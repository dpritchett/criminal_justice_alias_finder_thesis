<?php

/*
	This doSearch page has three functions:
	doSearch() hits our databases looking for partially matching suspect names
	printResults() generates an HTML table containing the results of doSearch()
	totalTime() calculates the execution time of this page for inclusion in printResults()
*/
	

//Calculate the total runtime of this page
function totalTime($start_time)
{
  echo ("<br>Total page execution time <font color=green size=+1>");
  $x = timeSince($start_time);
  print $x;
  echo ("</font> seconds.");
  
  print "<br><b><a href=\"./\">Back</a></b>";
  print "</b></center>";
  
  return $x;
}

//Print list of possible suspect matches to an HTML table
function printResults($output_type, $suspName, $suspSSN, $multiSearch, $possibles)
{
		global $count_exact, $count_partial;

		$count_exact = 0;
		$count_partial = 0;
		
		foreach($possibles as $row)
			if($row->exactMatch == 1)
				$count_exact++;
			else
				$count_partial++;
	
		print "<br><table border=1 cellpadding=2 cellspacing=3 width=100%>\n";
		if($output_type == "EXACT")
			print "<td colspan=100%><center><font size=+1 color=blue>$count_exact</font>";
		else
			print "<td colspan=100%><center><font size=+1 color=blue>$count_partial</font>";
		print " $output_type match(es) for ";
		if(strlen($suspName))
			print "'<font color=blue size=+1>$suspName</font>'\t";
		if(strlen($suspSSN))
			print "'<font color=blue size=+1>$suspSSN</font>'";
		print "<center></font></td></tr>";
		print "\t<tr><td colspan=100% bgcolor=EEAAAA><center>Matching elements listed in pink</center></td></tr>";
		
		if(!$multiSearch)
		{
  		print "\t<tr bgcolor=DDDDDD>\n\t";
  		print "<td>SSN<br>(master)</td><td>FNAME<br>(master)</td><td>LNAME<br>(master)</td>";
  		print "<td>DOB<br>(master)</td><td>DLNO<br>(master)</td>";
  		print "<td>HEIGHT<br>(master)</td><td>WEIGHT<br>(master)</td><td>RACE<br>(master)</td>";
  		print "<td>STREETNO<br>(master)</td><td>STREETNAME<br>(master)</td><td>CITY<br>(master)</td><td>ZIP<br>(master)</td>";
  		print "\n\t</tr>\n";
		}
		else
		{
  		print "\t<tr bgcolor=DDDDDD>\n\t";
  		print "<td>SSN<br>(master)</td><td>FNAME<br>(master)</td><td>LNAME<br>(master)</td>";
  		print "<td>DOB<br>(slaveone)</td><td>DLNO<br>(slaveone)</td>";
  		print "<td>HEIGHT<br>(slavetwo)</td><td>WEIGHT<br>(slavetwo)</td><td>RACE<br>(slavetwo)</td>";
  		print "<td>STREETNO<br>(slavethree)</td><td>STREETNAME<br>(slavethree)</td><td>CITY<br>(slavethree)</td><td>ZIP<br>(slavethree)</td>";
  		print "\n\t</tr>\n";
		}
		
	
		//traverse result arrays for printing
		foreach($possibles as $row)
		{			
			if($output_type == "EXACT")
			{
				if($row->exactMatch == 1)
			 		$row->printme();
			}
 			else
			{
				if($row->exactMatch != 1)
			 		$row->printme();
			}
		}
				
		print "</table>";
		
		print "<br><hr>";
		
		return $count_exact;
}

//Search across multiple databases to find possible suspect name matches.
//Uses Levenshtein distance, substring identification, and Soundex comparisons
//	in order to identify potential matches.  See paper for algorithm discussion.
function doSearch()  //performs a search and prints results
{

	//initialize timer
	global $start_time;
	$start_time = microtime(); 

	//include timeSince()
	include_once("timeSince.php");
	
	//include Suspect class
	include_once("class_suspect.php");
	
	//include loadSuspects()
	include_once("loadSuspects.php");
	
	//include flagPossibles()
	include_once("flagPossibles.php");
	
	//import DB connection info
	include("include/dbinfo.php");  

	//parse inputs
   $suspName = rtrim(strtoupper($_GET["suspName"]), "_");  //converts to all caps to match DB
	 $suspSSN = rtrim($_GET["suspSSN"], "_");
	
	 $doNameLev = $_GET["levName"];
	 $doSSNLev = $_GET["levSSN"];
	 $doSoundex = $_GET["soundex"];
	
	//set shorter flags based on inputs for easier typing below
	if($doNameLev == "true")
		$doNameLev = 1;
	else
		$doNameLev = 0;
	if($doSSNLev == "true")
		$doSSNLev = 1;
	else
		$doSSNLev = 0;
	if($doSoundex == "true")
		$doSoundex = 1;
	else
		$doSoundex = 0;
	
	if($_GET["subStr"] == "true")
		$doSubStr = 1;
	else
		$doSubStr = 0;
	
	//are we searching one DB or multiples?
	if($_GET["searchType"] == single)
		$multiSearch = 0;
	else
		$multiSearch = 1;
	
	//set primary DB name - this one contains name/ssn info
	if(!$multiSearch)
		$masterDB = "single";
	else
		$masterDB = "suspects";
	
//open master DB conn
	$master_link = mysql_connect("master",$user,$pass);
	mysql_select_db($masterDB,$master_link);
	
	
//perform queries
		//get ssn/fname/lname, store in array
						//in all cases these are the first 3 columns of the master DB
						
		//select all from $masterDB
		$query = "SELECT SSN,FNAME,LNAME FROM suspects WHERE 1=1 ORDER BY SSN ASC";  
			// fname LIKE '$suspName' OR lname LIKE '$suspName' OR SSN LIKE '$suspSSN'";
  	$result = mysql_query($query, $master_link);
  	  	  	
  	//empty query results into Suspect array
  	$possibles = array();
  	while($row = mysql_fetch_row($result))
  	{
    	$susp = new Suspect;
    	$susp->setName($row[0],$row[1],$row[2]);
    	array_push($possibles,$susp);
 		}
 		
		//levenshtein threshholds
		$name_thresh = strlen($suspName)/2;
		$num_thresh = 2;
				
		$possibles = flagPossibles($possibles, $suspSSN, $suspName, $doNameLev, $doSSNLev, $doSoundex, $multiSearch, $doSubStr, $name_thresh, $num_thresh);
		
		$result = mysql_query("SELECT COUNT(*) FROM SUSPECTS", $master_link);
		$num_records = mysql_fetch_row($result);
		
		//set timer after possibles identified
		global $extend_start;
		$extend_start = microtime();

		$count_possibles = count($possibles);
		
		//print count of possible hits
		print "<center>";
		print "<font color=orange size=+1>";
		print $count_possibles;
		print "</font>";
		print " potential match(es) identified out of <font color=orange size=+1>$num_records[0]</font> rows";
		print " on SSN/Name database <font color=red size=+1>master</font> in ";
		print "<font color=green size=+1>";
		$time_possibles = timeSince($start_time);
		print $time_possibles;
		
		print "</font>";
		print " seconds.<br>";

		print "<br>Now loading extended information from database(s) <font color=red size=+1>";
					  	
					//  	return;
  	//sort ssn/name array?  not needed if query results are ORDER BY ssn ASC
				
		//get extended info on hits from other databases
		if(!$multiSearch)  // multiSearch is false
		{
			print "$masterDB</font>.\n<hr>";
			//single: get the remaining columns from the master DB
			//clear POSSIBLES table
			//load list of $possible SSNs into table
			$commit = array();
			foreach($possibles as $key => $currSusp)
			{
				array_push($commit, $currSusp->ssn);
				if(($key % 50) == 0 && $key > 0)  //row index a nonzero multiple of 50
				{
  				//commit to possibles table
  				loadSuspects($master_link, $commit);
  				$commit = array();
				}
			}
			
			//commit last <50 rows
  		loadSuspects($master_link, $commit);
  		
			//do a join, return matches?
			$result = mysql_query("SELECT S.* FROM SUSPECTS AS S,	POSSIBLES AS P WHERE P.SSN = S.SSN ORDER BY S.SSN ASC", $master_link);
			
			$x = 0;
    	while($row = mysql_fetch_row($result))
			{
				if($possibles[$x]->ssn == $row[0])
				{
					$possibles[$x]->setName($row[0],$row[1],$row[2]);
					$possibles[$x]->set_dob_dlno($row[3],$row[11]);
					$possibles[$x]->set_vitals($row[4],$row[5],$row[6]);
					$possibles[$x]->set_address($row[7],$row[8],$row[9],$row[10]);
				}
				$x++;
			}
			
			//clear possibles table
			clearSuspects($master_link);
			
		}
		else  // multiSearch is true
		{
			print " slaveone, slavetwo, and slavethree</font>.\n<hr>";
			//multi: 
			//open slave DB conns
			$slave1_link = mysql_connect("slaveone",$user,$pass);
			$slave2_link = mysql_connect("slavetwo",$user,$pass);
			$slave3_link = mysql_connect("slavethree",$user,$pass);
					
			mysql_select_db($db,$slave1_link);
			mysql_select_db($db,$slave2_link);
			mysql_select_db($db,$slave3_link);
			
			//load list of $possible SSNs into tables
			$commit = array();
			foreach($possibles as $key => $currSusp)
			{
				array_push($commit, $currSusp->ssn);
				if(($key % 50) == 0 && $key > 0)  //row index a nonzero multiple of 50
				{
  				//commit to possibles table
  				loadSuspects($slave1_link, $commit);
  				loadSuspects($slave2_link, $commit);
  				loadSuspects($slave3_link, $commit);
  				$commit = array();
				}
			}
			//commit last <50 rows
  		loadSuspects($slave1_link, $commit);
  		loadSuspects($slave2_link, $commit);
  		loadSuspects($slave3_link, $commit);
  		
  		$start_extend = microtime();
  		
			//do a join, return matches?
			$result1 = mysql_query("SELECT S.* FROM SUSPECTS AS S, POSSIBLES AS P WHERE P.SSN = S.SSN ORDER BY S.SSN ASC", $slave1_link);
			$result2 = mysql_query("SELECT S.* FROM SUSPECTS AS S, POSSIBLES AS P WHERE P.SSN = S.SSN ORDER BY S.SSN ASC", $slave2_link);
			$result3 = mysql_query("SELECT S.* FROM SUSPECTS AS S, POSSIBLES AS P WHERE P.SSN = S.SSN ORDER BY S.SSN ASC", $slave3_link);
	
			//load slave1 results into $possibles
			$x = 0;
    	while($row1 = mysql_fetch_row($result1))
			{
				if($possibles[$x]->ssn == $row1[0])
					$possibles[$x]->set_dob_dlno($row1[1],$row1[2]);
				$x++;
			}
			
			//load slave2 results into $possibles
			$x = 0;
    	while($row2 = mysql_fetch_row($result2))
			{
				if($possibles[$x]->ssn == $row2[0])
					$possibles[$x]->set_address($row2[1],$row2[2],$row2[3],$row2[4]);	 
				$x++;
			}
			
			//load slave3 results into $possibles
			$x = 0;
    	while($row3 = mysql_fetch_row($result3))
			{
				if($possibles[$x]->ssn == $row3[0])
					$possibles[$x]->set_vitals($row3[1],$row3[2],$row3[3]);
				$x++;
			}
			
			//clear possibles tables
			clearSuspects($slave1_link);
			clearSuspects($slave2_link);
			clearSuspects($slave3_link);		
		}
					
		//close DB conns
		mysql_close($master_link);
		if($multiSearch)
		{
  		mysql_close($slave1_link);
  		mysql_close($slave2_link);
  		mysql_close($slave3_link);
		}
		
	//	$end_extend = timeSince($start_extend);
		
		//print exact matches
		$count_exact = printResults("EXACT", $suspName, $suspSSN, $multiSearch, $possibles);
		
		//print extended results
		printResults("PARTIAL", $suspName, $suspSSN, $multiSearch, $possibles);

    echo ("Extended information retrieved in <font color=green size=+1>");
    print timeSince($extend_start);
    echo ("</font> seconds.");
    
    $total_time = totalTime($start_time);
    
    
    
   // print "<hr><center>";
		//print "EXACT_MATCHES: $count_exact<br>";
		//print "PARTIAL_MATCHES: ";
		$count_partial = $count_possibles - $count_exact;
	//	print "$count_partial<br>";
	//	print "POSSIBLESTIME: $time_possibles<br>";
	//	print "TOTALTIME: $total_time<br></center>";
	
	
		//build log string of
		//SUSP_NAME,SUSP_SSN,MULTI_SEARCH,LEV_NAME,SOUNDEX,LEVSSN,
		//DO_SUBSTR,EXACT_MATCHES,PARTIAL_MATCHES,POSSIBLES_TIME,TOTAL_TIME

		$logstring = "";
		$logstring .= "$suspName,";
		$logstring .= "$suspSSN,";
		$logstring .= "$multiSearch,";
		$logstring .= "$doNameLev,";
		$logstring .= "$doSoundex,";
		$logstring .= "$doSSNLev,";
		$logstring .= "$doSubStr,";
		$logstring .= "$count_exact,";
		$logstring .= "$count_partial,";
		$logstring .= "$time_possibles,";
			$time_extend = $total_time - $time_possibles;
		$logstring .="$time_extend,";
		$logstring .= "$total_time\r\n";
	
	
		$handle = fopen("logfile.csv", "a+");
		fwrite($handle, $logstring);
	//	print "<hr>$handle";
	//	print "<hr>$logstring";
		fclose($handle);
		
	  /*
		//log results
		$master_link = mysql_connect("master",$user,$pass);
		mysql_select_db("suspects",$master_link);
		$query = "INSERT INTO RESULTS VALUES (" . $logstring . ")";
  	$result = mysql_query($query, $master_link);
		mysql_close($master_link);
		//print "<hr>$query<hr>";
		//var_dump($result);
		//exit function
		*/
		return $logstring;
}
?>

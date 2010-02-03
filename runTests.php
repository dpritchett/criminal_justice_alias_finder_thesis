<?php
	
	function openTest($filename)
	{
  	$handle = file_get_contents($filename);
  	$handle = "<h3>$filename</h3>" . $handle;
  	
  
  //	fclose($handle);
//  	sleep (.5);
  //  return $handle;
	}
	
	function callTest($testString, $name, $ssn)
	{
		 if($name)
		 {
  		 	openTest($testString . "&levName=true");
  		 	openTest($testString . "&soundex=true");
  		 	
		 }
		 
		 if($ssn)
		 {
  		  openTest($testString . "&levSSN=true");
		 }
		 
		 if($name || $ssn)
		 {
  		 	openTest($testString . "&subStr=true");
		 }
		 
		 return "Done.";
	}

	$suspName = $_GET["suspName"];
	$suspSSN = $_GET["suspSSN"];
	
	
	$baseString = "http://localhost/?suspName=$suspName&suspSSN=$suspSSN";
	
	$single = $baseString . "&searchType=single";
	$multi = $baseString . "&searchType=multiple";
	print "Running single-server tests on '$suspName' & '$suspSSN'...";
	print callTest($single, $suspName, $suspSSN);
	print "<br>";
	print "Running multi-server tests on '$suspName' & '$suspSSN'...";
	print callTest($multi, $suspName, $suspSSN);
	
	print "<hr><center><a href=/enterTest.php>BACK</a>";
	
?>

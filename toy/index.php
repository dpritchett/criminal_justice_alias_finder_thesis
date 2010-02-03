<?php
// Get a file into an array.  In this example we'll go through HTTP to get
// the HTML source of a URL.

print "<body>\n";
print "<font color=blue size=+2>Hib Loop Bot by Arywenium</font><br>\n";
print "<font color=blue> Data from <a href=http://www.happysquirrels.org/bot.txt>http://www.happysquirrels.org/bot.txt</a><br>\n";
print "php code by StrokerAce.  AIM:danielpritchett for suggestions.</font><p>\n";

$lines = file('http://www.happysquirrels.org/bot.txt');

$grouped = array();
$solo = array();
$offline = array();
$other = array();


//parse input file
foreach ($lines as $line_num => $line) {
   //echo "Line #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br />\n";
   if(strpos($line, "Opened"))
   {
 		  print "<h3>$line</h3>\n";
   }
	 else if(strpos($line, "member"))
   {
  		//print "$line<br>\n";
			//print "<font color=orange><b>Grouped:</b> ";
   	  $grouped[] =substr($line, 11, strpos($line, " is ") - 11); 
	 		//print "</font><br>\n";
   }
   else if(strpos($line, "invited"))
   {
   		//print "$line<br>\n";
   		//print "<font color=white><b>Solo:</b> ";
   		$solo[] = substr($line, 28, strpos($line, " to ") - 28);
	 		//print "</font><br>\n";
	 }
	 else if(strpos($line, "don't"))
	 {
	 //
	 //		print "<font color=black><b>Offline:</b> ";
	 //		print substr($line, strpos($line, " see ") + 5, strpos($line, " around ") - strpos($line, " see ") - 5);
	 //		print "<br>\n";
	 $offline[] = substr($line, strpos($line, " see ") + 5, strpos($line, " around ") - strpos($line, " see ") - 5);
	 }
	 else
	 {
		if(strpos($line, "]"))
		{
	  	$other[] = $line;
	  }
	 }
}

function printTable($name, $color, $theArray, $cols)
{
  print "\n<table border=1 cols=$cols cellpadding=3 bgcolor=black><tr><td colspan=$cols align=center><font color=$color><b>$name:</b></td></tr>\n";
  print "<tr>";
  foreach ($theArray as $line_num => $theArray)
  	{
    	print "<td><font color=$color>$theArray</font></td>";
    	
			if(!(($line_num +1) % $cols))
    	{
    		print "</tr>\n<tr><!-- $line_num -->";
    	}
    	
  	}
  if(!count($theArray))
  {
  	print "<td><font color=$color>No results.</font></td>";
  }
  print "</tr></table><br>\n";
}


sort($solo);
sort($grouped);
sort($other);
sort($offline);

printTable("Grouped", "orange", $grouped, 5);
printTable("Solo", "white", $solo, 5);
printTable("Offline", "grey", $offline, 5);

printTable("Other", "red", $other, 0);
?> 

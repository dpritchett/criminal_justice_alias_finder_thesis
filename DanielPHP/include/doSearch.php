<?php
function doSearch($server)  //performs a search on the given $server and prints results
{
	//scrape suspect name from input form
  $suspName = $_GET["suspName"];

	//import DB username and password
  include("include/dbinfo.php");  

	//open mysql connection to $server
  $mysql_link = mysql_connect($server, $admin, $adpass);
  mysql_select_db($db, $mysql_link);
  
  //query $server for suspects with names 'LIKE' $suspName.
  //this returns all names spelled the same regardless of case.
  $query = "SELECT * FROM suspects WHERE fname LIKE '$suspName' OR lname LIKE '$suspName'";
  $result = mysql_query($query, $mysql_link);
  
  //print an unordered list of hits
  print "<h3>Results from $server:</h3>\n";
  print "<ul>\n";
  if(mysql_num_rows($result)) {
      // we have at least one suspect, so show all names
    	while($row = mysql_fetch_row($result))
      {
        print "<li>$row[0] $row[1]</li>\n";
      }
    }
	else {
				//no hits
	      print "<option value=\"\">No results found</option>";
    }     
  print "</ul>\n";
  
  return;
}  
?>

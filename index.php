<?php
/*
	index.php
	Daniel Pritchett 8/2004
	
	Gets single-name input from user and returns a list of hits from multiple databases.
	Can display source on user request.
*/

	//if we have input already, do searches
if($_GET["suspName"]|| $_GET["suspSSN"])  
{
	include("include/doSearch.php");
	doSearch();
}
	//do we want to show source code?
else if($_GET["source"])  
{
	show_source("index.php");
}
	//get user input
else							
{
	include("include/getInput.php");
 	getInput();	
}
?>

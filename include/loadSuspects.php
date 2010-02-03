<?php

//empties table
function clearSuspects($database_link)
{
	mysql_select_db("possibles",$database_link);
	$result = mysql_query("DELETE FROM POSSIBLES WHERE 1=1", $database_link);
	return $result;
}

//loads $suspects_list (SSNs) into POSSIBLES table
function loadSuspects($database_link, $suspects_list)
{
	mysql_select_db("possibles",$database_link);
//	print	mysql_info();
//	print "<hr>";

	$commit_string = "INSERT INTO POSSIBLES VALUES \n";
	
	foreach($suspects_list as $key => $row)
	{
		$commit_string .= "($row)";
		if($key != sizeof($suspects_list) -1)
			$commit_string .= ",\n";
	}
//	print "Commit:<br>\n $commit_string\n<hr>\n";
	
	$result = mysql_query($commit_string, $database_link);
//	print_r($result);
//	print mysql_insert_id();
	return $result;
	
}

?>

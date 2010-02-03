<?php
	function timeSince($starttime)
	{
    $endtime            = microtime(); 
    $parts_of_starttime = explode(' ', $starttime); 
    $starttime          = $parts_of_starttime[0] + $parts_of_starttime[1]; 
    $parts_of_endtime   = explode(' ', $endtime); 
    $endtime            = $parts_of_endtime[0] + $parts_of_endtime[1]; 
    $time_taken         = $endtime - $starttime;
    $time_taken         = number_format($time_taken, 6);  // optional
    
    return $time_taken;
	}	
?>

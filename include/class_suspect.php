<?php
class Suspect {
	var $ssn;
	var $fname;
	var $lname;
	
	var $dob;
	var $dlno;
	
	var $height;
	var $weight;
	var $race;
	
	var $streetno;
	var $streetname;
	var $city;
	var $zip;
	
	var $fnameMatch;
	var $lnameMatch;
	var $ssnMatch;
	
	var $exactMatch;
	
	function Suspect()
	{
		$fnameMatch = 0;
		$lnameMatch = 0;
		$ssnMatch = 0;
		$exactMatch = 0;
	}
	
	function setName($ssn, $fname, $lname)
	{
		$this->ssn = $ssn;
		$this->fname = $fname;
		$this->lname = $lname;
		return;
	}
	
	function set_dob_dlno($dob, $dlno)
	{
		$this->dob = $dob;
		$this->dlno = $dlno;
		return;
	}
	
	function set_vitals($height, $weight, $race)
	{
		$this->height = $height;
		$this->weight = $weight;
		$this->race = $race;
		return;
	}
	
	function set_address($streetno, $streetname, $city, $zip)
	{
		$this->streetno = $streetno;
		$this->streetname = $streetname;
		$this->city = $city;
		$this->zip = $zip;
		return;
	}
	
	function printme()
	{
		print "\t<tr>\n\t";
		print "<td";
		if($this->ssnMatch)
			print " bgcolor=EEAAAA>";
		else
			print ">";
		print "$this->ssn</td>";
		
		print "<td";
		if($this->fnameMatch)
			print " bgcolor=EEAAAA>";
		else
			print ">";
		print "$this->fname</td>";
		
		print "<td";
		if($this->lnameMatch)
			print " bgcolor=EEAAAA>";
		else
			print ">";
		print "$this->lname</td>";
		
		print "<td>$this->dob</td>";
		print "<td>$this->dlno</td>";
		print "<td>$this->height</td>";
		print "<td>$this->weight</td>";
		print "<td>$this->race</td>";
		print "<td>$this->streetno</td>";
		print "<td>$this->streetname</td>";
		print "<td>$this->city</td>";
		print "<td>$this->zip</td>";
		
		print "\t</tr>\n";
		return;
	}
	
}

?>

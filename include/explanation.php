<center>	
	<table border=1>
	<tr>
		<td align=center colspan=100%><font size=+1>Explanation of similarity measures</font></td>
	</tr>
	
	<tr>
		<td><b>Edit Distance</b></td>
		<td>
  		<b>Uses the Levenshtein Edit Distance metric to determine if the input string
  		matches a database value.
			<br>Returns a match on SSN if the edit distance is <= 2.
			<br>Returns a match on NAME if the edit distance is <= (length of name / 2).
			</b>
  		
  		<p>"The smallest number of insertions, deletions, and substitutions required to 
  		change one string or tree into another. (2) A ?(m × n) algorithm to compute the 
  		distance between strings, where m and n are the lengths of the strings."
  		<a href=http://www.nist.gov/dads/HTML/Levenshtein.html>Link</a>
  		</p>
		</td>
	</tr>
	<tr>
		<td><b>Soundex</b></td>
		<td>
			<b>Compares the Soundex key of the input NAME to FNAME and LNAME values in
			the database.
			<br>Only returns exact matches.
			</b>
			
  		<p>"Soundex keys have the property that words pronounced similarly produce the same
  		soundex key, and can thus be used to simplify searches in databases where you know 
  		the pronunciation but not the spelling. This soundex function returns a string 4 
  		characters long, starting with a letter.  This particular soundex function is one 
  		described by Donald Knuth in 'The Art Of Computer Programming, vol. 3: Sorting And 
  		Searching', Addison-Wesley (1973), pp. 391-392."
  		<a href=http://us3.php.net/manual/en/function.soundex.php>Link</a></td>
  		</p>
	</tr>
	<tr>
		<td><b>Substring match</b></td>
		<td>
			<b>
			Checks to see if the NAME or SSN inputs exist as substrings of values in 
			the database.
			<br>Returns matches on one or more occurence of a name or ssn string that contains the input values.
			<br>Because this test takes considerably longer than the others, it is
			disabled by default.
			</b>
			
			<p>Uses the following function: 
			"substr_count() returns the number of times the needle substring occurs in 
			the haystack string. Please note that needle is case sensitive." 
			<a href=http://us3.php.net/manual/en/function.substr-count.php>Link</a>
			</p>
		</td>
	</tr>
	</table>
	  
	<br><b><a href=/>Back</a></b>
</center>


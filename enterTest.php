	  <form name="input" action="/runTests.php" method="get">
    <table border=1 cols=3>
    <tr><td colspan=2><center><font size=+2>Run test suite on input</font></center></td></tr>
    <tr>
  		<td colspan=2 align=center>
  			<b>Input search criteria:</b><br>
  		</td>
		</tr>
		<tr>
			<td>Suspect name (<i>first or last</i>)</td>
			<td><input type="text" name="suspName" length=255 size=50></td>
    </tr>
    <tr>
    	<td>Suspect SSN</td>
    	<td><input type="text" name="suspSSN" length=255 size=50></td>
		</tr>
		<tr>
		 <td colspan=2 align=center><input type="submit" value="Submit"></td>
		</tr>
    </table>
    </form>


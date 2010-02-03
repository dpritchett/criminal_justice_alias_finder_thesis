<?php

	function getInput()  //spits out an plain HTML input to capture suspect name
{		
		?>
		<html>
    <body>
    <center>
    
    <form name="input" action="./" method="get">
    <table border=1 cols=3>
    <tr><td colspan=2><center><font size=+2>Federated Database Suspect Search</font></center></td></tr>
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
  		<td colspan=2 align=center>
  			<b>Select desired database model:</b><br>
  		</td>
		</tr>
		<tr>
			<td colspan=2>
				<INPUT TYPE="RADIO" NAME="searchType" value="single" CHECKED>Single server model<br>
				<INPUT TYPE="RADIO" NAME="searchType" value="multiple">Multiple server model
			</td>
		</tr>
		<tr><td colspan=2></td></tr>
		<tr>
  		<td colspan=2 align=center>
  			<b>Check desired similarity measures:</b><br>
  		</td>
		</tr>
		<tr>
  		<td>
  			<table border=0>
          		<tr>
        				<td><input type="checkbox" name="levName" value="true" checked> <b>Name</b>: Edit distance (<i>within length(suspect name) / 2</i>)</td>
        			</tr>
          		<tr>
        				<td><input type="checkbox" name="soundex" value="true" checked> <b>Name</b>: Soundex exact match</td>				
        			</tr>
        			<tr>
        				<td><input type="checkbox" name="levSSN" value="true" checked> <b>SSN</b>: Edit distance (<i>within 2</i>)</td>
        			</tr>	
        			<tr>
        				<td><input type="checkbox" name="subStr" value="true"> <b>Name or SSN</b>: Substring match (<i>warning: slow</i>)</td>
        			</tr>
    		</table>
    	</td>
			<td>
    		<table border=0>
    			<tr>
					<td align=center valign=center><a href=/include/explanation.php>Explanation of similarity measures</a></td>
					</tr>
    		</table>
  		</td>
		</tr>
		<tr>
		 <td colspan=2 align=center><input type="submit" value="Submit"></td>
		</tr>
    </table>
    </form>
    <font size=-1>Try Name: <b><i>Daniel</i></b> or SSN: <b><i>123456789</i></b> to see an example
    <!--<br><a href=./?source=1>Show source</a></font>-->
    </center>
    
    <script>
    document.input.suspName.focus();
    </script>
    </body>
    </html>
		<?php
}
?>

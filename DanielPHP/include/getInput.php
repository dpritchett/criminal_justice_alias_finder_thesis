<?php

	function getInput()  //spits out an plain HTML input to capture suspect name
{		
		?>
		<html>
    <body>
    <h3>Multi-database suspect search</h3>
    
    <form name="input" action="./" method="get">
    Suspect name: 
    <input type="text" name="suspName">
    <input type="submit" value="Submit">
    </form>
    
    <font size=-1>(Try <b><i>captain</i></b> or <b><i>robot</i></b> to see an example)
    <br><a href=./?source=1>Show source</a></font>
    
    <script>
    document.input.suspName.focus();
    </script>
    </body>
    </html>
		<?php
}
?>

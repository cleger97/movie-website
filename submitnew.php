<!--
	File: submitnew.php
	Dev: Alex Leger
	Date Started: 2017/1/23
	Description: Checks submissions (for the addnew.php) and adds to the database if functional, or returns to add new with data otherwise.
-->

<?php
	// This page should always come with $_POST data
	// If it doesn't then we send the user back to the showall site
	
	if (!empty($_POST)) {
		header("Location: addnew.php?ret='empty'");
	}
	
	
	

	$submit;
?>

<html>
<head>
<?php
	if ($submit) {
		echo "\t<title> Added new movie succesfully! </title>\n";
	} else {
		echo "\t<title> Error in Submission </title>\n";
	}
?>
</head>
<body>



</body>
</html>


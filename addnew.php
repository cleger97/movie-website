<!--
	File: addnew.php
	Dev: Alex Leger
	Date Started: 2017/1/23
	Description: Interface for adding new movies to the database.
-->

<?php
	include("./data/dbinc.incf");
	session_start();
	$rating_list = array("G","PG","PG-13","R","NC-17","Unrated");
?>
<!DOCTYPE html>
<html>
<head>
	<title> Add New Movie </title>
</head>
	
<body>

	<!-- Links here -->
	<div id = "linkbox">
	<!-- Add the link boxes here -->
	</div>

<?php
	// This is where we handle the error values 
	// For now, we're just going to print them
	
	if (!empty($_GET['ret'])) {
		$error = $_GET['ret'];
		if ($error == 'empty') {
			echo "\t<p id = 'error'> Error: Did not send any data. </p>\n";
		}
	}
	

?>	


	<h2> Add New Movie </h2>
<?php
	// INSERT INTO movietable (COLUMN LIST) VALUES (VALUES)
	
	$query = "SELECT * FROM movielist LIMIT 1";
	$result = mysqli_query($cxn, $query);
	
	
	echo "<form action = 'submitnew.php' method = 'POST'>\n";
	while ($col = mysqli_fetch_field($result)) {
		$name = $col->name;
		if ($name == 'id' or $name == 'imdb') continue;
		// Print out the label for each one
		echo "\t<label for = $name> {$lov[$name]}: </label>\n";
		
		// Rating is a special exception, needs to use the rating list
		if ($name == 'rating') {
			echo "\t<select name = '$name'>\n";
			foreach ($rating_list as $rating) {
				echo "\t\t<option value = '$rating'> $rating </option>\n";
			}
			echo "\t</select>\n";
		} else { // Otherwise make a text field
			echo "\t<input type = 'text' name = $name id = $name required \>";
		}
		echo "\t<br \>\n";
	}
	echo "\t<input type = 'submit' value = 'Submit' \>\n";
	echo "</form>\n";
?>

</body>
</html>
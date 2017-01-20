<!--
	File: showall.php
	Dev: Alex Leger
	Date Stated: 2017/1/19
	Description: The site that displays all the movies.
-->
<?php
	include("./data/dbinc.incf");
	$sort_options = array( "title" => "Title", "year" => "Year", "genre" => "Genre", "rating" => "Rating", "actorList" => "Actor List");
?>
<html>

<head>
<title> Movie List </title>
</head>

<body>
	
	<!-- The form for searching for a certain object -->
	<form action = 'search.php' method = 'POST'>
		<label class = "textbox" for = "search"> Search: </label>
		<input type = "text" id = "search" name = "search" size = "30" maxlength = "30" />
		
		<select name = "ATTRIBUTE">
			<option value = "title"> Title </option>
			<option value = "year"> Year </option>
			<option value = "genre"> Genre </option>
			<option value = "rating"> Rating </option>
		</select>
		<input type = "submit" value = "Search" />
	</form>
	<br />
	
	<!-- The form for sorting the objects -->
	<form action = 'showall.php' method = 'POST'>
		<input type = "submit" value = "Sort" />
		<select name = "ATTRIBUTE">
			<option value = "title"> Title </option>
			<option value = "year"> Year </option>
			<option value = "genre"> Genre </option>
			<option value = "rating"> Rating </option>
		</select>
		<select name = "TYPE"> 
			<option value = "ASCENDING"> Ascending </option>
			<option value = "DESCENDING"> Descending </option>
		</select>
		
	</form>

	<h1> All Movies </h1>
	
<?php
	/* This block of PHP is built to get the movies and place them accordingly into a table. */
	
	/* Query the database for the movie list, sorted if necessary */
	$query = "SELECT * FROM movielist";
	if (@sizeof($_POST) != 0) {
		$query .= " ORDER BY ";
		$query .= $_POST['ATTRIBUTE'];
		if ($_POST['TYPE'] == 'DESCENDING') {
			if (!($_POST['ATTRIBUTE'] == "rating")) {
				$query .= " DESC";
			}
		}  else {
			if ($_POST['ATTRIBUTE'] == "rating") {
				$query .= " DESC"; 
			}
		}
		
	}
	$result = mysqli_query($cxn, $query) or die ("Query failed!");
	
	/* If there's no movies, then just print that and exit. */
?>

	<table>
		<caption><b> List of All Movies </b></caption>
		<tr>
			<th scope = "col"> Title </th>
			<th scope = "col"> Year </th>
			<th scope = "col"> Genre </th>
			<th scope = "col"> Rating </th>
		</tr>
	
<?php
	/* This builds the table with the movies. */
	if (!$result) {
		echo "</table><p> No movies have been added yet! </p>";
		die();
	} else {
		/* Now we have to print out the movies. */
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr>\n";
			foreach ($row as $key => $value) {
				if ($key == 'id') continue;
				echo "<td>{$value}</td>\n";
			}
			echo "</tr>\n";
		
		}
		echo "</table>";
	}
?>

</body>

</html>
<!--
	File: showall.php
	Dev: Alex Leger
	Date Stated: 2017/1/19
	Description: The site that displays all the movies.
-->
<?php
	include("./data/dbinc.incf");
	$sort_options = array( "title" => "Title", "year" => "Year", "genre" => "Genre", "rating" => "Rating", "actorList" => "Actor List", "stars" => "Stars", "id" => "ID");
?>
<!DOCTYPE html>
<html>

<head>
	<title> Movie List </title>
	<script type="text/javascript" src = "clicksort.js"> </script>
    <link rel="stylesheet" type="text/css" href="stylesheets/genstyle.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/dispstyle.css">
</head>

<body>
	<div id = "wrapper">
	<div id = "header">
        <div id = "headingtitle">
            <h1> Movie Website </h1>
        </div>
        
        
        <div id = "searchbox">
            <!-- The form for searching for a certain object -->
            <form action = 'search.php' method = 'POST'>
                <label class = "textbox" for = "SEARCH"> Search: </label>
                <input type = "text" id = "SEARCH" name = "SEARCH" size = "30" maxlength = "30" />
                <select name = "ATTRIBUTE">
                    <option value = "title"> Title </option><
                    option value = "year"> Year </option>
                    <option value = "genre"> Genre </option>
                    <option value = "rating"> Rating </option>
                    <option value = "stars"> Stars </option>
                </select>
                <input type = "submit" value = "Search" />
            </form>
	
        </div>
        <!-- Links here -->
        <div id = "linkbox">
        <table>
            <tr> <td> <a href="showall.php"> Show All Movies </a> </td> </tr>
            <tr> <td> <a href="addnew.php"> Add A Movie </a> </td> </tr>
            <tr> <td> <a href="modifymovie.php"> Change A Movie </a> </td> </tr>
        </table>
        </div>
    </div>
	
    
    
    <div id = "pageheading" >
    
	</div>
	
<?php
	/* This block of PHP is built to get the movies and place them accordingly into a table. */
	
	/* Query the database for the movie list, sorted if necessary */
	$query = "SELECT * FROM movielist";
	
	$result = mysqli_query($cxn, $query) or die ("Query failed!");
	
	/* If there's no movies, then just print that and exit. */


	echo "\t<table class = 'main'>\n";
	echo "\t\t<caption><b> List of All Movies </b></caption>\n";
	
	echo "\t\t<thead>\n";
	echo "\t\t\t<tr>\n";
		while ($currentField = mysqli_fetch_field($result)) {
			if ($currentField->name == 'id') continue; 
			echo "\t\t\t\t<th class = '{$currentField->name}'>{$lov[$currentField->name]}</th>\n";
		}		
		echo "\t\t\t</tr>\n";
		echo "\t\t</thead>\n";
		
	/* This builds the table with the movies. */
	if (!$result) {
		echo "\t</table><p> No movies have been added yet! </p>";
		die();
	} else {
		/* Now we have to print out the movies. */
		echo "\t\t<tbody>\n";
		while ($row = mysqli_fetch_assoc($result)) {
			echo "\t\t\t<tr>\n";
			foreach ($row as $key => $value) {
				if ($key == 'id') continue;
				echo "\t\t\t\t<td class = \"{$key}\">{$value}</td>\n";
			}
			echo "\t\t\t</tr>\n";
		
		}
		echo "\t\t<tbody>\n";
		echo "\t</table>";
	}
?>

    </div> <!-- close the wrapper -->
</body>

</html>
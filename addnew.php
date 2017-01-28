<!--
	File: addnew.php
	Dev: Alex Leger
	Date Started: 2017/1/23
	Description: Interface for adding new movies to the database.
-->

<?php
	include("./data/dbinc.incf");
	$rating_list = array("G","PG","PG-13","R","NC-17","Unrated");
?>
<!DOCTYPE html>
<html>
<head>
	<title> Add New Movie </title>
    <link rel="stylesheet" type="text/css" href="stylesheets/genstyle.css">    
 
    <link rel="stylesheet" type="text/css" href="stylesheets/anstyle.css"> 
    
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
	
    <div id = "pageheading">
        <div id = "pagetitle">
            <h2 style= "float: left"> Add New Movie </h2>
        </div>
    </div>
	
<?php
	// This is where we handle the error values 
	// For now, we're just going to print them
	
	if (!empty($_GET['ret'])) {
		$error = $_GET['ret'];
		if ($error == '\'empty\'') {
			echo "\t<h3 id = 'error'> Error: Did not send any data. </h3>\n";
		}
	}
	

?>	
	
<?php
	// INSERT INTO movietable (COLUMN LIST) VALUES (VALUES)
	
	$query = "SELECT * FROM movielist LIMIT 1";
	$result = mysqli_query($cxn, $query);
	
	
	echo "\t<form action = 'submitnew.php' method = 'POST'>\n";
    echo "\t<table class = 'main'>\n";
	while ($col = mysqli_fetch_field($result)) {
		$name = $col->name;
		if ($name == 'id' or $name == 'imdb') continue;
        echo "\t\t<tr>\n";
		// Print out the label for each one
		echo "\t\t\t<td><label for = $name> {$lov[$name]}: </label></td>\n";
		
		// Rating is a special exception, needs to use the rating list
		if ($name == 'rating') {
			echo "\t\t\t<td><select name = '$name'>\n";
			foreach ($rating_list as $rating) {
				echo "\t\t\t\t<option value = '$rating'> $rating </option>\n";
			}
			echo "\t\t\t</select></td>";
		} else { // Otherwise make a text field
			echo "\t\t\t<td><input type = 'text' name = '$name' id = '$name' class = 'forminput' required /></td>";
		}
        echo "</tr>\n";
	}
    
	echo "\t\t<tr><td><input type = 'submit' value = 'Submit' /></td></tr>\n";
    echo "\t</table>\n";
	echo "\t</form>\n";
?>
    </div> <!-- close the wrapper -->
</body>
</html>
<!--
    File: modifymovie.php
    Dev: Alex Leger
    Date Started: 2017/1/26
    Description: The interface to modify the movies.
-->

<?php
    include("./data/dbinc.incf");

    $rating_list = array("G","PG","PG-13","R","NC-17","Unrated");
    // POST will *only* be empty here if there is no movie selected.
    // Set the variable to determine how we're going to render the site here.
    $select = true;
    $result = null;
    if (!empty($_POST)) {
        $select = false;
        $query = "SELECT * FROM movielist WHERE movielist.id = {$_POST['id']}";
        $result = mysqli_query($cxn, $query) or die ("Error in query");
    } else if (!empty($_GET['id'])) {
        $select = false;
        $id = mysqli_real_escape_string($cxn, $_GET['id']);
        $query = "SELECT * FROM movielist WHERE movielist.id = {$id}";
        $result = mysqli_query($cxn, $query) or die ("Error in query");
    } else {
        $select = true;
        $query = "SELECT * FROM movielist";
        $result = mysqli_query($cxn, $query) or die ("Error in query");
    }
    
?>

<html>
<head>
    <title> Modify Movie </title>
    <link rel="stylesheet" type="text/css" href="stylesheets/anstyle.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/genstyle.css">
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
    
<?php 
    
    if ($select) {
        // Part 1: Selecting the movie
        // Get a list of all movies currently in the database
        echo "\t<form action = 'modifymovie.php' method = 'POST'>\n";
        echo "\t\t<select name = \"id\">\n";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "\t\t\t<option value = '{$row['id']}'>{$row['title']} ({$row['year']})</option>\n";
        }
        echo "\t\t</select>\n";
        echo "\t\t<input type = 'submit' value = 'Submit' \>\n";
    } else {
        // Part 2: Load the modifications
        // Load the new site 
        
        // UPDATE `movielist` SET `rating` = 'R' WHERE `movielist`.`id` = 1;
        echo "\t<form action = 'submitmod.php' method = 'POST'>\n";
        echo "\t<table>\n";
        
        $row = mysqli_fetch_assoc($result);
        while ($col = mysqli_fetch_field($result)) {
            $name = $col->name;
            $data = $row[$name];
            if ($name == 'id' or $name == 'imdb') continue;
            echo "\t\t<tr>\n";
            // Print out the label for each one
            echo "\t\t\t<td><label for = $name> {$lov[$name]}: </label></td>\n";
		
            // Rating is a special exception, needs to use the rating list
            if ($name == 'rating') {
                echo "\t\t\t<td><select name = '$name'>\n";
                
                foreach ($rating_list as $rating) {
                    if ($rating == $data) {
                        echo "\t\t\t\t<option value = '$rating' selected = \"selected\"> $rating </option>\n";
                    } else {
                        echo "\t\t\t\t<option value = '$rating'> $rating </option>\n";
                    }
                    
                }
                echo "\t\t\t</select></td>";
            } else { // Otherwise make a text field
                echo "\t\t\t<td><input type = 'text' name = $name id = $name value = '$data' class = 'forminput' required /></td>";
            }
            echo "\t\t</tr>\n";
        }
        // Store the id of the movie - so we can compare the new data to the old (and update as necessary)
        echo "\t\t<tr><td><input type = 'hidden' value = '{$_POST['id']}' id = 'id' name = 'id'/></td></tr>\n";
        echo "\t\t<tr><td><input type = 'submit' value = 'Submit' /></td></tr>\n";
        echo "\t</table>\n";
        echo "\t</form>\n";
    }
    
    
?>
    </div> <!-- close the wrapper -->
</body>
</html>
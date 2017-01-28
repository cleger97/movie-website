<!--
	File: search.php
	Dev: Alex Leger
	Date Stated: 2017/1/19
	Description: The site to search for certain movie types.
-->
<?php
	include("./data/dbinc.incf");
	$search = null;
	
	// Check if the post array's 'search' is set. If it is, we're using the search function.
	if (!empty($_POST['SEARCH'])) {
		$search = $_POST['SEARCH'];	
		// If we're researching then the old query is worthless.
	} 
	
	$attribute = null;
	// Same as above - check to make sure this is first time we've searched.
	if (!empty($_POST['ATTRIBUTE'])) { 
		$attribute = $_POST['ATTRIBUTE'];
	}
	
	// If they search for nothing then just display everything again
	if ((strlen($search) == 0 or strtolower($search) == 'all') and $_POST['INPUT'] != 'sort') {
		header("Location: showall.php");
	}
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<title> Search </title>
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
                    <option value = "title"> Title </option>
                    <option value = "year"> Year </option>
                    <option value = "genre"> Genre </option>
                    <option value = "rating"> Rating </option>
                    <option value = "stars"> Stars </option>
                    <option value = "actorList"> Actor </option>
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
	// Do the search
	// this only works for not-actor list
     //if ($attribute != 'actorList') {
    $query = "SELECT * FROM movielist WHERE $attribute LIKE '%{$search}%'";
     //}
	
	$result = mysqli_query($cxn, $query) or die ("Invalid attribute!");
	
	$hasResults = true;
	if (mysqli_num_rows($result) == 0) {
		$hasResults = false;
	}

	// Display the actual search
	if ($hasResults) {
		echo "\t<table class = 'main'>\n";
		echo "\t\t<caption> Search for $search </caption>\n";
		
		// Display fields 
		echo "\t\t<thead>\n\t\t\t<tr>\n";
		while ($currentField = mysqli_fetch_field($result)) {
			// Do not display the unique identifier - no reason
			if ($currentField->name == 'id') { 
				continue; 
			} else {
				echo "\t\t\t\t<th>{$lov[$currentField->name]}</th>\n";
			}
		}		
		echo "\t\t\t</tr>\n\t</thead>\n";
		
		echo "\t\t<tbody>\n";
		// Display movies
		while ($row = mysqli_fetch_assoc($result)) {
			echo "\t\t\t<tr>\n";
			foreach ($row as $key => $value) {
				if ($key == 'id') continue;
				echo "\t\t\t\t<td class = '{$key}'>{$value}</td>\n";
			}
			echo "\t\t\t</tr>\n";
		}
		echo "\t\t</tbody>\n";
		echo "\t</table>\n";
	} else {
        echo "\t<p> No results found for {$search}. </p>\n";
        
    }
	
	
	
?>
    </div> <!-- close the wrapper -->



</body>

</html>
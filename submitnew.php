<!--
	File: submitnew.php
	Dev: Alex Leger
	Date Started: 2017/1/23
	Description: Checks submissions (for the addnew.php) and adds to the database if functional, or returns to add new with data otherwise.
-->

<?php
    include("./data/dbinc.incf");
	
	$list_of_numbers = array ("year", "stars");
    $list_of_strings = array ("genre", "title");
    
    // This page should always come with $_POST data
	// If it doesn't then we send the user back to the showall site
	if (empty($_POST)) {
		header("Location: addnew.php?ret='empty'");
        exit();
	}
	
    // INSERT INTO movietable (title, year, genre, rating, stars, actorList) VALUES ($title, $year, $genre, $rating, $stars, $actorlist);
    
    extract ($_POST);
    $protoActorList = "";

	foreach ($_POST as $key => $val) {
        if (in_array($key, $list_of_numbers)) {
            $pattern = "/^([0-9]*)(\.)?([0-9]*)$/";
            if (!is_numeric(strip_tags($val))) {
                // Error: Value not a number
                header("Location: addnew.php?ret=invalid&key={$key}");
                exit();
            }
        }
                
        if (in_array($key, $list_of_strings)) {
            if (!is_string(strip_tags($val)) {
                // Error: Value not a string
                header("Location: addnew.php?ret=invalid&key={$key}");
                exit();
            }
        }
        
        if ($key == "actorList") {
            $actorList = explode(",", $val);
            foreach ($actorList as $actor) {
                $actor = trim($actor);
            }
            if (sort($actorList, SORT_STRING)) {
                $protoActorList = implode(",", $actorList);
            }
        }
        
    }


	$sqltitle = mysqli_real_escape_string($cxn, $title);
    $sqlyear = mysqli_real_escape_string($cxn, $year);
    $sqlgenre = mysqli_real_escape_string($cxn, $genre);
    $sqlrating = mysqli_real_escape_string($cxn, $rating);
    $sqlstars = mysqli_real_escape_string($cxn, $stars);
    $sqlactors = mysqli_real_escape_string($cxn, $protoActorList);
    
    
    $query = "INSERT INTO movielist (title, year, genre, rating, stars, actorList, id) VALUES ('$sqltitle', '$sqlyear', '$sqlgenre', '$sqlrating', '$sqlstars', '$sqlactors', NULL)";

    echo $query;
    
    $result = mysqli_query($cxn, $query) or die ("Error in query");

    $submit = false;
    if ($result) {
        $submit = true;
    } else {
        $submit = false;
    }

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
    if ($submit) {
        echo "\t<p> Added new movie succesfully! </p>\n";
    } else {
        echo "\t<p> Did not submit succesfully </p>\n";
    }
    
    
?>
    </div> <!-- close the wrapper -->


</body>
</html>


<!--
	File: submitnew.php
	Dev: Alex Leger
	Date Started: 2017/1/23
	Description: Checks submissions (for the addnew.php) and adds to the database if functional, or returns to add new with data otherwise.
-->

<?php
    include("./data/dbinc.incf");
	// This page should always come with $_POST data
	// If it doesn't then we send the user back to the showall site
	$list_of_numbers = array ("year", "stars");
    $list_of_strings = array ("genre", "title");

	if (empty($_POST)) {
		header("Location: addnew.php?ret='empty'");
        exit();
	}
	
    // INSERT INTO movietable (title, year, genre, rating, stars, actorList) VALUES ($title, $year, $genre, $rating, $stars, $actorlist);
    
    // Insures there are only numbers in the string
    extract ($_POST);
    $protoActorList = array();

	foreach ($_POST as $key => $val) {
        if (in_array($key, $list_of_numbers)) {
            $pattern = "/^([0-9]*)(\.)?([0-9]*)$/";
            if (!preg_match($pattern,strip_tags($val))) {
                // Error: Value not a number
            }
        }
                
        if (in_array($key, $list_of_strings)) {
            if (!is_string($val)) {
                // Error: Value not a string
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
    
    <div id = "linkbox">
        <table>
            <tr> <td> <a href="showall.php"> Show All Movies </a> </td> </tr>
            <tr> <td> <a href="addnew.php"> Add A Movie </a> </td> </tr>
        </table>
	</div>
<?php 
    if ($submit) {
        echo "\t<p> Added new movie succesfully! </p>\n";
    } else {
        echo "\t<p> Did not submit succesfully </p>\n";
    }
    
    
?>


</body>
</html>


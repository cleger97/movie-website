<!-- 
    File: submitmod.php
    Dev: Alex Leger 
    Date Started: 2017/1/26
    Description: The submission interface for the movie.
-->

<?php
    include("./data/dbinc.incf");
    $list_of_numbers = array ("year", "stars");
    $list_of_strings = array ("genre", "title");


    if (empty($_POST)) {
		header("Location: addnew.php?ret='empty'");
        exit();
	}
    
    extract ($_POST);
    $protoActorList = "";
    $updateData = array();

    $id = $_POST['id'];

    $sqlid = mysqli_real_escape_string($cxn, $_POST['id']);
    
    $query = "SELECT * FROM movielist WHERE movielist.id = {$sqlid}";
    echo $query;

    $result = mysqli_query($cxn, $query) or die ("Error in query!");

    // UPDATE `movielist` SET `rating` = 'R' WHERE `movielist`.`id` = 1;
    $oldData = mysqli_fetch_assoc($result);

    // First compare each part of the data, check if values are correct and have changed
	foreach ($_POST as $key => $val) {
        if ($key == $id) continue;
        
        if (in_array($key, $list_of_numbers)) {
            $pattern = "/^([0-9]*)(\.)?([0-9]*)$/";
            if (!is_numeric(strip_tags($val))) {
                // Error: Value not a number
                header("Location: modifymovie.php?ret=invalid&key={$key}&id={$id}");
                exit();
            }
        }
                
        if (in_array($key, $list_of_strings)) {
            if (!is_string(strip_tags($val))) {
                // Error: Value not a string
                header("Location: modifymovie.php?ret=invalid&key={$key}&id={$id}");
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
        
        if ($key == "actorList") {
            if ((!(isset($oldData[$key]))) or !($protoActorList == $oldData[$key])) {
                $updateData[$key] = $protoActorList;
            }
        } else {
            if (!($val == $oldData[$key])) {
                $updateData[$key] = $val;
            }     
        }             
    }
    

?>

<html>
<head>
    <title> Modify Movie </title>
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
    // Next step is to cycle through all the update data and send it to the database
    foreach ($updateData as $key => $val) {
        $sqlkey = mysqli_real_escape_string($cxn, $key);
        $sqlval = mysqli_real_escape_string($cxn, $val);
        $query = "UPDATE movielist SET {$sqlkey} = '{$sqlval}' WHERE movielist.id = $sqlid";
        $result = mysqli_query($cxn, $query) or die ("Error in replacing data");
        
        if ($result) {
            echo "\t<p> Updated value {$key} succesfully. </p>\n";
        }
    }         
?>
        
        
        
    </div> <!-- close the wrapper -->
</body>





</html>
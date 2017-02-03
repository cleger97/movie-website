<?php
    include("./data/dbinc.incf");
    // if no post data then send back to index
    if (empty($_POST)) {
        header("Location: index.html");
    }
    // if select isn't true then open the site
    $select = false;
    if (!empty($_POST['selected'])) {
        if ($selected) {
            $select = true;
        }
    }
    
    // if there's no id then the data sent doesn't work
    if (empty($_POST['id']) or empty($_SESSION['id'])) {
        header("Location: index.html");
    }
    // Initialize the ID
    $id = '';
    if (empty($_SESSION['id'])) {
        $id = $_POST['id'];
    } else {
        $id = $_SESSION['id'];
    }
?>

<html>
<head>
    <title> Delete Movie </title>
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
    
        
        
        
?>

    
    </div> <!-- close the wrapper -->
</body>

</html>
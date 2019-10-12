<!DOCTYPE html>
<html>

<?php
//create_cat.php

include 'header.php';
 
//connect.php
$server = 'localhost';
$username   = 'root';
$password   = 'Password@2000';
$database   = 'myforumdb';
$con=mysqli_connect($server, $username,  $password, $database);
if(!$con)
{
    exit('Error: could not establish database connection');
}


 if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
    echo '<form action="" method="post">
        Category name: <input type="text" name="cat_name" /><br>
        Category description: <textarea name="cat_description" /></textarea>
        <input type="submit" value="Add category" />
     </form>';
}
else
{
    //the form has been posted, so save it
    $CAT_NAME=mysqli_real_escape_string($con,$_POST['cat_name']);
    $CAT_DESCRIPTION=mysqli_real_escape_string($con,$_POST['cat_description']);
    $sql1 = "INSERT INTO categories(cat_name, cat_description)
       VALUES('$CAT_NAME','$CAT_DESCRIPTION')";
    $result = mysqli_query($con,$sql1);
    if(!$result)
    {
        //something went wrong, display the error
        echo 'Error'.mysqli_error($con);
    }
    else
    {
        echo 'New category successfully added.';
    }
}

include 'footer.php';
?>
</html>
<?php
//connect.php
$server = 'localhost';
$username   = 'root';
$password   = 'Password@2000';
$database   = 'myforumdb';
 
if(!mysqli_connect($server, $username,  $password, $database))
{
    exit('Error: could not establish database connection');
}

?>
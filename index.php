<?php
//create_cat.php

session_start();
if($_SESSION['signed_in']==TRUE){
    include 'header_aftersignin.php';
}
else{
include 'header.php';
}
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
$sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories";
 
$result = mysqli_query($con,$sql);
 
if(!$result)
{
    echo 'The categories could not be displayed, please try again later.';
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'No categories defined yet.';
    }
    else
    {
        //prepare the table
        echo '<style>
		table, th, td {
  			border: 1px solid black;
		  	border-collapse: collapse;
			}
		th, td {
  			padding: 15px;
				}
			</style>';
        echo '<table border="1" style="width:80%">
              <tr>
                <th>Category</th>
                <th>Category Description</th>
              </tr>'; 
             
        while($row = mysqli_fetch_assoc($result))
        {               
            echo '<tr>';
                echo '<td class="leftpart" width="50%">';
                    echo '<h3><a href="category.php?id='.$row["cat_id"].'">' . $row['cat_name'] . '</a></h3>';
                echo '</td>';
                echo '<td class="rightpart" width="50%">';
                            echo "'".$row['cat_description']."'";
                echo '</td>';
            echo '</tr>';
        }
    }
}
 
include 'footer.php';
?>
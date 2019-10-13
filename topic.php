<?php


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
//first select the category based on $_GET['cat_id']

$sql = "SELECT
            *
        FROM
            topics
        WHERE
            topic_id = '" . mysqli_real_escape_string($con,$_GET['id'])."'";
 
$result = mysqli_query($con,$sql);
 
if(!$result)
{
    echo 'The topic could not be displayed, please try again later.' . mysqli_error($con);
}
else
{
    if(mysqli_num_rows($result) == 0)
    {
        echo 'This topic does not exist.';
    }
    else
    {
        //display category data
        while($row = mysqli_fetch_assoc($result))
        {
            echo "'<h2>Posts in " . $row['topic_subject'] . " topic</h2>'";
        }
     
        //do a query for the topics
        $sql = "SELECT
           posts.post_topic,
            posts.post_content,
            posts.post_date,
            posts.post_by,
            posts.post_id,
            users.user_id,
           users.user_name
            FROM
               posts
            LEFT JOIN
              users
            ON
             posts.post_by = users.user_id
            WHERE
             posts.post_topic = '" . mysqli_real_escape_string($con,$_GET['id'])."'";
         
        $result = mysqli_query($con,$sql);
         
        if(!$result)
        {
            echo 'The topics could not be displayed, please try again later.';
        }
        else
        {
            if(mysqli_num_rows($result) == 0)
            {
                echo 'There are no posts in this topic yet.';
            }
            else
            {
                //prepare the table
                echo '<table border="1" style="width:80%">
                      <tr>
                        <th>Post Content</th>
                        <th>Created at</th>
                        <th>Post by</th>
                      </tr>'; 
                     
                while($row = mysqli_fetch_assoc($result))
                {    

                    echo "<tr>";
                        echo "<td width='50%'>";
                            echo "'".$row['post_content']."'";
                        echo "</td>";
                        echo "<td width='25%'>";
                            echo date('d-m-Y', strtotime($row['post_date']));
                        echo "</td>";
                        echo "<td width='25%'>";
                            echo "'".$row['user_name']."'";
                        echo "</td>";
                    echo "</tr>";

                }

        
        echo '<form action = "reply.php?id='.$_GET['id'].'" method = "post">
         
         
         <textarea rows = "5" cols = "50" name = "reply-content" id="reply-content">
            Enter reply
         </textarea>
         
         <input type = "submit" value = "submit" />
      </form>';

            }
        }
    }
}
 
include 'footer.php';
?>
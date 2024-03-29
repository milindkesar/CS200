<?php
//signin.php
include_once ('header.php'); ?>
 <!-- include 'header.php'; -->

<?php
//signup.php
// include 'header.php';
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

echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    ';
 
echo '<h3>Sign up</h3>';
 
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    /*the form hasn't been posted yet, display it
      note that the action="" will cause the form to post to the same page it is on */
    // echo '<form method="post" action="">
    //     Username: <input type="text" name="user_name" />
    //     Password: <input type="password" name="user_pass">
    //     Password again: <input type="password" name="user_pass_check">
    //     E-mail: <input type="email" name="user_email">
    //     <input type="submit" value="Add category" />
    //  </form>';
      echo '<form method="post" action="" style="padding-top: 5%; width:400px ; margin-left: 40%; margin-right: 40%">
                  <div class="form-group">
                    <label for="exampleInputUsername1">Username</label>
                    <input type="text" class="form-control" id="username" name="user_name"  placeholder="Enter Username">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="user_pass" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword2" name="user_pass_check" placeholder="Confirm Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputemail1">Email address</label>
                    <input type="email" class="form-control" id="useremail" name="user_email"  placeholder="Enter Email">
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            ';
}
else
{
    /* so, the form has been posted, we'll process the data in three steps:
        1.  Check the data
        2.  Let the user refill the wrong fields (if necessary)
        3.  Save the data 
    */
    $errors = array(); /* declare the array for later use */
     
    if($_POST['user_name'] != NULL)
    {
        //the user name exists
        if(!ctype_alnum($_POST['user_name']))
        {
            $errors[] = 'The username can only contain letters and digits.';
        }
        if(strlen($_POST['user_name']) > 30)
        {
            $errors[] = 'The username cannot be longer than 30 characters.';
        }
    }
    else
    {
        $errors[] = 'The username field must not be empty.';
    }
     
     
    if(($_POST['user_pass'])!=NULL)
    {
        if($_POST['user_pass'] != $_POST['user_pass_check'])
        {
            $errors[] = 'The two passwords did not match.';
        }
    }
    else
    {
        $errors[] = 'The password field cannot be empty.';
    }
     
    if(!empty($errors)) /*check for an empty array, if there are errors, they're in this array (note the ! operator)*/
    {
        echo 'Uh-oh.. a couple of fields are not filled in correctly..';
        echo '<ul>';
        foreach($errors as $key => $value) /* walk through the array so all the errors get displayed */
        {
            echo '<li>' . $value . '</li>'; /* this generates a nice error list */
        }
        echo '</ul>';
    }
    else
    {
        //the form has been posted without, so save it
        //notice the use of mysql_real_escape_string, keep everything safe!
        //also notice the sha1 function which hashes the password
        $USER_NAME=mysqli_real_escape_string($con,$_POST['user_name']);
        $USER_PASS=sha1($_POST['user_pass']);
        $USER_EMAIL=mysqli_real_escape_string($con,$_POST['user_email']);
        $sql = "INSERT INTO
                    users(user_name, user_pass, user_email ,user_date, user_level)
                VALUES('$USER_NAME',
                       '$USER_PASS',
                       '$USER_EMAIL',
                        NOW(),
                        0)";
                         
        $result = mysqli_query($con,$sql);
        if(!$result)
        {
            //something went wrong, display the error
            echo 'Something went wrong while registering. Please try again later.';
            //echo mysqli_error(); //debugging purposes, uncomment when needed
        }
        else
        {
            echo 'Successfully registered. You can now <a href="signin.php">sign in</a> and start posting! :-)';
        }
    }
}
 
include 'footer.php';
?>

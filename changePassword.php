<?php

session_start();

function get_post($conn,$var){
    return $conn->real_escape_string($_POST[$var]);
}

$incorrectError = "";

if(isset($_POST['submit'])){

    if(!empty($_POST['oldPassword'] && !empty($_POST['newPassword'])) && !empty($_POST['verifyNewPassword'])){
        require_once('dbconfig.php');

        $conn= new mysqli(HOST,USERNAME,PASSWORD,DBNAME);
        if($conn->connect_error) die('Connection failed:'.$conn->connect_error);
        
        $oldPassword = get_post($conn,'oldPassword');
        $newPassword = get_post($conn,'newPassword');
        $verifyNewPassword = get_post($conn,'verifyNewPassword');

        $id = $_SESSION['id'];


        $query = "select * from users where username=$id";/*   USERNAME?? DUHET ME MARR PREJ SESIONEVE */
        $result = $conn->query($query);
        $row = $result->fetch_array();
        $hashPw = $row['password'];
        
        $newHashPw = password_hash($newPassword,PASSWORD_DEFAULT);

        if(!password_verify($oldPassword,$hashPw)){
            $incorrectError = "The old password is incorrect!";
        }
        else if($newPassword != $verifyNewPassword){
            $incorrectError = "The passwords are not the same!";
        }
        else{
            $incorrectError = "";
            $query = "update users set password='$newHashPw' where username='$id'";

            if($conn->query($query)){
                echo '<script type="text/javascript">';
                echo 'alert("The password has been changed.")';
                echo '</script>';
                header("Location: login.php");
            }
            else{
                echo '<script type="text/javascript">';
                echo 'alert("The password has not been changed!")';
                echo '</script>';
            }
        }

    }

}


?>



<html>
    <head>
        <title>Login</title> 
        <link rel="stylesheet" type="text/css" href="css/Login.css">
    </head>
    <body>
        
        <div class="login">
            <a><img src="images/login.png" class="img"></a>

            <form action="changePassword.php" method="post">
            <p class="text">Old Password</p>
            <input type="password" name="oldPassword" class="input">
            <p class="text" >New Password</p>
            <input type="password" name="newPassword" class="input">
            <p class="text" >Verify New Password</p>
            <input type="password" name="verifyNewPassword" class="input">
            <input type="submit" class="hyrja" name="submit" value="Submit">
            <br><br>
            <p><?php echo $incorrectError?></p>
            </form>
        </div>
    
    
    

    </body>
</html>
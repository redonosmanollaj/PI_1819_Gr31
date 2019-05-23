


<?php

if(session_status()== PHP_SESSION_NONE){
    session_start();
}

function get_post($conn,$var){
    return $conn->real_escape_string($_POST[$var]);
}

if(isset($_SESSION['credentialsEntered'])){
    require_once('fetchStudentData.php');
}
else{
?>
<html>
    <head>
        <title>Login</title> 
        <link rel="stylesheet" type="text/css" href="css/Login.css">
    </head>

<?php
    require_once('dbconfig.php');
    $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $incorrectError = "";
    if(isset($_POST['submit'])){
        if(!empty($_POST['username']) AND !empty($_POST['password'])){
            $username = get_post($conn,'username');
            $password = get_post($conn,'password');

            $query = "select * from users where username = '$username' and password = '$password';";

            $result = $conn->query($query);
            $rows = $result->num_rows;

            if($rows==1){
                $incorrectError = "";
                $_SESSION['credentialsEntered']==true;
               header('Location: fetchStudentData.php');
            }
            else{
                $incorrectError = "* Username or password are incorrect!";
            }

            $conn->close();
        }
        else{
            $incorrectError = "* Username or password are missing!";
        }
    
    }

?>

<body>
        
        <div class="login">
            <a><img src="images/login.png" class="img"></a>

            <form action="Login.php" method="post">
            <p class="text">Perdoruesi</p>
            <input type="text" name="username" class="input">
            <p class="text" >Fjalekalimi</p>
            <input type="password" name="password" class="input">
            <input type="submit" class="hyrja" name="submit" value="Hyrja">
            <br><br>
            <p><?php echo $incorrectError?></p>
            </form>
        </div>
    
    
    

    </body>
</html>

<?php } ?>
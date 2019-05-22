


<?php

if(session_status()== PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['credentialsEntered'])){
    require_once('addStudent.php');
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
    $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME)
    or die('Could not connect to database!'."<br>".$conn->connect_error());

    $incorrectError = "";
    function signIn($conn){
        if(!empty($_POST['username']) and !empty($_POST['password'])){
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "select * from users where username = ? and password = ?";
            $statement = $conn->prepare($query);
            $statement->bind_param("ss",$username,$password);
            $statement->execute();

            $rows = $statement->affected_rows;
            if($rows==1){
                $incorrectError = "";
                $_SESSION['credentialsEntered']==true;
            }
            else{
                $incorrectError = "* Username or password are incorrect!";
            }
        }
        else{
            $incorrectError = "* Username or password are missing!";
        }
    }


if(isset($_POST['submit'])){
    signIn($conn);
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
            <button class="hyrja" type="submit" name="submit">Hyrja</button>
            <br><br>
            <p><?php echo $incorrectError?></p>
            </form>
        </div>
    
    
    

    </body>
</html>

<?php } ?>
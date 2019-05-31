<?php
if(session_status()== PHP_SESSION_NONE){
    session_start();
}

unset($_SESSION['id']);
unset($_SESSION['password']);

session_destroy();

header("Location: Login.php");

?>
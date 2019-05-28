<?php
session_start();

unset($_SESSION['id']);
unset($_SESSION['password']);
session_destroy();

header("Location: index.html");

?>
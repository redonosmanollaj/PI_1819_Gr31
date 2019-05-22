<?php

define("HOST","localhost");
define("DBNAME","dbmiami");
define("USERNAME","root");
define("PASSWORD","045257900");

$conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
<?php

define("HOST","localhost");
define("DBNAME","dbpi");
define("USERNAME","root");
define("PASSWORD","045257900");

$conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME)
or die('Could not connect to database!'."<br>".$conn->connect_error());

?>
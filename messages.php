<?php

require_once('dbconfig.php');

if(isset($_POST['submit'])){

    $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

      $query = "insert into messages(name,email,content) values(?,?,?);";

      $name = $_POST['emri'];
      $email = $_POST['email'];
      $content = $_POST['content'];

      $statement = $conn->prepare($query);
      $statement->bind_param("sss",$name,$email,$content);

      $statement->execute();

      $rows = $statement->affected_rows;

      if($rows==1){
        echo '<script type="text/javascript">';
        echo 'alert("Message has been sent!")';
        echo '</script>';
      }
      else{
        echo '<script type="text/javascript">';
        echo 'alert("Message has not sent! ")';
        echo '</script>';
      }

      $statement->close();
      $conn->close();

}
?>

<html>
  <body>
    <a href="index.html">Go Back</a>
  </body>
</html>
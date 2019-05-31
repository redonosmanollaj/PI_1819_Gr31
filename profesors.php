<?php
if(session_status()== PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['profesorLoggedin'])){
?>



<html>
    <head>
    <!-- Google fonts -->
    <link href='https://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>
    <!-- CSS style sheets -->
    <link rel="StyleSheet" href="./css/registration-design.css" />
    <link rel="StyleSheet" href="./css/message-design.css" />
    <title>Profesor Page</title>
    <link rel="shortcut icon" type="image/png" href="./pictures/westmount.png"/>
    </head>
    <body>
        

    <!-- Butoni per me shtu student ne databaz -->
    <table align="center" cellspacing = "8">
    <tr>
        <td align>
        <form action="./addStudent.php" method="post">
            <a href="fetchGrades.php"><input type="button" name="go"  class="redirectButton" value="View Grades" /></a>
            <a href="editGrades.php"><input type="button" name="go"  class="redirectButton" value="Edit Grades" /></a>
            <a href="changePassword.php"><input type="button" name="go"  class="redirectButton" value="Change Password" /></a>
            <a href="logout.php"><input type="button" name="go"  class="redirectButton" value="Log Out" /></a>
        </form>
        </td>
    </tr>
    </table>

<div id = "title">
    <img src="./images/miamilogo.png" alt="Banner" style="width:600px;height:300px;"/>
    <h1>Profesor's Page</h1>

</div>


<?php
$profesor_id = $_SESSION['id'];


require_once('dbconfig.php');
$conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME);
if(!$conn){
    die("Connection failed".mysqli_connect_error);
}  


// Marrja e pergjigjes nga databaza duke derguar lidhjen dhe queryn
$response = @mysqli_query($conn, $query);

$queryMyName = "SELECT first_name,last_name FROM Profesors WHERE profesor_id=$profesor_id";
$result = $conn->query($queryMyName);
$row = $result->fetch_array();
$myName = $row['first_name'].' '.$row['last_name'];

echo "<h2 align='center'>$profesor_id &nbsp &nbsp $myName</h2>";

?>
<?php
}
else{
    require_once('logout.php');
}
        
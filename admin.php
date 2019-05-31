<?php
if(session_status()== PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['adminLoggedin'])){
?>

    <html>
    <head>
    <!-- Google fonts -->
    <link href='https://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>
    <!-- CSS style sheets -->
    <link rel="StyleSheet" href="./css/registration-design.css" />
    <link rel="StyleSheet" href="./css/message-design.css" />
    <title>Admin Page</title>
    <link rel="shortcut icon" type="image/png" href="./pictures/westmount.png"/>
    </head>
    <body>

    <!-- Butoni per me shtu student ne databaz -->
    <table align="center" cellspacing = "8">
    <tr>
        <td align>
        <form action="./addStudent.php" method="post">
            <input type="submit" name="go"  class="redirectButton" value="Add Student" />
            <a href="fetchStudentData.php"><input type="button" name="go"  class="redirectButton" value="View Students" /></a>
            <a href="addProfesor.php"><input type="button" name="go"  class="redirectButton" value="Add Profesor" /></a>
            <a href="fetchProfesors.php"><input type="button" name="go"  class="redirectButton" value="View Profesors" /></a>
            <a href="fetchMessages.php"><input type="button" name="go"  class="redirectButton" value="View Messages" /></a>
            <a href="logout.php"><input type="button" name="go"  class="redirectButton" value="Log Out" /></a>
        </form>
        </td>
    </tr>
    </table>

<div id = "title">
    <img src="./images/miamilogo.png" alt="Banner" style="width:600px;height:300px;"/>
    <h1>Administrator Page</h1>
</div>

<?php
}
else{
    require_once('Login.php');
}
        
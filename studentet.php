<?php
if(session_status()== PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['studentLoggedin'])){
?>


<html>
    <head>
    <!-- Google fonts -->
    <link href='https://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>
    <!-- CSS style sheets -->
    <link rel="StyleSheet" href="./css/registration-design.css" />
    <link rel="StyleSheet" href="./css/message-design.css" />
    <title>Student's Information</title>
    <link rel="shortcut icon" type="image/png" href="./pictures/westmount.png"/>
    </head>
    <body>

    <!-- Butoni per me shtu student ne databaz -->
    <table align="center" cellspacing = "8">
    <tr>
        <td align>
        <form action="./addStudent.php" method="post">
            <a href="changePassword.php"><input type="button" name="changePassword"  class="redirectButton" value="Change Password" /></a>
            <a href="logout.php"><input type="button" name="go"  class="redirectButton" value="Log Out" /></a>

        </form>
        </td>
    </tr>
        

    </table>

<?php
// konektimi me databaz
require_once('dbconfig.php');

require_once('dbconfig.php');
$conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME);
if(!$conn){
    die("Connection failed".mysqli_connect_error);
}  


//	fshrija e te dhenes specifike nga databaza kur te klikohet butoni

?>

<div id = "title">
    <img src="./images/miamilogo.png" alt="Banner" style="width:600px;height:300px;"/>
    <h1>MY GRADES</h1>
</div>

<?php
$student_id = $_SESSION['id'];

//	Krijimi i queryt per databaz
$query = "SELECT S.subject_id, S.subject_name, P.first_name,P.last_name, S.ects, G.grade
FROM Subjects S, Profesors P, Grades G, Students St, Teachs T
where S.subject_id=G.subject_id and St.student_id = G.student_id and P.profesor_id=T.profesor_id and T.subject_id=S.subject_id
and St.student_id = $student_id";

// Marrja e pergjigjes nga databaza duke derguar lidhjen dhe queryn
$response = @mysqli_query($conn, $query);

$queryMyName = "SELECT first_name,last_name FROM Students WHERE student_id=$student_id";
$result = $conn->query($queryMyName);
$row = $result->fetch_array();
$myName = $row['first_name'].' '.$row['last_name'];

echo "<h2 align='center'>$student_id &nbsp &nbsp $myName</h2>";
// nese query ekzekutohet mir
if($response){
    //	Outputi i numrit te studenteve me te dhena
    $num_rows = mysqli_num_rows($response);
    echo "<p align='center'><font face = 'Architects Daughter' size='4pt'><i> * $num_rows records fetched! </i></font></p>";


    echo '<table class = "studentinfo" align="center" cellpadding="8">

    <tr><td align="left"><font face = "Architects Daughter" size="3"><b>Subject Id</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Subject Name</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Profesor</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>ECTS</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Grade</b></font></td>';
   

    // Kthe nje rresht te te dhenave nga query derisa t'mos ket te dhena tjera
    while($row = mysqli_fetch_array($response)){
        echo '<tr><td align="left">' . 
        $row['subject_id'] . '</td><td align="left">' . 
        $row['subject_name'] . '</td><td align="left">' . 
        $row['first_name'].' '.$row['last_name'] . '</td><td align="left">' .
        $row['ects'] . '</td><td align="left">' .
        $row['grade'] . '</td><td align="left">' ;

        echo '</tr>';
    }		
echo '</table>';
} 
//	nese query nuk ekzekutohet si duhet
else {
    echo "Couldn't issue database query<br />";
    echo mysqli_error($conn);
}

// mbyllja e konektimit me databaz
mysqli_close($conn);
?>
</body>
</html>

<?php
}
else{
    require_once('logout.php');
}
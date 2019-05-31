<?php
session_start();
?>


<html>
    <head>
    <!-- Google fonts -->
    <link href='https://fonts.googleapis.com/css?family=Nothing+You+Could+Do' rel='stylesheet' type='text/css'>
    <!-- CSS style sheets -->
    <link rel="StyleSheet" href="./css/registration-design.css" />
    <link rel="StyleSheet" href="./css/message-design.css" />
    <title>Fetch Student Data</title>
    <link rel="shortcut icon" type="image/png" href="./pictures/westmount.png"/>
    </head>
    <body>

    <!-- Butoni per me shtu student ne databaz -->
    <table align="center" cellspacing = "8">
    <tr>
        <td align>
        <form action="./addStudent.php" method="post">
        <a href="profesors.php"><input type="button" name="go"  class="redirectButton" value="Home" /></a>
            <a href="logout.php"><input type="button" name="go"  class="redirectButton" value="Log Out" /></a>
        </form>
        </td>
    </tr>
        

    </table>

<?php
// konektimi me databaz

require_once('dbconfig.php');
$conn = mysqli_connect(HOST,USERNAME,PASSWORD,DBNAME);
if(!$conn){
    die("Connection failed".mysqli_connect_error);
}  


?>

<div id = "title">
    <img src="./images/miamilogo.png" alt="Banner" style="width:600px;height:300px;"/>
    <h1>Grades of Students:</h1>
</div>

<?php
$profesor_id = $_SESSION['id'];
//	Krijimi i queryt per databaz
$query = "SELECT first_name, last_name, email, street_name, city,country,
phone,d_day, d_month, d_year,gender, student_id FROM students ORDER BY student_id,first_name, last_name";

// Marrja e pergjigjes nga databaza duke derguar lidhjen dhe queryn
$response = @mysqli_query($conn, $query);

// nese query ekzekutohet mir
if($response){
    //	Outputi i numrit te studenteve me te dhena
    $num_rows = mysqli_num_rows($response);
    echo "<p align='center'><font face = 'Architects Daughter' size='4pt'><i> * $num_rows records fetched! </i></font></p>";

    $subjectsQuery = "select S.subject_id,S.subject_name
            from Profesors P, Subjects S, Teachs T
            where P.profesor_id=T.profesor_id and S.subject_id = T.subject_id and P.profesor_id=$profesor_id";
    $result = $conn->query($subjectsQuery);
    while($row = $result->fetch_array()){
        $subjectsArray[] = $row['subject_name'];
        $subjectsIdArray[] = $row['subject_id'];
    }

    echo '<table class = "studentinfo" align="center" cellpadding="8">

    <tr><td align="left"><font face = "Architects Daughter" size="3"><b>Id</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>First Name</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Last Name</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Email</b></font></td>';
    foreach($subjectsArray as $subject){
        echo "<td align='left'><font face = 'Architects Daughter' size='3'><b>$subject</b></font></td>";
    }

    $gradeQuery = "select *
                from Grades
                where student_id = ? and subject_id = ?;";


    // Kthe nje rresht te te dhenave nga query derisa t'mos ket te dhena tjera
    while($row = mysqli_fetch_array($response)){
        echo '<tr><td align="left">' . 
        $row['student_id'] . '</td><td align="left">' . 
        $row['first_name'] . '</td><td align="left">' . 
        $row['last_name'] . '</td><td align="left">' .
        $row['email'] . '</td>' ;

        $gradeStm = $conn->prepare($gradeQuery);
        for($i=0;$i<sizeof($subjectsArray);$i++){
            $gradeStm->bind_param("ii",$row['student_id'],$subjectsIdArray[$i]);
            $gradeStm->execute();
            $gradeResult = $gradeStm->get_result();
            $gradeRow = $gradeResult->fetch_array();

        
            echo '<td align="center">'.$gradeRow['grade'].'</td>';
            
        }

        ?>



        <?php
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

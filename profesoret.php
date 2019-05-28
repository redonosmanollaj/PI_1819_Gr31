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
            <a href="changePassword.php"><input type="button" name="go"  class="redirectButton" value="Change Password" /></a>
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
            if($gradeRow['grade']==null){
                ?> <td align="center">
                <form method="post" action="profesoret.php">
                <input type="number" name="<?php echo $i?>" min="5" max="10" size="1">
                </td>
                </form>
                <?php
            }else{
                echo '<td align="center">'.$gradeRow['grade'].'</td>';
            }
        }

        ?>

        <!-- eventat ne form qendrojn ne faqe -->
        <form method="post" action="">
            <!-- Butonai fshehur ruan id specifike te studentit -->
            <td><input type="hidden" id = "student_id" name="student_id" value="<?php echo $row['student_id']; ?>" /></td>
            <!-- butoni delete -->
            <td><input type="submit" name="rate" class="deleteButton" value="Rate" onclick="return confirm('Are you sure?')" /></td>
        </form>

        <?php
        echo '</tr>';
    }		
echo '</table>';

if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];
    if (isset($_POST['rate'])) {
        $sql = "REPLACE INTO Grades(student_id,subject_id,grade) values(?,?,?)";
        $stm = $conn->prepare($sql);
        
        for($i=0;$i<sizeof($subjectsArray);$i++){
            $gradeString = "grade".$i;
            $stm->bind_param("iii",$student_id,$subjectsIdArray[$i],$_POST[$i]);
            $stm->execute();

            $rows = $stm->affected_rows;
            echo $rows;
            if ($rows>0)
            {?>
                <!-- Outputi pas fshirjes -->
                <div class="isa_success">
                <i class="fa fa-check"></i>
                    <?php echo "Student Rated"; ?>
                </div><?php
            }
            else
                // Outputi nese ndodh naj gabim gjat fshirjes
            {?>
                <div class="isa_error">
                <i class="fa fa-warning"></i>
                    <?php echo "Error Occurred ".mysqli_error($conn); ?>
                </div><?php
            }
        }
        

    }
}

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

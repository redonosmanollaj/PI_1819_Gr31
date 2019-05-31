<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['profesorLoggedin'])){

require_once('profesors.php');
require_once('dbconfig.php');

$conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);

if($conn->connect_error){
    die("Connection to database failed! ".$conn->connect_error);
}


$queryStudents = "SELECT * FROM Students";
$querySubjects = "SELECT *
                  FROM Teachs T, Subjects S 
                  WHERE S.subject_id=T.subject_id and T.profesor_id=$profesor_id;";
$queryGrades = "REPLACE INTO Grades(student_id,subject_id,grade) VALUES(?,?,?);";


$resultStudents = $conn->query($queryStudents);
$rowsOfStudents = $resultStudents->num_rows;



?>
<form method="post">
<table align="center" cellspacing = "8">
<tr>
	<!-- Broken down into three separate dropdowns -->
	<!-- Month -->
    <td align ="left">
    
    <select name="student" class = "inputs">
	
	<option value=""></option>
	<option value = "" disabled> - Student - </option>
	
	<?php
    for($j=0;$j<$rowsOfStudents;++$j){
        $resultStudents->data_seek($j);
        $rowStudent = $resultStudents->fetch_array();
		//	Remembers what option is used between rounds with some incorrect or missing data input
        ?><option value="<?php echo $rowStudent['student_id']; ?>"<?php
            echo ' selected="selected"';
        ?>><?php echo $rowStudent['student_id'].' '.$rowStudent['first_name'].' '.$rowStudent['last_name']; ?></option><?php
    }
	?>
    </select>

    <?php
    $resultSubjects = $conn->query($querySubjects);
    $rowsOfSubjects = $resultSubjects->num_rows;
    ?>

    <select name="subject" class = "inputs">
	
	<option value=""></option>
	<option value = "" disabled> - Subject - </option>
	
	<?php
    for($j=0;$j<$rowsOfSubjects;++$j){
        $resultSubjects->data_seek($j);
        $rowSubject = $resultSubjects->fetch_array();
		//	Remembers what option is used between rounds with some incorrect or missing data input
        ?><option value="<?php echo $rowSubject['subject_id']; ?>"<?php
            echo ' selected="selected"';
        ?>><?php echo $rowSubject['subject_name']; ?></option><?php
    }
	?>
    </select>

    <select name="grade" class = "inputs">
	
	<option value=""></option>
	<option value = "" disabled> - Subject - </option>
	
	<?php
    for($j=5;$j<11;$j++){
		//	Remembers what option is used between rounds with some incorrect or missing data input
        ?><option value="<?php echo $j; ?>"<?php
            echo ' selected="selected"';
        ?>><?php echo $j; ?></option><?php
    }
	?>
    </select>
            <!-- Butonai fshehur ruan id specifike te studentit -->
            <input type="hidden" id = "student_id" name="profesor_id" value="<?php echo $row['profesor_id']; ?>" />
            <!-- butoni delete -->
            <input type="submit" name="edit" class="deleteButton" value="Submit" onclick="return confirm('Are you sure?')" />

    </td>
    </tr>

</table>
</form>
<?php
        if (isset($_POST['edit'])) {
            $stm = $conn->prepare($queryGrades);

            $student_id = $_POST['student'];
            $subject_id = $_POST['subject'];
            $grade = $_POST['grade'];

            $stm->bind_param("iii",$student_id,$subject_id,$grade);
            
            
		    if ($stm->execute())
			{?>
				<!-- Outputi pas fshirjes -->
				<div class="isa_success">
				<i class="fa fa-check"></i>
					<?php echo "Grade Edited"; ?>
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

?>






<?php
}
else{
    require_once('logout.php');
}
?>
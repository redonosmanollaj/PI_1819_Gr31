

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
            <input type="submit" name="go"  class="redirectButton" value="Add Student to Database" />
            <a href="fetchMessages.php"><input type="button" name="go"  class="redirectButton" value="View Messages" /></a>
            <a href="addProfesor.php"><input type="button" name="go"  class="redirectButton" value="Add Profesor" /></a>
            <a href="index.html"><input type="button" name="go"  class="redirectButton" value="Log Out" /></a>
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

if (isset($_POST['student_id'])) {
        $student_id = $_POST['student_id'];
        if (isset($_POST['delete'])) {
            $sql = "DELETE FROM students WHERE student_id = " . $student_id;
			
		    if (mysqli_query($conn, $sql))
			{?>
				<!-- Outputi pas fshirjes -->
				<div class="isa_success">
				<i class="fa fa-check"></i>
					<?php echo "Student Deleted"; ?>
				</div><?php
			}
			else
				// Outputi nese ndodh naj gabim gjat fshirjes
			{?>
				<div class="isa_error">
				<i class="fa fa-warning"></i>
					<?php echo "Error Occurred ".mysqli_error($link); ?>
				</div><?php
			}
        }
    }
?>

<div id = "title">
    <img src="./images/miamilogo.png" alt="Banner" style="width:600px;height:300px;"/>
    <h1>Student Information Database:</h1>
</div>

<?php

//	Krijimi i queryt per databaz
$query = "SELECT first_name, last_name, email, street_name, city,country,
phone,d_day, d_month, d_year,gender, student_id FROM students ORDER BY student_id,first_name, last_name";

// Marrja e pergjigjes nga databaza duke derguar lidhjen dhe queryn
$response = @mysqli_query($conn, $query);

// nese query ekzekutohet mir
if($response){
    //	Outputi i numrit te studenteve me te dhena
    $num_rows = mysqli_num_rows($response);
    echo "<p align='center'><font face = 'Architects Daughter' size='4pt'><i> * $num_rows student records fetched! </i></font></p>";


    echo '<table class = "studentinfo" align="center" cellpadding="8">

    <tr><td align="left"><font face = "Architects Daughter" size="3"><b>Id</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>First Name</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Last Name</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Email</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Street</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>City</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Country</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Phone</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Birth Date</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Gender</b></font></td>';


    // Kthe nje rresht te te dhenave nga query derisa t'mos ket te dhena tjera
    while($row = mysqli_fetch_array($response)){
        echo '<tr><td align="left">' . 
        $row['student_id'] . '</td><td align="left">' . 
        $row['first_name'] . '</td><td align="left">' . 
        $row['last_name'] . '</td><td align="left">' .
        $row['email'] . '</td><td align="left">' .
        $row['street_name'] . '</td><td align="left">' . 
        $row['city'] . '</td><td align="left">' .
        $row['country'] . '</td><td align="left">' . 
        $row['phone'] . '</td><td align="left">' .
        $row['d_month'] ." ".$row['d_day'] .", ".$row['d_year'] .'</td><td align="left">'.
        $row['gender'] . '</td><td align="left">';
        ?>

        <!-- eventat ne form qendrojn ne faqe -->
        <form method="post" action="">
            <!-- Butonai fshehur ruan id specifike te studentit -->
            <td><input type="hidden" id = "student_id" name="student_id" value="<?php echo $row['student_id']; ?>" /></td>
            <!-- butoni delete -->
            <td><input type="submit" name="delete" class="deleteButton" value="Delete" onclick="return confirm('Are you sure?')" /></td>
        </form>

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

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
    <title>Fetch Profesor's Data</title>
    <link rel="shortcut icon" type="image/png" href="./pictures/westmount.png"/>
    </head>
    <body>

    <!-- Butoni per me shtu student ne databaz -->
    <table align="center" cellspacing = "8">
    <tr>
        <td align>
        <form  method="post">
            <a href="admin.php"><input type="button" name="go"  class="redirectButton" value="Home" /></a>
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

if (isset($_POST['profesor_id'])) {
        $profesor_id = $_POST['profesor_id'];
        if (isset($_POST['delete'])) {
            $sql = "DELETE FROM profesors WHERE profesor_id = " . $profesor_id;
			
		    if (mysqli_query($conn, $sql))
			{?>
				<!-- Outputi pas fshirjes -->
				<div class="isa_success">
				<i class="fa fa-check"></i>
					<?php echo "Profesor Deleted"; ?>
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
?>

<div id = "title">
    <img src="./images/miamilogo.png" alt="Banner" style="width:600px;height:300px;"/>
    <h1>Profesor Information Database:</h1>
</div>

<?php

//	Krijimi i queryt per databaz
$query = "SELECT * FROM profesors ";

// Marrja e pergjigjes nga databaza duke derguar lidhjen dhe queryn
$response = @mysqli_query($conn, $query);

// nese query ekzekutohet mir
if($response){
    //	Outputi i numrit te studenteve me te dhena
    $num_rows = mysqli_num_rows($response);
    echo "<p align='center'><font face = 'Architects Daughter' size='4pt'><i> * $num_rows records fetched! </i></font></p>";


    echo '<table class = "studentinfo" align="center" cellpadding="8">

    <tr><td align="left"><font face = "Architects Daughter" size="3"><b>Id</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>First Name</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Last Name</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Email</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Phone</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Subject 1</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Subject 2</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Subject 3</b></font></td>';

    $profesorId = $_SESSION['id'];
    $subjectQuery = "select P.first_name,S.subject_name
                    from Teachs T, Subjects S, Profesors P
                    where T.profesor_id = P.profesor_id and T.subject_id = S.subject_id and P.profesor_id=$profesorId";


    // Kthe nje rresht te te dhenave nga query derisa t'mos ket te dhena tjera
    while($row = mysqli_fetch_array($response)){
        echo '<tr><td align="left">' . 
        $row['profesor_id'] . '</td><td align="left">' . 
        $row['first_name'] . '</td><td align="left">' . 
        $row['last_name'] . '</td><td align="left">' .
        $row['email'] . '</td><td align="left">' .
        $row['phone'] . '</td><td align="left">'.
        "test1" . '</td><td align="left">'.
        "test2" . '</td><td align="left">'.
        "test3" . '</td><td align="left">';
        ?>

        <!-- eventat ne form qendrojn ne faqe -->
        <form method="post" action="">
            <!-- Butonai fshehur ruan id specifike te studentit -->
            <td><input type="hidden" id = "student_id" name="profesor_id" value="<?php echo $row['profesor_id']; ?>" /></td>
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

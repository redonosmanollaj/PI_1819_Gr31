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
            <a href="admin.php"><input type="button" name="go"  class="redirectButton" value="Home" /></a>
            <a href="index.html"><input type="button" name="go"  class="redirectButton" value="Log Out" /></a>
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

if (isset($_POST['messageid'])) {
    $messageid = $_POST['messageid'];
    if (isset($_POST['delete'])) {
        $sql = "DELETE FROM messages WHERE messageid = " . $messageid;
        //	Note that the $dbc variable is from the required .php file included
        if (mysqli_query($conn, $sql))
       {?>
           <!-- Outputs success message for deletion -->
           <div class="isa_success">
           <i class="fa fa-check"></i>
               <?php echo "Message Deleted"; ?>
           </div><?php
        }
        else
           // Outputs error message for failure of deletion
       {?>
           <div class="isa_error">
           <i class="fa fa-warning"></i>
               <?php echo "Error Occurred ".mysqli_error($conn,$link); ?>
           </div><?php
        }
    }
}

?>

<div id = "title">
    <img src="./images/miamilogo.png" alt="Banner" style="width:600px;height:300px;"/>
    <h1>MESSAGES:</h1>
</div>

<?php

//	Krijimi i queryt per databaz
$query = "SELECT * from messages;";

// Marrja e pergjigjes nga databaza duke derguar lidhjen dhe queryn
$response = @mysqli_query($conn, $query);

// nese query ekzekutohet mir
if($response){
    //	Outputi i numrit te studenteve me te dhena
    $num_rows = mysqli_num_rows($response);
    echo "<p align='center'><font face = 'Architects Daughter' size='4pt'><i> * $num_rows message records fetched! </i></font></p>";


    echo '<table class = "studentinfo" align="center" cellpadding="8">

    <tr><td align="left"><font face = "Architects Daughter" size="3"><b>Full Name</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Email</b></font></td>
    <td align="left"><font face = "Architects Daughter" size="3"><b>Message</b></font></td>';


    // Kthe nje rresht te te dhenave nga query derisa t'mos ket te dhena tjera
    while($row = mysqli_fetch_array($response)){
        echo '<tr><td align="left">' . 
        $row['name'] . '</td><td align="left">' . 
        $row['email'] . '</td><td align="left">' . 
        $row['content'] . '</td><td align="left">';
        ?>

        <!-- eventat ne form qendrojn ne faqe -->
        <form method="post" action="">
            <!-- Butonai fshehur ruan id specifike te studentit -->
            <td><input type="hidden" id = "messageid" name="messageid" value="<?php echo $row['messageid']; ?>" /></td>
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
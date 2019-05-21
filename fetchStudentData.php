<?php


if(session_start() == PHP_SESSION_NONE) {
    session_start();
}

//Parandalimi i qasjes direkte ne databaz pa u kyqur
if(isset($_SESSION['credentialsEntered'])) {
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css">
        <title>Fetch Student Data</title>
        <!-- CSS/foto ... -->

    </head>
    <body>
        <!-- Butonat per me shtu student ne databaz -->
        <table cellspacing = "8">
            <tr>
                <td>
                <form action="./addNewStudent.php" method="post">
                    <input type="submit" name="go" class="redirectButton" value="Add Student to Database">
                </td>
            </tr>
                </form> 
        </table>

        <?php
        //lidhja me databaz
        require_once('dbconfig.php');
        
        //fshirja pi databaze nese butoni esht kliku
        if(isset($_POST['student_id'])) {
            $student_id = $_POST['student_id'];
            if(isset($_POST['delete'])){
                $sql = "DELETE FROM students WHERE student_id = ". $student_id;
                if(mysqli_query($dbc, $sql)){
                    ?>
                    <div class="isa_success">
                        <i class="fa fa-check"></i>
                        <?php echo "Student Deleted"; ?>
                    </div>
                    <?php
                }
                else {
                    ?>
                    <div class="isa_error">
                        <i class="fa fa-warning"></i>
                        <?php echo "Error Ocurred ".mysqli_error($link); ?>
                    </div>
                    <?php
                }
            }
        }
        ?>
        <div id="title">
            <h1>Student Infromation Database:</h1>
            <img src="" alt="Banner" style="width: 600px; height: 100px;" />
        </div>
        
        <?php
        //query
        $query = "SELECT first_name, last_name, gender, email, street_type, city, postal_code,
        phone, course, dob_day, dob_month, dob_year, student_id FROM students ORDER BY last_name, first_name";

        //pergjigja nga databaza duke derguar connection dhe query
        $response = @mysqli_query($dbc, $query);

        if($response) {
            $num_rows = mysqli_num_rows($response);
            echo "<p align='center'><font face='Architects Daughter' size='4pt'><i> * $num_rows student records fetched! </i></font></p>";
            
            echo '<table class = "studentinfo" align="center" cellpadding="8">
                <tr><td align="left"><font face = "Architects Daughter" size="3"><b>Last Name</b></font></td>
                <td align="left"><font face = "Architects Daughter" size="3"><b>First Name</b></font></td>
                <td align="left"><font face = "Architects Daughter" size="3"><b>Gender</b></font></td>
                <td align="left"><font face = "Architects Daughter" size="3"><b>Email</b></font></td>
                <td align="left"><font face = "Architects Daughter" size="3"><b>Street</b></font></td>
                <td align="left"><font face = "Architects Daughter" size="3"><b>City</b></font></td>
                <td align="left"><font face = "Architects Daughter" size="3"><b>Postal Code</b></font></td>
                <td align="left"><font face = "Architects Daughter" size="3"><b>Phone</b></font></td>
                <td align="left"><font face = "Architects Daughter" size="3"><b>Birth Date</b></font></td>
                <td align="left"><font face = "Architects Daughter" size="3"><b>Course Code</b></font></td></tr>';

                //kthimi i nje rreshti me te dhena nga query perderisa te gjitha fushat jane te plotesuara
                while($row = mysqli_fetch_array($response)) {
                    echo '<tr><td align="left">' .
                    $row['last_name'] . '</td><td align="left">'.
                    $row['first_name'] . '</td><td align="left">'.
                    $row['gender'] . '</td><td align="left">' . 
                    $row['email'] . '</td><td align="left">' . 
                    $row['street_name'] ." ".$row['street_type'].'</td><td align="left">' .
                    $row['city'] . '</td><td align="left">' . 
                    $row['postal_code'] . '</td><td align="left">' . 
                    $row['phone'] . '</td><td align="left">' .
                    $row['dob_month'] ." ".$row['dob_day'] .", ".$row['dob_year'] .'</td><td align="left">'.
                    $row['course'] . '</td><td align="left">';
        ?>

        <form action="" method="post">
            <td><input type="hidden" id="student_id" name="student_id" value="<?php echo $row['student_id']; ?>" /></td>
            <td><input type="submit" name="delete" class="deleteButton" value="Delete" onclick="return confirm('Are you sure?')" /></td>
        </form>

        <?php
        echo '</tr>';
                }
                echo '</table>';
            }

            else {
                echo "Couldn't issue database query<br />";
                echo mysqli_error($dbc);
            }

            mysqli_close($dbc);
        }
        else{
            require_once('login.php');
        }
        ?>




                }
        }

    </body>
</html>
    }
<?php
// funksion per normalizim te tekstit, varesisht nga parametri $numbers(true or false)
// caktojme tekstin a do te jete me numra apo pa numra
// Poashtu kthen tekstin me shkronjen e pare te madhe dhe pa hapesira
function normalizeText($str,$numbers){
    if($numbers==false){
        $str = preg_replace("/[^-'a-zA-Z]/","",$str);
    }
    else{
        $str = preg_replace("/[^-'0-9a-zA-Z]/","",$str);
    }

    $firstLetter = substr($str,0,1);
    $otherPart = substr($str,1);
    $firstLetter = strtoupper($firstLetter);

    $str = $firstLetter.$otherPart;
    return trim($str);
}

function checkEmail($email){
    if(filter_var($email,FILTER_VALIDATE_EMAIL)===false){
        throw new Exception('Invalid email!');
    }
    return true;
}

function checkPhone($phone){
    if(!(preg_match("/\d{9}/",$phone))){
        throw new Exception('Invalid phone number!');
    }

    return true;
}

$subjects = array("Mathematics 1","Physics 1","Foundamentals of Electrothechnics","Programming Language","English","Electric Circuits","Physiscs 2","Mathematics 2","Digital Circuits","Algorithms");


if(isset($_POST['submit'])){
    $data_missing = array();
    $data_changed = array();

    // validimi i emrit
    if(empty($_POST['first_name'])){
        $data_missing[] = 'First Name';
        $nameError = "* First Name missing!";
    }
    else{
        $first_name = trim($_POST['first_name']);
        $temp = $first_name;

        $first_name = normalizeText($first_name,false);
        $nameError = "";

        if($temp != $first_name){
            $data_changed[] = 'First Name';
            if($first_name == ""){
                $data_missing[] = 'First Name';
                $nameError = "* First Name missing!";
            }
        }
    }

    // validimi i mbiemrit
    if(empty($_POST['last_name'])){
        $data_missing[] = 'Last Name';
        $lastNameError = "* Last Name missing!";
    }
    else{
        $last_name = trim($_POST['last_name']);
        $temp = $last_name;
        $last_name = normalizeText($last_name, false);

        $lastNameError = "";

        if($temp != $last_name){
            $data_changed[] = 'Last Name';
            if($last_name == ""){
                $data_missing[] = 'Last Name';
                $lastNameError = "* Last Name missing!";
            }
        }
    }

    // validimi i emailit
    if(empty($_POST['email'])){
        $data_missing[] = 'Email';
        $emailError = "* Email missing!";
    }
    else{
        $email = trim($_POST['email']);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        try{
            checkEmail($email);
            $emailError = "";
        }catch(Exception $e){
            $data_missing[] = 'Email';
            $emailError = '* Error: '.$e->getMessage()."<br><br>";
        }
    }


    if(!empty($_POST['subject1'])){
        $subject1 = $_POST['subject1'];
        $subject1Id = array_search($subject1,$subjects)+1;
    }else{
        $subject1Id=null;
    }

    if(!empty($_POST['subject2'])){
        $subject2 = $_POST['subject2'];
        $subject2Id = array_search($subject2,$subjects)+1;
    }else{
        $subject2Id = null;
    }

    if(!empty($_POST['subject3'])){
        $subject3 = $_POST['subject3'];
        $subject3Id = array_search($subject3,$subjects)+1;
    }else{
        $subject3Id = null;
    }

        //validimi i numrit te telefonit

        if(empty($_POST['phone'])){
            $data_missing[] = 'Phone Number';
            $phoneError = "* Phone Number missing!";
    
        }
        else{
            $phone = trim($_POST['phone']);
    
            try{
                checkPhone($phone);
                $phoneError="";
            }
            catch(Exception $e){
                $data_missing[] = 'Phone Number';
                $phoneError = '* Error: '.$e->getMessage()."<br><br>";
            }
        }


    // add to database nese fushat jane te mbushura
    if(empty($data_missing)){
        
        require_once('dbconfig.php');

        $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }


        $query = "INSERT INTO profesors(first_name,last_name,email,phone)
        VALUES(?,?,?,?)";

        $statement = $conn->prepare($query);
        $statement->bind_param("ssss",$first_name,$last_name,$email,$phone);

        $statement->execute();

        $rows = $statement->affected_rows;

        if($rows == 1){
            echo '<script type="text/javascript">';
            echo 'alert("Profesor added successfuly!")';
            echo '</script>';
        }
        else{
            echo '<script type="text/javascript">';
            echo 'alert("Profesor added failed! ".$conn->error())';
            echo '</script>';
        }

        $query = "INSERT INTO users(username,password,role) values (?,?,?)";
        $idQuery = "SELECT profesor_id FROM profesors where profesor_id = (select max(profesor_id) from profesors)";
        
        $result = $conn->query($idQuery);
        $row = $result->fetch_array();
        $id = $row['profesor_id'];

        $phoneQuery = "SELECT phone FROM profesors WHERE profesor_id=$id";
        $result = $conn->query($phoneQuery);
        $row = $result->fetch_array();
        $phone = $row['phone'];

        $role = "profesor";

        $hash = password_hash($phone,PASSWORD_DEFAULT);

        $statement = $conn->prepare($query);
        $statement->bind_param("iss",$id,$hash,$role);

        $statement->execute();

        // INSERT per insertimin e lendes

        $subjectQuery = "INSERT INTO Teachs(profesor_id,subject_id) VALUES($id,?);";
        $stm = $conn->prepare($subjectQuery);
        for($i=1;$i<=3;$i++){
            $stm->bind_param("i",${"subject$i"."Id"});
            $stm->execute();
        }

        $stm->close();
        $statement->close();
        $conn->close();

    }
    else{
        if(!isset($first_name)){
            $first_name = "";
        }
        if(!isset($last_name)){
            $last_name = "";
        }
        if(!isset($email)){
            $email="";
        }
        if(!isset($phone)){
            $phone="";
        }
        if(!isset($subject1)){
            $phone="";
        }
        if(!isset($subject2)){
            $phone="";
        }
        if(!isset($subject3)){
            $phone="";
        }
    }
}

if(isset($_POST['erase']) or (empty($data_missing))){
    $first_name="";
    $last_name="";
    $email="";
    $phone="";
    $subject1="";
    $subject2="";
    $subject3="";



    $nameError="";
    $lastNameError="";
    $emailError="";
    $phoneError="";
    $subject1Error="";
    $subject2Error="";
    $subject3Error="";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="StyleSheet" href="css/registration-design.css" />
    <link rel="StyleSheet" href="css/message-design.css" />
    <title>Add New Student</title>
</head>
<body>



<table align="center" cellspacing = "8">
<tr><td align>
    <a href="admin.php"><input type="button" name="go"  class="redirectButton" value="Home" /></a>
    <a href="index.html"><input type="button" name="go"  class="redirectButton" value="Log Out" /></a>
</table>

<div id="studentWrapper">
<div id = "title">
<h1>Add a New Profesor:</h1>
</div>

<form action="addProfesor.php" method="post">


<table align="center"
cellspacing="8">

<!-- First name, with error message -->
<tr><td align="left"><p><font face = "Arial" size="4" ><b>First Name:</b></font></td>
<td align ="left"><input type="text" name="first_name" value = "<?php echo $first_name; ?>" size="30" maxlength="30" class = "inputs" /></p></td>
<td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $nameError ?></font> </td></tr>

<!-- Last name, with error message -->
<tr><td align="left"><p><font face = "Arial" size="4"><b>Last Name:</b></font></td>
<td align ="left"><input type="text" name="last_name" value = "<?php echo $last_name; ?>" size="30" maxlength="30" class = "inputs" /></p></td>
<td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $lastNameError ?></font> </td></tr>

<!-- Email, with error message -->
<tr><td align="left"><p><font face = "Arial" size="4"><b>Email:</b></font></td>
<td align ="left"><input type="text" name="email" value = "<?php echo $email; ?>" size="30" maxlength="30" class = "inputs" /></p></td>
<td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $emailError ?></font> </td></tr>

<tr><td align="left"><p><font face = "Arial" size="4"><b>Phone Number:</b></font></td>
<td align ="left"><input type="text" name="phone" size="30" value = "<?php echo $phone; ?>" maxlength = "14" value="" class = "inputs" /></p></td>
<td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $phoneError ?></font> </td> </tr></tr>


<tr><td align="left"><p>
    <font face = "Arial" size="4"><b><label for= "course"> Subject 1:</label></b></font></td>
<td align ="left"><select name="subject1" class = "inputs">
	
	<option value=""></option>
	<option value = "" disabled> - Subject 1 - </option>
<?php

foreach($subjects as $subject){
    ?><option value="<?php echo $subject; ?>"><?php echo $subject; ?></option><?php
}

?>
</select>
</tr>


<tr><td align="left"><p>
    <font face = "Arial" size="4"><b><label for= "course"> Subject 2:</label></b></font></td>
<td align ="left"><select name="subject2" class = "inputs">
	
	<option value=""></option>
	<option value = "" disabled> - Subject 2 - </option>
<?php

foreach($subjects as $subject){
    ?><option value="<?php echo $subject; ?>"><?php echo $subject; ?></option><?php
}

?>
</select>
</tr>


<tr><td align="left"><p>
    <font face = "Arial" size="4"><b><label for= "course"> Subject 3:</label></b></font></td>
<td align ="left"><select name="subject3" class = "inputs">
	
	<option value=""></option>
	<option value = "" disabled> - Subject 3 - </option>
<?php

foreach($subjects as $subject){
    ?><option value="<?php echo $subject; ?>"><?php echo $subject; ?></option><?php
}

?>
</select>
</tr>


<table align="center">
<tr><td align="middle"><p>
<!-- Submits entered information and redirects to addNewStudent.php -->
<input type="submit" name="submit" class="submitButton" value="Send" />
<!-- Clears fields; has a confirmation pop-up -->
<!-- This is not a normal reset button and is in fact a submit button, but triggers a function to clear values from variables as mentioned." -->
<input type="submit" name="erase" onclick="return confirm('Are you sure?')" class="submitButton" value="Reset" /></p></td></tr>
</table>

</table>

</form>




</body>
</html>
<?php

if(session_status()== PHP_SESSION_NONE){
    session_start();
}

if(isset($_SESSION['adminLoggedin'])){


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

function checkMonthLimit($month,$year){
    if($month == "FEB"){
        if($year%4 == 0){
            $limit = 30;
        }else{
            $limit = 29;
        }
    }
    else if($month == "SEP" OR $month == "APL" or $month == "JUN" or $month == "NOV"){
        $limit = 31;
    }
    else{
        $limit = 32;
    }

    return $limit;
}


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

    // validimi i adreses
    if(empty($_POST['street_name'])){
        $data_missing[] = 'Street Name';
        $streetError = "* Street Name missing!";
    }
    else{
        $street_name = trim($_POST['street_name']);
        $temp = $street_name;

        $street_name = normalizeText($street_name, true);

        $streetError = "";

        if($temp != $street_name){
            $data_changed[] = 'Street Name';
            if($street_name == ""){
                $data_missing[] = 'Street Name';
                $streetError = "* Street Name missing!";
            }
        }
    }

    //validimi i qytetit
    if(empty($_POST['city'])){
        $data_missing[] = 'City';
        $cityError = "* City missing!";
    }
    else{
        $city = trim($_POST['city']);
        $temp = $city;

        $city = normalizeText($city,false);

        $cityError = "";

        if($temp!=$city){
            $data_changed[] = 'City';
            if($city==""){
                $data_missing[] = 'City';
                $cityError = "* City missing!";
            }
        }
    }

    // validimi i shtetit
    if(empty($_POST['country'])){
        $data_missing[] = 'Country';
        $countryError = "* Country missing!";
    }
    else{
        $country = trim($_POST['country']);
        $temp = $country;

        $country = normalizeText($country,false);

        $countryError = "";

        if($temp!=$country){
            $data_changed[] = 'Country';
            if($country==""){
                $data_missing[] = 'Country';
                $countryError = "* Country missing!";
            }
        }
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

    //validimi i gjinise

    if(empty($_POST['gender'])){
        $data_missing[] = 'Gender';
        $genderError = "* Gender missing!";

    }
    else{
        $gender = $_POST['gender'];
        $genderError = "";
    }

    // validimi i dates se lindjes
    if(empty($_POST['day'])){
        $data_missing[]='Day';
        $dayError = "Day missing!";
    }
    else{
        $day=$_POST['day'];
        $dayError="";
    }

    if(empty($_POST['month'])){
        $data_missing[] = "Month";
        $monthError = "Month missing!";
    }
    else{
        $month = $_POST['month'];
        $monthError = "";
    }

    if(empty($_POST['year'])){
        $data_missing[] = "Year";
        $yearError = "Year missing!";
    }
    else{
        $year = $_POST['year'];
        $yearError="";
    }



    // add to database nese fushat jane te mbushura
    if(empty($data_missing)){
        
        require_once('dbconfig.php');

        $conn = new mysqli(HOST,USERNAME,PASSWORD,DBNAME);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }


        $query = "INSERT INTO students (first_name,last_name,email,street_name,city,country,phone,d_day,d_month,d_year,gender)
        VALUES(?,?,?,?,?,?,?,?,?,?,?)";

        $statement = $conn->prepare($query);
        $statement->bind_param("sssssssisis",$first_name,$last_name,$email,$street_name,$city,$country,$phone,$day,$month,$year,$gender);

        $statement->execute();

        $rows = $statement->affected_rows;

        if($rows == 1){
            echo '<script type="text/javascript">';
            echo 'alert("Student added successfuly!")';
            echo '</script>';
        }
        else{
            echo '<script type="text/javascript">';
            echo 'alert("Student added failed! ".$conn->error())';
            echo '</script>';
        }

        $query = "INSERT INTO users(username,password,role) values (?,?,?)";
        $idQuery = "SELECT student_id FROM students where student_id = (select max(student_id) from students)";
        
        $result = $conn->query($idQuery);
        $row = $result->fetch_array();
        $id = $row['student_id'];

        $phoneQuery = "SELECT phone FROM students WHERE student_id=$id";
        $result = $conn->query($phoneQuery);
        $row = $result->fetch_array();
        $phone = $row['phone'];

        $role = "student";

        $hash = password_hash($phone,PASSWORD_DEFAULT);

        $statement = $conn->prepare($query);
        $statement->bind_param("iss",$id,$hash,$role);

        $statement->execute();

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
        if(!isset($street_name)){
            $street_name="";
        }
        if(!isset($city)){
            $city="";
        }
        if(!isset($country)){
            $country="";
        }
        if(!isset($phone)){
            $phone="";
        }
        if(!isset($day)){
            $day="";
        }
        if(!isset($month)){
            $month="";
        }
        if(!isset($year)){
            $year="";
        }
        if(!isset($gender)){
            $gender="";
        }
    }
}

if(isset($_POST['erase']) or (empty($data_missing))){
    $first_name="";
    $last_name="";
    $email="";
    $street_name="";
    $city="";
    $country="";
    $phone="";
    $day="";
    $month="";
    $year="";
    $gender="";

    $nameError="";
    $lastNameError="";
    $emailError="";
    $streetError="";
    $cityError="";
    $countryError="";
    $phoneError="";
    $dayError="";
    $monthError="";
    $yearError="";
    $genderError="";
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
<h1>Add a New Student:</h1>
</div>

<form action="addStudent.php" method="post">


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

<!-- Street name & type -->
<!-- Name is fed in via input box -->
<tr><td align="left"><p>
    <font face = "Arial" size="4"><b><label for= "street"> Street:</label></b></font></td>
	
    <td align ="left">
	<input type="text" name="street_name" value = "<?php echo $street_name; ?>" size="30" maxlength="30" class = "inputs" />
    <td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $streetError ?></font> </td></tr>

<!-- Dropdown selection for street type -->

<!-- Outputs error message for street fields (name & type) -->

<!-- City, with error message -->
<tr><td align="left"><p><font face = "Arial" size="4"><b>City</b></font></td>
<td align ="left"><input type="text" name="city" value = "<?php echo $city; ?>" size="30" maxlength="30" class = "inputs" /></p></td>
<td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $cityError ?></font> </td></tr>

<!-- Country, with error message -->
<tr><td align="left"><p><font face = "Arial" size="4"><b>Country</b></font></td>
<td align ="left"><input type="text" name="country" value = "<?php echo $country; ?>" size="30" maxlength="30" class = "inputs" /></p></td>
<td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $countryError ?></font> </td></tr>



<!-- Phone number, with error message -->
<tr><td align="left"><p><font face = "Arial" size="4"><b>Phone Number:</b></font></td>
<td align ="left"><input type="text" name="phone" size="30" value = "<?php echo $phone; ?>" maxlength = "14" value="" class = "inputs" /></p></td>
<td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $phoneError ?></font> </td> </tr></tr>

<!-- Dropdown selection for date of birth (proxy for age) -->
<tr><td align="left"><p>
    <font face = "Arial" size="4"><b><label for= "course"> Date of Birth:</label></b></font></td>

	<!-- Broken down into three separate dropdowns -->
	<!-- Month -->
    <td align ="left"><select name="month" class = "inputs">
	
	<option value=""></option>
	<option value = "" disabled> - Month - </option>
	
	<?php
    foreach(array(
	"JAN"   => "JAN",
	"FEB"   => "FEB",
	"MAR"   => "MAR",
	"APR"   => "APR",
	"MAY"   => "MAY",
	"JUN"   => "JUN",
	"JUL"   => "JUL",
	"AUG"   => "AUG",
	"SEP"   => "SEP",
	"OCT"   => "OCT",
	"NOV"   => "NOV",
	"DEC"   => "DEC"
    ) as $key => $val){
		//	Remembers what option is used between rounds with some incorrect or missing data input
        ?><option value="<?php echo $key; ?>"<?php
            if($key==$month)echo ' selected="selected"';
        ?>><?php echo $val; ?></option><?php
    }
	?>
</select>

<!-- Day (1 - 31 [max], inclusive) -->
<select name="day" class = "inputs">
	<option value=""></option>
	<option value = "" disabled> - Day - </option>
	<?php
	
	//	Sets the number of days (+1, for < inequality), depending on the user month and year (31 by default)
	$limit = CheckMonthLimit($b_month, $b_year);
	
	//	Remembers what option is used between rounds with some incorrect or missing data input
	for($i = 1; $i < $limit; $i++){ ?>
	  <option value="<?php echo $i ?>"<?php
            if($i==$day)echo ' selected="selected"';
        ?>><?php echo $i; ?></option><?php
    }
	?>
</select>

<!-- Year (upwards from 1990 to the present year - 10 -->
<!-- Basically encompasses birth years for current HS students with some generous wiggle room -->
<select name="year" class = "inputs">
	<option value=""></option>
	<option value = "" disabled> - Year - </option>
	<?php
	//	Ages of 10 - 25 (currently for range of 1991 - 2006); will be used to submit student information
	//	Remembers what option is used between rounds with some incorrect or missing data input
	for($i = date("Y")-25; $i < date("Y")-9; $i++){ ?>
	  <option value="<?php echo $i ?>"<?php
            if($i==$year)echo ' selected="selected"';
        ?>><?php echo $i; ?></option><?php
    }
	?>
</select>
<td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $dayError." ".$monthError." ".$yearError ?></font> </td>

</tr>

<!-- Outputs error message for all DOB fields (month, day, year), taking number of related fields, if any, into account  -->


<!-- Gender of student -->
<!-- Note: Sex refers to the biological and physiological characteristics that define men and women. 
Gender refers to the roles and attributes that society considers appropriate for men and women. -->
<!-- 3 options: traditional M & F and Oth for 'Other' -->
<tr><td align="left"><p>
    <font face = "Arial" size="4"><b><label for= "gender"> Gender:</label></b></font></td>
    <td align ="left"><select name="gender" class = "inputs">
	<option value=""></option>
	<?php
    foreach(array(
	"M"   => "M",
	"F"   => "F",
    ) as $key => $val){
		//	Remembers what option is used between rounds with some incorrect or missing data input
        ?><option value="<?php echo $key; ?>"<?php
            if($key==$gender)echo ' selected="selected"';
        ?>><?php echo $val; ?></option><?php
    }
	?>
    </select>
</p></td>
<td align = "middle"> <font face = "Arial" size="4" color="red"><?php echo $genderError ?></font> </td></tr>

<!-- Course student can choose; can only choose one -->
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

<?php
}
else{
    require_once('logout.php');
}
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Sofia' rel='stylesheet' type='text/css'>
<link href='login.css' rel='stylesheet' type='text/css'>

<body>
<div class='login'>
<?php
// define variables and set to empty values
$name = $email  = $agree = $checkSunday = $checkSunday = $checkTuesday = $checkWednesday = $checkThursday = $checkFriday = $checkSaturday = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["username"]);
  $email = test_input($_POST["email"]);
  $checkSunday = test_input($_POST["checkSunday"]);
  $checkMonday = test_input($_POST["checkMonday"]);
  $checkTuesday = test_input($_POST["checkTuesday"]);
  $checkWednesday = test_input($_POST["checkWednesday"]);
  $checkThursday = test_input($_POST["checkThursday"]);
  $checkFriday = test_input($_POST["checkFriday"]);
  $checkSaturday = test_input($_POST["checkSaturday"]);
  $agree = test_input($_POST["agree"]);
  $from = test_input($_POST["from"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// TODO: Read Server Information from a secure file
//$fh = fopen('filename.txt','r');
//while ($line = fgets($fh)) {
  // <... Do your work with the line ...>
  // echo($line);
//}
//fclose($fh);
$servername = "ec2-52-33-221-59.us-west-2.compute.amazonaws.com:3306";
$username = "db_write";
$password = "19JAN1983";

// Create connection
$conn = mysqli_connect($servername, $username, $password,"PrayerTeam");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$setSunday = $setMonday = $setTuesday = $setWednesday = $setThursday = $setFriday = $setSaturday = "false";
if ($checkSunday == "Sunday") {
$concat="Sunday,";
$setSunday="true";
$bool="true,";
}
if ($checkMonday == "Monday") {
$concat=$concat."Monday,";
$setMonday="true";
$bool=$bool."true,";
}
if ($checkTuesday == "Tuesday") {
$concat=$concat."Tuesday,";
$setTuesday="true";
$bool=$bool."true,";
}
if ($checkWednesday == "Wednesday") {
$concat=$concat."Wednesday,";
$setWednesday="true";
$bool=$bool."true,";
}
if ($checkThursday == "Thursday") {
$concat=$concat."Thursday,";
$setThursday="true";
$bool=$bool."true,";
}
if  ($checkFriday == "Friday") {
$concat=$concat."Friday,";
$setFriday="true";
$bool=$bool."true,";
}
if ($checkSaturday == "Saturday") {
$concat=$concat."Saturday,";
$setSaturday="true";
$bool=$bool."true,";
}

if ($from == "fromLogin") {
$sql = "update subscribers set Sunday=$setSunday, Monday=$setMonday, Tuesday=$setTuesday, Wednesday=$setWednesday, Thursday=$setThursday, Friday=$setFriday, Saturday=$setSaturday where email='$email'"; 
}
else {
 		$salt = 'AmazingGrace';
 		$pw_hash = sha1($email.$salt).dechex(time());
 		$url="http://prayerteamseasbothell.org/activate.php?id=".$pw_hash;
		$sql = "insert into subscribers ($concat name,email,code) values($bool'$name','$email','$pw_hash');";
		$subject = "Verification Required to Activate Prayer Team Subscription";
   		$body = "Hello $name,\n Thanks for your request to subscribe to Prayer Reminders.Please click link below to activate your";
		$body = "<html><font color=\"blue\">Hello $name,<br> Thanks for your request to subscribe to Prayer Reminders.<br>Please click link below to activate your subscription.<br>";
   		$body=$body."<a href=\"$url\">Click Here</a><br>Thanks,<br>Your Prayer Captain.";
   	 	$headers = "From: prayerteam@easbothell.org \r\n";
		$headers .= "Reply-To: prayerteam@easbothell.org \r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
 if (mail($email, $subject, $body,$headers)) {
	$emailSent=1;
  } else {
    $emailSent=0;
  }
}



if ($conn->query($sql) === TRUE) { 
	if ($from == "fromLogin") {
		echo "<h6> Thank You " .$name ." for updating " . $email . " to receive emails. You will receive Prayer reminders on the following day(s):";
		error_log(date(DATE_RFC822), 3,"/tmp/php.log") ;
    	error_log("Successfully updated data for $name, $email \n", 3, "/tmp/php.log");
		$concat = rtrim($concat, ',');
		echo "<h6>$concat";
		echo "<br><a href=\"http://prayerteamseasbothell.org\">Back</a>";
		}
		else {
			if ( $emailSent == 1 ) {
			echo "<h6> Thank You " . $name . " An email with activation link has been sent to $email. <br>";
			echo "<h6> Please click on the link in email to activate your subscription. ";
			error_log(date(DATE_RFC822), 3,"/tmp/php.log") ;
    		error_log("Successfully inserted data for $name, $email \n", 3, "/tmp/php.log");
			$concat = rtrim($concat, ',');
			echo "<h6>$concat";
			echo "<br><a href=\"http://prayerteamseasbothell.org\">Back</a>";
		   						}
		   	else   {
		   	echo "<h6> Unable to send email to $email. Please check email and try again.<h6>";
		   	echo "<br><a href=\"http://prayerteamseasbothell.org\">Back</a>";
		   			 }
		
    		} 
     }	
else {
    echo  "<br><h4>" . $conn->error; // Write to the log with the data.
    error_log("Sql used for $email is $sql \n", 3, "/tmp/php.log");
	error_log( date(DATE_RFC822) , 3,"/tmp/php.log") ;		
    error_log("Error message: $conn->error :", 3, "/tmp/php.log");
    error_log("Data: $email: name\n", 3, "/tmp/php.log");
    echo "<br><a href=\"http://prayerteamseasbothell.org\">Back</a>";
}

//catch (Exception $e) {
    // not a MySQL exception
//    $e->getMessage();
//}

$conn->close();


?>
</div>

<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Sofia' rel='stylesheet' type='text/css'>
<link href='login.css' rel='stylesheet' type='text/css'>

<body>
<div class='login'>
<?php
if( $_GET["id"] ){
   $code=$_GET['id'];
   $servername = "ec2-52-33-221-59.us-west-2.compute.amazonaws.com:3306";
   $username = "db_write";
   $password = "19JAN1983";

// Create connection
$conn = mysqli_connect($servername, $username, $password,"PrayerTeam");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "update subscribers set confirmed=true where code='$code'"; 

	if ($conn->query($sql) === TRUE) { 
	echo "<h6>Success!!! You will now receive Prayer Reminders. <h6>";
	echo "<br>Ccheck and modify your subscripton <a href=\"http://prayerteamseasbothell.org/checkLogin.php\">here</a>";
	}
	else {
	echo "<h6> Unable to validate your email. Please check validation email and try again.<h6>";
	echo "<br><a href=\"http://prayerteamseasbothell.org\">Back</a>";
	}
	
	
}

else {
 			echo "<h6> Unable to send email to $email. Please check email and try again.<h6>";
		   	echo "<br><a href=\"http://prayerteamseasbothell.org\">Back</a>";
}


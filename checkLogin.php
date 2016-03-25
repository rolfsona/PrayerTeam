<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Sofia' rel='stylesheet' type='text/css'>
<link href='login.css' rel='stylesheet' type='text/css'>
<script type="text/javascript">

function validateMyForm()
{
document.getElementById("emailError").innerHTML = "";
x=document.forms["registerForm"]["email"].value;
if (x.length == 0){
document.getElementById("emailError").innerHTML = "Please Enter Your Email";
return false;
}
else {
    var re = /\S+@\S+\.\S+/;
    if (!re.test(x) ){
    document.getElementById("emailError").innerHTML = "Please Enter a valid Email.";
    return false;
    				}
	}
}

function validateDayForm()
{
x1=document.forms["modifyForm"]["checkSunday"].value;
x2=document.forms["modifyForm"]["checkMonday"].value;
x3=document.forms["modifyForm"]["checkTuesday"].value;
x4=document.forms["modifyForm"]["checkWednesday"].value;
x5=document.forms["modifyForm"]["checkThursday"].value;
x6=document.forms["modifyForm"]["checkFriday"].value;
x7=document.forms["modifyForm"]["checkSaturday"].value;

if (!document.forms["modifyForm"]["checkSunday"].checked  && 
	!document.forms["modifyForm"]["checkMonday"].checked  &&
	!document.forms["modifyForm"]["checkTuesday"].checked  &&
	!document.forms["modifyForm"]["checkWednesday"].checked  &&
	!document.forms["modifyForm"]["checkThursday"].checked  &&
	!document.forms["modifyForm"]["checkFriday"].checked  &&
	!document.forms["modifyForm"]["checkSaturday"].checked ) {
	document.getElementById("dayError").innerHTML = "Please select one day of the week to register.";
   return false;
}
if (!document.forms["modifyForm"]["agree"].checked) {
document.getElementById("dayError").innerHTML = 'Please check "I wish to modify" if you would like to modify registered days.';
return false;
} 

}


</script>
<body>
<?php
// define variables and set to empty values
$email = $name = $sunDay = $monDay =$tuesDay = $wednesDay = $thursDay = $friDay = $saturDay = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $email = test_input($_POST["email"]);
   $servername = "ec2-52-33-221-59.us-west-2.compute.amazonaws.com:3306";
   $username = "db_write";
   $password = "19JAN1983";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"PrayerTeam");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM subscribers where email = '$email'";
$result = $conn->query($sql);
$decide = $result->num_rows;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $name = $row["name"];
        if ($row["Sunday"] == 1) {
        $sunDay = "checked";
        }
        if ($row["Monday"] == 1) {
        $monDay = "checked";
        }
        if  ($row["Tuesday"] == 1) {
        $tuesDay ="checked";
        }
        if ($row["Wednesday"] == 1) {
         $wednesDay = "checked"; 
        }
        if ($row["Thursday"] == 1) {
        $thursDay = "checked";
        }
        if( $row["Friday"] == 1) {
        $friDay = "checked";
        }
		if ( $row["Saturday"] == 1) {
        $saturDay= "checked";
        }
    }
} 
$conn->close();


}

function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>

<form name="registerForm" method="post"  action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' >
<div class='login'>
  <h2>Register</h2>
  <input name='email' placeholder='E-Mail Address *' type='text' >
  <p id="emailError"></p> 
  <input class='animated' type='submit' value='Check'>
  </form>
<?php
if ($decide > 0) {
echo '<form name="modifyForm" method="post" onsubmit=\'return validateDayForm()\' action=welcome.php >';
echo "<br> <br>" .$name . " |  " . $email. "<br>";
echo '<table> <tr> <td> &nbsp;&nbsp;Sunday &nbsp;&nbsp;</td> <td> <div class="slideThree"> <input type="checkbox" value="Sunday" id="slideThree" name="checkSunday"'. $sunDay .'/> <label for="slideThree"></label>  </div> </td>';
echo '<td> &nbsp;&nbsp; Monday &nbsp;&nbsp;</td><td> <div class="slideThree"> <input type="checkbox" value="Monday" id="slideFour" name="checkMonday"'. $monDay.  '/> <label for="slideFour"></label> </div> </td>';
echo '<td> &nbsp;&nbsp; Tuesday &nbsp;&nbsp;</td><td><div class="slideThree"> <input type="checkbox" value="Tuesday" id="slideFive" name="checkTuesday"'. $tuesDay. '/> <label for="slideFive"></label> </div> </td></tr>';
echo '<tr><td> &nbsp;&nbsp; Wednesday &nbsp;&nbsp;</td><td><div class="slideThree"><input type="checkbox" value="Wednesday" id="slideSix" name="checkWednesday"' .$wednesDay .' /> <label for="slideSix"></label></div> </td>';
echo '<td> &nbsp;&nbsp; Thursday &nbsp;&nbsp;</td><td><div class="slideThree"><input type="checkbox" value="Thursday" id="slideSeven" name="checkThursday"' .$thursDay . '/><label for="slideSeven"></label> </div>';
echo '<td> &nbsp;&nbsp; Friday &nbsp;&nbsp;</td><td><div class="slideThree"><input type="checkbox" value="Friday" id="slideEight" name="checkFriday"' .$friDay .' /><label for="slideEight"></label> </div> </td></tr>';
echo '<tr><td></td><center> <td> &nbsp;&nbsp; Saturday &nbsp;&nbsp;</td><td><div class="slideThree"><input type="checkbox" value="Saturday" id="slideNine" name="checkSaturday"' .$saturDay .'/> <label for="slideNine"></label> </div>';
echo '</td> </center> </tr> </table>';
echo '<p id="dayError"></p>';
echo '<input type="hidden" name="username" value="'.$name. '" />';
echo '<input type="hidden" name="email" value="'.$email. '" />';
echo '<input type="hidden" name="from" value="fromLogin" />';
echo '<div class=\'agree\'> <input id=\'agree\' name=\'agree\' type=\'checkbox\' >';
echo '<label for=\'agree\'></label> I wish to modify registered days for mail subscription</div>';
echo '<input class=\'animated\' type=\'submit\' value=\'Modify\'>';
echo '</form>';
} 
else {
if ($email != "") {
echo "<br><br>$email is not registered. Please click <a href=\"http://prayerteamseasbothell.org/\"> here </a> to register your email";
			}
}
?>
</div>


</form>

</body>
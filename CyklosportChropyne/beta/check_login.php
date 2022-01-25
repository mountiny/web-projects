<?php
header('Content-Type: text/html; charset=utf-8');
// $host="localhost"; // Host name 
// $username="root"; // Mysql username 
// $password="root"; // Mysql password 
// $db_name="vzpirani"; // Database name 
// $tbl_name="members2"; // Table name 

// // Connect to server and select databse.
// $connection = @mysqli_connect("$host", "$username", "$password", "$db_name");
// // mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
// // mysql_select_db("$db_name")or die("cannot select DB");
// if (!$connection)
//   {
//   die("Connection error: " . mysqli_connect_error());
//   }
//   mysqli_set_charset($connection,'utf8');
//   // $connection->set_charset("utf8");
// $sql2 = "SELECT id, username, password, name FROM members2";
// $result2 = $connection->query($sql2);
// if ($result2->num_rows > 0) {
// 	echo "<table rules='rows'> <thead><tr><td>id</td> <td>Username</td> <td>Password</td><td>Name</td></tr></thead><tbody>";
// 	while ($row = $result2->fetch_assoc()) {

// 		echo "<tr><td>".$row["id"]."</td><td>".$row["username"]."</td><td>".$row["password"]."</td><td>".$row["name"]."</td></tr>";

// 	}
// 	echo "</tbody></table>"; 
// } else {
// 	echo "nikdo";
// }
 
					
// // $connection->set_charset("utf8");

// // username and password sent from form 
// $myusername= mysqli_real_escape_string($connection, $_POST['myusername']); 
// $mypassword= mysqli_real_escape_string($connection, $_POST['mypassword']); 
// echo " ".$myusername." ";
// // To protect MySQL injection (more detail about MySQL injection)
// // $myusername = stripslashes($myusername);
// // $mypassword = stripslashes($mypassword);
// // $myusername = mysql_real_escape_string($myusername);
// // $mypassword = mysql_real_escape_string($mypassword);
// // $sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
// $sql="SELECT username, password FROM members2";
// // $result=mysql_query($sql);
// $result= $connection->query($sql);
// if ($result) {
// 	$row = $result->fetch_assoc();
// 	echo $row['password'];
// 	if ($row) {
// 		echo "Hurray";
// 	}
// }

// // Mysql_num_row is counting table row
// $count=mysql_num_rows($result);

// // If result matched $myusername and $mypassword, table row must be 1 row
// if($count==1){

// // Register $myusername, $mypassword and redirect to file "login_success.php"
// session_register("myusername");
// session_register("mypassword"); 
// header("location:login_success.php");
// }
// else {
// 	echo $myusername;
// echo "Wrong Username or Password";
// }
// $connection->close();

session_start();

if (isset($_SESSION['myusername'])) {
	header('location:login_success.php');
}

// $host="localhost"; // Host name 
// $username="root"; // Mysql username 
// $password="root"; // Mysql password 
// $db_name="csch"; // Database name 
// $tbl_name="members"; // Table name 

$host="uvdb21.active24.cz"; // Host name 
$username="cyklosport"; // Mysql username 
$password="uikwVHpF"; // Mysql password 
$db_name="cyklosport"; // Database name 
$tbl_name="members"; // Table name 

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

// $con = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect to database");
// $con->set_charset("utf8");
mysql_set_charset("utf8");

// username and password sent from form 
$myusername=$_POST['myusername']; 
$mypassword=$_POST['mypassword']; 
// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);

// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1){
	// mysqli_set_charset("utf16");
	// echo "you are herre";
	$sql2="SELECT jmeno FROM $tbl_name WHERE username='$myusername'";
	$result2=mysql_query($sql2);
	$row = mysql_fetch_row($result2);
	$name = $row[0];

	$time = time();
	$_SESSION['lastinteraction'] = $time;

	$_SESSION['jmeno'] = $name;
	// Register $myusername, $mypassword and redirect to file "login_success.php"
	// session_register("myusername");
	$_SESSION['myusername'] = $myusername;
	// session_register("mypassword");
	$_SESSION['mypassword'] = $mypassword;
	// $_SESSION['name'] = $name; 
	header("location:login_success.php");
}
else {
	echo "Wrong Username or Password";
}
echo "<a href='login.php'>Back</a>"

?>
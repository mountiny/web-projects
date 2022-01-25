<?php  
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
header('Content-Type: text/html; charset=utf-8'); 
session_start();

if(!isset($_SESSION['myusername']) || !isset($_SESSION['mypassword'])){
	header("location:login.php");
}
if (time() - $_SESSION['lastinteraction'] > 1800) {
	header("location:logout.php");
} else {
	$_SESSION['lastinteraction'] = time();
}

if (isset($_POST["edit_nadpis"]) && isset($_POST["edit_obsah"]) && isset($_POST["edit_id"])) {

	include "database.php";

	$connection = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect to database");
	$connection->set_charset("utf8");
	$message = '';

	if (file_exists($_FILES['edit_obrazek']['tmp_name'])) {
		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["edit_obrazek"]["name"]);
		$uploadOk = 1;
		$isAlreadyThere = 0;
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		$check = getimagesize($_FILES["edit_obrazek"]["tmp_name"]);
		if($check !== false) {
	        $message .= "File is an image - " . $check["mime"] . ".<br>";
	        $uploadOk = 1;
	    } else {
	        $message .= "File is not an image.<br>";
	        $uploadOk = 0;
	    }
	    if (file_exists($target_file)) {
		    $message .= "Sorry, file already exists.<br>";
		    $uploadOk = 1; // !!!!!!!!!!!!!!!!!
		    $isAlreadyThere = 1;
		    // $nazevObrazku = mysqli_real_escape_string($connection, $target_file);
		}
		if ($_FILES["edit_obrazek"]["size"] > 2000000) {
		    $message .= "Sorry, your file is too large.";
		    $uploadOk = 0;
		}
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
		    $message .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
		    $uploadOk = 0;
		}
		if ($uploadOk == 0) {
		    $message .= "Sorry, your file was not uploaded.<br>";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["edit_obrazek"]["tmp_name"], $target_file) && $isAlreadyThere == 0) {
		        $message .= "The file ". basename( $_FILES["edit_obrazek"]["name"]). " has been uploaded.<br>";
		    } elseif ($isAlreadyThere == 1) {
		    	$message .= "The file is already there, I will use it.<br>";
		    } else {
		        $message .= "Sorry, there was an error uploading your file.<br>";
		    }
		}
		$nazevObrazku = mysqli_real_escape_string($connection, $target_file);
	} else {
		$nazevObrazku = mysqli_real_escape_string($connection, $_POST['edit_previous_image']);
	}
	$nadpis = mysqli_real_escape_string($connection, $_POST["edit_nadpis"]);
	$obsah = mysqli_real_escape_string($connection, $_POST["edit_obsah"]);
	// $idToChange = mysqli_real_escape_string($connection, $_POST["edit_id"]);
	$idToChange = (int)$_POST["edit_id"];
	$t = time();
	$uploadTime = mysqli_real_escape_string($connection, date("d/m/Y", $t) . " " . date("H:i", $t));
	$autor = mysqli_real_escape_string($connection, $_SESSION["name"]);
	mysqli_set_charset($connection, 'utf8');
	$_SESSION['lastinteraction'] = $t;
	// mysqli_query($connection, "INSERT INTO aktuality(nadpis,obsah,autor,datum,obrazky) VALUES ('$nadpis','$obsah','$autor','$uploadTime','$nazevObrazku')");
	mysqli_query($connection, "UPDATE aktuality SET nadpis='$nadpis', obsah='$obsah', datum='$uploadTime', obrazek='$nazevObrazku' WHERE id='$idToChange'");
	$message .= "Aktualita byla pozměněna!";
	$_SESSION['changeMessage'] = $message;	
	$connection->close();

	header('location:login_success.php');
	return;

} 

?>
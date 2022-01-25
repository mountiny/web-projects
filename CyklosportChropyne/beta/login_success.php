<?php
header('Content-Type: text/html; charset=utf-8'); 
session_start();
if(!isset($_SESSION['myusername']) || !isset($_SESSION['mypassword'])){
	header("location:login.php");
}

if (time() - $_SESSION['lastinteraction'] > 1800) {
	header("location:logout.php");
}

if (isset($_POST["nadpis"]) && isset($_POST["obsah"])) {
	include "database.php";
	$message = '';

	$connection = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect to database");
	$connection->set_charset("utf8");

	// mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	// mysql_select_db("aktuality")or die("cannot select DB");
	if (file_exists($_FILES['obrazek']['tmp_name'])) {
		$target_dir = "images/";
		$target_file = $target_dir . basename($_FILES["obrazek"]["name"]);
		$uploadOk = 1;
		$isAlreadyThere = 0;
		$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
		$check = getimagesize($_FILES["obrazek"]["tmp_name"]);
		if($check !== false) {
	        $message .= "File is an image - " . $check["mime"] . ".<br>";
	        $uploadOk = 1;
	    } else {
	        $message .= "File is not an image.<br>";
	        $uploadOk = 0;
	    }
	    if (file_exists($target_file)) {
		    $message .= "Sorry, file already exists.<br>";
		    $uploadOk = 1; // !!!!!!!!!!!!!!!!!!!!!!!
		    $isAlreadyThere = 1;
		    // $nazevObrazku = mysqli_real_escape_string($connection, $target_file);
		}
		if ($_FILES["obrazek"]["size"] > 2000000) {
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
		    $target_file = "-";
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["obrazek"]["tmp_name"], $target_file) && $isAlreadyThere == 0) {
		        $message .= "The file ". basename( $_FILES["obrazek"]["name"]). " has been uploaded.<br>";
		    } elseif ($isAlreadyThere == 1) {
		    	$message .= "The file is already there, I will use it.<br>";
		    } else {
		        $message .= "Sorry, there was an error uploading your file.<br>";
		    }
		}
		$nazevObrazku = mysqli_real_escape_string($connection, $target_file);
	} else {
		$nazevObrazku = mysqli_real_escape_string($connection, '-');
	}

	$nadpis = mysqli_real_escape_string($connection, $_POST["nadpis"]);
	$obsah = mysqli_real_escape_string($connection, $_POST["obsah"]);
	$t = time();
	$uploadTime = mysqli_real_escape_string($connection, date("d/m/Y", $t) . " " . date("H:i", $t));
	// $autor = mysqli_real_escape_string($connection, $_SESSION["name"]);
	mysqli_set_charset($connection, 'utf=');
	$_SESSION['lastinteraction'] = $t;
	mysqli_query($connection, "INSERT INTO aktuality(nadpis,datum,obsah,obrazek) VALUES ('$nadpis','$uploadTime','$obsah','$nazevObrazku')");
	$message .= "Aktualita byla přidána úspěšně!";
	$_SESSION['uploadMessage'] = $message;	
	$connection->close();

	header('location:login_success.php');
	return;

}


?>

<html>
<head>
	<title>
		Cyklosport Chropyně - admin
	</title>	
	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script src="script/admin/trix.js"></script>
	<link href='https://fonts.googleapis.com/css?family=Lato:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="styles/admin/admin_style.css">
	<link rel="stylesheet" type="text/css" href="styles/admin/trix.css">
	
</head>
<body>
<header>
	<ul>
		<li>
			<a href="login_success.php">Admin</a>
		</li>
		<li>
			<a href="index.php">Web</a>
		</li>
		<li>
			<a href="logout.php" class="logout">Logout</a>
		</li>
	</ul>
	<ul class="jmeno">
		<li>
			<?php
			echo $_SESSION['jmeno'];
			  ?>
		</li>
	</ul>
</header>
<div class="admin_cont">
	
	<form id="upload_aktualita" method="post" action="" enctype="multipart/form-data">
		<input name="nadpis" type="text" placeholder="Nadpis" style="width:300px;">
		<br>
		<input id="trixContent" type="hidden" name="obsah" style="width:300px; height: 200px;">
		<trix-editor input="trixContent" placeholder="Obsah" class="trix-content"></trix-editor>
		<br>
		<input name="obrazek" type="file" placeholder="">
		<br>
		<input name="submit" type="submit" value="Upload">
	</form>
	<div class="report-cont">
		<?php
			echo $_SESSION['uploadMessage'];
			unset($_SESSION['uploadMessage']);
			echo $_SESSION['changeMessage'];
			unset($_SESSION['changeMessage']);
		?>
	</div>
	<?php 

		include "database.php";

		$connection = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect to database");
		$connection->set_charset("utf8");

		$sql = "SELECT id, nadpis, obsah, datum, obrazek FROM aktuality ORDER BY `aktuality`.`id` DESC";
		$result = $connection->query($sql);
		if ($result->num_rows > 0) {
			echo "<div class='aktuality_cont'><table class='seznamAktualit trix-content' rules='rows'> <thead><tr><td>id</td><td>Datum vložení</td> <td>Nadpis</td> <td>Obsah</td><td>Obrázek</td><td>Změna</td></tr></thead><tbody>";
			while ($row = $result->fetch_assoc()) {

				echo "<tr><td class='id'>".$row["id"]."</td><td class='datum'>".$row["datum"]."</td><td class='nadpis'>".$row["nadpis"]."</td><td class='obsah'>".$row["obsah"]."</td><td class='obrazky'>".$row["obrazek"]."</td><td class='uprava'><a class='upravit_button' href='#'>Upravit</a></td></tr>";

			}
			echo "</tbody></table></div>"; 
		}else {
				echo "<div class='position:relative; margin: 0px auto; top: 0;'>Žádné aktuality.</div>";
			}

			$connection->close();
	?>


</div>
	<div class="upravit_modal">
		<form id="edit_aktualita" method="post" action="edit_row.php" enctype="multipart/form-data">
			<input name="edit_id" type="text" style="display:none;" >
			<input name="edit_previous_image" type="text" style="display:none;" >
			<input name="edit_nadpis" type="text">
			<!-- <br> -->
			<input id="trixContentUpravit" name="edit_obsah" type="hidden">
			<trix-editor input="trixContentUpravit" class="trix-content" id="modal_editor"></trix-editor>
			<!-- <input id="trixContentUpravit" type="hidden" name="edit_obsah" style="width:300px; height: 200px;">
			<trix-editor input="trixContentUpravit" 
			 class="trix-content"></trix-editor> -->
			<!-- <br> -->
			<input name="edit_obrazek" type="file">  <!-- style="width: 15%; height: 100%;" -->
			<!-- <br> -->
			<div class="input_button_cont">
				<input class="input_button" name="edit_submit" type="submit" value="Změnit">
				<input class="input_button cancel_modal" type="button" value="Zrušit">
			</div>
		</form>
		<!-- <button class="cancel_modal" type="button">
			Zrušit
		</button> -->
	</div>
<div class="display_overlay"></div>
</body>
<script type="text/javascript">
	$('#clear').on('click' ,function(){
		$('#control').replaceWith( 
			$('#control').val('').clone( true ) 
		);
	});
	$(document).ready(function(){
		var newNadpis = $('[name="edit_nadpis"]');
		var newObsah = $('#modal_editor');
		var newObrazek = $('[name="edit_obrazek"]');
		var newId = $('[name=edit_id]');
		var previousImage = $('[name=edit_previous_image]');

		$('.upravit_button').click(function(e){
			e.preventDefault();
			var row = $(this).parent().parent();
			var id = row.find('.id').text();
			var datum = row.find('.datum').text();
			var nadpis = row.find('.nadpis').text();
			var obsah = row.find('.obsah').html();
			var obrazky = row.find('.obrazky').text();


			newNadpis.val(nadpis);
			newObsah.val(obsah);
			// newObsah.attr("value", obsah);
			// $("#modal_editor").editor.insertString(obsah);
			newId.val(id);
			previousImage.val(obrazky);
			// newObrazek.val(obrazky);
			$('.upravit_modal').css("display", "block");
			$('.display_overlay').css("display", "block");
			$('html').css("overflow", "hidden");
			
		})
		$('.cancel_modal').click(function(){
			$('.upravit_modal').css("display", "none");
			$('.display_overlay').css("display", "none");
			$('html').css("overflow", "scroll");
			newNadpis.text('');
			newObsah.text('');
			newObrazek.val('');
			// newObrazek.text('');

		})
	})
</script>
</html>
<?php 
session_start();
    include 'database.php';

    $connection = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect to database");
    $connection->set_charset("utf8");

	$recaptcha = "";
	$nevyplnenoEcho = "";
	if (!empty($_POST['jmeno']) && isset($_POST['jmeno'])) {
		$_SESSION['jmeno'] = $_POST['jmeno'];
	}
	if (!empty($_POST['prijmeni']) && isset($_POST['prijmeni'])) {
		$_SESSION['prijmeni'] = $_POST['prijmeni'];
	}
	if (!empty($_POST['obec']) && isset($_POST['obec'])) {
		$_SESSION['obec'] = $_POST['obec'];
	}
	if (!empty($_POST['psc']) && isset($_POST['psc'])) {
		$_SESSION['psc'] = $_POST['psc'];
	}
	if (!empty($_POST['rn']) && isset($_POST['rn'])) {
		$_SESSION['rn'] = $_POST['rn'];
	}
	if (!empty($_POST['velikost']) && isset($_POST['velikost'])) {
		$_SESSION['velikost'] = $_POST['velikost'];
		if ($_POST['velikost'] == "V1") {
			$vel1 = "38-39";
		} elseif ($_POST['velikost'] == "V2") {
			$vel2 = "40-41";
		} elseif ($_POST['velikost'] == "V3") {
			$vel3 = "42-43";
		} elseif ($_POST['velikost'] == "V4") {
			$vel4 = "44-45";
		} elseif ($_POST['velikost'] == "V5") {
			$vel4 = "46-47";
		} elseif ($_POST['velikost'] == "VX") {
			$velX = "pozde";
		}
		 else {
			$vel5 = "46-47";
		} 
	}
	if (!empty($_POST['kategorie']) && isset($_POST['kategorie'])) {
		$_SESSION['kategorie'] = $_POST['kategorie'];
		if ($_POST['kategorie'] == "M1") {
			$katm1 = "M";
		} elseif ($_POST['kategorie'] == "M2") {
			$katm2 = "M";
		} elseif ($_POST['kategorie'] == "M3") {
			$katm3 = "M";
		} elseif ($_POST['kategorie'] == "M4") {
			$katm4 = "M";
		} elseif ($_POST['kategorie'] == "M5") {
			$katm5 = "M";
		} elseif ($_POST['kategorie'] == "M6") {
			$katm6 = "M";
		} elseif ($_POST['kategorie'] == "Mk1") {
			$katmk1 = "M";
		} elseif ($_POST['kategorie'] == "Mk2") {
			$katmk2 = "M";
		} elseif ($_POST['kategorie'] == "Ž1") {
			$katz1 = "M";
		} elseif ($_POST['kategorie'] == "Ž2") {
			$katz2 = "M";
		} elseif ($_POST['kategorie'] == "Žk1") {
			$katzk1 = "M";
		} elseif ($_POST['kategorie'] == "Žk2") {
			$katzk2 = "M";
		} else {
		}
		
	}
	if (!empty($_POST['trasa']) && isset($_POST['trasa'])) {
		$_SESSION['trasa'] = $_POST['trasa'];
		if ($_POST['trasa'] == "dlouha") {
			$trasaD = "dlouha";
		} else {
			$trasaK = "kratka";
		}
	}
	if (!empty($_POST['mail']) && isset($_POST['mail'])) {
		$_SESSION['mail'] = $_POST['mail'];
	}
	if (!empty($_POST['klub']) && isset($_POST['klub'])) {
		$_SESSION['klub'] = $_POST['klub'];
	}
	if (!empty($_POST['poradi']) && isset($_POST['poradi'])) {
		$_SESSION['poradi'] = $_POST['poradi'];
	}

  if (!empty($_POST['jmeno']) && isset($_POST['jmeno']) && 
     !empty($_POST['prijmeni']) &&  isset($_POST['prijmeni']) &&
     !empty($_POST['obec']) && isset($_POST['obec']) &&  
     !empty($_POST['psc']) &&  isset($_POST['psc']) &&
     !empty($_POST['rn']) && isset($_POST['rn']) &&  
     !empty($_POST['kategorie']) &&  isset($_POST['kategorie']) &&
     !empty($_POST['mail']) && isset($_POST['mail']) &&
     !empty($_POST['trasa']) && isset($_POST['trasa']) &&
     !empty($_POST['velikost']) && isset($_POST['velikost'])) {

		// Oddělat velikost až bude pozde


 // &&
 //     !empty($_POST['trasa']) && isset($_POST['trasa']
    
  	if ($_POST['g-recaptcha-response']) {
      if (!empty($_POST['klub']) && isset($_POST['klub'])) {
        $klub = mysqli_real_escape_string($connection,$_POST['klub']);
      } else {
        $klub = mysqli_real_escape_string($connection,"-");
      }
      if (!empty($_POST['poradi']) && isset($_POST['poradi'])) {
        $poradi = mysqli_real_escape_string($connection,$_POST['poradi']);
      } else {
        $poradi = mysqli_real_escape_string($connection,"-");
      }
      // if (!empty($_POST['mail']) && isset($_POST['mail'])) {
      //   $mail = mysqli_real_escape_string($connection,$_POST['mail']);
      // } else {
      //   $mail = mysqli_real_escape_string($connection,"-");
      // }
      if ($_POST["trasa"] == "dlouha") {
      	$trasa_email = "Dlouhá";
      } else {
      	$trasa_email = "Krátká";
      }
      $sym = mt_rand(1000000,100000000);
      $symbol = mysqli_real_escape_string($connection,$sym);
      $mail = mysqli_real_escape_string($connection,$_POST['mail']);
      $jmeno = mysqli_real_escape_string($connection,$_POST['jmeno']);
      $prijmeni = mysqli_real_escape_string($connection,$_POST['prijmeni']);
      $obec = mysqli_real_escape_string($connection,$_POST['obec']);
      $psc = mysqli_real_escape_string($connection,$_POST['psc']);
      $rn = mysqli_real_escape_string($connection,$_POST['rn']);
      $kategorie = mysqli_real_escape_string($connection,$_POST['kategorie']);
      $trasa = mysqli_real_escape_string($connection,$_POST['trasa']);
      $velikost = mysqli_real_escape_string($connection,$_POST['velikost']);

		if ($velikost == "V1") {
			$velikost = "38-39";
		} elseif ($velikost == "V2") {
			$velikost = "40-41";
		} elseif ($velikost == "V3") {
			$velikost = "42-43";
		} elseif ($velikost == "V4") {
			$velikost = "44-45";
		} elseif ($velikost == "V5") {
			$velikost = "46-47";
		} elseif ($velikost == "VX") {
			$velikost = "Dárek již není v ceně startovného.";
		} else {
			// $velikost = "46-47";
			$velikost = "Přihláška přišla po termínu.";
		} 

      if ($trasa == "dlouha") {
      	$trasa = "1";
      } else {
      	$trasa = "2";
      }

    //   $message = "Dobrý den,<br><br>právě jsme obdrželi Vaši elektronickou přihlášku na závod FORCE Chřibská 50/30 MTB.<br><br>Údaje pro bezhotovostní platbu startovného jsou:<br><br>Číslo účtu: <br><b>5193378319/0800</b><br><br> Váš variabilní symbol: <br><b>$sym</b><br><br>
    //  		 Startovné: <br>
    //  		 trasa <b>T50 - 400 Kč</b><br>trasa <b>T30 - 350 Kč</b><br><br>
	// 		V den konání závodu při prezentaci je startovné <b>450 Kč</b>.<br>
	// 		Při startovném uhrazeném do 25. 5. 2019 (ne včetně) je ve startovném zahrnut dárek v podobě originálních cyklistických ponožek.<br><br>Děkujeme za Vaši přihlášku a včasnou úhradu startovného. Těšíme se na Vaši účast.<br><br>Organizační tým<br><br>Údaje pro kontrolu:<br>Jméno: ".$_POST["jmeno"]."<br>Příjmení: ".$_POST["prijmeni"]."<br>Obec: ".$_POST["obec"]."<br>PSČ: ".$_POST["psc"]."<br>Klub: ".$_POST["klub"]."<br>Rok narození: ".$_POST["rn"]."<br>Trasa: ".$trasa_email."<br>Kategorie: ".$_POST["kategorie"]."<br>Loňské pořadí: ".$_POST["poradi"]."<br>Velikost ponožek: ".$velikost."<br><br>Pokud máte jakékoliv dotazy, či byste potřebovali upravit některý údaj v přihlášce, neváhejte nás kontaktovat na mountiny@gmail.com nebo prodejna@cyklosportchropyne.cz.";
      $headersVlad = "MIME-Version: 1.0" . "\r\n";
	  $headersVlad .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	  $headers = "MIME-Version: 1.0" . "\r\n";
    //   mail($mail, "FORCE Chribska 50/30 MTB - Registrace 2019", $message, $headers);
	  $mailVlad = "vladimir.rm@seznam.cz";
	//   $mailVlad = "mikllhor@gmail.com";
	
	$mime_boundary = "----Meeting Booking----".MD5(TIME());

    // $headers = "From: ".$from_name." <".$from_address.">\n";
    // $headers .= "Reply-To: ".$from_name." <".$from_address.">\n";
    // $headers .= "MIME-Version: 1.0\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
    $headers .= "Content-class: urn:content-classes:calendarmessage\n";
	
	$messageVlad = "Přijmení: $prijmeni<br>Jméno: $jmeno<br>Obec: $obec<br>PSČ: $psc<br>E-mail: $mail<br>Rok narození: $rn<br>Kategorie: $kategorie<br>Trasa: $trasa<br>Klub: $klub<br>Var. symbol: $symbol<br>Pořadí z minulého roku: $poradi<br>Velikost ponožek: $velikost";
    
    //Create Email Body (HTML)
    $message = "--$mime_boundary\r\n";
    $message .= "Content-Type: text/html; charset=UTF-8\n";
	$message .= "Content-Transfer-Encoding: 8bit\n\n";
	$message .= "<html>\n";
	$message .= "<body>\n";
	$message .= "<div>\n";
	$message .= "Dobrý den,<br><br>právě jsme obdrželi Vaši elektronickou přihlášku na závod FORCE Chřibská 50/30 MTB.<br><br>Údaje pro bezhotovostní platbu startovného jsou:<br><br>Číslo účtu: <br><b>5193378319/0800</b><br><br> Váš variabilní symbol: <br><b>$sym</b><br><br>
	Startovné: <br>
	trasa <b>T50 - 400 Kč</b><br>trasa <b>T30 - 350 Kč</b><br><br>
  V den konání závodu při prezentaci je startovné <b>450 Kč</b>.<br>
  Při startovném uhrazeném do 1. 5. 2019 (ne včetně) je ve startovném zahrnut dárek v podobě originálních cyklistických ponožek.<br><br>Děkujeme za Vaši přihlášku a včasnou úhradu startovného. Těšíme se na Vaši účast.<br><br>Organizační tým<br><br>Údaje pro kontrolu:<br>Jméno: ".$_POST["jmeno"]."<br>Příjmení: ".$_POST["prijmeni"]."<br>Obec: ".$_POST["obec"]."<br>PSČ: ".$_POST["psc"]."<br>Klub: ".$_POST["klub"]."<br>Rok narození: ".$_POST["rn"]."<br>Trasa: ".$trasa_email."<br>Kategorie: ".$_POST["kategorie"]."<br>Loňské pořadí: ".$_POST["poradi"]."<br>Velikost ponožek: ".$velikost."<br><br>Pokud máte jakékoliv dotazy, či byste potřebovali upravit některý údaj v přihlášce, neváhejte nás kontaktovat na dev@mountiny.com nebo prodejna@cyklosportchropyne.cz.";
	// $message .= $messageVlad;
	
    $message .= "</div>\n";
    $message .= "</body>\n";
	$message .= "</html>\n";
	$message .= "--$mime_boundary\r\n";
	
	$ical = 'BEGIN:VCALENDAR' . "\r\n" .
	'CALSCALE:GREGORIAN' . "\r\n" .
	'VERSION:2.0' . "\r\n" .
	'X-WR-CALNAME:FORCE Chřibská 50/30 MTB' . "\r\n" .
	'METHOD:PUBLISH' . "\r\n" .
	'PRODID:-//Apple Inc.//Mac OS X 10.14.2//EN' . "\r\n" .
	'BEGIN:VEVENT' . "\r\n" .
	'TRANSP:TRANSPARENT' . "\r\n" .
	'DTEND;VALUE=DATE:20190609' . "\r\n" .
	'X-APPLE-STRUCTURED-LOCATION;VALUE=URI;X-ADDRESS="K Výstavišti 8, 767 01 
	 Kroměříž 1, Česká republika";X-APPLE-MAPKIT-HANDLE=CAES2gEIrk0QxP3fmJST4
	 /1TGhIJI40xLmSkSEARbvK4/7lkMUAiZAoOQ3plY2ggUmVwdWJsaWMSAkNaGgVabMOtbioMS
	 3JvbcSbxZnDrcW+MgxLcm9txJvFmcOtxb46Bjc2NyAwMVIOSyBWw71zdGF2acWhdGlaAThiE
	 EsgVsO9c3RhdmnFoXRpIDgqGEV4aGliaXRpb24gY2VudHJlIEZMT1JJQTIQSyBWw71zdGF2a
	 cWhdGkgODIVNzY3IDAxIEtyb23Em8WZw63FviAxMg5DemVjaCBSZXB1YmxpYw==;X-APPLE-
	 RADIUS=141.1750603717516;X-APPLE-REFERENCEFRAME=0;X-TITLE=Exhibition cen
	 tre FLORIA:geo:49.284307,17.393463' . "\r\n" .
	'UID:DD3E21C8-B240-4D17-B75F-3F7335AB4790' . "\r\n" .
	'DTSTAMP:20190109T125845Z' . "\r\n" .
	'LOCATION:Exhibition centre FLORIA\nK Výstavišti 8\, 767 01 Kroměříž 1\,
	 Česká republika' . "\r\n" .
	'URL;VALUE=URI:https://www.cyklosportchropyne.cz/chribska.php' . "\r\n" .
	'SEQUENCE:0' . "\r\n" .
	'X-APPLE-TRAVEL-ADVISORY-BEHAVIOR:AUTOMATIC' . "\r\n" .
	'SUMMARY:FORCE Chřibská 50/30 MTB' . "\r\n" .
	'LAST-MODIFIED:20190109T125935Z' . "\r\n" .
	'CREATED:20181213T112500Z' . "\r\n" .
	'DTSTART;VALUE=DATE:20190608' . "\r\n" .
	'BEGIN:VALARM' . "\r\n" .
	'X-WR-ALARMUID:CD5E0791-E622-4461-BBF1-C64C5DB0F951' . "\r\n" .
	'UID:CD5E0791-E622-4461-BBF1-C64C5DB0F951' . "\r\n" .
	'TRIGGER;VALUE=DATE-TIME:19760401T005545Z' . "\r\n" .
	'ACTION:NONE' . "\r\n" .
	'END:VALARM' . "\r\n" .
	'BEGIN:VALARM' . "\r\n" .
	'X-WR-ALARMUID:EED6F6CE-DA37-462B-8A10-9E851AC664E2' . "\r\n" .
	'UID:EED6F6CE-DA37-462B-8A10-9E851AC664E2' . "\r\n" .
	'TRIGGER:-PT15H' . "\r\n" .
	'DESCRIPTION:Reminder' . "\r\n" .
	'ACTION:DISPLAY' . "\r\n" .
	'END:VALARM' . "\r\n" .
	'BEGIN:VALARM' . "\r\n" .
	'X-WR-ALARMUID:529F1602-488C-42CA-B35C-E47277D9623A' . "\r\n" .
	'UID:529F1602-488C-42CA-B35C-E47277D9623A' . "\r\n" .
	'TRIGGER:-P6DT15H' . "\r\n" .
	'ATTACH;VALUE=URI:Chord' . "\r\n" .
	'ACTION:AUDIO' . "\r\n" .
	'END:VALARM' . "\r\n" .
	'END:VEVENT' . "\r\n" .
	'END:VCALENDAR';
	$message .= 'Content-Type: text/calendar;name="FORCE_Chřibská_50/30_MTB.ics";method=REQUEST'."\n";
	$message .= 'Content-Disposition: attachment';
    $message .= "Content-Transfer-Encoding: base64\n\n";
    $message .= $ical;

      
	  mail($mailVlad, "Registrace závodníka", $messageVlad, $headersVlad);
	  mail($mail, "Registrace závodníka", $message, $headers);

      mysqli_set_charset($connection,'utf8');

      mysqli_query($connection,"INSERT INTO zavodnici2019(prijmeni,jmeno,obec,psc,email,rok_narozeni,kategorie,tym,symbol,poradi,trasa,velikost) VALUES('$prijmeni','$jmeno','$obec','$psc','$mail','$rn','$kategorie','$klub','$symbol','$poradi','$trasa','$velikost')");

      // echo "Děkujeme za registraci, doufáme, že si závod užijete, jak jen to bude možné.";
      $connection->close();
      $_SESSION['success'] = "Registrace proběhla úspěšně, na Vámi uvedený email Vám byl odeslán variabilní symbol pro platbu převodem.";
      // header('location: https://www.cyklosportchropyne.cz/chribska/chribska_prihlaska.php?msg=success');

      //POZOR
      header('location: https://www.cyklosportchropyne.cz/prihlaska.php');
      exit();
      
      // include 'redirect.php';
	  } else {
	  	// recaptcha();
	  	// $recaptcha = "<p style='color:red;'>Nezatrhli jste recaptchu.</p>";
	  	$_SESSION['failure'] = "Nepotvrdili jste, že nejste robot.";
	}
    

  } 
  elseif (!empty($_POST['jmeno']) || isset($_POST['jmeno']) || 
     !empty($_POST['prijmeni']) ||  isset($_POST['prijmeni']) ||
     !empty($_POST['obec']) || isset($_POST['obec']) ||  
     !empty($_POST['psc']) ||  isset($_POST['psc']) ||
     !empty($_POST['rn']) || isset($_POST['rn']) ||  
     !empty($_POST['kategorie']) ||  isset($_POST['kategorie']) ||
     !empty($_POST['mail']) || isset($_POST['mail'])||
     !empty($_POST['trasa']) || isset($_POST['trasa'])) {
  	
// || !empty($_POST['velikost']) || isset($_POST['velikost'])

  	// echo "<p style='color:red;'>Nevyplnili jste všechna požadovaná pole.</p>";
  	// nevyplneno();
  	// $nevyplnenoEcho = "<p style='color:red;'>Nevyplnili jste všechna požadovaná pole.</p>";
  	$_SESSION['failure'] = "Nevyplnili jste všechna požadovaná pole.";

  } else {

    

  }
    $connection->close();

?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Cyklosport Chropyně</title>
	<meta name="Description" CONTENT="Přihláška na Chřibskou 50 MTB..">
  <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
  <link rel="manifest" href="favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#5AC0CE">
  <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#5AC0CE">
	<link rel="stylesheet" href="din-pro/style.css">
    <!-- <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,500,600,700&amp;subset=latin-ext" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
        <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body class="ch50-page" style="background-color:#5ac0ce;">

    <div class="ch50-container">
        <div class="ch50-main">
        <a href="./chribska.php" class="back_home">
                <img src="img/back_left.png" alt="" class="back_img">
            </a>
            <a href="https://www.force.cz">
                <img src="img/force-black.png" alt="" class="force-black">
            </a>
            <h1 class="prihlaska-heading">PŘIHLÁŠKA 2019</h1>
        <form accept-charset="utf-8" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="send_form" id="prihlaska">
				<table border="0" cellpadding="10" cellspacing="0" > 
					<tr>
						<td colspan="100%" id="error_info" style="font-weight:500; color:#EC3359;" class="<?php echo isset($_SESSION['success']) ? 'success' : '';echo isset($_SESSION['failure']) ? 'failure' : ''?>" >
							<?php 
								if (isset($_SESSION["success"])) {
									echo $_SESSION["success"];
									session_unset();
								}
								if (isset($_SESSION["failure"])) {
									echo $_SESSION["failure"];
								}

							?>
						</td>
					</tr>
					<tr> 
						<td> <input class="bold" type="text" name="jmeno" placeholder="Jméno" value="<?php echo isset($_SESSION['jmeno']) ? $_SESSION['jmeno'] : ''?>"></td> 
						
						<td> <input class="bold" type="text" name="prijmeni" placeholder="Příjmení" value="<?php echo isset($_SESSION['prijmeni']) ? $_SESSION['prijmeni'] : ''?>"></td>
					</tr>
					<tr> 
						<td> <input class="bold" type="text" name="obec" placeholder="Obec" value="<?php echo isset($_SESSION['obec']) ? $_SESSION['obec'] : ''?>"></td> 
						
						<td> <input class="bold" type="text" name="psc" placeholder="PSČ" value="<?php echo isset($_SESSION['psc']) ? $_SESSION['psc'] : ''?>"></td>
					</tr>
					<tr> 
						<td> <input type="text" name="klub" placeholder="Klub" value="<?php echo isset($_SESSION['klub']) ? $_SESSION['klub'] : ''?>"></td> 
						
						<td> <input class="bold" id="rok_nar" type="text" name="rn" placeholder="Rok narození" value="<?php echo isset($_SESSION['rn']) ? $_SESSION['rn'] : ''?>"/></td>
					</tr>
					<tr> 
						<td> <input class="bold" type="email" name="mail" placeholder="E-mail" value="<?php echo isset($_SESSION['mail']) ? $_SESSION['mail'] : ''?>"></td> 
						
						<td> 
						<select name="trasa" size="1" id="vyber_trasa"> 
							<option class="bold" disabled selected> Trasa
							<option value="dlouha" <?php echo isset($trasaD) ? 'selected' : ''?> > Dlouhá - 50 km
							<option value="kratka" <?php echo isset($trasaK) ? 'selected' : ''?> > Krátká - 30 km
						</select>
						</td>
					</tr>
					<tr> 
					
						<td> <input type="text" name="poradi" placeholder="Pořadí v loňském roce" value="<?php echo isset($_SESSION['poradi']) ? $_SESSION['poradi'] : ''?>"></td> 
						<td> 
						<select id="vyber_kat" name="kategorie" size="1"> 
							<option class="bold" value="" disabled selected> Kategorie
							<option class="bold" value="" disabled> Dlouhá
							<option value="M1" id="m1" class="dlouha_trasa_opt" <?php echo isset($katm1) ? 'selected' : ''?>> M1 - muži do 19 
							<option value="M2" id="m2" class="dlouha_trasa_opt" <?php echo isset($katm2) ? 'selected' : ''?>> M2 - muži 20-29 
							<option value="M3" id="m3" class="dlouha_trasa_opt" <?php echo isset($katm3) ? 'selected' : ''?>> M3 - muži 30-39 
							<option value="M4" id="m4" class="dlouha_trasa_opt" <?php echo isset($katm4) ? 'selected' : ''?>> M4 - muži 40-49 
							<option value="M5" id="m5" class="dlouha_trasa_opt" <?php echo isset($katm5) ? 'selected' : ''?>> M5 - muži 50-59 
							<option value="M6" id="m6" class="dlouha_trasa_opt" <?php echo isset($katm6) ? 'selected' : ''?>> M6 - muži nad 60 
							<option value="Ž1" id="z1" class="dlouha_trasa_opt" <?php echo isset($katz1) ? 'selected' : ''?>> Ž1 - ženy do 35 (včetně)
							<option value="Ž2" id="z2" class="dlouha_trasa_opt" <?php echo isset($katz2) ? 'selected' : ''?>> Ž2 - ženy nad 35
							<option class="bold" value="" disabled> Krátká
							<option value="Mk1" id="mk1" class="kratka_trasa_opt" <?php echo isset($katmk1) ? 'selected' : ''?>> Mk1 - muži do 19 (včetně)
							<option value="Mk2" id="mk2" class="kratka_trasa_opt" <?php echo isset($katmk2) ? 'selected' : ''?>> Mk2 - muži nad 19
							<option value="Žk1" id="zk1" class="kratka_trasa_opt" <?php echo isset($katzk1) ? 'selected' : ''?>> Žk1 - ženy do 19 (včetně)
							<option value="Žk2" id="zk2" class="kratka_trasa_opt" <?php echo isset($katzk2) ? 'selected' : ''?>> Žk2 - ženy nad 19
						</select>
						<!-- <select name="pohlaví" size="1" id="vyber_pohlavi"> 
							<option class="bold" value="" disabled selected> Pohlaví
							<option value="muz"> Muž
							<option value="zena"> Žena
						</select> -->
						</td>
						
					</tr>
					 <tr style="display:none;"> 
					
						<td> 

						<select id="vyber_vel" name="velikost" size="1"> 
						<!-- Disable the first option, put different value -->
							<option class="bold" value="VX" selected> Velikost ponožek
							<option value="V1" id="v1" class="velikost_opt" <?php echo isset($vel1) ? 'selected' : ''?>> 38-39
							<option value="V2" id="v2" class="velikost_opt" <?php echo isset($vel2) ? 'selected' : ''?>> 40-41
							<option value="V3" id="v3" class="velikost_opt" <?php echo isset($vel3) ? 'selected' : ''?>> 42-43
							<option value="V4" id="v4" class="velikost_opt" <?php echo isset($vel4) ? 'selected' : ''?>> 44-45 
							<option value="V5" id="v5" class="velikost_opt" <?php echo isset($vel5) ? 'selected' : ''?>> 46-47
							
							
						</select>
						 <!-- <select name="pohlaví" size="1" id="vyber_pohlavi"> 
							<option class="bold" value="" disabled selected> Pohlaví
							<option value="muz"> Muž
							<option value="zena"> Žena
						</select> -->
						</td>
						
					</tr> 
					<!-- <tr>
						<td colspan=100%>
							<p class="kat_info" style="text-align: center;"> Zadejte rok narození a trasu.</p>
						</td>
					</tr> -->
					<tr> <td colspan="2"> <b>Tučné nutno vyplnit! (Kategorii a trasu také)</b></td> 
					<!-- <td><input id="kontrola" style="visibility: hidden;" autocomplete="off" type="text" name="password"></td> -->
					</tr>





					<tr> 
						<td colspan="2"> 
						Variabilní symbol k platbě převodem Vám bude zaslán na Vámi uvedený email. Číslo účtu: <span style="color:#EC3359;">5193378319/0800</span>.
						</td> 
					</tr>
					<tr><td colspan="2"> Pokud Vám po odeslání přihlášky vzápětí nepřijde potvrzující e-mail s var. s., zašlete požadované přihlašovací údaje na tento <a href="mailto:dev@mountiny.com">e-mail.</a> Za problémy se omlouváme a děkujeme za pochopení.</td></tr>
					<tr>
						<td colspan="2">
Přihlášením se na tento závod každý účastník souhlasí se zveřejněním svých osobních údajů v podobě přihlášky,
startovní listiny, výsledků a dalším zpracováním svých údajů pořadatelem v rozsahu nutném pro zabezpečení celé akce.
Účastník bere na vědomí, že poskytnutí údajů je dobrovolné, že svůj souhlas může bezplatně a písemně kdykoliv na adrese pořadatele odvolat,
má právo přístupu k osobním údajům a právo na opravu těchto údajů, blokování nesprávných osobních údajů, jejich likvidace atd.
V průběhu akce budou pořizovány zdravodajské fotografie, sloužící k informování veřejnosti o proběhlém závodě, propagačním účelům pořadatele, ale také pro osobní potřebu závodníků. 
Přihlášením se každy účastník souhlasí s pořízením fotografické, audio nebo video dokumentace a zpracováním osobních údajů na ní uvedených.
</td>
					<!-- <td colspan="2">Přihlášením se na tento </td> -->
</tr>

					<tr><td colspan="2"><b>Za osoby mladších 18 let přihlášku odesílá jejich zákonný zástupce.</b></td></tr>

					<tr><td colspan="2">Propozice beru na vědomí a závodu se zúčastním na vlastní nebezpečí. Seznámil(a) jsem se s bezpečnostními předpisy, které se zavazuji dodržovat. Prohlašuji, že jsem si vědom(a) toho, že nesu veškerou zodpovědnost za škodu způsobenou na zdraví nebo věcech, která vznikne mně, pořadateli nebo třetím osobám před, během či po závodě. Budu dodržovat pravidla fair-play, budu se chovat šetrně k přírodě. Plná přilba povinná. Zadáním e-mailové adresy souhlasím se zasíláním informací souvisejících se závodem.</td></tr>
				
				<tr><td colspan="2"> Pořadatel se zavazuje, že Vaše osobní údaje neposkytne třetí osobě a zajistí jejich ochranu v souladu se zákonem č. 101 / 2000 Sb., o ochraně osobních údajů a také v souladu s nařízení Evropského parlamentu a Rady č. 2016/679.</td></tr>
				<tr><td>

				<div class="g-recaptcha" data-sitekey="6LeszgATAAAAACM9y4mQlwb6rfwDfPvab1Bduguv"></div>
				<br>
				<input type="button" value="Odeslat" name="kontrola" id="kontrolaButton" /> 
				<input type="submit" value="Odeslat" name="odeslat" id="odeslatButton" style="visibility: hidden;" /></td></tr>
				</table>
				</form>
				<?php 
					session_unset();
				 ?>
           
        </div>
    </div>

	<footer>
        CS<b>CH</b>&nbsp;roztočil a podporuje
        <a href="https://www.mountiny.com" target="_blank"
          ><img src="img/mountiny.png" alt="Mountiny" class="mountiny_logo"
        /></a>
      </footer>

	<script type="text/javascript">
	$(window).on("load", function() {
		$("img.back_img").toggleClass("show");
			$("footer").toggleClass("show");
			$("form.send_form").toggleClass("show");
			$("h1.prihlaska-heading").toggleClass("show");
			$("img.force-black").toggleClass("show");
      });
        $(document).ready(function() {

			// $("img.back_img").toggleClass("show");
			// $("footer").toggleClass("show");
			// $("form.send_form").toggleClass("show");
			// $("h1.prihlaska-heading").toggleClass("show");
			// $("img.force-black").toggleClass("show");


            $("#vyber_trasa").change(function(){


        var trasa = $("#vyber_trasa").val();
        if (trasa == "dlouha") {

            $("#vyber_kat option.kratka_trasa_opt").prop("disabled", true);
            $("#vyber_kat option.dlouha_trasa_opt").prop("disabled", false);
            $("#vyber_kat option.kratka_trasa_opt:selected").prop("selected", false);

        } else if (trasa == "kratka") {

            $("#vyber_kat option.dlouha_trasa_opt").prop("disabled", true);
            $("#vyber_kat option.kratka_trasa_opt").prop("disabled", false);
            $("#vyber_kat option.dlouha_trasa_opt:selected").prop("selected", false);

        } else {

        }
        });

        var realySubmit = false;
        $("#kontrolaButton").click(function(){
        $("#odeslatButton").trigger("click");
        });
        $("#prihlaska").submit(function(e) {

        if (!realySubmit) {
            e.preventDefault();
            
            var rok = parseInt($("#rok_nar").val(),10);
        
            if (rok > 1900 && rok < 2017) {

                var trasa = $("#vyber_trasa").val();
                var kategorie = $("#vyber_kat").val();
                if (kategorie === null || trasa === null) {

                    $("#error_info").text("Kategorie nebo trasa nebyla vybrána.");
                    $("#error_info").css("opacity","1");
                    return;

                };
                if (kategorie.length == 3 && trasa == "kratka") {
                    realySubmit = true;
                    $("#prihlaska").submit();

                } else if (kategorie.length == 2 && trasa == "dlouha") {
                    realySubmit = true;
                    $("#prihlaska").submit();

                } else {

                    $("#error_info").text("Vámi vybraná kategorie nekoresponduje s vámi vybranou trasou.");
                    $("#error_info").css("opacity","1");

                }
                                
            } else {

                $("#error_info").text("Vámi zadaný rok narození je nepravděpodobný a v přírodě neobvyklý.");
                $("#error_info").css("opacity","1");
            }
        };

            $(".ch-vysledek-li h2").click(function (e) {
                e.preventDefault();
                $(this).toggleClass("open");
                var target = "#" + $(this).text() + "vysledky";
                $(target).toggleClass("open");
            })



            $("ul.seznam-photo li h2").click(function (e) {
                e.preventDefault();
                $(this).toggleClass("open");
                var target = "#photo" + $(this).text();
                $(target).toggleClass("open");
            })



            $(".photo-btn img").click(function (e) {
                e.preventDefault();
                $(this).toggleClass("open");
                $("div.hidden-photo-li").toggleClass("open");
            })



            $(".vysledky-btn img").click(function (e) {
                e.preventDefault();
                $(this).toggleClass("open");
                $("div.hidden-li").toggleClass("open");
            })

            $(window).on("scroll", function (e) {
                // var offsetY = $("html").offset().top * (0)
                screenTop = $(document).scrollTop() * -0.2;

                // $('#content').css('top', screenTop);
                $("img.ch50-bg-map").css("transform", "translate3d(" + (-0.4) * screenTop + "px," +
                    screenTop + "px,0px)")
                var dHeight = $("div.ch50-intro").height() * 2.5;
                var alpha = (($(document).scrollTop() / dHeight));
                $('body').css('background', 'rgba(90,192,206,' + (alpha * 2) + ')');
            })

        })
    })
    </script>

</body>

</html>
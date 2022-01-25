<?php
	session_start();
    include 'db_active.php';
	$connection->set_charset("utf8");
	
	$recaptcha = "";
	
	$nevyplnenoEcho = "";
  	if (!empty($_POST['jmeno']) && isset($_POST['jmeno']) && 
    	!empty($_POST['prijmeni']) &&  isset($_POST['prijmeni']) &&
    	!empty($_POST['obec']) && isset($_POST['obec']) &&  
    	!empty($_POST['psc']) &&  isset($_POST['psc']) &&
    	!empty($_POST['rn']) && isset($_POST['rn']) &&  
    	!empty($_POST['kategorie']) &&  isset($_POST['kategorie']) &&
    	!empty($_POST['mail']) && isset($_POST['mail']) ) {

    
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
      $sym = mt_rand(1000000,100000000);
      $symbol = mysqli_real_escape_string($connection,$sym);
      $mail = mysqli_real_escape_string($connection,$_POST['mail']);
      $jmeno = mysqli_real_escape_string($connection,$_POST['jmeno']);
      $prijmeni = mysqli_real_escape_string($connection,$_POST['prijmeni']);
      $obec = mysqli_real_escape_string($connection,$_POST['obec']);
      $psc = mysqli_real_escape_string($connection,$_POST['psc']);
      $rn = mysqli_real_escape_string($connection,$_POST['rn']);
      $kategorie = mysqli_real_escape_string($connection,$_POST['kategorie']);

      $message = "Dobrý den,\n\nprávě jsme obdrželi Vaši elektronickou přihlášku na závod FORCE Chřibská 50ka MTB.\n\nÚdaje pro bezhotovostní platbu startovného jsou:\n\nČíslo účtu: 2216117143/0800\n\n Váš variabilní symbol: $sym\n\n\nDěkujeme za Vaši přihlášku a včasnou úhradu startovného. Těšíme se na Vaši účast.\n\nOrganizační tým";
      mail($mail, "Chribska 50ka MTB - Registrace", $message);
      $mailVlad = "vladimir.rm@seznam.cz";
      
      $messageVlad = "Přijmení: $prijmeni\nJméno: $jmeno\nObec: $obec\nPSČ: $psc\nE-mail: $mail\nRok narození: $rn\nKategorie: $kategorie\nKlub: $klub\nVar. symbol: $symbol\nPořadí z minulého roku: $poradi";
      mail($mailVlad, "Registrace zavodnika", $messageVlad);

      mysqli_set_charset($connection,'utf8');

      mysqli_query($connection,"INSERT INTO zavodnici(prijmeni,jmeno,obec,psc,email,rok_narozeni,kategorie,tym,symbol,poradi) VALUES('$prijmeni','$jmeno','$obec','$psc','$mail','$rn','$kategorie','$klub','$symbol','$poradi')");

      // echo "Děkujeme za registraci, doufáme, že si závod užijete, jak jen to bude možné.";
      $connection->close();
      header('location: http://www.cyklosportchropyne.cz/chribska/chribska_prihlaska.php?msg=success');
      exit();
      
      // include 'redirect.php';
	  } else {
	  	// recaptcha();
	  	$recaptcha = "<p style='color:red;'>Nezatrhli jste recaptchu.</p>";
	}
    

  } elseif (!empty($_POST['jmeno']) || isset($_POST['jmeno']) || 
     !empty($_POST['prijmeni']) ||  isset($_POST['prijmeni']) ||
     !empty($_POST['obec']) || isset($_POST['obec']) ||  
     !empty($_POST['psc']) ||  isset($_POST['psc']) ||
     !empty($_POST['rn']) || isset($_POST['rn']) ||  
     !empty($_POST['kategorie']) ||  isset($_POST['kategorie']) ||
     !empty($_POST['mail']) || isset($_POST['mail'])) {
  	
  	// echo "<p style='color:red;'>Nevyplnili jste všechna požadovaná pole.</p>";
  	// nevyplneno();
  	$nevyplnenoEcho = "<p style='color:red;'>Nevyplnili jste všechna požadovaná pole.</p>";

  } else {

    

  }
    // $connection->close();
?>
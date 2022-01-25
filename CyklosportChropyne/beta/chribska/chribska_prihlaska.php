<?php 
session_start();
    include 'db_active.php';
	// define('DB_SERVER', 'uvdb21.active24.cz');
	// define('DB_USERNAME', 'cyklosport');
	// define('DB_PASSWORD', 'uikwVHpF');
	// define('DB_DATABASE', 'cyklosport');
	// $connection = @mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
	// $base_url = 'http://www.cyklosportchropyne.cz/beta/chribska/';

	$connection->set_charset("utf8");

// $link = mysqli_connect('uvdb21.active24.cz', 'cyklosport', 'uikwVHpF', 'cyklosport');
// if (!$link) {
//  die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
//   } 
//   echo 'Connected... ' . mysqli_get_host_info($link) . "\n"; 
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
     !empty($_POST['trasa']) && isset($_POST['trasa'])) {
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
		} elseif ($velikost == "VX") {
			$velikost = "pozde";
		} else {
			$velikost = "46-47";
		} 

      if ($trasa == "dlouha") {
      	$trasa = "1";
      } else {
      	$trasa = "2";
      }

      $message = "Dobrý den,<br><br>právě jsme obdrželi Vaši elektronickou přihlášku na závod FORCE Chřibská 50/30 MTB.<br><br>Údaje pro bezhotovostní platbu startovného jsou:<br><br>Číslo účtu: <br><b>2216117143/0800</b><br><br> Váš variabilní symbol: <br><b>$sym</b><br><br>
     		 Startovné: <br>
     		 trasa <b>T50 - 390 Kč</b><br>trasa <b>T30 - 350 Kč</b><br><br>
			V den konání závodu při prezentaci je startovné <b>450 Kč</b>.<br>
			Při startovném uhrazeném do 30. 3. 2018 (ne včetně) je ve startovném zahrnut dárek v podobě originálních cyklistických ponožek.<br><br>Děkujeme za Vaši přihlášku a včasnou úhradu startovného. Těšíme se na Vaši účast.<br><br>Organizační tým<br><br>Údaje pro kontrolu:<br>Jméno: ".$_POST["jmeno"]."<br>Příjmení: ".$_POST["prijmeni"]."<br>Obec: ".$_POST["obec"]."<br>PSČ: ".$_POST["psc"]."<br>Klub: ".$_POST["klub"]."<br>Rok narození: ".$_POST["rn"]."<br>Trasa: ".$trasa_email."<br>Kategorie: ".$_POST["kategorie"]."<br>Loňské pořadí: ".$_POST["poradi"]."<br>Velikost ponožek: ".$velikost."<br><br>Pokud máte jakékoliv dotazy, či byste potřebovali upravit některý údaj v přihlášce, neváhejte nás kontaktovat na mountiny@gmail.com nebo prodejna@cyklosportchropyne.cz.";
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      mail($mail, "FORCE Chribska 50/30 MTB - Registrace 2018", $message, $headers);
      // $mailVlad = "vladimir.rm@seznam.cz";
      $mailVlad = "mikllhor@gmail.com";
      
      $messageVlad = "Přijmení: $prijmeni<br>Jméno: $jmeno<br>Obec: $obec<br>PSČ: $psc<br>E-mail: $mail<br>Rok narození: $rn<br>Kategorie: $kategorie<br>Trasa: $trasa<br>Klub: $klub<br>Var. symbol: $symbol<br>Pořadí z minulého roku: $poradi<br>Velikost ponožek: $velikost";
      mail($mailVlad, "Registrace závodníka", $messageVlad, $headers);

      mysqli_set_charset($connection,'utf8');

      mysqli_query($connection,"INSERT INTO zavodnici2018(prijmeni,jmeno,obec,psc,email,rok_narozeni,kategorie,tym,symbol,poradi,trasa,velikost) VALUES('$prijmeni','$jmeno','$obec','$psc','$mail','$rn','$kategorie','$klub','$symbol','$poradi','$trasa','$velikost')");

      // echo "Děkujeme za registraci, doufáme, že si závod užijete, jak jen to bude možné.";
      $connection->close();
      $_SESSION['success'] = "Registrace proběhla úspěšně, na Vámi uvedený email Vám byl odeslán variabilní symbol pro platbu převodem.";
      // header('location: http://www.cyklosportchropyne.cz/chribska/chribska_prihlaska.php?msg=success');

      //POZOR
      header('location: http://www.cyklosportchropyne.cz/chribska/chribska_prihlaska.php');
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
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cz">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cyklosport Chropyně</title>

	<link rel="stylesheet" type="text/css" href="../styles/style.css">
	<link rel="stylesheet" type="text/css" href="../styles/chribska.css">
	<link rel="stylesheet" type="text/css" href="../styles/formular.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="../script/jquery.shorten.js"></script>
	<script src="../script/modernizr.js"></script>
	<script type="text/javascript" src="../script/jquery.unveil.js"></script>
	<script type="text/javascript" src="../script/background.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	
<script>

$(document).ready(function() {

	$("nav.trigger ul li div img.ramForeground").hover(function() {
		$("nav.trigger ul li div img.ram").css("opacity", "0.5");
	}, function() {
		$("nav.trigger ul li div img.ram").css("opacity", "0.8");
	});

	function smoothScroll(target) {
        $('body,html').animate(
        	{'scrollTop':target.offset().top},
        	600
        );
	}

	$('.arrowDown').on('click', function(event){
        event.preventDefault();
        smoothScroll($(this.hash));
    });

});
$()
	
var lastScrollTop = 0, delta = 200;

   $(window).scroll(function(event){
       var st = $(this).scrollTop();
       var nav = $(".no-touch nav.menu");
       var navT = $("nav.trigger");
       var scrolled = false;
       
       if(Math.abs(lastScrollTop - st) <= delta)
          return;
       
       if (st > lastScrollTop){
           // downscroll code
           // console.log('scroll down');
           if (scrolled) {
           	nav.removeClass("fallDown");
           }
           nav.addClass("fallUp"); 
           nav.css("top", "-50");         
       } else {
	          // upscroll code
	          // console.log('scroll up');
	          nav.removeClass("fallUp");
	          nav.addClass("fallDown");
	          scrolled = true;
	          nav.css("top", "0");
       }
      	 lastScrollTop = st;
   });
$(window).load(function(){
	function showUpLogo() {
		$(".logo").addClass("fadeIn");
		$(".logo").css("opacity", "1");
		$(".logoMob").addClass("fadeIn");
		$(".logoMob").css("opacity", "1");
		$(".no-touch nav.menu").addClass("fallDown");
		$(".no-touch nav.menu").css("top", "0");
		$("nav.trigger").addClass("fallDown");
		$("nav.trigger").css("top", "0");
	}
	setTimeout(showUpLogo, 200); 
	var f1 = $('#f1');
	var f2 = $('#f2');
	var f3 = $('#f3');
	var s1 = $('#s1');
	var s2 = $('#s2');
	var s3 = $('#s3');
	var t1 = $('#t1');
	var t2 = $('#t2');
	var t3 = $('#t3');
var t4 = $('#t4');

	var neuplnaVlna = false; //Zda-li je na řadě neuplna vlna

	var ahojVar = $('section.content');

	function ahoj() {
		$('section.content').css("background-color", "yellow");
	}
	function rotateFirstAds() {

		f1.animate({

			opacity: 0,

		}, 500, function() {
			f1.removeClass("displayed");
			f1.addClass("hidden");
			f1.css("opacity", "1");

			f2.removeClass("hidden");
			f2.addClass("displayed");
			f2.css("opacity", "0");
			f2.animate({
			opacity: 1,
			}, 500, function() {
				setTimeout(rotateSecondAds, 2000);
			})
		});

		s1.animate({

			opacity: 0,

		}, 500, function() {
			s1.removeClass("displayed");
			s1.addClass("hidden");
			s1.css("opacity", "1");

			s2.removeClass("hidden");
			s2.addClass("displayed");
			s2.css("opacity", "0");

			s2.animate({
				opacity: 1,
			}, 500 )
		});

		t1.animate({

			opacity: 0,

		}, 500, function() {
			t1.removeClass("displayed");
			t1.addClass("hidden");
			t1.css("opacity", "1");

			t2.removeClass("hidden");
			t2.addClass("displayed");
			t2.css("opacity", "0");

			t2.animate({
				opacity: 1,
			}, 500 )
		});

	}
	function rotateSecondAds() {
		if(!neuplnaVlna) {
			f2.animate({

				opacity: 0,

			}, 500, function() {
				f2.removeClass("displayed");
				f2.addClass("hidden");
				f2.css("opacity", "1");

				f1.removeClass("hidden");
				f1.addClass("displayed");
				f1.css("opacity", "0");

				f1.animate({
					opacity: 1,
				}, 500, function() {
					setTimeout(rotateFirstAds, 2000);
				})
			});

			s2.animate({

				opacity: 0,

			}, 500, function() {
				s2.removeClass("displayed");
				s2.addClass("hidden");
				s2.css("opacity", "1");

				s1.removeClass("hidden");
				s1.addClass("displayed");
				s1.css("opacity", "0");

				s1.animate({
					opacity: 1,
				}, 500 )
			});

			t2.animate({

				opacity: 0,

			}, 500, function() {
				t2.removeClass("displayed");
				t2.addClass("hidden");
				t2.css("opacity", "1");

				t1.removeClass("hidden");
				t1.addClass("displayed");
				t1.css("opacity", "0");

				t1.animate({
					opacity: 1,
				}, 500 )
			});
		} else {
			f2.animate({

				opacity: 0,

			}, 500, function() {
				f2.removeClass("displayed");
				f2.addClass("hidden");
				f2.css("opacity", "1");

				f3.removeClass("hidden");
				f3.addClass("displayed");
				f3.css("opacity", "0");

				f3.animate({
					opacity: 1,
				}, 500, function() {
					setTimeout(rotateThirdAds, 2000);
				})
			});

			s2.animate({

				opacity: 0,

			}, 500, function() {
				s2.removeClass("displayed");
				s2.addClass("hidden");
				s2.css("opacity", "1");

				s3.removeClass("hidden");
				s3.addClass("displayed");
				s3.css("opacity", "0");

				s3.animate({
					opacity: 1,
				}, 500 )
			});

			t2.animate({

				opacity: 0,

			}, 500, function() {
				t2.removeClass("displayed");
				t2.addClass("hidden");
				t2.css("opacity", "1");

				t4.removeClass("hidden");
				t4.addClass("displayed");
				t4.css("opacity", "0");

				t4.animate({
					opacity: 1,
				}, 500 )
			});
		}

	}

	rotateFirstAds()
})
</script>

</head>
<body class="nav-is-fixed chribska" style="background-position: center 11%;"> <!-- nav-is-fixed overflow-y:hidden; background-image:url('../images/cyklo_masakr.jpg');-->
	<nav class="menu cd-nav">
		<ul id="cd-primary-nav" class="is-fixed menuFirstLayer cd-primary-nav">  <!-- is-fixed -->
			<li class="menuAktuality">
				<a href="../index.php">
					Aktuality
				</a>
			</li>
			<li class="menuCyklooddil has-children">
				<a href="../cyklooddil/cyklooddil.html">
					Cyklooddíl
				</a> 
				<ul class="menuSecondLayerCyklooddil hidden-submenu cd-secondary-nav is-hidden">
					<!-- <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil_clenove.html"> -->
					<li class="go-back">
						<a href="#cd-primary-nav">Zpět</a>
					</li>
					<li class="submenuClenove cyklooddilMob">
						<a class="cd-nav-item" href="../cyklooddil/cyklooddil.html">
							Výsledky
						</a>
					</li>
					<li class="submenuClenove">
						<a class="cd-nav-item" href="../cyklooddil/cyklooddil_clenove.html">
							Členové
						</a>
					</li>
					<!-- </a> -->
					<li class="submenuKalendar">
						<a class="cd-nav-item" href="../cyklooddil/cyklooddil_kalendar.html">
							Kalendář
						</a>
					</li>
					<li class="submenuArchiv">
						<a class="cd-nav-item" href="../cyklooddil/s2014.php">
							Archiv akt.
						</a>
					</li>
				</ul>
			</li>
			<li class="menuChribska has-children">
				<a style="font-weight: bold" href="chribska_propozice.html">
					FORCE Chřibská 50 MTB
				</a>
				<ul class="menuSecondLayerChribska hidden-submenu cd-secondary-nav is-hidden">
					<li class="go-back">
						<a href="#cd-primary-nav">Zpět</a>
					</li>					
					<li class="submenuPropozice">
						<a href="chribska_propozice.html">Propozice</a>
					</li>
					<li class="submenuPrihlaska">
						<a style="font-weight: bold" href="chribska_prihlaska.php">Přihláška</a>
					</li>
					<li class="submenuSeznam">
						<a href="chribska_seznam.php">
							Seznam přihlášených
						</a>
					</li>
					<li class="submenuMapa">
						<a href="chribska_mapa.html">
							Mapa
						</a>
					</li>
					<li class="submenuVysledky">
						<a href="chribska_vysledky.html">
							Výsledky
						</a>
					</li>
					<li class="submenuFotogalerie">
						<a href="chribska_foto.html">
							Fotogalerie
						</a>
					</li>

					
				</ul>
			</li>
			<li class="menuDetske has-children">
				<a href="../detske_zavody/detske_zavody.html">
								Dětské závody
							</a>
				<ul class="menuSecondLayerDetske hidden-submenu cd-secondary-nav is-hidden">
					<li class="go-back">
						<a href="#cd-primary-nav">Zpět</a>
					</li>
					<li class="detskeMobile">
						<a href="../detske_zavody/detske_zavody.html">Propozice</a>
					</li>
					<li class="submenuPrihlaskaD">
						<a href="../detske_zavody/detske_zavody_prihlaska.php">Přihláška</a>
					</li>
					<li class="submenuVysledkyD">
						<a href="../detske_zavody/detske_zavody_vysledky.html">
							Výsledky
						</a>
					</li>
					<li class="submenuFotogalerieD">
						<a href="https://www.flickr.com/photos/vilemeliv/albums">
							Fotogalerie
						</a>
					</li>
										
				</ul>
			</li>
			<li class="menuFotogalerie">
				<a href="https://www.flickr.com/photos/cschropyne/" target="_blank">
								Fotogalerie
							</a>
			</li>
			<li class="menuProdejna">
				<a href="../prodejna/prodejna.html">
							Prodejna
				</a>
			</li>
		</ul>
	</nav>
	<nav class="trigger cd-main-header">
		<ul class="cd-header-buttons">
			<li>
				<a class="cd-nav-trigger" href="#cd-primary-nav">
					Menu
					<span></span>
				</a>
				<a class="desktop-nav"  href="../index.php">
					<div class="burger-cont" >
						<img src="../images/ramS2.png" class="ram">
						<img src="../images/ramW.png" class="ramForeground">
					</div>
				</a>
				
			</li>
		</ul>
	</nav>
	<section id="section2" class="content cd-main-content" style="overflow-y:hidden;">
	<!-- <div class="aktualita"> -->
		<div class="aktualita propozice">

			<div style="margin:0 auto 30px auto;" class="textPropozic podtrzene">
			
			<h1 id="nadpis" style="color:black;">Přihláška</h1>
			
			<br>
			<a href="http://www.force.cz" target="_blank">
			<img src="../images/powered_by_force.png" class="powered">
			</a>

			</div>

			<div style="margin: 30 auto; display:block;" class="textPropozic">

				ONLINE přihlašování bylo ukončeno. Přihlásit se můžete ještě na výstavišti Floria v pátek, nebo v den závodu.
				<?php 
					session_unset();
				 ?>
			</div>

		</div>
		<div id="dialog" title="Alert message" style="display: none;">
    <div class="ui-dialog-content ui-widget-content">
        <p> <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0"></span>

            <label id="lblMessage"></label>
        </p>
    </div>
</div>
			
		<div class="cd-overlay"></div>
		
		

	</section>

	<div class="footer" style="position:fixed;">
		
		<div class="reklamy chribskaSponzori" style="text-align:center; position:absolute; top:0;left:0; width:100%; height:100%;">
			<a id="f1" href="http://www.mesto-kromeriz.cz" class="displayed" target="_blank">
				<img class="reklama levaReklama" src="../images/sponsors/km-white.png"></a>
			<a id="s1" href="http://www.force.cz" class="displayed" target="_blank">
				<img class="reklama stredníReklama" src="../images/sponsors/logo-force-white.png" style="max-width:25%;"></a>
			<a id="t1" href="http://www.elmo.cz/en/" class="displayed" target="_blank">
				<img class="reklama pravaReklama" src="../images/loga/elmo_Logo.png" class="demaLogo"></a>
			<a id="f2" href="http://www.kruzik.cz" class="hidden" target="_blank">
				<img class="reklama levaReklama" src="../images/loga/kruzik_Logo.png"></a>
			<a id="s2" href="http://www.force.cz" class="hidden" target="_blank">
				<img class="reklama stredniReklama" src="../images/sponsors/logo-force-white.png" style="max-width:25%;"></a>
			<a id="t2" href="http://www.kr-zlinsky.cz" class="hidden" target="_blank">
				<img class="reklama pravaReklama" src="../images/loga/zl_kraj_Logo.png"></a>
			
				</div>

	</div>
<script type="text/javascript">
	$(document).ready(function () {

		$(window).scroll(function(){
			var topOfWindow = $(window).scrollTop();

			$("img.lazyload").each(function(){

				var imagePos = $(this).offset().top;

				if (imagePos <= topOfWindow + 1000 && imagePos >= topOfWindow - 400) {

					$(this).unveil();

				}

			});

			


		});


		// $("img.lazyload").unveil(1000, function() {
				
		// 	$(this).load(function() {
		// 		this.style.opacity = 1;
		// 	});
		// });
	});
</script>

<script type="text/javascript">
	$(document).ready(function(){
		$(".comment").shorten({
			"showChars" : 400,
			"moreText" : "Více",
			"lessText" : "Méně",
		});
	});
</script>
<script type="text/javascript">
	// function doOnOrientationChange()
 //  {
 //    switch(window.orientation) 
 //    {  
 //      case -90:
 //      case 90:
        
 //        getViewport()
 //        break; 
 //      default:
 //      	getViewport()
        
 //        break; 
 //    }
 //  }

 //  window.addEventListener('orientationchange', doOnOrientationChange);

 //  // Initial execution if needed
 //  doOnOrientationChange();

	var alreadyResized = false;
	

	var isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
	};


	function getViewportOfMobile() {

		if (alreadyResized) {
			return;
		}

		alreadyResized = true;
		
		 var viewPortWidth;
		 var viewPortHeight;

		 // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
		 if (typeof window.innerWidth != 'undefined') {
		   viewPortWidth = window.innerWidth,
		   viewPortHeight = window.innerHeight
		 }

		// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
		 else if (typeof document.documentElement != 'undefined'
		 && typeof document.documentElement.clientWidth !=
		 'undefined' && document.documentElement.clientWidth != 0) {
		    viewPortWidth = document.documentElement.clientWidth,
		    viewPortHeight = document.documentElement.clientHeight
		 }

		 // older versions of IE
		 else {
		   viewPortWidth = document.getElementsByTagName('body')[0].clientWidth,
		   viewPortHeight = document.getElementsByTagName('body')[0].clientHeight
		 }
		 // return [viewPortWidth, viewPortHeight];
		 var section = document.getElementsByTagName('section')
		 for (var i = 0; i < section.length - 1; i++) {
		 	section[i].style.height = parseInt(viewPortHeight - 80) + 'px'
		 }

	}

	function getScreenSize() {

		if (alreadyResized) {
			return;
		}

		alreadyResized = true;

		var screenWidth;
		var screenHeight;

		if (typeof screen.width != 'undefined') {
			screenWidth = screen.width,
			screenHeight = screen.height
		}

		var section = document.getElementsByTagName('section')
		for (var i = 0; i < section.length; i++) {
			if (window.matchMedia("(orientation: portrait)").matches) {
		 		section[i].style.height = parseInt(screenHeight - 35) + 'px'
		 	}else {
		 		section[i].style.height = parseInt(screenWidth) + 'px'
		 	}
		 }

	}
	function updateBgWidth() {
		var viewPortWidth;
		 var viewPortHeight;

		 // the more standards compliant browsers (mozilla/netscape/opera/IE7) use window.innerWidth and window.innerHeight
		 if (typeof window.innerWidth != 'undefined') {
		   viewPortWidth = window.innerWidth,
		   viewPortHeight = window.innerHeight

		 }

			// IE6 in standards compliant mode (i.e. with a valid doctype as the first line in the document)
		 else if (typeof document.documentElement != 'undefined'
		 && typeof document.documentElement.clientWidth !=
		 'undefined' && document.documentElement.clientWidth != 0) {
		    viewPortWidth = document.documentElement.clientWidth,
		    viewPortHeight = document.documentElement.clientHeight
		 }

			 // older versions of IE
		 else {
		   viewPortWidth = document.getElementsByTagName('body')[0].clientWidth,
		   viewPortHeight = document.getElementsByTagName('body')[0].clientHeight
		 }
			 // return [viewPortWidth, viewPortHeight];
			 // var section = document.getElementsByTagName('section')
			 // for (var i = 0; i < section.length; i++) {
			 // 	section[i].style.height = parseInt(viewPortHeight) + 'px'
			 // }

		 var body = document.getElementsByTagName("body");
		 // alert('už');
		 if (viewPortWidth >= 1920) {
		 	// alert('už');
		 	body[0].style.backgroundSize = parseInt(viewPortWidth) + 'px auto';
		 };
		 if (viewPortHeight >= 1200) {
		 	body[0].style.backgroundSize = 'auto' + parseInt(viewPortHeight) + 'px';
		 };
		 
	}
	window.addEventListener("resize", updateBgWidth);
	window.addEventListener("load", updateBgWidth);

	function rotationBackdoor() {
		alreadyResized = false;
	}


	if (isMobile.any()) {
		
		var isiPad = navigator.userAgent.match(/iPad/i) != null;
		if (isiPad) {
			// window.onresize = getViewportOfMobile;
		}else {
			// window.onresize = getScreenSize;
		}
		
				
	}else {
		// window.onresize = getViewport;
	}
</script>
	<script>
	jQuery(document).ready(function($){
	//if you change this breakpoint in the style.css file (or _layout.scss if you use SASS), don't forget to update this value as well
	var MqL = 9878;
	//move nav element position according to window width
	moveNavigation();
	// $(window).on('resize', function(){
	// 	(!window.requestAnimationFrame) ? setTimeout(moveNavigation, 300) : window.requestAnimationFrame(moveNavigation);
	// });

	//mobile - open lateral menu clicking on the menu icon
	$('.cd-nav-trigger').on('click', function(event){
		event.preventDefault();
		if( $('.cd-main-content').hasClass('nav-is-visible') ) {
			closeNav();
			$('.cd-overlay').removeClass('is-visible');
		} else {
			$(this).addClass('nav-is-visible');
			$('.cd-primary-nav').addClass('nav-is-visible');
			// $('.cd-primary-nav').addClass('moveLeft');
			$('.cd-main-header').addClass('nav-is-visible');
			$('#intro').addClass('nav-is-visible');
			$('div.footer').addClass('nav-is-visible');
			$('.cd-main-content').addClass('nav-is-visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
				$('body').addClass('overflow-hidden');
			});
			toggleSearch('close');
			$('.cd-overlay').addClass('is-visible');
		}
	});

	//open search form
	$('.cd-search-trigger').on('click', function(event){
		event.preventDefault();
		toggleSearch();
		closeNav();
	});

	//close lateral menu on mobile 
	$('.cd-overlay').on('swiperight', function(){
		if($('.cd-primary-nav').hasClass('nav-is-visible')) {
			closeNav();
			$('.cd-overlay').removeClass('is-visible');
		}
	});
	$('.nav-on-left .cd-overlay').on('swipeleft', function(){
		if($('.cd-primary-nav').hasClass('nav-is-visible')) {
			closeNav();
			$('.cd-overlay').removeClass('is-visible');
		}
	});
	$('.cd-overlay').on('click', function(){
		closeNav();
		toggleSearch('close')
		$('.cd-overlay').removeClass('is-visible');
	});


	//prevent default clicking on direct children of .cd-primary-nav 
	$('.cd-primary-nav').children('.has-children').children('a').on('click', function(event){
		event.preventDefault();
	});
	//open submenu
	$('.has-children').children('a').on('click', function(event){
		if( checkWindowWidth() ) event.preventDefault();
		var selected = $(this);
		if( selected.next('ul').hasClass('is-hidden') ) {
			//desktop version only
			selected.addClass('selected').next('ul').removeClass('is-hidden').end().parent('.has-children').parent('ul').addClass('moves-out');
			selected.parent('.has-children').siblings('.has-children').children('ul').addClass('is-hidden').end().children('a').removeClass('selected');
			$('.cd-overlay').addClass('is-visible');

		} else {
			selected.removeClass('selected').next('ul').addClass('is-hidden').end().parent('.has-children').parent('ul').removeClass('moves-out');
			$('.cd-overlay').removeClass('is-visible');
		}
		toggleSearch('close');
	});

	//submenu items - go back link
	$('.go-back').on('click', function(){
		$(this).parent('ul').addClass('is-hidden').parent('.has-children').parent('ul').removeClass('moves-out');
	});

	function closeNav() {
		$('.cd-nav-trigger').removeClass('nav-is-visible');
		$('.cd-main-header').removeClass('nav-is-visible');
		$('.cd-primary-nav').removeClass('nav-is-visible');
		// $('.cd-primary-nav').removeClass('moveLeft');
		// $('.cd-primary-nav').addClass('moveRight');
		$('.has-children ul').addClass('is-hidden');
		$('.has-children a').removeClass('selected');
		$('.moves-out').removeClass('moves-out');
		$('div.footer').removeClass('nav-is-visible');
		$('#intro').removeClass('nav-is-visible');
		$('.cd-main-content').removeClass('nav-is-visible').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			$('body').removeClass('overflow-hidden');
		});
	}

	function toggleSearch(type) {
		if(type=="close") {
			//close serach 
			$('.cd-search').removeClass('is-visible');
			$('.cd-search-trigger').removeClass('search-is-visible');
		} else {
			//toggle search visibility
			$('.cd-search').toggleClass('is-visible');
			$('.cd-search-trigger').toggleClass('search-is-visible');
			if($(window).width() > MqL && $('.cd-search').hasClass('is-visible')) $('.cd-search').find('input[type="search"]').focus();
			($('.cd-search').hasClass('is-visible')) ? $('.cd-overlay').addClass('is-visible') : $('.cd-overlay').removeClass('is-visible') ;
		}
	}

	function checkWindowWidth() {
		//check window width (scrollbar included)
		var e = window, 
            a = 'inner';
        if (!('innerWidth' in window )) {
            a = 'client';
            e = document.documentElement || document.body;
        }
        if ( e[ a+'Width' ] >= MqL ) {
			return true;
		} else {
			return false;
		}
	}

	function moveNavigation(){
		var navigation = $('.cd-nav');
  		var desktop = checkWindowWidth();
        if ( desktop ) {
			navigation.detach();
			navigation.insertBefore('.cd-header-buttons');
		} else {
			navigation.detach();
			navigation.insertAfter('.cd-main-content');
		}
	}
});</script>
<script type="text/javascript">
	;(function($){
    $.fn.extend({
        donetyping: function(callback,timeout){
            timeout = timeout || 1e3; // 1 second default timeout
            var timeoutReference,
                doneTyping = function(el){
                    if (!timeoutReference) return;
                    timeoutReference = null;
                    callback.call(el);
                };
            return this.each(function(i,el){
                var $el = $(el);
                // Chrome Fix (Use keyup over keypress to detect backspace)
                // thank you @palerdot
                $el.is(':input') && $el.on('keyup keypress paste',function(e){
                    // This catches the backspace button in chrome, but also prevents
                    // the event from triggering too preemptively. Without this line,
                    // using tab/shift+tab will make the focused element fire the callback.
                    if (e.type=='keyup' && e.keyCode!=8) return;
                    
                    // Check if timeout has been set. If it has, "reset" the clock and
                    // start over again.
                    if (timeoutReference) clearTimeout(timeoutReference);
                    timeoutReference = setTimeout(function(){
                        // if we made it here, our timeout has elapsed. Fire the
                        // callback
                        doneTyping(el);
                    }, timeout);
                }).on('blur',function(){
                    // If we can, fire the event since we're leaving the field
                    doneTyping(el);
                });
            });
        }
    });
})(jQuery);

$(document).ready(function() {
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


    });

	$("nav.trigger").hover(function(){
		var nav = $(".no-touch nav.menu");
        var navT = $("nav.trigger");
        nav.removeClass("fallUp");
        nav.addClass("fallDown");
        nav.css("top", "0");
	});
});
</script>

</body>
</html>
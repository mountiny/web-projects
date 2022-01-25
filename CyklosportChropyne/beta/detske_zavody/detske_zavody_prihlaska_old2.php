<?php 
session_start();
    include 'db_active_deti.php';
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


  if (!empty($_POST['jmeno']) && isset($_POST['jmeno']) && 
     !empty($_POST['prijmeni']) &&  isset($_POST['prijmeni']) &&
     !empty($_POST['obec']) && isset($_POST['obec']) &&  
     !empty($_POST['rn']) && isset($_POST['rn']) ) {

    
  	if ($_POST['g-recaptcha-response']) {
  		if ($_POST['rn'] > 1999 && $_POST['rn'] < 2015) {
	  			
	      
	      
	      // if (!empty($_POST['mail']) && isset($_POST['mail'])) {
	      //   $mail = mysqli_real_escape_string($connection,$_POST['mail']);
	      // } else {
	      //   $mail = mysqli_real_escape_string($connection,"-");
	      // }
	      $rok_kdy_se_narodil = $_POST['rn'];
	      if (isset($_POST['odrazedlo']) && $rok_kdy_se_narodil <= 2011) {
	      	$recaptcha = "<p style='color:red;'>Vím, že odrážedla jsou super, ale nebylo by to trochu nefér?</p>";
	      } else {
	      		if (isset($_POST['odrazedlo']) && $rok_kdy_se_narodil >= 2012) {
			      	$kategorie = mysqli_real_escape_string($connection,"A");
			    } elseif ($rok_kdy_se_narodil >= 2011) {
				      	$kategorie = mysqli_real_escape_string($connection,"B");
				} elseif ($rok_kdy_se_narodil >= 2009) {
				      	$kategorie = mysqli_real_escape_string($connection,"C");
				} elseif ($rok_kdy_se_narodil >= 2007) {
				      	$kategorie = mysqli_real_escape_string($connection,"D");
				} elseif ($rok_kdy_se_narodil >= 2005) {
				      	$kategorie = mysqli_real_escape_string($connection,"E");
				} elseif ($rok_kdy_se_narodil >= 2003) {
				      	$kategorie = mysqli_real_escape_string($connection,"F");
				} else{
				      	$kategorie = mysqli_real_escape_string($connection,"G");
				}

				if (!empty($_POST['klub']) && isset($_POST['klub'])) {
			        $klub = mysqli_real_escape_string($connection,$_POST['klub']);
			      } else {
			        $klub = mysqli_real_escape_string($connection,"-");
			      }

				$mail = mysqli_real_escape_string($connection,$_POST['mail']);
				$jmeno = mysqli_real_escape_string($connection,$_POST['jmeno']);
				$prijmeni = mysqli_real_escape_string($connection,$_POST['prijmeni']);
				$obec = mysqli_real_escape_string($connection,$_POST['obec']);
				$psc = mysqli_real_escape_string($connection,$_POST['psc']);
				$rn = mysqli_real_escape_string($connection,$_POST['rn']);
				      // $kategorie = mysqli_real_escape_string($connection,$_POST['kategorie']);

				      // $message = "Dobrý den,\n\nprávě jsme obdrželi Vaši elektronickou přihlášku na závod FORCE Chřibská 50ka MTB.\n\nÚdaje pro bezhotovostní platbu startovného jsou:\n\nČíslo účtu: 2216117143/0800\n\n Váš variabilní symbol: $sym\n\n\nDěkujeme za Vaši přihlášku a včasnou úhradu startovného. Těšíme se na Vaši účast.\n\nOrganizační tým";
				      // mail($mail, "Chribska 50ka MTB - Registrace", $message);
				      // $mailVlad = "vladimir.rm@seznam.cz";
				      
				      $messageVlad = "Přijmení: $prijmeni\nJméno: $jmeno\nObec: $obec\nPSČ: $psc\nE-mail: $mail\nRok narození: $rn\nKategorie: $kategorie\nKlub: $klub\nVar. symbol: $symbol\nPořadí z minulého roku: $poradi";
				      // mail($mailVlad, "Registrace zavodnika", $messageVlad);

				      mysqli_set_charset($connection,'utf8');

				      mysqli_query($connection,"INSERT INTO deti(prijmeni,jmeno,obec,rok_narozeni,kategorie,klub) VALUES('$prijmeni','$jmeno','$obec','$rn','$kategorie','$klub')");

				      // echo "Děkujeme za registraci, doufáme, že si závod užijete, jak jen to bude možné.";
				      $connection->close();
				      header('location: http://www.cyklosportchropyne.cz/detske_zavody/detske_zavody_prihlaska.php?msg=success');
				      exit();
	      	
	      }
		      
	      		// include 'redirect.php';

	      
	      
	  	} else {
	  		$recaptcha = "<p style='color:red;'>Rok narození poněkud neodpovídá limitům.</p>";
	  	}
	  } else {
	  	// recaptcha();
	  	$recaptcha = "<p style='color:red;'>Nezatrhli jste recaptchu.</p>";
	}
    

  } elseif (!empty($_POST['jmeno']) || isset($_POST['jmeno']) || 
     !empty($_POST['prijmeni']) ||  isset($_POST['prijmeni']) ||
     !empty($_POST['obec']) || isset($_POST['obec']) ||  
     !empty($_POST['rn']) || isset($_POST['rn']) ) {
  	
  	// echo "<p style='color:red;'>Nevyplnili jste všechna požadovaná pole.</p>";
  	// nevyplneno();
  	$nevyplnenoEcho = "<p style='color:red;'>Nevyplnili jste všechna požadovaná pole.</p>";

  } else {

    

  }
    // $connection->close();

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cz">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cyklosport Chropyně</title>

	<link rel="stylesheet" type="text/css" href="../styles/style.css">
	<link rel="stylesheet" type="text/css" href="../styles/chribska.css">
	<link rel="stylesheet" type="text/css" href="../styles/formular.css">
	<link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="../script/jquery.shorten.js"></script>
	<script src="../script/modernizr.js"></script>
	<script type="text/javascript" src="../script/jquery.unveil.js"></script>
	<script type="text/javascript" src="../script/background.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript" src="../script/cufon-yui.js"></script>
	<script type="text/javascript" src="../fonts/Avenir.font.js"></script>
	
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

$(document).ready(function() {
	var prevence = 0;
	$("#kontrolaButton").click(function() {

		var rok_nar = $('#rok_nar').val();

		if (rok_nar < 1997 || rok_nar > 2015) {
			if (rok_nar = "") {
				rok_nar = "- nenarodil";
			};
			alert("Opravdu jste se narodil v roce " + rok_nar + "?");
			return;
		};

      // var obsahPole = $("#kontrola").val();
      
      // alert(obsahPole);

      // alert(prvniCislo);

      // if (!obsahPole) {
      	
      	if (prevence == 0) {
      		$("#odeslatButton").trigger('click');
      		prevence = 1;
      	};

        // $("#odeslatButton").trigger('click');..

      // } else {

      //   $("#nadpis").text("You spamBot! How you dare?!");

      // };

    });

	$("nav.trigger").hover(function(){
		var nav = $(".no-touch nav.menu");
        var navT = $("nav.trigger");
        nav.removeClass("fallUp");
        nav.addClass("fallDown");
        nav.css("top", "0");
	});
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
<body class="nav-is-fixed chribska deti" style="background-image:url('../images/cyklo_masakr.jpg');"> <!-- nav-is-fixed -->
	<nav class="menu cd-nav">
		<ul id="cd-primary-nav" class="is-fixed menuFirstLayer cd-primary-nav">  <!-- is-fixed -->
			<li class="menuAktuality">
				<a href="../index.html">
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
						<a class="cd-nav-item" href="../cyklooddil/s2014.html">
							Akt. 2014
						</a>
					</li>
				</ul>
			</li>
			<li class="menuChribska has-children">
				<a href="../chribska/chribska_propozice.html">
					FORCE Chřibská 50 MTB
				</a>
				<ul class="menuSecondLayerChribska hidden-submenu cd-secondary-nav is-hidden">
					<li class="go-back">
						<a href="#cd-primary-nav">Zpět</a>
					</li>					
					<li class="submenuPropozice">
						<a href="../chribska/chribska_propozice.html">Propozice</a>
					</li>
					<li  class="submenuPrihlaska">
						<a href="../chribska/chribska_prihlaska.php">Přihláška</a>
					</li>
					<li class="submenuSeznam">
						<a href="../chribska/chribska_seznam.php">
							Seznam přihlášených
						</a>
					</li>
					<li class="submenuMapa">
						<a href="../chribska/chribska_mapa.html">
							Mapa
						</a>
					</li>
					<li class="submenuVysledky">
						<a href="../chribska/chribska_vysledky.html">
							Výsledky
						</a>
					</li>
					<li class="submenuFotogalerie">
						<a href="../chribska/chribska_foto.html">
							Fotogalerie
						</a>
					</li>
					
				</ul>
			</li>
			<li class="menuDetske has-children">
				<a style="font-weight: bold" href="detske_zavody.html">
								Dětské závody
							</a>
				<ul class="menuSecondLayerDetske hidden-submenu cd-secondary-nav is-hidden">
					<li class="go-back">
						<a href="#cd-primary-nav">Zpět</a>
					</li>
					<li class="detskeMobile">
						<a href="detske_zavody.html">Propozice</a>
					</li>
					<li class="submenuPrihlaskaD">
						<a style="font-weight: bold" href="detske_zavody_prihlaska.php">Přihláška</a>
					</li>
					<li class="submenuVysledkyD">
						<a href="detske_zavody_vysledky.html">
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
				<a class="desktop-nav"  href="../index.html">
					<div class="burger-cont" >
						<img src="../images/ramS2.png" class="ram">
						<img src="../images/ramW.png" class="ramForeground">
					</div>
				</a>
				
			</li>
		</ul>
	</nav>
	<section id="section2" class="content cd-main-content">
	
		<div class="aktualita propozice" style="padding-bottom: 0px;">

			<div style="margin:0 auto 30px auto;" class="textPropozic podtrzene">
			
			<h1 id="nadpis" style="color:black;">Přihláška</h1>
			
			<br>
			<a href="http://www.force.cz" target="_blank">
			<img src="../images/powered_by_force.png" class="powered">
			</a>

			</div>

			<div style="margin: 30 auto; display:block;" class="textPropozic">

			<?php 
				
					echo $nevyplnenoEcho;				
					echo $recaptcha;
			 ?>

				<form accept-charset="utf-8" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<table border="0" cellpadding="10" cellspacing="0" > <!-- width="100%" -->
					<tr> 
						<!-- <td> <b>Jméno:</b></td>  -->
						<td> <input class="bold" type="text" name="jmeno" placeholder="Jméno"></td> 
						<!-- <td> <b>Příjmení:</b></td>  -->
						<td> <input class="bold" type="text" name="prijmeni" placeholder="Příjmení"></td>
					</tr>
					<tr> 
						<!-- <td> <b>Obec:</b></td>  -->
						<td> <input class="bold" type="text" name="obec" placeholder="Obec"></td> 
						<!-- <td> <b>PSČ:</b></td>  -->
						<td> <input type="text" name="klub" placeholder="Klub"></td> 
					</tr>
					<tr> 
						<!-- <td> Klub</td>  -->

						<!-- <td> <b>Rok narození</b></td>  -->
						<td> <input class="bold" id="rok_nar" type="text" name="rn" placeholder="Rok narození"></td>

						<td> <input type="checkbox" name="odrazedlo">&nbsp Odrážedlo</td>
					</tr>
					<tr> 
						<!-- <td> Váš e-mail:</td>  -->
						<!-- <td> <input class="bold" type="email" name="mail" placeholder="E-mail"></td>  -->
						<!-- <td> Odrážedlo: </td> 
						<td> <input type="checkbox" name="odrazedlo"> </td> </tr> -->
						<!-- <td> <b>Kategorie</b></td>  -->
						<!-- <td> <select name="kategorie" size="1"> 
							<option class="bold" value="" disabled selected> Kategorie
							<option value="J"> junioři 
							<option value="M19-29"> M - muži 19-29 
							<option value="M30-39"> MI - muži 30-39 
							<option value="M40-49"> MII - muži 40-49 
							<option value="M50-59"> MIII - muži 50-59 
							<option value="M60+"> MIV - muži 60 a starší 
							<option value="Ž35"> ženy I 35 a méně 
							<option value="Ž36+"> ženy II 36 a více
						</select></td> -->
					</tr>
					
					<tr> <td> <b>Tučné nutno vyplnit! (Kategorii také)</b></td> 
					<!-- <td><input id="kontrola" style="visibility: hidden;" autocomplete="off" type="text" name="password"></td> -->
					</tr>

					<tr><td colspan="2"> Přihláška bohužel není plně kompatibilní s prohlížeči na Windows XP a Windows XP Professional. </td></tr>

					<tr><td colspan="2">Propozice beru na vědomí a závodu se zúčastním na vlastní nebezpečí. 
					Seznámil(a) jsem se s bezpečnostními předpisy, které se zavazuji dodržovat. 
					Prohlašuji,že jsem si vědom(a) toho, že nesu veškerou zodpovědnost za škodu způsobenou na zdraví nebo věcech, 
					která vznikne mně, pořadateli nebo třetím osobám před, během či po závodě. Budu dodržovat pravidla fair-play, 
					budu se chovat šetrně k přírodě. Plná přilba povinná. </td></tr>
					<tr><td colspan="2"><b>Za osoby mladších 18 let přihlášku odesílá jejich zákonný zástupce.</b></td></tr>
				 
				<!-- <img src = "formular.php?generuj" alt="code" id="captcha"/>  -->
				<!-- <p id="priklad">
				  <?php 

				$firstRandomNumber = rand(0,9);
				$secondRandomNumber = rand(0,9);

				$soucet = $firstRandomNumber + $secondRandomNumber;

				$_SESSION['vysledek'] = $soucet;

				echo "<span id='prvni'>$firstRandomNumber</span> + <span id='druhy'>$secondRandomNumber</span> =";

				?>
				</p> 
				Výsledek: -->
				<!-- <input type="text" name="soucet" size="24" id="zadanyVysledek" />  -->
				<!-- (nutno vyplnit zvýrazněné znaky)  -->
				<tr><td>

				<div class="g-recaptcha" data-sitekey="6LeszgATAAAAACM9y4mQlwb6rfwDfPvab1Bduguv"></div>
				<br>
				<input type="button" value="Odeslat" name="kontrola" id="kontrolaButton" /> 
				<input type="submit" value="Odeslat" name="odeslat" id="odeslatButton" style="visibility: hidden;" /></td></tr>
				
				<!-- <tr><td><input type="button" value="Obnovit" onClick="window.location.reload()"/></td></tr> -->
				
				<tr><td colspan="2"> Pořadatel se zavazuje, že Vaše osobní údaje neposkytne třetí osobě a zajistí jejich ochranu v souladu se zákonem č. 101 / 2000 Sb., o ochraně osobních údajů.</td></tr>
				<!-- <tr><td colspan="2"> V případě problémů s registrací nás prosím kontaktujte na tento <a href="mailto:mountiny@gmail.com">e-mail.</a></td></tr> -->
				</table>
				</form>

			</div>

		</div>
		<div id="dialog" title="Alert message" style="display: none;">
    <div class="ui-dialog-content ui-widget-content">
        <p> <span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0"></span>

            <label id="lblMessage"></label>
        </p>
    </div>
</div>
<div class="aktualita" style="padding-bottom: 200px;">
			<div style="margin:0 auto 40px auto;" class="textPropozic podtrzene">
			
			<h1 id="nadpis" style="color:black;">Seznam<b>přihlášených</b></h1>
			
			<br>
			<a href="http://www.force.cz" target="_blank">
			<img src="../images/powered_by_force.png" class="powered">
			</a>

			</div>
			<div class="textPropozic">
				<!-- <table class="seznamPrihlasenych"> -->
					<!-- <table class="seznamPrihlasenych" rules="rows">
						<thead><tr><td>Příjmení</td> <td>Jméno</td><td>Rok nar.</td><td>Kategorie</td><td>Tým</td><td>Zaplaceno</td></tr></thead>
						<tbody>
							<tr><td>Horáček</td> <td>Vít</td><td>1997</td><td>J</td><td>CYKLOSPORT CHROPYNĚ</td><td>NE</td></tr>
							<tr><td>Horáček</td> <td>Vít</td><td>1997</td><td>J</td><td>CYKLOSPORT CHROPYNĚ</td><td>NE</td></tr>
							<tr><td>Horáček</td> <td>Vít</td><td>1997</td><td>J</td><td>CYKLOSPORT CHROPYNĚ</td><td>NE</td></tr>
							<tr><td>Horáček</td> <td>Vít</td><td>1997</td><td>J</td><td>CYKLOSPORT CHROPYNĚ</td><td>NE</td></tr>
						</tbody>
					</table> -->
					<?php
					include 'db_active_deti.php';
					$connection->set_charset("utf8");
					$sql2 = "SELECT id, prijmeni, jmeno, obec, rok_narozeni, kategorie, klub FROM deti ORDER BY  `deti`.`kategorie`, `deti`.`prijmeni` ASC";
					$result2 = $connection->query($sql2);
					if ($result2->num_rows > 0) {
						echo "<table class='seznamPrihlasenych' rules='rows'> <thead><tr> <td>Kategorie</td> <td>Příjmení</td> <td>Jméno</td><td>Obec</td><td>Rok nar.</td><td>Tým</td></tr></thead><tbody>";
						while ($row = $result2->fetch_assoc()) {
		
						
							echo "<tr><td>".$row["kategorie"]."</td><td>".$row["prijmeni"]."</td><td>".$row["jmeno"]."</td><td>".$row["obec"]."</td><td>".$row["rok_narozeni"]."</td><td>".$row["klub"]."</td></tr>";

						}
						echo "</tbody></table>"; 
					}else {
							echo "<div class='position:relative; margin: 0px auto; top: 0;'>Prozatím se nikdo nepřihlásil.</div>";
						}
  
 					$connection->close();
					?>
				<!-- </table> -->
			</div>	
		</div>
		<div class="cd-overlay"></div>
		
		

	</section>

	<div class="footer" style="position:fixed;">
		
		<div class="adCont">
			<div class="firstColumn">
				<div id="f1" class="displayed">
					<a href="http://www.ktm-bikes.at" target="_blank"><img src="../images/sponsors/ktm.png"></a>
				</div>
				<div id="f2" class="hidden">
					<a href="http://www.campagnolo.com/WW/en" target="_blank"><img src="../images/sponsors/campagnolo.png"></a>
				</div>
				<div id="f3" class="hidden">
					<a href="http://www.dema-bicycles.com" target="_blank"><img src="../images/sponsors/dema.png" class="demaLogo"></a>
				</div>
			</div>
			<div class="secondColumn">
				<div id="s1" class="displayed">
					<a href="http://www.dtswiss.com/Home" target="_blank"><img src="../images/sponsors/dtswiss.png"></a>
				</div>
				<div id="s2" class="hidden">
					<a href="http://www.force.cz" target="_blank"><img style="max-height:40px;" src="../images/sponsors/logo-force-white.png"></a>	
				</div>
				<div id="s3" class="hidden">
					<a href="http://www.mrxbike.com" target="_blank"><img src="../images/sponsors/mrx.png"></a>
				</div>
			</div>
			<div class="thirdColumn">
				<div id="t1" class="displayed">
					<a href="http://www.rockmachine.us/en/home/" target="_blank"><img src="../images/sponsors/rockmachine.png"></a>
				</div>
				<div id="t2" class="hidden">
					<a href="http://cycle.shimano-eu.com" target="_blank"><img src="../images/sponsors/shimano.png"></a>
				</div>
				<div id="t3" class="hidden">
					<a href="http://superiorbikes.eu/cz/uvod/" target="_blank"><img src="../images/sponsors/superior.png"></a>
				</div>
				<div id="t4" class="hidden">
					<a href="http://www.enervitcz.cz" target="_blank"><img src="../images/sponsors/enervit.png"></a>
				</div>
			</div>
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
Cufon.now();</script>

</body>
</html>
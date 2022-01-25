<?php 
session_start();
    include 'db_active_deti.php';

	$connection->set_charset("utf8");

if (!empty($_POST['jmeno']) && isset($_POST['jmeno'])) {
		$_SESSION['jmeno'] = $_POST['jmeno'];
	}
if (!empty($_POST['prijmeni']) && isset($_POST['prijmeni'])) {
		$_SESSION['prijmeni'] = $_POST['prijmeni'];
	}
if (!empty($_POST['bydliste']) && isset($_POST['bydliste'])) {
		$_SESSION['bydliste'] = $_POST['bydliste'];
	}
if (!empty($_POST['klub']) && isset($_POST['klub'])) {
		$_SESSION['klub'] = $_POST['klub'];
	}
if (!empty($_POST['rn']) && isset($_POST['rn'])) {

	if (!empty($_POST['prostredek']) && isset($_POST['prostredek'])) {
		if ($_POST['prostredek'] == "odrazedlo") {
			$kat = "A";
		} elseif ($_POST['rn'] == "2015" || $_POST['rn'] == "2014" || $_POST['rn'] == "2013" || $_POST['rn'] == "2012") {
			$kat = "B";
		} elseif ($_POST['rn'] == "2011" || $_POST['rn'] == "2010") {
			$kat = "C";
		} elseif ($_POST['rn'] == "2009" || $_POST['rn'] == "2008") {
			$kat = "D";
		} elseif ($_POST['rn'] == "2007" || $_POST['rn'] == "2006") {
			$kat = "E";
		} elseif ($_POST['rn'] == "2005" || $_POST['rn'] == "2004") {
			$kat = "F";
		} elseif ($_POST['rn'] == "2003" || $_POST['rn'] == "2002" || $_POST['rn'] == "2001") {
			$kat = "G";
		} else {
		}
	}
		
}

  if (!empty($_POST['jmeno']) && isset($_POST['jmeno']) && 
     !empty($_POST['prijmeni']) &&  isset($_POST['prijmeni']) &&
     !empty($_POST['bydliste']) && isset($_POST['bydliste']) &&
     !empty($_POST['rn']) && isset($_POST['rn']) &&
     !empty($_POST['prostredek']) && isset($_POST['prostredek']) &&
     !empty($_POST['pohlavi']) && isset($_POST['pohlavi'])) {

    
  	if ($_POST['g-recaptcha-response']) {

  		$kategorie = mysqli_real_escape_string($connection, $kat);
  		$jmeno = mysqli_real_escape_string($connection,$_POST['jmeno']);
		$prijmeni = mysqli_real_escape_string($connection,$_POST['prijmeni']);
		$bydliste = mysqli_real_escape_string($connection,$_POST['bydliste']);
		$rn = mysqli_real_escape_string($connection,$_POST['rn']);
		$pohlavi = mysqli_real_escape_string($connection,$_POST['pohlavi']);
		if (!empty($_POST['klub']) && isset($_POST['klub'])) {
			$klub = mysqli_real_escape_string($connection,$_POST['klub']);
		} else {
			$klub = mysqli_real_escape_string($connection,"-");
		}
	  
	    $mailVlad = "vladimir.rm@seznam.cz";
	    

	    $messageVlad = "Přijmení: $prijmeni\nJméno: $jmeno\nObec: $bydliste\nRok narození: $rn\nKategorie: $kategorie\nKlub: $klub";

	    mail($mailVlad, "Registrace dětského závodníka", $messageVlad);

	    mysqli_set_charset($connection,'utf8');

	    mysqli_query($connection,"INSERT INTO deti2016(jmeno,prijmeni,bydliste,rn,kat,klub,pohlavi) VALUES('$jmeno','$prijmeni','$bydliste','$rn','$kategorie','$klub','$pohlavi')");

	    $connection->close();

	    $_SESSION['success'] = "Registrace proběhla úspěšně, již se těšíme na Vaši účast.";

	    header('location: http://www.cyklosportchropyne.cz/detske_zavody/detske_zavody_prihlaska.php');
	    exit();


	      

	} else {
		$_SESSION['failure'] = "Nezatrhli jste recaptchu.";
	}
    

  } elseif (!empty($_POST['jmeno']) || isset($_POST['jmeno']) || 
     !empty($_POST['prijmeni']) ||  isset($_POST['prijmeni']) ||
     !empty($_POST['bydliste']) || isset($_POST['bydliste']) ) {
  	
  	$_SESSION['failure'] = "Nevyplnili jste nejméně jedno z požadovaných polí (jméno, příjmení, bydliště).";


  } elseif (!empty($_POST['pohlavi']) || isset($_POST['pohlavi']) || 
     !empty($_POST['rn']) ||  isset($_POST['rn']) ||
     !empty($_POST['prostredek']) || isset($_POST['prostredek'])) {

  	$_SESSION['failure'] = "Nevybrali jste některou z požadovaných informací (rok narození, kolo/odrážedlo, nebo pohlaví).";

  }

  else {

  }

?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cz">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cyklosport Chropyně</title>

	<link rel="stylesheet" type="text/css" href="../styles/style.css">
	<link rel="stylesheet" type="text/css" href="../styles/chribska.css">
	<link rel="stylesheet" type="text/css" href="../styles/formular.css">
	<link rel="stylesheet" type="text/css" href="../styles/form-deti.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="../script/jquery.shorten.js"></script>
	<script src="../script/modernizr.js"></script>
	<script type="text/javascript" src="../script/jquery.unveil.js"></script>
	<script type="text/javascript" src="../script/background.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript" src="../script/main.js"></script>
	

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
							Archiv akt.
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
				<p>Přihlašování online bylo ukončeno. Ale nic není ztraceno a naprsto stejně hladce se budete moci přihlásit i v neděli na míste v Chropyni. Těšíme se na Vás.</p>
			<br style="clear:both;" />
			</div>

		</div>
		

		<div class="aktualita" style="padding-bottom: 200px;">
			<div style="margin:0 auto 40px auto;" class="textPropozic podtrzene">
			
			<h1 id="nadpis" style="color:black;">Seznam<b>přihlášených</b></h1>
			
			<br>
			<!-- <a href="http://www.force.cz" target="_blank">
			<img src="../images/powered_by_force.png" class="powered">
			</a> -->

			</div>
			<div class="textPropozic" style="overflow: scroll;">
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
					$sql2 = "SELECT id, prijmeni, jmeno, bydliste, rn, kat, klub FROM deti2018 ORDER BY  `deti2018`.`kat`, `deti2018`.`prijmeni` ASC";
					$result2 = $connection->query($sql2);
					if ($result2->num_rows > 0) {
						echo "<table class='seznamPrihlasenych' rules='rows'> <thead><tr> <td>Kategorie</td> <td>Příjmení</td> <td>Jméno</td><td>Obec</td><td>Rok nar.</td><td>Tým</td></tr></thead><tbody>";
						while ($row = $result2->fetch_assoc()) {
		
						
							echo "<tr><td>".$row["kat"]."</td><td>".$row["prijmeni"]."</td><td>".$row["jmeno"]."</td><td>".$row["bydliste"]."</td><td>".$row["rn"]."</td><td>".$row["klub"]."</td></tr>";

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
		<?php 
			session_unset();
		?>
		

	</section>

	<!-- <div class="footer" style="position:fixed;">
		
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

</div> -->

<script type="text/javascript">


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

	
	$("input").on("click", function(){
		$(this).toggleClass("input-filled", $(this).is(":focus"));
	}) 
	$("input").on("focus", function(){
		if ($(this).hasClass("input-filled")) {
			return;
		}
		$(this).toggleClass("input-filled");
	}) 
	$("input").on("blur", function(){
		if ($(this).val()) {
			return;
		}
		$(this).toggleClass("input-filled");
	}) 
	$(".pohlavi-cont .tile").on("click", function(){
		if ($(".pohlavi-cont .tile.selected")) {
			$(".pohlavi-cont .tile.selected").toggleClass("selected");
		}
		$(this).toggleClass("selected");
	})
	$(".rn-cont .tile").on("click", function(){
		if ($(".rn-cont .tile.selected")) {
			$(".rn-cont .tile.selected").toggleClass("selected");
		}
		$(this).toggleClass("selected");
		var dc = $(this).data("content")
		if (dc == "2013" || dc == "2014" || dc == "2015") {
			if ($("#kolo").hasClass("disabled")) {
				$("#kolo").toggleClass("disabled");
			} else {
				// $("#kolo").toggleClass("disabled");
				
			}
			if ($("#kolo").hasClass("selected")) {
				$("#kolo").toggleClass("selected");
			}
			if ($("#odr").hasClass("disabled")) {
				$("#odr").toggleClass("disabled");
			} 
		} else if (dc == "2012" || dc == "2011" || dc == "2010" || dc == "2009" || dc == "2008" || dc == "2007" || dc == "2006" || dc == "2005" || dc == "2004" || dc == "2003" || dc == "2002" || dc == "2001") {
			if ($("#kolo").hasClass("disabled")) {
				$("#kolo").toggleClass("disabled");
				$("#kolo").toggleClass("selected");
			} 
			if (!$("#kolo").hasClass("selected")) {
				$("#kolo").toggleClass("selected");
			} 
			if ($("#odr").hasClass("disabled")) {
			}else {
				$("#odr").toggleClass("disabled");
			}
			if ($("#odr").hasClass("selected")) {
				$("#odr").toggleClass("selected");
			} 
		}
		else {

		}
	}) 
	$(".equip-cont .tile.clickable").on("click", function(){
		if ($(".equip-cont .tile.selected")) {
			$(".equip-cont .tile.selected").toggleClass("selected");
		}
		$(this).toggleClass("selected");
	})
	// $("#submit").click(function(){
	// 	var pohlavi-cont = $(".pohlavi-cont");
	// 	var rn-cont = $(".rn-cont");
	// 	var equip-cont = $(".equip-cont");
	// })
	$("#kontrolaButton").click(function(){
		$("#odeslatButton").trigger("click");
	});
	var submitNow = false; 
	$("#prihlaska").submit(function(e){
		if (!submitNow) {
			e.preventDefault();
			

			var messageCont = $(".message");
			var pohlaviCont = $(".pohlavi-cont");
			if (pohlaviCont.find(".selected").length == 0) {
				messageCont.html("Nevybrali jste, zda-li je Vaše ratolest kluk, či dívka.")
				return
			}

			var rnCont = $(".rn-cont");
			if (rnCont.find(".selected").length == 0) {
				messageCont.html("Nevybrali jste ročník narození závodníka(ce).")
				return
			}
			var equipCont = $(".equip-cont");
			if (equipCont.find(".selected").length == 0) {
				messageCont.html("Nevybrali jste, zda-li Vaše dítě absolvuje závod na odrážedle, či kole.")
				return
			}
			messageCont.html("");

			var pohlavi = pohlaviCont.find(".selected").data("content");
			var rn = rnCont.find(".selected").data("content");
			var equip = equipCont.find(".selected").data("content");


			$("#pohlavi-input").attr("value", pohlavi);
			$("#rn-input").attr("value", rn);
			$("#prostredek-input").attr("value", equip);

			submitNow = true;

			$(this).submit();
		}
		
	})

});</script>

</body>
</html>
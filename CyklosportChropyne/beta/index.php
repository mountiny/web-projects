<?php
header('Content-Type: text/html; charset=utf-8'); 
?>

<!DOCTYPE html>
<html class="js">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cyklosport Chropyně</title>

	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<!-- <link href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'> -->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>
	<script type="text/javascript" src="script/jquery.shorten.js"></script>
	<script src="script/modernizr.js"></script>
	<script type="text/javascript" src="script/jquery.unveil.js"></script>
		
	<script type="text/javascript" src="script/background.js"></script>
	<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.34.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.34.0/mapbox-gl.css' rel='stylesheet' />

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-58921066-1', 'auto');
		ga('send', 'pageview');
	</script>
	<script type="text/javascript" src="script/main.js"></script>

<script>
$(document).ready(function() {
	function smoothScroll(target) {
        $('body,html').animate(
        	{'scrollTop':target.offset().top},
        	600
        );
	};
	$('.arrowDown').on('click', function(event){
        event.preventDefault();
        smoothScroll($(this.hash));
    });
});
</script>

<style>
    .mapboxgl-popup {
        max-width: 300px;
        font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
    }
	.mapboxgl-ctrl-compass {
    display: none !important;
    }
</style>



</head>
<body class="nav-is-fixed"> <!-- nav-is-fixed -->
	<div class="js-is-not-working">
		Bohužel, Váš prohlížeč nepodporuje Javascript. Prosíme, navštivte stránku pomocí jiného prohlížeče.
	</div>
	<nav class="menu cd-nav">
		<ul id="cd-primary-nav" class="is-fixed menuFirstLayer cd-primary-nav">  <!-- is-fixed -->
			<li class="menuAktuality">
				<a style="font-weight: bold" href="index.php">
					Aktuality
				</a>
			</li>
			<li class="menuCyklooddil has-children">
				<a href="cyklooddil/cyklooddil.html">
					Cyklooddíl
				</a>
				<ul class="menuSecondLayerCyklooddil hidden-submenu cd-secondary-nav is-hidden">
					<li class="go-back">
						<a href="#cd-primary-nav">Zpět</a>
					</li>
					<li class="submenuClenove cyklooddilMob">
						<a class="cd-nav-item" href="cyklooddil/cyklooddil.html">
							Výsledky
						</a>
					</li>
					<li class="submenuClenove">
						<a class="cd-nav-item" href="cyklooddil/cyklooddil_clenove.html">
							Členové
						</a>
					</li>
					<li class="submenuKalendar">
						<a class="cd-nav-item" href="cyklooddil/cyklooddil_kalendar.html">
							Kalendář
						</a>
					</li>
					<li class="submenuArchiv">
						<a class="cd-nav-item" href="cyklooddil/s2014.php">
							Archiv akt.
						</a>
					</li>
				</ul>
			</li>
			<li class="menuChribska has-children">
				<a href="chribska/chribska_propozice.html">
					FORCE Chřibská 50 MTB
				</a>
				<ul class="menuSecondLayerChribska hidden-submenu cd-secondary-nav is-hidden">
					<li class="go-back">
						<a href="#cd-primary-nav">Zpět</a>
					</li>
					<li class="submenuPropozice">
						<a href="chribska/chribska_propozice.html">Propozice</a>
					</li>
					<li  class="submenuPrihlaska">
						<a href="chribska/chribska_prihlaska.php">Přihláška</a>
					</li>
					<li class="submenuSeznam">
						<a href="chribska/chribska_seznam.php">
							Seznam přihlášených
						</a>
					</li>
					<li class="submenuMapa">
						<a href="chribska/chribska_mapa.html">
							Mapa
						</a>
					</li>
					<li class="submenuVysledky">
						<a href="chribska/chribska_vysledky.html">
							Výsledky
						</a>
					</li>
					<li class="submenuFotogalerie">
						<a href="chribska/chribska_foto.html">
							Fotogalerie
						</a>
					</li>

				</ul>
			</li>
			<li class="menuDetske has-children">
				<a href="detske_zavody/detske_zavody.html">
								Dětské závody
							</a>
				<ul class="menuSecondLayerDetske hidden-submenu cd-secondary-nav is-hidden">
					<li class="go-back">
						<a href="#cd-primary-nav">Zpět</a>
					</li>
					<li class="detskeMobile">
						<a href="detske_zavody/detske_zavody.html">Propozice</a>
					</li>
					<li class="submenuPrihlaskaD">
						<a href="detske_zavody/detske_zavody_prihlaska.php">Přihláška</a>
					</li>
					<li class="submenuVysledkyD">
						<a href="detske_zavody/detske_zavody_vysledky.html">
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
				<a href="prodejna/prodejna.html">
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
				<a class="desktop-nav" href="http://www.cyklosportchropyne.cz/">
					<div class="burger-cont">
						<img src="images/ramS2.png" class="ram">
						<img src="images/ramW.png" class="ramForeground">
					</div>
				</a>

			</li>
		</ul>
	</nav>
	<section id="intro" class="intro">
		<!-- <img src="images/logo.png" class="logo">
		<img src="images/logo.png" class="logoMob"> -->
		<div class="fixed-intro-bg" id="mobileBg">

		</div>
		<div class="motto">
			<div class="mottoRed" id="mottoRedId">
				<!-- PF2017 -->
			</div>
			<div class="mottoBlack" id="mottoBlackId">
				<!-- PŘEJEME VÁM RADOSTNÉ VÁNOCE<br>
				A ÚSPĚŠNÝ NOVÝ ROK<br><br>
				CYKLOSPORT<br>
				CHROPYNĚ<br>
				<span style="color:#ef2c1d;">1997-2017</span> -->
			</div>
			<!-- <a href="#section2" class="arrowDown cd-img-replace">scroll down</a> -->
		</div>
		<a href="#section2" class="arrowDown cd-img-replace">scroll down</a>
		<a href="https://cs-cz.facebook.com/pages/CYKLOSPORT-CHROPYNĚ/108473619247419" target="_blank">
			<img src="images/fb.png" style="width:40px; max-width:10vw;position:absolute;bottom:10px; right:70px;">
		</a>
		<a href="https://www.flickr.com/photos/cschropyne/" target="_blank">
			<img src="images/flickr.png" style="width:40px; max-width:10vw;position:absolute;bottom:10px; right:20px;">
		</a>
		<!-- OVERLAY MOBILE -->
		<div class="cd-overlay"></div>
	</section>

	<section id="section2" class="content cd-main-content">
		<div class="aktualita">
			<div class="textAktuality">
				<p class="nadpisAktuality">Vánoce a rok 2019</p>
				<p class="">
				Za celý tým Cyklosportu Chropyně Vám přejeme klidné a pokojné prožití svátků vánočních nejen v rodinném kruhu a šťastný nový rok 2019.

				<br><br>
				Ať nám všem přinese jen to nejlepší!
				</p>
			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<img src="images/prodejzavreno.jpg">
				<p class="nadpisAktuality">Změna prodejní doby</p>
				<p class="datumVlozeniAktuality">18/12/2018 15:20:33</p>
				<p class="">
				V době od pondělí 24.12.2018 do neděle 6.1.2019 bude prodejna zavřena.<br>
				Děkujeme za pochopení. 
				</p>
			</div>
		</div>
		<?php 
		include "database.php";
		

		$connection = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect to database");
		$connection->set_charset("utf8");

		$sql = "SELECT id, nadpis, obsah, datum, obrazek FROM aktuality WHERE id > 51 ORDER BY `aktuality`.`id` DESC";
		$result = $connection->query($sql);
		if ($result->num_rows > 0) {
			
			while ($row = $result->fetch_assoc()) {

				echo '<div class="aktualita">'. ($row["obrazek"] == "-" ? "" : "<img src='".$row['obrazek']."'>").'<div class="textAktuality">
					<p class="nadpisAktuality">'.$row["nadpis"].'</p>
					<p class="datumVlozeniAktuality">'.$row["datum"].'</p>
					<p class="">
					'.$row["obsah"].'
					</p>
					</div>
				</div>';

			} 
		}

		$connection->close();

		?>

		
		<div class="aktualita">
			<div class="archiv">
				<a href="cyklooddil/s2014.php"> Předchozí roky </a>
			</div>
		</div>

	</section>

	<div class="footer" style="position:fixed;">

		<div class="not-ad-at-all">
			<div class="firstColumn">
				<div id="f1" class="displayed">
					<a href="http://www.ktm-bikes.at" target="_blank"><img src="images/sponsors/ktm.png"></a>
				</div>
				<div id="f2" class="hidden">
					<a href="http://www.campagnolo.com/WW/en" target="_blank"><img src="images/sponsors/campagnolo.png"></a>
				</div>
				<div id="f3" class="hidden">
					<a href="http://www.dema-bicycles.com" target="_blank"><img src="images/sponsors/dema.png" class="demaLogo"></a>
				</div>
			</div>
			<div class="secondColumn">
				<div id="s1" class="displayed">
					<a href="http://www.dtswiss.com/Home" target="_blank"><img src="images/sponsors/dtswiss.png"></a>
				</div>
				<div id="s2" class="hidden">
					<a href="http://www.force.cz" target="_blank"><img style="max-height:40px;" src="images/sponsors/logo-force-white.png"></a>
				</div>
				<div id="s3" class="hidden">
					<a href="http://www.rockmachine.us/en/home/" target="_blank"><img src="images/sponsors/rockmachine.png"></a>
				</div>
			</div>
			<div class="thirdColumn">
				<div id="t1" class="displayed">
					<a href="http://www.radiozlin.cz" target="_blank"><img src="images/sponsors/radio-zlin-white.png"></a>
				</div>
				<div id="t2" class="hidden">
					<a href="http://www.rockmax.cz" target="_blank"><img src="images/sponsors/rockmax-white.png"></a>
				</div>
				<div id="t3" class="hidden">
					<a href="http://superiorbikes.eu/cz/uvod/" target="_blank"><img src="images/sponsors/superior.png"></a>
				</div>
				<div id="t4" class="hidden">
					<a href="http://www.mrxbike.com" target="_blank"><img src="images/sponsors/mrx.png"></a>
				</div>
			</div>
		</div>

	</div>
<script type="text/javascript">
	$(document).ready(function () {

		$(window).scroll(function(){
			var topOfWindow = $(window).scrollTop();
			var windowHeight = $(window).height();

			$("img.lazyload").each(function(){

				var imagePos = $(this).offset().top;

				if (imagePos - 300 <= topOfWindow + windowHeight) { // && imagePos >= topOfWindow - 500
					$(this).unveil();

				}

			});

		});
		$("img.lastLazyload").unveil();
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
	function doOnOrientationChange()
  {
    switch(window.orientation)
    {
      case -90:
      case 90:

        getViewport()
        break;
      default:
      	getViewport()

        break;
    }
  }

  window.addEventListener('orientationchange', doOnOrientationChange);

  // Initial execution if needed
  doOnOrientationChange();

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

	function getViewport() {

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

		 var introSection = document.getElementById("intro")

		 introSection.style.height = parseInt(viewPortHeight - 80) + 'px';

	}

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

	window.onload = getViewport();

	if (isMobile.any()) {

		var isiPad = navigator.userAgent.match(/iPad/i) != null;
		if (isiPad) {
			// window.onresize = getViewportOfMobile;
		}else {
			// window.onresize = getScreenSize;
		}


	}else {
		window.onresize = getViewport;
	}
</script>

	<script>
	jQuery(document).ready(function($){
		// $(".group1").colorbox({rel:'group1'});
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
// VÁNOČNÍ VERZE

if (hasClass(html[0], "no-touch")) {
	window.onload = myFunction;
} else {
	window.onload = myMobileFunction;
}
</script>
</body>
</html>

<?php 
session_start();
   

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
	
var lastScrollTop = 0, delta = 100;

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

		if (rok_nar < 1900 || rok_nar > 2015) {

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
<body class="nav-is-fixed chribska" style="background-position: center 11%;"> <!-- nav-is-fixed overflow-y:hidden; background-image:url('../images/cyklo_masakr.jpg');-->
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
				<a class="desktop-nav"  href="../index.html">
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

			<div style="margin: 30 auto; display:block;font-size: 28px;" class="textPropozic">

			Online přihlašování ještě nebylo spuštěno.

			</div>

		
			
		<div class="cd-overlay"></div>
		
		

	</section>

	<div class="footer" style="position:fixed;">
		
		<div class="reklamy chribskaSponzori" style="text-align:center; position:absolute; top:0;left:0; width:100%; height:100%;">
			<a id="f1" href="http://www.drimalservis.cz" class="displayed" target="_blank">
				<img class="reklama levaReklama" src="../images/loga/drimal_Logo.png"></a>
			<a id="s1" href="http://www.force.cz" class="displayed" target="_blank">
				<img class="reklama stredníReklama" src="../images/sponsors/logo-force-white.png" style="max-width:25%;"></a>
			<a id="t1" href="http://www.elmo.cz/en/" class="displayed" target="_blank">
				<img class="reklama pravaReklama" src="../images/loga/elmo_Logo.png" class="demaLogo"></a>
			<a id="f2" href="http://www.kruzik.cz" class="hidden" target="_blank">
				<img class="reklama levaReklama" src="../images/loga/kruzik_Logo.png"></a>
			<a id="s2" href="#" class="hidden" target="_blank">
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
 Cufon.now();</script>
</body>
</html>
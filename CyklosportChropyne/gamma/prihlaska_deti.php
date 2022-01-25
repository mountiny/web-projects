<?php 

	session_start();
	include 'database.php';
	
	$connection = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect to database");

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
			} elseif ($_POST['rn'] == "2016" || $_POST['rn'] == "2017" || $_POST['rn'] == "2018" || $_POST['rn'] == "2019") {
				$kat = "B";
			} elseif ($_POST['rn'] == "2014" || $_POST['rn'] == "2015") {
				$kat = "C";
			} elseif ($_POST['rn'] == "2012" || $_POST['rn'] == "2013") {
				$kat = "D";
			} elseif ($_POST['rn'] == "2010" || $_POST['rn'] == "2011") {
				$kat = "E";
			} elseif ($_POST['rn'] == "2008" || $_POST['rn'] == "2009") {
				$kat = "F";
			} elseif ($_POST['rn'] == "2007" || $_POST['rn'] == "2006" || $_POST['rn'] == "2005") {
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
				$klub = mysqli_real_escape_string($connection,"");
			}
		
			$mailVlad = "vladimir.rm@seznam.cz";	
			// $mailVlad = "mikllhor@gmail.com";	

			$messageVlad = "Přijmení: $prijmeni\nJméno: $jmeno\nObec: $bydliste\nRok narození: $rn\nKategorie: $kategorie\nKlub: $klub";

			mail($mailVlad, "Registrace dětského závodníka", $messageVlad);

			mysqli_set_charset($connection,'utf8');

			mysqli_query($connection,"INSERT INTO deti2020(jmeno,prijmeni,bydliste,rn,kat,klub,pohlavi) VALUES('$jmeno','$prijmeni','$bydliste','$rn','$kategorie','$klub','$pohlavi')");

			$connection->close();

			$_SESSION['success'] = "Registrace proběhla úspěšně, již se těšíme na Vaši účast.";

			header('location: https://www.cyklosportchropyne.cz/prihlaska_deti.php');
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
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Cyklosport Chropyně</title>
	<meta name="Description" CONTENT="Přihláška na dětské závody v Chropyni.">
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

<body class="ch50-page" style="background-color:white;">

    <div class="ch50-container">
        <div class="ch50-main">
        <a href="./detske-zavody.php" class="back_home">
                <img src="img/back_left.png" alt="" class="back_img">
            </a>
            <!-- <a href="https://www.force.cz">
                <img src="img/force-black.png" alt="" class="force-black">
            </a> -->
            <h1 class="prihlaska-heading" style="margin-top:40px;">DĚTSKÉ ZÁVODY - PŘIHLÁŠKA 2020</h1>

			<div class="aktualita propozice" style="padding-bottom: 30px;">

			<div class="message <?php echo isset($_SESSION['success']) ? 'success' : '';echo isset($_SESSION['failure']) ? 'failure' : ''?>">
				<?php 
					if (isset($_SESSION["success"])) {
						echo $_SESSION["success"];
						session_unset();
					}
					if (isset($_SESSION["failure"])) {
						echo $_SESSION["failure"];
					}

				?>
			</div>

<div style="margin: 30 auto; display:block;" class="textPropozic">

<div style="display:none;visibility:hidden;">
Přihlásit se můžeš na místě v den závodu 30.8.2020. Všechny důležité informace najdeš <a href="https://www.cyklosportchropyne.cz/detske-zavody.php" style="color:#EC3359;">zde</a>.
</div>

<form id="prihlaska" accept-charset="utf-8" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	<h3>Pohlaví</h3>

	<div class="form-cont pohlavi-cont">
		<div class="tile" data-content="kluk">
			<img src="../images/icons/kluk.svg">
		</div>
		<div class="tile" data-content="holka">
			<img src="../images/icons/holka.svg">
		</div>
		<input id="pohlavi-input" type="text" name="pohlavi" style="display: none;"></input>
	</div>
	<h3>Rok narození</h3>

	<div class="form-cont rn-cont">
		
		
		<div class="tile" data-content="2005">
			<img src="../images/icons/n05.svg">
		</div>
		<div class="tile" data-content="2006">
			<img src="../images/icons/n06.svg">
		</div>
		<div class="tile" data-content="2007">
			<img src="../images/icons/n07.svg">
		</div>
		<div class="tile" data-content="2008">
			<img src="../images/icons/n08.svg">
		</div>
		<div class="tile" data-content="2009">
			<img src="../images/icons/n09.svg">
		</div>
		<div class="tile" data-content="2010">
			<img src="../images/icons/n10.svg">
		</div>
		<div class="tile" data-content="2011">
			<img src="../images/icons/n11.svg">
		</div>
		<div class="tile" data-content="2012">
			<img src="../images/icons/n12.svg">
		</div>
		<div class="tile" data-content="2013">
			<img src="../images/icons/n13.svg">
		</div>
		<div class="tile" data-content="2014">
			<img src="../images/icons/n14.svg">
		</div>
		<div class="tile" data-content="2015">
			<img src="../images/icons/n15.svg">
		</div>
		<div class="tile" data-content="2016">
			<img src="../images/icons/n16.svg">
		</div>
		<div class="tile" data-content="2017">
			<img src="../images/icons/n17.svg">
		</div>
		<div class="tile" data-content="2018">
			<img src="../images/icons/n18.svg">
		</div>
		<div class="tile" data-content="2019">
			<img src="../images/icons/n19.svg">
		</div>
		<input id="rn-input" type="text" name="rn" style="display: none;"></input>
	</div>

	<h3>Vybavení</h3>

	<div class="form-cont equip-cont">
		<div class="tile disabled" id="odr" data-content="odrazedlo">
			<img src="../images/icons/odrazedlo.svg">
		</div>
		<div class="tile disabled" id="kolo" data-content="kolo">
			<img src="../images/icons/kolo.svg" style="width: 90%;">
		</div>

		<div class="tile disabled">
			<img src="../images/icons/bidon.svg">
		</div>
		<div class="tile disabled">
			<img src="../images/icons/helma.svg">
		</div>
		<input id="prostredek-input" type="text" name="prostredek" style="display: none;"></input>
	</div>
	<div class="form-cell">
		<input class="<?php echo isset($_SESSION['jmeno']) ? 'input-filled' : ''?>" type="text" name="jmeno" value="<?php echo isset($_SESSION['jmeno']) ? $_SESSION['jmeno'] : ''?>"></input>
		<label class="form-label">
			<span class="form-label-content">Jméno</span>
		</label>
	</div>
	<div class="form-cell">
		<input class="<?php echo isset($_SESSION['prijmeni']) ? 'input-filled' : ''?>" type="text" name="prijmeni" value="<?php echo isset($_SESSION['prijmeni']) ? $_SESSION['prijmeni'] : ''?>"></input>
		<label class="form-label">
			<span class="form-label-content">Příjmení</span>
		</label>
	</div>
	<div class="form-cell">
		<input class="<?php echo isset($_SESSION['bydliste']) ? 'input-filled' : ''?>" type="text" name="bydliste" value="<?php echo isset($_SESSION['bydliste']) ? $_SESSION['bydliste'] : ''?>"></input>
		<label class="form-label">
			<span class="form-label-content">Obec</span>
		</label>
	</div>
	<div class="form-cell">
		<input class="<?php echo isset($_SESSION['klub']) ? 'input-filled' : ''?>" type="text" name="klub" value="<?php echo isset($_SESSION['klub']) ? $_SESSION['klub'] : ''?>"></input>
		<label class="form-label">
			<span class="form-label-content">Klub</span>
		</label>
	</div>
	<br style="clear:both;" />
	<br>
	<br>
	<br>
	<p>Online přihlašování bude ukončeno ve čtvrtek 27. srpna ve 20:00.</p>
	<br>
	<br>
	<p>Ti, jež se přihlásili online, již v dějišti závodů nevyplňují přihlášku znovu!!</p>
	<br>
	<br>
	<p>
	Přihlášením se na tento závod každý účastník souhlasí se zveřejněním svých osobních údajů v podobě přihlášky,
startovní listiny, výsledků a dalším zpracováním svých údajů pořadatelem v rozsahu nutném pro zabezpečení celé akce.
Účastník bere na vědomí, že poskytnutí údajů je dobrovolné, že svůj souhlas může bezplatně a písemně kdykoliv na adrese pořadatele odvolat,
má právo přístupu k osobním údajům a právo na opravu těchto údajů, blokování nesprávných osobních údajů, jejich likvidace atd.
V průběhu akce budou pořizovány zdravodajské fotografie, sloužící k informování veřejnosti o proběhlém závodě, propagačním účelům pořadatele, ale také pro osobní potřebu závodníků. 
Přihlášením se každy účastník souhlasí s pořízením fotografické, audio nebo video dokumentace a zpracováním osobních údajů na ní uvedených.
	</p>
	<br>
	<br>
	<p>
		Pro zařazení do kategorie je rozhodující ročník narození dítětě, nikoliv den narození.
	</p>
	<br>
	<div class="g-recaptcha" data-sitekey="6LeszgATAAAAACM9y4mQlwb6rfwDfPvab1Bduguv"></div>
	
	<input type="button" value="Odeslat" name="kontrola" id="kontrolaButton" /> 
	<input type="submit" value="Odeslat" name="odeslat" id="odeslatButton" style="visibility: hidden;" />
	<!-- <input id="submit" type="submit" value="Odeslat"></input>-->
</form> 
<br style="clear:both;" />

           
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
			$("div.aktualita").toggleClass("show");
			$("h1.prihlaska-heading").toggleClass("show");
      });
        $(document).ready(function() {

			// $("img.back_img").toggleClass("show");
			// $("footer").toggleClass("show");
			// $("div.aktualita").toggleClass("show");
			// $("h1.prihlaska-heading").toggleClass("show");


			var realySubmit = false;
			$("#kontrolaButton").click(function(){
				$("#odeslatButton").trigger("click");
			});
        

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

            // $(window).on("scroll", function (e) {
            //     // var offsetY = $("html").offset().top * (0)
            //     screenTop = $(document).scrollTop() * -0.2;

            //     // $('#content').css('top', screenTop);
            //     $("img.ch50-bg-map").css("transform", "translate3d(" + (-0.4) * screenTop + "px," +
            //         screenTop + "px,0px)")
            //     var dHeight = $("div.ch50-intro").height() * 2.5;
            //     var alpha = (($(document).scrollTop() / dHeight));
            //     $('body').css('background', 'rgba(90,192,206,' + (alpha * 2) + ')');
            // })

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
				if (dc == "2019"  || dc == "2018" || dc == "2017") {
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
				} else if (dc == "2012" || dc == "2011" || dc == "2010" || dc == "2009" || dc == "2008" || dc == "2007" || dc == "2006" || dc == "2005" || dc == "2004" || dc == "2003" || dc == "2002" || dc == "2013" || dc == "2014" || dc == "2015" || dc == "2016") {
					if ($("#kolo").hasClass("disabled")) {
						$("#kolo").toggleClass("disabled");
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
			$(".equip-cont .tile").on("click", function(){
				if ($(".equip-cont .tile.selected") && !$(this).hasClass("disabled")) {
					$(".equip-cont .tile.selected").toggleClass("selected");
				}
				if ($(this).hasClass("disabled")) {

				} else {
					$(this).toggleClass("selected");
				}
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


        })


	
    // })
    </script>

</body>

</html>
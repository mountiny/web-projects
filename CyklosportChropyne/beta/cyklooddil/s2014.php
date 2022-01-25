<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Cyklosport Chropyně</title>

	<link rel="stylesheet" type="text/css" href="../styles/style.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

	<script src="http://code.jquery.com/jquery-2.1.0.min.js"></script>

	<script type="text/javascript" src="../script/jquery.shorten.js"></script>
	<script src="../script/modernizr.js"></script>
	<script type="text/javascript" src="../script/jquery.unveil.js"></script>
	<script type="text/javascript" src="../script/background.js"></script>
	<script type="text/javascript" src="../fonts/Avenir.font.js"></script>
	<script type="text/javascript" src="../script/main.js"></script>

</head>
<body class="nav-is-fixed" style="background-image:url('../images/cyklo_masakr.jpg');"> <!-- nav-is-fixed -->
	<nav class="menu cd-nav">
		<ul id="cd-primary-nav" class="is-fixed menuFirstLayer cd-primary-nav">  <!-- is-fixed -->
			<li class="menuAktuality">
				<a href="../index.php">
					Aktuality
				</a>
			</li>
			<li class="menuCyklooddil has-children">
				<a href="cyklooddil.html">
					Cyklooddíl
				</a> 
				<ul class="menuSecondLayerCyklooddil hidden-submenu cd-secondary-nav is-hidden">
					<!-- <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil_clenove.html"> -->
					<li class="go-back">
						<a href="#cd-primary-nav">Zpět</a>
					</li>
					<li class="submenuClenove cyklooddilMob">
						<a class="cd-nav-item" href="cyklooddil.html">
							Výsledky
						</a>
					</li>
					<li class="submenuClenove">
						<a class="cd-nav-item" href="cyklooddil_clenove.html">
							Členové
						</a>
					</li>
					<!-- </a> -->
					<li class="submenuKalendar">
						<a class="cd-nav-item" href="cyklooddil_kalendar.html">
							Kalendář
						</a>
					</li>
					<li class="submenuArchiv">
						<a style="font-weight: bold" class="cd-nav-item" href="s2014.php">
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
					<div class="burger-cont">
						<img src="../images/ramS2.png" class="ram">
						<img src="../images/ramW.png" class="ramForeground">
					</div>
				</a>
				
			</li>
		</ul>
	</nav>


	<section id="section2" class="content cd-main-content">

		<?php 
		include "../database.php";
		

		$connection = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect to database");
		$connection->set_charset("utf8");

		$sql = "SELECT id, nadpis, obsah, datum, obrazek FROM aktuality WHERE id < 53 ORDER BY `aktuality`.`id` DESC";
		$result = $connection->query($sql);
		if ($result->num_rows > 0) {
			
			while ($row = $result->fetch_assoc()) {

				echo '<div class="aktualita">'. ($row["obrazek"] == "-" ? "" : "<img src='../".$row['obrazek']."'>").'<div class="textAktuality">
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
			<img src="../images/29ser2016.jpg">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 29</p>
				<p class="datumVlozeniAktuality">25/07/16 23:07</p>
				<p class="">
				Minulý víkend všichni kompletně pověsili závodní tretry mimo zraku dosah. Čímž vysvětluji i&nbspmalou mezeru v posloupnosti číslování tohoto servisu. Mnozí však nevydrželi ponechat klid nohám a&nbsphýčkané bikové technice na delší dobu, čehož důkazem je i&nbsptento text.<br>
Nejpočetněji jsme obsadili závod ze seriálu KPŽ -&nbspKarlštejn Tour s&nbsp trochu zavádějícím názvem neb z&nbsphradu závodníci nezahlédnou ni věžičku, maximálně projedou pár metrů po katastru stejnojmenné obce. Možná, díky pekelnému pařáku, byl některý ze závodníků obdarován fatou morgánou Karlštejna.<br>
Několik méně početných výprav se rozjelo po moravských lokacích. Holky Nábělkovic řádily na Moravskotřebovském cyklomaratonu. Kateřina svoji kategorii vyhrála (šampáňo) a&nbspAdélka byla jen o&nbspstupínek níže (pouze nealko). Na Okruhu luhačovickým Zálesím si oddílový novic Jaromír Fuksa s&nbsppřehledem dojel v&nbspkategorii pro vavřín nejcennější. Na triatlonovém Hulmenu byl Lipánek vybičován k&nbspnejlepšímu výkonu za posledních deset let.<br><br>

Přehled výsledků je <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>.<br>
Přehled výsledků týmu KPŽ je <a href="http://www.cyklosportchropyne.cz/files/kpz2016.pdf">zde</a>.<br>
Výběr fotek z&nbsp„Karlštejna” od Jana Reinera a&nbspHonzy Blažka najdete na oddílové <a href="https://www.flickr.com/photos/cschropyne/">fotogalerii</a>, jsou tam také fotky neznámých autorů z&nbspvýše citovaných akcí.
			
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/27ser2016.jpg">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 27</p>
				<p class="datumVlozeniAktuality">11/07/16 19:25</p>
				<p class="">
				Duše se k&nbspmajitelce navrátila. I&nbspto je ve zkratce příběh, který se v&nbspsobotu odehrál na Karpatském pedálu. Masivní účastí našeho oddílu se vyznačoval tento závod, kde jsme uháněli s&nbspvětrem a&nbspsluncem v zádech malebnou krajinou vůkol Javorníku nad Veličkou o&nbspstošest za metami vyššími než Velká Javořina. Jednu se nám podařilo získat. Tým ve složení Vladimír Kučera, Jan Procházka a&nbspMartin Piruch obhájil první místo z&nbsppředešlých ročníků. O&nbspstupínek níže se v&nbspkategorii umístil kapitán oddílu (14/2). V&nbsprámci pětidílného seriálu MAXBIKE Karpaty MTB Tour, jehož poslední součástí Karpatský pedál byl, jsme zůstali před branami vedoucími ke stupňům pro nejlepší.<br>
Ve vrchlabském závodu ze seriálu KPŽ se z trojice našich kmotrovských zástupců nejlépe vedlo Kateřině Nábělkové (256/3), když cílovou páskou prosvištěla na třetím místě v&nbspkategorii.<br>
Symbolická účast oddílu na dlouhém silničním Beskydu v&nbsppodání Milana Mosazného (76/3) byla jeho úsilím přetavena v&nbsppravou, nefalšovanou bronzovou medaili za třetí místo v&nbspkategorii.<br><br>
Přehled výsledků najdete <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>.<br>
Výběr fotek od Viléma z&nbspKarpatského pedálu je <a href="https://www.flickr.com/photos/vilemeliv/albums">zde</a> a&nbspvýběr fotek od Míše Jurásové je na oddílové <a href="https://www.flickr.com/photos/cschropyne/">fotogalerii</a>.
			
			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/26ser2016.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 26</p>
				<p class="datumVlozeniAktuality">04/07/16 11:59</p>
				<p class="">
				Neobvykle, už v&nbsppátek, zahájili naši bikeři v&nbspNovém Městě na Moravě soupeření mimo jiné pocty i&nbspo&nbsptitul akademického mistra ČR. Obhajoba titulu akademického vícemistra z&nbsploňského roku se nepovedla. Tři sestry v&nbsppředvečer klání vysály z&nbspJana Procházky všechnu zbylou energii po úspěchu na Drásalovi.<br>
Lépe si vedli v&nbspsobotu Vladimír Kučera a&nbspzvláště pak Kateřina Nábělková. Kateřina (206/1) vyhrála svoji kategorii na oblíbené rodinné lokaci - Vinařské padesátce v&nbspŠatově a&nbspVladimír (5/2) se pro druhé místo v&nbspkategorii vypravil do zahraničí na Oravský cyklomaraton.<br><br>
				Přehled výsledků najdete <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>.<br>
Výběr fotek z&nbspBirell biku od Viléma a&nbspVíti je <a href="https://www.flickr.com/photos/vilemeliv/albums">zde</a>
			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/25ser2016.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 25</p>
				<p class="datumVlozeniAktuality">28/06/16 23:28</p>
				<p class="">
				Drásal bolí. Letošní, s&nbspnovými náročnějšími trasami, obšťastněný nadměrnou přízní Slunce, se mnohým z&nbspnás vryje nesmazatelně do paměti. Z&nbspnašich oddílových členů to jistě budou Jan Peza, Radomír Gregor a&nbspPetr Kučera, kteří budou vzpomínat na útrapy, jež se jim přihodily. Na druhém pólu to budou ti úspěšní - Jan Procházka (3/1), který předvedl životní výkon na drásalovské klasice, když dojel celkově třetí a&nbspvyhrál svoji kategorii, na krátkém Drásalovi si pro vavříny v&nbspkategoriích dojeli Vladimír Kučera (26/2) a&nbspKateřina Nábělková (195/3).<br>
Rosťa Ryplů (88/1) si pro svoji sobotní dávku slunečních paprsků zajel do Životských hor. Zatímco domácí Rocco s&nbsptetou Johanou hledali útěchu u&nbspSpasitele, tak si Rosťa dojel pro první místo v&nbspkategorii.<br><br>
				Přehled výsledků najdete <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>.<br>
Výběr fotek z&nbspDrásala od Viléma a&nbspVíti je <a href="https://www.flickr.com/photos/vilemeliv/albums">zde</a> a&nbsppár fotek z&nbspŽivotských hor na oddílové <a href="https://www.flickr.com/photos/cschropyne/">fotogalerii</a>.<br><br>
Neodpustím si malou poznámku. V&nbsp<a href="http://www.kolopro.cz/clanky/aktualni-informace/10762-jobankuv-obri-hattrick" target="_blank">článku</a> o&nbspDrásalovi na stránkách KPŽ jsem se dozvěděl, že Holešov je v&nbspČechách, že tradiční termín závodu (první červencový víkend) byl změněn o&nbsp14 dní dopředu a&nbspže Pavel Skalický je neznámý amatér???!!!

			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/24ser2016.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 24</p>
				<p class="datumVlozeniAktuality">20/06/16 07:30</p>
				<p class="">
				Příprava na Drásala bolí. Kapitán oddílu by mohl po nedělní cvičné seznamovací vyjížďce s&nbspnovou trasou vyprávět. Obdobně i&nbspMarek Julina po dvoudenních galejích na Kotárech Tůr.<br>
V&nbspsobotu na Rampušáku, okleštěném o&nbspsilniční část, zopakoval Vladimír Kučera zlaté umístění v&nbspkategorii na 60-ti kilometrové distanci bikové trasy. Na její kratší sestře se z&nbsptřetího místa v&nbspkategorii radoval Petr Procházka. Potěšilo nás i&nbsppotvrzení stoupající výkonnosti po úspěšném zdolání záludností zkouškového období našeho černého koně na Drásala -&nbspMartina Pirucha.<br>
Druhou víkendovou akcí bylo nevyhlášené mistrovství Valašska ve dvouetapovém bikovém závodu dvojic -&nbspKotáry Tůr. Letošní jubilejní 20. ročník vedl jako obvykle snad přes všechny kopce Javorníků ze Zlína do Velkých Karlovic a&nbspna druhý den zpět přes ty obzvláště vybrané v&nbspHostýnsko -&nbspvsetínské hornatině, bratru cca 170 km. Zásluhou Filipa Chovance (s&nbspparťákem Andrejem) jsme obhájili loňské vítězství dvojice Marek Julina a&nbspRadim Horáček, kteří letos zůstali těsně pod stupni pro vítěze.<br><br>
Přehled výsledků oddílu najdete <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>. <br> 
Výběr fotek z&nbspKotárů z&nbsplokality Na Písečné od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/albums">zde</a> a&nbsppár fotek z&nbspRampušáka na oddílové <a href="https://www.flickr.com/photos/cschropyne/">fotogalerii</a>.


			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/23ser2016.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 23</p>
				<p class="datumVlozeniAktuality">15/06/16 01:10</p>
				<p class="">
				Jeden z&nbspvíkendů, kdy jsme se vypravili na závodní kolbiště v&nbspsobotu i&nbspv&nbspneděli. Sobotní výprava se jala dobývati horu zvanou Ještěd na závodech ze seriálu KPŽ. Do vzdálené lokace se vypravila část race týmu posílená o&nbsp„kmotrovskou” skupinu. A&nbspjako je již poslední dobou zvykem, třetí místa v&nbspkategoriích neunikla Vladimíru Kučerovi (48/3) a&nbspKateřině Nábělkové (327/3). V&nbspten samý den se k&nbspvýbornému výkonu vzepjal Michal Straka (3/2), když na 70 kilometrovém Kaktus biku (SVK) dojel celkově třetí a&nbspdruhý v&nbspkategorii.<br>
Nedělní oddílový výkon na Nivnické padesátce by si měli všichni zapsat do památníčku. Z&nbspprvního tuctu v&nbspcelkovém pořadí na 50 kilometrové trase byl rovný půltucet oděn v&nbspnašich dresech. Nejintenzivněji šlapal do pedálů Jan Procházka (4/3), v&nbspkategorii pokořil Vladimír Kučera (8/1) prokletí třetích míst z&nbspposledních akcí a&nbspbral rovnou první. Na kratší trase se vytáhli mladíci Petr Procházka (2/1) a&nbspLukáš Kučera (7/3) prvním a&nbsptřetím místem v&nbspkategorii, přičemž Petr dojel v&nbspcelkovém pořadí druhý.<br><br>
				
Přehled výsledků oddílu najdete <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>. <br>
Přehled výkonů týmu KPŽ je <a href="http://www.cyklosportchropyne.cz/files/kpz2016.pdf">zde</a>.<br>
Výběr fotek od Jana Reinera z&nbspJeštědu je <a href="https://www.flickr.com/photos/cschropyne/">zde</a>.<br>
Výběr fotek z Nivnice od Viléma Horáčka je <a href="https://www.flickr.com/photos/vilemeliv/albums/">zde</a>.<br>
Výběr fotek z Nivnice od Jana Junaštíka a Petra Smutného je <a href="https://www.flickr.com/photos/cschropyne/">zde</a>.

			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/22ser2016.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 22</p>
				<p class="datumVlozeniAktuality">07/06/16 00:00</p>
				<p class="">
				3 x 3. Ne, to vás nechci zkoušet z&nbsppočtů. To je jen stručný zápis nejlepších výkonů našich oddílových členů v tomto víkendu a&nbspznamená tři třetí místa ve svých kategoriích. Vyzdvihnout musím historicky první individuální pódiové umístění Jaroslava Zemana (50/3) v&nbspnašich barvách, na které dosáhl na olomouckém řetězu a&nbspto věru (zůstali-li pořadatelé věrni svým ideám) nebyla lehká projížďka lesem. Na Orlíku si pláž z&nbsppódia prohlédli osvědčení sběratelé drahých kovů - Adélka Nábělková (113/3) a&nbspVladimír Kučera (29/3).<br>
Dnes tj. 7. 6. 2016 vstoupí náš oddíl do historie Pražských schodů první účastí v&nbsphlavním závodě  v&nbsposobě Jana Procházky. Držíme mu pěsti s&nbspvírou, že štěstí přeje připraveným. <br><br>
				
Přehled výsledků oddílu najdete <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>. <br>
Přehled výkonů týmu KPŽ je <a href="http://www.cyklosportchropyne.cz/files/kpz2016.pdf">zde</a>.<br>
Výběr fotek od Jana Reinera z&nbspOrlíku je <a href="https://www.flickr.com/photos/cschropyne/">zde</a>.


			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/dz_2016.jpg"  class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Bikové závody dětí</p>
				<p class="datumVlozeniAktuality">01/06/16 21:45</p>
				<p class="">
				Byl 29. květen, neděle ráno, bouřkové mraky kvapně opouštěly oblohu nad chropyňským rybníkem a nadvládu nad celým zbývajícím dnem převzal Slunce svit. S kalužemi na závodní trase si však ještě nedokázal do startu první kategorie poradit. Pro žádného závodníka nebyly louže nepřekonatelnou překážkou, ba mohu říct, že pro některé to byl super hit.<br>
Ve všech sedmi věkových kategoriích jsme na startu přivítali 207 dětí ve věku od jednoho do patnácti let. Jejich měření sil bylo urputné, vedené v duchu fair play.<br><br>
			
Kompletní výsledky najdete <a href="http://www.cyklosportchropyne.cz/detske_zavody/detske_zavody_vysledky.html">zde</a>. <br>
Výběr fotografií od Viléma najdete <a href="https://www.flickr.com/photos/vilemeliv/albums/with/72157668346768546">zde</a>.

			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/20ser2016.jpg"  class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 20</p>
				<p class="datumVlozeniAktuality">23/05/16 21:45</p>
				<p class="">
				Dalším závodem seriálu Kolo pro život byl oblíbený díl v Jestřebích horách, který si nenechali utécti i naši. Čtyřčlenná sestava bojující o body do týmové soutěže podporovaná třemi Kmotry a jednou osamocenou bikerkou Kateřinou Nábělkovou (336/2) zkontrolovali organizační kvality pořadatelů a její zásluhou dovezli domů alespoň jeden drahý kov.<br>
Zbývající část členů až na Rosťu Rypla (272/4) na Silesii a Jardu Zemana (48/5) na hradě Broumově sbírala síly na další klání jinými vhodnými postupy.<br><br>
				
Přehled výsledků <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>. <br>
Výběr fotek od Jana Reinera a Miloše Lubase z Úpice najdete <a href="https://www.flickr.com/photos/cschropyne/">zde</a>.


			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/19ser2016.jpg"  class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 19</p>
				<p class="datumVlozeniAktuality">16/05/16 12:45</p>
				<p class="">
				„Jedeme na Mamuta”, zavelel před časem kapitán oddílu. Povel byl jasný a&nbsptak účast na letošním Mamut Tour & Bike byla po několika letech z&nbspnaší strany velmi početná. Závodníky jsme obsadili všech pět nabízených distancí, tři na silniční části a&nbspdvě bikové trasy.<br>
Na nejdelší silniční , 212 kilometrů dlouhé královské trase, jsme nasadili ocelového muže Milana Mosazného (53/9), který však kvůli tajtrlíkujícím fotografům v&nbsptrase závodu, zvolil strategii dojetí do cíle ve zdraví. Na střední si z&nbspnaší trojice nejlépe vedla Kateřina Nábělková (112/2), když obsadila druhé místo v&nbspkategorii. Zlatým stupínkem v kategorii nás na nejkratší trase potěšila Adélka Nábělková (92/1).<br>
Vynikajících výsledků dosáhla početná ekipa našich členů na delší bikové trati.<br> V&nbspelitní jedenáctce se umístila hned čtveřice z nich. Nejvýše se probojoval Jan Procházka (2/2), celkově i&nbspv&nbspkategorii druhý, vítězstvím v kategorii podpořil úspěšné působení na Mamutu Vladimír Kučera (7/1). A&nbspani na kratší bikové trati jsme neodešli bez kovu na hrudi. Bronzovou placku si na ni pověsil za umístění v&nbspkategorii Lukáš Kučera (13/3).<br><br>
				
Přehled výsledků <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>. <br>
Výběr fotek ze stoupání na Hadovnu od Viléma je <a href="https://www.flickr.com/photos/vilemeliv/albums/with/72157668346768546">zde</a>.


			</div>
		</div>
		<div class="aktualita">

			<img data-src="../images/18ser2016.jpg"  class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 18</p>
				<p class="datumVlozeniAktuality">09/05/16 07:35</p>
				<p class="">
				Krasný slunečný den čekal hordu našich oddílových členů v okolí hradu Helfštýna na letošní Šele. Vytáhl do terénu dokonce i Kamila s Luďkem. Závodníky jsme obsadili všechny nabízené distance. Na nejdelší, 97 kilometrové mistrovské trase, kterou jsme měli i dobře pokrytou pomocným personálem podavačů povoleného dopingu (ale ne jenom ji) si nejlépe vedl v celkovém pořadí Jan Procházka (27/16), v kategorii o kousek, co by se párkrát kamenem hodilo, unikl bronz Vladimíru Kučerovi (63/4).<br>
Janem Blažkem dobře rozjetou střední distanci, s ambicí umístění v první desítce celkového pořadí, zhatila krátká letecká vložka na cca 18 kilometru s tvrdým přistáním bez zjevných následků na těle, ale s totální destrukcí ráfku předního kola.<br><br>

Přehled výsledků najdete <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>.<br>
Výběr fotek od Viléma je ke zhlédnutí <a href="https://www.flickr.com/photos/vilemeliv/albums/with/72157667227377926">zde</a>.<br> 


			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/17ser2016.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 17</p>
				<p class="datumVlozeniAktuality">04/05/16 19:35</p>
				<p class="">
				Druhý závod seriálu Kolo pro život byl pro zúčastněné členy našeho oddílu ve znamení číslice tři. Trojice Jan Procházka (9/3), Vladimír Kučera 38/3) a&nbspKateřina Nábělková (237/3) vybojovali krásná třetí místa ve svých kategoriích. Třešničkou na dortu, potvrzující výše citované, je třetí místo našeho race týmu ze stránek KPŽ nezjistitelného složení.<br>
Další akcí u&nbspnás za kopcem a&nbsptím pádem s&nbspnaší početnou účastí byla bondovská jarní srdcovka v Prusinovicích - Rohálovská padesátka. Na pódium jsme letos nedosáhli. Nejlépe si s&nbspnástrahami trati poradil Filip Chovanec (25/21).<br><br>

Přehled výsledků najdete <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>.<br>
Fotky od Jana Reinera a&nbspJiřího Blažka z&nbspHustopečí <a href="https://www.flickr.com/photos/cschropyne/">zde</a>.<br>
Fotka z&nbspR50 od Viléma <a href="https://www.flickr.com/photos/vilemeliv/albums/with/72157667227377926">zde</a>.<br>

			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 16</p>
				<p class="datumVlozeniAktuality">26/04/16 17:05</p>
				<p class="">
				Nejvýznamnější událostí tohoto víkendu je to, že jsme spustili přihlašování na dětské závody v Chropyni, které se uskuteční 29.&nbspkvětna. Přihlašovat se můžete <a href="http://www.cyklosportchropyne.cz/detske_zavody/detske_zavody_prihlaska.php">zde</a>.<br><br>

Začalo Kolo pro život obvyklým úvodním závodem Trans Brdy. Z naší strany prozatím vlažně, a i proto musel Jarda studovat naše sponzory, vymalované na našich dresech, ve zpětném zrcátku. Nejlépe si je mohl prohlížet na dresu Jana Procházky (30/5), který byl z našich účastníků nejlepší. I web pořadatele ještě nešlape na 100%. Najít bodovací tabulku, jak je uvedeno v pravidlech, na stránkách seriálu, je úkol minimálně pro Horatia z CSI Miami.<br>
Třetím závodem na Záhoří pokračoval i seriál Maxbike Karpaty Tour. Ten jsme obsadili převážně početnou skupinou Kučerovců. Z nich si nejlépe vedl Petr (37/7). Za zmínku stojí to, že výborně natrénováno má náš emeritní člen Vladimír Kučera st., a to až tak, že výsledkové listině omládl minimálně o osm let.<br><br>

Přehled výsledků najdete <a href="http://www.cyklosportchropyne.cz/files/csch2016.pdf">zde</a>.<br>
Jednu fotku od Jana Reinera z Brd a pár párů fotek ze Záhoří najdete<a href="https://www.flickr.com/photos/cschropyne/">zde</a>.


			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/ch502016.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Chřibská 50 2016</p>
				<p class="datumVlozeniAktuality">19/04/16 23:01</p>
				<p class="">
				Už je to uděláno, už je to hotovo. Touto větou, notoricky známou nám dětem všeho věku, se dá nejvýstižněji charakterizovat pocit úlevy organizátorů 14. ročníku FORCE Chřibské padesátky z kroku do nové podoby závodu. Nové úplně z gruntu. Zázemím v hanáckých Athénách, městě Kroměříži, v areálu výstaviště Floria, z toho vyplývající novou trasou tradiční distance a přídavkem kratší trasy s délkou cca poloviční, vstupem do seriálu pěti bikových závodů Maxbike Karpaty MTB Tour.<br><br>
Úleva je na místě. Upgrade 3.0 závodu se povedl. Vyčnívá v něm především zázemí na výstavišti s parkovištěm takřka na dosah ruky, nadstandardním vybavením pro osobní hygienu (určitě i našich mechanických domin), krytým prostorem s dostatečnou kapacitou pro všechny zúčastněné lidičky, aby mohli v klidu znovu nabýt vydanou energii fyzickou i duševní, vydanou na trase klasické distance, kterou Foja charakterizoval slovy: "Rychlá, ale na úvod sezóny i dostatečně obtížná”, ale i na krátké trase, která na své hodnocení ještě čeká.<br><br>
A k tomu se přidalo i počasí. Do žluta rozžhavené aprílové Slunce nabíjelo blankytně modrou oblohu snad jenom pozitivní energií se selektivním přenosem na zúčastněné.<br><br>
Jako novinku lze zařadit i jméno vítězky dlouhé trasy Terezy Němcové (familiérně nazývané TeHu) mezi něžným pokolením a také Marka Rauchfusse z řad ogarů. Na krátké trase vstoupí do historie závodu jako první vítězové sexy Denisa Knapková a snad sexy Tomáš Petříček.<br><br>
Na závěr tohoto nezvykle dlouhého textu musím vyslovit jménem našeho trojjedinného (ředitel závodu, kapitán oddílu, biker) poděkování všem participujícím členům oddílu a jeho sympatizantům za nadstandardně zvládnutý upgrade 3.0 závodu včetně jeho vlastního průběhu a závodníkům v obou pelotonech, že závodili s rozumem v hrsti. Dík.<br><br>
				Výsledky závodu najdete <a href="http://www.cyklosportchropyne.cz/chribska/chribska_vysledky.html">zde</a>.<br>
Výsledky seriálu MKmtbT <a href="http://www.karpatymtbtour.eu/vysledky/">zde</a>.<br>
Výběr fotek od Viléma <a href="https://www.flickr.com/photos/vilemeliv/albums/with/72157667227377926">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<p class="nadpisAktuality">Výsledky FORCE Chřibské 50 2016</p>
				<p class="datumVlozeniAktuality">16/04/16 20:58</p>
				<p class="">
				Za jak dlouho jste proletěli trať letošní Chřibské? Kolik jste naložili svému odvěkému sokovi, či o kolik se budete muset do příštího roku zlepšit, abyste jej zdolali? Výsledky <a href="chribska/chribska_vysledky.html">zde</a>.


			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<p class="nadpisAktuality">The latest news</p>
				<p class="datumVlozeniAktuality">14/04/16 21:18</p>
				<p class="">
				V posledním víkendovém výsledkovém servisu jsem již nastínil účast výborných bikerek a&nbspbikerů na letošní CH50. Možná i&nbsptento text zviklal k&nbsppřihlášení další jedince z&nbsptop sféry. Džobra, Adlíka a TeHu (alias Terezka Němcová), hochy z&nbspKellys Bikeranch Teamu, ČS-Accolade a&nbspSymbio+Cannondale. Na 99% se na startu objeví "amatér" Foja. A&nbsptaky je možné, že se v&nbspsobotu v&nbspbikerském světě našich luhů, hájů a&nbsplesů objeví úplně nové, nezapomenutelné jméno. Loňskou CH50 nám počasí osvěžilo krátkou, intenzívní, sněhovou přeháňkou. To letos podle oblíbených norských meteorologických jasnovidců nehrozí a&nbspvypadá to na krátké krátké. Prášit se taky nebude, trať i&nbspjejí okolí bylo příjemně zvlhčeno a&nbsppro mladší ročníky jsme kaluže ponechali v&nbspaktuálním stavu.


			</div>
		</div>

		<div class="aktualita">
			<div class="textAktuality">
				<p class="nadpisAktuality">CH50 LIVE</p>
				<p class="datumVlozeniAktuality">11/04/16 21:18</p>
				<p class="">
				 Jelikož se trať line přes železnici, vybízíme k obezřetnosti a upozorňujeme, že závodníci, kteří přes koleje přejedou po spuštění výstražných zařízení, budou <b>diskvalifikování</b>.<br><br>

				 Na výstavišti můžete očekávat atrakce pro děti mj. skákací hrad. <b>Avšak dětské závody zde nejsou pořádány.</b> Ty se budou jako každý rok konat na konci května (29.5.) v Chropyni v okolí tamějšího zámku. <a href="detske_zavody/detske_zavody.html">Jste srdečně zváni</a>.
				 <br><br>
				 <h3>Stravování</h3>
				 Na stravenku si závodníci budou moci vybrat:
				 <ul>
				 	<li>Těstoviny s grilovanou zeleninou v tomatové omáčce</li>
				 	<li>Boloňské těstoviny</li>
				 	<li>Rizoto s kuřecím masem, zeleninou a sýrem</li>
				 	<li>Hovězí guláš, pečivo</li>
				 	<li>Pivo alko a nealko / s příchutí</li>
				 	<li>Neperlivá / jemně perlivá voda</li>
				 </ul>
				 Ve stejné restauraci, kde bude jídlo připraveno pro závodníky, si bude moci psychická podpora a doprovod dopřát i jiných než-li výše uvedených pochutin.
				 <br><br>
				 Mapu zázemí se zvýrazněnými klíčovými body můžete nalézt <a href="chribska/chribska_propozice.html">zde</a>.
				 <br><br>
				 <b>Přijaté platby po 14.4. 20:00 nemusí být spárovány s přihláškou, a proto bude startovné považováno za neuhrazené. Případné nesrovnalosti budou řešeny individuálně s ředitelem závodu při prezentaci.</b>
				 <br><br>
				 Také pro první tři ženy v absolutním pořádí jsou přichystány peněžní odměny (1000Kč, 500Kč, 500Kč).
				 <br><br>

				 <h3>Kontakt na zástupce pořadatele</h3>
				 TEL: +420 603 446 917
				 E-mail: vk1973@seznam.cz
				 <br><br>
				 <h4>Prezentace:</h4>
					
					Pátek: 16:00 - 19:30<br>
					Sobota: 8:00 - 10:00 dlouhá<br>
						8:00-10:45 krátká<br>
					  


			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<p class="nadpisAktuality">Výsledkový servis 13</p>
				<p class="datumVlozeniAktuality">07/04/16 16:40</p>
				<p class="">
				 Biková sezóna zahájena. V Morkovicích si naši oddíloví chrti otestovali svoji aktuální výkonnost v přímém souboji s konkurencí. Test na výbornou dopadl pro Vladimíra Kučeru vítězstvím ve své kategorii. Duo 2P ještě přemýšlelo, místo kterých přednášek budou najíždět potřebné tréninkové kilometry, aby byli obávanými soupeři elitních závodníků a tak o čučuť zaostali za očekáváním. Chřibská padesátka v novém hávu je za dveřmi a letmý pohled do seznamu přihlášených věští kvalitní složení pelotonu. Jen namátkou bych jmenoval tetu Johanu a strýca Rocca, z fotbalistova týmu Denisu s nesmazatelnou pihou krásy společně se šťastným Petrem, lokální hvězdy Žakin a Žmolda, standardně nadprůměrný orientační smysl navedl do Kroměříže i Jirku Hradila a snad se objeví i kouzelník Foja. Tak se těšte!!!
			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/ch50_banner_mapa.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Úprava krátké trasy a jejího startu</p>
				<p class="datumVlozeniAktuality">04/04/16 00:50</p>
				<p class="">
				 Z důvodu zajištění maximální bezpečnosti účastníků a&nbsptaké minimalizace vzájemného ovlivňování průběhu závodu na 50 a&nbsp30 km jsme se rozhodli provést tyto změny: Start kratší trasy bude oddělen od 50 km trasy, závodníci odstartují z&nbspareálu výstaviště ve <span>12:00 hod</span>. Po startu se vydají proti dojezdu závodu a&nbsppo přejetí železnice budou směřovat na Kotojedy, kde se napojí na již dříve představenou trasu. Děkujeme za pochopení a&nbspvěříme, že tyto změny zlepší průběh závodu.
			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<p class="nadpisAktuality">CH50 LIVE</p>
				<p class="datumVlozeniAktuality">31/03/16 19:18</p>
				<p class="">
				 Již máme k dispozici celý záznam dlouhé trasy, najdete jej <a href="http://www.bikemap.net/en/route/3462433-chribska-50-mtb-2016/#/z12/49.22275,17.36998/terrain" target="_blank">zde</a> (online Bikemap.net).
				 <br><br>
				 Na trase krátkého závodu byly provedeny kosmetické úpravy, které se týkají jeho finálních kilometrů. Jedná se o&nbspúsek asi 4&nbspkm od cíle v&nbspokolí Hvězdy. Důvodem změny je snaha předejít možným kolizím závodníků z&nbspdlouhé trasy se závodníky z&nbspkrátké.
			</div>
		</div>
		<div class="aktualita">
			<img data-src="../images/chribska2016chystej.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">FORCE Chřibská padesátka - 16. dubna 2016</p>
				<p class="datumVlozeniAktuality">24/01/16 23:58</p>
				<p class="comment">
				Už se chystej. Na nový, ale vskutku nový 14. ročník FORCE Chřibské padesátky. Nové je místo zázemí v&nbspareálu výstaviště Floria v&nbspKroměříži. Nové jsou trasy závodu a&nbspto hned dvě - dlouhá a&nbspkratší. Novinkou je i&nbspto, že dlouhá trasa je součástí seriálu závodů Maxbike Karpaty MTB tour 2016. Nový je dodavatel sportovní výživy na občerstvovačce (Kompava). A&nbspmožná nového přijde ještě více … třeba kouzelník. Něco však zůstalo nedotčené. Osvědčený tým pořadatelů! Maximální počet závodníků na dlouhé trase (500) a&nbspaprílové počasí.<br><br>

				Propozice jsou <a href="http://www.cyklosportchropyne.cz/chribska/chribska_propozice.html">zde</a>. Přihlásit se můžete na <a href="http://www.cyklosportchropyne.cz/chribska/chribska_prihlaska.php">tomto</a> odkazu. Mapu můžete nalézt <a href="http://www.cyklosportchropyne.cz/chribska/chribska_mapa.html">zde</a>.
			</div>
		</div>

		<div class="aktualita">
			<img data-src="../images/bvs2015.jpg" class="lastLazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Bilanční výsledkový servis roku 2015</p>
				<p class="datumVlozeniAktuality">16/11/15 12:14</p>
				<p class="comment">
				„Opět se přiblížilo období, kdy se chystá sv.&nbspMartin vypustit svého bílého koně mezi nás”. Touto větou jsem začínal loňský bilanční výsledkový přehled. Letos sv.&nbspMartin s&nbspbílou peřinou určitě nepřijede, ba co víc, prodlužuje pravověrným cyklistům sezónu další várkou dnů s&nbspnadprůměrnou teplotou, neobvyklou pro toto roční období. Tak neváhejte a&nbspjezděte. Využijte této přímluvy sv.&nbspMartina do úplného vyčerpání, než se uložíte k&nbsppo sezónnímu odpočinku od svých ke SVÝM více či méně drahým miláčkům.
<br><br>
Po tomto krátkém úvodu přikročme k&nbspstručnému kvantitativnímu vyhodnocení letošní sezóny.
<br><br>
Námi pořádaná FORCE Chřibská padesátka se letos, na rozdíl od výše citované pranostiky, neobešla bez drobné, leč nepříjemnou teplotou s&nbspvětrem doprovázené, sněhové přeháňky. Tato, našimi meteorologickými kapacitami a&nbspaplikacemi na nejchytřejších telefonních cihlách, avizovaná nepohoda pravděpodobně stála za nižší účastí čítající rovných 301 odstartovavšich otužilců. Na Dětských závodech v&nbspChropyni jsme přivítali 170 dětí, což je prozatím nejvyšší účast v&nbspdosavadní historii akce, na kterou jsme právem pyšní.
<br><br>
Celkově se členi oddílu v&nbspletošním roce zúčastnili 66 akcí, z&nbsptoho pěti silničních a&nbspčtyř triatlonových. V&nbspzahraničí jsme letos byli pouze na jedné slovenské akci. Dle vedené evidence to představuje 483 „osoboúčastí” (vlastní měrná jednotka) s&nbsppoklesem o&nbsp60 oú oproti loňskému roku. Na nich jsme vybojovali v&nbspcelkovém pořadí třináct prvních míst (markantní nárůst), dvě druhá a&nbsppět třetích míst. V&nbsppříslušných kategoriích to bylo 34x první, 25x druhé a 36x třetí místo včetně konečných umístění v&nbspseriálech.<br>
Nejpilnějšími z&nbspnás byli Kateřina Nábělková a&nbspVladimír Kučera&nbspml. s&nbspúčastí na dvacetidevíti akcích jen těsně následováni Aldou Nábělkem. Naší srdcovkou se podobně jako v&nbsppředešlých letech stal holešovský Drásal s&nbsp28 aktivními účastníky (počítáno bez neméně aktivní a&nbsppočetné skupiny oddílových sympatizantů).  
<br><br>
Uspěli jsme i&nbspv&nbsptýmových soutěžích ve dvou nejsledovanějších tuzemských bikových seriálech, i&nbspkdyž ne tak jako v&nbsploňské sezóně. V&nbspseriálu Cyklomaraton se tým ve složení Vladimír Kučera&nbspml., Rosťa Ryplů, Martin Piruch, Jan Procházka a&nbspKateřina Nábělková umístil na třetím místě. Druhý tým ve složení Petr Koubek, Aleš Nábělek, Petr Kučera, Martin Klár a&nbspLukáš Kučera obsadil sedmou příčku. V&nbspjednotlivcích, v&nbsptomto seriálu v&nbspcelkovém hodnocení v&nbspkategorii mužů, si nejlépe vedl Vladimír Kučera&nbspml., když seriál mezi muži vyhrál. V kategoriích se nejlépe dařilo Vladimíru Kučerovi ml. ziskem prvního místa, druhá místa vybojovali Adélka Nábělková, Rosťa Ryplů a&nbspJan Procházka, třetí pak Kateřina Nábělková.<br>
V&nbspseriálu „Kolo pro život” tým ve složení Vladimír Kučera&nbspml., Jan Peza, Petr Koubek, Martin Piruch, Jan Procházka, Jan Blažek, Michal Straka a&nbspMartin Klár sice neobhájil loňské vynikající třetí místo, ale i&nbsppáté pořadí v&nbspcelkovém hodnocení lze považovat za úspěšné počínání v&nbspkonkurenci s&nbspdalšími dvaceti pěti týmy. V&nbspcelkovém hodnocení seriálu mezi jednotlivci se Jan Procházka a&nbspMartin Piruch udrželi v&nbspelitní patnáctce třináctým a&nbspčtrnáctým místem. V&nbspkategoriích pódiové umístění s&nbspbronzovou hodnotou obhájil Petr Koubek a&nbspnově si tuto příčku vybojovala Kateřina Nábělková.		
				
			</div>
		</div>
	
		<div id="sezona2015" class="aktualita">
			<img src="../images/pf2016.jpg">
			<div class="textAktuality">
				<p class="nadpisAktuality">Pour féliciter 2016</p>
				<p class="datumVlozeniAktuality">26/12/15 13:28</p>
				<p class="comment">
				Přejeme všem lidem štěstí v&nbsproce 2016, ať při nich stojí ve chvílích, kdy ho nejvíce potřebují, a&nbspTi, kteří mají pocit, že ho mají na rozdávání, tak ať neváhají a&nbsprozdávají.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/43ser2015.jpg">
			<div class="textAktuality">
				<p class="nadpisAktuality">Spadaným listím</p>
				<p class="datumVlozeniAktuality">26/10/15 19:34</p>
				<p class="comment">
				Tradiční sezónu uzavírající hromadná vyjížďka bikerů startuje v sobotu 31. 10. 2015 v 13:00 z náměstí ve Fryštáku trasou dle výběru do cíle na Holajce (v parčíku, hospodě apod.) nebo tam, kam vás nohy došlapou.			
				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/40ser2015.jpg">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 40</p>
				<p class="datumVlozeniAktuality">07/10/15 15:34</p>
				<p class="comment">
				Náročný víkend. V&nbspsobotu i&nbspneděli jsme byli na závodních kolbištích posledních závodů ze seriálů KPŽ i&nbspCyklomaraton.<br>
				Letošní derniéra seriálu KPŽ se odehrála ve Vysočina aréně v&nbspNovém Městě na Moravě. Oku libé kulisy závodu a&nbspstudený vítr nepomohly splnit „úkol, který zněl jasně” a&nbsptým nesmazal ztrátu a&nbspzůstal na konečném pátém místě v&nbsptýmové soutěži. I&nbspjednotlivcům nebylo dopřáno a&nbsptak třešničkou útěchy je bramborová medaile Kateřiny Nábělkové za umístění v&nbspkategorii.<br>
				Totální derniéra seriálu Cyklomaraton se odehrála v&nbspneděli ve Zlíně (příští rok nebude již tento seriál pořádán). V&nbsppodmínkách charakteristických pro babí léto se účastníkům z&nbspnašich řad vedlo o&nbsppoznání lépe než v&nbspsobotu. Vybojovali dvě druhá místa v kategoriích zásluhou Jana Pezy a Radima Horáčka. Třetí místa přidali Petr Koubek a&nbspVladimír Kučera ml. Celkové výsledky jak jednotlivců, tak i&nbspdružstev ještě nejsou k&nbspdispozici, ale predikce v&nbsptýmech vychází na letos oblíbené páté místo.

				<br><br>

				Výběr z&nbspfotek od Jana Reinera z&nbspNMnM je v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, fotky od Viléma z&nbspNMnM i&nbspze Zlína jsou <a href="https://www.flickr.com/photos/vilemeliv/albums" target="_blank">zde</a>. Přehledy výsledků členů oddílu a&nbsptýmů KPŽ i&nbspCMT jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.				
				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/39ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 39</p>
				<p class="datumVlozeniAktuality">28/09/15 16:34</p>
				<p class="comment">
				Oderskou Mlýnici tento rok totálně opanovali černoši, snad až z&nbspdaleké africké pouště Kalahari, možná to byli i&nbsppotomci otroků z&nbspmexické Sonory. Tito nadmíru zdatní a&nbspvytrvalí jedinci, sycení vytrvalým přísunem drobného deště v&nbspjejich domovině nevídaným, známého pod hanáckým označením „sere a&nbspsere”, byli možná příčinou, že se z&nbsptamních tratí vracíme bez bobkových listů, ale „pouze” se dvěma bramborovými posty. Přesto si tým o&nbsp72,22 bodů v&nbspcelkovém hodnocení polepšil, ale to stačilo pouze na snížení ztráty na tým o&nbspstupínek výše na pouhých 13.85 bodu. Úkol pro poslední závod seriálu KPŽ v&nbspNovém Městě na Moravě tedy zní jasně: „ztrátu zlikvidovat.?!!!”.

				<br><br>

				Výběr z&nbspfotek od Jana Reinera z&nbspMlýnice je v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, fotky od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/albums" target="_blank">zde</a>. Přehledy výsledků členů oddílu a&nbsptýmu KPŽ jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.
				
				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/38ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 38</p>
				<p class="datumVlozeniAktuality">23/09/15 22:04</p>
				<p class="comment">
				Sladký plzeňský zlatavý mok se transformoval v&nbsphořký mok budějovický. Snad takto by se mohl ve stručnosti popsat výsledek týmu KPŽ na závodě v&nbspPlzni. Nikdo z&nbspčlenů týmu tentokrát nedosáhl na bednu. Nejblíže se k&nbspní přiblížil bramborovým místem v&nbspkategorii Petr Koubek. Ani to však nezabránilo poklesu týmu o&nbspjednu příčku níže (ze 4. na 5. místo) v&nbspprůběžném pořadí seriálu. Oddílovou medailovou čest zachraňovala Kateřina Nábělková vavřínem za třetí místo ve své kategorii.


				<br><br>
				Jediná fotka z&nbspPlzně v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a> mluví za vše (v&nbspPlzni snad nikdo nefotil, dohledat slušnou fotku se mi totiž nepodařilo). Přehledy výsledků členů oddílu a&nbsptýmu KPŽ jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.&nbsp
				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/37ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 37</p>
				<p class="datumVlozeniAktuality">16/09/15 20:54</p>
				<p class="comment">
				Zbytnění vinných zásob na Cyklobraní ve Valticích se nekonalo. Oddílová i&nbsptýmová strategie nekompromisně zavelela, kdo je zdravý musí na Cyklomaraton do Ostravy. Ostravský kahan asi naši úspěšní členi v&nbspigelitce s&nbspvýhrou nenašli, možná tak černouhelnou briketu. Byli to za první místo v&nbspkategorii Vladimír Kučera ml., za třetí místa Kateřina Nábělková a&nbspRostislav Rypl.<br>
				Tříčlenná miniskupinka na Zlatohorské magistrále o&nbspjednom závodícím Radimu Horáčkovi, který zopakoval loňské vítězství v&nbspkategorii a&nbspvylepšil o&nbspjedno místo svoji pozici v&nbspcelkovém pořadí z&nbspšestého na páté.

				<br><br>
				Výběr z&nbspfotek Zlatohorské magistrály od Viléma je <a href="https://www.flickr.com/photos/vilemeliv/albums" target="_blank">zde</a>, několik fotek z&nbspaparátu kapitána z&nbspOstravy je v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehledy výsledků členů oddílu a&nbsptýmu CMT jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>. 

				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/36ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 36</p>
				<p class="datumVlozeniAktuality">09/09/15 22:54</p>
				<p class="comment">
				Sprinterský závod seriálu „Kolo pro život” se obvykle odehrává ve vinařských lokalitách jižní Moravy. Letos podobně jako loni ve Znojmě. Čert ví proč se zde jezdí tak rychle. Možná kvůli nicotnému převýšení, možná někteří neodolali předstartovní dopingové konzumaci burčáku (dns - nadměrná předstartovní spotřeba burčáku -&nbspletos mezi první stovkou v&nbspabs. pořadí seriálu zvýšený výskyt). Ale dvacítka aktivních závodníků v&nbspnašich dresech si pro burčák spořádaně vystála frontu až po odvedeném sportovním výkonu. Nejvýše na stupních vítězů vystoupala Kateřina Nábělková (293/2) a&nbspto na stříbrný stupínek, o&nbspjeden níže se postavil Vladimír Kučera ml. (31/3). Oba tím navýšili své vinné zásoby z&nbspminulého týdne. Kdo z&nbspnich pojede 12. 9. do Valtic? 
				<br><br>
				Výběr z&nbspfotek od Jana Reinera ze Znojma je v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, fotky od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/albums" target="_blank">zde</a>. Přehledy výsledků členů oddílu a&nbsptýmu KPŽ jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.		

				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/35ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 35</p>
				<p class="datumVlozeniAktuality">01/09/15 15:54</p>
				<p class="comment">
				Náročný víkend - v&nbspsobotu závod u&nbspVranovské přehrady a&nbspv&nbspneděli dva mohykáni Cyklomaraton Tour pelášili do Berouna, jiní v&nbspdomnění, že se na severu zchladí, do Ostravy. Třetí skupinka se chladila doma v&nbspKroměříži na Bagráku na triatlonovém Kromplmanu. Okolo Vranovské přehrady na Lahofer Cupu se závodilo o&nbspvíno. Loňské, už skoro nicotné zásoby řádně doplnil Vladimír Kučera ml. vítězstvím ve své kategorii, obdobně se zásobila Katka Nábělková odměnou za druhé místo. V&nbspneděli v&nbspBerouně opět Vladimír Kučera ml. mával ze stupínku pro vítěze - tentokrát stříbrného. Odhaduji, že výhrou mohla být nyní nedostatková potoční voda na zalévání ze soutoku řek Vltavy a&nbspBerounky. Ostravský chachar nechladil, což nezabránilo naší letošní pódiové stálici Katce Nábělkové vybojovat třetí místo ve své kategorii (vyhrála vagon černého uhlí, psala agentura JPP).
				<br><br>
				Fotky z&nbspfotoaparátu kapitána od Vranovské přehrady a&nbspBerouna a&nbspvýběr fotek od „fran999” z&nbspOstravy jsou v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehledy výsledků členů oddílu a&nbsptýmu CMT jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.
			

				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/34ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 34</p>
				<p class="datumVlozeniAktuality">24/08/15 23:30</p>
				<p class="comment">
				Modrá je dobrá - tvrdí nejškaredší překladatel z&nbspčínštiny v&nbspnaší republice a&nbspmožná tajný indián. Tým KPŽ v&nbspminimálním možném počtu, ale i&nbsps&nbspposilami od Kmotra a&nbspjinými, se vypravil na závod Manitou Železné hory (každým správným železným horám vládne indiánský bůh - info pro divící se) do Chrudimi. Za skoro ideálního cyklistického počasí, pod dohledem vládce okolních hor, jsme se zásluhou Martina Pirucha a&nbspkapitána oddílu Vladimíra Kučery ml. dvakrát podívali do davu účastníků čekajícího na tombolu ze stupínku, určeného pro dobyvatele bronzových medailí. Výsledky týmu Kmotrů jsou až do schválení nejvyšším Kmotrem tajné -&nbspco kdyby stály za nic.
				<br><br>
				Výběr z&nbspfotek od Jana Reinera z&nbspChrudimi a&nbspod „liboroff” z&nbspŽelechovic jsou v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehledy výsledků členů oddílu a&nbsptýmu KPŽ jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.

				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/33ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 33</p>
				<p class="datumVlozeniAktuality">20/08/15 10:00</p>
				<p class="comment">
				Opět horký víkend, tentokrát pouze horký s&nbspodpolední přípravou na pořádnou bouřku (tedy alespoň v okolí Rusavy), která se nezalekla a&nbspve večerních hodinách přišla úřadovat. Stejně intenzivně úřadovaly na dlouhé trase Rusavské padesátky Kateřina a&nbspAdélka Nábělkovy. Obě to na trase roztočily na plné pecky a&nbspvyhrály své kategorie. Na pódium se zde ještě podíval náš inkognito tandem, složený z&nbspPavla Mrázka a&nbspZbyňka Vondrušky, když dojel na třetím místě.<br>
				Tým KPŽ se v minimálním počtu vypravil na závod až do vzdálených Karlových Varů. Ani tam jsme nezůstali bez pódiového umístění. Zásluhou Martina Pirucha si hoši odvezli bronz.<br><br>
				
				Výběr fotek od Jana Reinera z&nbspKarlových Varů je v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, fotky z&nbspRusavské padesátky od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/albums" target="_blank">zde</a>. Přehledy výsledků členů oddílu a&nbsptýmu KPŽ jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.
				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/32ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 32</p>
				<p class="datumVlozeniAktuality">11/08/15 22:00</p>
				<p class="comment">
				Horký, horký a&nbspještě jednou horký víkend, Slunce stále pařící nad hlavami a&nbsprozehřívající atmosféru v našich nadmořských výškách až k 38°C. Takové podmínky panovaly v&nbsppátek a&nbspsobotu pro zápolení naší triatlonové štafety ve složení Petr Procházka (plavání), Vladimír Kučera (bike) a&nbspPetr Kučera (běh) na závodech zvaných Valachyman a&nbspHolešovman. Přestože štafeta trpěla hrubou ústrojovou nekázní, tak výsledky odvedla excelentní. Oba závody s&nbspdosti výrazným náskokem před ostatními vyhrála.<br><br>
				Výběry fotek od Jana Reinera a&nbspz&nbspfotoaparátu kapitána z&nbspValachymana a&nbspHolešovmana jsou v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, fotky z&nbspHolešovmana od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/albums" target="_blank">zde</a>. Přehledy výsledků členů oddílu jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/31ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 31</p>
				<p class="datumVlozeniAktuality">04/08/15 23:00</p>
				<p class="comment">
				Před obdobím dalších veder, za takřka skoro ideálního cyklistického počasí, jsme se rozdělili do dvou téměř početně shodných skupin a&nbspvyrazili. Skupina KPŽ to vzala přes devět kopců a&nbspdevět řek do šumavského střediska zimních sportů Zadov. Druhá pouze přes jeden kopec do Bystřice pod Hostýnem na Hostýnskou padesátku. Medaili nejcennější za umístění v&nbspkategoriích jsme tento víkend přenechali v&nbspplen soupeřům, ale stříbrnou zásluhou Jana Procházky a&nbspbronzovou zásluhou Petra Koubka jsme ze Šumavy domů přivezli. Z&nbspměsta pod svatým Hostýnem jsme si odvezli nic, ale někteří z&nbspnás si na druhý den vyšlápli alespoň pro vodu na svatý Hostýn.
				<br><br>
				Výběr fotek od Jana Reinera a&nbspz&nbspfotoaparátu kapitána z&nbspKPŽ je v naší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, fotky z&nbspBpH od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/albums" target="_blank">zde</a>. Přehledy výsledků členů oddílu a&nbsptýmu KPŽ jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/30ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 30</p>
				<p class="datumVlozeniAktuality">29/07/15 12:15</p>
				<p class="comment">
				Po období nekonečných veder nechal pražský pořadatel před startem závodu KPŽ Karlštejn Tour pokropit celou trasu tak, aby se neprášilo a&nbspani blátem se nebrodilo. Karlštejn náš střediskový jsme nedobyli úplně, ale pouze částečně. Alespoň jednu medaili za umístění v&nbspkategorii, a&nbspto stříbrnou, si vydobyl Jan Procházka (12/2). V&nbsphodnocení týmů to vypadá, že nás v&nbspletošním ročníku bude pronásledovat umístění na bramborovém stupínku, podobně jako Sagana druhé na letošní LeTour.<br>
				Bez zlaté medaile jsme tento víkend nezůstali. Zlato se stává oblíbeným kovem Rosti Rypla, získal ho na 50 km trase Moravskotřebovského maratonu za umístění ve své kategorii. Nutno vyzvednout ten fakt, že je to již třetí Rosťovo zlato za posledních třicet dní.
				<br><br>
				Výběr fotek od Jana Reinera z&nbspKPŽ je v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehledy výsledků členů oddílu a&nbsptýmu KPŽ jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.
				
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/28ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 28</p>
				<p class="datumVlozeniAktuality">13/07/15 22:53</p>
				<p class="comment">
				V&nbspdruhém prázdninovém víkendu obvykle houfně vyrážíme na závody do Javorníku, kde již tradičně vládne ideální počasí. Asi vymodlené nebo možná zároveň i&nbspvykoupené kvalitním vínem z&nbspmístních sklípků.<br>
				Náš specialista na Obra Drásala Jan Peza vypálil všem adeptům na vítězství Karpatského pedálu rybník, a&nbspjak je jeho zvykem, po 70. km zrychlil (údaj vychází z předpokladu, že přijel na start z&nbspdomu na kole; obvykle tvrdím, že zrychluje až po 100. km, ale to by v&nbsptomto případě musel bydlet dál než v&nbspUH) a&nbspvytáhl s&nbspsebou do úniku pouze oddílového kapitána Vladimíra Kučeru. V&nbspcílovém spurtu, nedbaje na oddílovou hierarchii, zvítězil, čímž si ověřil, že dříve podceňované několikadenní předzávodní dodržování životasprávy k&nbspvavřínům nejvyšším vynáší. Medailové žně oddílu v&nbspJavorníku k&nbspdvěma nejhodnotnějším místům v&nbspcelkovém pořadí přidaly i&nbspdalší „převodníky” za umístění v&nbspkategoriích - zlaté zásluhou Rosťe Rypla, Vladimíra Kučery a&nbsp„Obra”, stříbrný zásluhou Kateřiny Nábělkové a&nbspbronzové zásluhou Petra Koubka a&nbspv&nbspsoutěži týmů.<br>
				No a&nbsppak nejeďte tam.?!
				<br><br>
				Výběr fotek od fotografa s&nbspnickem „zden11” jsou v naší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehledy výsledků členů oddílu jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.	
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/27ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 27</p>
				<p class="datumVlozeniAktuality">09/07/15 14:59</p>
				<p class="comment">
				Drásal - naše první letní srdcovka. Sotva ráno otevřeme oči a&nbspvykoukneme z&nbspokna, už se samovolně upírají směrem k&nbspsv.&nbspHostýnu a&nbspmysl k&nbsppodvědomé úvaze, po kolikáté už letos na ten kopec či do jeho okolí protočíme výplety svých biků nebo silniček. Letos se nám, obdobně jako v&nbsploňském roce, podařilo obsadit oddílovými dresy všechny nabízené trasy a&nbspto i&nbsppřes avizované odrazující sluneční peklo. A&nbspbylo.<br>
				Specialistou na Obra Drásala se z&nbspnašeho středu stává Jan Peza (11/7). Pak tu máme skupinku skalních příznivců klasického Dlóhého Drásala, letos posílenou o&nbspmladou a&nbspúspěšnou krev Martina Pirucha (10/2) a&nbspJana Procházku (16/3). Krátkého Drásala si letos naordinovala skupinka nejpočetnější. Z nich se s&nbsptratí nejlépe v&nbspkategorii vypořádal Petr Koubek (59/2) jen těsně následován Kateřinou Nábělkovou (247/3) a&nbspVladimírem Kučerou (23/3). Na nejkratšího „dětského” Drásala jsme vyslali slečnu Adélku Nábělkovou (85/5).<br>
				Celkově byla účast členů oddílu a&nbspjejich příznivců mírně nižší než v&nbsppamátném roce 2013 s&nbspvíce než 50 kusy, ale i&nbsptak byla letos prozatím nejpočetnější.
				<br><br>
				Výběr fotek od Jana Reinera je v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, fotky od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/albums" target="_blank">zde</a>. Přehledy výsledků týmu <a href="files/kpz2015.pdf" target="_blank">KPŽ</a> a&nbspoddílu jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.		
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/26ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 26</p>
				<p class="datumVlozeniAktuality">29/06/15 14:35</p>
				<p class="comment">
				Rampepurdo rampepurďácká, ta mírná úprava hmotnosti směrem k&nbspnižším hodnotám u&nbspMartina Pirucha se fakt osvědčila a&nbspv&nbspkombinaci s&nbspenergetickou výživou od firmy Grandmother Ltd. ho vynesla k&nbspnejlepšímu výsledku v letošním (ale i&nbsppředešlých) ročníku seriálu Kolo pro život v podobě třetího místa v&nbspcelkovém pořadí, hned za Boudou a&nbspVencou. Nebude dlouho trvat a&nbsptakhle familiérně na ně bude pokřikovat, až je bude předjíždět. Ostatně od svého nedávného razantního vstupu do oddílu už překonal i&nbspsvého kapitána v počtu vyobrazení na doprovodných obrázcích k&nbsptextům, zaznamenávajícím oddílový života běh.<br>
				V&nbspŽivotských horách, na Roccově oblíbeném švihu, se vytáhl k&nbspexcelentnímu výkonu, zúročujíce tím svoji tréninkovou píli ve valašských kopcích, Rosťa Ryplů vítězstvím ve své kategorii.<br>
				Do Šatova vyrazila naše specializovaná skupina na vinařské lokality - Nábělkovi. O&nbspkolik litrů vína a&nbspz&nbspkterého ročníku se letos jelo mi neprozradili, ale za druhé místo ve své kategorii si Kateřina jistě nějaké odvezla. A možná přibylo i&nbsprodinné balení. V této soutěži si společně s&nbspAdélkou a&nbspAldou vyjeli třetí místo.
				<br><br>
				Výběr fotek z&nbspVrchlabí od Jana Reinera a&nbspJosefa Obrusníka z&nbspŽivotských hor jsou v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehledy výsledků týmu <a href="files/kpz2015.pdf" target="_blank">KPŽ</a> a&nbspoddílu jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.
			
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/25ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 25</p>
				<p class="datumVlozeniAktuality">22/06/15 14:05</p>
				<p class="comment">
			Na závodě ze seriálu KPŽ u&nbsppřehrady Orlík se čerti ženili. Sice ne tak divoce jak je na obrázku, ale vody na zem spadlé a&nbspv&nbspbláto proměněné bylo neúrekom. I&nbspsamotného Jardu toto počasí předčasně vyhnalo z&nbsptrati do Maserati karavanu. Ne však naše „čertíky” Jana Procházku a&nbspMartina Pirucha. Ti nedali nikomu šanci a&nbspve své kategorii obsadili první dvě místa. Obdobně se z&nbsppekelnými, přírodou seslanými nástrahami vypořádali i&nbspdalší dva naši životem zkušenější borci Kateřina Nábělková a&nbspPetr Koubek, když oba shodně vybojovali třetí místa ve svých kategoriích.<br>
			Vítězství na etapovém závodě dvojic Kotáry Tůr !!! Po bratrech Kučerových, kteří tento závod vyhráli v&nbspjeho prvním ročníku v&nbsproce 1999, zopakovala stejné umístění i&nbspv&nbspjeho patnáctém pokračování dvojice Marek Julina a&nbspRadim Horáček a&nbspto v&nbsprekordním čase.
			<br><br>
			Fotky z&nbspOrlíku od Jana Reinera a&nbspJirky Blažka jsou v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehledy výsledků týmu <a href="files/kpz2015.pdf" target="_blank">KPŽ</a> a&nbspoddílu jsou na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/24ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 24</p>
				<p class="datumVlozeniAktuality">16/06/15 19:30</p>
				<p class="comment">
			Oddychový víkend? Asi ano, prozatím v&nbspletošní sezóně víkend s&nbspnejnižší účastí podpořenou mohykánem Miličem na silničním závodě Dukovanské okruhy, snad s&nbspcílem nabytí jadrné energie na Obra Drásala. Nebo ne?<br>
			Studentíci věnovali neděli na pilování jízdy překážkovým terénem na XCO v&nbspPeci pod Sněžkou. Kvalitativní nárůst umu, jak se úspěšně poprat s&nbspješitností stavitelů trati, se zdá býti velký a&nbspnaplňuje nás očekáváním na super výsledek v&nbspněkterém z&nbspdalších letošních klání.<br>
			Nejpočetnější účast jsme měli na Cyklomaratonu v&nbspČeské Třebové. I&nbspco do počtu vavřínů. Z&nbspšesti účastníků si domů dovezli čtyři z&nbspnich něco do vitríny. V&nbspkategoriích vyhráli Petr Koubek a&nbspVladimír Kučera, druhé místo obsadila Adélka Nábělková a&nbsptřetí Kateřina Nábělková.<br><br>

			Fotky z&nbspČeské Třebové od Michala Horáka a&nbspJardy Koníčka jsou v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehledy výsledků na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/23ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 23</p>
				<p class="datumVlozeniAktuality">09/06/15 20:20</p>
				<p class="comment">
			První a&nbspasi ne poslední letošní víkend, kdy se naše dresy prsily na stupních vítězů od Velkých Karlovic až po Plzeň. Všude je přivítalo Sluncem rozpálené prostředí, vzduch rozehřátý na více jak 30°C a&nbspchladivého, osvěžujícího stínu, co by se za nehet vešlo. Některým se po dojetí do cíle v&nbspLiberci mohlo i&nbspvyčerpáním zdát, že je Ještěd vzhůru nohama. Z&nbspnejvyššího stupínku pro vítěze své kategorie si valašské kotáry obhlížela Kateřina Nábělková na Karlovském Pepi maratonu. Ze stupínku o&nbspstupeň nižšího na závodu ze seriálu KPŽ v&nbspLiberci se přesvědčoval o&nbspsprávné poloze Ještědu Martin Piruch (a&nbspto hned dvakrát, ještě z&nbsppodlahy pódia, protože dojel celkově pátý). Ze stupínku nejnižšího se radovali Adélka Nábělková ve Velkých Karlovicích, vzkříšený Vladimír Kučera ml. v&nbspLiberci a&nbspv&nbspneděli na závodě ze seriálu CMT v&nbspPlzni už posílený jedním oroseným, plzeňsky vychlazeným plzeňským Rosťa Ryplů.
			<br><br>
Fotky z&nbspLiberce od Jiřího Blažka a&nbspJane Reinera, z&nbspVelkých Karlovic od neznámého autora a&nbspz&nbspPlzně od Jiřího Rypla jsou v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehledy výsledků na obvyklém <a href="files/csch2015.pdf" target="_blank">místě</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/22ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 22</p>
				<p class="datumVlozeniAktuality">31/05/15 22:40</p>
				<p class="comment">
				Malá změna - tento víkend začíná nedělí. Jak jsem minule tvrdil, tak to někdo za mě zařídil. Počasí objednané na nedělní dětské závody bylo excelentní a&nbspto až tak, že jsme s&nbspvaší pomocí překonali účastnický rekord z&nbsppředešlého roku&nbspX a&nbspna zápolení bylo našim startérem vysláno ve všech vypsaných kategoriích dohromady 170 dětí. Boje na tratích proběhly s&nbspminimálním množstvím slz a&nbspkrve a&nbsphlavně v&nbspduchu fair play. Za dohledu paní starostky Chropyně byly vítězům na hruď zavěšeny medaile z&nbspdrahých kovů a&nbspspravedlivě vylosována LEGO tombola s&nbsphlavní cenou bikovým speciálem od firmy Dema. Za rok se na Vás opět těšíme. Výběr fotografií najdete na této <a href="https://www.flickr.com/photos/vilemeliv/sets/72157653434764988" target="_blank">adrese</a>.<br>
Když už jsme u&nbspneděle, tak musím referovat, že do růžova vyhajaný Martin Piruch na zahraničních bikových „pretekoch” zvaných Bikefest ve slovenské Kálnici, vybojoval vynikající třetí místo (druhé v&nbspkategorii), když nestačil pouze na letošního akademického mistra republiky Marka Rauchfusse a&nbspneustále výborného Karla Hartla.
<br><br>
V&nbspsobotu se v okolí Trutnova odehrál čtvrtý díl seriálu KPŽ. Ani tam jsme nechyběli. A&nbspi&nbspodtud jsme si odvezli pár pěkných umístění. Jan Procházka neopojen titulem akademického vícemistra v&nbspmaratonu si dojel pro celkové desáté místo a&nbsptřetí v&nbspkategorii. Ještě o&nbspjeden stupínek lépe se ve své kategorii umístila Kateřina Nábělková. Fotky od Jana Reinera jsou v&nbspnaší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. Přehled výsledků týmu KPŽ je <a href="files/kpz2015.pdf" target="_blank">zde</a>. Ostatní přehledy na obvyklých <a href="files/csch2015.pdf" target="_blank">místech</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/dz2015_tombola.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Dětské závody jsou za dveřmi!!!</p>
				<p class="datumVlozeniAktuality">27/05/15 20:40</p>
				<p class="">
				31. května v&nbsp10 hodin začínáme. Počasí je objednané, ceny pro vítěze nedočkavé a&nbsptombola startovních čísel naplněná k&nbspprasknutí s&nbsphlavní cenou žádající si prohánění po cestách i&nbspmimo ně. Proto neváhejte a&nbsp<a href="detske_zavody/detske_zavody_prihlaska.php">přihlaste se</a> prostřednictvím našich stránek do soboty 30. 5. 2015 do 20:00. Nestihnete-li to nevadí, hlavně dojděte včas, s&nbspkolem, přilbou a&nbspdobrou, odhodlanou a&nbspfair play náladou, startovních čísel (i&nbspvýherních) máme dost. Těšíme se na Vás.<br><br>
Bližší informace jsou na tomto <a href="detske_zavody/detske_zavody.html">odkazu</a>.

			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/21ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 21</p>
				<p class="datumVlozeniAktuality">25/05/15 18:46</p>
				<p class="comment">
				Máme vicemistra republiky v&nbspmaratonu. Akademického, a&nbspto zásluhou Jana Procházky. Trio našich akademiků se vypravilo na závod Birell Bike Vysočina maraton, který byl zároveň vypsán jako mistrovský závod české akademické obce. Celkově dojel čtvrtý, v&nbspkategorii třetí a&nbspv&nbspakademicích druhý. Prostě paráda. Prezentace oddílu byla ještě umocněna zpovědníkem z&nbspnašich řad v&nbspcíli - Pavlem Mrázkem, který celý závod moderoval a&nbspvšechny tři účastníky v&nbspnašich dresech - Jana, Martina a&nbspRadima (samé svaté křestní jméno) po dojetí vyzpovídal.
				<br><br>
				Fotky ze závodu od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/sets/72157651094128313" target="_blank">zde</a>, fotky přibližující atmosféru UCI CC od Radima <a href="https://www.flickr.com/photos/114979093@N05/sets/72157653321976766" target="_blank">zde</a>. Ostatní přehledy na obvyklých <a href="cyklooddil/cyklooddil.html">místech</a>&nbsp
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/20ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 20</p>
				<p class="datumVlozeniAktuality">20/05/15 23:20</p>
				<p class="comment">
				S mírným zpožděním k&nbspvám přichází pravidelný stručný soupis činů členů oddílu z&nbsppředcházejícího týdne, hodných záznamu navždy do temných zákoutí Bytů a&nbspbitů. Z&nbspobrázku je zřejmé, že Martin Piruch slavil. Slavil druhé místo tříčlenného ad hoc týmu při středečních závodech XCR na brněnském autodromu, kde loni tak "exceloval" Lipánek. <br><br>
				Sobotní závod seriálu KPŽ v Mladé Boleslavi se taky neobešel bez účasti "našinců" na stupních pro nejlepší. Jan Procházka vyhrál svoji kategorii a&nbspcelkovým osmým místem řádně prohnal bikery kategorie Elite. Katka Nábělková vybojovala třetí místo ve své kategorii a&nbspzopakovala tak umístění z&nbspminulého víkendu na Mamutovi. (Tajná informace - do oddílu se nám infiltrovali Kmotři)<br><br>
				Přehled oddílu najdete <a href="files/csch2015.pdf" target="_blank">zde</a>, týmu KPŽ <a href="files/kpz2015.pdf" target="_blank">zde</a> a&nbspfotky z&nbspBrna i&nbspMB ve <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, tentokrát pouze zásluhou Jana Reinera.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/19ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 19</p>
				<p class="datumVlozeniAktuality">10/05/15 23:40</p>
				<p class="comment">
				Prodloužený „Mamutí” víkend začal minimamutíkem v&nbspLutopecnách. Nultým ročníkem závodu na 25 km z&nbspkategorie OH, na který vyrazila kroměřížská diaspora oddílu. Kategorii chlapců, jinochů a mužů zároveň vyhrál Martin Klár, v&nbspkategorii děv vyhrála Kateřina Nábělková před dobře vychovanou dcerou Adélkou (zápis do tab. slávy bude učiněn při nejbližší vhodné příležitosti).
				<br><br>
				Hon na mamuta byl z&nbspnaší strany veden mimo jedné na všech frontách (trasách). Pouze nejdelší trasu jsme letos neobsadili, i&nbspkdyž adept byl, ale skolil ho jiný netvor před soubojem s&nbspmamutem. Cenné kovy si tentokrát vysloužili aktéři z&nbspdelší bikové trasy. Zlato - Vladimír Kučera ml. a&nbspbronz Kateřina Nábělková.
				Přehled účastníků honu je <a href="files/csch2015.pdf" target="_blank">zde</a>, pár fotek z&nbspTOURistické fronty od Viléma je <a href="https://www.flickr.com/photos/vilemeliv/sets/72157650265822473" target="_blank">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/18ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 18</p>
				<p class="datumVlozeniAktuality">04/05/15 21:21</p>
				<p class="comment">
				Někteří tomu nevěří nebo hledí s&nbspotevřenou pusou, jiní se suše drze usmívají. Mount Agrotec Hustopeče dobyli naši amatérští borci a&nbspne, jak píše autorka na stránkách KPŽ, eliťáci. Ti totiž musí být za skoro každou cenu první, to aby měl pan Kysilka dobrý pocit, že nevyhodil peníze oknem. No posuďte sami výsledky našich dobyvatelů - dvakrát první v kategoriích (Martin Piruch a Petr Koubek), dvakrát druzí v&nbspkategoriích (Jan Procházka a&nbspKateřina Nábělková) a&nbsptřešinka na dortu zdola - jedno třetí místo v&nbspkategorii (Vladimír Kučera). O&nbsptom se týmům s&nbspelitními členy mohlo v Hustopečích jenom zdát - vyhráli pouze závod a jednu kategorii a&nbspještě o&nbsptom píšou. Výsledky týmu jsou <a href="files/kpz2015.pdf" target="_blank">zde</a> fotky od Zuzany Koubkové, Jana Reinera a Jiřího Blažka v naší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>.
				<br><br>
				Druhá mini skupinka dvou závodících se o&nbspvíkendu vydala zkontrolovat technický stav hradu Helfštýn na AŠM. Stojí. Z&nbspdruhého stupínku (nebo třetího) na stupních pro vítěze to obhlédl Lukáš Kučera. Fotky z&nbspokolí hradu od Viléma najdete <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a>. Celkový přehled aktivity oddílu najdete <a href="files/csch2015.pdf" target="_blank">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/17ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 17</p>
				<p class="datumVlozeniAktuality">27/04/15 21:43</p>
				<p class="comment">
				Cirkus známý pod zkratkou KPŽ tuto sobotu vstoupil do své 16 sezóny obvyklým „otvírákem” Trans Brdy v Dobřichovicích u Prahy. A taky že jsme tam ani my nechyběli. Race tým našeho oddílu tam vyrazil za obhajobou loňského 5. místa v seriálu se třemi nováčky v sestavě pod drobnohledem osvědčeného kapitána Vladimíra Kučery. Jeli opravdu výborně, i když to tentokrát nebylo na bednu, tak se všichni dojevše do cíle vešli do první osmdesátky z cca osmistovky odstartovaných. Výsledky jsou v tabulce <a href="files/kpz2015.pdf" target="_blank">zde</a>, foto od Jana Reinera v naší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>.
				<br><br>
				Početnější oddílová účast se udála na „jarní srdcovce” v Prusinovicích - Rohálovské padesátce. Na boj s chronometrem se vydalo sice pouze pět ze čtrnácti přítomných členů oddílu, o to byla ale morální a technická podpora závodících intenzivnější. To se odrazilo především na výkonu Jaroslava Zemana, který poprvé v přímém srovnání dojel před Radomírem Gregorem. Na rozdíl od minulého týdne, kdy nám v Roštíně nosy mrzly a kapalo z nich kdeco, tak v Rohálově (a možná i Praze) jsme si je pro změnu řádně Sluncem přismahli, tedy ti, kteří nemazali a že jich bylo. Přehled výsledků je <a href="files/csch2015.pdf" target="_blank">zde</a>, fotky od Viléma najdete <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/16ser2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Víkendový výsledkový servis 16</p>
				<p class="datumVlozeniAktuality">19/04/15 22:43</p>
				<p class="">
				Tento víkend byl pro náš oddíl ve znamení námi pořádaného, již 13. ročníku FORCE Chřibské padesátky. Aprílový termín si jako obvykle zalaškoval s naší i vaší nervovou soustavou. Ráno počasí na krátký - krátký, cca hodinu a půl před startem na dlouhý - dlouhý + pláštěnka. Na start se neodrazení postavili ve všech kombinacích a např. kameník jel ranní variantu. Jako se už stalo tradicí, účast v poli závodníků byla okořeněna o zahraniční účastníky. Mnohaleté bujaré závodníky z Maďarska letos na startu nahradili majitelé italských pasů z týmu FORCE - Wiliers. Slibovaný odložený Velikonoční výprask se sice nekonal, ale i tak byli Italové více než dobrou konkurencí, když se všichni tři vešli do elitní patnáctky v celkovém pořadí a Massimo DeBertolis vyhrál svoji kategorii. Vítězství v letošním ročníku si nenechal vzít již několikanásobný vítěz Chřibské padesátky z předcházejících ročníků Ondřej Fojtík. Výsledky jsou <a href="chribska/chribska_vysledky.html">zde</a>, fotky najdete <a href="chribska/chribska_foto.html">zde</a>.
				<br><br>
				Oddílovou omluvenku z účasti na pořádání Ch50 získalo duo J.P. + M.P., které vyjelo na 1. závod v rámci českého poháru XCO do Teplic, aby ukázali Jardovi, jak se to jezdí a pro sebe odkoukat, jak to jezdí Jarda. Výsledky najdete <a href="files/csch2015.pdf" target="_blank">zde</a>.
				<br><br>
				Ještě musím reportovat třetí místo v kategorii Vladimíra Kučery ze závodu z minulého víkendu ze seriálu Cyklomaraton v jihomoravském Pavlově, kde byl naším nejúspěšnějším zástupcem. Fotky jsou v naší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/squadra_corse_wilier.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Aktuality z velikonočního víkendu</p>
				<p class="datumVlozeniAktuality">07/04/15 18:50</p>
				<p class="">Tož, chlapi těšte se, na posunutou italskou pomlázku na Chřibské padesátce v provedení fakt dobré, ne-li ještě lepší sestavy týmu Willier Force, která se letošního závodu zúčastní. Vzdorovat jim, s již na 99% přislíbenou účasti, bude Ondra Fojtík, mladí chrti z ČS - Accodale týmu, Petr Čech v zastoupení a možná se zjeví i nějaké to bikové zjevení (viz. foto v <a href="https://www.flickr.com/photos/cschropyne/with/16851330327/" target="_blank">galerii</a>).
				<br>
				Začátek bikové sezóny v našich lokalitách předznamenal nedělní Morkovské bajk. Výsledky našich zástupců jsou chvalitebné a konkurenci slibujeme, že ještě podstatně zrychlíme. Kapitán oddílu vyhrál svoji kategorii a Martin Piruch byl celkově pátý (viz. <a href="http://www.cyklosportchropyne.cz/files/csch2015.pdf" target="_blank">tabulka</a>).</p>
			</div>
		</div>

		<div class="aktualita reklamy">
			<div class="textAktuality" style="text-align:center;">
			<h4 class="partneriZavodu">Partneři CH50 MTB 2015</h4>
				<a href="http://www.force.cz" target="_blank">
					<img class="obrazky-sponzori" src="../images/sponsors/logo-force-white.png" style="max-width:25%;"></a>
				<a href="http://www.drimalservis.cz" target="_blank">
					<img class="obrazky-sponzori" src="../images/loga/drimal_Logo.png"></a>
				<a href="http://www.elmo.cz/en/" target="_blank">
					<img class="obrazky-sponzori" src="../images/loga/elmo_Logo.png" class="demaLogo"></a>
				<a href="http://www.kruzik.cz" target="_blank">
					<img class="obrazky-sponzori" src="../images/loga/kruzik_Logo.png"></a>
				<a href="http://www.kr-zlinsky.cz" target="_blank">
					<img class="obrazky-sponzori" src="../images/loga/zl_kraj_Logo.png"></a>
				<a href="http://www.kmotr.cz/cs" target="_blank">
					<img class="obrazky-sponzori" src="../images/loga/kmotr_logo_white.png"></a>

				</div>
		</div>

		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/chribska_banner.png" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Horké informace</p>
				<p class="datumVlozeniAktuality">25/03/15 18:50</p>
				<p class="">Na závodech Morkovský bajk dne 5. dubna 2015 a Cyklomaratonu v Pavlově dne 11. dubna 2015 se můžete přihlásit u&nbspVladimíra Kučery na Chřibskou padesátku včetně hotovostní úhrady startovného.<br>
				<br>
				Ti, jenž uhradí startovné na FORCE Chřibskou padesátku v daném termínu (do 3.4. nebo se přihlásí i&nbsps&nbspúhradou startovného na Morkovkém bajku), budou již tradičně při prezentaci obdarováni párem jedinečně originálních ponožek.</p>
			</div>
		</div>
		<!-- <div class="aktualita">
			<img src="../images/ponozky2015.jpg">
			<div class="textAktuality">
				<p class="nadpisAktuality">FORCE Chřibská 50 MTB - Dárek</p>
				<p class="datumVlozeniAktuality">12/03/15 10:52</p>
				<p class="">Tak zde jsou - originální ponožky pro ty, kteří uhradí startovné na letošní FORCE Chřibskou padesátku v termínu. Jsou nejenom originální a v limitovaném počtu, ale taky prošly náročným testem na zasněženém Ondřejovském hřebenu.
				Každý, jenž uhradí startoné na FORCE Chřibskou padesátku v termínu, získá již tradičně originální pár cyklistkých ponožek.</p>
			</div>
		</div> -->

		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/CH15.png" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">13. ročník FORCE Chřibská 50 MTB - přihlašování spuštěno!!!</p>
				<p class="datumVlozeniAktuality">30/01/15 01:10</p>
				<p class="">Velevážená bikerská komunito, už to pomalu zrychleně začíná. Nová sezóna Vašich urputných klání už vystrkuje ze zasněžených lesních cest, cestiček a trailů své drapáčky a důrazně Vám šeptá do podvědomí: „Už konečně začni s tou přípravou! Odlehči kolo i tělo!” a jiné podobné hlášky. Toto už má náš oddílový tým tahounů za sebou, prověrku výkonnosti si odbyl před čtrnácti dny na již zimní klasice v&nbspHradci Králové nad blatem (výsledky a fotky jsou na obvyklých odkazech). K tréninku si ověření organizátoři přibalili i organizaci již 13. ročníku FORCE Chřibské 50, na který se již můžete <a href="chribska/chribska_prihlaska.php">na tomto odkazu</a> přihlašovat. Tak neváhejte s přihláškou, protože maximální povolený limit počtu aktivních závodníků správou Přírodního parku Chřiby je stanoven na <b>500</b>.</p>
			</div>
		</div>

		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/pf2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">PF 2015</p>
				<p class="datumVlozeniAktuality">20/12/14 16:12</p>
				<p class="comment">Přejeme všem, aby rok 2015 byl o hodně lepší než všechny minulé. Vstupme do něj s čistým štítem. Radujme se, milujme se, zachraňujme Svět, nedržme se při zemi a i do pedálů šlapme o sto šest.</p>
			</div>
		</div>

		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/kalendarCSCh2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Náš nový kalendář ...</p>
				<p class="datumVlozeniAktuality">14/12/14 17:09</p>
			</div>
		</div>

		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/cile2015.jpg" class="lazyload">
			<div class="textAktuality">
				<p class="nadpisAktuality">Naše cíle na příští sezónu jsou nemalé</p>
				<p class="datumVlozeniAktuality">14/11/14 00:05</p>
			</div>
		</div>

		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/bvs2014.jpg" class="lazyload lastLazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">Bilanční výsledkový servis 2014</div>
				<div class="datumVlozeniAktuality">1/11/14 16:12</div>
				<p class="comment">
					Opět se přiblížilo období, kdy se chystá sv. Martin vypustit svého bílého koně mezi nás. Pro některé to znamená letos naposled vypucovat své oblíbené a více či méně hýčkané kolo, ať je to silnička nebo bike, a uložit ho k zimnímu oddechu. Ti odhodlanější z nás vytáhnou z temných zákoutí zimní speciály, ze šatníků neprofuky, nepromoky, šály a čepice, a budou s&nbspvervou sobě vlastní zdolávat nástrahy nadcházejícího ročního období.<br><br>
Po tomto krátkém úvodu přikročme k stručnému kvantitativnímu vyhodnocení letošní sezóny.<br><br>

Tak jako loni nejprve pár čísel k námi pořádaným akcím - na start FORCE Chřibská padesátka se v příhodnějších klimatických podmínkách postavilo 485 závodníků. Jen doufám, že se v lokalitě chřibských lesů usadí jejich vlastnické poměry, které nám umožní pro nadcházející ročník upravit trasu závodu tak, aby narostl poměr bikerských terénů na úkor zpevněných cest. Na Dětských závodech v&nbspChropyni jsme přivítali 138 dětí.<br><br>

Celkově se členi oddílu v letošním roce zúčastnili 70 akcí, z toho pěti na Slovensku a jedné v Rakousku. Dle vedené evidence to představuje 543 „osoboúčastí” (vlastní měrná jednotka) s nárůstem o 95 oú oproti loňskému roku. Na nich jsme vybojovali v celkovém pořadí jedno první místo, čtyři druhá a devět třetích míst. V příslušných kategoriích to bylo 36x první, 44x druhé a 40x třetí místo včetně konečných umístění v seriálech. Nejpilnějším z nás byl Martin Piruch (viz. obr.) s&nbspúčastí na třiceti akcích jen těsně následován duem V+P. Naší srdcovkou se podobně jako v předešlých letech stal holešovský Drásal s 31 aktivními účastníky (počítáno bez neméně aktivní a&nbsppočetné skupiny oddílových sympatizantů).  <br><br>

Uspěli jsme i v týmových soutěžích ve dvou nejsledovanějších tuzemských bikových seriálech. V seriálu Cyklomaraton se suverénním způsobem již od jeho osmého dějství usadil na prvním místě tým ve složení Vladimír Kučera ml., Petr Kučera, Martin Piruch, Jan Procházka a Kateřina Nábělková. Druhý tým ve složení Petr Koubek, Aleš Nábělek, Rostislav Rypl, Martin Klár a Lukáš Kučera obsadil příčku pátou. V jednotlivcích si v tomto seriálu v celkovém hodnocení v kategorii mužů nejlépe vedl Jan Procházka, když obsadil třetí místo. V kategorii žen toto umístění jen o kousek uniklo Kateřině Nábělkové. V kategoriích se nejlépe dařilo Vladimíru Kučerovi ml. a&nbspPetru Kučerovi. Oba si vybojovali zlaté medaile.<br><br>
V seriálu „Kolo pro život” tým ve složení Vladimír Kučera ml., Petr Kučera, Petr Koubek, Martin Piruch, Jan Procházka, Daniel Kučera, Michal Straka a Martin Klár sice neobhájil loňské vynikající třetí místo, ale i páté pořadí v celkovém hodnocení lze považovat za úspěšné počínání v konkurenci s týmy, v jejichž dresech jezdí závodníci kategorie „elite” nebo v této kategorii byli ještě nedávno zařazeni. V&nbspcelkovém hodnocení seriálu mezi jednotlivci se Martin Piruch a Jan Procházka těsně přiblížili k elitní desítce jedenáctým a dvanáctým místem a posunuli tak naše oddílové barvy na nové maximum. V kategoriích na pódiové umístění s bronzovou hodnotou dosáhli Petr Koubek a Martin Piruch.<br><br>

Bilance by nebyla kompletní, kdybych zde opomněl naši Adélku Nábělkovou. V rámci seriálu Cyklomaraton pořádaných soutěžích „Smart Dětský pohár” a „sprint” dosáhla v celkovém hodnocení, jak je jejím zvykem, na medaile. V tom prvním byla šestá a v kategorii druhá, ve „sprintu” sedmá a kategorii třetí.
				</p>
			</div>
		</div>
		<div class="aktualita" id="sezona2014">
			<img src="../images/bvs2014.jpg">
			<div class="textAktuality">
				<div class="nadpisAktuality">Bilanční výsledkový servis 2014</div>
				<div class="datumVlozeniAktuality">1/11/14 16:12</div>
				<p class="comment">
					Opět se přiblížilo období, kdy se chystá sv. Martin vypustit svého bílého koně mezi nás. Pro některé to znamená letos naposled vypucovat své oblíbené a více či méně hýčkané kolo, ať je to silnička nebo bike, a uložit ho k zimnímu oddechu. Ti odhodlanější z nás vytáhnou z temných zákoutí zimní speciály, ze šatníků neprofuky, nepromoky, šály a čepice, a budou s&nbspvervou sobě vlastní zdolávat nástrahy nadcházejícího ročního období.<br><br>
Po tomto krátkém úvodu přikročme k stručnému kvantitativnímu vyhodnocení letošní sezóny.<br><br>

Tak jako loni nejprve pár čísel k námi pořádaným akcím - na start FORCE Chřibská padesátka se v příhodnějších klimatických podmínkách postavilo 485 závodníků. Jen doufám, že se v lokalitě chřibských lesů usadí jejich vlastnické poměry, které nám umožní pro nadcházející ročník upravit trasu závodu tak, aby narostl poměr bikerských terénů na úkor zpevněných cest. Na Dětských závodech v&nbspChropyni jsme přivítali 138 dětí.<br><br>

Celkově se členi oddílu v letošním roce zúčastnili 70 akcí, z toho pěti na Slovensku a jedné v Rakousku. Dle vedené evidence to představuje 543 „osoboúčastí” (vlastní měrná jednotka) s nárůstem o 95 oú oproti loňskému roku. Na nich jsme vybojovali v celkovém pořadí jedno první místo, čtyři druhá a devět třetích míst. V příslušných kategoriích to bylo 36x první, 44x druhé a 40x třetí místo včetně konečných umístění v seriálech. Nejpilnějším z nás byl Martin Piruch (viz. obr.) s&nbspúčastí na třiceti akcích jen těsně následován duem V+P. Naší srdcovkou se podobně jako v předešlých letech stal holešovský Drásal s 31 aktivními účastníky (počítáno bez neméně aktivní a&nbsppočetné skupiny oddílových sympatizantů).  <br><br>

Uspěli jsme i v týmových soutěžích ve dvou nejsledovanějších tuzemských bikových seriálech. V seriálu Cyklomaraton se suverénním způsobem již od jeho osmého dějství usadil na prvním místě tým ve složení Vladimír Kučera ml., Petr Kučera, Martin Piruch, Jan Procházka a Kateřina Nábělková. Druhý tým ve složení Petr Koubek, Aleš Nábělek, Rostislav Rypl, Martin Klár a Lukáš Kučera obsadil příčku pátou. V jednotlivcích si v tomto seriálu v celkovém hodnocení v kategorii mužů nejlépe vedl Jan Procházka, když obsadil třetí místo. V kategorii žen toto umístění jen o kousek uniklo Kateřině Nábělkové. V kategoriích se nejlépe dařilo Vladimíru Kučerovi ml. a&nbspPetru Kučerovi. Oba si vybojovali zlaté medaile.<br><br>
V seriálu „Kolo pro život” tým ve složení Vladimír Kučera ml., Petr Kučera, Petr Koubek, Martin Piruch, Jan Procházka, Daniel Kučera, Michal Straka a Martin Klár sice neobhájil loňské vynikající třetí místo, ale i páté pořadí v celkovém hodnocení lze považovat za úspěšné počínání v konkurenci s týmy, v jejichž dresech jezdí závodníci kategorie „elite” nebo v této kategorii byli ještě nedávno zařazeni. V&nbspcelkovém hodnocení seriálu mezi jednotlivci se Martin Piruch a Jan Procházka těsně přiblížili k elitní desítce jedenáctým a dvanáctým místem a posunuli tak naše oddílové barvy na nové maximum. V kategoriích na pódiové umístění s bronzovou hodnotou dosáhli Petr Koubek a Martin Piruch.<br><br>

Bilance by nebyla kompletní, kdybych zde opomněl naši Adélku Nábělkovou. V rámci seriálu Cyklomaraton pořádaných soutěžích „Smart Dětský pohár” a „sprint” dosáhla v celkovém hodnocení, jak je jejím zvykem, na medaile. V tom prvním byla šestá a v kategorii druhá, ve „sprintu” sedmá a kategorii třetí.
				</p>																	
			</div>
		</div>
		
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/40ser2014.jpg" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 40</div>
				<div class="datumVlozeniAktuality">12/10/14 18:45</div>
				<p class="comment">
					Neděle 5. 10. 2014 uzavřela letošní účinkování našich dvou týmů v seriálu Cyklomaraton závodem s názvem „Okolo Zlína”. Derniéra seriálu se odehrála za, řekněme, optimálního počasí a stavu trati. Pračky i maminky tentokrát, oproti závodu na Oderské Mlýnici, závodníky pochválily a s radostí se daly do obvyklé po závodní rutinní činnosti.<br>
					V týmové soutěži již od ostravského závodu seděl pevně a neotřesitelně na prvním místě náš „tým+”. Podobně „tým A” okupoval příčku pátou. Jen někteří jednotlivci měli poslední šanci k tomu, aby vylepšili své prozatím nemedailové pozice v&nbspcelém seriálu na pozice s&nbspkovy. A povedlo se především Vladimíru Kučerovi vyskočil z brambory až pro zlato ve své kategorii. Toto, ale i zbývající celkové výsledky jsou zapsány v tabulce seriálu. (Podrobnější článek s vyhodnocením celého seriálu CMT i KPŽ připravuje právě teď kapitán oddílu z&nbspnadhledu vyšších sfér.)<br>
					V neděli, raketovým zrychleních v posledních cca pěti kilometrech trasy a v předtuše BDSM výhry v tombole, se do cíle jako první přiřítil Jan Procházka (7/5) s mírným odstupem následován Martinem Piruchem (10/3). Na nejvyšší stupínek za umístění v kategorii si vyskočil Vladimír Kučera (28/1), o stupínek níže Petr Koubek (66/2) a Adélka Nábělková (9/2). Na nejnižší stupínek se k Martinovi přidala i Adélka (111/3), která jako letos obvykle zvládla dvě CMT trasy v jednom dnu.
				</p>

				
				
				Fotky od Viléma najdete <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a> a přehledy známých výsledků všech jako <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">obvykle</a>, včetně konečných výsledků týmů CMT.
																	
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/39ser2014.jpg" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 39</div>
				<div class="datumVlozeniAktuality">30/09/14 12:30</div>
				<p class="comment">
				Sobotní ranní pohled z okna nevěštil nic dobrého, z oblohy se k zemi snášela vodní deka nejlépe charakterizovaná hanáckým termínem „venku sere” a v koutku duše jsem si pomyslel, že Rosťa chodil za kostel. Ranní pohled z okna odradil od účasti na posledním závodě seriálu KPŽ v Oderské Mlýnici i našeho nejvyššího „kmotra”. Po příjezdu do areálu závodu jsem své mínění o Rosťovi poopravil. Přivítalo nás totiž počasí probouzejícího se a dlouho vyhlíženého babího léta. Byl to taky poslední a letos jediný závod Adélky Nábělkové v&nbspseriálu Junior Trophy, s kterým se ve své kategorii rozloučila vítězstvím o dva parníky.<br>
Úkol dne pro tým zněl - jet tak, abychom udrželi čtvrté místo v celkovém hodnocení seriálu. Ale ten se ukázal jako obtížně splnitelný již před startem. Jan Procházka, jeden z našich hlavních bodových přispěvatelů, přijel zdravotně indisponovaný (což ho stálo i bednové umístění v kategorii v celém seriálu) a tak nabídnutou šanci odsunout náš tým na celkové páté místo využil tým nabuzených „ježků” a to i&nbsppřesto, že na Mlýnici jsme skončili třetí. V celkovém pořadí zajel nejlépe Martin Piruch (11/5), ale v kategorii odvedl svůj obvyklý nadstandard Petr Koubek (88/3) třetím místem.
				</p>
				
				Výběr fotek z Mlýnice od Jana Reinera a Jirky Blažka najdete v naší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, fotky od Viléma ze stejné lokality najdete <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a> a přehledy známých výsledků všech jako <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">obvykle</a> včetně konečných výsledků týmu KPŽ.
													
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/38ser2014.jpg" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 38</div>
				<div class="datumVlozeniAktuality">23/09/14 17:07</div>
				<p class="comment">
				Opět víkend, kdy jsme závodili skoro od Šumavy až k Jeseníkům. Oddíl se ve třech skupinkách rozjel do tří lokalit. Nejpočetnější, osmičlenná skupina, se vydala do Čech na plzeňský závod seriálu „Kolo pro život” s cílem získat co nejvíce bodů do týmové soutěže. Plzeň je přivítala počasím ideálním i pro zastávku ve výčepu „Na schodech” a zchlazením se jedním oroseným „gambáčem”. Opouštěli ji však za podmínek vhodných na dvě stopky domácí trnkové (to asi hledal Rosťa, jaképak modlení). Nejlépe se s počasím vypořádal Martin Piruch - zavčas si přivodil neopravitelný defekt, nejhůře Vladimír Kučera (65/13) - ten si zase o několik kilometrů blouděním prodloužil dobu na trati v pořádné dávce dešťových kapek. Ale i přes tyto potíže, lze naši první výpravu na tento závod považovat za úspěšnou. Jan Procházka (8/2) dojel v první desítce celkového pořadí a druhý ve své kategorii. Výsledkově ho podpořil Petr Koubek (63/3) třetím místem v kategorii. Stejného umístění dosáhl v Plzni i tým a v průběžném pořadí seriálu poskočil na čtvrtou příčku.<br>
Druhé dvě dvoučlenné skupiny vyrazily dobývat Sudety. Jan Peza (59/29) a Martin Klár (69/26) se usilovně prali s, že prý, nejtěžší tuzemskou maratonskou 115 kilometrovou tratí známou jako „Rallye Sudety”.<br>
Druhá skupinka složená z bratrů Horáčkových si jela pro zlato do Horního Údolí na „Zlatohorskou magistrálu”. A povedlo se - Radim Horáček (6/1) si, i přes zajetí způsobené nepřejícím, značení trati měnícím domorodcem, domů odvezl zlatou medaili.<br>
Nábělkovic rodina měla tento víkend volno (dopíjela zásoby vína) a Lipánek byl spatřen v sobotu 7:47 pod přerovským mostem, jen přechodní brňáci Martin Piruch (16/10) a Jan Procházka (45/23) si v neděli střihli pár koleček na „Pell’s kritériu”.
				</p>
				Výběr fotek z Plzně od Jana Reinera najdete v naší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, fotky od Viléma ze Zlatohorské magistrály najdete <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a> a přehledy všech známých výsledků jako <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">obvykle</a>.													
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/37ser2014.jpg" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 37</div>
				<div class="datumVlozeniAktuality">14/09/14 22:45</div>
				<p class="comment">
				Nová destinace seriálového závodu KPŽ v Novém Městě na Moravě se na nás vytáhla výborným zázemím. Ovšem dodané počasí snad vítal pouze náš kapitán (nebo to mává na Lucii?) a pár již profláknutých „blátobikerů”. Pršelo, nepršelo, lilo, … jen Slunce se za mraky schovávalo, pokud ho náhodou v tento den nad Moravou někdo „nečórknul”. Snad všem po průjezdu cílem tuhly úsměvy na tváři vyjma Martina Pirucha (17/2), který si dojel pro stříbro ve své kategorii. Špatně připevněné startovní číslo „13”, přineslo asi smůlu ve formě zlomeného sedla Janovi Procházkovi, který již před polovinou závodu mohl jít sbírat houby.<br>
				S podobným počasím, ale s příjemnějším údajem °C na teploměru, se potýkala i úderná jednotka Nábělkových na Valtickém cyklobraní. Tento závod se ukázal dobrou volbou k doplnění a zmnožení rodinných vinných zásob, se kterým započali již minulý týden ve Znojmě.  Děvčata Nábělkovic nedaly svým soupeřkám šanci a o parník vyhrály své kategorie, hlava rodiny se taky vytáhla a dojela ve své kategorii třetí. O kolik se zvýšil stav vinných zásob je prozatím bedlivě střeženým údajem.<br>
				Další tříčlenná úderka se vypravila na závod ze seriálu CMT do Prahy. Lukáši Kučerovi (43/4) uniklo pódiové umístění jen, s&nbspohledem na tBBT, o nicotný časový úsek.
				</p>
				Pár fotek z NMnM od Jana Reinera najdete v naší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>, přehledy výsledků všech jako <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">obvykle</a>.											
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/36ser2014.jpg" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 36</div>
				<div class="datumVlozeniAktuality">09/09/14 06:45</div>
				<p class="comment">
				„Znojmo, Znojmo, vidím tě dvojmo, není to tentokrát lihovinou” … tento text refrénu známé písně od Ivana Mládka se mi vloudil do klávesnice při psaní víkendového výsledkového servisu, protože jeho dominantní akcí byl sobotní „Burčák Tour” v rámci seriálu KPŽ. Tento závod by se dal charakterizovat například takto - zběsilá biková oddechovka. Průměrná rychlost vítěze o čučuť přesáhla hodnotu 34 km/h, což je cca o deset km/h vyšší rychlost než na ostatních závodech seriálu. I&nbspvětšina našich „tryskáčů” hravě překonala hranici 30 km/h a některé jsem ani nezaregistroval v pádícím davu a tudíž je nevyfotil. Pro sklenici pravých znojemských okurek si snad dojeli skoro všichni, pro flašu vína si přiletěli Kateřina Nábělková druhým místem v kategorii a Petr Koubek s Janem Procházkou, kteří přistáli na třetích místech ve svých kategoriích.<br>
				Víkendovou derniérou několika našich členů oddílu, nevyzávoděných a abstinujících po pořádném kopci, se staly „Slavkovské radary”, kde si nejlépe vedl Petr Kučera čtrnáctým místem a jako jediný z našich zajel trať pod 20 minut.
				</p>
				Přehledy výsledků najdete v odkazu <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">výsledky</a> a fotky od Viléma Horáčka na tomto <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">odkazu</a>.										
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/34ser2014.jpg" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 34</div>
				<div class="datumVlozeniAktuality">26/08/14 09:05</div>
				<p class="comment">
				Dvoudenní dobývání vavřínů v českých krajích - tak by se mohl nazvat tento víkend v podání našich týmů v seriálech KPŽ a CMT. Sobotní zteč se odehrála na jednom z obtížnějších závodů seriálu KPŽ s importovaným indiánským názvem Manitou. Nejcennější vavříny v kategoriích jsme sice nezískali, ale jeden stříbrný, zásluhou Jana Procházky (14/2), a dva bronzové, které okrášlily krky Martina Pirucha (16/3) a Petra Koubka (98/3), jsou výborným výsledkem sedmičlenného týmu.<br>
				Nedělní žeň vavřínů začala již v sobotu přesunem části týmu KPŽ z Chrudimi do cca 170 km vzdáleného Berouna a jeho metamorfózou v tým CMT, doplněný tříčlennou Yeti skupinou z Kroměříže. Stanový bivak, rozložený u Berounky za „ideálního” letního počasí byl sladkou odměnou za ušetřené hodiny trmácení se v týmových vozech. Úspěšnost zvoleného postupu se projevila v nadstandardních výsledcích v kategoriích, ale i celkovém pořadí. V kategoriích dvě první, dvě druhá a tři třetí místa. V celkovém pořadí druhé místo Jana Procházky (2/2) a třetí Martina Pirucha (3/1). Nejúspěšnější co do počtu a hodnoty medailí byla Adélka Nábělková (78/1) se zlatou v kategorii na krátké trati a v závodech svých vrstevníků se stříbrnou (5/2).
				</p>
				Přehledy výsledků najdete v odkazu <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">výsledky</a>, fotky z Chrudimi od Zuzany Koubkové a Jana Reinera ve <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii oddílu</a>, fotky z Berouna od Zuzany Koubkové tamtéž.								
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/33ser2014a.jpg" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 33</div>
				<div class="datumVlozeniAktuality">19/08/14 16:21</div>
				<p class="comment">
				Rusavská padesátka - náš skoro domácí podnik, symbolizovaný osobou spolupořadatele a nezaměnitelného spíkra z řad našeho oddílu Pavla Mrázka, se dočkal již jedenáctého pokračování. Letos byl závod zpestřen počasím s občasnými dešťovými přeháňkami a to jak v týdnu před závodem, tak i v jeho průběhu. Notoricky známá trasa, na které už mimo Pavla Žáka snad nikdo nezabloudí, se v obvyklých místech proměnila do větších či menších kaluží a blátivých úseků. Celkový počet závodících členů oddílu na obou trasách se zastavil na čísle 16. S početnou skupinou „podpůrného personálu” se počet navýšil až k číslu ±40. Nejlépe se s tratí popasoval Jan Procházka (4/3), který dlouho sekundoval dvojici pronásledovatelů suveréna závodu Ondry Fojtíka. V kategorii zase nejlépe sprintoval do cíle Petr Koubek (65/2), když dojel o fous druhý. V kategoriích jsme získali ještě další dvě umístění na stupních vítězů a to zásluhou Kateřiny Nábělkové (377/3) a Vladimíra Kučery (29/3). Smůla si ihned po startu našla Martina Pirucha (10/7), který se připletl do drobné, leč déle trvající kolize vícera bikerů.<br>
				Odloučená dvoučlenná jednotka složená z Rostě (44/3) a Jiřího Ryplových se vypravila prozkoumat terény v Životských horách na tamní 30 km trati. Průzkum byl rychlý a úspěšný - Rosťa si domů do sbírky odvezl bronzovou medaili za umístění ve své kategorii (viz. foto Jana Obrusníka v oddílové fotogalerii).
				</p>
				Přehledy výsledků najdete v odkazu <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">výsledky</a>, fotky z R50 od Jirky Blažka ve <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a> oddílu a od Viléma Horáčka na tomto <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">odkazu</a>.							
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/32ser2014.jpg" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 32</div>
				<div class="datumVlozeniAktuality">11/08/14 16:20</div>
				<p class="comment">
				Tož, kam vyjeli naši borci za vavříny? Nejdál se vypravil již ve čtvrtek na sólo akci kapitán oddílu. Až za východňárama do slovenského Svitu na tříetapovou bikovou akci Horal Tour. V první etapě - vysokotatranské - výšlapu do „kopce” na 31 km trase s cílem ve Ski areálu na Štrbském Plese za „krásného” deštivého počasí dojel celkově šestý a první v kategorii. V druhé etapě - nízkotatranské - maratonu na 127 km dojel celkově sedmý a opět první v kategorii. V poslední třetí etapě - cross country na 5 kol - dojel celkově čtvrtý a pro změnu druhý v kategorii. Celkové výsledky Horal Tour nejsou v tuto chvíli ještě k dispozici, ale předpokládám, že svoji kategorii s přehledem vyhrál a v celkovém pořadí bude hodně vysoko.
				Nejpočetnější skupina se vypravila do černé Ostravy na závod ze seriálu CMT. A pro některé zúčastněné to byl fakt „černý” den. Martin Piruch (11/2) zápolil se značením trasy, což ho stálo první místo v kategorii, Petr Koubek (63/5) zase s defekty, Jan Procházka (21/10) s obojím a Martin Klár snad se vším, takže ani nedojel. Na bednu se ve své kategorii probojovala naše medailová stálice Kateřina Nabělková (126/2) a příjemně překvapil druhým místem v kategorii Lukáš Kučera (58/2). Poslední medaili do sbírky z Ostravy přidala třetím místem Adélka Nábělková (4/3).
				</p>
				Přehledy výsledků najdete tam jako obvykle a fotky od Zuzany Koubkové v <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a> oddílu.					
			</div>
		</div>
		
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/31ser2014.jpg" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 31</div>
				<div class="datumVlozeniAktuality">04/08/14 12:32</div>
				<p class="comment">
				Další víkend v letošní sezóně, kdy jsme se za závody vypravili napříč celou naší republikou. Nejpočetnější, jedenáctičlenná skupina se vypravila do blízké, sluncem zalité Bystřice pod Hostýnem na Hostýnskou padesátku. Zde na cenný bronzový kov dosáhla ve své kategorii Kateřina Nábělková (201/3). Početně druhá skupina, čítající osm kousků, se vypravila na závod ze seriálu KPŽ do šumavského Zadova. Oč jich bylo méně, o to více cenných kovů si dovezli domů. Přesně tři stříbrné a jednu zlatou. Zlato ve své kategorii vybojoval Jan Procházka (8/1), stříbro Martin Piruch (9/2), Vladimír Kučera (22/2) a Petr Koubek (69/2). Skupina s nejmenším počtem členů (pěti) se vypravila na závod ze seriálu CMT až do Ústí nad Labem. I zde se urodily dva bronzové kousky a to zásluhou Petra Kučery (8/3) a Martina Klára (10/3).<br>
				Nedělní výšlap na Praděd si nenechala ujít šestnáctka cyklistů z různých týmů. Jen organizátor Lipánek v oprávněných obavách, že si bude muset intenzivní metodou prát svůj nový cyklistický „kroj”, se potenciálních zážitků z výletu dobrovolně vzdal. 
				</p>
				Fotky z Hostýnské padesátky od Viléma najdete <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a>, fotky ze Zadova od Zuzany Koubkové a Vladimíra Kučery jsou <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">zde</a>. Tabulky výsledků jsou <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">zde</a>.		
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/30ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 30</div>
				<div class="datumVlozeniAktuality">28/07/14 11:43</div>
				<p class="comment">
				Po dovolené, snad zasloužené, se opět rozběhl seriál závodů „Kola pro život”. Již tradičním závodem v tomto termínu je nadstandardně obsazený Karlštejn Tour se zázemím na dostihovém závodišti v Chuchli. Na prašné, suché a proto i rychlé trati vytápěné rozpáleným Sluncem skoro do ruda, se neztratili ani naši ogaři v rudých dresech. Petr Koubek (81/2) protrhl svoji letošní, doposud smolnou výsledkovou bilanci v tomto seriálu a vybojoval poprvé umístění na stupních vítězů druhým místem v kategorii. Stejným umístěním v kategorii jako Petr se prezentoval Jan Procházka (14/2), který ovšem, jak je jeho zvykem, pořádně proháněl všechny závodníky elitní kategorie.<br>
				Manželé Nábělkovi se vypravili na Moravskotřebovský cyklomarton. Katka (65/1) zde opět nenašla rovnocennou konkurentku a na padesátikilometrové trase vyhrála svoji kategorii.
				</p>
				Přehled výsledků z víkendu je <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">zde</a>. Výběr fotek od Jana Reinera a tajného autora z KPŽ a Petry Zápecové z Moravské Třebové v oddílovém <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">photostreamu</a>.	
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/29ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 29</div>
				<div class="datumVlozeniAktuality">22/07/14 22:42</div>
				<p class="comment">
				Tajný závod v zahraničí - alespoň takový jsem měl první dojem, když jsem si prohlédl dvě várky fotek se strohým textem, které mi došly na email. Ještě tajemnější byli pořadatelé s výsledky, které zveřejnili až dnes. K jejich přesné interpretaci bylo potřeba trochu vyšší míry dedukce, ale snad jsem nic nepřehlédl a v <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">naší tabulce</a> uvedl ty správné cifry. O kterém závodě je vlastně řeč? V sobotu, kdy se rtuť v teploměru šplhala k historickým maximům se trojice našich bikerů, ve složení V+P a Koubič, vypravila osvěžit svá těla na „blízký východ” k vodní nádrži Kanianka. Tamtéž si střihla 45 km v závodním tempu na akci „Kaňanský bicigel`” s výborným výsledkem - dvě první a jedno druhé místo v kategoriích.
				</p>
				Fotky jsou ke zhlédnutí na naší nové oddílové galerii <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">zde</a>	
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/28ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 28</div>
				<div class="datumVlozeniAktuality">14/07/14 12:42</div>
				<p class="comment">
				Po měsíční pauze, vynucené stávkujícím hardwarem, se opět připomínám se stručným soupisem slavných činů našeho oddílu.<br>

				Bikový závod Karpatský pedál, který se jel tuto sobotu se stává naší oblíbenou destinací. Loňskou medailovou žeň jsme skoro kompletně zopakovali. Naši šohaji nenechali nikoho na pochybách, že přijeli pro pocty nejvyšší a již po úvodním cca 8 km dlouhém kolečku přijeli do Javorníku s dvouminutovým náskokem před houfem pronásledovatelů. Než dojeli svorně do cíle, přidali k náskoku ještě dalších skoro pět minut. V cílovém spurtu se jako silnější předvedl rodák z blízké vesnice Martin Piruch (1/1) před Janem Procházkou (2/2). Svoji kategorii zde vyhrál i Petr Koubek (22/1) a snad tím zlomil letošní prokletí čtvrtých míst. Mezi ženami kralovala naše „popelavá” Kateřina Nábělková (142/1). Třešničkou na zlatém dortu bylo vítězství v soutěži tříčlenných týmů, kde duo šohajů doplnil Petr Kučera (12/5).<br>
				V sobotu, na trase Salzkammergut Trophy 211 km, náš nekorunovaný „dálkoplaz” Jan Peza (28/16) dojel po defektu na pěkném 28. místě. Úspěch v podobě třetího místa se o deset vteřin vyhnul Milanu Mosaznému (88/4) na dlouhé trase silničního Beskyd Tour.
				</p>
				Fotky od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a>. Přehled <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">výsledků</a> je na obvyklých místech.	
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/27ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 27</div>
				<div class="datumVlozeniAktuality">14/07/14 12:42</div>
				<p class="comment">
				První červencový víkend se odehrál ve znamení skoro domácího závodu - Drásala. Letos okořeněný o novou trasou pro vytrvalce drsného kalibru pojmenovanou příhodně „Obr Drásal” s délkou trasy 175 km. Tato výzva nedala spát třem členům našeho oddílu - Miliči Fojtovi (61/16), Aldovi Nábělkovi (90/27) a Janu Pezovi (8/8), který se zapsal nesmazatelně do historie toho závodu osmým místem. I na ostatních drásalovských trasách se naše dresy mihly na pódiu pro nejlepší - na Dlóhém Drásalovi vyhrál Jan Procházka (6/1) svoji kategorii, na Krátkém Drásalovi zase Martin Piruch (3/1) a Vladimír Kučera (17/3) zabodoval třetím místem v kategorii. Na nejkratším si odnesl stříbrnou medaili Lukáš Kučera (11/2).
				</p>
				Fotky od Viléma jsou <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a>. Přehled <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">výsledků</a> je na obvyklých místech.	
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/24ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 24</div>
				<div class="datumVlozeniAktuality">17/06/14 00:13</div>
				<p class="comment">
				Víkend 24. týdne začal již v pátek účastí čtyř členů na časovce do vrchu, konkrétně od hřbitova v BpH až k basilice na sv. Hostýně. Nejlépe z nich si vedl Pavel Mrázek (38/3) třetím místem v kategorii.<br>
				Sobotní pokračování se již odehrávalo na více místech. Od Rožnova přes obce Čechy a Bělkovice až po Ještěd. Na akci Čechy Tour se vypravila čtyřčlenná část oddílu s doprovodem (manželé Nábělkovi byli kolem 8:15 spatřeni naší výzvědnou skupinou, jak zmateně pobíhají v kukuřičném poli u Přestavlk). Zmatené pobíhání je asi nová a úspěšná tréningová metoda, která Aleše Nábělka (7/7) posunula do první desítky celkového pořadí a Kateřinu na bronzový stupínek mezi ženami. Nejlépe si zde ovšem vedl Lukáš Kučera (8/1), když dojel hned za Aldou a svoji kategorii vyhrál doslova o Titanic. Mini skupinka bří Horáčků se vypravila na Bělkovický řetěz, kde si Vít Horáček (125/11) užíval to „pravé bikování”. Další dvoučlenná mini skupinka, složená z našich agilních „dědků” Rosti Rypla (67/5) a Jaroslava Zemana (106/14), zdolávala valašské kotáry na Petyši. Nejpočetnější skupina, tvořená týmem KPŽ posíleným o Martina Klára (55/11), se vypravila na šestý závod tohoto seriálu do Liberce zkontrolovat vysílač na Ještědu. Nejrychleji kontrolu provedlo naše úderné „šohaj” duo v pořadí Martin Piruch (8/1) a Jan Procházka (9/2) s mírným odstupem následované Vladimírem Kučerou (23/2). Ti také pobrali ve svých kategoriích příslušné medaile. Cenný kov v tomto seriálu stále uniká Petru Koubkovi (97/4).
				</p>
				Přehled <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">výsledků</a> najdete na obvyklých místech. Výběr z fotek z Bělkovic od Viléma je <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/23ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 23</div>
				<div class="datumVlozeniAktuality">09/06/14 12:35</div>
				<p class="comment">
				Víkend v Čechách. Tak by se dal stručně popsat. Závodní zápolení v obou námi preferovaných seriálech se totiž přesunulo západně za Vltavu. KPŽ k přehradě Orlík a CMT do Plzně. Tam se v neděli vypravil pouze jeden mohykán, samozřejmě ten, který to měl „nejblíže” - Rosťa Ryplů (108/13). Podstatně početnější skupina vyrazila již v sobotu na závod KPŽ u přehrady Orlík. Poprvé od začátku sezóny kompletní KPŽ tým posílený hlavně o sehranou dvojici z technicko-sportovního zabezpečení výpravy. Jejich přítomnost přispěla k výbornému výsledku celého týmu - třetí místo s vysokým bodovým ziskem. V podmínkách, kdy Slunce úřadovalo na plné pecky a z chladících se závodníků stoupala skoro nasycená pára, zazářily naše dvě hvězdy dne - Jan Procházka (10/1) a Martin Piruch (13/2), když obsadily první dvě místa ve své kategorii mladíků.
				</p>
				Přehled výsledků najdete na obvyklých <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">místech</a>. Tentokrát i rozsáhlou kolekci <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotek</a> z Orlíku z čipů Jiřího Blažka a Jana Reinera.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/22ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 22</div>
				<div class="datumVlozeniAktuality">09/06/14 12:35</div>
				<p class="comment">
				Tento víkend se naše pořadatelské i sportovní aktivity odehrávaly od Jeseníků až po Povážský Inovec. V sobotu skupina již „profesionálních” organizátorů z našich oddílových řad zabezpečila bezproblémový průběh Dětských bikových závodů v Chropyni, pořádaných tradičně našim oddílem při příležitosti Mezinárodního dne dětí. Letos se této akce zúčastnilo 138 dětí od tří do patnácti let. Dařilo se i našim zástupcům - Adélka Nábělková i Lukáš Kučera si dojeli pro stříbrné medaile ve svých kategoriích.
				Sobotní závodní aktivity obstaraly dvě skupiny. První, jednočlenná úderka ve složení Jan Peza (14/6) se vypravila do Velkých Karlovic na Pepi maratón. Druhá, původně čtyřčlenná úderka, oslabená o potlučeného Jana Procházku, ve složení Martin Piruch (17/1) plus naši dva Jánošíci, vyrazila do jesenických Koutů na závod ze seriálu KPŽ. A nevedli si věru zle. Především Martin, který dojel celkově sedmnáctý a vyhrál svoji kategorii.
				Nedělní sportovní aktivity byly obdobou sobotních. Na Slovensko, do obce Kalnica se vypravil se svojí podpůrnou suitou Vít Horáček (116/13), vyjet si na kopec Inovec. Početnější skupina se vydala ku Hradci Králové na závod za seriálu Cyklomaraton. I tentokrát nenechali naši borci nikoho na pochybách, že obhajobu loňských předních míst myslí vážně. Bronz sice nikdo nezískal, ale dvě stříbra ve svých kategoriích vybojovali Petr Koubek (47/2) a Martin Piruch (9/2), dvě zlata Kateřina Nábělková (212/1) a Vladimír Kučera (16/1). 843 km - to je vzdálenost, kterou dohromady s jmenovitou délkou závodních tras na dvou kolech a přesuny na čtyřech kolech urazil za tyto dva dny Martin Piruch.
				</p>
				<a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">Zde</a> najdete přehled víkendových výsledků, výsledky týmu KPŽ a CMT. Několik <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotek</a> z Hradce od Zuzany Koubkové a Koutů od Jana Reinera a výběr fotek z <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">Kalnice</a> od Viléma.
			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<div class="nadpisAktuality">Výsledky dětských závodů</div>
				<div class="datumVlozeniAktuality">31/05/14 21:48</div>
				<p class="comment">
				Počasí i sponzoři nám byli opět nakloněni, sehraný realizační tým pracoval jak švýcarské hodinky na 110%. Předjezdci i zajezdci byli k neutahání. Závodníci byli v hojném počtu 138 osobností k sobě nesmlouvavou, ale zároveň i tolerantní a závodící v duchu fair play, konkurencí.
				</p>
				Zde najdete výsledky z <a href="http://www.cyklosportchropyne.cz/radim_look/detske_zavody_vysledky.html">dětských závodů</a> v Chropyni 2014, výběr z fotek je <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/21ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 21</div>
				<div class="datumVlozeniAktuality">26/05/14 22:45</div>
				<p class="comment">
				Proč jenom nejeli do Úpice místo Dolan ! Pomyslel jsem si, když jsem se v deset hodin podíval na radar. Ještěže nejeli do Úpice, ale do Dolan. Poopravil jsem svoje pochyby, když jsem se na radar znovu podíval asi za tři hodiny. V Úpici čerti tančili svatební odzemek. V obou lokalitách bouřkové počasí s tak vydatnými dávkami deště, že psi, na rozdíl od bikerů, zůstali ve svých přístřešcích a ani špičku nosu z něho nevystrčili. Ne tak našich patnáct borců a dvě borkyně (Adélka hned dvakrát), kteří do cíle dojeli všichni. S přelivem z bláta od hlavy až k patě, samozřejmě i na nose. Na cestu domů už svítilo sluníčko. Auta, přitížena pěti medailemi z cenných kovů za umístění v kategoriích, nechtěla svižně jet ani ze svatého kopce. Zlatou si domů odvážel Petr Kučera (19/1), stříbrné Katka Nábělková (156/2) a Vladimír Kučera (14/2), bronzové Petr Koubek (43/3) a Martin Piruch (11/3). Bez medaile jen těsně zůstal náš nejúspěšnější borec - Jan Procházka (4/4), který dojel celkově čtvrtý.
				</p>
				Přehled výsledků je na tomto <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">odkazu</a>. Výběr fotek od Zuzany Koubkové je <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 20</div>
				<div class="datumVlozeniAktuality">19/05/14 16:17</div>
				<p class="comment">
				Bláto, blátíčko, sem tam větší či menší louže a déšť, teplota kousek nad 10 °C. To byly závodní podmínky tohoto víkendu, ve kterém se na závodění vypravili pouze naši skalní, všechny rozmary počasí při závodech akceptující, členové oddílu. Jaroslav Zeman (50/5) si vyjel do Bílých Karpat ke slovenské hranici do Brumova - Bylnice na Hradní okruh, Jan Peza (23/8) se nezalekl celníků a zazávodil si v Marikovskej dolině na slovenské straně Javorníků. Nejpočetnější, čtyřčlenná skupina, vedená Vladimírem Kučerou (16/2), se vypravila na sever do podhůří Orlických hor na Sportbárt bikemaraton v Ústí nad Orlicí. Nejlépe si vedl Vladimír, když obohatil svoji sbírku o stříbrnou medaili, Petr Kučera (15/4) si domů dovezl bramboru.
				</p>
				Celkový přehled výsledků je <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/19ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 19</div>
				<div class="datumVlozeniAktuality">10/05/14 22:36</div>
				<p class="comment">
				Tento víkend, „prodloužený” o sváteční čtvrtek 8. květen, jsme zvládli závodit hned na třech frontách.
				V onen sváteční den jsme na první, předsunuté frontě dobývali drahé kovy v Liberci na závodech seriálu Cyklomaraton. V sobotu jsme za nimi vyrazili hned na zbývajících dvou frontách - část pátečních rekreantů z okolí Liberce se přesunula na závody KPŽ do Mladé Boleslavi, zbytek z Liberce se, doplněn o posily ze zálohy, vypravil do Přerova na Mamuty - silniční i bikové.
				A jak toto naše „frontální” tažení republikou od severozápadu na východ dopadlo? V Liberci jsme vybojovali umístěním v kategoriích všechny možné drahé kovy. A to zásluhou Vladimíra Kučery (16/1) zlatý, Petra Koubka (57/2) stříbrný a Katky Nábělkové (203/3) bronzový. V Mladé Boleslavi se pro změnu vytáhli mladíci Jan Procházka (12/1) se zlatou a Martin Piruch (20/2) se stříbrnou medailí. V Přerově zůstalo vytahování na bedrech zralých ročníků, které se přeměnilo v stříbrného Mamuta pro Katku Nábělkovou (148/2) na bikové trati a v bronzového pro našeho jediného zástupce na nejdelší 212 km trati silničního Mamuta Milana Mosazného (43/3). Stručně řečeno - královnou víkendu se stává bimetalová Nábělková a králem bronzový Mosazný.
				</p>
				Přehledy výsledků jsou na tomto <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">odkazu</a>. Výběr <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">fotek</a> od Viléma ze stoupání na HP Hadovna. Pár fotek z CMT v Liberci od XY a výběr fotek od Jana Reinera z KPŽ v Mladé Boleslavi <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/18ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 18</div>
				<div class="datumVlozeniAktuality">05/05/14 10:11</div>
				<p class="comment">
				První květnová sobota už s každoroční pravidelností blížící se tradici, vyláká v hojném počtu bajkerskou profesionální i hobby veřejnost různého věku do Lipníku nad Bečvou na Author Šela Maraton s cílem na nádvoří zříceniny hradu Helfštýna. Letos však náš oddíl asi v předtuše, že počasí bude ideální spíše pro otužilce, podpořil pořadatele zaplacením startovného pouze za čtyři aktivisty.
				Jediným našim mohykánem, který se vydal na dlouhou trasu byl Jan Peza (69/32). Zbytek mini týmu se vydal na 50 km trasu, kde nejlepšího výsledku dosáhl se zarputilostí sobě vlastní náš oddílový kapitán Vladimír Kučera (13/2), když si vybojoval druhé místo v kategorii.
				</p>
				Kompletní přehled výsledků členů oddílu je v tabulce <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">zde</a>.<br>
				Výběr fotografií od Viléma je <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">zde</a> a od Jana Reinera <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/17ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 17</div>
				<div class="datumVlozeniAktuality">28/04/14 08:59</div>
				<p class="comment">
				Tímto víkendem pro nás začal závodní kolotoč o sobotách, ba i nedělích. Pro členy týmů v seriálových soutěžích KPŽ a CMT skoro každý víkend, pro ostatní dle jejich výběru a časových i fyzických možností. A tak tomu bylo i tuto sobotu. Tým KPŽ se vypravil do Prahy na první závod seriálu Trans Brdy a početnější skupina členů se vypravila na „jarní srdcovku” do Prusinovic - Rohálovskou padesátku.<br>
				V Letech u Prahy byl naším nejúspěšnějším borcem Jan Procházka (16/2), který si vyjel druhou příčku v kategorii a navázal tak na úspěšnou loňskou sezónu.<br>
				V Rohálově z našich řad kralovaly dámy. Katce Nábělkové (276/4) o kousek uniklo třetí místo v kategorii. Nejhodnotnější výkon však odvedla Adélka Nábělková (3/1), která na trase přichystané v okolí Kasařova snad pro galejníky (když tuto pětikilometrovou trasu první „chlap” zdolal za 32 minut) dojela ve své kategorii první, pouhé čtyři minuty za vítězem.
				</p>
				Pár fotek z Letů najdete <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">zde</a>, fotky z Rohálovské padesátky od <a href="https://www.flickr.com/photos/vilemeliv/sets/" target="_blank">Viléma</a>. Přehled výsledků z víkendu je <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/chribska502014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">FORCE CHŘIBSKÁ 50MTB 2014 - Shrnutí</div>
				<div class="datumVlozeniAktuality">20/04/14 23:36</div>
				<p class="comment">
				Letošní 12. ročník FORCE Chřibské padesátky je za námi. Celkovým vítězem 51 km dlouhé trasy se časem 1h : 34m : 49s stal Jan Jobánek z týmu Superior Rubena Team, který vyhrál o pouhých osm vteřin před Matějem Lasákem z týmu MAX CURSOR. Na další borce v pořadí jsme čekali skoro další dvě a půl minuty. Za to se nám tato trojice vtěsnala do dvou vteřin v tomto pořadí -  Filip Adel z Jobánkova týmu, Petr Šťastný z týmu České spořitelny a Jiří Hradil z týmu generálního sponzora FORCE.<br>
				Z děvčat trať časem 1h : 55m : 29s nejrychleji prolétla Denisa Stodůlková z týmu České spořitelny před Lucií Boudnou z týmu Život na kole a Šárkou Vojtkovou, která si jen tak odskočila na chvilku od plotny (bez týmu).	
				</p>
				Celkové výsledky najdete na stránkách časoměřičů prostřednictvím tohoto <a href="http://www.atletikauni.cz/cz/s1522/Kalendar-akci/Seznam-akci/c2130-Detail-akce/ata77-Chribska-50ka-MTB" target="_blank">odkazu</a> nebo na našich stránkách zde, kde je i soubor ke stažení ve formátu pdf. Fotografie naleznete na těchto odkazech.
			</div>
		</div>
		<div class="aktualita">
			<img src="../images/placeholder.png" data-src="../images/15ser2014.png" class="lazyload">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 15</div>
				<div class="datumVlozeniAktuality">13/04/14 13:06</div>
				<p class="comment">
				Tento víkend byl ve znamení ostrého startu seriálu závodů CYKLOMARATON prvním počítaným závodem na Pálavě. V zázemí závodu v prostorách Yacht clubu Pavlov u přehrady Nové Mlýny nás přivítalo slunečné, ale chladné počasí a nadržená smečka závodění chtivých konkurentů toužících po našem skalpu, se kterými jsme se rozloučili v loni ve Zlíně. Že jim týmové prvenství, ale i jiné vydobyté posty z loňska, tak snadno nepřepustíme jsme zde dokázali ziskem tří pódiových míst. Vladimír Kučera (30/1) vyhrál svoji kategorii. Katka Nábělková (224/3) a Petr Koubek (79/3) si domů přivezou bronz.
				</p>
				Přehled výsledků najdete <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">zde</a> a výběr z fotografií Jana Reinera <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<div class="nadpisAktuality">VÍKENDOVÝ VÝSLEDKOVÝ SERVIS 14</div>
				<div class="datumVlozeniAktuality">06/04/14 23:05</div>
				<p class="comment">
				Tak se opět na našich stránkách objevuje „VVS”. Tentokrát začínáme čtrnáctým týdnem i když uspokojivou výsledkovou overturu jsme si odbyli již v týdnu třetím. Čas mezi těmito daty vyplnila většina členů oddílu k intenzivnímu najíždění tréningových dávek v množstvích od desítek do tisíců kilometrů a to jak na tuzemských štrekách (díky přízni letošního zimního počasí) tak někteří i v krajích cyklistice více zaslíbených.<br>
				První naše letošní ostrá zkouška výkonnosti a srovnání s konkurencí se odehrála tuto neděli na „Morkovském bajku”. A konkurence byla vskutku na úrovni. Zmínil bych bratry Fojtíkovy, race tým Ghost Rubena Racing i s Pavlínou Šulcovou, úřadující mistryni v maratonu Irenu Berkovou. Do Morkovic zabloudil i nový člen Česká spořitelna - Specialized týmu Jan Reiner atd.<br>
				Jak dopadly naše barvy ve více jak dvěstě členném pelotonu? V první desítce s jedním třetím místem v kategorii dojeli naši mladíci Jan Procházka (5/3) a Martin Piruch (9/5). Svoji kategorii vyhrál Vladimír Kučera (20/1).<br>
				V prvním ročníku „Dětského Morkovského bajku” si nejlépe vedl Lukáš Kučera (2/2), který zkompletoval naše umístění na stupních vítězů druhým místem.
				</p>
				Výsledky zbývajících členů našeho oddílu, kteří se zapojili do závodění najdete v této <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">tabulce</a>.
			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<div class="nadpisAktuality">Anketa "Sportovec roku 2013"</div>
				<div class="datumVlozeniAktuality">03/03/14 18:46</div>
				<p class="comment">
				<strong>Naše pořadí bylo odtajněno - uhájili jsme vynikající 4. až 10. místo.!!!</strong>
				Na co pomyslelo v koutku duše jenom několik optimistů z našich řad se proměnilo ve skutečnost. Náš oddíl je mezi deseti finalisty v anketě kroměřížského regionu „Sportovec roku 2013”. Organizátoři ankety však nyní zařadili do jejího programu dramatickou, dvacet čtyři dnů trvající pauzu - odtajnění pořadí naplánovali až na sobotu 1. března.<br>
				Držte nám pěsti.!?
				</p>
				Píár článek z pera (lk) a fotografií (vh) naleznete <a href="http://www.cyklosportchropyne.cz/radim_look/files/csch-kpz2014.pdf">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<div class="nadpisAktuality">Zimní výsledkový servis</div>
				<div class="datumVlozeniAktuality">04/02/14 13:11</div>
				<p class="comment">
				Devitičlenná skupina členů našeho oddílu ukončila zimní spánek (na rozdíl od autora těchto řádků) a v počasí připomínajícím spíše podzim si střihla v sobotu 18. ledna závod ze seriálu CMT - Winter Hradec Králové. A naše dresy byly vidět, tedy do doby, než se všichni „oblékli” do jednotných dresů v barvě polabské černozemě. Ve výsledkové listině figuruje nejvýše náš nejúspěšnější člen Jan Procházka (celkově 3. a v kategorii také 3.) a navazuje tak na výborné loňské výsledky. Ale i zbývající účastníci zájezdu o sobě dali řádně vědět. Náš nový oddílový přírůstek Martin Piruch se blýskl vítězstvím v kategorii (5/1), Petr Kučera si dojel v kategorii pro stříbro (8/2), Lukáš Kučera (76/3) a Katka Nábělková (120/3) pro bronz. Nesmím zapomenout na Adélku Nábělkovou (93/4). Ta si na kratší trati přijela pro bramborovou medaili v kategorii, když na tu kovovou jí chyběly necelé čtyři vteřiny.<br>
				Taky musím vyzdvihnout výkon našeho jediného účastníka přidruženého závodu v běhu na 7 km Petra Kučery (1/1), který tento závod vyhrál.
				</p>
				Pár fotografií od neznámého autora ze stránek CMT najdete v naší fotogalerii <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">zde</a>. Kompletní přehled výsledků členů oddílu zase <a href="http://www.cyklosportchropyne.cz/radim_look/cyklooddil.html">zde</a>.
			</div>
		</div>
		<div class="aktualita">
			<div class="textAktuality">
				<div class="nadpisAktuality">Bilanční servis sezóny 2013</div>
				<div class="datumVlozeniAktuality">06/11/13 09:54</div>
				<p class="comment">
				Za okny padá déšť, teploměry se pomalu chystají podívat na nulu zdola - no prostě počasí, že bys ani cyklistu ven nevyhnal. Poslední i naše hromadná akce „na koho nezbude guláš na Holajce”, známá pod názvem Spadaným listím, je za námi a tak nastal vhodný čas k bilancování.<br />
				<br>
				Nejprve pár čísel k námi pořádaným akcím - na start FORCE Chřibská padesátka se i přes ne ideální počasí postavilo 350 závodníků a na Dětských závodech v Chropyni jsme přivítali 143 dětí.<br />
				<br>
				Celkově se členi oddílu v letošním roce zúčastnili 58 akcí, průměrně se na akci zúčastnilo 8 našich členů (skutečný počet je vyšší o účast neevidovaných, ale vždy přítomných sympatizantů našeho oddílu). Na nich jsme vybojovali buď v celkovém pořadí, nebo v příslušných kategoriích 42x první, 44x druhé a 41x třetí místo.<br />
				<br>
				Uspěli jsme i v týmových soutěžích. Tým ve složení Vladimír Kučera, Petr Koubek, Petr Kučera, Marek Julina, Jan Peza, Jan Blažek, Michal Straka a Jan Procházka vybojoval třetí místo v seriálu „Kolo pro život” (v podstatě první místo mezi čistě amatérskými týmy). Tým ve složení Vladimír Kučera, Petr Koubek, Petr Kučera, Aleš Nábělek a Kateřina Nábělková letos suverénně ovládl týmovou soutěž v seriálu „Cyklomaraton Tour” a vybojoval první místo. Ještě je potřeba zmínit, že všichni členi týmu se v seriálu KPŽ umistnili v první stovce celkového pořadí, u týmu v seriálu CMT dokonce v první padesátce.<br />
				<br>
				Z členů oddílu je potřeba vyzdvihnout Jana Procházku, celkově 17. a 2. v kategorii v seriálu závodů KPŽ, Petra Koubka 1. v kategorii seriálu CMT a 3. v kategorii seriálu KPŽ. Především však Vladimíra Kučeru ml., kapitána a motor oddílu, 1. v kategorii seriálu CMT a 3. v kategorii seriálu KPŽ.<br /><br>
				Bilance by nebyla kompletní, kdybych zde opomněl naše elévy - Adélku Nábělkovou a Lukáše Kučeru, absolutní vítěze ve svých kategoriích v seriálu CMT.
				</p>
				Výběr fotografií ze slavnostních zakončení seriálů KPŽ i CMT najdete v naší <a href="https://www.flickr.com/photos/cschropyne/" target="_blank">fotogalerii</a>. <br />
				Zpověď big bosse oddílu je <a href="http://www.cyklosportchropyne.cz/radim_look/files/o-cyklosportu-chropyne.pdf">zde</a>.
			</div>
		</div>
	</section>

	<div class="footer" style="position:fixed;">
		
		<div class="not-ad-at-all">
		
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
		
		// $(window).scroll(function(){

			// var topOfWindow = $(window).scrollTop();
			// var distanceFromTop = $("img.lazyload").offset().top;

			// if (distanceFromTop <= topOfWindow + 2400 && distanceFromTop >= topOfWindow + 2000) {

				// $("img.lazyload").unveil(1000, function() {

				// 	$(this).load(function() {
				// 		this.style.opacity = 1;
				// 	});
				// });
			// }
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
</body>
</html>
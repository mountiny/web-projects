<?
	session_start();
	ob_start();
	include("include.php");
//	error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
?>

<style>

	#kontejner_stred {
		height: 100vh;
		background: none;
	}

</style>


<?

$_SESSION['nacti'] 		= 0;
$rozmery 				= @$_GET['rozmery'];
$doklad 				= $_GET['doklad'];

// uprava databazi podle rokuz promenne doklady
// do tabulek nastavi dle roku v dokladu spravny rok a vygeneruje si ID aktualniho roku

$tab_nabidky_index 		= UPRAVADB($tab_nabidky_index,$doklad);
$tab_nabidky_polozky 	= UPRAVADB($tab_nabidky_polozky,$doklad);
$tab_objekty_index 		= UPRAVADB($tab_objekty_index,$doklad);
$tab_objekty_polozky 	= UPRAVADB($tab_objekty_polozky,$doklad);
$tab_objekty_pasy 		= UPRAVADB($tab_objekty_pasy,$doklad);


$x_zaklad = 1450;
$y_zaklad = 850;
		
		// test na existenci promenne pro vypocet krytiny.
		// pokud neexistuje, pridam ji
		
		$vnitrniPomer = 0;
		
		$POMER = DOTAZ($tab_objekty_index,'meritko','id',$rozmery) + $vnitrniPomer;

		$velikostPisma 	= 16;
		$prumerpopisek 	= 18;
		
		$sql = "select * from `$tab_objekty_index` where id='$rozmery'";
		$res = PROVEST ($sql);
		$row = mysql_fetch_array($res);
		
		$rastr 					= $row['rastr'];
        $modulovani 			= $row['modulovani'];
        $manual_offset 			= $row['manual_offset'];
        $kotovani 				= $row['kotovani'];
        $infotext 				= $row['info'];
		$bgimage 				= $row['bgimage'];
        $infopoznamka 			= $row['poznamka'];
        $smer_kladeni 			= $row['smer_kladeni'];
        $pomocnecary 			= $row['pomocnecary'];
        $zobraztasky 			= $row['snehovataska'];
        $tolerance_ztraty 		= $row['tolerance'];
        $kladeni_offset 		= $row['kladeni_offset'];
        $typ_krytiny 			= $row['krytina'];
        $uhel 					= $row['uhel'];
        $plocha_rodic 			= $row['rodic'];
        $kryci_sirka_krytiny 	= $row['kryciSirka'];
		$celkova_sirka_krytiny 	= $row['celkovaSirka'];
		$barvaPlochy 			= $row['barva'];

		$sql = "select * from `module_roof_nastavenikrytin` where `id` = '$typ_krytiny'";
		$res = PROVEST2 ($sql);
		$row = mysql_fetch_array($res);
		
        $stresnitaska 			= $row['stresnitaska'];
        $krytina_cary 			= $row['pomocnecary'];
        $optimalizace_modul 	= $row['optimalizace'];
        $prodlouzeni_min 		= $row['prodlouzeni_min'];
        $zadek_delka 			= $row['prodlouzeni_min'];
        $prodlouzeni_max 		= $row['prodlouzeni_max'];
        $informace 				= $row['informace'];
		$minimalni_delka		= $row['minimalni_delka'];
		$zalozka 				= $row['strih'];
		$predek 				= $row['predek'];
		
		$sql = "select * from `$tab_nabidky_index` where `cislo_fa` = '$doklad'";
		$res = PROVEST ($sql);
		$row = mysql_fetch_array($res);
		
		$vypis 					= $row['rezimKryti'];
        $material_krytina 		= $row['material_trida'];
        $vyrobce_krytina 		= $row['vyrobce'];
        $snehovaoblast 			= $row['snehovaoblast'];
        $snehovyuhel 			= $row['snehovyuhel'];
        $pome2d 				= $row['2dpomer'];
		$updatem2  				= @$_GET['updatem2'];
		
		// moznost volit optimalizaci rozmeru ktytin

		$setOpt = PROMENNE_KOMENTAR ('MODUL_STRECHA', 'OPTIMALIZACE');
		include("include/src/funkce_strechy.php");
	
	if (@$_GET['rozmery'] != ""){
		$x_obr = sejmi_rozmer($rozmery, 'x'); 	// dynamicke zvetseni osy X obrazku podle nejvetshiho X rozmeru
		$y_obr = sejmi_rozmer($rozmery, 'y');  	// dynamicke zvetseni osy X obrazku podle nejvetshiho Y rozmeru
	}
		$sirkaLevo = 302;	// sirka leveho kontejneru pro absolutni pozicovani Javascriptu osy X v osach a spol
	
// ulozeni souboru na pozadi
	
if (@$_GET['bg'] == 1){
	$soubor = @$_POST['bgimage'];
	$id = @$_GET['rozmery'];
	
	$sql = "update `$tab_objekty_index` set `bgimage`='$soubor' where `id`='$rozmery'";
	PROVEST ($sql);
	$bgimage = $soubor;
	
	// funkce vnitrne sejme i velikost obrazku.
	// nutno se podivat do funkce sejmi_rozmer
	
	$x_obr = sejmi_rozmer($rozmery, 'x'); 	// dynamicke zvetseni osy X obrazku podle nejvetshiho X rozmeru
	$y_obr = sejmi_rozmer($rozmery, 'y');  	// dynamicke zvetseni osy X obrazku podle nejvetshiho Y rozmeru
		
}

// v pripade, ze dojde zmena smeru z tlacitka, upravim smer a nactu jej podle volby

if (@$_POST['submitsmerzleva'] != "" || @$_POST['submitsmerzprava'] != ""){
	if (@$_POST['submitsmerzleva'] != "") $postsmer = 0;
	if (@$_POST['submitsmerzprava'] != "") $postsmer = 1;
	PROVEST ("update `$tab_objekty_index` set `smer_kladeni`='$postsmer' where `id`='$rozmery'");
	$smer_kladeni = DOTAZ($tab_objekty_index,'smer_kladeni','id',$rozmery);
}

// zaokrouhleni nemodulovych krytin 
// 1. pasy se seradi podle velikosti a vzdycky se budou kontrolovat dva sousedici pasy. 
// 2. pokud je rozdil mensi nez rozsah, zaokrouhli se kratsi pas na delsi

if (POST(@$_POST['zaoNem']) != ""){

	$z 		= $_POST['zaokrouhleniNemodul'];
	$delky 	= array();
	$idPasy	= array();
	
	$sql 	= "select * from `$tab_objekty_pasy` where `plocha_id`='$rozmery' order by delka_modulu asc" ;
	$res 	= PROVEST ($sql);
	$zaz 	= mysql_num_rows($res);
	
	while ($row = mysql_fetch_array($res)){
		$idPasy[] 	= $row['id'];
		$delky[] 	= $row['delka_modulu'];
	}

	
	for ($i = 0; $i < count($delky); $i++){
		
		// test prvni a nasledujici delky
		$d1 	= $delky[$i];
		$d2 	= $delky[$i+1];
		$test 	= 0;
		
		// pokud je druha delka v toleranci, upravi se delka podle prvni
		if ($i < count($delky)-1){
			if (($d2 - $d1) < $z){
				$delky[$i] = $d2;
			}
		}
	}

	// ulozeni hodnot
	
	for ($i = 0; $i < count($delky); $i++){
		$sql = "update `$tab_objekty_pasy` set `delka_modulu` = '".$delky[$i]."' where `id`='".$idPasy[$i]."'";
		PROVEST ($sql);
	}
	
	header ("location:system_strechy.php?doklad=".$doklad."&rozmery=".$rozmery."&akce=prepocitat");
	die;
}


// ulozim nebo nactu toleranci

if (@$_POST['tolerance'] != ""){
	$tolerance_ztraty = $_POST['tolerance'];
	$sql = "update `$tab_objekty_index` set `tolerance` = '$tolerance_ztraty' where `id`='$rozmery'";
	PROVEST ($sql);
}

if (@$_GET['tolerance'] != "") $tolerance_ztraty = @$_GET['tolerance'];

$nazev_krytiny 		= DOTAZ2('module_roof_nastavenikrytin','krytina','id',$typ_krytiny);
$delka_modulu 		= DOTAZ2('module_roof_nastavenikrytin','delka_modulu','id',$typ_krytiny);
//$minimalni_delka 	= DOTAZ2('module_roof_nastavenikrytin','minimalni_delka','id',$typ_krytiny);
$x_off_left 		= 70;
$x_off_right 		= 100;
$y_off 				= 70;
$posunobjekt 		= 10; // index o kolik se bude posouvat objekt

	$sql = "select * from `$tab_objekty_pasy` where `plocha_id`='$rozmery' and `vyber`='1'";
	$res = PROVEST ($sql);
	$ukaz = mysql_num_rows($res);
	$hromadnyvyber = 0;
	if ($ukaz != 0)	$hromadnyvyber = 1;


// otoci plochu o 90st

if (@$_GET['otocPlochu'] != ""){
	
	$id = $_GET['otocPlochu'];
	global $xbody;
	global $ybody;
	
	$uhelOtoc = (int)@$_POST['rotace'];
	if ($uhelOtoc == 0) $uhelOtoc = 90;
	
	nactibody_2d($id,1);
	otocbody($uhelOtoc);
	max_body();
	
	// smazu plochu a ulozim ji otocenou
	
	$sql = "delete from `$tab_objekty_polozky` where `index`='$id'";
	PROVEST ($sql);

// upravim pole bodu a nastavim jej na hodnotu 0 na ose X/Y	
	
	$pocetbodupulka = count($body)/2;
	$pocetbodu = count($body);
	
	for ($i = 0 ; $i < $pocetbodu; $i++){

		$x = Round($body[$i]) / 100;
		$y = Round($body[$i+1]) / 100;
		$sql = "insert into `$tab_objekty_polozky` (`doklad`,`plocha`,`index`,`x`,`y`) values ('$doklad','$rozmery','$rozmery','$x','$y')";
		PROVEST ($sql);
		$i++;
		
	}
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
	die;
}


// vlozi bod do databaze

if (@$_GET['vlozbod'] != "") {
	vlozbod($_GET['vlozbod'], $rozmery);
}

// switch pomocne cary
if (@$_GET['akce'] == "snehovataska"){

	// switch stavu
	$stav = DOTAZ ($tab_objekty_index,'snehovataska','id',$rozmery);
	if ($stav == 0)	PROVEST ("update `$tab_objekty_index` SET `snehovataska` = '1' where `id`='$rozmery'");
	if ($stav == 1)	PROVEST ("update `$tab_objekty_index` SET `snehovataska` = '0' where `id`='$rozmery'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// switch pomocne cary
if (@$_GET['akce'] == "pomocnecary"){

	// switch stavu
	$stav = DOTAZ ($tab_objekty_index,'pomocnecary','id',$rozmery);
	if ($stav == 0)	PROVEST ("update `$tab_objekty_index` SET `pomocnecary` = '1' where `id`='$rozmery'");
	if ($stav == 1)	PROVEST ("update `$tab_objekty_index` SET `pomocnecary` = '0' where `id`='$rozmery'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

if (@$_GET['otoc'] != ""){
	$id = $_GET['otoc'];
	$data = $_GET['okolik'];
	$sql = "update `$tab_objekty_index` set `2d_uhel`= 2d_uhel + $data where id='$id'";
	PROVEST ($sql);
}

// zmena barvy
if (@$_GET['zmenabarvakrytina'] == "ano"){

	if ($_POST['material'] != ""){
		$mat 				= explode (";",POST($_POST['material']));
		$material_krytina 	= $mat[1];
		$material_trida 	= $mat[0];
	} else {
		$material_krytina 	= "";
		$material_trida 	= "";
	}
	
	$vyrobce 			= POST($_POST['vyrobce']);
	$snehovaoblast 		= POST($_POST['snehovaoblast']);
	$snehovyuhel 		= POST($_POST['snehovyuhel']);
	$rezim 				= POST($_POST['rezimKryti']);

	$sql = "update `$tab_nabidky_index` set `snehovaoblast`='".$snehovaoblast."',
	`snehovyuhel`='".$snehovyuhel."',
	`material`='".$material_krytina."',
	`material_trida`='$material_trida',
	`vyrobce`='$vyrobce',`rezimKryti`='$rezim'  where `cislo_fa`='".GET($_GET['doklad'])."'";
	
	PROVEST ($sql);
	header ("location:system_strechy.php?doklad=$doklad&logo=1");
	die;
	
}

if (@$_GET['kopirovatplochu'] != ""){
	
	$id 	= $_GET['kopirovatplochu'];
	$doklad = $_GET['doklad'];
	
	// zkopiruje index zaznamu
		$sql = "INSERT INTO `$tab_objekty_index` (`id2`,`nazev`,`doklad`,`krytina`,`obj_index`,`meritko`,`rastr`,`kotovani`,`modulovani`,`rodic`,`data`,`smer_kladeni`,`kladeni_offset`,`uhel`,`plocham2`,`vnitrniPomer`,`kryciSirka`,`celkovaSirka`,`barva`)
		(SELECT id2,nazev,doklad,krytina,obj_index,meritko,rastr,kotovani,modulovani,rodic,data,smer_kladeni,kladeni_offset,uhel,plocham2,vnitrniPomer,kryciSirka,celkovaSirka,barva FROM `$tab_objekty_index` WHERE id='$id' order by id asc)";
		PROVEST ($sql);
		$posledniindex = mysql_insert_id();
		
		// zmenim nazev s COPY na konci
		
		$jm = DOTAZ ($tab_objekty_index,'nazev','id',$posledniindex);
		$jm = $jm."_COPY";
		$sql = "update $tab_objekty_index set `nazev`='$jm' where `id`='$posledniindex'";
		PROVEST ($sql);
		
	// zkopiruje tabulku bodu
		
		$sql = "select * from `$tab_objekty_polozky` where `index`='$id' order by id asc";
		$res = PROVEST ($sql);
		$zaznamy = "";

		while ($row = mysql_fetch_array($res)){
			$zaznamy[] = $row['id'];
		}

		for ($i = 0; $i < count($zaznamy); $i++){
			$id_bod = $zaznamy[$i];
			// zkopiruje jednotlive body
				$sql2 = "INSERT INTO `$tab_objekty_polozky` (`doklad`,`id2`,`index`,`x`,`y`,`data_odkaz`,`data_skupina`,`data_zdroj`,`ikona`)
				(SELECT `doklad`,`id2`,`index`,`x`,`y`,`data_odkaz`,`data_skupina`,`data_zdroj`,`ikona` FROM `$tab_objekty_polozky` WHERE id='$id_bod')";
				PROVEST ($sql2);
				$poslednibod = mysql_insert_id();
			
			// zmenim provedeny zaznam
			
				$sql2 = "UPDATE `$tab_objekty_polozky` set `index` = '".$posledniindex."',`plocha`='".$posledniindex."' where `id`='$poslednibod'";
				PROVEST ($sql2);
			
		}

	// zkopiruje tabulku pasu
		$sql = "select * from `$tab_objekty_pasy` where `plocha_id`='$id'";
		$res = PROVEST ($sql);
		unset($zaznamy);
		$zaznamy = "";

		while ($row = mysql_fetch_array($res)){
			$zaznamy[] = $row['id'];
		}

		for ($i = 0; $i < count($zaznamy); $i++){
			$id_pas = $zaznamy[$i];
			// zkopiruje jednotlive pasy
				$sql2 = "INSERT INTO `$tab_objekty_pasy` (`doklad`,`id2`,`plocha_id`,`pas`,`modul_start`,`pocet_modulu`,`nemodul_ystart`,`smer_kladeni`,`delka_modulu`,`zadek`,`kryci_sirka`,`celkova_sirka`,`krytina`,`vyber`)
				(SELECT `doklad`,`id2`,`plocha_id`,`pas`,`modul_start`,`pocet_modulu`,`nemodul_ystart`,`smer_kladeni`,`delka_modulu`,`zadek`,`kryci_sirka`,`celkova_sirka`,`krytina`,`vyber`
				FROM `$tab_objekty_pasy` WHERE id='$id_pas')";
				PROVEST ($sql2);
				$poslednipas = mysql_insert_id();
			// zmenim provedeny zaznam
				$sql2 = "UPDATE `$tab_objekty_pasy` set `plocha_id` = '$posledniindex' where `id`='$poslednipas'";
				PROVEST ($sql2);
		}
	
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$id&akce=prepocitat");
	
}

// smaze bod
if (@$_GET['smazbod'] != ""){
	$id = $_GET['smazbod'];
	$doklad = $_GET['doklad'];
	$sql = "delete from `$tab_objekty_polozky` where id='$id'";
	PROVEST ($sql);
	SMAZATOPT();
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// funkce pro manipulace s pasy
// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// automaticke rozdeleni vice modulu

if (@$_GET['nemodul'] == "rozdelitvice"){
	
	global $zalozka;
	
	$strih = 	$_POST['delkarezu'];
	$stridat = 	$_POST['stridat'];
	if ($stridat != 1) $stridat = 0;

	$pas_id = array();
	$pas_delka = array();
	$pas_plocha = array();
	$pas_y = array();
	$pas_kryci = array();
	$pas_celkova = array();
	$pas_krytina = array();
	$pas_smer = array();
	$pas_pas = array();

	$sql = "select * from `$tab_objekty_pasy` where plocha_id='$rozmery' and vyber='1' order by id asc";
	$res = PROVEST ($sql);
	$zaznamu = mysql_num_rows($res);

	$t = 0;

	// nactu pasy do pole
	while ($row = mysql_fetch_array($res)){
		$pas_id[] = 		$row['id'];
		$pas_pas[] = 		$row['pas'];
		$pas_delka[] = 		$row['delka_modulu'];
		$pas_plocha[] = 	$row['plocha_id'];
		$pas_y[] = 			$row['nemodul_ystart'];
		$pas_kryci[] = 		$row['kryci_sirka'];
		$pas_celkova[] = 	$row['celkova_sirka'];
		$pas_krytina[] = 	$row['krytina'];
		$pas_smer[] = 		$row['smer_kladeni'];
	}

	$id2 = 0;

	// zpracuju pasy
	for ($i = 0; $i < count($pas_id); $i++){
		// pokud je delka vetsi nez strih, muzu pokracovat

		if ($pas_delka[$i] > $strih){

			// zkratim pas na delku
			$sql = "update `$tab_objekty_pasy` set `delka_modulu` = '$strih' where id='".$pas_id[$i]."'";
			PROVEST ($sql);

			// dopocitam zbyvajici delku

			$plocha_id = 		$pas_plocha[$i];
			$pas = 				$pas_pas[$i];
			$novy_zacatek = 	$pas_y[$i] + $strih - $zalozka;
			$pocet_modulu = 	0;
			$smer_kladeni = 	$pas_smer[$i];
			$novy_delka = 		$pas_delka[$i] - $strih + $zalozka;
			$zadek = 			0;
			$kryci_sirka = 		$pas_kryci[$i];
			$celkova_sirka = 	$pas_celkova[$i];
			$krytina = 			$pas_krytina[$i];
			$vyber = 			0;

			$sql = "insert into `$tab_objekty_pasy`
			(`doklad`,`id2`,`plocha_id`,`pas`,`nemodul_ystart`,`pocet_modulu`,`smer_kladeni`,`delka_modulu`,`zadek`,`kryci_sirka`,`celkova_sirka`,`krytina`,`vyber`)
			values
			('$doklad','$id2','$plocha_id','$pas','$novy_zacatek','$pocet_modulu','$smer_kladeni','$novy_delka','$zadek','$kryci_sirka','$celkova_sirka','$krytina','$vyber')";
			PROVEST ($sql);
			$zaznamu++;

			// switch pokud je stridani pasu

			if ($stridat == 1) $strih = $novy_delka;
		}
	}
	header ("location:system_strechy.php?generuj=smazvyber&doklad=$doklad&rozmery=$rozmery");
	die;
}

// posun nahoru
if (@$_GET['nemodul'] == "strihni"){
	
	global $zalozka;
	
	$id = nemodul_scan($_GET);

	$y = $_GET['y'];
	$x = $_GET['x'];

	$delkapuvodniho = DOTAZ ($tab_objekty_pasy,'delka_modulu','id',$id);
	$sql = "select * from `$tab_objekty_pasy` where id='$id'";
	$res = PROVEST ($sql);
	$row = mysql_fetch_array($res);

	$doklad = $row['doklad'];
	$id2 = 5555;
	$pas = $row['pas'];
	$plocha_id = $row['plocha_id'];
	$pas = $row['pas'];
	$pocet_modulu = 0;
	$nemodul_ystart = $row['nemodul_ystart'];
	$smer_kladeni = $row['smer_kladeni'];
	$delka_modulu = $delkapuvodniho - $y + $zalozka;
	$zadek = $zalozka;
	$kryci_sirka = $row['kryci_sirka'];
	$celkova_sirka = $row['celkova_sirka'];
	$krytina = $row['krytina'];
	$vyber = 0;


	if ($hromadnyvyber == 0){
		$zkraceny_delka = $y - $nemodul_ystart;
		$novy_zacatek = $y - $zalozka;
		$novy_delka = $nemodul_ystart + $delkapuvodniho - $y + $zalozka;

		// kontrola pokud je strih mimo rozsah pasu
		if (($nemodul_ystart + $delkapuvodniho) > $y){
			// 1. zkratim puvodni pas
			$sql = "update `$tab_objekty_pasy` set delka_modulu = '$zkraceny_delka' where plocha_id='$rozmery' and id='$id'";
			PROVEST ($sql);
			// 2. pridam pas
			$ystartovymodul = $y+1 - $zalozka;
			$sql = "insert into `$tab_objekty_pasy`
			(`doklad`,`id2`,`plocha_id`,`pas`,`nemodul_ystart`,`pocet_modulu`,`smer_kladeni`,`delka_modulu`,`zadek`,`kryci_sirka`,`celkova_sirka`,`krytina`,`vyber`)
			values
			('$doklad','$id2','$plocha_id','$pas','$novy_zacatek','$pocet_modulu','$smer_kladeni','$novy_delka','$zadek','$kryci_sirka','$celkova_sirka','$krytina','$vyber')";
			PROVEST ($sql);
			header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
		} else {
			header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat&infotext=".G_STRECHY_KRATKYMODUL);
			}
	}
	if ($hromadnyvyber == 1){

		// nactu vsechny promenne

		$s1 = "select * from `$tab_objekty_pasy` where plocha_id='$rozmery' AND vyber='1'";
		$res = PROVEST ($s1);

		while ($rx = mysql_fetch_array($res)){

				$id = $rx['id'];
				$delkapuvodniho = DOTAZ ($tab_objekty_pasy,'delka_modulu','id',$id);
				$sql = "select * from `$tab_objekty_pasy` where id='$id'";

				$res2 = PROVEST ($sql);
				$row = mysql_fetch_array($res2);

				$doklad = $row['doklad'];
				$id2 = 5555;
				$pas = $row['pas'];
				$plocha_id = $row['plocha_id'];
				$pas = $row['pas'];
				$pocet_modulu = 0;
				$nemodul_ystart = $row['nemodul_ystart'];
				$smer_kladeni = $row['smer_kladeni'];
				$delka_modulu = $delkapuvodniho - $y + $zalozka;
				$zadek = $zalozka;
				$kryci_sirka = $row['kryci_sirka'];
				$celkova_sirka = $row['celkova_sirka'];
				$krytina = $row['krytina'];
				$vyber = 0;

				$zkraceny_delka = $y - $nemodul_ystart;
				$novy_zacatek = $y - $zalozka;
				$novy_delka = $nemodul_ystart + $delkapuvodniho - $y + $zalozka;

				// kontrola pokud je strih mimo rozsah pasu
				if (($nemodul_ystart + $delkapuvodniho) > $y){
					// 1. zkratim puvodni pas
					$sql = "update `$tab_objekty_pasy` set delka_modulu = '$zkraceny_delka' where plocha_id='$rozmery' and id='$id'";
					PROVEST ($sql);
					// 2. pridam pas
					$ystartovymodul = $y+1 - $zalozka;
					$sql = "insert into `$tab_objekty_pasy`
					(`doklad`,`id2`,`plocha_id`,`pas`,`nemodul_ystart`,`pocet_modulu`,`smer_kladeni`,`delka_modulu`,`zadek`,`kryci_sirka`,`celkova_sirka`,`krytina`,`vyber`)
					values
					('$doklad','$id2','$plocha_id','$pas','$novy_zacatek','$pocet_modulu','$smer_kladeni','$novy_delka','$zadek','$kryci_sirka','$celkova_sirka','$krytina','$vyber')";
					PROVEST ($sql);
				}
		}
				header ("location:system_strechy.php?generuj=smazvyber&doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
	}
}

// vybrat radu

if (@$_GET['nemodul'] == "vybratradu"){
	$id = nemodul_scan($_GET);
	$plocha = DOTAZ ($tab_objekty_pasy,'plocha_id','id',$id);
	$ystart = DOTAZ ($tab_objekty_pasy,'nemodul_ystart','id',$id);

	$sql = "update `$tab_objekty_pasy` set vyber='1' where `nemodul_ystart` = '$ystart' and `plocha_id`='$plocha'";
	PROVEST ($sql);

	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// posun nahoru
if (@$_GET['nemodul'] == "posunnahoru"){
	$id = nemodul_scan(@$_GET);
	$delka = $_POST['delka2'];
	PROVEST ("update `$tab_objekty_pasy` set nemodul_ystart = nemodul_ystart + $delka where plocha_id='$rozmery' and id='$id'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// posun dolu
if (@$_GET['nemodul'] == "posundolu"){
	$id = nemodul_scan(@$_GET);
	$delka = $_POST['delka3'];
	PROVEST ("update `$tab_objekty_pasy` set nemodul_ystart = nemodul_ystart - $delka where plocha_id='$rozmery' and id='$id'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// nastavi pas podle zadani ze seznamu
if (@$_GET['nemodul'] == "novadelka2"){
	$id = nemodul_scan($_GET);
	$novadelka = $_POST['novadelka2'];
	$delkapasu = DOTAZ ($tab_objekty_pasy,'delka_modulu','id',$id);

	if ($hromadnyvyber == 0){
		PROVEST ("update `$tab_objekty_pasy` set delka_modulu = '$novadelka'  where plocha_id='$rozmery' and id='$id'");
	}

	if ($hromadnyvyber == 1){
		PROVEST ("update `$tab_objekty_pasy` set `delka_modulu` = '$novadelka' where plocha_id='$rozmery' and `vyber`='1'");
	}

	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");

}

// nastavi pas podle vybraneho modulu ze seznamu
if (@$_GET['nemodul'] == "novadelka"){
	$id = nemodul_scan(@$_GET);
	$novadelka = $_POST['novadelka'];
	$delkapasu = DOTAZ ($tab_objekty_pasy,'delka_modulu','id',$id);
	$delka = $novadelka - $delkapasu;

	if ($hromadnyvyber == 0){
		if ($paspulka == 1) PROVEST ("update `$tab_objekty_pasy` set delka_modulu = delka_modulu + ($delka)  where plocha_id='$rozmery' and id='$id'");
		if ($paspulka == 0) PROVEST ("update `$tab_objekty_pasy` set nemodul_ystart = nemodul_ystart - ($delka) , delka_modulu = delka_modulu + ($delka) where plocha_id='$rozmery' and id='$id'");
	}

	if ($hromadnyvyber == 1){
		PROVEST ("update `$tab_objekty_pasy` set `delka_modulu` = '$novadelka' where plocha_id='$rozmery' and `vyber`='1'");
	}

	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// oznaci nemodulovy pas
if (@$_GET['nemodul'] == "vyberpas"){
	$id = nemodul_scan($_GET);
	// switch stavu
	$stav = DOTAZ ($tab_objekty_pasy,'vyber','id',$id);
	if ($stav == 0)	PROVEST ("update `$tab_objekty_pasy` SET `vyber` = '1' where `id`='$id'");
	if ($stav == 1)	PROVEST ("update `$tab_objekty_pasy` SET `vyber` = '0' where `id`='$id'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}


// oznaci vsechny nemodulove  plechu v plose - z optimalizace
if (@$_GET['nemodul'] == "vyberdelku"){
	$delka = $_GET['delka'];
	PROVEST ("update `$tab_objekty_pasy` set vyber = 1 where plocha_id='$rozmery' and `delka_modulu`='$delka'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// smaze pas
if (@$_GET['nemodul'] == "smazatpas"){
	$id = nemodul_scan($_GET);

	if ($hromadnyvyber == 0){
	    PROVEST ("delete from `$tab_objekty_pasy` where `id`='$id'");	// smaze pas
	} else {
	    PROVEST ("delete from `$tab_objekty_pasy` where `plocha_id`='$idplocha' and `vyber`='1'");
	}
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}


// prodlouzi vybrane pasy o delku zadanou ve form
if (@$_GET['nemodul'] == "prodlouzit"){
	$id = nemodul_scan($_GET);
	$delka = $_POST['delka'];

	if ($hromadnyvyber == 0){
		// rozliseni vrchni a spodni casti kliku na pasu a podle toho se bud pas navysi dole ci nahore
		if ($paspulka == 1) PROVEST ("update `$tab_objekty_pasy` set delka_modulu = delka_modulu + $delka  where plocha_id='$rozmery' and id='$id'");
		if ($paspulka == 0) PROVEST ("update `$tab_objekty_pasy` set nemodul_ystart = nemodul_ystart - $delka , delka_modulu = delka_modulu + $delka where plocha_id='$rozmery' and id='$id'");
	}

	if ($hromadnyvyber == 1){
		// rozliseni vrchni a spodni casti kliku na pasu a podle toho se bud pas navysi dole ci nahore
		if ($paspulka == 1) PROVEST ("update `$tab_objekty_pasy` set delka_modulu = delka_modulu + $delka  where plocha_id='$rozmery' and vyber='1'");
		if ($paspulka == 0) PROVEST ("update `$tab_objekty_pasy` set nemodul_ystart = nemodul_ystart - $delka , delka_modulu = delka_modulu + $delka where plocha_id='$rozmery'  and vyber='1'");
	}


	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// prodlouzi vybrane pasy o delku zadanou ve form
if (@$_GET['nemodul'] == "zkratit"){
	$id = nemodul_scan($_GET);
	$delka = $_POST['delka1'];

	if ($hromadnyvyber == 0){
		// rozliseni vrchni a spodni casti kliku na pasu a podle toho se bud pas navysi dole ci nahore
		if ($paspulka == 1) PROVEST ("update `$tab_objekty_pasy` set delka_modulu = delka_modulu - $delka  where plocha_id='$rozmery' and id='$id'");
		if ($paspulka == 0) PROVEST ("update `$tab_objekty_pasy` set nemodul_ystart = nemodul_ystart + $delka , delka_modulu = delka_modulu - $delka where plocha_id='$rozmery' and id='$id'");
	}

	if ($hromadnyvyber == 1){
		// rozliseni vrchni a spodni casti kliku na pasu a podle toho se bud pas navysi dole ci nahore
		if ($paspulka == 1) PROVEST ("update `$tab_objekty_pasy` set delka_modulu = delka_modulu - $delka  where plocha_id='$rozmery' and vyber='1'");
		if ($paspulka == 0) PROVEST ("update `$tab_objekty_pasy` set nemodul_ystart = nemodul_ystart + $delka , delka_modulu = delka_modulu - $delka where plocha_id='$rozmery' and vyber='1'");
	}

	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}


// ---- modulove funkce --------------------------------------------------------------------------------------------------------------------------------------------------------------------

// strih modulu

if (@$_GET['generuj'] == "vymenaza"){
	$id = pas_scan($_GET);
	$zamodul = $_POST['vymenaza'];

	// nactu potrebne hodnoty z pasu na ktery jsem kliknul

	$sql = "select * from `$tab_objekty_pasy` where id='$zamodul'";
	$res = PROVEST ($sql);
	$row = mysql_fetch_array($res);

	$pocet_modulu = $row['pocet_modulu'];
	$nemodul_ystart = $row['nemodul_ystart'];
	$delka_modulu = $row['delka_modulu'];
	$zadek = $row['zadek'];

	// nactu pas, na kterem jsem klikl a zkopiruju hodnoty

	$sql = "select * from `$tab_objekty_pasy` where id='$id'";
	$res = PROVEST ($sql);
	$row = mysql_fetch_array($res);

	$doklad = $row['doklad'];
	$id2 = $row['id2'];
	$plocha_id = $row['plocha_id'];
	$pas = $row['pas'];
	$modul_start = $row['modul_start'];
	$smer_kladeni = $row['smer_kladeni'];
	$kryci_sirka = $row['kryci_sirka'];
	$celkova_sirka = $row['celkova_sirka'];
	$krytina = $row['krytina'];
	$vyber = 0;
	$strih = 0;
	$startx = $row['startx'];
	$starty = $row['starty'];
	$endx = $row['endx'];
	$endy = $row['endy'];
	$vazba = 0;
	$strihvlozen = $zamodul;

	$sql = "insert into `$tab_objekty_pasy` (`doklad`,`id2`,`plocha_id`,`pas`,`modul_start`,`pocet_modulu`,`nemodul_ystart`,`smer_kladeni`,`delka_modulu`,`zadek`,`kryci_sirka`,`celkova_sirka`,`krytina`,`vyber`,`strih`,`startx`,`starty`,`endx`,`endy`,`vazba`,`strihvlozen`)
	values
	('$doklad','$id2','$plocha_id','$pas','$modul_start','$pocet_modulu','$nemodul_start','$smer_kladeni','$delka_modulu','$zadek','$kryci_sirka','$celkova_sirka','$krytina','$vyber','$strih','$startx','$starty','$endx','$endy','$vazba','$strihvlozen')
	";
	PROVEST ($sql);

	// smazu puvodni pas

	$sql = "delete from `$tab_objekty_pasy` where id='$id'";
	PROVEST ($sql);

	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");

}

// vyber vse
if (@$_GET['generuj'] == "vybervse"){
	$doklad = $_GET['doklad'];
	$idplocha = $_GET['rozmery'];
	$sql = "update `$tab_objekty_pasy` set vyber = 1 where doklad='$doklad' AND `plocha_id`='$rozmery'";
	PROVEST ($sql);
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// oznaci vsechny delky plechu ve vsech plochach- z optimalizace
if (@$_GET['generuj'] == "vyberdelkuvse"){
	$a1 = $_GET['modul'];
	$a2 = $_GET['zadek'];
	$a3 = $_GET['doklad'];
	$sql = "update `$tab_objekty_pasy` set vyber = 1 where doklad='$a3' and `pocet_modulu`='$a1' and `zadek`='$a2'";
	PROVEST ($sql);
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// oznaci vsechny delky plechu v plose - z optimalizace
if (@$_GET['generuj'] == "vyberdelku"){
	$a1 = $_GET['modul'];
	$a2 = $_GET['zadek'];
	PROVEST ("update `$tab_objekty_pasy` set vyber = 1 where plocha_id='$rozmery' and `pocet_modulu`='$a1' and `zadek`='$a2'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// smaze vyber plechu
if (@$_GET['generuj'] == "smazvyber"){
	PROVEST ("update `$tab_objekty_pasy` set vyber = 0");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// oznaci pas
if (@$_GET['generuj'] == "vyberpas"){
	$id = pas_scan($_GET);
	// switch stavu
	$stav = DOTAZ ($tab_objekty_pasy,'vyber','id',$id);

	if ($stav == 0)	PROVEST ("update `$tab_objekty_pasy` SET `vyber` = '1' where `id`='$id'");
	if ($stav == 1)	PROVEST ("update `$tab_objekty_pasy` SET `vyber` = '0' where `id`='$id'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// oznaci pas
if (@$_GET['generuj'] == "vyberradu"){
	$id = pas_scan($_GET);
	$modstart = DOTAZ ($tab_objekty_pasy,'modul_start','id',$id);
	$plocha = DOTAZ ($tab_objekty_pasy,'plocha_id','id',$id);

	PROVEST ("update `$tab_objekty_pasy` SET `vyber` = '1' where `modul_start`='$modstart' AND `plocha_id`='$plocha' AND `doklad`='$doklad'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}


// smaze pas
if (@$_GET['generuj'] == "smazatpas"){
	$id = (int)pas_scan($_GET);

	if ($hromadnyvyber == 0){
		if ($id != 0){
			$sql1 = "delete from `$tab_objekty_pasy` where `id`='$id'";
			$sql2 = "delete from `$tab_objekty_pasy` where `strihvlozen`='$id'";
			PROVEST ($sql1);		// smaze pas
			PROVEST ($sql2);	// smaze mozny strih
		} else {
			header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat&infotext=".G_STRECHY_MIMOPLOCHU."");
			die;
		}
	} else {
			$sql3 = "delete from `$tab_objekty_pasy` where `plocha_id`='$idplocha' and `vyber`='1'";
			PROVEST ($sql3);
	}
			header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// prodlouzeni o 1 modul
if (@$_GET['generuj'] == "zvetsiomodulnahoru"){
	$id = pas_scan($_GET);
	$kolik = $_POST['kolik'];
	if ($_POST['kolik'] == "") $kolik = 1;

	if ($hromadnyvyber == 0){
	    PROVEST ("update `$tab_objekty_pasy` SET pocet_modulu = pocet_modulu+".$kolik." where `id`='$id'");
	} else {
	    PROVEST ("update `$tab_objekty_pasy` SET pocet_modulu = pocet_modulu+".$kolik." where `plocha_id`='$idplocha' and `vyber`='1'");
	}

	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// zkraceni o 1 modul
if (@$_GET['generuj'] == "zmensiomodulnahoru"){
	$id = pas_scan($_GET);

	if ($hromadnyvyber == 0){
	    PROVEST ("update `$tab_objekty_pasy` SET pocet_modulu = pocet_modulu-1 where `id`='$id'");
	} else {
	    PROVEST ("update `$tab_objekty_pasy` SET pocet_modulu = pocet_modulu-1 where `plocha_id`='$idplocha' and `vyber`='1'");
	}
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// posunout o 1 modul nahoru
if (@$_GET['generuj'] == "posunoutnahoru"){
	$id = pas_scan($_GET);

	if ($hromadnyvyber == 0){
		PROVEST ("update `$tab_objekty_pasy` SET modul_start = modul_start+1 where `id`='$id'");
	} else {
		PROVEST ("update `$tab_objekty_pasy` SET modul_start = modul_start+1 where `plocha_id`='$idplocha' and `vyber`='1'");
	}
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// posunout o 1 modul dolu
if (@$_GET['generuj'] == "posunoutdolu"){
	$id = pas_scan($_GET);
	if ($hromadnyvyber == 0){
		PROVEST ("update `$tab_objekty_pasy` SET modul_start = modul_start-1 where `id`='$id'");
	} else {
		PROVEST ("update `$tab_objekty_pasy` SET modul_start = modul_start-1 where `plocha_id`='$idplocha' and `vyber`='1'");
	}

	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// spojit s pasem pod
if (@$_GET['generuj'] == "spojitdolu"){
	$id = pas_scan($_GET);
	if ($hromadnyvyber == 0){
		PROVEST ("update `$tab_objekty_pasy` SET modul_start = modul_start-1 where `id`='$id'");
	} else {

		$sql = "select * from `$tab_objekty_pasy` where `plocha_id`='$rozmery' and `vyber`='1'";
		$res = PROVEST ($sql);
		while ($row = mysql_fetch_array($res)){

			// vyberu vsechny pasy v plose
			$idpuvodni = $row['id'];
			$pas = $row['pas'];
			$st_modulstart = $row['modul_start'];
			$st_pocet_modulu = $row['pocet_modulu'];
			$st_zadek = $row['zadek'];

			$s2 = "select * from `$tab_objekty_pasy` where `plocha_id`='$rozmery' AND `pas` = '$pas' AND `modul_start` < '$st_modulstart' order by `modul_start` DESC LIMIT 1";
			$res2 = PROVEST ($s2);
			while ($r2 = mysql_fetch_array($res2)){
				// upravim spojvany modul
				$pocet_modulu = $r2['pocet_modulu'] + $st_pocet_modulu;
				$id = $r2['id'];
				PROVEST ("update `$tab_objekty_pasy` set `pocet_modulu`='$pocet_modulu',`zadek`='$st_zadek' where `id`='$id'");
				// smazu nadrazeny zaznam
				PROVEST ("delete from `$tab_objekty_pasy` where `id`='$idpuvodni'");
			}
		}
	}

	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat&infotext=".G_STRECHY_MODSPOJENO);
}

// posunuti doleva o 1 modul
if (@$_GET['generuj'] == "posunoutdoleva"){
	$id = pas_scan($_GET);

	if ($hromadnyvyber != 0){
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat&infotext=".G_STRECHY_NEDOVOLENO);
		die;
	}

	$obrana = DOTAZ ($tab_objekty_pasy,'pas','id',$id);
	if ($obrana != 1){
		PROVEST ("update `$tab_objekty_pasy` SET pas = pas-1 where `id`='$id'");
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
	} else {
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&infotext=".G_STRECHY_NEDOLEVA);
	}
}

// posunuti doprava o 1 modul
if (@$_GET['generuj'] == "posunoutdoprava"){
	$id = pas_scan($_GET);

	if ($hromadnyvyber != 0){
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat&infotext=".G_STRECHY_NEDOVOLENO);
		die;
	}

	PROVEST ("update `$tab_objekty_pasy` SET pas = pas+1 where `id`='$id'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}


// rozdeleni pasu
if (@$_GET['generuj'] == "rozdelitmodul"){
	$id = pas_scan($_GET);

	if ($hromadnyvyber != 0){
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat&infotext=".G_STRECHY_NEDOVOLENO);
		die;
	}
	
	if ($POMER > 1) 	$rez_na_modulu =  Round((($y - 55) / $POMER) / $modul);
	if ($POMER <= 1) 	$rez_na_modulu =  Round((($y) / $POMER) / $modul);
		
	$startmodul = DOTAZ ($tab_objekty_pasy,'modul_start','id',$id);
	$pocetm = DOTAZ ($tab_objekty_pasy,'pocet_modulu','id',$id);
	$krytinatyp = DOTAZ ($tab_objekty_index,'krytina','id',$rozmery);
	$rez_na_modulu = $rez_na_modulu - $startmodul;

	// kdyz je pouze jednomodul, nemuzu jej delit
	if ($pocetm <= 2){
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat&infotext=".G_STRECHY_MALYMODUL."");
		die;
	}

	// zkratim spodni pas
	PROVEST ("update `$tab_objekty_pasy` SET pocet_modulu = $rez_na_modulu where `id`='$id'");

	$sql = "select * from `$tab_objekty_pasy` where id='$id'";
	$res = PROVEST ($sql);
	$row = mysql_fetch_array($res);

		$plocha_id = $row['plocha_id'];
		$pas = $row['pas'];
		$modul_start = $row['modul_start'] + $rez_na_modulu;
		$pocet_modulu = $pocet_modulu - $rez_na_modulu;
		$smer_kladeni = $row['smer_kladeni'];
		$delka_modulu = $row['delka_modulu'];
		$zadek = $prodlouzeni_min;
		$kryci_sirka = $row['kryci_sirka'];
		$celkova_sirka = $row['celkova_sirka'];
		$nazev = $row['nazev'];

	$sql = "select max(id2) from `$tab_objekty_pasy` where `plocha_id`='$plocha_id'";
	$row = mysql_fetch_array(PROVEST ($sql));
	$id2 = $row[0]+1;

	// zapisu novy rozdeleny pas
	$sql = "insert into `$tab_objekty_pasy` (`doklad`,`id2`,`plocha_id`,`pas`,`modul_start`,`pocet_modulu`,`smer_kladeni`,`delka_modulu`,`zadek`,`kryci_sirka`,`celkova_sirka`,`krytina`) values ('$doklad','$id2','$plocha_id','$pas','$modul_start','$pocet_modulu','$smer_kladeni','$delka_modulu','$zadek','$kryci_sirka','$celkova_sirka','$krytinatyp')";
	PROVEST ($sql);
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// nastav novy zadek
if (@$_GET['generuj'] == "novyzadek"){
	$id = pas_scan($_GET);
	$novyzadek = $_POST['zadek'];
        
	if ($hromadnyvyber == 0){
		PROVEST ("update `$tab_objekty_pasy` SET `zadek` = '$novyzadek' where `id`='$id'");
	} else {
		PROVEST ("update `$tab_objekty_pasy` SET `zadek` = '$novyzadek' where `plocha_id`='$idplocha' and `vyber`='1'");
	}
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// zoom na max plochu
if (@$_GET['zoom'] == "100"){

	$pomer = 1 + $vnitrniPomer;

	nactibody();
	max_body();

	if ($xmax+200+$x_off_left > $x_zaklad) $pomerx = ($xmax+200+$x_off_left ) / $x_zaklad;
	if ($ymax+100+$y_off > $y_zaklad) $pomery = ($ymax+100+$y_off) / $y_zaklad;
	if ($pomerx > $pomery) $pomer = Round($pomerx,1);
	if ($pomerx < $pomery) $pomer = Round($pomery,1);

	$sql = "update `$tab_objekty_index` set `meritko`='$pomer' where id='$rozmery'";
	PROVEST ($sql);
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}


// prepnuti rastru
if (@$_GET['akce'] == "rastr"){
	if ($rastr == 1) PROVEST ("update `$tab_objekty_index` set `rastr`='0' where id='$rozmery'");
	if ($rastr == 0) PROVEST ("update `$tab_objekty_index` set `rastr`='1' where id='$rozmery'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// prepnuti kotovani
if (@$_GET['akce'] == "kotovani"){
	if ($kotovani == 1) PROVEST ("update `$tab_objekty_index` set `kotovani`='0' where id='$rozmery'");
	if ($kotovani == 0) PROVEST ("update `$tab_objekty_index` set `kotovani`='1' where id='$rozmery'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// mirroring objektu

if (@$_GET['akce'] == "mirror"){
	nactibody();
	max_body();

	$osa = (($xmax + $xmin) / 2 / 100);

	// otocim souradnice v X

	for ($i = 0; $i < count($body); $i+=2){

		if (($body[$i]/100) < $osa) {
			$body[$i] = ($body[$i]/100) + (2 * ($osa - ($body[$i]/100)));
		} else {
			$body[$i] = ($body[$i]/100) - (2 * (($body[$i]/100) - $osa));
		}

		// zapisu bod do databaze
		$novex = $body[$i];
		$id = $bodyid[$i];
		PROVEST ("update `$tab_objekty_polozky` set `x`='$novex' where id='$id'");
	}
	SMAZATOPT();
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// posun vsech bodu
if (@$_GET['fc1'] == "1"){
	switch ($_GET['fc']){
		case "posunxminus":
		PROVEST ("update `$tab_objekty_polozky` set x = x - $posunobjekt where `index`='$rozmery'");
			$sql = "select * from `$tab_objekty_index` where `rodic`='$rozmery'";
			$res = PROVEST ($sql);
			while ($row = mysql_fetch_array($res)){
				PROVEST ("update `$tab_objekty_polozky` set x = x - $posunobjekt where `index`='".$row['id']."'");
			}
		break;

		case "posunxplus":
		PROVEST ("update `$tab_objekty_polozky` set x = x + $posunobjekt where `index`='$rozmery'");
			$sql = "select * from `$tab_objekty_index` where `rodic`='$rozmery'";
			$res = PROVEST ($sql);
			while ($row = mysql_fetch_array($res)){
				PROVEST ("update `$tab_objekty_polozky`set x = x + $posunobjekt where `index`='".$row['id']."'");
			}
		break;

		case "posunyminus":
		PROVEST("update `$tab_objekty_polozky` set y = y + $posunobjekt where `index`='$rozmery'");
			$sql = "select * from `$tab_objekty_index` where `rodic`='$rozmery'";
			$res = PROVEST ($sql);
			while ($row = mysql_fetch_array($res)){
				PROVEST ("update `$tab_objekty_polozky` set y = y + $posunobjekt where `index`='".$row['id']."'");
			}
		break;

		case "posunyplus":
		PROVEST("update `$tab_objekty_polozky` set y = y - $posunobjekt where `index`='$rozmery'");
			$sql = "select * from `$tab_objekty_index` where `rodic`='$rozmery'";
			$res = PROVEST ($sql);
			while ($row = mysql_fetch_array($res)){
				PROVEST ("update `$tab_objekty_polozky` set y = y - $posunobjekt where `index`='".$row['id']."'");
			}
		break;

	}
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
}

// smaze optimalizaci


if (@$_POST['submitsmazat'] != "") {
	SMAZATOPT();
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
	die;
}

if (@$_POST['submitoffset'] != "") {
	SMAZATOPT();
	$off = VZOREC($_POST['manualoffset']);
	PROVEST("update `$tab_objekty_index` set `manual_offset` = '$off' where `id`='$rozmery'");
	header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat");
	die;
}



// *prepocitat a ulozi vsechny hodnoty -----------------------------------------------------------------------------------------------------------------------------------------------------------

if (@$_GET['akce'] == "prepocitat"){
	
	$infotext 	= @$_GET['infotext'];
	$index 		= @$_POST['index'];
	$x 			= @$_POST['xbod'];
	$y 			= @$_POST['ybod'];
	$pocet 		= count($x);
	$mer 		= VZOREC(@$_POST['mer']);
	$poznamka 	= @$_POST['objpoznamka'];

	if (strlen($mer) != 0){
		$sql = "update `$tab_objekty_index` set `meritko`='$mer' where `id`='$rozmery'";
		PROVEST ($sql);
	}
	
	if (strlen($poznamka) != 0){
		$sql = "update `$tab_objekty_index` set `poznamka`='$poznamka' where `id`='$rozmery'";
		PROVEST ($sql);
	}

	// smazu vsechny nastavene pasy z duvodu ochrany pred chybou
	// pokud prijde prikaz z GET nebo podle nactenych dat z dbase zjistim, ze je plocha jiz zoptimalizovana

	$optimalizace = @$_GET['optimalizace'];

	$POMER = DOTAZ ($tab_objekty_index,'meritko','id',$rozmery) + $vnitrniPomer;
	$kladeni_offset = DOTAZ ($tab_objekty_index,'kladeni_offset','id',$rozmery);
	$nazev_plochy = DOTAZ ($tab_objekty_index,'nazev','id',$rozmery);
	$meritko = str_replace('.', ':', number_format(Round($POMER,1),2));

	// nactu body z POST a ulozim do DBASE
	// musim je prekonvertovat do metricke soustavy v pripade, ze se pouziva imperialni
	
	$stejne = 0;

	
	for ($i = 0; $i < $pocet; $i++){
		
		if ($_SESSION['unit'] == "metric"){
			$xBafr = VZOREC($x[$i]);
			$yBafr = VZOREC($y[$i]);
		}
		
		if ($_SESSION['unit'] == "imperial"){
			$xBafr = EXPRESS($x[$i]);
			$yBafr = EXPRESS($y[$i]);
		}
		
		echo $i."x:".$xBafr." - y:".$yBafr."<br>";
	}



	
	for ($i = 0; $i < $pocet; $i++){
		
		// nactu hodnoty z X a Y pole
		
		if ($_SESSION['unit'] == "metric"){
			$xBafr = VZOREC($x[$i]);
			$yBafr = VZOREC($y[$i]);
		}
		
		if ($_SESSION['unit'] == "imperial"){
			$xBafr = EXPRESS($x[$i]);
			$yBafr = EXPRESS($y[$i]);
		}
		
		$xbod 	= $xBafr;
		$ybod 	= $yBafr;
		$ii 	= $index[$i];

		// nejdriv nactu body a zkontroluju, zdali se zmenili
		
		$sql 	= "select * from `$tab_objekty_polozky` where `id`='$ii' AND id2 != '1'";
		$res 	= PROVEST ($sql);
		$row 	= mysql_fetch_array($res);
		$x2 	= $row['x'];
		$y2 	= $row['y'];
		
		if (number_format($xbod,2) != $x2 || number_format($ybod,2) != $y2) $stejne++;
		$sql = "update `$tab_objekty_polozky` set `x`='$xbod', `y`='$ybod',`doklad`='$doklad',`plocha`='$rozmery' where `id`='$ii'";
		PROVEST ($sql);
	}

	// prida bod do seznamu ploch
	
	if (@$_POST['fc'] == "pridatbod"){
		$sql = "insert into `$tab_objekty_polozky` (`index`,`x`,`y`) values ('$rozmery','0','0')";
		PROVEST ($sql);
		SMAZATOPT();
		//header ("location:system_strechy.php?doklad=$doklad&rozmery=$id&akce=prepocitat");
	}

	
	// nastaveni bodu, pomeru a spol 

	nactibody();
	max_body();
	
	$POMER = $POMER + $vnitrniPomer;
	
	$x_obr = sejmi_rozmer($rozmery, 'x'); 	// dynamicke zvetseni osy X obrazku podle nejvetshiho X rozmeru
	$y_obr = sejmi_rozmer($rozmery, 'y');  	// dynamicke zvetseni osy X obrazku podle nejvetshiho Y rozmeru
	
	prepoctibody();
	
	
	
// definice promennych a textu ----------------------------------------------------------------------------------------------------------------------------------------------------------------

	if ($smer_kladeni == 0) $txtsmer = G_STRECHY_SMERZLEVA." ";
	if ($smer_kladeni == 1) $txtsmer = G_STRECHY_SMERZPRAVA." ";
	
	$vyrobceNazev = DOTAZ2('module_roof_seznamvyrobcu','vyrobce','id',$vyrobce_krytina);
	
	if ($stresnitaska == 0) $txt_nazev = "$vyrobceNazev - $nazev_krytiny ( $nazev_plochy ), MOD$delka_modulu, $txtsmer";
	if ($stresnitaska == 1) $txt_nazev = "$vyrobceNazev - $nazev_krytiny ( $nazev_plochy )";

	$pocetbodupulka = count($body)/2;
	$pocetbodu = count($body);
	
	$image = imagecreatetruecolor($x_obr, $y_obr);

	// definice barev
	$barva_pozadi = 		imagecolorallocate($image, 255, 255, 255);			// barva pozadi papiru
	$barva_taska = 			imagecolorallocatealpha($image, 250, 250, 250,50);	// barva pozadi papiru
	$barva_plocha = 		imagecolorallocate($image, 250, 250, 250);			// barva plochy objektu
	$barva_obsazeno = 		imagecolorallocate($image, 231, 231, 231);			// barva plochy objektu
	$barva_strih = 			imagecolorallocatealpha($image, 255, 192, 195,85);	// barva strizenych pasu
	$barva_oramovani = 		imagecolorallocate($image, 64, 0, 64);				// barva oramovani pasu
	$barva_mimo_plochu = 	imagecolorallocate($image, 234, 234, 234);			// barva ktera vznikne prunikem barvy plochy a alpha barvy pasu krytiny !
	$barva_cervena = 		imagecolorallocate($image, 255, 192, 192);			// barva uriznute a nepouzitelne casi plechu
	$barva_cerna = 			imagecolorallocate($image, 0, 0, 0);				// cerna je cerna
	$barva_delka = 			imagecolorallocate($image, 0xC4, 0x0A, 0x0A);		// cerna je cerna
	$barva_obrysu = 		imagecolorallocate($image, 0, 0, 0);				// obrys objektu
	$barva_osa = 			imagecolorallocate($image, 0, 128, 128);			// osa a popisky osy
	$barva_pasu = 			imagecolorallocatealpha($image, 200, 200, 200, 80);	// zobrazeny pas s pruhlednosti
	$barva_vyber = 			imagecolorallocatealpha($image, 159, 254, 146, 85);	// vyber modulu
	$barva_rastr = 			imagecolorallocate($image, 230, 230, 230);			// barva rastrovani modulu
	$barva_rastr2 = 		imagecolorallocate($image, 125, 230, 230);			// barva rastrovani modulu
	$barva_body = 			imagecolorallocate($image, 255, 255, 255);			// podkres popisku

	$stylcary = array (IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT,$barva_cerna,$barva_cerna,$barva_cerna,$barva_cerna);
	imagesetstyle($image, $stylcary);

  // 1. nakresli tvar strechy ( v pomeru )

	imagefilledrectangle($image, 0, 0, $x_obr, $y_obr, $barva_pozadi);		// vyplni pozadi
	imagefilledpolygon($image, $body, $pocetbodupulka, $barva_plocha);			// nakresli vyfilovany tvar

		// vykresli pripadne podplochy

		$arr_plochy[] 	= "";	// alokace pole bodu(pole)
		$sqlx 			= "select * from `$tab_objekty_index` where `rodic`='$rozmery'";
		$resx 			= PROVEST ($sqlx);

		$i = 0;

		while ($rowx = mysql_fetch_array($resx)){

			// nactu body podplochy a zobrazim
			$objid 				= $rowx['id'];
			$sqlx2 				= "select * from `$tab_objekty_polozky` where `index`='$objid' AND id2 != '1' order by id asc";
			$resx2 				= PROVEST($sqlx2);
			$body_podplocha 	= array();
			$bodyid_podplocha 	= array();

			while ($rx2 = mysql_fetch_array($resx2)){
				$bodyid_podplocha[] 	= $rx2['id'];
				$body_podplocha[] 		= $rx2['x'];
				$bodyid_podplocha[] 	= $rx2['id'];
				
				//$body_podplocha[] = $rx2['y'];

				if ($uhel == 0) $body_podplocha[] = $rx2['y'];
				if ($uhel != 0) $body_podplocha[] = $rx2['y'] / cos(deg2rad($uhel));
			}

			// ulozim body do pole bodu
			$arr_plochy[$i] = $body_podplocha;
			$i++;
		}
		// vypis vsech ulozenych poli bodu  pokud existuji )

		if (count($arr_plochy) > 0){
			foreach ($arr_plochy as $arr_plocha){
				$pocet2 = count($arr_plocha)/2;
				$body2 = prepoctibody_podplocha($arr_plocha);
				
				if ($pocet2 > 2){
					imagefilledpolygon($image, $body2, $pocet2, $barva_pozadi);			// nakresli vyfilovany tvar
					imagepolygon($image, $body2, $pocet2, $barva_cerna);			// nakresli vyfilovany tvar
				}
			}
		}

		// operace s plochou poslou v get pozadavku prepocitani m2
		if ($stejne != 0 || $updatem2 == 1){
			$m2 = metry2($rozmery);
			$txt_plocha2 = ", ".G_STRECHY_PLOCHA." : UNIT2($m2,1) ".jednotka("plocha");

		} else {
			
			// nactu m2 plochu z databaze
			
			$m2 = DOTAZ($tab_objekty_index,'plocham2','id',$rozmery);
			$m2 = Round($m2,2);

			$txt_plocha2 = ", ".G_STRECHY_PLOCHA." : ".UNIT2($m2,1)." ".jednotka("plocha");
		}
	
		// -------------------------------------------------------------------------------------------------------------
		// ulozim velikost plochy do databaze v cm2 :) abych nemusel menit vypocet
		// jedrive provedu test, zdali podobny zaznam existuje. Pokud ne, tak se jedna o starsi plochy vytvorenou drive.
		// -------------------------------------------------------------------------------------------------------------
		$sql = "select * from `$tab_objekty_polozky` where `id2`='1' AND `plocha`='$rozmery'";
		$res = PROVEST ($sql);
		$zaz = mysql_num_rows($res);

		if ($zaz > 0){
			$sql = "update `$tab_objekty_polozky` set `data_odkaz`='".($m2*100)."' where `plocha`='$rozmery' AND `id2`='1'";
		} else {
			$sql = "insert into `$tab_objekty_polozky` (`doklad`,`plocha`,`id2`,`index`,`x`,`y`,`data_odkaz`) values ('$doklad','$rozmery','1','$rozmery',0,0,'".($m2*100)."')";
		}

		PROVEST ($sql);
	
	
   // 3. pravitko ( v pomeru )
	if ($rastr == 1){
   	    $b = 0;
	    for ($i = $x_off_left; $i < $x_obr; $i+=(100/$POMER)){
		imageline($image, $i, ($y_obr - $y_off+3), $i, ($y_obr - $y_off+15), $barva_cerna);			// osa X carky
		Imagestring ($image, 2, $i+4, $y_obr-$y_off+5, ($b*100),$barva_osa );					// osa  texty
		$b++;
	    }
	    $b = 0;
	    for ($i = $y_obr - $y_off; $i > 0; $i-=(100/$POMER)){
		imageline($image, $x_off_left-3, $i, $x_off_left-15, $i, $barva_cerna);			// osa Y carky
		Imagestring ($image, 2, $x_off_left-25,$i-13, ($b*100),$barva_osa);				// osa Y texty
		$b++;
	    }

	   	// 2. nakresli souradnice
		imageline($image, 0, ($y_obr - $y_off+2), $x_obr, ($y_obr - $y_off+2), IMG_COLOR_STYLED);		// souradnice X
		imageline($image, ($x_off_left-2), 0, ($x_off_left-2), $y_obr, IMG_COLOR_STYLED);					// souradnice Y
	}
	
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// START OPTIMALIZACE
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// *optimalizace dat :) ... tak naschval :)

			if ($optimalizace == "ano"){
				// smazu vsechny zaznamy v databazi pokud jsou
				
				$sql = "delete from `$tab_objekty_pasy` where `plocha_id`='$rozmery'";
				PROVEST ($sql);

				// odnastavim vsechny moduly
				PROVEST ("update `$tab_objekty_pasy` set vyber = 0");

				// smazu xoffset
				PROVEST ("update `$tab_objekty_index` set kladeni_offset = 0 where id='$rozmery'");

				// optimalizace pro smer zleva

				$opt_pasu = Ceil(($xmax-$xmin) / 100 / $kryci_sirka_krytiny);
				$opt_modulu = Ceil(($ymax - $ymin) / ($delka_modulu/10));
				$opt_krytina = $kryci_sirka_krytiny * 100;
				$opt_delka_modulu = $delka_modulu / 10;

				// budu prochazet jednotlive moduly smerem od spodu nahoru a pokud narazim na prazdny modul, zariznu krytinu
				// parametry potrebne pro vypocet delek modulu

				//    $xmin , $xmax / $ymin , $ymax
				//    $delka_modulu
				//    $kryci_sirka_krytiny
				//    $modulu na vysku a pocet pasu musim dopocitat ze znamych hodnot

				// 1. budu projizdet jednotlive ctverce a kontrolovat barvu pozadi. Pokud ji najdu, nastavim zacatek modulu

				//$startx = $x_off_left+$xmin;
				//$starty = $y_obr - ($ymin + $y_off);

				$p = 0;
				$m = 0;
				$d = 0;	// delka v modulech

				$arr_prvni_optimalizace[] = "";
				$data = "";

				// kladeni z leva pro modulovaci krytiny
				if ($smer_kladeni == 0 && $modulovani == 1){
					
					$kladeni_offset = 0;
					//$q1 = "update `$tab_objekty_index` set `kladeni_offset`='$kladeni_offset' where `id`='$rozmery'";
					//PROVEST ($q1);

					for ($p = 0; $p < $opt_pasu; $p++){
						for ($m = 0; $m < $opt_modulu; $m++){

							$startx = $x_off_left+$xmin + $manual_offset + (($p * $opt_krytina) / $POMER);
							$starty = $y_obr - ($ymin + $y_off) - $zadek_delka -($m * ($opt_delka_modulu/$POMER));
							$endx = $startx + $manual_offset + ($opt_krytina / $POMER);
							$endy = $starty - $zadek_delka -($opt_delka_modulu / $POMER);

							// test na obsazenost jednotlivych pixelu.
							// projedu cely prostor modulu a pokud nenajdu pixel plochy, nebudu modul pouzivat

							$celepole = ($startx-$endx) * ($endy - $starty);
							$pixelu = SPOCITEJ_PROSTOR($image, $startx, $starty, $endx, $endy,$smer_kladeni,$kladeni_offset);

							$pomer_ploch = $celepole / $pixelu;		// pomer kontrolovanych ploch

							if ($pixelu != 0 && $pomer_ploch < $tolerance_ztraty){
								$data = $data. "1";
								$d++;
							} else {
								// rozseknu plech, protoze jsem nasel prazdnou plochu
								$data = $data. "0";
								$d = 0;
							}
						}
						// v prvni optimalizaci jsou v poli 0 a 1 -- modul je ... neni
						$arr_prvni_optimalizace[] = $data;
						$data = "";
					}
				}

				// optimalizace pro smer kladeni z prava pro modul. krytiny
				if ($smer_kladeni == 1 && $modulovani == 1){
					
					$kladeni_offset = $xmax - ($opt_pasu * ($kryci_sirka_krytiny*100));
					$q1 = "update `$tab_objekty_index` set `kladeni_offset`='$kladeni_offset' where `id`='$rozmery'";
					PROVEST ($q1);

					for ($p = $opt_pasu; $p >= 0; $p--){
						for ($m = 0; $m < $opt_modulu; $m++){

							$startx = (($xmax/$POMER)+$x_off_left) - (($p * ($kryci_sirka_krytiny*100))/$POMER);
							$starty = $y_obr - ($ymin + $y_off) - ($m * ($opt_delka_modulu/$POMER));
							$endx = $startx+($opt_krytina / $POMER);
							$endy = $starty- ($opt_delka_modulu / $POMER);

							// test na obsazenost jednotlivych pixelu.
							// projedu cely prostor modulu a pokud nenajdu pixel plochy, nebudu modul pouzivat

							$celepole = ($startx-$endx) * ($endy - $starty);
							$pixelu = SPOCITEJ_PROSTOR($image, $startx, $starty, $endx, $endy,$smer_kladeni);

							$pomer_ploch = $celepole / $pixelu;		// pomer kontrolovanych ploch

							if ($pixelu != 0 && $pomer_ploch < $tolerance_ztraty){
								$data = $data. "1";
								$d++;
							} else {
								// rozseknu plech, protoze jsem nasel prazdnou plochu
								$data = $data. "0";
								$d = 0;
							}
						}
						// v prvni optimalizaci jsou v poli 0 a 1 -- modul je ... neni
						$arr_prvni_optimalizace[] = $data;
						$data = "";
					}
				}

				// ------------------------------------------------------------------------------------------------------------------------
				// optimalizace nemodulovych veci zleva
				// ------------------------------------------------------------------------------------------------------------------------

				if ($smer_kladeni == 0 && $modulovani == 0){
					$delitel_modulu = $_POST['delkamodulu'];	// pocet modulu, po kterem se maji vsechny pasy delit
					$kladeni_offset = 0;
					$q1 = "update `$tab_objekty_index` set `kladeni_offset`='$kladeni_offset' where `id`='$rozmery'";
					PROVEST ($q1);

					for ($p = 0; $p < $opt_pasu; $p++){
						
						$startx = $x_off_left + (($xmin + @$modul_offset)/$POMER) + (($p * $opt_krytina) / $POMER);
						$starty = $y_obr - (($ymin/$POMER) + $y_off);
						
						// zoptimalizuje a zrovna ulozi do databaze !
						// kontrola probiha od vrchu dolu !! - proto zacatek Y je YMAX

						SPOCITEJ_DELKU($image,$startx,$starty,$smer_kladeni,$p,$kladeni_offset);
					}
				}
			
			// die;
				// ------------------------------------------------------------------------------------------------------------------------
				// optimalizace nemodulovych ,kladeni z prava
				// ------------------------------------------------------------------------------------------------------------------------

				if ($smer_kladeni == 1 && $modulovani == 0){
					$kladeni_offset = ((($xmax-$xmin)/$POMER)) - (($opt_pasu * ($kryci_sirka_krytiny*100))/$POMER);
					$q1 = "update `$tab_objekty_index` set `kladeni_offset`='$kladeni_offset' where `id`='$rozmery'";
					PROVEST ($q1);

					$delitel_modulu = $_POST['delkamodulu'];	// pocet modulu, po kterem se maji vsechny pasy delit
										
					for ($p = 0; $p < $opt_pasu; $p++){
						
							$startx = $x_off_left + $xmin + (($p * $opt_krytina) / $POMER);
							$starty = $y_obr - ($ymin + $y_off) - ($m * ($opt_delka_modulu/$POMER));
							// zoptimalizuje a zrovna ulozi do databaze !
							// kontrola probiha od vrchu dolu !! - proto zacatek Y je YMAX
							SPOCITEJ_DELKU($image,$startx,$starty,$smer_kladeni,$p,$kladeni_offset);
					}
				}
				// ------------------------------------------------------------------------------------------------------------------------


			if ($modulovani == 1){
					// ulozim datovou mapu do dbase
					PROVEST ("update `$tab_objekty_index` set `data`= '".$arr_prvni_optimalizace."' where `id`='$rozmery'");

					$pocet = 0;
					$delitel_modulu = $_POST['pmodulu'];	// pocet modulu, po kterem se maji vsechny pasy delit
					if ($delitel_modulu == "") $delitel_modulu = $optimalizace_modul;
					if ($delitel_modulu == 0) $delitel_modulu = 10;

					$k = 0;

					for ($p = 1; $p <= $opt_pasu; $p++){
							$txt =  $arr_prvni_optimalizace[$p];	// do txt dostanu jeden sloupec cisel 1 a 0
							$pocetmodulu = strlen($txt);

							$a = "1";
							$b = "1";
							$c = 0;
							$arr_pasy[] = "";

							for ($i = 0; $i < $pocetmodulu; $i++){
								$a = substr($txt, $i, 1);
								$b = substr($txt, $i+1, 1);

								if ($a == '1' && $b == '1')$c++;

								// narazil jsem nahore na prazdny modul
								if ($a == '1' && $b == '0'){
									$c++;
									$sql = "insert into `$tab_objekty_pasy` (`doklad`,`id2`,`plocha_id`,`pas`,`modul_start`,`pocet_modulu`,`smer_kladeni`,`delka_modulu`,`zadek`,`kryci_sirka`,`celkova_sirka`,`krytina`) values ('$doklad','$k','$rozmery','$p','".($i-$c+1)."','".($c)."','$smer_kladeni','$delka_modulu','$prodlouzeni_min','$kryci_sirka_krytiny','$celkova_sirka_krytiny','$typ_krytiny')";
									//echo "<br>".$sql."<br>";
									PROVEST ($sql);
									$c = 0;
									$k++;
								}

								// narazil jsem na maximalni delku modulu
								if ($c == $delitel_modulu){
									$sql = "insert into `$tab_objekty_pasy` (`doklad`,`id2`,`plocha_id`,`pas`,`modul_start`,`pocet_modulu`,`smer_kladeni`,`delka_modulu`,`zadek`,`kryci_sirka`,`celkova_sirka`,`krytina`) values ('$doklad','$k','$rozmery','$p','".($i-$delitel_modulu+1)."','".($c)."','$smer_kladeni','$delka_modulu','$prodlouzeni_min','$kryci_sirka_krytiny','$celkova_sirka_krytiny','$typ_krytiny')";
									//echo "<br>".$sql."<br>";
									PROVEST ($sql);
									$c = 0;
									$k++;
								}
							}
					}
			}

}

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// konec optimalizace
// pokud neni nutna optimalizace, vykresli se pouze obrazek z disku
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// vykresli mrizku pro modul krytiny
	if ($modulovani == 1){

		$modul = $delka_modulu / 10;		// delka modulu na centimetry
		$maxmodulu = Round($ymax / $modul);	// zaokrouhli pocet modulu nahoru

		$kryci_sirka_krytiny = $kryci_sirka_krytiny * 100;
		$pasu = Ceil(($xmax-$xmin) / $kryci_sirka_krytiny);
		$delitel_modulu = @$_POST['pmodulu'];	// pocet modulu, po kterem se maji vsechny pasy delit
		$delkacary_y = ($y_obr - $y_off) - (($maxmodulu * $modul)/ $POMER) ;
		$krytina_cary = explode(",",$krytina_cary);

		// mrizka pro kladeni zleva
		if ($smer_kladeni == 0){
			// vykresleni X - souradnic

			for  ($i = 0 ; $i < ($pasu+1); $i++) {
				$nx = ($xmin+($i * $kryci_sirka_krytiny))/$POMER;
				$nx = $nx + $x_off_left;
				Imageline($image, $nx+$manual_offset, ($y_obr - $y_off - ($ymin/$POMER)), $nx+$manual_offset, $delkacary_y, $barva_rastr);

				// pokud ma krytina i podcary (rozdeleni na moduly) , vykreslim je
				if ($pomocnecary == '1' && count($krytina_cary) > 0){
					for  ($ii = 0 ; $ii < count($krytina_cary); $ii++) {
						$posun = $krytina_cary[$ii] / 10 / $POMER;
						$nx2 = $nx + $posun;
						Imageline($image, $nx2+$manual_offset, ($y_obr - $y_off - ($ymin/$POMER)), $nx2+$manual_offset, $delkacary_y, $barva_rastr);
					}
				}
			}


			// vykresleni Y - souradnic
			$delkacary_x = $x_off_left + ($xmin/$POMER) + ($pasu * $kryci_sirka_krytiny)/ $POMER;

			for  ($i = 0 ; $i <= $maxmodulu; $i++) {
				$ny = ($y_obr - ($ymin/$POMER) - $y_off) - (($i * $modul)/$POMER);
				Imageline($image, $x_off_left+$manual_offset+($xmin/$POMER), $ny, $delkacary_x+$manual_offset, $ny, $barva_rastr);
			}
		}



		// mrizka pro kladeni zprava
		if ($smer_kladeni == 1){
			// vykresleni X - souradnic
			for  ($i = 1 ; $i < ($pasu+1); $i++) {
				$nx = $x_off_left+($xmax/$POMER) -($i * $kryci_sirka_krytiny)/$POMER;
				Imageline($image, $nx, ($y_obr - $y_off), $nx, $delkacary_y, $barva_rastr);
					// pokud ma krytina i podcary (rozdeleni na moduly) , vykreslim je
					if ($pomocnecary == '1' && count($krytina_cary) > 0){
						for  ($ii = 0 ; $ii < count($krytina_cary); $ii++) {
							$posun = $krytina_cary[$ii] / 10 / $POMER;
							$nx2 = $nx + $posun;
							Imageline($image, $nx2, ($y_obr - $y_off - ($ymin/$POMER)), $nx2, $delkacary_y, $barva_rastr);
						}
					}
			}



			// vykresleni Y - souradnic
			$delkacary_x = ($xmax/$POMER)+$x_off_left;
			$caraxstart = (($xmax/$POMER)+$x_off_left) - (($pasu * $kryci_sirka_krytiny)/$POMER);

			for  ($i = 0 ; $i <= $maxmodulu; $i++) {
				$ny = ($y_obr - $y_off) - (($i * $modul)/$POMER);
				Imageline($image, $caraxstart, $ny, $delkacary_x, $ny, $barva_rastr);
			}

		}

		// vykresleni existujicich pasu z databaze
		$sql = "select * from `$tab_objekty_pasy` where `plocha_id`='$rozmery' AND vazba = 0";
		$res = PROVEST ($sql);

		while ($row = mysql_fetch_array($res)){
			$idpas = $row['id'];
			$id = $row['id2'];
			$pas = $row['pas'];
			$strih = $row['strih'];
			$modul_start = $row['modul_start'];
			$pocet_modulu = $row['pocet_modulu'];
			$smer_kladeni = $row['smer_kladeni'];
			$delka_modulu = $row['delka_modulu'];
			$zadek = $row['zadek'];
			$kryci_sirka = $row['kryci_sirka'];
			$vyber = $row['vyber'];
			$strihvlozen = $row['strihvlozen'];

			VYKRESLI_MODUL ($image,$pas,$modul_start,$pocet_modulu,$smer_kladeni,$delka_modulu,$zadek,$kryci_sirka,$id,$vyber,$kladeni_offset,$strih,$idpas,$strihvlozen);
		}
	}


// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// vykresli mrizku pro nemodulove
	if ($modulovani == 0){
		$kryci_sirka_krytiny = $kryci_sirka_krytiny * 100;
		$pasu = Ceil(($xmax-$xmin) / $kryci_sirka_krytiny);
		$delkacary_y = ($y_obr - $y_off - ($ymax/$POMER));
		// mrizka pro kladeni zleva
		if ($smer_kladeni == 0){
			// vykresleni X - souradnic
			for  ($i = 0 ; $i <= $pasu; $i++) {
				$nx = $x_off_left+($xmin/$POMER)+($i * $kryci_sirka_krytiny)/$POMER;
				Imageline($image, $nx + $manual_offset, ($y_obr - $y_off), $nx + $manual_offset, $delkacary_y, $barva_rastr);
			}
		}

		// mrizka pro kladeni zprava
		if ($smer_kladeni == 1){
			// vykresleni X - souradnic
			for  ($i = 0 ; $i <= $pasu; $i++) {
				$nx = $x_off_left+($xmax/$POMER) -($i * $kryci_sirka_krytiny)/$POMER;
				Imageline($image, $nx + $manual_offset, ($y_obr - $y_off), $nx + $manual_offset, $delkacary_y, $barva_rastr);
			}
		}

		// vykresleni existujicich pasu z databaze
		$sql = "select * from `$tab_objekty_pasy` where `plocha_id`='$rozmery'";
		$res = PROVEST ($sql);

		while ($row = mysql_fetch_array($res)){
			$id = $row['id2'];
			$pas = $row['pas'];
			$nemodul_ystart = $row['nemodul_ystart'];
			$pocet_modulu = $row['pocet_modulu'];
			$smer_kladeni = $row['smer_kladeni'];
			$delka_modulu = $row['delka_modulu'];
			$zadek = $row['zadek'];
			$kryci_sirka = $row['kryci_sirka'];
			$vyber = $row['vyber'];

			VYKRESLI_NEMODUL ($image,$pas,$nemodul_ystart,$smer_kladeni,$delka_modulu,$zadek,$kryci_sirka,$id,$vyber);
		}
	}
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// nakresli snehove tasky, pokud je potreba

	// tabulka kladeni tasek v polich
	$arr_uhel_min = array (00,25,30,35,40,45,50);
	$arr_uhel_max = array (24,29,34,39,44,49,90);
	$arr_roztec = array("6666665","6666554","6655444","5554444","5544433","4444433","444333X","43333XX");
	$arr_zpusob = array("aaaaaab","aaaaaab","aaaabbc","aaaabcc","aaabbcc","aabbccc","aabbccX","aabbcXX");

	$poletasek = "";
	$pocettasek = 0;
	$pocetrad = Ceil($ymax / ($delka_modulu/10));

	// do pocatecnich dat si ulozim xmax, ymax a pomer !
	$poletasek = ($x_obr/$xmax).",".($y_obr/$ymax).",".$POMER.";";

	for ($i = 0; $i < count($arr_uhel_min); $i++){
		$min = $arr_uhel_min[$i];
		$max = $arr_uhel_max[$i];

		if ($snehovyuhel >= $min &&  $snehovyuhel <= $max){
			$nasel = $i;
		}
	}

	// nactu zpusob a roztec a podle snehove oblasti zvolim zpusob kryti
	$z = $arr_zpusob [$nasel];
	$r = $arr_roztec [$nasel];
	$rad = 0;
	$meziady = 0;
	$arr_rady = "";	// budu uchovavat roztece rad

	$so = $snehovaoblast - 1;

	$zpusob = substr($z,$so,1);
	$roztec = substr($r,$so,1);
	$prvnirada = 1;								// mozno posouvat
	$pocetmodulu = floor($ymax / ($delka_modulu/10) - 3);

	// vypocitam toleranci pro rozmistneni rad.
	$tolerance = (($ymax/100) / $roztec) - floor(($ymax/100) / $roztec);	// vypocitam zbytek , desetinne misto po deleni

	if ($tolerance < 0.5) $rad = floor(($ymax/100) / $roztec);
	if ($tolerance > 0.5) $rad = ceil(($ymax/100) / $roztec);

	$mezi = ceil(($pocetmodulu-$prvnirada) / $rad);
	$rad--;

	if ($zobraztasky == 1){
		
		switch ($zpusob){

			case "a":
				$rada = $prvnirada;	// $rada = rada na ktere se bude kreslit
				$interval = 4;	// odsazeni jednotlivych tasek v rade
				$roztec = DOTAZ2('module_roof_nastavenikrytin','roztecvln','id',$typ_krytiny);
				$od = explode(',',DOTAZ2('module_roof_nastavenikrytin','pomocnecary','id',$typ_krytiny));
				$odsazeni = $od[0];	// odsazeni krytiny ( prvni hodnota v tabulce pomocnych car - kvuli presnemu vykresleni)
				$odskok = 0;	// odskok pro lichou radu snehovych tasek
				RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
				$rada = $prvnirada+1;	// $rada = rada na ktere se bude kreslit
				$odskok = 2;	// odskok pro lichou radu snehovych tasek
				RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);

				for ($i = 0; $i < $rad; $i++){
					$rada = $prvnirada+$mezi+1+$i;	// $rada = rada na ktere se bude kreslit
					$odskok = 0;	// odskok pro lichou radu snehovych tasek
					RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
					$rada = $prvnirada+$mezi+2+$i;	// $rada = rada na ktere se bude kreslit
					$odskok = 2;	// odskok pro lichou radu snehovych tasek
					RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
					$mezi = $mezi + $mezi;
				}

				break;

			case "b":
				$rada = $prvnirada;	// $rada = rada na ktere se bude kreslit
				$interval = 2;	// odsazeni jednotlivych tasek v rade
				$roztec = DOTAZ2('module_roof_nastavenikrytin','roztecvln','id',$typ_krytiny);
				$od = explode(',',DOTAZ2('module_roof_nastavenikrytin','pomocnecary','id',$typ_krytiny));
				$odsazeni = $od[0];	// odsazeni krytiny ( prvni hodnota v tabulce pomocnych car - kvuli presnemu vykresleni)
				$odskok = 0;	// odskok pro lichou radu snehovych tasek
				RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
				$rada = $prvnirada+1;	// $rada = rada na ktere se bude kreslit
				$odskok = 1;	// odskok pro lichou radu snehovych tasek
				RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);

				for ($i = 0; $i < $rad; $i++){
					$rada = $prvnirada+$mezi+1+$i;	// $rada = rada na ktere se bude kreslit
					$odskok = 0;	// odskok pro lichou radu snehovych tasek
					RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
					$rada = $prvnirada+$mezi+2+$i;	// $rada = rada na ktere se bude kreslit
					$odskok = 1;	// odskok pro lichou radu snehovych tasek
					RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
					$mezi = $mezi + $mezi;
				}

				break;

			case "c":
				$rada = $prvnirada;	// $rada = rada na ktere se bude kreslit
				$interval = 2;	// odsazeni jednotlivych tasek v rade
				$roztec = DOTAZ2('module_roof_nastavenikrytin','roztecvln','id',$typ_krytiny);
				$od = explode(',',DOTAZ2('module_roof_nastavenikrytin','pomocnecary','id',$typ_krytiny));
				$odsazeni = $od[0];	// odsazeni krytiny ( prvni hodnota v tabulce pomocnych car - kvuli presnemu vykresleni)
				$odskok = 0;	// odskok pro lichou radu snehovych tasek
				RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
				$rada = $prvnirada+1;	// $rada = rada na ktere se bude kreslit
				$odskok = 1;	// odskok pro lichou radu snehovych tasek
				RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
				$rada = $prvnirada+2;	// $rada = rada na ktere se bude kreslit
				$odskok = 0;	// odskok pro lichou radu snehovych tasek
				RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);

				for ($i = 0; $i < $rad; $i++){
					$rada = $prvnirada+$mezi+($i*2)+$i+3;	// $rada = rada na ktere se bude kreslit
					$odskok = 0;	// odskok pro lichou radu snehovych tasek
					RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
					$rada = $prvnirada+$mezi+($i*2)+$i+4;	// $rada = rada na ktere se bude kreslit
					$odskok = 1;	// odskok pro lichou radu snehovych tasek
					RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
					$rada = $prvnirada+$mezi+($i*2)+$i+5;	// $rada = rada na ktere se bude kreslit
					$odskok = 0;	// odskok pro lichou radu snehovych tasek
					RADA_TASEK ($image,$rada,$interval,$roztec,$odsazeni,$odskok);
					$mezi = $mezi + $mezi;
				}

				break;
		}
	}

	// zapise pocet tasek do db
	PROVEST ("update `$tab_objekty_index` set `pocetsnehovychtasek`='$pocettasek',`taskypole`='$poletasek' where `id`='$rozmery'");
	// zapise pocet tasek do obrazku


	if ($zobraztasky == 1) $tx = priprava(", ".G_STRECHY_SNEHTASEK." : $pocettasek ".G_KS."");
	if ($zobraztasky == 0) $tx = priprava(", ".G_STRECHY_BEZSNEHTASEK."");
	if ($modulovani == 0) $tx = "";


	//ImageTTFText ($image, 20,0, $x_off_left+10, 60, $barva_cerna, FONT, $tx);

	// nakresli obrys zakladniho tvaru

	$okrajplochy = array (IMG_COLOR_TRANSPARENT, IMG_COLOR_TRANSPARENT, $barva_obrysu, $barva_obrysu,IMG_COLOR_TRANSPARENT,IMG_COLOR_TRANSPARENT,$barva_obrysu,$barva_obrysu);
	imagesetstyle($image, $okrajplochy);
	imagepolygon($image, $body, $pocetbodupulka, IMG_COLOR_STYLED);


		// nakresli podplochy
		if (count($arr_plochy) > 0){
			foreach ($arr_plochy as $arr_plocha){
				$pocet2 = count($arr_plocha)/2;
				$body2 = prepoctibody_podplocha($arr_plocha);
					
					if ($pocet2 > 3) imagepolygon($image,$body2, $pocet2, IMG_COLOR_STYLED);
			}
		}

   	// 4. vykresli na vrcholy popis bodu
	if ($optimalizace != "ano") {
		for ($i = 0 ; $i < $pocetbodu; $i++){
			imagefilledellipse($image, $body[$i], $body[$i+1], $prumerpopisek, $prumerpopisek, $barva_body);		// vykresli infobublinu pro popis bodu
			imageellipse($image, $body[$i], $body[$i+1], $prumerpopisek, $prumerpopisek, $barva_cerna);				// vykresli infobublinu pro popis bodu
			imagestring ($image, 2, $body[$i]-2, $body[$i+1]-6, ($i/2)+1, $barva_cerna);
			$i++;
		}
	}

	// vykresli delky stran
	// if ($optimalizace != "ano") {
		for ($i = 0 ; $i < $pocetbodu; $i+=2){
			// vykresli rozmery jednotlivych car
			$x1 = $body[$i];
			$y1 = $body[$i+1];
			$x2 = $body[$i+2];
			$y2 = $body[$i+3];
			$idb = $bodyid[$i];

			// pokud jsem na poslednim bodu, tak pro porovnani si vezmu prvni a druhy bod z pole
			if ($body[$i+2] == ""){
				$x2 = $body[0];
				$y2 = $body[1];
			}
			ukaz_delku($image,$barva_delka,$x1,$y1,$x2,$y2,$idb);
		}
		
	// }

	   // 5. vykresleni informacnich textu

		$txt = priprava($txt_nazev).$tx;
			
		$sql = "update `$tab_objekty_index` set `info`='$txt' where `id`='$rozmery'";
		PROVEST ($sql);

		//ImageTTFText ($image, 20,0, $x_off_left+10, $y_obr-22 , $barva_cerna, FONT, $txt);

		TEST_CAD($doklad);
		$rok_doklad = ROK($doklad);	// pokud neni adresar, vytvori jej a vrati hodnotu roku nabidky
		
		imagepng($image,"../".$_SESSION['db_klient']."/cad/".$rok_doklad."/".$doklad."/".$doklad."_".$rozmery.".png");              
		imagedestroy($image);
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$rozmery&infotext=$infotext&tolerance=$tolerance_ztraty");
		}


	// prida zaznam do seznamu ploch
	if (@$_GET['fc'] == "pridat"){
		$sql = "insert into `$tab_objekty_index` (`doklad`,`modulovani`) values ('$doklad','1')";
		PROVEST ($sql);
		$posledni = mysql_insert_id();
		
		// zalozim v tabulce hran plochu pro osazeni skladby
		
		$sql = "insert into `$tab_objekty_polozky` 
		(`doklad`,`plocha`,`id2`,`index`,`x`,`y`,`data_odkaz`) values 
		('$doklad','$posledni','1','$posledni',0,0,0)";
		PROVEST ($sql);
		
		
		//skok na editaci nastaveni plochy
		header ("location:system_strechy.php?doklad=$doklad&plochaconfig=$posledni&focus=plochanazev");
		die;
	}

// --------------------------------------------------------------------------------------------------------
// update konfigurace plochy
// --------------------------------------------------------------------------------------------------------

if (@$_POST['plochanazev'] != ""){
	
	$id = 				$_POST['id'];
	$nazev = 			$_POST['plochanazev'];
	$krytina = 			$_POST['krytina'];
	$rodic = 			$_POST['rodic'];
	$barva = 			$_POST['barvaPlochy'];
	
	// ulozenou barvu nacpu do session, abych pri dalsi plose nabidl jiz zvolenou
	
	if (!isset($_SESSION['barvaPlochy'])) $_SESSION['barvaPlochy'] = $barva;
	
	$smer = 			0;
	$doklad = 			$_GET['doklad'];
	$uhel = 			$_POST['uhel'];
	$rozmery = 			$_GET['plochaconfig'];
	$modulovani = 		DOTAZ2 ('module_roof_nastavenikrytin','modulova','id',$krytina);
	$stara_krytina = 	DOTAZ($tab_objekty_index,'krytina','id',$rozmery);
	$stary_uhel = 		DOTAZ($tab_objekty_index,'uhel','id',$rozmery);
	$kryci_sirka = 		VZOREC($_POST['nova_kryci']);
	$celkova_sirka = 	VZOREC($_POST['nova_celkova']);
	
	$sql = "update `$tab_objekty_index` set `nazev`='$nazev',`krytina`='$krytina',`barva`='$barva',`rodic`='$rodic',`smer_kladeni`='$smer',`uhel`='$uhel',`modulovani`='$modulovani',`kryciSirka`='$kryci_sirka',`celkovaSirka`='$celkova_sirka',`manual_offset`='0' where `id`='$id'";
	PROVEST ($sql);

// pokud se zmeni krytina, smaze se optimalizace

	if (($stara_krytina != $krytina) || ($stary_uhel != $uhel)){
		$s = "delete from `$tab_objekty_pasy` where `doklad`='$doklad' AND `plocha_id`='$rozmery'";
		PROVEST ($s);
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$id&akce=prepocitat&updatem2=1&infotext=".G_STRECHY_OPTSMAZANA);
		die;
	}

	if ($stara_krytina == $krytina){
		header ("location:system_strechy.php?doklad=$doklad&rozmery=$id&akce=prepocitat&updatem2=1");
		die;
	}
		
}

// smazat body v plose

if (GET(@$_GET['smazbody']) != ""){
	$id = $_GET['smazbody'];
	// smaze zaznam v index table
	$sql = "delete from `$tab_objekty_polozky` where `index`='$id'";
	PROVEST ($sql);

	// smaze zaznamy v zaznamu ploch a pasu
	$sql = "delete from `$tab_objekty_pasy` where `plocha_id`='$id'";
	PROVEST ($sql);

	// updavi meritko na 1
	$sql = "update  `$tab_objekty_index` set `meritko`='1',`plocham2`='0' where `id`='$id'";
	PROVEST ($sql);
	
	header ("location:system_strechy.php?doklad=$doklad&rozmery=".$id."&akce=prepocitat");
	die;
}


// smazat zaznam

if (GET(@$_GET['smazplochu']) != ""){
	
	$id = $_GET['smazplochu'];
	
	// smaze zaznam v index table
	
	$sql = "delete from `$tab_objekty_index` where `id`='$id'";
	PROVEST ($sql);

	// smaze zaznamy v zaznamu bodu
	
	$sql = "delete from `$tab_objekty_polozky` where `index`='$id'";
	PROVEST ($sql);

	// smaze zaznamy v zaznamu ploch a pasu
	
	$sql = "delete from `$tab_objekty_pasy` where `plocha_id`='$id'";
	PROVEST ($sql);

	header ("location:system_strechy.php?doklad=$doklad");
	die;
}

nactibody();
max_body();

HTMLBODY (GET(@$_GET['infotext']),"","");


?>

<script>
	var string = "<a href='system_strechy.php?doklad=<?=$doklad?>&editor=skladacka' target='mainframe'><? echo ICON_ZKRATKA;?></a>";
	parent.menuframe.document.getElementById("nabidka_zkratka").innerHTML = string;
	var noScreen = 1;
</script>

<script type="text/javascript" language="JavaScript"><!--

function pridatbodik(){

	var input = document.createElement("input");
	input.setAttribute("type", "hidden");
	input.setAttribute("name", "fc");
	input.setAttribute("value", "pridatbod");

	document.getElementById("f1_vstupbodu").appendChild(input)
	document.forms["f1_vstupbodu"].submit();
}

function testConfig(){

	var x = document.getElementById("nastaveniKrytina").selectedIndex;
	
	if (x == 0 || $b == 0){
		alert ("<? echo G_SKLADPRVNIRADEK;?>");
		return false;
	} else {
		return true;
	}
}


function vyberRozmery(){
	var x=document.getElementById("nastaveniKrytina").selectedIndex;
	var y = document.getElementById("nastaveniKrytina").options;
	var data = y[x].value;

	$.get('system_strechy_rozmery.php?co=kryci&id='+data, function(resultdata){
		var a = parseFloat(resultdata);
		$('#novaKryci').val(a);
	});

	$.get('system_strechy_rozmery.php?co=celkova&id='+data, function(resultdata){
		var a = parseFloat(resultdata);
		$('#novaCelkova').val(a);
	});
}

function osax(x){
	var pomer 		= parseFloat(<?echo $POMER + $vnitrniPomer; ?>);
	var xoff 		= parseInt("<? echo $x_off_left;?>");
	var yoff 		= parseInt("<? echo $y_off;?>");
	var sirkaLevo 	= parseInt("<? echo $sirkaLevo;?>");
	var novex 		= (x * 100 / pomer) + xoff + sirkaLevo + 8;
	var input		= "<? echo $_SESSION['unit'];?>";
	var output		= "<? echo $_SESSION['unitFormat'];?>";
	//var noveXcislo	= UNIT(novex,input,output)
	var noveXcislo	= novex;
	
	document.getElementById("osa_svisla").style.left = noveXcislo;
	document.getElementById("osa_svisla").style.visibility = "visible";
}

function osay(yForm){
	var pomer 		= parseFloat(<?echo $POMER + $vnitrniPomer; ?>);
	var yoff 		= parseInt("<? echo $y_off;?>");
	var y 			= parseInt(yForm * 100) / pomer;
	var sirkaLevo 	= parseInt("<? echo $sirkaLevo;?>");
	var vyska 		= parseInt("<? echo $y_obr;?>") + yoff + 100;
	var novey 		= parseInt(vyska - y);
	var input		= "<? echo $_SESSION['unit'];?>";
	var output		= "<? echo $_SESSION['unitFormat'];?>";
	// var noveYcislo	= UNIT(novey,input,output)
	var noveYcislo	= novey;
	
	document.getElementById("osa_vodorovna").style.top = noveYcislo;
	document.getElementById("osa_vodorovna").style.visibility = "visible";
}

xmin =  "<?echo $xmin; ?>";
ymin =  "<?echo $ymin; ?>";

$(document).ready(function() {
	
	$( "#rodicTest" ).change(function () {
		var x=document.getElementById("rodicTest").selectedIndex;
		var y = document.getElementById("rodicTest").options;
		var data = y[x].value;
		
		$.get('system_strechy_krytina.php?id='+data, function(resultdata){
			var element = document.getElementById('nastaveniKrytina');
			element.value = parseInt(resultdata);
			vyberRozmery();
			
			if (element.value != 0){

				// vlozi input pole do schovaneho DIV

				$("#hiddenInput").empty();
				$("#hiddenInput").append("<input type='text' name='krytina' value='"+element.value+"' class=destroyHidden>");
				$('#nastaveniKrytina').attr("disabled", true);
				$('#novaKryci').attr("disabled", true);
				$('#novaCelkova').attr("disabled", true);
			} else {
				$("#destroyHidden").remove();
				$('#nastaveniKrytina').attr("disabled", false);
				$('#novaKryci').attr("disabled", false);
				$('#novaCelkova').attr("disabled", false);
				
			}
		});
	});
	
});

// -->

</script>

<style>
	BODY {padding: 0px;margin: 0px;}
	IMG {padding: 0px; margin: 0px;}
	.ruka { color: white;}
	A.ikona {float: left; padding-top: 4px;}

#box1 input {text-align: right;}

#kresleni {
	position: absolute;
	left: 10px; top: 100px;
	width: <? echo $x_obr;?>px; height: <? echo $y_obr;?>px;
	}

#osa_svisla {
	position: absolute;
	left: 30px;
	top: 100px;
	width: 1px;
	height: 0px;
	background-image : url('grafika/cad/osa_svisla.gif');
	background-repeat:repeat-y;
	visibility: hidden;
	z-index: 20;
	}

#popisek {
	position: absolute;
	width: 130px;
	height: 30px;
	color: #333333;
	visibility: visible;
	z-index: 20;
	}

#osa_vodorovna {
	position: absolute;
	left: 313px;
	top: 0px;
	width: 100%;
	height: 1px;
	background-image : url('grafika/cad/osa_vodorovna.gif');
	background-repeat:repeat-x;
	visibility: hidden;
	z-index: 20;
	}

#infotext {
	position: absolute;
	top: 40px;
	left: 10px;
	padding: 5px;
	width: 1060px;
	height: 40px;
	z-index: 100;
	font-size: 16px;
	background-color: #ffffff;
	}

</style>

<?

if (@$_GET['editor'] == "" && @$_GET['plochaconfig'] == ""){
	// zobrazi plovouci klikaci divy kvuli editaci jednotlivych car

	$sql = "select * from `$tab_objekty_polozky` where `index`='$rozmery' AND `id2` != '1'";
	$res = PROVEST ($sql);

	while ($row = mysql_fetch_array($res)){
		$iddiv = $row['id'];
		$dt = $row['data_odkaz'];
		$a = explode ('*', $dt);
		$delka = $a[0];
		
		$x_div = ($a[1]+$x_off_left+200+30)."px";
		$y_div = ($a[2]+25+$y_off)."px";
		
		$skupina = $row['data_skupina'];
		$ikona = $row['ikona'];
		if ($ikona == "") $ikona='zadna.png';
		echo "<div id='plovouci_$iddiv' style='position: absolute; left :".$x_div."; top:".$y_div."; width: 20px; height: 20px; z-index: 101;'><a href='system_strechy_polozky.php?id2=0&rozmery=$rozmery&doklad=$doklad&delkastrany=$delka&krok=1&skupina=$skupina&cara=$iddiv&ikona=$ikona'  onclick=\"return hs.htmlExpand(this, { objectType: 'iframe', width: 700, height: 500, headingText: '".G_STRPOL_TITLE."', align: 'center'} )\"><img src='grafika/cad/skupiny/$ikona'></a></div>";
	}

	$sql = "select * from `$tab_objekty_polozky` where `index`='$rozmery' AND `id2` = '1'";
	$res = PROVEST ($sql);
	$row = mysql_fetch_array($res);

		// zobrazim ikonu pro osazeni plochy skladbou :)
		$x_div = (50+$x_off_left+200+30)."px";
		$y_div = (50+25+$y_off)."px";
		$iddiv = $row['id'];
		$delka = $row['data_odkaz'];

		$skupina = $row['data_skupina'];
		$ikona = $row['ikona'];
		if ($ikona == "") $ikona='zadna.png';
		
		echo "<div id='plovouci_$iddiv' style='position: absolute; left :".$x_div."; top:".$y_div."; width: 20px; height: 20px; z-index: 101;'><a href='system_strechy_polozky.php?id2=1&rozmery=$rozmery&doklad=$doklad&delkastrany=$delka&krok=1&skupina=$skupina&cara=$iddiv&ikona=$ikona'  onclick=\"return hs.htmlExpand(this, { objectType: 'iframe', width: 600, height: 500, headingText: '".G_STRPOL_TITLE."', align: 'center'} )\"><img src='grafika/cad/skupiny/$ikona'></a></div>";
}


// zobrazi seznam index ploch
$sql = "select * from `$tab_objekty_index` where `doklad` = '$doklad' order by id asc";
$res = PROVEST ($sql);
$pocetPloch = mysql_num_rows($res);

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// ----------  																	zobrazeni ploch
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	if ($rozmery != "") $stbl = "none";
	if ($rozmery == "") $stbl = "block";
	
	// test dali existuje zdroj data pro daneho vyrobce
	
	$testNaDatasource = "";
	if ($vyrobce_krytina != ""){
		$test = DOTAZ2('module_roof_seznamvyrobcu','databaze','id',$vyrobce_krytina);
		if ($test == "") $testNaDatasource = "<div id='box1' class='pozor stred font14'>".G_STRECHY_NENIZDROJ."</div>";
	}
	
	echo "
	<div id='plochacela' style='background: none; width: ".($x_obr+380)."; height: 100vh;'>
	<div id= 'kontejner_levo' style='position: relative ; width:302px; height: 100vh; background-color: #000000; overflow: auto;'>
		<div id='box1'>
		<div id='vystup' style='display: none;'></div>
		
			<h1 id='m1' class=ruka>".G_STRECHY_TITPROJEKT."</h1>
				<div id='menu001' style='display: ".$stbl.";'>
				<form action='system_strechy.php?doklad=$doklad&zmenabarvakrytina=ano&editor=skladacka' method=post>
				<table width='100%' cellspacing='0' cellpadding='2' border='0' class=strechyTab>
					<tr>
						<th class=zleva width=50>".G_SETKRYTINY_TAB02."</th>
						<td>
						";
						
						$sqlVyr = "select * from `module_roof_seznamvyrobcu` where aktivni=1 order by vyrobce asc";
						$rVyr = PROVEST2 ($sqlVyr);
						echo "<select name='vyrobce' onChange=submit(); style='width: 80px;'>";
						echo "<option value=''>---</option>";
						while ($rVyr2 = mysql_fetch_array($rVyr)){
							echo "<option value='".$rVyr2['id']."' ".TEST($rVyr2['id'],$vyrobce_krytina).">".$rVyr2['vyrobce']."</option>";
						}
						echo "</select>
						";
		
			$s1 = "select * from `module_roof_materialy` where `vyrobce` = '$vyrobce_krytina' order by popisSystem asc";
			$r1 = PROVEST2 ($s1);
				
			echo "
				<select name='material' onChange=submit(); style='width: 140px;'>
					<option value=''>---</option>
			";
			while ($r2 = mysql_fetch_array($r1)) echo "<option value='".$r2['id']."' ".TEST($r2['id'],$material_krytina).">".$r2['popisSystem']."</option>\n";
		
			echo "
					</select>
				</td>
			</tr>
			";

	// $a = "select * from `module_roof_materialy` where `nazev`='$material_krytina' and `vyrobce`='$vyrobce_krytina'";
	// $aa = PROVEST2 ($a);
	// $aaa = mysql_fetch_array($aa);

	echo "
		<tr>
			<th class=zleva>".G_STRECHY_PROJEKTTAB03."</th>
			<td class=zprava>".G_STRECHY_PROJEKTTAB03A." <select name='snehovaoblast' onChange=submit();>
		";

		for ($o = 1; $o <= 8; $o++) echo "<option value='$o' ".TEST($snehovaoblast,$o).">$o</option>";

		echo "
			</select> ".G_STRECHY_PROJEKTTAB03B." <input type='number' name='snehovyuhel' value='".REPOST($snehovyuhel)."' min='0' step='1' max='90' style='width: 60px;'>".G_STUPEN." <a class=boxtlac href='grafika/snehove_oblasti.jpg' class='highslide' onclick=\"return hs.expand(this)\" title='".G_STRECHY_MAPASNIH."'>".G_STRECHY_MAPATITLE."</a></td>
		</tr>
		<tr>
			<th class=zleva>".G_STRECHY_REZIMVYP."</th>
			<td class=zprava>
				<div class='radio'>
					<input type='radio' name='rezimKryti' id='radio1' value='0' ".TESTRADIO ($vypis,0)." onChange=submit();><label for='radio1' style='width: 50%;'>".G_STRECHY_CELKOVA."</label>
					<input type='radio' name='rezimKryti' id='radio2' value='1' ".TESTRADIO ($vypis,1)." onChange=submit();><label for='radio2' style='width: 50%;'>".G_STRECHY_KRYCI."</label>
				</div>
			</td>
		</tr>
	</table>
	<input type='submit' name='odeslat' value='ok' style='display: none;'>
	</form>
	</div>

	$testNaDatasource
	
	
	";

        
        // pokud neni vybrana krytina, nezobrazi se pokrocile menu
        
        if ($material_krytina != ""){
			echo "
			<table width='100%' cellspacing='0' cellpadding='1' border='0' class=strechyTab>
				<tr height=26>
					<th colspan=4>
						<a href='system_strechy.php?fc=pridat&doklad=$doklad' title='".G_STRECHY_MENU01."' ><img src='grafika/cad/cad_plusbod.png' data-dalsi='grafika/cad/cad_plusbod1.png' border='0' class='imageSwap'></a>
						<a href='system_strechy.php?doklad=$doklad&editor=skladacka' title='".G_STRECHY_MENU02INF."' ><img src='grafika/cad/cad_posun.png' data-dalsi='grafika/cad/cad_posun1.png' border='0' class='imageSwap'></a>
						<a href='system_strechy_generovat.php?doklad=$doklad' onclick=\"return hs.htmlExpand(this, { objectType: 'iframe', align: 'center', width: 500, headingText: '".G_STRECHGEN_TITLE."'} )\" title='".G_STRECHY_MENU04INF."'><img src='grafika/cad/generovat.png' data-dalsi='grafika/cad/generovat1.png' border='0' class='imageSwap'></a>
						<a href=javascript:okno(\"tisk_kladeci_plan.php?doklad=$doklad\",".G_X_TISK.",".G_Y_TISK.") title='".G_STRECHY_TISKKLADINF."' ><img src='grafika/cad/tisk.png' data-dalsi='grafika/cad/tisk1.png' border='0' class='imageSwap'></a>
						<a href='system_nabidky_editace.php?co=polozky&id=$doklad' title='".G_STRECHY_DONABIDKY."' ><img src='grafika/cad/zpet.png' data-dalsi='grafika/cad/zpet1.png' border='0' class='imageSwap'></a>
					</td>
				</tr>
			";
						
			$cm = 0;	// celkem metry

			while ($row = mysql_fetch_array($res)){
				
					$id 			= $row['id'];
					$krytina 		= $row['krytina'];
					$rodic 			= $row['rodic'];
					$krytina_nazev 	= DOTAZ2('module_roof_nastavenikrytin','krytina','id',$krytina);
					$vyrobce 		= DOTAZ2('module_roof_nastavenikrytin','vyrobce','id',$krytina);
					$id_krytina 	= DOTAZ2('module_roof_nastavenikrytin','id_krytina','id',$krytina);
					$metrazplochy 	= Round($row['plocham2'],2);
					$mod 			= DOTAZ($tab_objekty_index,'modulovani','id',$id);

					if ($rodic == '0') $kn = " style='font-weight: bold;' ";
					if ($rodic != '0') $kn = " style='font-style:italic;' ";
					
					$aktualniRadek = "style='background-color: none;'";
					if ($rozmery == $row['id']) $aktualniRadek = "style='background-color: #fffde1;'";
					
					echo "
					<tr $aktualniRadek>
						<td class=zleva><a href='system_strechy.php?doklad=".$doklad."&rozmery=".$id."&akce=prepocitat' class='preloader'><span $kn >".$row['nazev']."</span></a></td>
						<td class=zleva>
					";
					
					if ($id_krytina != ""){
						if ($rodic == 0) {
							echo $krytina_nazev." ($id_krytina)";
							$cm = $cm + $metrazplochy;
						}
					} else {
						if ($rodic == 0) {
							echo $krytina_nazev;
							$cm = $cm + $metrazplochy;
						}						
					}
					
					// pokud je plocha dira, odectu plochu
					if ($rodic != 0) {
						echo "----";
						$cm = $cm - $metrazplochy;
					}

					echo "
						</td>
						<td width=55 class=zprava>".UNIT2($metrazplochy,1)." ".jednotka("plocha")."</td>
						<th width=20 class=stred><a href='system_strechy.php?doklad=".$doklad."&plochaconfig=".$id."' title='".G_STRECHY_CONFIGTITLE."'><img src='grafika/cad/config.png' class='imageSwap preloader' data-dalsi='grafika/cad/config1.png'></a></th>
					";
			}

			echo "
				<tr>
					<th colspan=2 class=zleva>".G_STRECHY_MATCELKEM."</th>
					<th class=zprava>".UNIT2($cm,1)." ".jednotka("plocha")."</th>
					<th>&nbsp;</th>
				</tr>
			</table>
			</form>
			";

        } // zobrazeni pokrocileho menu
        
echo 
	"
	</div>
	";

?>
<script>
    $("#m1").click(function () {
      $("#menu001").slideToggle("slow");
    });
</script>
<?

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// configurator plochy
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

if (@$_GET['plochaconfig'] != ""){
	
	$id 					= $_GET['plochaconfig'];
	$sql 					= "select * from `$tab_objekty_index` where doklad = '$doklad' AND `id`='$id'";
	$res 					= PROVEST ($sql);
	$row 					= mysql_fetch_array($res);
	$id 					= $row['id'];
	$krytina 				= $row['krytina'];
	$plochanazev 			= $row['nazev'];
	$rodic 					= $row['rodic'];
	$uhel 					= $row['uhel'];
	$smer 					= $row['smer_kladeni'];
	$barvaPlochy			= $row['barva'];
	
	if (isset($_SESSION['barvaPlochy'])) {
		if ($barvaPlochy == $_SESSION['barvaPlochy']){
				$barvaPlochy = $_SESSION['barvaPlochy'];
		}
	}	
	
	
	$krytina_nazev 			= DOTAZ2('module_roof_nastavenikrytin','krytina','id',$krytina);
	$kryci_sirka_krytiny 	= $row['kryciSirka'];
	$celkova_sirka_krytiny 	= $row['celkovaSirka'];
	$sel1 					= "";
	$s1 					= "select * from `$tab_objekty_index` where `rodic`='0' AND `id` != '$id' AND `doklad`='$doklad'";
	$r1 					= PROVEST ($s1);
	$sel1 					.= "<select name='rodic' style='width: 98%;' id=rodicTest>";
	$sel1 					.= "<option value='0'>-----</option>";
	while ($r2 = mysql_fetch_array($r1)) $sel1 .= "<option value='".$r2['id']."' ".TEST($r2['id'],$rodic).">".$r2['nazev']."</option>";
	$sel1 					.= "</select>";
	
	// nactu pouze ty profily, ktere jsou dostupne v dane tride materialu
	
	$s1 					= "select * from `module_roof_materialy` where `vyrobce`='$vyrobce_krytina' AND `id`='$material_krytina'";
	$r1 					= PROVEST2($s1);
	$zaz 					= mysql_num_rows($r1);
	
	if ($zaz > 0){
		$krytinaTest = 1;
	} else {
		$krytinaTest = 0;
	}
	
	if ($krytinaTest == 1){
		
		$o1 					= mysql_fetch_array($r1);
		$dostupneProfily 		= $o1['dostupneProfily'];
		$dostupneBarvy 			= $o1['dostupnebarvy'];
		$dotazNaKrytiny 		= PARSUJKRYTINY($dostupneProfily);
		
		$sel2 = "";
		$s1 = "select * from `module_roof_nastavenikrytin` where $dotazNaKrytiny order by popis asc";
		$r1 = PROVEST2 ($s1);
	
		$sel2 .= "<select name='krytina' id='nastaveniKrytina' style='width: 98%;' onChange='vyberRozmery()'; required>";
		$sel2 .= "<option value='0'>".G_SKLADPRVNIRADEK."</option>";
		
		while ($r2 = mysql_fetch_array($r1)) {
			$idk = $r2['id_krytina'];
			if ($idk != "") $idText = " (".$r2['id_krytina'].")";
			if ($idk == "") $idText = "";
			
			$sel2 .= "<option value='".$r2['id']."' ".TEST($r2['id'],$krytina).">".$r2['krytina']." $idText</option>";
		}
		
		$sel2 .= "</select>";
			
		// barvy	
		
		$sel3 = "";
		$bcode = explode(";",$dostupneBarvy);
		$sel3 .= "<select name='barvaPlochy' id='barvaPlochy' style='width: 98%;' required>";
		$sel3 .= "<option value=''>".G_SKLADPRVNIRADEK."</option>";
		for ($i = 0; $i < count($bcode); $i++){
			$sel3 .= "<option value='".$bcode[$i]."' ".TEST($bcode[$i],$barvaPlochy)." ".RALKA($bcode[$i]).">".$bcode[$i]."</option>";
		}
		$sel3 .= "</select>";
		
		if ($setOpt != 1) {
			$ronly = " readonly ";
			$ronlyStyle = " readonly ";
		} else {
			$ronly = "";
			$ronlyStyle = "";
		}

						
		// vypis tabulky
				
		echo "
		<div id='box1'>
		<h1>".G_STRECHY_CONFTITLE."</h1>
			<form action='system_strechy.php?doklad=$doklad&plochaconfig=$id' method='post' id='plochaNastaveni' onsubmit=\"return testConfig()\">
			<table width='100%' cellspacing='0' cellpadding='0' border='0'>
				<tr>
					<th class=zleva width=100>".G_STRECHY_CONFTAB01."</th>
					<td class=zprava><input type='text' name='plochanazev' id='plochanazev' value='$plochanazev' ".G_STOPROCENT." required><input type='hidden' id='id' name='id' value='".$id."'></td>
				</tr>
				<tr>
					<th class=zleva>".G_STRECHY_PROJEKTTAB02."</th>
					<td class=zprava>".$sel3."</td>
				</tr>
				<tr>
					<th class=zleva>".G_STRECHY_CONFTAB02."</th>
					<td class=zprava>".$sel1."</td>
				</tr>
				<tr>
					<th class=zleva>".G_STRECHY_CONFTAB03."</th>
					<td class=zprava>".$sel2."</td>
				</tr>
				<tr>
					<th class=zleva>".G_STRECHY_CONFTAB04." (".G_STUPEN.")</th>
					<td class=zprava> ( ".G_STRECHY_CONFTAB04A.") <input type='number' name='uhel' id='uhel' value='$uhel' size=4 min=0 step=1 style='width: 40px;'></td>
				</tr>
				<tr>
					<th>".SET_STRECHY_VLASTNI."</th>
					<td class=zprava><input type='number' name='nova_kryci' id='novaKryci' min='0.01' step='0.001' value='".$kryci_sirka_krytiny."' style='width: 80px;' class='$ronlyStyle' required $ronly><input type='number' name='nova_celkova' value='".$celkova_sirka_krytiny."' style='width: 80px;' min='0.01' step='0.001' class='$ronlyStyle' id='novaCelkova' required $ronly></td>
				</tr>
			</table>
			<div id='hiddenInput' style='display: none;'></div>
			<button style='width: 98%;text-align: center;'>".G_STRECHY_CONFBTN."</button><br>
			<span class='checkbtn pozor s98' id='smazBTN'>smazat</span>
			<div id='smazatConfirm' style='display: none;'></div>
		</form>
		</div>
		
		<script>
			plochaNastaveni.plochanazev.select();
		</script>
		";
	} else {
		
		// material ci krytina nenalezena, musi se nejdrvive aktualizovt material
		echo "<div id='box1' class='pozor stred'>".G_STRECHY_SPATNYCFG."</div>";
		
	}
	
}

//<a href='system_strechy.php?doklad=".$doklad."&smazplochu=".$id."' class='boxtlac ui-state-error' style='display: block; width: 95%; text-align: center;' onclick=\"return confirm ('".G_STRECHY_ROZMIKONOTA3."')\";>".G_STRECHY_ROZMIKON3."</a>

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// editor rozmeru
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

if (@$_GET['rozmery'] != "" ){

	// zavru menu s vyberem ploch

	$zakladurl 		= "doklad=$doklad&rozmery=$rozmery";
	$nazevplochy 	= DOTAZ ($tab_objekty_index,'nazev','id',$rozmery);
	$meritko 		= DOTAZ ($tab_objekty_index,'meritko','id',$rozmery);
	$objpoznamka 	= DOTAZ ($tab_objekty_index,'poznamka','id',$rozmery);	// poznamka k plose

	// nacteni vsech dostupnych ploch a jejich editace
	$arr_seznam 	= "";
	$sql 			= "select * from `$tab_objekty_index` where doklad = '$doklad'";
	$res 			= PROVEST($sql);
	while ($row = mysql_fetch_array($res)) $arr_seznam[] = $row['id'];
	
	// zjistim na kterem jsem zaznamu - bude v $i

	for ($i = 0 ; $i < count($arr_seznam); $i++){
		if ($arr_seznam[$i] == $rozmery){
			break;
		}
	}

	$dozadu = @$arr_seznam[$i-1];
	$dopredu = @$arr_seznam[$i+1];
	$pocetz = count($arr_seznam) - 1;
	
	if (($i+1) >= count($arr_seznam)) $dopredu = $arr_seznam[0];
	if ($i == 0) $dozadu = $arr_seznam[$pocetz];

	echo "<div id='box1'>";
	echo "<h1 id='m2' class=ruka><a href='system_strechy.php?doklad=$doklad&rozmery=$dozadu&akce=prepocitat' style='position: relative; left: -10px;' class='preloader'><img src='grafika/ikony/predchozi_1.png'></a>".G_STRECHY_ROZMTITLE." - $nazevplochy<a href='system_strechy.php?doklad=$doklad&rozmery=$dopredu&akce=prepocitat' style='position: relative; right: -10px;' class='preloader'><img src='grafika/ikony/dalsi_1.png'></a></h1>";
	echo "<div id='menu002' style='display: block;'>";

	$sql = "select * from `$tab_objekty_polozky` where `index`='$rozmery' AND id2 != '1' order by id asc";
	$res = PROVEST ($sql);
	$zazBodu = mysql_num_rows($res);
	
	if ($rastr == 1) $ikona1 = "cad_osa.png";
	if ($rastr == 0) $ikona1 = "cad_osa_bw.png";
	if ($pomocnecary == 1) $ikona2 = "cad_pomocnecary.png";
	if ($pomocnecary == 0) $ikona2 = "cad_pomocnecary_bw.png";
	if ($zobraztasky == 1) $ikona3 = "cad_snehovataska.png";
	if ($zobraztasky == 0) $ikona3 = "cad_snehovataska_bw.png";
	$ikona2a = "cad_pomocnecary_bw1.png";
	$ikona3a = "cad_snehovataska_bw1.png";
	
	// spocitam kolik existuje bodu
	
	$selBody = "<select name='bodcislo' id='bodcislo'>";
	for ($i = 1; $i <= $zazBodu; $i++){
		$selBody .= "<option value='$i'>$i</option>";
	}
	$selBody .= "</select>";
	
	echo "
	<div id='presundiv' style='display: none; padding: 5px;' class='divfunkce stred'>
		<form action='system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=posunbodu' method='post' id='f3'>
			".G_STRECHY_PRESUNTITTXT." $selBody X : <input type='number' value='' name='novex' id='novex' title='".G_STRECHY_PRESUNTITINF."' style='width: 50px;' min=0 step='0.01'> Y : <input type='number' value='' name='novey' id='novey' title='".G_STRECHY_PRESUNTITINF."' style='width: 50px;' min=0 step='0.01'></a><input id=nastav type='button' value='".G_STRECHY_PRESUNTITBTN."'>
		</form>
	</div>

	<div id='zvetsenidiv' style='display: none; padding: 5px;' class='divfunkce stred'>
		<form action='system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=posunbodu' method='post' id='f3'>
			".G_STRECHY_SIZEKOEF." X : <input type='number' value='1' name='krat_x' id='krat_x' title='".G_STRECHY_SIZEINF."' style='width: 40px;' min=1 step='0.01'> Y: <input type='number' value='1' name='krat_y' id='krat_y' title='".G_STRECHY_SIZEINF."' style='width: 40px;' min=1 step='0.01'></a><input id=prepoctos type=button value='".G_STRECHY_SIZEBTN."'>
		</form>
	</div>

	<div id='DIVmeritko' class='divfunkce stred' style='display: none; padding: 5px;'>
	<form action='system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat' method='post'>
		<a href='system_strechy.php?rozmery=$rozmery&doklad=$doklad&zoom=100' class=checkbtn>".G_STRECHY_MERITKOINF1."</a>
		<input type='number' value='$meritko' step=0.1 min=0.5 name='mer' id='mer' size=4 style='width: 70px;' class='checkbtn stred'><input type='submit' value='".G_STRECHY_PRESUNTITBTN."' class='preloader checkbtn'>
		</form>
	</div>

	<div id='DIVrotace' class='divfunkce stred' style='display: none; padding: 5px;'>
	<form action='system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat&otocPlochu=".$rozmery."' method='post'>
		<a href='system_strechy.php?doklad=".$doklad."&rozmery=$rozmery&otocPlochu=".$rozmery."' title='".G_STRECHY_ROZMIKON3."' class='checkbtn'>".G_STRECHY_ROZMIKON6."</a>
		<input type='number' value='90' step=1 name='rotace' id='rotace' size=4 style='width: 70px;' class='checkbtn stred'><input type='submit' value='".G_STRECHY_PRESUNTITBTN."' class='checkbtn'>
	</form>
	</div>

	
	<form action='system_strechy.php?doklad=$doklad&rozmery=$rozmery&akce=prepocitat&bg=0' method='post' id='f1_vstupbodu'>
	<table width='100%' cellspacing='0' cellpadding='1' border='0' class=strechyTab>
		<tr>
			<th colspan='5'>
				<a href='#' title='".G_STRECHY_ROZMIKONINF01."' onclick=\"pridatbodik();\"><img src='grafika/cad/cad_plusbod.png' data-dalsi='grafika/cad/cad_plusbod1.png' border='0' class='imageSwap'></a>
				<a href='system_strechy.php?rozmery=$rozmery&doklad=$doklad&akce=ukazRozmery' title='".G_STRECHY_ROZMTITLE."'><img src='grafika/cad/cad_rozmery.png' data-dalsi='grafika/cad/cad_rozmery1.png' class='imageSwap' border='0'></a>
				<a href='system_strechy.php?rozmery=$rozmery&doklad=$doklad&akce=mirror'  title='".G_STRECHY_ROZMIKONINF02."'  onclick=\"return confirm ('".G_STRECHY_ROZMIKONINF03."')\";><img src='grafika/cad/cad_mirror.png' data-dalsi='grafika/cad/cad_mirror1.png' class='imageSwap' border='0'></a>
				<a href='system_strechy.php?rozmery=$rozmery&doklad=$doklad&akce=rastr'  title='".G_STRECHY_ROZMIKONINF04."'><img src='grafika/cad/$ikona1' data-dalsi='grafika/cad/cad_osa_bw1.png' border='0' class='imageSwap'></a>
				";
				
				if ($modulovani == 1) echo "<a href='system_strechy.php?rozmery=$rozmery&doklad=$doklad&akce=pomocnecary'  title='".G_STRECHY_ROZMIKONINF05."'><img src='grafika/cad/$ikona2' data-dalsi='grafika/cad/$ikona2a' border='0' class='imageSwap'></a>";
				if ($modulovani == 1) echo "<a href='system_strechy.php?rozmery=$rozmery&doklad=$doklad&akce=snehovataska'  title='".G_STRECHY_ROZMIKONINF06."'><img src='grafika/cad/$ikona3' data-dalsi='grafika/cad/$ikona3a' border='0' class='imageSwap'></a>";

			echo "
				<a href='#' id=pozntext title='".G_STRECHY_ROZMIKONINF07."'><img src='grafika/cad/cad_poznamka.png' data-dalsi='grafika/cad/cad_poznamka1.png' border='0' class='imageSwap'></a>
				<a href='#' title='".G_STRECHY_ROZMIKON."' id=presun><img src='grafika/cad/cad_posun.png' data-dalsi='grafika/cad/cad_posun1.png' border='0' class='imageSwap'></a>
				<a href='#' title='".G_STRECHY_ROZMIKON1."' id=zvetseni><img src='grafika/cad/cad_zvetsi.png' data-dalsi='grafika/cad/cad_zvetsi1.png' border='0' class='imageSwap'></a>
				<a href='system_strechy.php?doklad=".$doklad."&kopirovatplochu=".$rozmery."' onclick=\"return confirm ('".G_STRECHY_ROZMIKONOTA."')\";  title='".G_STRECHY_ROZMIKON2."'><img src='grafika/cad/cad_copy.png' data-dalsi='grafika/cad/cad_copy1.png' border='0' class='imageSwap'></a>
				<a href='system_strechy.php?doklad=".$doklad."&smazbody=".$rozmery."' onclick=\"return confirm ('".G_STRECHY_ROZMIKON4."')\";  title='".G_STRECHY_ROZMIKON4."'><img src='grafika/cad/cad_del.png' data-dalsi='grafika/cad/cad_del1.png' border='0' class='imageSwap'></a>
				<a href='#'  title='".G_STRECHY_ROZMIKON5."'id=DIVrotaceSHOW><img src='grafika/cad/rotacelevo.png' data-dalsi='grafika/cad/rotacelevo1.png' border='0' class='imageSwap'></a>
				<a href='#' title='".G_STRECHY_MERITKOINF."'  id=DIVmeritkoSHOW><img src='grafika/cad/cad_lupa.png' class='imageSwap' data-dalsi='grafika/cad/cad_lupa1.png'></a>
				<input type='hidden' id='id' name='id' value='".$id."'>
			</th>
		</tr>
	</table>
	
	<div id='pozndiv' style='display: none;'>
		<textarea name='objpoznamka' rows=3 id='objpoznamka' style='width: 98%;'>$objpoznamka</textarea><br clear=both><input type='submit' name='ok' value='".F_POZNAMKAPOSLI."' style='width: 98%; text-align: center;'><p>
	</div>
	";
				
	$poradi = 0;
	$pocetboduZapis = 0;
	$soubory = "";
	$sSelect = "<form action='system_strechy.php?doklad=$doklad&rozmery=$rozmery&bg=1' method='post' name='fbg' id='fbg'>";
	
	// pokud existuji soubory typu JPG na disku v priloze, zobrazi se jejich moznost mit je na pozadi
	
	$cesta = IDENTITACESTY(G_SYSTEMDOKUMENTY."/".$_SESSION['rok']."/".$doklad);
	
	foreach (glob("$cesta/*.jpg") as $filename) {
		$s = explode("/",$filename);
		$file = $s[(count($s)-1)];
		
		$soubory .= "<option value='$filename' ".TEST($filename,$bgimage).">$file</option>";
	}
	
	if ($soubory != ""){
			$sSelect .= "
			<div align='center'>
				".G_STRECHY_VYBEROBR." : <select name='bgimage' style='width: 135px;' onchange=\"this.form.submit()\">
				<option value=''>---</option>
				$soubory
				</select>
				</form>
				<p>
			</div>
			";
	}
	
	echo "
	<div style='max-height:200px; overflow: auto;'>
	<table width='100%' cellspacing='0' cellpadding='1' border='0' class=strechyTab>
	
	";
	while ($row = mysql_fetch_array($res)){
		$poradi++;
		$bod_id = $row['id'];
		$y_obr = sejmi_rozmer($rozmery, 'y');  	// dynamicke zvetseni osy X obrazku podle nejvetshiho Y rozmeru
		
		if ($_SESSION['unit'] == "metric"){
			echo "
			<tr>
				<th width=30 align=center>$poradi</th>
				<td class=stred><b>X : </b><input type='text' name='xbod[]' id='xbod' value='".UNIT($row['x'])."' size='6' onkeyup=osax(this.value); onClick=osax(this.value); class='cislo' style='text-align: center;'> ".$_SESSION['unitFormat']."  </td>
				<td class=stred><b>Y : </b><input type='text' name='ybod[]' id='ybod' value='".UNIT($row['y'])."' size='6' onkeyup=osay(this.value); onClick=osay(this.value); class='cislo' style='text-align: center;'> ".$_SESSION['unitFormat']." <input type='hidden' name='index[]' id='index' value='".$row['id']."'></td>
				<td width=20 class=stred><a href='system_strechy.php?$zakladurl&smazbod=$bod_id' onclick=\"return confirm ('".G_STRECHY_SMAZATBOD."')\";>".ICONSWAP("ikony","smazat")."</a></td>
			</tr>
			";
		}

		if ($_SESSION['unit'] == "imperial"){
			echo "
			<tr>
				<th width=30 align=center>$poradi</th>
				<td class=stred><b>X : </b><input type='text' name='xbod[]' id='xbod' value='".UNIT($row['x'])."' size='7' onkeyup=osax(this.value); onClick=osax(this.value); class='imperial' style='text-align: center;'> ".$_SESSION['unitFormat']."  </td>
				<td class=stred><b>Y : </b><input type='text' name='ybod[]' id='ybod' value='".UNIT($row['y'])."' size='7' onkeyup=osay(this.value); onClick=osay(this.value); class='imperial' style='text-align: center;'> ".$_SESSION['unitFormat']." <input type='hidden' name='index[]' id='index' value='".$row['id']."'></td>
				<td width=20 class=stred><a href='system_strechy.php?$zakladurl&smazbod=$bod_id' onclick=\"return confirm ('".G_STRECHY_SMAZATBOD."')\";>".ICONSWAP("ikony","smazat")."</a></td>
			</tr>
			";
		}
		
		$pocetboduZapis++;
	}

	echo "
		</table>
		</div>
		<input type='submit' name='odesli' value='".G_BNT_AKTUALIZOVAT."' class=preloader style='width: 98%; text-align: center;'>
	</form>
	</table>
	$sSelect
	
</div>
";	


?>
	<script>

		 $("#pozntext").click(function () {
		     $("#pozndiv").slideToggle("slow");
		    $("#zvetsenidiv").slideUp("slow");
		    $("#presundiv").slideUp("slow");
		 });

		 $("#presun").click(function () {
		    $("#zvetsenidiv").slideUp("slow");
		    $("#presundiv").slideToggle("slow");
			$("#pozndiv").slideUp("slow");
			$("#menu003").slideUp("slow");
			$("#menu004").slideUp("slow");
			$("#DIVmeritko").slideUp("slow");
			$("#DIVrotace").slideUp("slow");
		});

		 $("#zvetseni").click(function () {
		    $("#presundiv").slideUp("slow");
		    $("#zvetsenidiv").slideToggle("slow");
			$("#pozndiv").slideUp("slow");
			$("#menu003").slideUp("slow");
			$("#menu004").slideUp("slow");
			$("#DIVmeritko").slideUp("slow");
			$("#DIVrotace").slideUp("slow");
		});

		$("#DIVmeritkoSHOW").click(function () {
			$("#DIVmeritko").slideToggle("slow");
			$("#DIVrotace").slideUp("slow");
		    $("#presundiv").slideUp("slow");
		    $("#zvetsenidiv").slideUp("slow");
			$("#pozndiv").slideUp("slow");
			$("#menu003").slideUp("slow");
			$("#menu004").slideUp("slow");
	  });

		$("#DIVrotaceSHOW").click(function () {
			$("#DIVrotace").slideToggle("slow");
			$("#DIVmeritko").slideUp("slow");
		    $("#presundiv").slideUp("slow");
		    $("#zvetsenidiv").slideUp("slow");
			$("#pozndiv").slideUp("slow");
			$("#menu003").slideUp("slow");
			$("#menu004").slideUp("slow");
	  });

	
		var pomer 		= parseFloat(<?echo $POMER + $vnitrniPomer; ?>);
		rozmery 		= <?echo "$rozmery"; ?>;
		doklad 			= "<?echo $doklad; ?>";
		xmin 			= "<?echo "$xmin"; ?>";
		modulovani 		=  "<?echo $modulovani; ?>";
		xoff 			= parseInt("<? echo $x_off_left;?>");
		yoff 			= parseInt("<? echo $y_off;?>");
		bodyPocet 		= 1;
		vyskaObrazku 	= parseInt("<? echo $y_obr;?>");
		
		$(document).ready(function(){
			
		   $("#kresleni").mousemove(function(e){
			
			// pozice Y rozdil o pozici DIV v CSS a YOFFSET 
			var xpoz = Math.round((e.pageX - this.offsetLeft - 302 - xoff) * pomer);
			var ypoz = Math.round(((vyskaObrazku) - e.pageY + 100 - yoff) * pomer);
			
			var ukazX = UNIT(((xpoz+3) / 100),'m','grafika','<? echo $_SESSION['unit'];?>','<? echo $_SESSION['unitFormat'];?>');
			var ukazY = UNIT(((ypoz+3) / 100),'m','grafika','<? echo $_SESSION['unit'];?>','<? echo $_SESSION['unitFormat'];?>');
			
			$('#popisek').html('<b class=xp>X : '+ ukazX+'</b><br><b class=yp>Y : '+ ukazY +'</b>');
			$('#osa_svisla').css('left',e.pageX+3+'px');
			$('#osa_vodorovna').css('top',e.pageY-3+'px');
			$('#osa_vodorovna').css('visibility','visible');
			$('#popisek').css('left',e.pageX+15+'px');
			$('#popisek').css('top',e.pageY+'px');
			
			if (xpoz < 0) $('.xp').css('color','red');
			if (ypoz < 0) $('.yp').css('color','red');
				
			if (e.pageX < 305) {
				$('#osa_vodorovna').css('visibility','hidden');
				$('#osa_svisla').css('visibility','hidden');
				$('#popisek').css('visibility','hidden');
			} else {
				$('#osa_vodorovna').css('visibility','visible');
				$('#osa_svisla').css('visibility','visible');
				$('#popisek').css('visibility','visible');
			}

		   });
	
		$("#kresleni").click(function(e) {
			
			var bodu = parseInt("<? echo $pocetboduZapis;?>");
			var soubor = "<? echo $bgimage;?>";
			var ok = 0;
			
			var x = Math.round((e.pageX - this.offsetLeft - 302 - xoff) * pomer);
			var y = Math.round(((vyskaObrazku) - e.pageY + 100 - yoff) * pomer);
			
			document.getElementById('editmenu').style.display='none';
			var mn = document.getElementById("editmenu");
			
			// jestlize je malo bodu, zobrazi se hlaska
			
			if (bodu < 3 && soubor.length == 0) {
				mn.innerHTML = "<table><tr><td style='color: white;'><? echo G_STRECHY_MALOBODU;?></td></tr></table>";
				document.getElementById('editmenu').style.width='200px';
				var ok = 1;
			}
			
			if (bodu < 3 && soubor.length != 0) {
				// nactu body z hidden pole
				var data = document.getElementById('zaznamBody').value;
				var createButton = "";
				if (bodyPocet > 3) var createButton = "<button id='zalozitPlochu'><? echo G_STRECHY_RECCREATE;?></button>";
				
				mn.innerHTML = "<button id='zaznamenatBod'><? echo G_STRECHY_RECBTN;?> : "+bodyPocet+"</button><br><button id='smazatZaznam'><? echo G_STRECHY_RECDEL;?></button><br>"+createButton;
				var ok = 1;
			
				// ulozi bod
				$("#zaznamenatBod").click(function() {
						
					var data = document.getElementById('zaznamBody').value;
					data = data+x+"/"+y+";";
					
					// zobrazi bod na graficke mape, ale musi je otocit vzhledem ke stylu kresleni v ose Y
					var yDiv = vyskaObrazku - y + 26;
					var xDiv = x + 75 + 302;
					$("#plochacela").append("<div style='position: absolute; left: "+xDiv+"px; top: "+yDiv+"px; width: 15px; height: 15px;z-index:100;' class=points><img src='grafika/cad/cad_bod.png'></div>");
				
					bodyPocet++;
					document.getElementById('zaznamBody').value = data;
					$('#editmenu').fadeOut(200);
				});				
				
				// smaze zaznam
				$("#smazatZaznam").click(function() {
					document.getElementById('zaznamBody').value = "";
					bodyPocet = 1;
					$( ".points" ).remove();
					$('#editmenu').fadeOut(200);
				});

				// ulozi zaznam
				$("#zalozitPlochu").click(function() {
					var body = document.getElementById('zaznamBody').value;
					$('#editmenu').fadeOut(200);
					$("#vystup").load( "system_strechy_zalozit.php?doklad=<?echo $doklad;?>&rozmery=<?echo $rozmery;?>&body="+body, function() {
						location.href = "system_strechy.php?doklad=<? echo $doklad;?>&rozmery=<? echo $rozmery;?>&akce=prepocitat";
					});
				});

			}
				document.getElementById('editmenu').style.width='60px';
				$('#editmenu').css('left',e.pageX-40);
				$('#editmenu').css('top',e.pageY-40);

			$('#editmenu').fadeIn(300);

				
			/* modulove krytiny */
			if (modulovani  == '1' && ok == 0){
				
				mn.innerHTML =

				" <div id='formkolikplus' style='display: none;'>" +
				"    <form action='system_strechy.php?generuj=zvetsiomodulnahoru&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' method='post' id='fzmena'>" +
				"          <input type='number' id='kolik' value='1' name='kolik' min='1' step='1' style='width:40px;'><input type='submit' name='od' value='ok'>" +
				"    </form>" +
				" </div>"+
				"<table width='80' cellspacing='0' cellpadding='0' border='0'  onmouseover=resetuj();>" +
				"    <tr>"+
				"        <td><a href='#'  id='ukazkolik' onmouseover=resetuj();><img src='grafika/cad/cad_plus.png' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?generuj=posunoutnahoru&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/cad_posun_nahoru.png' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?generuj=rozdelitmodul&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/nuzky.png' border='0'></a></td>" +
				"    <tr>" +

				"    <tr>"+
				"        <td><a href='system_strechy.php?generuj=posunoutdoleva&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/cad_posun_levo.png' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?generuj=vyberpas&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/vyber.png' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?generuj=posunoutdoprava&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/cad_posun_pravo.png' border='0'></a></td>" +
				"    <tr>" +

				"    <tr>"+
				"        <td><a href='system_strechy.php?generuj=zmensiomodulnahoru&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/cad_minus.png' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?generuj=posunoutdolu&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/cad_posun_dolu.png' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?generuj=smazatpas&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj(); onclick=\"return confirm ('<? echo G_STRECHY_OPTSMAZPAS;?>')\";><img src='grafika/cad/cad_del.png' border='0'></a></td>" +
				"    <tr>" +

				"    <tr>"+
				"        <td><a href='#' onmouseover=resetuj(); id='ukazzadek'><img src='grafika/cad/zadek.png' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?generuj=smazvyber&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/vyber_smaz.gif' border='0'></a></td>" +
				"        <td><a href='#' id=dalsifunkce onmouseover=resetuj();><img src='grafika/cad/cad_dalsif.png' border='0'></a></td>" +
				"    <tr>" +
				"</table>" +

				" <div id='rozmerzadku' style='display: none; background-color: white;'>" +
				"    <form action='system_strechy.php?generuj=novyzadek&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' method='post' id='fzmena'>" +
				"          <input type=number id='zadek' name='zadek' style='width: 45px;' value='<? echo $prodlouzeni_min;?>' min='<? echo $prodlouzeni_min;?>' max='<? echo $prodlouzeni_max;?>' step=1><input type='submit' name='od' value='ok'>" +
				"    </form>" +
				" </div>"+

				// dalsi funkce

				" <div id='formdalsifunkce' style='display: none;'>" +
				"<a href='system_strechy.php?generuj=vyberradu&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><? echo G_STRECHY_GFXMENU02;?></a>" +
				"<a href='system_strechy.php?generuj=spojitdolu&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><? echo G_STRECHY_GFXMENU03;?></a>" +
				" </div>";
				document.getElementById('editmenu').style.width='60px';
				$('#editmenu').css('left',e.pageX-40);
				$('#editmenu').css('top',e.pageY-40);
				FADE();
			}

			// nemodulove krytiny
			if (modulovani  == '0'){
				
				mn.innerHTML =
				"<table width='80' cellspacing='0' cellpadding='0' border='0'  onmouseover=resetuj();>" +
				"    <tr>"+
				"        <td><a href='#' onmouseover=resetuj(); id=nemodulplus><img src='grafika/cad/cad_plus.png' border='0'></a></td>" +
				"        <td><a href='#' onmouseover=resetuj(); id=posunup><img src='grafika/cad/cad_posun_nahoru.png' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?nemodul=strihni&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/nuzky.png' border='0'></a></td>" +
				"    <tr>" +

				"    <tr>"+
				"        <td>&nbsp;</td>" +
				"        <td><a href='system_strechy.php?nemodul=vyberpas&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/vyber.png' border='0'></a></td>" +
				"        <td>&nbsp;</td>" +
				"    <tr>" +

				"    <tr>"+
				"        <td><a href='#' onmouseover=resetuj(); id=nemodulminus><img src='grafika/cad/cad_minus.png' border='0'></a></td>" +
				"        <td><a href='#' onmouseover=resetuj(); id=posundown><img src='grafika/cad/cad_posun_dolu.png' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?nemodul=smazatpas&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj(); onclick=\"return confirm ('<? echo G_STRECHY_OPTSMAZPAS;?>')\";><img src='grafika/cad/cad_del.png' border='0'></a></td>" +
				"    <tr>" +

				"    <tr>"+
				"        <td><a href='#' onmouseover=resetuj(); id='kopirujdelku'><img src='grafika/cad/delky.png' border='0' title='<? echo G_EDITORPASYDELKA;?>'></a></td>" +
				"        <td><a href='system_strechy.php?generuj=smazvyber&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/vyber_smaz.gif' border='0'></a></td>" +
				"        <td><a href='system_strechy.php?nemodul=vybratradu&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><img src='grafika/cad/vyber_rada.png' border='0' title='<? echo G_STRECHY_GFXMENU02;?>'></a></td>" +
				"    <tr>" +

				"</table>" +

				" <div id='formnactidelky' style='display: none; background-color: white;'>" +
				"    <form action='system_strechy.php?nemodul=novadelka&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' method='post' id='fzmena1'>" +
				"       <select name='novadelka' onchange=\"this.form.submit();\" onmouseover=resetuj();>" +
				vsechnyrozmery +
				"       </select>" +
				"    </form>" +
				" </div>" +

				" <div id='formposundown' style='display: none; background-color: white;'>" +
				"    <form action='system_strechy.php?nemodul=posundolu&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' method='post' id='fzmena3'>" +
				"          <input type='number' min='1' step='1' id='delka3' name='delka3' value='15' style='text-align: right;width: 55px;'> <? echo G_CM;?> <input type='submit' name='od' value='ok' style='width: 100%;'>" +
				"    </form>" +
				" </div>" +

				" <div id='formposunup' style='display: none; background-color: white;'>" +
				"    <form action='system_strechy.php?nemodul=posunnahoru&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' method='post' id='fzmena3'>" +
				"          <input type='number' id='delka2' min='1' step='1' name='delka2' value='15' style='text-align: right; width: 55px;'> <? echo G_CM;?> <input type='submit' name='od' value='ok' style='width: 100%;'>" +
				"    </form>" +
				" </div>" +

				" <div id='nemodulminusform' style='display: none; background-color: white;'>" +
				"    <form action='system_strechy.php?nemodul=zkratit&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' method='post' id='fzmena2'>" +
				"          <input type='number' id='delka1' name='delka1' value='15' min='1' step='1' style='text-align: right; width: 55px;'> <? echo G_CM;?> <input type='submit' name='od' value='ok' style='width: 100%;'>" +
				"    </form>" +
				" </div>" +

				" <div id='nemodulplusform' style='display: none; background-color: white;'>" +
				"    <form action='system_strechy.php?nemodul=prodlouzit&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' method='post' id='fzmena'>" +
				"          <input type='number' id='delka' name='delka' value='15' min='1' step='1' style='text-align: right; width: 55px;'> <? echo G_CM;?> <input type='submit' name='od' value='ok' style='width: 100%;'>" +
				"    </form>" +
				" </div>" +

				" <div id='formdalsifunkcenemodul' style='display: none;'>" +
				"<a href='system_strechy.php?generuj=strihpohrane&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><? echo G_STRECHY_GFXMENU01;?></a>" +
				"<a href='system_strechy.php?generuj=vyberradu&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><? echo G_STRECHY_GFXMENU02;?></a>" +
				"<a href='system_strechy.php?generuj=spojitdolu&x="+x+"&y="+y+"&rozmery="+rozmery+"&doklad="+doklad+"' onmouseover=resetuj();><? echo G_STRECHY_GFXMENU03;?></a>" +
				" </div>";
				document.getElementById('editmenu').style.width='60px';
				$('#editmenu').css('left',e.pageX-40);
				$('#editmenu').css('top',e.pageY-40);
				FADE();
			}

			 $("#dalsifunkce").click(function () {
			     $("#formdalsifunkce").slideToggle("slow");
			 });

			 $("#dalsifunkcenemodul").click(function () {
			     $("#formdalsifunkcenemodul").slideToggle("slow");
			 });


			 $("#ukazzadek").click(function () {
			     $("#rozmerzadku").slideToggle("slow");
			     $("#zadek").focus();
			     $("#zadek").select();
			 });

			 $("#ukazkolik").click(function () {
			     $("#formkolikplus").slideToggle("slow");
			     $("#kolik").focus();
			     $("#kolik").select();
			 });

			 $("#nemodulplus").click(function () {
			     $("#nemodulplusform").slideToggle("slow");
				 $("#formposundown").slideUp("slow");
				 $("#nemodulminusform").slideUp("slow");
				 $("#formposunup").slideUp("slow");
			     $("#delka").focus();
			     $("#delka").select();
			 });

			 $("#nemodulminus").click(function () {
			     $("#nemodulminusform").slideToggle("slow");
				 $("#nemodulplusform").slideUp("slow");
				 $("#formposunup").slideUp("slow");
				 $("#formposundown").slideUp("slow");
			     $("#delka1").focus();
			     $("#delka1").select();
			 });

			 $("#posunup").click(function () {
			     $("#formposunup").slideToggle("slow");
			     $("#nemodulminusform").slideUp("slow");
				 $("#nemodulplusform").slideUp("slow");
				 $("#formposundown").slideUp("slow");
			     $("#delka2").focus();
			     $("#delka2").select();
			 });

			 $("#posundown").click(function () {
			     $("#formposundown").slideToggle("slow");
				 $("#nemodulminusform").slideUp("slow");
				 $("#nemodulplusform").slideUp("slow");
				 $("#formposunup").slideUp("slow");
			     $("#delka3").focus();
			     $("#delka3").select();
			 });

			 $("#kopirujdelku").click(function () {
			     $("#formnactidelky").slideToggle("slow");
			 });

			});
		})

		 $("#nastav").click(function(){
			 var bodcislo = $('#bodcislo').val()-1;
			 var x = $("input[name^=xbod]").eq(bodcislo).val();
			 var y = $("input[name^=ybod]").eq(bodcislo).val();
			 // var x = parseFloat(x1);
			 // var y = parseFloat(y1);
			 
			 var scanx = $('#novex').val();
			 var scany = $('#novey').val();
			 var novex = scanx.replace(",",".");
			 var novey = scany.replace(",",".");
			 var rozdilx = parseFloat(novex - x);
			 var rozdily = parseFloat(novey - y);

			 /* prepoctu vsechny prvky podle zadanych dat */

			 $("input[name^=xbod]").each(function() {
				var x = parseFloat($(this).val());
				var posunx = parseFloat(rozdilx + x);
				$(this).val(posunx)
			 });
			 $("input[name^=ybod]").each(function() {
				var y = parseFloat($(this).val());
				var posuny = parseFloat(rozdily + y);
				$(this).val(posuny)
			 });
			 document.forms["f1_vstupbodu"].submit();
		 });

		$('#novey').on('keyup', function(e) {
		    if (e.which == 13) {
			 var bodcislo = $('#bodcislo').val()-1;
				if (bodcislo != -1){
					 var x = $("input[name^=xbod]").eq(bodcislo).val();
					 var y = $("input[name^=ybod]").eq(bodcislo).val();
					 var scanx = $('#novex').val();
					 var scany = $('#novey').val();
					 var novex = scanx.replace(",",".");
					 var novey = scany.replace(",",".");
					 var rozdilx = parseFloat(novex - x);
					 var rozdily = parseFloat(novey - y);

					 /* prepoctu vsechny prvky podle zadanych dat */

					 $("input[name^=xbod]").each(function() {
						var x = parseFloat($(this).val());
						var posunx = parseFloat(rozdilx + x);
						$(this).val(posunx)
					 });
					 $("input[name^=ybod]").each(function() {
						var y = parseFloat($(this).val());
						var posuny = parseFloat(rozdily + y);
						$(this).val(posuny)
					 });
					 document.forms["f1_vstupbodu"].submit();
				} else {
					 alert ("<? echo G_STRECHY_ZADEJBODY;?>");
				}
		    }
		});

    $("#m3pris").click(function () {
      $("#menu003prisl").slideToggle("slow");
    });

	$("#prepoctos").click(function(){

		 var scanx = $('#krat_x').val();
		 var scany = $('#krat_y').val();
		 var novex = scanx.replace(",",".");
		 var novey = scany.replace(",",".");


			if (novex != '' || novey != ''){

				 $("input[name^=xbod]").each(function() {
					var sx = $(this).val();
					var x = sx.replace(",",".");
					var posunx = parseFloat(novex * x);
					$(this).val(posunx)
				 });

				 $("input[name^=ybod]").each(function() {
					var sy = $(this).val();
					var y = sy.replace(",",".");
					var posuny = parseFloat(novey * y);
					$(this).val(posuny)
				 });

				 document.forms["f1_vstupbodu"].submit();
			} else {
				 alert ("<? echo G_STRECHY_ZADEJBODY;?>");
			}
		 });

</script>

<?

// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// Optimalizace pro modulove krytiny
// -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

// pokud je plocha vnorena, nezobrazi se moznost optimalizace

if ($plocha_rodic == 0 && $pocetboduZapis > 2){
		
		$tolerancepole = array(4,10,14,20,100);
		$toleranceVypis = array(80,85,90,95,100);

		echo "
		</form>
		</div>
				<form action='system_strechy.php?rozmery=$rozmery&doklad=$doklad&akce=prepocitat&optimalizace=ano&bg=0' method='post' id=\"reservation\">
				<div id='box1' class=stred><h1>".G_STRECHY_OPTTITLE."</h1>
				";
				
					if ($modulovani == 1){
						echo "<div class='radio'>";
						for ($i = 0; $i < count($tolerancepole); $i++){
							echo "<input type=radio name=tolerance id='radioTolerance_$i' value='".$tolerancepole[$i]."' ".TESTRADIO($tolerancepole[$i],$tolerance_ztraty)."><label for='radioTolerance_$i'>".$toleranceVypis[$i]." %</label>";
						}
						echo "</div><hr>";
					}

					echo "	
						<input type='image' src='grafika/ikony/dalsi_1.png' name='submitsmerzleva' value='1' onclick=\"return confirm ('".G_STRECHY_OPTZLEVA."')\"; class='checkbtn preloader'>
						<input type='image' src='grafika/ikony/optsmazat_1.png' name='submitsmazat' value='1' onclick=\"return confirm ('".G_STRECHY_OPTSMAZATINF."')\"; class='checkbtn'>
						<input type='image' src='grafika/ikony/predchozi_1.png' name='submitsmerzprava' value='1' onclick=\"return confirm ('".G_STRECHY_OPTZLEVA."')\"; class='checkbtn preloader'>
						<div id='contForm' style='display: none;'>Pokracovat ?</div>
					";
					
					
					if ($stresnitaska != 1){
						if ($modulovani == 1) echo "<input type='number' name='pmodulu' id='pmodulu' value='$optimalizace_modul' style='text-align: center; width:55px;' step=1 min=1 class='checkbtn'><span class='checkbtn'>MOD</span>";
						if ($modulovani == 0) echo "<input type='number' value='5' name='zaokrouhleniNemodul' style='width: 60px;' step='5' min='0' class='checkbtn'><input type='submit' name='zaoNem' value='".G_STRECHY_ZAKROU."' class='checkbtn'>";
						echo "<hr><input type='number' name='manualoffset' id='manualoffset' value='$manual_offset' class='checkbtn' step=1 style='width: 60px;'><input type='submit' name='submitoffset' value='".G_STRECHY_OFFSET."' title='".G_STRECHY_OPTOFFSET."' class='checkbtn'>";
					}
		
		echo "</div>";
		echo "</form>";


		// funkce pro hromadne upravy

if ($hromadnyvyber == 1){
	echo "

	<div id='box1' style='background-color: #2e619a;'>
		<h1>".G_STRECHY_FCETITLE."</h1>
	";

	if ($modulovani == 1){
		echo "
		<table width=100% cellspacing='0' cellpadding='1' border='0'>
			<tr>
				<th>
					<form action='system_strechy.php?generuj=novyzadek&rozmery=$rozmery&doklad=$doklad' method='post' id='fzmenavice'>
					<a href='system_strechy.php?generuj=zvetsiomodulnahoru&rozmery=$rozmery&doklad=$doklad' title='".G_STRECHY_FCEINF01."' ><img src='grafika/cad/cad_plusbod.png' data-dalsi='grafika/cad/cad_plusbod1.png' border='0' class='imageSwap'></a>
					<a href='system_strechy.php?generuj=zmensiomodulnahoru&rozmery=$rozmery&doklad=$doklad' title='".G_STRECHY_FCEINF02."' ><img src='grafika/cad/cad_minus.png' data-dalsi='grafika/cad/cad_minus1.png' border='0' class='imageSwap'></a>
					<a href='system_strechy.php?generuj=smazvyber&rozmery=$rozmery&doklad=$doklad' title='".G_STRECHY_FCEINF03."' ><img src='grafika/cad/cad_zrusvyber.png' data-dalsi='grafika/cad/cad_zrusvyber1.png' border='0' class='imageSwap'></a>
					<a href='system_strechy.php?generuj=posunoutnahoru&rozmery=$rozmery&doklad=$doklad' title='".G_STRECHY_FCEINF04."' ><img src='grafika/cad/cad_posun_nahoru.png' data-dalsi='grafika/cad/cad_posun_nahoru1.png' border='0' class='imageSwap'></a>
					<a href='system_strechy.php?generuj=posunoutdolu&rozmery=$rozmery&doklad=$doklad' title='".G_STRECHY_FCEINF05."' ><img src='grafika/cad/cad_posun_dolu.png' data-dalsi='grafika/cad/cad_posun_dolu1.png' border='0' class='imageSwap'></a>
					<a href='system_strechy.php?generuj=spojitdolu&rozmery=$rozmery&doklad=$doklad' title='".G_STRECHY_FCEINF06."' ><img src='grafika/cad/cad_spojit_dolu.png' data-dalsi='grafika/cad/cad_spojit_dolu1.png' border='0' class='imageSwap'></a>
					
					<input type='number' value='10' name='zadek' size='3' min='".$prodlouzeni_min."' max='".$prodlouzeni_max."' step='1'><input type='submit' name='od' value='ok'>
					</form>
				</th>
			</tr>
		</table>
		";
	}

	if ($modulovani == 0){
		echo "
		<table width=100% cellspacing='0' cellpadding='1' border='0'>
			<tr>
				<th width='80' class=zleva>".G_STRECHY_FCEROZDELIT."</th>
				<td>
					<form action='system_strechy.php?nemodul=rozdelitvice&rozmery=$rozmery&doklad=$doklad' method='post' id='fzmenavice'>
					<input type='number' name='delkarezu' value='400' min=10 step='1' class='stred' style='width: 60px;'> ".G_CM." <input type=checkbox name='stridat' value='1' class=checkbtn id='si1'><label for='si1'>".G_STRECHY_FCESTRIDAT."</label><input type='submit' name='ok' value='".G_STRECHY_SIZEBTN."'>
					</form>
				</td>
			</tr>
			<tr>
				<th class=zleva>".G_STRECHY_NOVADELKA."</th>
				<td>
					<form action='system_strechy.php?nemodul=novadelka2&rozmery=$rozmery&doklad=$doklad' method='post' id='fzmena1'>
					<input type='number' name='novadelka2' id='novadelka2' style='width: 60px;'>".G_CM." <input type='submit' name='ok' value='".G_STRECHY_SIZEBTN."' onmouseover=resetuj();>
					</form>
				</td>
			</tr>
		</table>
		";
	}
	
	echo "	
	</div>
	";
}
		
		echo "<div id='menu003' style='display: block;'>";

		if ($modulovani == 1) $sql = "select delka_modulu,zadek,pocet_modulu,pocet_modulu, count(pocet_modulu) pocet_modulu,celkova_sirka from `$tab_objekty_pasy` where `plocha_id`='$rozmery' AND `strih`='0' group by `pocet_modulu`,`zadek`";
		if ($modulovani == 0) $sql = "select delka_modulu, zadek, count(delka_modulu) delka_modulu, celkova_sirka from `$tab_objekty_pasy` where `plocha_id`='$rozmery' AND `strih`='0' group by `delka_modulu`";
		TABULKAPASU ($sql, $modulovani, $nazev_krytiny, $typ_krytiny);

		//echo "</div>";		// box1
	
	echo "</div>";		// box1
}					// konec kontroly na rodice


// ------------------------------------------------------------------------------------------------------------------------
// informace o malem poctu bodu

if ($pocetboduZapis < 3) {
	$maloBodu = "<div id='box1' class='pozor stred cena14'>".G_STRECHY_MALOBODU."</div>";
} else {
	$maloBodu = "";
}

// ------------------------------------------------------------------------------------------------------------------------


// nakrmim pole seznamem strizenych pasu

$arr_strihy = "";
$sql = "select * from `$tab_objekty_pasy` where `doklad`='$doklad' and `strih`='1'";
$w = PROVEST ($sql);

while ($w1 = mysql_fetch_array($w)){
	$arr_strihy = $arr_strihy."_". $w1['id'];
}
?>

<script>

	// rozparsuju delky z PHP dbase a udelam z nich option hodnoty pro submenu v editoru pasu
	delky =  "<?echo "$arr_rozmery"; ?>";
	var d = delky.split("_");
	vsechnyrozmery = "";

	for(i=0;i<d.length;i++){
		     vsechnyrozmery = vsechnyrozmery + "<option value='"+d[i]+"'>"+d[i]+"</option>";
	 }

	// rozparsuje vsechny rozsekane pasy pripravene na dokryti

	delky =  "<?echo "$arr_strihy"; ?>";
	var d = delky.split("_");
	vsechnystrihy = "";

	for(i=0;i<d.length;i++){
		     vsechnystrihy = vsechnystrihy + "<option value='"+d[i]+"'>"+d[i]+"</option>";
	 }


    $("#m3").click(function () {
		$("#menu003").slideDown("slow");
		$("#menu004").slideUp("slow");
		$("#zvetsenidiv").slideUp("slow");
		$("#presundiv").slideUp("slow");
    });
</script>
<?

// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// celkovy nahled na cely kladeci plan
// ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

echo "<div id='box1'>";
	echo "<h1 id='m4' class=ruka>".G_STRECHY_OPTCELSOUHRN."</h1>";
	echo "<div id='menu004' style='display: none;'>";

	$poleploch = "";
	// nactu pocet ruznych materialu (krytina , trapez)
	$xsql = "select * from `$tab_objekty_index` where `doklad` = '$doklad' AND rodic = '0' group by krytina";
	
	$xres = PROVEST ($xsql);
	$pocet_materialu = mysql_num_rows($xres);
	while ($row = mysql_fetch_array($xres)){
		$poleploch[] = $row['krytina'];
	}

	// vypisu vsechny materialy setridene v seznamech delek plechu
	for ($a = 0; $a < count($poleploch); $a++){

		$jmenokrytiny =  DOTAZ2('module_roof_nastavenikrytin','krytina','id',$poleploch[$a]);
		$modulova =  DOTAZ2('module_roof_nastavenikrytin','modulova','id',$poleploch[$a]);
		$typkrytina = $poleploch[$a];
		if ($modulova == 1) $sql = "select delka_modulu,zadek,pocet_modulu,pocet_modulu, count(pocet_modulu) pocet_modulu,celkova_sirka from `$tab_objekty_pasy` where `doklad`='$doklad' AND krytina='$typkrytina' group by `pocet_modulu`,`zadek`";
		if ($modulova == 0) $sql = "select delka_modulu, zadek, count(delka_modulu) delka_modulu, celkova_sirka from `$tab_objekty_pasy` where `doklad`='$doklad' AND krytina='$typkrytina' group by `delka_modulu`,`zadek`";
		TABULKAPASU ($sql, $modulova, $jmenokrytiny, $typkrytina);

	}	// konec vypisu ploch
	echo "</div>";
?>

<script>
    $("#m4").click(function () {
		$("#menu003").slideToggle("slow");
		$("#menu004").slideToggle("slow");
		$("#zvetsenidiv").slideUp("slow");
		$("#presundiv").slideUp("slow");
    });
</script>
<?

	echo "
	</div>
</div>
";			// box1


// konec celkoveho souhrnu celeho kladeciho planu ----------------------------------------------------------------------------------------------------------------------------------
}

// zapis pozic do databaze

if (@$_GET['zapispozic'] == "ano"){

	$pome2d = $_POST['pomer2d'];

	$sql = "select * from `$tab_objekty_index` where `doklad`='$doklad'";
	$res = PROVEST ($sql);

	while ($row = mysql_fetch_array($res)){
		$id = $row['id'];

		$x = @$_POST["drform_".$row['id']."_x"];
		$y = @$_POST["drform_".$row['id']."_y"];
		$z = @$_POST["drform_".$row['id']."_z"];
		$zobraz = @$_POST["drform_".$row['id']."_zobraz"];

		$s = "update `$tab_objekty_index` set `2d_x`='$x',`2d_y`='$y',`2d_uhel`='$z',`2d_zobraz`='$zobraz' where `id`='$id'";
		PROVEST ($s);
	}
	PROVEST ("update `$tab_nabidky_index` set `2dpomer`='$pome2d' where `cislo_fa`='$doklad'");
	$pome2d = DOTAZ($tab_nabidky_index,'2dpomer','cislo_fa',$doklad);
}

if (@$_GET['editor'] == "skladacka"){
		
	if ($pocetPloch != 0){
		
	echo "
	<div id='box1'>
	<h1>".G_STRECHY_OPT2DEDITOR."</h1>
		<form action='system_strechy.php?doklad=$doklad&editor=skladacka&zapispozic=ano' method='post' id='pozice'>
			<table width='100%' cellspacing='0' cellpadding='".G_PADDING."' border='0'>
			<tr>
				<th>".G_STRECHY_OPT2DNAZEV."</th>
				<th>X</th>
				<th>Y</th>
				<th>".G_STUPEN."</th>
				<th>&nbsp;</th>
			</tr>
	  ";

		$sql = "select * from `$tab_objekty_index` where doklad = '$doklad' AND `rodic` = '0'";
		$res = PROVEST ($sql);
		$i = 0;
		
		while ($row = mysql_fetch_array($res)){
			
			$nazev 	= $row['nazev'];
			$idobj 	= $row['id'];
			$x 		= $row['2d_x'];
			$y 		= $row['2d_y'];
			$z 		= $row['2d_uhel'];
			$zobraz = $row['2d_zobraz'];

			echo "
			<tr id='drform_".$idobj."_nazev'>
				<td class=stred>$nazev</td>
				<td class=stred><input type='number' id='drform_".$idobj."_x' name='drform_".$idobj."_x' value='$x' class='cislotecka number' step='1'></td>
				<td class=stred><input type='number' id='drform_".$idobj."_y' name='drform_".$idobj."_y' value='$y' class='cislotecka number' step='1'></td>
				<td class=stred><a href='system_strechy.php?doklad=$doklad&editor=skladacka&otoc=$idobj&okolik=10'>+</a><input type='number' id='drform_".$idobj."_z' name='drform_".$idobj."_z' value='$z' class='cislotecka' style='width: 45px;'><a href='system_strechy.php?doklad=$doklad&editor=skladacka&otoc=$idobj&okolik=-10'>-</a></td>
				<td class=stred><input type='checkbox' id='drform_".$idobj."_zobraz' name='drform_".$idobj."_zobraz' value='1' ".CHECKBOX($zobraz)."  onclick='submit();'></td>
			</tr>
			";
			
			$i++;
			
		}
		
		echo "</table>&nbsp;&nbsp;&nbsp;".G_STRECHY_VELNAHLED." : 
			<select name=\"pomer2d\" id=\"pomer2d\" onChange=submit();>";

		for ($i = 3; $i < 15; $i++) echo "<option value='$i' ".TEST($i,$pome2d).">$i</option>";

		echo "
			</select>
			<input type='submit' name='ok' value='ok'>
		</form>
		</div>
		";

		} else {
			echo "<div id='box1' class='pozor stred'>".G_STRECHY_NENIPLOCHA."</div>";
		}
	}

echo @$maloBodu;
echo "</div>"; 	// kontejner levo


// plocha kresleni ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
// mrknu na strizene okna

$sql = "select * from `$tab_objekty_pasy` where `doklad`='$doklad' and `strih`='1'";
$res = PROVEST ($sql);
$strihyokno = mysql_num_rows($res);


// obrazek na pozadi


if ($bgimage != "") {
	
	// div do ktereho se vykresluje obrazek
	
	$bgplocha = "<div id='bgimage' style='position: absolute; top: 100px; left: 10px; z-index: 10; width:100%; opacity: 0.4;'><img src=$bgimage width=1000><input type='hidden' value='' id='zaznamBody'></div>";
	$bgOpacity = "0.5";
}


// neni obrazek na pozadi


if ($bgimage == "") {
	$bgplocha = "";
	$bgOpacity = 1;
}

$i2 = "";
if (strlen($infopoznamka) != 0) $i2 = "<br><b>$infopoznamka</b>";

	// obrazek + editor

	if (@$_GET['editor'] != "skladacka" && $rozmery != ""){
		$time = time();
		TEST_CAD($doklad);
		$rok_doklad = ROK($doklad);	// pokud neni adresar, vytvori jej a vrati hodnotu roku nabidky

		echo "
		<div id='kontejner_stred' style='background: none;'>
			<div id='errmsg'></div>
			<h1>".G_STRECHY_TITHLAVNI01." $doklad - ".G_STRECHY_TITHLAVNI02."</h1>
				<div id='infotext'>$infotext $i2</div>
				$bgplocha
				<div id='kresleni' style='z-index: 15; opacity: $bgOpacity;'>
					";
					
					if ($bgimage == "") echo "<img src='../".$_SESSION['db_klient']."/cad/".$rok_doklad."/".$doklad."/".$doklad."_".$rozmery.".png?time=$time' id=obrazek>";

		echo "
				</div>
		</div>
		";
	}
	
	// 2d editor
	if (@$_GET['editor'] == "skladacka"){

		echo "
		<div id='kontejner_stred' style='background-color: white;'>
			<div id='errmsg'></div>
			<h1>".G_STRECHY_TITHLAVNI01." $doklad - ".G_STRECHY_TITHLAVNI02." v2.0</h1>
		";
			
		// prekreslim vsechny plochy do obrazku a zobrazim v plovoucich divech

		$sql = "select * from `$tab_objekty_index` where doklad = '$doklad'";
		$res = PROVEST ($sql);

		$i = 0;
		$java = "";
		$java2 = "";
		while ($row = mysql_fetch_array($res)){
			// vykreslim obrazek
			$id = $row['id'];
			$nazev = $row['nazev'];

			$zaznam_x = $row['2d_x'];
			$zaznam_y = $row['2d_y'];
			$zaznam_uhel = $row['2d_uhel'];
			$zobraz = $row['2d_zobraz'];

			nactibody_2d($id,$pome2d);
			otocbody($zaznam_uhel);
			max_body();

			$pocetbodupulka = count($body)/2;
			$pocetbodu = count($body);
			$x = $xmax - $xmin;
			$y = $ymax - $ymin;

			// prepocita body ( otoci Y )
			for ($xi = 0; $xi < count($body); $xi+=2){
				$body[$xi] = $body[$xi];
				$body[$xi+1] = $y-($body[$xi+1]);
			}

			$image = imagecreatetruecolor($x+5, $y+5);
			$barva_pozadi = imagecolorallocate($image, 255, 255, 255);	// zobrazeny pas s pruhlednosti
			$barva_plocha = imagecolorallocate($image, 0, 0, 0);			// barva plochy objektu
			$barva_cerna = imagecolorallocate($image, 0, 0, 0);
			
			//$barva_cerna = imagecolorallocate($image, 0, 0, 0);				// cerna je cerna

			imagefilledrectangle($image, 0, 0, $x+5, $y+5, $barva_pozadi);		// vyplni pozadi
			
			if ($pocetbodupulka > 2) {
					imagepolygon($image, $body, $pocetbodupulka, $barva_cerna);			// nakresli obrys zakladniho tvaru
			} else {
					echo "<div style='text-align: center; color: red;'>".G_STRECHY_PLOCHA." : $nazev ".G_STRECHY_MALOBODU."</div>";
			}

			$box = imagettfbbox(14, $zaznam_uhel, FONT, $nazev);
			$sirkatextu = $box[2] - $box[0];

			$vyskatextu = $box[7] - $box[1];
			$xtxt = (($x - $sirkatextu) / 2);
			$ytxt = (($y - $vyskatextu) / 2);
			
			TEST_CAD($doklad);			
			$rok_doklad = ROK($doklad);	// pokud neni adresar, vytvori jej a vrati hodnotu roku nabidky
		
			ImageTTFText ($image, 14, $zaznam_uhel, $xtxt, $ytxt, $barva_cerna, FONT, $nazev);			// textovy popisek modulu
			imagepng($image,"../".$_SESSION['db_klient']."/cad/2d/".$rok_doklad."/".$doklad."/".$doklad."_".$id.".png");                // vypocita rozmery jednotlivych bodu a zobrazi rozmery
			imagedestroy($image);

			if ($zobraz == 1) $display = "block";
			if ($zobraz == 0) $display = "none";

			echo "<div id='dr$id' style='position: absolute; display: $display; width: ".(($x / $pome2d)+5)."px; height: ".(($y/$pome2d)+5)."px; opacity: 0.6; top: $zaznam_y; left: $zaznam_x'>\n";
			
			$time = time();
			echo "<img src='../".$_SESSION['db_klient']."/cad/2d/".$rok_doklad."/".$doklad."/".$doklad."_".$id.".png?time=$time'><span style='position: absolute; left: 0px; right: 0px; width: 20px; height: 20px;'><a href='system_strechy.php?doklad=$doklad&rozmery=$id&akce=prepocitat'><img src='grafika/cad/edit_div.gif'></a></span><br>\n";
			echo "</div>\n";

			$java2 = $java2 . " $( \"#dr$id\" ).draggable({ containment: \"#kontejner_stred\", scroll: false,cursor: \"move\", stop: function() {\n";
			$java2 = $java2 . " $('form#pozice').submit(); }";
			$java2 = $java2 . "});\n";
			$java2 = $java2 . "$(\"#dr$id\").mousemove(function(e){\n";
			$java2 = $java2 . "\tvar p$id = $(\"#dr$id\");\n";
			$java2 = $java2 . "\tvar position = p$id.position();\n";
			$java2 = $java2 . "\t$(\"#drform_".$id."_x\").val(position.left);\n";
			$java2 = $java2 . "\t$(\"#drform_".$id."_y\").val(position.top);\n";
			$java2 = $java2 . "\t$(\"#drform_".$id."_nazev\").removeClass().addClass(\"tablevyber\");\n";
			$java2 = $java2 . "}).mouseout(function(){\t$(\"#drform_".$id."_nazev\").removeClass();});\n\n";

			$i++;
		}
	}
	
	if (isset($java2)){
	?>

    <script>
		$(function() {
			<?= $java2;?>
		});
    	document.getElementById("<?=@$_GET['focus'];?>").focus();
    	document.getElementById("<?=@$_GET['focus'];?>").select();
    </script>

	<?
	}
	
	
echo "</div>";	// plocha
echo "</div>";	// kontejner stred

// kresleni osy

echo "<div id='osa_svisla'></div><div id='popisek'></div><div id='osa_vodorovna'></div>";
echo "<div id=editmenu onmouseout=skryjmenu();  onmouseover=resetuj();></div>";

?>

<script>
/*
	$(function() {
			if($.cookie('ox') != null){
				$('.ui-dialog').css('left', $.cookie('ox'));
			}else{
				$('.ui-dialog').css('left', '50px');
			}

			if($.cookie('oy') != null){
				$('.ui-dialog').css('top', $.cookie('oy'));
			}else{
				$('.ui-dialog').css('top', '100px');
			}
	});
*/

	/* uprava osy X */
	
	document.getElementById("osa_vodorovna").style.width = "<? echo ($x_obr+235);?>px";
	document.getElementById("osa_svisla").style.height = "<? echo $y_obr;?>px";

	$("#smazBTN").click(function () {
		$("#smazatConfirm").load("system_strechy_smazatPlochu.php?id=<? echo $id;?>&doklad=<? echo $doklad;?>", function() {
			$("#smazatConfirm").slideToggle("slow");
		});
	});

	
</script>

<?
$_GET['chatstop'] = 1;

include ("include/src/konec.php");
include ("include/src/zavritdb.php");
?>
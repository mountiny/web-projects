<?php session_start()?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kontrola testovacího formuláře</title>
</head>
<body>
<?php
if (isset($_SESSION['string']))
{
if( $_SESSION['string'] == $_POST['kod'] )
{
  echo 'Byl vložen správný kód <br>';
$adresat = "prodejna@cyklosportchropyne.cz,vladimir.rm@seznam.cz";
$predmet = "Přihláška dětské závody Chropyně 2014";
/* Přicházejí proměnné $body, $name, $subject, $mail, $poznamka, $stylelink, $dalsipole */
    ?>
<?
if( !($jmeno && $prijmeni && $obec && $psc && $rn)) {
    ?><h2>Prázdné některé pole</h2>
<p> Prosím o vyplnění všech údajů.</p>
<? } else {
if($odrazedlo) {
	$kategorie = A;
}
else if ($rn >= 2010) {
	$kategorie = B;
}
else if ($rn >= 2008) {
	$kategorie = C;
}
else if ($rn >= 2006) {
	$kategorie = D;
}
else if ($rn >= 2004) {
	$kategorie = E;
}
else if ($rn >= 2002) {
	$kategorie = F;
}
else {
	$kategorie = G;
}
if(@Mail($adresat, $predmet, StripSlashes($body)."\n".$jmeno."\n".$prijmeni."\n".$obec."\n".$psc."\n".$klub."\n".$rn."\n".$kategorie."\n".$mail.">", "from: $name <$mail>")) {
echo "<h2>Přihláška byla odeslána</h2>";
}
    else { ?>
<!-- generuje se nový formulář pro odeslání přes klienta --><h2>Přihlášku se nepodařilo odeslat. </H2><p> Pravděpodobně blbne SMTP server. Omlouváme se.</p><form action="mailto:<? echo $adresat; ?>" method=post enctype="text/plain"> <input type="hidden" name="jmeno" value="<? echo $jmeno; ?>" > <input type="hidden" name="prijmeni" value="<? echo $prijmeni; ?>" > <input type="hidden" name="ulice" value="<? echo $ulice; ?>" > <input type="hidden" name="cislo" value="<? echo $cislo; ?>" > <input type="hidden" name="obec" value="<? echo $obec; ?>" > <input type="hidden" name="psc" value="<? echo $psc; ?>" > <input type="hidden" name="klub" value="<? echo $klub; ?>" > <input type="hidden" name="rodne cislo" value="<? echo $rc; ?>" > <input type="hidden" name="umisteni" value="<? echo $umisteni; ?>" ><input type="submit" value="Zkusit znovu"> pomocí prohlížeče</form> Pokud se to ani napodruhé nepovedlo, zkopírujte si obsah a pošlete ho normální poštou. <br> <br>to:<? echo $adresat; ?> <br>subject:<?echo "Přihláška dětské závody Chropyně 2014"; ?> <br> <br>
<? echo $body; } } /* Uzavírá se podmínka o poslání přes server a o prázdnosti polí */ ?> <br> 
<a href="http://www.cyklosportchropyne.cz/detskezavody/files/prihlaskadz2014/formular.php">Zpět na formulář</a> <br><br>
<a href="http://www.cyklosportchropyne.cz/">Zpět na stránky</a>
<? 
  
  ;
}
else
{
  echo 'Zadal jste špatný kód <br>';

 Echo '<a href="http://www.cyklosportchropyne.cz/detskezavody/files/prihlaskadz2014/formular.php"> Jej, zkusím to znova </a>';

}
}
 ?>

 
</body>

</html>
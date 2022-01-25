<?php
session_start();
if (!isset($_GET['generuj'])) {
for ($i=0;$i<5;$i++)
{
	while(strlen($str[$i])!=1){
	$random=rand(48,123);
	if( ($random>47 && $random<58) || ($random>96 && $random<123)  ||
    ($random>64 && $random<91)  ){
	   $str[$i] = chr($random);
    }
  }
  $text .= $str[$i];
 }
$_SESSION['string']= $text;
$GLOBALS['text'] = $text;
}
elseif  (isset($_GET['generuj'])){
  $GLOBALS['text'] = $_SESSION['string'];
  $obrazek = imagecreatefrompng("background.png");
  for ($i=0; $i<5; $i++){
  $textcolor = imagecolorallocate($obrazek,rand(0,130),rand(0,130),rand(0,130));
  $pismenko = substr($GLOBALS['text'],0+$i,1);
  imagettftext ($obrazek,rand(15,25),rand(-45,45),15+($i*38),35, $textcolor,"FreeSerif.ttf",$pismenko) ;
}
header("Content-type: image/png");
imagepng($obrazek);
imagedestroy ($obrazek);
exit();
};
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?> '; ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2000/REC-xhtml1-20000126/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cz">
<head>
<link rel="stylesheet" type="text/css" href="http://www.cyklosportchropyne.cz/cyklosport.css">
<meta http-equiv="content-language" content="cz" />
<meta name="language" content="cz" />
<meta name="document-language" content="cz" />
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-2" />
<title> Přihláška na dětské závody Chropyně 2014</title>
</head>
<body>
<div id=obsah>
<form method="post" action="kontrola.php">
<h2>Přihláška na dětské závody Chropyně 2014</h2>
<table border="0" cellpadding="6" cellspacing="0" width="60%">
<tr> <td> <b>Jméno:</b></td> <td> <input type="text" name="jmeno" size="20"></td> <td> <b>Příjmení:</b></td> <td> <input type="text" name="prijmeni" size="20"></td></tr>
<tr> <td> <b>Obec:</b></td> <td> <input type="text" name="obec" size="20"></td> <td> <b>PSČ:</b></td> <td> <input type="text" name="psc" size="3"></td></tr>
<tr> <td> Klub</td> <td> <input type="text" name="klub" size="20"></td> <td> <b>Rok narození</b></td> <td> <input type="text" name="rn" size="10"></td></tr>
<tr> <td> Váš e-mail:</td> <td> <input type="email" name="mail" size="20" value="@"></td> <td> Odrážedlo: </td> <td> <input type="checkbox" name="odrazedlo"> </td> </tr>
<!--<td> <b>Kategorie</b></td> <td> <select name="kategorie" size="1"> <option value="junioři"> junioři <option value="M 19-29"> M - muži 19-29 <option value="MI 29-39"> MI - muži 30-39 <option value="MII 39-49"> MII - muži 40-49 <option value="MIII 50-59"> MIII - muži 50-59 <option value="MIV 60 a starší"> MIV - muži 60 a starší <option value="ženy I 35 a méně"> ženy I 35 a méně <option value="ženy II 36 a více"> ženy II 36 a více</select></td> --!>

<tr> <td colspan="4"> Tučné nutno vyplnit !!!</td></tr>

<tr><td colspan="4">Propozice beru na vědomí a závodu se zúčastním na vlastní nebezpečí. Seznámil(a) jsem se s bezpečnostními předpisy, které se zavazuji dodržovat. Prohlašuji,že jsem si vědom(a) toho, že nesu veškerou zodpovědnost za škodu způsobenou na zdraví nebo věcech, která vznikne mně, pořadateli nebo třetím osobám před, během či po závodě. Budu dodržovat pravidla fair-play, budu se chovat šetrně k přírodě a veškerý odpad přivezu do cíle nebo ho zanechám v občerstvovacích stanicích a u pořadatelů na trati. Plná přilba povinná. Zadáním e-mailové adresy souhlasím se zasíláním informací souvisejících se závodem.</td></tr>
</table> <img src = "formular.php?generuj" alt="code" id="captcha"/> <br/> <br/> Opiš kód: <input type="text" name="kod" size="24"/> (nutno vyplnit zvýrazněné znaky) <br/> <br/> 
<input type="submit" value="Odeslat" name="odeslat"/> <button  id="reset"/>Obnovit</button><hr><p> Pořadatel se zavazuje, že Vaše osobní údaje neposkytne třetí osobě a zajistí jejich ochranu v souladu se zákonem č. 101 / 2000 Sb., o ochraně osobních údajů.</p></form></div><div id=hlavicka>
<!--<script type="text/javascript">
	document.getElementById('reset').onclick= function() {
        var captcha = document.getElementById('captcha');
        captcha.src = formular.php?generuj;
    };
</script>--!>
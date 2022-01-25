<?php
include "database.php";
?>
<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cyklosport Chropyně</title>
    <meta name="Description" CONTENT="Kalendář závodů a výsledky oddílu.">
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

</head>

<body class="oddil-page">

    <div class="oddil-cont">
        <div class="oddil-list">
            <a href="./index.html" class="back_home_right">
                <img src="img/back_right.png" alt="" class="back_img_right">
            </a>
            <!-- členové -->
            <div class="cat-head expand-anchor" id="clenove-head">
                <!-- <img src="img/plus.png" alt=""> -->
                <a href="" data-target="clenove">
                    <span>Členové</span></a>
            </div>
            <div class="cat-body" id="clenove-body">
              <?php

function t1($val, $min, $max)
{
    return ($val >= $min && $val <= $max);
}

$connection = mysqli_connect("$host", "$username", "$password", "$db_name")or die("cannot connect to database");
$connection->set_charset("utf8");

$sql = "SELECT name, year, race, sex FROM clenove ORDER BY `name` ASC";
$result = $connection->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $m1416 = t1(date('Y') - intval($row["year"]), 14, 16);
        $m1718 = t1(date('Y') - intval($row["year"]), 17, 18);
        $m1923 = t1(date('Y') - intval($row["year"]), 19, 23);
        $m2429 = t1(date('Y') - intval($row["year"]), 24, 29);
        $m3039 = t1(date('Y') - intval($row["year"]), 30, 39);
        $m4049 = t1(date('Y') - intval($row["year"]), 40, 49);
        $m5059 = t1(date('Y') - intval($row["year"]), 50, 59);
        $m6069 = t1(date('Y') - intval($row["year"]), 60, 69);
        $m70 = t1(date('Y') - intval($row["year"]), 70, 100);
        $cat = "";
        if ($m1416) {
            $cat = $row["sex"]."14-16";
        } elseif ($m1718) {
            $cat = $row["sex"]."17-18";
        } elseif ($m1923) {
            $cat = $row["sex"]."19-23";
        } elseif ($m2429) {
            $cat = $row["sex"]."24-29";
        } elseif ($m3039) {
            $cat = $row["sex"]."30-39";
        } elseif ($m4049) {
            $cat = $row["sex"]."40-49";
        } elseif ($m5059) {
            $cat = $row["sex"]."50-59";
        } elseif ($m6069) {
            $cat = $row["sex"]."60-69";
        } elseif ($m70) {
            $cat = "Mladík";
        }

        echo $row["name"].'&nbsp;&nbsp;&nbsp;&nbsp;'.($row["race"]=="TRUE" ? $cat : "")."<br>";
    }
}

$connection->close();

                ?>
            </div>
            <!-- kalendář -->
            <div class="cat-head" id="kalendar-head">
                <!-- <img src="img/plus.png" alt=""> -->
                <a href="files/csch_terminovka_2021.pdf" target="_blank">
                    <span>Kalendář</span></a>
            </div>
            <!-- <div class="cat-body" id="kalendar-body" style="padding-left:0px;">
            <a href="../files/term2018.pdf" target="_blank">Kalendář ve formátu PDF</a>
            

            </div> -->
            <!-- výsledky -->
            <div class="cat-head" id="vysledky-head">
                <!-- <img src="img/plus.png" alt=""> -->
                <span>Výsledky</span>:<br>
                &nbsp;&nbsp;&nbsp;<a href="../files/csch2021.pdf" target="_blank">
                    <span>Veškeré</span></a><br>
                    &nbsp;&nbsp;&nbsp;<a href="../files/nc2021.pdf" target="_blank">
                    <span>Prima Cup</span></a><br>
                    &nbsp;&nbsp;&nbsp;<a href="../files/kpz2021.pdf" target="_blank">
                    <span>KPŽ</span></a><br>
                    &nbsp;&nbsp;&nbsp;<a href="../files/kpzhobby2021.pdf" target="_blank">
                    <span>KPŽ hobby</span></a>
            </div>
            <!-- <div class="cat-body" id="vysledky-body" style="padding-left:0px;">
            <a href="../files/csch2018.pdf" target="_blank">Výsledky ze všech závodů ve formátu PDF</a><br><br>
            <a href="../files/kpz2018.pdf" target="_blank">Výsledky z KPŽ ve formátu PDF</a>
              
            </div> -->
        </div>
        <img src="img/red_blur.png" alt="" class="red-blur">
        <div class="oddil-title">
            <div class="oddil-text">oddíl</div>
            <img src="img/dots.png" alt="">
        </div>
        <div class="pics-cont">
            <a href="https://www.psg.cz" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_psg.svg" alt="PSG" />
            </a>
            <a href="https://www.muchropyne.cz" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_m_chropyne.svg" alt="Město Chropyně" />
            </a>
            <a href="https://www.optikafenix.cz" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_optikafenix.svg" alt="Optika Fénix" />
            </a>
            <a href="https://www.cyklosportchropyne.cz" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_starcomm.svg" alt="Starcomm" />
            </a>
            <a href="https://www.elmo.cz" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_elmo.svg" alt="Elmo" />
            </a>
            <a href="https://www.mechanix.com/us-en/" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_mechanix.svg" alt="Mechanix" />
            </a>
            <a href="https://www.elins.cz" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_elins.svg" alt="Elins" />
            </a>
            <a href="https://www.kmotr.cz" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_krahulik_kmotr.svg" alt="Kmotr" />
            </a>
            <a href="https://www.cyklosportchropyne.cz" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_andyinstal.svg" alt="Andy Instal" />
            </a>
            <a href="https://www.cyklosportchropyne.cz" target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_esco.svg" alt="Esco" />
            </a>
            <a href="https://www.ktm-bikes.at"target="_blank" class="pic-link">
              <img src="img/oddil/partner_22_ktm.svg" alt="KTM" />
            </a>
          
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
        $("img.back_img_right").toggleClass("show");
            $("div.oddil-cont").toggleClass("show");
            $("footer").toggleClass("show");
      });
        $(document).ready(function () {

            // $("img.back_img_right").toggleClass("show");
            // $("div.oddil-cont").toggleClass("show");
            // $("footer").toggleClass("show");

            $(".expand-anchor a").click(function (e) {
                e.preventDefault();
                $(this).toggleClass("open");
                var target = "#" + $(this).data("target") + "-body";
                $(target).toggleClass("open");
            })
            $("div.oddil-text").click(function (e) {
                e.preventDefault();
                window.location.href = "./index.html"
            })
        })
    </script>

</body>

</html>
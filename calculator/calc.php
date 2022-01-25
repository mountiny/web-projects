<?php

$arrMena = "CZK;EUR;USD";
$arrKurz = "1;27.02;20.52"

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Calculator</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" src="jquery-3.1.1.min.js"></script>
</head>
<body>
	<div id="calc">
		<div id="top">
			<div class="equation">
				<span contenteditable="true" id="equation"></span>
				<span class="cur-code" id="cur-code-from">
					EUR
				</span>
			</div>
			<div class="result">
				<span id="result">0</span>

				<span class="cur-code" id="cur-code-to">
					CZK
				</span>
			</div>
		</div>
		<div id="keys">

			<!-- FIRST ROW -->

			<span class="keybox">
				<span class="key keyhalf">
					AC
				</span>
				<span class="key keyhalf" id="butdel">
					C
				</span>
			</span>
			<!-- <span class="key">
			(
			</span>
			<span class="key">
			)
			</span> -->
			<span class="currency key" id="cur-from">
				from<br>
				<select id="cur-from-sel">
					<?php 
						foreach (explode(";", $arrMena) as $key => $value) {
							echo "<option value='$value'>$value</option>";
						}
					?>
				</select>
				<!-- <span class="keyhalf">
					from
				</span>
				<span class="keyhalf">
					CZK
				</span> -->
			</span>
			<span class="currency key" id="cur-to">
				to<br>
				<select id="cur-to-sel">
					<?php 
						foreach (explode(";", $arrMena) as $key => $value) {
							echo "<option value='$value'>$value</option>";
						}
					?>
				</select>
			</span>
			<span class="key" id="butdiv">
			÷
			</span>

			<!-- FIRST ROW -->

			<span class="key number" id="but7">
			7
			</span>
			<span class="key number" id="but8">
			8
			</span>
			<span class="key number" id="but9">
			9
			</span>
			<span class="key" id="butx">
			x
			</span>

			<!-- SECOND ROW -->

			<span class="key number" id="but4">
			4
			</span>
			<span class="key number" id="but5">
			5
			</span>
			<span class="key number" id="but6">
			6
			</span>
			<span class="key" id="butmin">
			-
			</span>

			<!-- THIRD ROW -->

			<span class="key number" id="but1">
			1
			</span>
			<span class="key number" id="but2">
			2
			</span>
			<span class="key number" id="but3">
			3
			</span>
			<span class="key" id="butplus">
			+
			</span>

			<!-- FOURTH ROW -->

			<span class="key number" id="but0">
			0
			</span>
			<span class="key" id="butdec">
			,
			</span>
			<span class="key" id="butper">
			%
			</span>
			<span class="key" id="buteq">
			=
			</span>
		</div>
		
	</div>
	<script type="text/javascript">
		
	$(document).ready(function(){

		var eqBox = $("#equation");
		var resBox = $("#result");
		var eq = "";
		var res = "";
		var op = 0;
		var opArray = ["+","-","x","÷","/","*"];
		var forbArray = ["+","-","x","÷","/","*"];
		var last = "";

		var mena = <? echo json_encode($arrMena);?>;
    	var kurz = <? echo json_encode($arrKurz);?>;
    	var arrMena = mena.split(";");
    	var arrKurz = kurz.split(";");

		$(".key").click(function(){
			eq = eqBox.text();
			btnVal = $.trim($(this).text());
			if (btnVal === "AC") {
				eq = "";
				res = "0";
				resBox.text(res);
				$("#cur-code-to").css("display","none");
				$("#cur-code-from").css("display","none");
			} else if (btnVal === "C") {
				if (eq.length > 0) {
					eq = eq.slice(0,-1);
				}
			} else if (btnVal === "%") {

				$("#buteq").click();
				if (resBox.text() != 0) {
					if (res <= 1 && res >= -1) {
						res = res * 100;
						if (decimalPlaces(res) > 4) {
							res = res.toFixed(2);
						}
						res += " %";
						resBox.text(res);
						$("#cur-code-to").css("display","none");
						$("#cur-code-from").css("display","none");
					}
				}
			} else if (btnVal === "=") {
				
				if ($.inArray(eq.substr(eq.length - 1), opArray) > -1) {
					eq = eq.slice(0,-1);
				}

				res = eval(eq);
				if (decimalPlaces(res) > 4) {
					res = res.toFixed(4);
				}
				resBox.text(res);
				$("#cur-code-to").css("display","none");
				$("#cur-code-from").css("display","none");

				if (res > 1000000) {
					$("#result").css("fontSize", "16px");
				}

			} else if (btnVal === ",") {
				if (eq.length == 0) {
					eq += "0";
				}
				if (eq.substr(eq.length - 1) !== ".") {
					eq += ".";
				}
			} 
				// OPERATORS
			else if (btnVal === "-") {
				if ($.inArray(eq.substr(eq.length - 1), ["-","+"]) == -1) {
				
							eq += "-";
				}
			}
			else if ($.inArray(btnVal, opArray) > -1) { 
				if ($.inArray(eq.substr(eq.length - 1), opArray) == -1) {
				
					if (eq.length == 0) {
						if (btnVal === "-") {
							eq += "-";
						}
					} else {
						if (btnVal === "+") {
							eq += "+";
						} else if (btnVal === "-") {
							eq += "-";
						} else if (btnVal === "x") {
							eq += "*";
						} else if (btnVal === "÷") {
							eq += "/";
						} else {

						}
					}
				}
			} 
			// else if (btnVal === "(") {
			// 	eq += "(";
			// 	op++;
			// } else if (btnVal === ")") {
			// 	if (op == 0) {

			// 	} else if(eq.substr(eq.length - 1) === "(") {

			// 	} else {
			// 		eq += ")";
			// 		op--;
			// 	}
			// } 
			else if ($(this).attr("id") == "cur-from") {

			}
			else if ($(this).attr("id") == "cur-to") {

			}

			else {
				eq += btnVal;
			}

			if (eq.length > 19) {
				$("#equation").css("fontSize", "12px");
			} else {
				$("#equation").css("fontSize", "14px");
			}

			eqBox.text(eq);

		})
		$("#cur-to").click(function(){
			if (eq == "") {
				return;
			}

			var iKurzTo = $.inArray($("#cur-to-sel").val(), arrMena);
			var exchangeTo = arrKurz[iKurzTo];
			if (exchangeTo == 1) {
				var iKurzFrom = $.inArray($("#cur-from-sel").val(), arrMena);
				var exchangeFrom = arrKurz[iKurzFrom];
			} else {
				$("#cur-from-sel").val("CZK");
				var iKurzFrom = $.inArray($("#cur-from-sel").val(), arrMena);
				var exchangeFrom = arrKurz[iKurzFrom];
			}

			$("#cur-code-to").text($("#cur-to-sel").val()).css("display","block");
			$("#cur-code-from").text($("#cur-from-sel").val()).css("display","block");
			
			var fromInCZK = eval(eq)*(exchangeFrom);
			var res = fromInCZK/exchangeTo;			

			if (decimalPlaces(res) > 5) {
				res = res.toFixed(3);
			}
			resBox.text(res);
		})
		$("#cur-from").click(function(){
			if (eq == "") {
				return;
			}

			var iKurzFrom = $.inArray($("#cur-from-sel").val(), arrMena);
			var exchangeFrom = arrKurz[iKurzFrom];
			if (exchangeFrom == 1) {
				var iKurzTo = $.inArray($("#cur-to-sel").val(), arrMena);
				var exchangeTo = arrKurz[iKurzTo];
			} else {
				$("#cur-to-sel").val("CZK");
				var iKurzTo = $.inArray($("#cur-to-sel").val(), arrMena);
				var exchangeTo = arrKurz[iKurzTo];
			}

			$("#cur-code-from").text($("#cur-from-sel").val()).css("display","block");
			$("#cur-code-to").text($("#cur-to-sel").val()).css("display","block");

			var fromInCZK = eval(eq)*(exchangeFrom);
			var res = fromInCZK/exchangeTo;

			if (decimalPlaces(res) > 5) {
				res = res.toFixed(3);
			}

			resBox.text(res);
		})

		$("#cur-to-sel").change(function(){
			if (eq == "") {
				return;
			}

			// alert($(this).val());
			// $("#cur-code-to").text($(this).val()).css("display","block");
			// $("#cur-code-from").text($("#cur-from-sel").val()).css("display","block");
			var iKurzTo = $.inArray($(this).val(), arrMena);
			var exchangeTo = arrKurz[iKurzTo];
			if (exchangeTo == 1) {
				var iKurzFrom = $.inArray($("#cur-from-sel").val(), arrMena);
				var exchangeFrom = arrKurz[iKurzFrom];
			} else {
				$("#cur-from-sel").val("CZK");
				var iKurzFrom = $.inArray($("#cur-from-sel").val(), arrMena);
				var exchangeFrom = arrKurz[iKurzFrom];
			}

			$("#cur-code-to").text($(this).val()).css("display","block");
			$("#cur-code-from").text($("#cur-from-sel").val()).css("display","block");
			// var iKurzFrom = $.inArray($("#cur-from-sel").val(), arrMena);
			// var exchangeFrom = arrKurz[iKurzFrom];
			// alert("from: " + exchangeFrom + " to: " + exchangeTo);
			
			var fromInCZK = eval(eq)*(exchangeFrom);
			var res = fromInCZK/exchangeTo;

			// if ($(this).val() == "CZK") {
			// 	res = eval(eq)*(exchangeFrom);
			// } else if ($("#cur-from-sel").val() == "CZK") {
			// 	res = eval(eq)*(exchangeFrom/exchangeTo);
			// } else {
			// 	res = eval(eq)*(exchangeTo/exchangeFrom);
			// }

			

			if (decimalPlaces(res) > 5) {
				res = res.toFixed(3);
			}
			resBox.text(res);

		})
		$("#cur-from-sel").change(function(){
			if (eq == "") {
				return;
			}

			// alert($(this).val());
			// $("#cur-code-from").text($(this).val()).css("display","block");
			// $("#cur-code-to").text($("#cur-to-sel").val()).css("display","block");


			// var iKurzTo = $.inArray($("#cur-to-sel").val(), arrMena);
			// var exchangeTo = arrKurz[iKurzTo];
			var iKurzFrom = $.inArray($(this).val(), arrMena);
			var exchangeFrom = arrKurz[iKurzFrom];
			if (exchangeFrom == 1) {
				var iKurzTo = $.inArray($("#cur-to-sel").val(), arrMena);
				var exchangeTo = arrKurz[iKurzTo];
			} else {
				$("#cur-to-sel").val("CZK");
				var iKurzTo = $.inArray($("#cur-to-sel").val(), arrMena);
				var exchangeTo = arrKurz[iKurzTo];
			}

			$("#cur-code-from").text($(this).val()).css("display","block");
			$("#cur-code-to").text($("#cur-to-sel").val()).css("display","block");

			var fromInCZK = eval(eq)*(exchangeFrom);
			var res = fromInCZK/exchangeTo;

			// if ($(this).val() == "CZK") {
			// 	res = eval(eq)*(exchangeFrom/exchangeTo);
			// } else {
			// 	res = eval(eq)*(exchangeFrom/exchangeTo);
			// }
			// alert("from: " + exchangeFrom + " to: " + exchangeTo);

			if (decimalPlaces(res) > 5) {
				res = res.toFixed(3);
			}

			resBox.text(res);
		})
		
		function decimalPlaces(number) {
		  // toFixed produces a fixed representation accurate to 20 decimal places
		  // without an exponent.
		  // The ^-?\d*\. strips off any sign, integer portion, and decimal point
		  // leaving only the decimal fraction.
		  // The 0+$ strips off any trailing zeroes.
		  return ((+number).toFixed(20)).replace(/^-?\d*\.?|0+$/g, '').length;
		}
		$(document).keydown(function(e) {

			switch(e.which) {
		        case 48:
		        case 96: // 0
		        	$("#but0").click();
		        break;
		        case 49:
		        case 97: // 1
		        	$("#but1").click();
		        break;
		        case 50:
		        case 98: // 0
		        	$("#but2").click();
		        break;
		        case 51:
		        case 99: // 0
		        	$("#but3").click();
		        break;
		        case 52:
		        case 100: // 0
		        	$("#but4").click();
		        break;
		        case 53:
		        case 101: // 0
		        	$("#but5").click();
		        break;
		        case 54:
		        case 102: // 0
		        	$("#but6").click();
		        break;
		        case 55:
		        case 103: // 0
		        	$("#but7").click();
		        break;
		        case 56:
		        case 104: // 0
		        	$("#but8").click();
		        break;
		        case 57:
		        case 105: // 0
		        	$("#but9").click();
		        break;
		        case 110:
		        case 190: // ./,
		        	$("#butdec").click();
		        break;
		        case 191:
		        case 111: // /
		        	$("#butdiv").click();
		        break;
		        case 107: // +
		        	$("#butplus").click();
		        break;
		        case 106: // *
		        	$("#butx").click();
		        break;
		        case 189:
		        case 109: // -
		        	$("#butmin").click();
		        break;
		        case 13:
		        case 187: // =
		        	$("#buteq").click();
		        break;
		        case 8: // del
		        	$("#butdel").click();
		        break;

		        default: return; // exit this handler for other keys
		    }
		    e.preventDefault(); // prevent the default action (scroll / move caret)

	    
		});


	})

	</script>
</body>
</html>
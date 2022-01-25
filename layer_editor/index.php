<!DOCTYPE html>
<html>
<head>
	<title>Layer Editor</title>
	<script type="text/javascript" src="script/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="script/draggabilly.pkgd.min.js"></script>
	<script type="text/javascript" src="script/jquery-ui.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link rel="stylesheet" type="text/css" href="styles/jquery-ui.min.css">
</head>
<body>

	<div class="main-cont">
		<div class="menu">
			<a href="" class="menu-item" id="saveLayout">ULOŽIT</a>
		</div>
		<div class="container">
			
			<div class="draggable">
				<div class="div-head">
					<a href="" class="div-head-item">ID</a>
					<a href="" class="div-head-item">JMÉNO</a>
					<a href="" class="div-head-item">X</a>
				</div>
				<div class="div-cont">
					<div class="handle">
						Div1
					</div>
				</div>
			</div>
			<div class="draggable">
				<div class="div-head">
					<a href="" class="div-head-item">ID</a>
					<a href="" class="div-head-item">JMÉNO</a>
					<a href="" class="div-head-item">X</a>
				</div>
				<div class="div-cont">
					<div class="handle">
						
					</div>
				</div>
			</div>
			<div class="draggable">
				<div class="div-head">
					<a href="" class="div-head-item">ID</a>
					<a href="" class="div-head-item">JMÉNO</a>
					<a href="" class="div-head-item">X</a>
				</div>
				<div class="div-cont">
					<div class="handle">
						
					</div>
				</div>
			</div>
		</div>
		<div class=""></div>
	</div>

<script type="text/javascript">
	var $draggable = $('.draggable').draggabilly({
	  containment: '.container',
	  handle: '.handle',
	  grid: [10,10]
	})
	$(document).ready(function(){
		$("#saveLayout").click(function(e){
			e.preventDefault();

			save();

		})
		$(".div-head-item").click(function(e){
			e.preventDefault();

		})

		$(".draggable").resizable({
			containment: '.container',
	  		grid: [10,10]
		})
		
		function save() {

			var fields = [];
			var divs = $(".draggable");
			for (var i = 0; i < divs.length; i++) {
				var name = divs.eq(i).find(".handle").text().trim();
				var width = divs.eq(i).css("width").slice(0, -2);
				var height = divs.eq(i).css("height").slice(0, -2);
				var top = divs.eq(i).css("top").slice(0, -2);
				var left = divs.eq(i).css("left").slice(0, -2);

				fields += [name,height,width,top,left];

				// var position = [parseInt(divs.eq(i).css("left").slice(0, -2)), parseInt(divs.eq(i).css("top").slice(0, -2))];
				// positions += position;
			}

			var toSend = JSON.stringify(fields);
			$.ajax({
				url: "saveLayer.php",
				type: "POST",
				dataType: "html",
				data: {data: toSend},
				success: function(data){
					$("#saveLayout").text(data);
					// $(".form-response").html(data);
					// $(".contactMe").find('#submitButton').prop('disabled', true);
					// setTimeout(function(){
					// 	$(".contactMe").find('#submitButton').prop('disabled', false);
					// }, 2000)
				}
			});

		}

	})

</script>
</body>
</html>
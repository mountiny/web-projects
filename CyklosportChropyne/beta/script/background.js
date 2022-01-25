function hasClass( elem, klass ) {
     		return (" " + elem.className + " " ).indexOf( " "+klass+" " ) > -1;
		}


	
	

		function myFunction() {
			
			// if (document.body.classList.contains('.no-touch')) {
				var x = Math.floor(Math.random() * 3);
		   	 	var paths = ["url('images/cyklo_masakr.jpg')", "url('images/tymova_sila.jpg')", "url('images/emoce.jpg')"];
		   	 	var redMottoArray = ["Cyklo<br>masakr","Týmová<br>síla","Emoce"];
		   	 	var whiteMottoArray = ["Neexistuje špatné počasí","Nebojíme se zaútočit","Baví nás to!"];
		   	 	var redMotto = redMottoArray[x];
		   	 	var whiteMotto = whiteMottoArray[x];
		    	var path = paths[x];
		    	var body = document.getElementsByTagName("body");
		    	body[0].style.backgroundImage = path;
		    	var redMottoDiv = document.getElementById("mottoRedId");
		    	var whiteMottoDiv = document.getElementById("mottoBlackId");
		    	redMottoDiv.innerHTML = redMotto;
		    	whiteMottoDiv.innerHTML = whiteMotto;
	
			// } else {

			// 	document.getElementById('intro').innerHTML = "<img src='images/bg.jpg' style='height: 100%; position:absolute; top:0; left:0; z-index:2; overflow:hidden;'></img>";

			// }								    
		}
		function myNotMainPageFunction() {
			
			// if (document.body.classList.contains('.no-touch')) {
				var x = Math.floor(Math.random() * 3);
		   	 	var paths = ["url('../images/cyklo_masakr.jpg')", "url('../images/tymova_sila.jpg')", "url('../images/emoce.jpg')"];
		   	 	
		    	var path = paths[x];
		    	var body = document.getElementsByTagName("body");
		    	body[0].style.backgroundImage = path;
	
		    	
			// } else {

			// 	document.getElementById('intro').innerHTML = "<img src='images/bg.jpg' style='height: 100%; position:absolute; top:0; left:0; z-index:2; overflow:hidden;'></img>";

			// }								    
		}
		
		function myMobileFunction() {
			var x = Math.floor(Math.random() * 3);
			var paths = ["url('images/cyklo_masakr.jpg')", "url('images/tymova_sila.jpg')", "url('images/emoce.jpg')"];
			var path = paths[x];
		    	var mobileBg = document.getElementById("mobileBg");
		    	mobileBg.style.backgroundImage = path;
			var redMottoArray = ["Cyklo<br>masakr","Týmová<br>síla","Emoce"];
		   	var whiteMottoArray = ["Neexistuje špatné počasí","Nebojíme se zaútočit","Baví nás to!"];
		   	var redMotto = redMottoArray[x];
		   	var whiteMotto = whiteMottoArray[x];
		   	var redMottoDiv = document.getElementById("mottoRedId");
		    var whiteMottoDiv = document.getElementById("mottoBlackId");
		    redMottoDiv.innerHTML = redMotto;
		    whiteMottoDiv.innerHTML = whiteMotto;
		    // if (x == 2) {
		    // 	mobileBg.style.backgroundPosition = "30% center";
		    // };
		    var phone = window.matchMedia("only screen and (min-device-width : 320px) and (max-device-width : 568px) and (orientation : portrait)");
		    if (phone && x == 1) {
		    	mobileBg.style.backgroundPosition = "20% center";
		    };


		}
		
		var html = document.getElementsByTagName("html");



		// if (hasClass(html[0], "no-touch")) {
		// 	window.onload = myFunction;
		// } else {
		// 	window.onload = myMobileFunction;
		// }
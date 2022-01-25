$(document).ready(function() {
var lastScrollTop = 0, delta = 100;

  $(window).scroll(function(event){
       var st = $(this).scrollTop();
       var nav = $(".no-touch nav.menu");
       var navT = $("nav.trigger");
       var scrolled = false;

       if(Math.abs(lastScrollTop - st) <= delta)
          return;

      if (st > 200) {

	       if (st > lastScrollTop){
	           // downscroll code
	           // console.log('scroll down');
	           if (scrolled) {
	           	// nav.removeClass("fallDown");
	           }
	           	nav.removeClass("menuDown");
	           // nav.toggleClass("menuDown");
	           // nav.addClass("fallUp");
	           // nav.css("top", "-50");
	       } else {
		          // upscroll code
		          // console.log('scroll up');
		          // nav.removeClass("fallUp");
		          // nav.addClass("fallDown");
		          nav.addClass("menuDown");
		          scrolled = true;
		          // nav.css("top", "0");
	       }
	      	 lastScrollTop = st;
      }
  });
});
$(document).ready(function() {
	$("nav.trigger").hover(function(){
		var nav = $(".no-touch nav.menu");
        var navT = $("nav.trigger");
        // nav.removeClass("fallUp");
        // nav.addClass("fallDown");
        // nav.css("top", "0");
        nav.addClass("menuDown");
	});
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
	};

});
$(window).load(function(){
	function showUpLogo() {
		// $(".no-touch nav.menu").addClass("fallDown");
		// $(".no-touch nav.menu").css("top", "0");
		$(".no-touch nav.menu").toggleClass("menuDown");
		$("nav.trigger").addClass("menuDown");
		// $("nav.trigger").css("top", "0");

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

				t3.removeClass("hidden");
				t3.addClass("displayed");
				t3.css("opacity", "0");

				t3.animate({
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
	function rotateThirdAds() {
		if (!neuplnaVlna) {
			f3.animate({

				opacity: 0,

			}, 500, function() {
				f3.removeClass("displayed");
				f3.addClass("hidden");
				f3.css("opacity", "1");

				f1.removeClass("hidden");
				f1.addClass("displayed");
				f1.css("opacity", "0");

				f1.animate({
					opacity: 1,
				}, 500, function() {
					setTimeout(rotateFirstAds, 2000);
				})
			});

			s3.animate({

				opacity: 0,

			}, 500, function() {
				s3.removeClass("displayed");
				s3.addClass("hidden");
				s3.css("opacity", "1");

				s1.removeClass("hidden");
				s1.addClass("displayed");
				s1.css("opacity", "0");

				s1.animate({
					opacity: 1,
				}, 500 )
			});

			t3.animate({

				opacity: 0,

			}, 500, function() {
				t3.removeClass("displayed");
				t3.addClass("hidden");
				t3.css("opacity", "1");

				t1.removeClass("hidden");
				t1.addClass("displayed");
				t1.css("opacity", "0");

				t1.animate({
					opacity: 1,
				}, 500 )
			});
			neuplnaVlna = true;
		} else {
			f3.animate({

				opacity: 0,

			}, 500, function() {
				f3.removeClass("displayed");
				f3.addClass("hidden");
				f3.css("opacity", "1");

				f1.removeClass("hidden");
				f1.addClass("displayed");
				f1.css("opacity", "0");

				f1.animate({
					opacity: 1,
				}, 500, function() {
					setTimeout(rotateFirstAds, 2000);
				})
			});

			s3.animate({

				opacity: 0,

			}, 500, function() {
				s3.removeClass("displayed");
				s3.addClass("hidden");
				s3.css("opacity", "1");

				s1.removeClass("hidden");
				s1.addClass("displayed");
				s1.css("opacity", "0");

				s1.animate({
					opacity: 1,
				}, 500 )
			});

			t4.animate({

				opacity: 0,

			}, 500, function() {
				t4.removeClass("displayed");
				t4.addClass("hidden");
				t4.css("opacity", "1");

				t1.removeClass("hidden");
				t1.addClass("displayed");
				t1.css("opacity", "0");

				t1.animate({
					opacity: 1,
				}, 500 )
			});
			neuplnaVlna = false;
		}

	}

	rotateFirstAds()
})
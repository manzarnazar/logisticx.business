/* ===================================================================

	Author          : Kazi Sahiduzzaman
	Template Name   : Rx - Courier Service
	Version         : 1.0

* ================================ ================================= */
(function ($) {
	"use strict";

	/* ========== Sticky menu Start======== */

	window.addEventListener("scroll", function () {
		const headers = document.querySelectorAll(".headerSticky");
		const scrollBtn = document.querySelector("#scrtop");
	
		headers.forEach((header) => {
			header.classList.toggle("sticky", window.scrollY > 300);
		});
	
		scrollBtn.classList.toggle("show", window.scrollY > 300);
	});


	/* ========== Sticky menu Ends======== */


	$(document).ready(function () {

		/* ==================================================
			Preloader Init
		===============================================*/

		$(window).on('load', function () {
			// Animate loader off screen
			$(".preloader").fadeOut("slow");
		});


		// footer image open
		function setImageSrc(src) {
			document.getElementById('modalImage').src = src;
		}

		/* ==================================================
			# menu active
		 =============================================== */

		/* ==================================================
			# Smooth Scroll
		 =============================================== */

		$('a.smooth-menu').on('click', function (event) {
			var $anchor = $(this);
			var headerH = '85';
			$('html, body').stop().animate({
				scrollTop: $($anchor.attr('href')).offset().top - headerH + "px"
			}, 1500, 'easeInOutExpo');
			event.preventDefault();
		});

		/* ==================================================
			# Circuler Progressbar
		 =============================================== */

		$('.chart').easyPieChart({
			size: 140,
			barColor: '#DF0A0A',
			scaleColor: false,
			lineWidth: 15,
			trackColor: '#f5f5f5'
		});

		/* ==================================================
			# imagesLoaded active
		===============================================*/

		$('.filter-active').imagesLoaded(function () {
			var $filter = '.filter-active',
				$filterItem = '.filter-item',
				$filterMenu = '.filter-menu-active';

			if ($($filter).length > 0) {
				var $grid = $($filter).isotope({
					itemSelector: $filterItem,
					filter: '*',
					masonry: {
						// use outer width of grid-sizer for columnWidth
						columnWidth: '.filter-item'
					}
				});

				// filter items on button click
				$($filterMenu).on('click', 'button', function () {
					var filterValue = $(this).attr('data-filter');
					$grid.isotope({
						filter: filterValue
					});
				});

				// Menu Active Class
				$($filterMenu).on('click', 'button', function (event) {
					event.preventDefault();
					$(this).addClass('active');
					$(this).siblings('.active').removeClass('active');
				});
			}
		})

		/* ==================================================
			# Magnific popup init
		 ===============================================*/

		$(".popup-link").magnificPopup({
			type: 'image',
			// other options
		});

		$(".popup-gallery").magnificPopup({
			type: 'image',
			gallery: {
				enabled: true
			},
			// other options
		});

		$(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
			type: "iframe",
			mainClass: "mfp-fade",
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});

		$("#videoLink").magnificPopup({
			type: "inline",
			midClick: true
		});

		$('.magnific-mix-gallery').each(function () {
			var $container = $(this);
			var $imageLinks = $container.find('.item');

			var items = [];
			$imageLinks.each(function () {
				var $item = $(this);
				var type = 'image';
				if ($item.hasClass('magnific-iframe')) {
					type = 'iframe';
				}
				var magItem = {
					src: $item.attr('href'),
					type: type
				};
				magItem.title = $item.data('title');
				items.push(magItem);
			});

			$imageLinks.magnificPopup({
				mainClass: 'mfp-fade',
				items: items,
				gallery: {
					enabled: true,
					tPrev: $(this).data('prev-text'),
					tNext: $(this).data('next-text')
				},
				type: 'image',
				callbacks: {
					beforeOpen: function () {
						var index = $imageLinks.index(this.st.el);
						if (-1 !== index) {
							this.goTo(index);
						}
					}
				}
			});
		});

		/* ==================================================
		# Quantity
		===============================================*/

		function wcqib_refresh_quantity_increments() {
			jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function (a, b) {
				var c = jQuery(b);
				c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
			})
		}
		String.prototype.getDecimals || (String.prototype.getDecimals = function () {
			var a = this,
				b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
			return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
		}), jQuery(document).ready(function () {
			wcqib_refresh_quantity_increments()
		}), jQuery(document).on("updated_wc_div", function () {
			wcqib_refresh_quantity_increments()
		}), jQuery(document).on("click", ".plus, .minus", function () {
			var a = jQuery(this).closest(".quantity").find(".qty"),
				b = parseFloat(a.val()),
				c = parseFloat(a.attr("max")),
				d = parseFloat(a.attr("min")),
				e = a.attr("step");
			b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
		});

		/* ==================================================
			# Typed
		 ===============================================*/

		$(".typed").typed({
			strings: ["IT Company ", "Software Company ", "Digital Marketplace "],
			// Optionally use an HTML element to grab strings from (must wrap each string in a <p>)
			stringsElement: null,
			// typing speed
			typeSpeed: 100,
			// time before typing starts
			startDelay: 1200,
			// backspacing speed
			backSpeed: 10,
			// time before backspacing
			backDelay: 600,
			// loop
			loop: true,
			// false = infinite
			loopCount: Infinity,
			// show cursor
			showCursor: false,
			// character for cursor
			cursorChar: "|",
			// attribute to type (null == text)
			attr: null,
			// either html or text
			contentType: 'html',
			// call when done callback function
			callback: function () { },
			// starting callback function before each string
			preStringTyped: function () { },
			//callback for every typed string
			onStringTyped: function () { },
			// callback for reset
			resetCallback: function () { }
		});

		/* ==================================================
			# Fun Factor Init
		===============================================*/

		$('.timer').countTo();
		$('.fun-fact').appear(function () {
			$('.timer').countTo();
		}, {
			accY: -100
		});

		/* ==================================================
			# Wow Init
		 ===============================================*/

		var wow = new WOW({
			boxClass: 'wow', // animated element css class (default is wow)
			animateClass: 'animated', // animation css class (default is animated)
			offset: 0, // distance to the element when triggering the animation (default is 0)
			mobile: true, // trigger animations on mobile devices (default is true)
			live: true // act on asynchronously loaded content (default is true)
		});
		wow.init();

		/* ==================================================
			# Range Slider
		 ===============================================*/

		$("#slider-range").slider({
			range: true,
			min: 0,
			max: 500,
			values: [75, 300],
			slide: function (event, ui) {
				$("#amount").val("" + ui.values[0] + " - " + ui.values[1]);
			}
		});
		$("#amount").val("" + $("#slider-range").slider("values", 0) +
			" - " + $("#slider-range").slider("values", 1));

		/* ==================================================
			Contact Form Validations
		================================================== */

		$('.contact-form').each(function () {
			var formInstance = $(this);
			formInstance.submit(function () {

				var action = $(this).attr('action');

				$("#message").slideUp(750, function () {
					$('#message').hide();

					$('#submit')
						.after('<img src="assets/img/logo/ajax-loader.gif" class="loader" />')
						.attr('disabled', 'disabled');

					$.post(action, {
						name: $('#name').val(),
						email: $('#email').val(),
						comments: $('#comment').val()
					},
						function (data) {
							document.getElementById('message').innerHTML = data;
							$('#message').slideDown('slow');
							$('.contact-form img.loader').fadeOut('slow', function () {
								$(this).remove()
							});
							$('#submit').removeAttr('disabled');
						}
					);
				});
				return false;
			});
		});




		// FOR_DYNAMIC_BG_IMAGE
		$("[data-background]").each(function () {
			$(this).css("background-image", "url(" + $(this).attr("data-background") + ")");
		});


		//FOR_DYNAMIC_BG_color
		$("[data-background-color]").each(function () {
			$(this).css("background-color", $(this).attr("data-background-color"));
		});




		// Toggle password

		const toggleIcon = document.querySelectorAll('.second-icon').forEach(icon => {
			icon.addEventListener('click', function () {
				let inputPassword = this.previousElementSibling;
				if (inputPassword.type === "password") {
					inputPassword.type = "text"; // show password
					this.innerHTML = '<i class="fa-regular fa-eye"></i>' // change icon
				}
				else {
					inputPassword.type = "password"; // show password
					this.innerHTML = '<i class="fa-regular fa-eye-slash"></i>' // change icon
				}
			});
		});


		/* ==================================================
			// theme dark mode RTL MOde
			=============================================== */

		// let settingIcon = document.querySelector('.icon i');
		// let themeModeContainer = document.querySelector('.theme__typography');


		// settingIcon.addEventListener("click", function () {

		// 	if (settingIcon.classList.contains("fa-gear")) {
		// 		settingIcon.classList.replace("fa-gear", "fa-xmark");
		// 		themeModeContainer.classList.add('active');
		// 	} else {
		// 		settingIcon.classList.replace("fa-xmark", "fa-gear");
		// 		themeModeContainer.classList.remove('active');
		// 	}
		// });


		// const body = document.body;
		// const lightMode = document.querySelector('.lightBtn');
		// const darkMode = document.querySelector('.darkBtn');
		// const darkModeToggle = document.querySelector('.dark-mode-toggle');
		// const darkModeIcon = document.querySelector('.dark-mode-icon');
		// const ltrMode = document.querySelector('.ltrMode');
		// const rtlMode = document.querySelector('.rtlMode');

		// if (localStorage.getItem('theme') === 'dark') {
		// 	body.classList.add('dark-mode');
		// 	darkModeIcon.classList.replace('fa-moon', 'fa-sun');
		// }

		// Dark mode Toggle btn
		// darkModeToggle.addEventListener('click', () => {
		// 	const isDark = body.classList.toggle('dark-mode');

		// 	if (isDark) {
		// 		// body.classList.toggle('dark-mode');
		// 		localStorage.setItem('theme', 'dark');
		// 		darkModeIcon.classList.replace('fa-moon', 'fa-sun');
		// 	}
		// 	else {
		// 		localStorage.setItem('theme', 'light');
		// 		darkModeIcon.classList.replace('fa-sun', 'fa-moon');
		// 	}
		// });

		// Dark mode and Light Mode Both
		// lightMode.addEventListener('click', () => {
		// 	body.classList.remove('dark-mode');
		// 	localStorage.setItem('theme', 'light');
		// 	darkModeIcon.classList.replace('fa-sun', 'fa-moon');
		// });

		// darkMode.addEventListener('click', () => {
		// 	body.classList.add('dark-mode');
		// 	localStorage.setItem('theme', 'dark');
		// 	darkModeIcon.classList.replace('fa-moon', 'fa-sun');
		// });

		// rtl mode & Ltr Mode are Both


		/* ==================================================
			# Hero Init
		 ===============================================*/
		let swiperInstances = [];

		const commonCarouselProperties = {
			slidesPerView: 1,
			loop: true,
			dots: false,
			autoplay: false,
			//    pagination: {
			// 	 el: ".swiper-pagination",
			// 	 clickable: true,
			//    },
		};

		const carouselConfigs = {
			'.hero-sldr': {
				loop: true,
				autoplay: {
					delay: 5000,
				},
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
			},

			'.team-sldr': {
				loop: true,
				freeMode: true,
				grabCursor: true,
				autoplay: {
					delay: 5000,
				},
				pagination: {
					el: ".swiper-pagination",
					clickable: true,
				},
				// Navigation arrows
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev"
				},
				breakpoints: {
					640: {
						slidesPerView: 1,
						slidesPerColumn: 1,
						spaceBetween: 20,
					},
					768: {
						slidesPerView: 3,
						slidesPerColumn: 3,
						spaceBetween: 20,
					},
					1024: {
						slidesPerView: 4,
						slidesPerColumn: 4,
						spaceBetween: 30,
					},
				},
			},

			'.review-sldr': {
				// Optional parameters
				loop: true,
				freeMode: true,
				grabCursor: true,
				slidesPerView: 1,
				spaceBetween: 30,


				// Navigation arrows
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev"
				},
				breakpoints: {
					768: {
						slidesPerView: 2,
					},
					1201: {
						slidesPerView: 2,
					},
					1300: {
						slidesPerView: 3,
					},
				},
			},

			'.review-sldr-2': {
				cssMode: true,
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
				pagination: {
					el: ".swiper-pagination",
					clickable: true,
				},
				mousewheel: true,
				keyboard: true,
			},

			'.rev-sldr': {
				loop: true,
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
				// autoplay: true,
				breakpoints: {
					640: {
						slidesPerView: 1,
						slidesPerColumn: 1,
						spaceBetween: 20,
					},
					768: {
						slidesPerView: 2,
						slidesPerColumn: 2,
						spaceBetween: 40,
					},
					1024: {
						slidesPerView: 3,
						slidesPerColumn: 3,
						spaceBetween: 30,
					},
				},
			},

			'.blog-sldr': {
				loop: true,
				autoplay: {
					delay: 5000,
				},
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
				breakpoints: {
					640: {
						slidesPerView: 1,
						slidesPerColumn: 1,
						spaceBetween: 20,
					},
					768: {
						slidesPerView: 2,
						slidesPerColumn: 2,
						spaceBetween: 40,
					},
					1024: {
						slidesPerView: 4,
						slidesPerColumn: 4,
						spaceBetween: 30,
					},
				},
			},

			'.blog-sldr-2': {
				loop: true,
				spaceBetween: 30,
				autoplay: {
					delay: 5000,
				},
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
				breakpoints: {
					640: {
						slidesPerView: 1,
						slidesPerColumn: 1,
						spaceBetween: 20,
					},
					768: {
						slidesPerView: 2,
						slidesPerColumn: 2,
						spaceBetween: 40,
					},
					1024: {
						slidesPerView: 3,
						slidesPerColumn: 3,
						spaceBetween: 30,
					},
				},
			},

			'.ptnr-sldr': {
				loop: true,
				autoplay: {
					delay: 5000,
				},
				spaceBetween: 50,
				slidesPerColumn: 1,
				breakpoints: {
					0: {
						slidesPerView: 2,
					},
					640: {
						slidesPerView: 3,
					},
					768: {
						slidesPerView: 4,

					},
					1024: {
						slidesPerView: 5,
					},
				},
			},

			'.delivery-success': {
				loop: true,
				spaceBetween: 30,
				speed: 1000,
				autoplay: {
					delay: 3000,
				},
				breakpoints: {
					0: {
						slidesPerView: 1,
					},
					576: {
						slidesPerView: 2,
					},
					768: {
						slidesPerView: 3,

					},
					1024: {
						slidesPerView: 4,
					},
				},
			},

			'.testimonial-carousel': {
				loop: true,
				spaceBetween: 30,
				speed: 1000,
				// effect: "coverflow",
				// grabCursor: true,
				clickable: true,
				centeredSlides: true,
				// slidesPerView: "auto",
				speed: 1400,
				autoplay: {
					delay: 3000,
				},
				navigation: {
					nextEl: ".swiper-button-next",
					prevEl: ".swiper-button-prev",
				},
				pagination: {
					el: ".swiper-pagination",
					clickable: true,
				},

				breakpoints: {
					0: {
						slidesPerView: 1,
					},
					576: {
						slidesPerView: 2,
					},
					768: {
						slidesPerView: 2,

					},
					1024: {
						slidesPerView: 3,
					},
				},
			},

			'.client-slider-two': {
				loop: true,
				spaceBetween: 10,
				// freeMode: true,
				speed: 1000,
				autoplay: {
					delay: 2000,
				},
				breakpoints: {
					0: {
						slidesPerView: 3,
					},
					768: {
						slidesPerView: 3,

					},
					1024: {
						slidesPerView: 6,
					},
				},
			},

			'.hero-one': {
				loop: true,
				spaceBetween: 20,
				// animation: 'fadin',
				autoplay: {
					delay: 4000,
				},
				// autoplay: false,
				slidesPerView: 1,
				speed: 1500,
				effect: 'fade',
				fadeEffect: {
					crossFade: true, // Optional: makes transition smoother
					disableOnInteraction: false,
				},
				pagination: {
					el: '.swiper-pagination',
					clickable: true,
				},
			}
		};

		// function initializeAllCarousels() {
		// 	// Destroy existing Swiper instances
		// 	swiperInstances.forEach(swiper => swiper.destroy(true, true));
		// 	swiperInstances = []; // Clear previous instances

		// 	const rtlMode = document.body.getAttribute('dir') === 'rtl'; 

		// 	Object.keys(carouselConfigs).forEach(selector => {
		// 		const config = {
		// 			...carouselConfigs[selector],
		// 			rtl: rtlMode // Dynamically set RTL mode
		// 		};

		// 		// Initialize new Swiper and store instance
		// 		const swiper = new Swiper(selector, config);
		// 		swiperInstances.push(swiper);
		// 	});
		// }

		// Function to initialize swipers
		function initializeSwiper() {
			console.log(" Destroying old Swipers...");

			// Destroy all previous swiper instances
			swiperInstances.forEach(swiper => swiper.destroy(true, true));
			swiperInstances = [];

			console.log(" Old Swipers destroyed. Now re-initializing...");

			// Re-initialize
			Object.entries(carouselConfigs).forEach(([selector, sliderConfig]) => {
				document.querySelectorAll(selector).forEach(sliderEl => {
					const config = { ...commonCarouselProperties, ...sliderConfig };

					if (config.navigation) {
						const nav = config.navigation;
						const parent = sliderEl.parentElement;
						config.navigation = {
							nextEl: parent.querySelector(nav.nextEl),
							prevEl: parent.querySelector(nav.prevEl),
						};
					}

					console.log(` Initializing Swiper for selector: ${selector}`, config);

					const swiper = new Swiper(sliderEl, config);
					swiperInstances.push(swiper);
				});
			});

			console.log(" All Swipers Initialized:", swiperInstances);
		}
		initializeSwiper();

		/* ============ All Swiper slider Initialize Ends ============= */

		/* ============ RTL Mode Start ============= */

		//   document.addEventListener('DOMContentLoaded', function () {
		// 	// Check if there is a saved direction in localStorage
		// 	const savedDir = localStorage.getItem('dir') || 'ltr'; // Default to 'ltr' if not set
		// 	document.getElementById("bdy").dir = savedDir;
		// 	initializeSwiper();
		//   });

		//   // Switch to RTL
		//   function myFunction1() {
		// 	document.getElementById("bdy").dir = "rtl";
		// 	localStorage.setItem('dir', 'rtl');
		// 	initializeSwiper();
		//   }

		//   // Switch to LTR
		//   function myFunction2() {
		// 	document.getElementById("bdy").dir = "ltr";
		// 	localStorage.setItem('dir', 'ltr');
		// 	initializeSwiper();
		//   }


		//Check Local Storage for RTL or LTR Mode
		// if (localStorage.getItem('dir') === 'rtl') {
		// 	body.dir = 'rtl';
		// 	document.getElementById('bootstrap-rtl').removeAttribute('disabled'); // Enable RTL CSS
		// 	document.getElementById('bootstrap-ltr').setAttribute('disabled', 'true'); // Disable LTR CSS
		// } 
		// else {
		// 	body.dir = 'ltr';
		// 	document.getElementById('bootstrap-ltr').removeAttribute('disabled'); // Enable LTR CSS
		// 	document.getElementById('bootstrap-rtl').setAttribute('disabled', 'true'); // Disable RTL CSS
		// }

		// Initialize carousel after setting direction

		// Event listener for LTR mode
		// ltrMode.addEventListener('click', () => {
		// 	if (body.dir === 'rtl') {
		// 		body.dir = 'ltr';
		// 		document.getElementById('bootstrap-ltr').removeAttribute('disabled');
		// 		document.getElementById('bootstrap-rtl').setAttribute('disabled', 'true');
		// 		localStorage.setItem('dir', 'ltr');
		// 		initializeAllCarousels(); // Reinitialize carousel after changing direction
		// 	}
		// });

		// //Event listener for RTL mode
		// rtlMode.addEventListener('click', () => {
		// 	if (body.dir === 'ltr') {
		// 		body.dir = 'rtl';
		// 		document.getElementById('bootstrap-rtl').removeAttribute('disabled');
		// 		document.getElementById('bootstrap-ltr').setAttribute('disabled', 'true');
		// 		localStorage.setItem('dir', 'rtl');
		// 		initializeAllCarousels(); // Reinitialize carousel after changing direction
		// 	}
		// });

	}); // end document ready function
})(jQuery); // End jQuery

/* ==================================================
	# Sidenav
 =============================================== */

// function openNav() {
// 	document.getElementById("mySidenav").style.width = "250px";
// 	document.getElementById("mySidenav").style.overflowX = "visible";

// }

// function closeNav() {
// 	document.getElementById("mySidenav").style.width = "0";
// 	document.getElementById("mySidenav").style.overflowX = "hidden";
// }


/* ============ Custom select Dropdown menu STArt ============*/

document.querySelectorAll('.custom-select').forEach(select => {
	const box = select.querySelector('.select-box');
	const options = select.querySelector('.options');
	const selectedText = select.querySelector('.selected-text');

	box.addEventListener('click', () => {
		// Close others
		document.querySelectorAll('.custom-select .options').forEach(opt => {
			if (opt !== options) opt.classList.remove('show');
		});
		document.querySelectorAll('.custom-select .select-box').forEach(b => {
			if (b !== box) b.classList.remove('active');
		});

		options.classList.toggle('show');
		box.classList.toggle('active');
	});

	options.querySelectorAll('li').forEach(item => {
		item.addEventListener('click', () => {
			selectedText.textContent = item.textContent;
			options.classList.remove('show');
			box.classList.remove('active');
		});
	});
});

document.addEventListener('click', function (e) {
	if (!e.target.closest('.custom-select')) {
		document.querySelectorAll('.options').forEach(opt => opt.classList.remove('show'));
		document.querySelectorAll('.select-box').forEach(b => b.classList.remove('active'));
	}
});

/* ============ Custom select Dropdown menu Ends ============*/

document.addEventListener("DOMContentLoaded", function(){
	MakeResponsive()
	
	if(document.body.classList.contains('home')) { //HomePage
		ArchisHomePage();
		// ImageGradient();
		DesktopMenu();
		BackUp();
	
	} else if (document.body.classList.contains('about')){ //AboutPage
		DesktopMenu();
		BackUp();
		MobileMenu();
	} else { //Other pages
		MobileMenu();
		DesktopMenu();
		FiltersOpening();
		ImageGradient();
		VolumeSlider();
		ImageDisplacement();
		LayerComein();
		BackUp();
		Slider();
	}

	if (document.body.classList.contains('bazar-post')) {
		ShopButtons();
	}
	
});


function MakeResponsive(){
	// Mobile menu showing
	function responsiveCalculation(){
	    var newWidth = window.innerWidth;
	    var newHeight = window.innerHeight; 
	    var tablet = 924;
	    var phone = 624;

	    if (newWidth <= tablet) {
	   		document.body.classList.add('body--tablet');
	    } else {
	   		document.body.classList.remove('body--tablet');
	    }

	}

	window.addEventListener('resize', responsiveCalculation);

	responsiveCalculation();
}


function LayerComein(){
	var layer = document.querySelector('.layers .layer');

	window.setTimeout(function(){
		layer.classList.add('layer--positioned');	
	}, 1);
	
}




function DesktopMenu(){

	// Desktop menu & background layer behavior
	var background = document.querySelector('.background');
	var layer = document.querySelector('.layers');
	var body = document.querySelector('body');

	if(!document.body.classList.contains("body--tablet")) {
		//Desktop
		if(layer) {
			background.addEventListener("mouseenter", function(e){
				layer.classList.add('layers--move--hint');
				body.classList.add('body--noscroll');
			});

			background.addEventListener("mouseleave", function(){
				layer.classList.remove('layers--move--hint');
				body.classList.remove('body--noscroll');
			});

			background.addEventListener("click", function(){
				layer.classList.add('layers--move--aside');
				body.classList.add('body--noscroll');
			});

		
			layer.addEventListener("click", function(){
				layer.classList.remove('layers--move--aside');
				body.classList.remove('body--noscroll');
			});
		}
		
	} else {
		// Mobile menu
		var trigger = document.querySelector('.mobilenav__trigger');
		var homeLayers = document.querySelector('.home__layers');
		var archisLayers = document.querySelector('.content__archis');
		
		trigger.addEventListener("click", function(){
			if(layer) {
				layer.classList.toggle('layers--move--hint');	
				body.classList.toggle('body--noscrollmobile');
			}

			if (homeLayers){
				homeLayers.classList.toggle('layers--move--hint');		
				body.classList.toggle('body--noscrollmobile');
			}

			if (archisLayers){
				archisLayers.classList.toggle('layers--move--hint');
				body.classList.toggle('body--noscrollmobile');
			}
		});	
	}

}



function FiltersOpening(){

	var buttons = document.querySelectorAll('.nav__actions .option', '.filter__actions .option');
	var filterGroups = document.querySelectorAll('.nav__panel .filter__group', '.filter__actions .option .filter__group');

	buttons.forEach(function(button){
		button.addEventListener('click', function(){

			buttons.forEach(function(other_button, index){
				var panel = filterGroups[index];
				if(button == other_button) {
					if(panel.classList.contains('filter__group--open')) {
						panel.style.maxHeight = null;
						panel.classList.remove('filter__group--open');
						other_button.classList.remove('filter--open');	
					} else {
						panel.classList.add('filter__group--open');
						panel.style.maxHeight = panel.scrollHeight + "px";
						other_button.classList.add('filter--open');	
					}
				} else {
					panel.classList.remove('filter__group--open');
					other_button.classList.remove('filter--open');
			      	panel.style.maxHeight = null;
				}
			});

		});
	});
}



function MobileMenu(){
	// Scroll direction
	var scrollPos = 0;
	var body = document.querySelector('body');
    var layers = document.querySelector('.layers');
	if (!layers) return
	window.addEventListener('scroll', function(direction){
		// detects new state and compares it with the new one
		if ((document.body.getBoundingClientRect()).top >= scrollPos) {
			body.setAttribute('data-scroll-direction', 'up');

			if(body.classList.contains('body--tablet')) {
				layers.classList.add('layers--down');
			}
		} else {
			body.setAttribute('data-scroll-direction', 'down');
			layers.classList.remove('layers--down');
		}
		scrollPos = (document.body.getBoundingClientRect()).top;
	});
}





function ImageGradient(){

	var images = document.querySelectorAll('.home .page .home__layers .layer--volume .layer__content .articles__highlight .article__thumbnail .container .image__container img.image, .header--volume--2 .row--2 .post__cover, .layer--projects .articles__list .article__thumbnail--list .container .image__container img, .header--volume--2 .row--2 .post__cover img, .volume-post .layer--volume img, .image__container--projects img, .searchresults__container > img, .article__thumbnail--highlight .content .image__container img, .articles__list img');
	window.addEventListener('scroll', function scrollColor (){
		var splitHeight = window.innerHeight / 1.75;

		images.forEach(function selectOne (image){
			var imagePosition = image.getBoundingClientRect().top;
			var imageSplitHeight = splitHeight - imagePosition;

			if (imageSplitHeight > 0) {
				image.classList.add('image--after');
				image.classList.remove('image--before');
			} else {
				image.classList.add('image--before');
				image.classList.remove('image--after');
			}
		})
	})

}



function VolumeSlider(){
	var carousel = document.querySelector('.issue__carousel .issues');
	//var carouselScroll = 0

	if(carousel){
		var screenHeight = window.innerHeight;
		var last_position = carousel.getBoundingClientRect().top;
		window.addEventListener('wheel', function slideCarousel (){
			var delta = carousel.getBoundingClientRect().top - last_position
			last_position = carousel.getBoundingClientRect().top
			if(carousel.getBoundingClientRect().top < screenHeight) {
				if(delta!==0) {
					carousel.scrollLeft -= delta
				}
			}
		});



		
	}
}



function PostSlider(){
	var slider = document.querySelectorAll('.wp-block-gallery');

	if (slider){
		// TODO make slider js
	}
}




function ArchisHomePage(){
	var homeSections = document.querySelectorAll('.home__section:not(.cheat__section)')
	var layers = document.querySelectorAll('.home__section:not(.cheat__section) .layer')

	//Wait for images to be loaded to recompute
	var images = document.querySelectorAll('img')
	function checkImages(){
		let loaded = 0
		images.forEach(function(image){
			if(image.complete) {
				loaded ++
			}
		})

		if(loaded!==images.length) {
			window.setTimeout(checkImages, 100)
		} else {
			compute_layer_offsets()
		}
	}
	checkImages()

	var loadingLayerOffsets = []
	function compute_layer_offsets(){
		//reset positions, we need to do this for the boundingbox to return the correct values
		homeSections.forEach(function(section, index){
			section.classList.remove("home__section--scrolling")
		})

		//compute offset positions
		loadingLayerOffsets = []
		layers.forEach(function(layer){
			loadingLayerOffsets.push(layer.getBoundingClientRect().top)
		})
	
		homeSections.forEach(function(section, index){
			section.style.height = layers[index].offsetHeight + "px"
		})

		//update back to scrolled offsets
		homeSections.forEach(function(section, index){
			var sectionPosition = section.getBoundingClientRect().top;
			if(sectionPosition < loadingLayerOffsets[index]) {
				section.classList.add("home__section--scrolling")
			} else {
				section.classList.remove("home__section--scrolling")
			}
		})
	}
	compute_layer_offsets()

	
	

	//Scrolling effect
	window.addEventListener('scroll', function slideCarousel (){
		homeSections.forEach(function(section, index){
			var sectionPosition = section.getBoundingClientRect().top;
			if(sectionPosition < loadingLayerOffsets[index]) {
				section.classList.add("home__section--scrolling")
			} else {
				section.classList.remove("home__section--scrolling")
			}
		})	
	});

	//Smooth scroll to section on click
	homeSections.forEach(function(section, index){
		var layer = layers[index]
		layer.addEventListener("click", function(e){
			section.scrollIntoView({ block: 'start',  behavior: 'smooth' })
		})
	})

	// Payoff that highlights layers
	var payoffLinks = document.querySelectorAll('.payoff__link');
	payoffLinks.forEach(function(payoffLink){
		var ref = ".layer"+payoffLink.id.slice(12);
		var layer = document.querySelector(ref);
		payoffLink.addEventListener("mouseenter", function(){
			layer.classList.add("layer--hint");
		});
		payoffLink.addEventListener("mouseleave", function(){
			layer.classList.remove("layer--hint");
		})
		payoffLink.addEventListener("click", function(e){
			e.preventDefault();
			layer.parentNode.scrollIntoView({ block: 'start',  behavior: 'smooth' })
		})
	})

}



//'.volume .article__thumbnail--list .link__container, .volume .article__thumbnail .image__container, .article__thumbnail--highlight .link__container'
function ImageDisplacement(){
	var imageContainers = document.querySelectorAll('.volume .layer--volume .article__thumbnail--list');
	imageContainers.forEach(function(imageContainer){
		
		var image = imageContainer.querySelector('img');
		if(image) {

			const updateImageStyle = function(event){			
				image.style.transform= "translate("+event.clientX+"px,"+event.clientY+"px)";
			}
			imageContainer.addEventListener('mousemove', updateImageStyle);

			imageContainer.addEventListener('mouseenter', updateImageStyle);	
		}
		
	});

}



function BackUp(){
	var button = document.querySelector('.backup');
	var page  = document.querySelector('.page');

		if (button) {
			button.addEventListener("click", function(e){
			page.scrollIntoView({ block: 'start',  behavior: 'smooth' })		
		});
	}
}


function Slider(){
	var slider_containers = document.querySelectorAll(".blocks-gallery-grid")
	var slider_offset_percentage = 0.55;
	var slide_width_percentage = 0.7;

	slider_containers.forEach(function(slider_container){
		var width, slider_offset
		
		let slides = slider_container.querySelectorAll(".blocks-gallery-item")
		
		//clone the first two and the second two
		let first_clone = slides[0].cloneNode(true)
		let second_clone = slides[1].cloneNode(true)
		slider_container.appendChild(first_clone)
		slider_container.appendChild(second_clone)

		let last_clone = slides[slides.length-1].cloneNode(true)
		let second_last_clone = slides[slides.length-2].cloneNode(true)
		slider_container.prepend(last_clone)
		slider_container.prepend(second_last_clone)
		
		slides = slider_container.querySelectorAll(".blocks-gallery-item")
		slides.forEach((slide, slide_id)=>{
			slide.addEventListener("click", function(){
				slider_offset = width * slider_offset_percentage + (width*slide_width_percentage) * (slide_id-1)
				slider_container.scroll({top: 0, left: slider_offset,  behavior: 'smooth'})
			})
			
		})


		let lower_bound, lower_target
		//initialize offset
		window.setTimeout(_=>{
			width = slider_container.parentNode.getBoundingClientRect().width
			slider_offset = (width*slider_offset_percentage) + (width*slide_width_percentage) * (2)
			slider_container.scrollLeft = slider_offset

			lower_bound = (width*slider_offset_percentage)
			lower_target = (width*slider_offset_percentage) + (width*slide_width_percentage) * (slides.length-4)

			upper_bound = (width*slider_offset_percentage) + (width*slide_width_percentage) * (slides.length-3)
			upper_target = (width*slider_offset_percentage) + (width*slide_width_percentage) * (1)

		}, 100)

		

		slider_container.addEventListener("scroll", function(){
			//console.log(slider_container.scrollLeft, lower_bound, lower_target);
			if(slider_container.scrollLeft<=lower_bound) {
				slider_container.scrollLeft = lower_target
			}

			if(slider_container.scrollLeft>=upper_bound) {
				slider_container.scrollLeft = upper_target
			}
		})
		
	})
}

function ShopButtons() {
	// If the product is misc, don't hide the buttons
	if(document.querySelector(".product__actions--misc")) {
		return
	}

	var product_options = document.querySelectorAll(".product__option")
	var ctas = document.querySelectorAll(".cta")

	ctas.forEach(function(cta){
		cta.style.display = "none"
	})

	product_options.forEach(function(product_option, i){
		var toggle_id = product_option.getAttribute("toggle-id");
		let my_cta = document.querySelector(".cta--"+toggle_id);


		product_option.addEventListener("click", function(){
			// Hide all cta buttons
			ctas.forEach(function(cta){
				cta.style.display = "none"
			})

			// Deselect all toggle options
			product_options.forEach(function(p){
				p.classList.remove("product__option--selected")
			})

			// Set style on selected option
			my_cta.style.display = "block"
			product_option.classList.add("product__option--selected")
		})

		

		// Default select top option
		if(i==0) {
			product_option.classList.add("product__option--selected")
			my_cta.style.display = "block"
		}
	})
}
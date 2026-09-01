document.addEventListener("DOMContentLoaded", function(){

	// Desktop menu & background layer behavior
	var background = document.querySelector('.background');
	var layer = document.querySelector('.layers');

	console.log(background);

	background.addEventListener("mouseenter", function(){
		layer.classList.add('layers--move--hint');
	});

	background.addEventListener("mouseleave", function(){
		layer.classList.remove('layers--move--hint');
	});

	background.addEventListener("click", function(){
		layer.classList.add('layers--move--aside');
	});

	layer.addEventListener("click", function(){
		layer.classList.remove('layers--move--aside');
	});

	layer.addEventListener("mouseenter", function(){
		layer.classList.add('layers--move--hintback');
	});

	layer.addEventListener("mouseleave", function(){
		layer.classList.remove('layers--move--hintback');
	});


	// Filters opening
	var buttons = document.querySelectorAll('.nav__actions .button', '.filter__actions .button');
	var filterGroups = document.querySelectorAll('.nav__actions .button .filter__group', '.filter__actions .button .filter__group');


	buttons.forEach(function(button){
		button.addEventListener('click', function(){
			var panel = button.querySelector('.filter__group');

			filterGroups.forEach(function(group){
				if(group == panel) {
					panel.classList.toggle('filter__group--open');
				} else {
					group.classList.remove('filter__group--open');	
				}
			});

			
			
		});
	});




	// Scroll direction
	var scrollPos = 0;
	var body = document.querySelector('body');
    var layers = document.querySelector('.layers');
	window.addEventListener('scroll', function(direction){
		// detects new state and compares it with the new one
		if ((document.body.getBoundingClientRect()).top >= scrollPos) {
			body.setAttribute('data-scroll-direction', 'up');

			if(body.classList.contains('body--tablet')) {
				console.log('beep boop');
				layers.classList.add('layers--down');
			}
		} else {
			body.setAttribute('data-scroll-direction', 'down');
			layers.classList.remove('layers--down');
		}
		scrollPos = (document.body.getBoundingClientRect()).top;
	});


	// Mobile menu showing
	function responsiveCalculation(){
	    var newWidth = window.innerWidth;
	    var newHeight = window.innerHeight; 
	    var tablet = 924;
	    var phone = 624;

	    if (newWidth < tablet) {
	   		body.classList.add('body--tablet');

	   		// if (body.getAttribute('data-scroll-direction') == 'up') {
	   		// 	console.log('tablet up');
	   		// }
	    }

	    if (newWidth > tablet) {
	   		body.classList.remove('body--tablet');
	    }
	}

	window.addEventListener('resize', responsiveCalculation);

	responsiveCalculation();
});

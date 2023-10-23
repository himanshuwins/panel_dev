// JavaScript Document
// DO NOT EDIT!

jQuery(document).ready(function ($) {

	// Primary nav ///////////////////////////////////////////////////////////////////////////////////////////////
	$('ul.primary-nav').superfish({
		delay: 200,
		animation: {opacity:'show', height:'show'},
		speed: 'fast',
		autoArrows: false,
		dropShadows: false
	});
	
	// Accordion //////////////////////////////////////////////////////////////////////////////////////////
	$('.accordion').accordion({ header: 'h5',autoHeight: false,collapsible:true });
	
	// Tabs ///////////////////////////////////////////////////////////////////////////////////////////////
	$('.tabs').tabs({ fx: { opacity: 'show' } });

	// Toggles ////////////////////////////////////////////////////////////////////////////////////////////
	jQuery(".toggle").each( function () {
		if(jQuery(this).attr('data-id') == 'closed') {
			jQuery(this).accordion({ header: 'h5', collapsible: true, active: false  });
		} else {
			jQuery(this).accordion({ header: 'h5', collapsible: true});
		}
	});
	
	// Twiiter ////////////////////////////////////////////////////////////////////////////////////////////
	JQTWEET.loadTweets();
	
	// Flexslider /////////////////////////////////////////////////////////////////////////////////////////
	$('.flexslider').flexslider({
		slideshow: true,
		slideshowSpeed: 7000,
		animationDuration: 600,
		directionNav: true,
		controlNav: false,
		randomize: false,
		slideToStart: 0,
		animationLoop: true,
		pauseOnAction: true,
		pauseOnHover: true
	});
	
	// Lightbox	///////////////////////////////////////////////////////////////////////////////////////////
	$("a[rel^='prettyPhoto']").prettyPhoto({
		theme: 'pp_default',
		animation_speed: 'fast',
		opacity: 0.80,
		show_title: true
	});

	// Testimonials ///////////////////////////////////////////////////////////////////////////////////////
	$('#testimonials').mouseover(function() {
		$('#testimonials').cycle('pause');
	}); 
	$('#testimonials').mouseout(function() {
		$('#testimonials').cycle('resume');
	});
	$('#testimonials')
		.cycle({
			fx: 'scrollLeft', // Change the effect; fade, scrollUp, scrollDown, scrollRight, scrollLeft
			speed: 1500, // Change the speed of transition.
			timeout: 5000 // Change the speed of tesimonials duration.			
	});

});
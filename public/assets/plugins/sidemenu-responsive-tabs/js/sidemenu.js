(function () {
	"use strict";

	var slideMenu = $('.side-menu');
	$('.app').addClass('sidebar-mini');
	
	// Toggle Sidebar
	$(document).on("click", "[data-toggle='sidebar']", function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled');
		$('.app').removeClass('sidenav-toggled4');
	});
	$(document).on("click", ".sidenav-toggled .nav-link.toggle", function(event) {
		event.preventDefault();
		$('.app').toggleClass('sidenav-toggled1');
	});
	$(document).on("click", ".sidenav-toggled .resp-tab-item", function(event) {
		event.preventDefault();
		$('.app').addClass('sidenav-toggled4');
		$('.app').removeClass('sidenav-toggled1');
		$('.app').removeClass('sidenav-toggled');
	});
	
	//mobile  Toggle Sidebar
	if ( $(window).width() < 767) { 
		$(document).on("click", "[data-toggle='sidebar']", function(event) {
			event.preventDefault();
			$('.app').toggleClass('sidenav-mobile');
		});
		
		$(document).on("click", ".sidenav-mobile .resp-tab-item", function(event) {
			event.preventDefault();
			$('.app').toggleClass('sidenav-toggled1');
			$('.app').toggleClass('sidenav-toggled');
		});
	}
	
	// Activate sidebar slide toggle
	$(document).on("click", "[data-toggle='slide']", function(event) {
		event.preventDefault();
		if(!$(this).parent().hasClass('is-expanded')) {
			slideMenu.find("[data-toggle='slide']").parent().removeClass('is-expanded');
		}
		$(this).parent().toggleClass('is-expanded');
	});

	// Set initial active toggle
	$("[data-toggle='slide.'].is-expanded").parent().toggleClass('is-expanded');

	//Activate bootstrip tooltips
	$("[data-toggle='tooltip']").tooltip();
	
	
	
	const ps13 = new PerfectScrollbar('.first-sidemenu', {
		useBothWheelAxes:true,
		suppressScrollX:true,
	});
	const ps14 = new PerfectScrollbar('.second-sidemenu', {
		useBothWheelAxes:true,
		suppressScrollX:true,
	});
	
	
	// ______________sticky-header
	function updateScroll() {
		if ($(window).scrollTop() >= 30) {
			$(".main-header-fixed").addClass('fixed-header');
		} else {
			$(".main-header-fixed").removeClass("fixed-header");
		}
	}
	$(function() {
		$(window).scroll(updateScroll);
		updateScroll();
	});
	
	
})();
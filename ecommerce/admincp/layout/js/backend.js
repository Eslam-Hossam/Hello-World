$(function () {

 	'use strict';

 	// adminpanel

 	$('.toggle-info').click(function(){

 		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);

 		if( $(this).hasClass('selected')) {
 			$(this).html('<i class="fa fa-minus fa-lg"></i>');
 		} else {
 			$(this).html('<i class="fa fa-plus fa-lg"></i>');
 		}

 	});

 	// trun on plugin selcet box

 	$("select").selectBoxIt({
 		autoWidth: false, showEffect: "fadeIn", showEffectSpeed: 400, hideEffect: "fadeOut", hideEffectSpeed: 400
 	});


 	$('[placeholder]').focus(function(){

 		$(this).attr('data-text', $(this).attr('placeholder'));
 		$(this).attr('placeholder','');

 	}).blur(function () {

 		$(this).attr('placeholder', $(this).attr('data-text'));
 	});


 	//add * >> required fields

 	$('input').each(function() {

 		if ($(this).attr('required') === 'required') {

 			$(this).after('<span class="asrto" style="color:red;">*</span>')
 		}

 	});

 	// show password when hover

 	var passf = $('.password');

 	$('.show-pass').hover(function () {

 		passf.attr('type','text');

 	}, function(){

 		passf.attr('type','password');

 	});

 	// conf in mange section in users page

 	$('.conf').click(function(){

 		return confirm('motaked yabny');
 	});


 	//view option
 	$('.cat h3').click(function(){

 		$(this).next('.full-view').fadeToggle();
 	});

 	$('.Option span').click(function(){

 		$(this).addClass('active').siblings('span').removeClass('active');

 		if ($(this).data('view') === 'full') {

 			$('.cat .full-view').fadeIn(200);
 		
 		} else {

 			$('.cat .full-view').fadeOut(200);
 		};

 	});

 });
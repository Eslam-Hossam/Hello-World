$(function () {

 	'use strict';


 	// switch sign / login

 	$('.login-page h1 span').click(function(){

 		$(this).addClass('active').siblings().removeClass('active');

 		$('.login-page form').hide();

 		$('.' + $(this).data('class')).fadeIn(100);
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

 	// conf in mange section in users page

 	$('.conf').click(function(){

 		return confirm('motaked yabny');
 	});


 	//live show add new ads page

 	$('.live-name').keyup(function() {

 		$('.live-preview .caption h3').text($(this).val());

 	});

 	$('.live-desc').keyup(function(){

 		$('.live-preview .caption p').text($(this).val());
 	});

 	$('.live-price').keyup(function(){

 		$('.live-preview span').text( '$' + $(this).val());
 	});

 });
$(function(){
	'use strict';
	//Remove Placeholder on Focus
	$('[placeholder]').focus(function(){
		$(this).attr('data-text', $(this).attr('placeholder'));
		$(this).attr('placeholder', '');
	}).blur(function(){
		$(this).attr('placeholder', $(this).attr('data-text'));
	})
	//Add Asterisk on Required Files
	$('input').each(function(){
		if($(this).attr('required') === 'required'){
			$(this).after('<span class="asterisk">*</span>');
		}
	})
	//Convert Password Field To Text Filed
	var passField = $('.password');
	$('.fa-low-vision').hover(function(){
		passField.attr('type', 'text');
	}, function(){
		passField.attr('type', 'password');
	})
})
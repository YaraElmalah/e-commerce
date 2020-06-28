$(function(){
	'use strict';
	//Dashboard - fadeToggle the Panel Body
	$('.toggle-show').on('click', function(){
		$(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(300);
		($(this).hasClass('selected'))?$(this).html("<i class='fas fa-minus'></i>"):$(this).html("<i class='fas fa-plus'></i>");
	})
	//Trigger The SelectBoxIt
	$('select').selectBoxIt({
		  autoWidth: false
	});
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
	//Confirm Message On Delete Member Button
	$('.confirm').on('click', function(){
		return confirm('Are You Sure?');
	})
	//Category View Options
	$('.cat h3').on('click', function(){
		$(this).next('.full-view').fadeToggle(500);
	})
	var myViewOption = $('.full-view');
	$('.manage-order span').on('click', function(){
		$(this).addClass('active').siblings('span').removeClass('active');
		($(this).data('view') === 'full')? myViewOption.fadeIn(200): 
	     myViewOption.fadeOut(200);
	 });
		
})
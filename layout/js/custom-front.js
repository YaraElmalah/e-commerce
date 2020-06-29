$(function(){
	'use strict';
	//Switch between Login and Signup
	$('.login-form h1 span').on('click', function(){
		$(this).addClass('selected').siblings('span')
		.removeClass('selected');
	$('form').hide();
	$('form' + $(this).data('class')).fadeIn(100);
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
	//Confirm Message On Delete Member Button
	$('.confirm').on('click', function(){
		return confirm('Are You Sure?');
	})
		
})
$(function()
{
	$('.netihlmusic-form').submit(function(event)
	{
		event.stopPropagation();
		event.preventDefault();
		var action_uri = $(this).attr('action');
		var data = $(this).serialize();
		var error_message_div = $(this).find('.alert');
		var target_uri = $(this).find('input[name=SEF_FOLDER]').val();
		
		$.ajax(
		{
			url:		action_uri,
			type:		'POST',
            dataType:	'json',
			data:		data,
			cache:		false,
			error: function(xhr) 
			{
				console.log(xhr.responseText);
				return false;
			},
			success: function(result) 
			{
				if (result.result)
				{
					window.location.replace(target_uri);
				}
				else
				{
					error_message_div.html(result.error);
					error_message_div.fadeIn(300);
				}
			},
		});
		
		return false;
	});
	
	$('.netihlmusic-button').bind('click',function(event)
	{
		event.stopPropagation();
		event.preventDefault();
		
		var answ = confirm('Вы действительно хотите удалить элемент: "'+$(this).attr('data-name')+'"?');
		if (answ !== true) return false;
		
		var data = 'operation=' + $(this).attr('data-operation') + '&ID=' + $(this).attr('data-id');
		var action_uri = $(this).attr('href');

		$.ajax(
		{
			url:		action_uri,
			type:		'POST',
            dataType:	'json',
			data:		data,
			cache:		false,
			error: function(xhr) 
			{
				console.log(xhr.responseText);
				return false;
			},
			success: function(result) 
			{
				if (result.result)
				{
					window.location.reload();
				}
				else
				{
					alert(result.error);
				}
				return false;
			},
		});
		
		return false;
	});
});
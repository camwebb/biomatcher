$(function() {
	$('#upload_file').submit(function(e) {
		e.preventDefault();
		$.ajaxFileUpload({
			url 			:'../../upload_file/', 
			secureuri		:false,
			fileElementId	:'zipped_file',
			dataType		: 'json',
            
			success	: function (data, status)
			{
				if(data.status != 'error')
				{
					$('#files').html('<p>Reloading files...</p>');
					refresh_files();
				}
				//alert(data.msg);
                $('.errorbox').html(data.msg);
			}
		});
		return false;
	});
});
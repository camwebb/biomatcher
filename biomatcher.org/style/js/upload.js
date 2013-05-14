$(function() {

//elements

var progressbox     = $('#progressbox');
var progressbar     = $('#progressbar');
var statustxt       = $('#statustxt');
var myform          = $("#upload_file");
var output          = $(".errorbox");
var completed       = '0%';
progressbar.progressbar({value: 0});
output.html("");

$(myform).ajaxForm({
    dataType:  'json',
    beforeSend: function() { //brfore sending form
        statustxt.empty();
        progressbox.slideDown();
        statustxt.html(completed); //set status text
        statustxt.css('color','#000'); //initial color of status text
    },
    uploadProgress: function(event, position, total, percentComplete) { //on progress
        progressbar.progressbar({value: percentComplete});
        statustxt.html(percentComplete + '%'); //update status text
        if(percentComplete>50)
        {
            statustxt.css('color','#fff'); //change status text to white after 50%
        }
    },
    complete: function(response) { // on complete
        var message = JSON.parse(response.responseText);
        progressbar.progressbar({value: 100});
        output.html(message.msg); //update element with received data
        statustxt.html("Processing image" + message.list); //update status text                                                
        myform.resetForm();  // reset form
    },
    /*processImage: function(process){
        var processMsg = JSON.parse(process.responseText);        
        statustxt.html("Processing image" + processMsg.num + processMsg.list);
    }*/
});


       
/*
    $( "#progressbar" ).progressbar({
      value: 37
    });
        
	$('#upload_file').submit(function(e) {
		e.preventDefault();
		$.ajaxFileUpload({
			url 			:'../../upload_file/?pid='+$('#project_id').val()+'&unid='+$('#unid').val(), 
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
    
    function refresh_files()
    {
       $.get('../../upload_file/')
       .success(function (data){
          $('#files').html(data);
       });
    }
*/    

});
$(document).ready(function() {
    $("div#toppanel-disable").hide();
    
    function addProject(){
        $("div#addProject_panel").fadeIn("normal");
        $("div#toppanel-disable").show();
        $("div#panel").animate({
			height: "0px"
		}, "fast");
    }
    
    function cancelProject(){
        $("div#addProject_panel").fadeOut("normal"); 
        $("div#toppanel-disable").hide();       
    }
    
    function editLabel(){
        var id = $('input[@name="id_label"]:checked').val();
        $.ajax({
            url: '../../do_getIdLabel/',
            type: "POST",
            dataType: "json",
            data: 'id='+id,
            cache:false,
            success: function(data){ 
                alert(data);            }           
            });
    }
    
    function cancelLabel(){
        $("#draggable").fadeOut("normal");
    }
    
    function editAll(){
        $("#draggable").fadeIn("normal");
        $( "#draggable" ).draggable({containment: "#content-frame;",scroll: false});
    }
    
    $('a#close, #mask').bind('click', function() { 
        $('#mask , .popup').fadeOut(300 , function() {
            $('#mask').remove();  
        });
        return false;
	});
    
    $("#addProject, #upl_img").bind("click",addProject);
    $("#button_cancelProject, #button_cancelUpload").bind("click",cancelProject);
    
    /*editLabel function*/	
    $("#editLabel").bind("click",editLabel);
   /* $("#editAll").bind("click",editAll);*/
    $("#cancelLabel").bind("click",cancelLabel);	

        
});
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
        $("#draggable").fadeIn("normal");
        $( "#draggable" ).draggable({containment: "#content-frame;",scroll: false});
    }
    
    function cancelLabel(){
        $("#draggable").fadeOut("normal");
    }
    
    $('a#close, #mask').bind('click', function() { 
        $('#mask , .popup').fadeOut(300 , function() {
            $('#mask').remove();  
        });
        return false;
	});
    
    $("#addProject, #upl_img").bind("click",addProject);
    $("#button_cancelProject, #button_cancelUpload").bind("click",cancelProject);	
    $("#editLabel").bind("click",editLabel);
    $("#cancelLabel").bind("click",cancelLabel);	
    
});
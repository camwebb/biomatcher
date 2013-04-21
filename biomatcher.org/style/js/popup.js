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
    
    $("#addProject, #upl_img").bind("click",addProject);
    $("#button_cancelProject, #button_cancelUpload").bind("click",cancelProject);	
    
});
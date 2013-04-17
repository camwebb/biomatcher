$(document).ready(function() {
    $("div#toppanel-disable").hide();
    
    function addProject(){
        $("div#addProject_panel").show("slow");
        $("div#toppanel-disable").show();
        $("div#panel").animate({
			height: "0px"
		}, "fast");
    }
    
    function cancelProject(){
        $("div#addProject_panel").hide("slow"); 
        $("div#toppanel-disable").hide();       
    }
    
    $("#addProject").bind("click",addProject);
    $("#button_cancelProject").bind("click",cancelProject);	
    
});
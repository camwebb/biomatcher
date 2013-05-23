$(document).ready(function() {
    $("div#toppanel-disable").hide();
    
    function addProject(){
        $("div#addProject_panel").fadeIn("normal");
        $("div#toppanel-disable").show();
        $("div#progressbox").hide();
        $("div.errorbox").empty();
        $("div#panel").animate({
			height: "0px"
		}, "fast");
    }
    
    function cancelProject(){
        $("div#addProject_panel").fadeOut("normal"); 
        $("div#toppanel-disable").hide();       
    }
    
    function cancelLabel(){
        $("#draggable").fadeOut("normal");
    }
    
    function editAll(){
        $("#draggable").fadeIn("normal");
        $( "#draggable" ).draggable({containment: "#content-frame;",scroll: false});
    }
    
    function del_img(){
        var arr_img = $.map($("input[name='id_image']:checked"), function(e,i) {
            return +e.value;
        });

        var pID=$("#pid").val();
        var pagination=$("#pagination").val();
        var data_img = { 'id_image' : arr_img, 'pid' : pID, 'pagination' : pagination};
        console.log(data_img);
        $.ajax({
            type: "POST",
            url: "../../deleteImage",
            dataType: "json",
            data: data_img,
            cache:false,
            success: function(data){
                $("#form_message").html(data.message).css({'background-color' : data.bg_color}).fadeIn('slow');
            }
        });
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
    $("#editAll").bind("click",editAll);
    $("#cancelLabel").bind("click",cancelLabel);
    
    $('#delete').click(function() {
        del_img();
    });	     
});

$(function() {
    $("#buttonLabel").click(function() {
    
    var form_data = {
        csv: $("textarea#labelProject").val(),
        user_id: $("input[name='user_id']").val(),
        project_address: $("input#project_address").val(),
        project_name: $("input#project_name").val()
    };
    
    $.ajax({
    type: "POST",
    url: "../../do_editAllLabel",
    data: form_data,
    success: function(data){
        //alert(data); 
        $("#draggable").fadeOut("normal");
        //$("#label").html(data);
        location.reload();
        }
    });
    return false;
    });
    });
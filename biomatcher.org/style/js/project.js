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
    
    function cancelAllLabel(){
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
            success: function(){
                window.location.replace("test/");
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
    $("#cancelLabel").bind("click",cancelAllLabel);
    
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
    
$(function(){
   $("#editLabel").click(function(){
    
    var id_label = $("input[name='id_label']:checked").val();
    var dataString = 'id_label='+ id_label;
    
    $.ajax({
    type: "POST",
    url: "../../do_editLabel",
    data: dataString,
    success: function(data){
        //alert(data);
        $("#label"+id_label).replaceWith('<form id="formLabel'+id_label+'" method="POST" action="test"><input name="edit_label" id="hide_cancelLabel'+id_label+'" type="text" value="'+data+'" /><a class="button_edit_label" id="cancelLabel'+id_label+'">Cancel</a><button class="button_edit_label" id="editOneLabel">Submit</button></form>');
        $("#for_close_label"+id_label).css("background","#e6e6e6");
        $("#cancelLabel"+id_label).click(function(){
          $("#for_close_label"+id_label).children().remove();  
          $("#for_close_label"+id_label).html('<p id="label'+id_label+'">'+data+'</p>');
          $("input[name='id_label']").removeAttr("checked");
          $("#for_close_label"+id_label).css("background","none");
        });
        }
    });
    return false;
   }); 
});
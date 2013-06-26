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
        $.ajax({
            type: "POST",
            url: CI_ROOT+"index.php/pages/deleteImage",
            dataType: "json",
            data: data_img,
            cache:false,
            success: function(status){
                if(status != 'error')
        		{
                    if(pagination==0){
                        pagination = "";
                    }
                    var url = CI_ROOT+"index.php/pages/view/project/"+pID+"/"+pagination;
                    redirect(url);
                }
            }
        });
        
    }
    
    function insert_match(same){
        var imageIDA = $("#imageIDA").val();
        var imageIDB = $("#imageIDB").val();
        var data = {'imageIDA' : imageIDA, 'imageIDB' : imageIDB, 'same' : same}
        console.log(data);
        
        $.ajax({
            type: "POST",
            url: CI_ROOT+"index.php/pages/insert_match",
            dataType: "json",
            data: data,
            cache:false,
            success: function(status){
                if(status != 'error')
        		{
                    redirect('');
                }
            }
        });
    }
    
    function redirect(url)
    {
        window.location.href = url;
    }
    
    function insertProject(){
        alert('masuk function');
    }
    
    $('#delete').click(function() {
        del_img();
    }); 
    
    /*$('#button_addProject').click(function(){
        insertProject();
    });*/
    
    $('#sameMatch').click(function(){
        var same = 'yes';
        insert_match(same);
    });
    
    $('#differentMatch').click(function(){
        var same = 'no';
        insert_match(same);
    });
    
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
    url: CI_ROOT+"index.php/pages/do_editAllLabel",
    data: form_data,
    success: function(data){
        //alert(data); 
        $("#draggable").fadeOut("normal");
        //$("#label").html(data);
        location.reload();
        },
    error:function (xhr, textStatus, thrownError, data) {
            $('#error_msg_all').fadeIn(300);
            $('#error_msg_all').html('<p style="font-size: 13px; color: red; font-style: italic;">Duplicated Label</p>');
            console.log("Duplicated label");
            console.log("Update Error Status: ", xhr.status, " Error Thrown: ", thrownError);
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
    url: CI_ROOT+"index.php/pages/find_IDLabel",
    data: dataString,
    success: function(data){
        //alert(data);
        $('html,body').animate({scrollTop:$("#slide_label"+id_label).offset().top},500);
        $("#label"+id_label).replaceWith('<form id="formLabel'+id_label+'" method="POST"><input id="hide_cancelLabel'+id_label+'" type="text" name="new_label" value="'+data+'" /><input type="hidden" id="label_id'+id_label+'" name="id_label2" value="'+id_label+'"/><a class="button_edit_label" id="cancelLabel'+id_label+'">Cancel</a><a class="button_edit_label" id="editOneLabel'+id_label+'">Submit</a></form>');
        $("#for_close_label"+id_label).css("background","#e6e6e6");       
        
        $("#cancelLabel"+id_label).click(function(){
          $("#for_close_label"+id_label).children().remove();  
          $("#for_close_label"+id_label).html('<p id="label'+id_label+'">'+data+'</p>');
          $("input[name='id_label']").removeAttr("checked");
          $("#for_close_label"+id_label).css("background","none");
          $('#error_msg'+id_label).fadeOut(300);
        });
        
        $("#editOneLabel"+id_label).click(function(){
            var form_data2 = {
                id_label2: $("#label_id"+id_label).val(),
                new_label: $("#hide_cancelLabel"+id_label).val()
            };
            
            $.ajax({
            type: "POST",
            url: CI_ROOT+"index.php/pages/do_editLabel",
            data: form_data2,
            success: function(data){
                //alert(data);
                $("#for_close_label"+id_label).children().remove();  
                $("#for_close_label"+id_label).html('<p id="label'+id_label+'">'+data+'</p>');
                $("input[name='id_label']").removeAttr("checked");
                $("#for_close_label"+id_label).css("background","none");
            },
            error:function (xhr, textStatus, thrownError, data) {
            $('#error_msg'+id_label).fadeIn(300);
            $('#error_msg'+id_label).html('<p style="font-size: 13px; color: red; font-style: italic;">Duplicated Label</p>');
            console.log("Duplicated label");
            console.log("Update Error Status: ", xhr.status, " Error Thrown: ", thrownError);
            }
        }); 
        });
        
        }
    });
    return false;
   }); 
});


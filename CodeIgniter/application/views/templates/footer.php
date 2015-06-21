    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/project.js"></script>
    <script src="<?php echo base_url()?>style/js/jquery.form.js"></script>
    <script src="<?php echo base_url()?>style/js/upload.js"></script>
	<script src="<?php echo base_url()?>style/js/ajaxfileupload.js"></script>
    
    <!-- syntax highlighter -->
    <script type="text/javascript" src="<?php echo base_url(); ?>syntaxhighlighter/scripts/shCore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>syntaxhighlighter/scripts/shLegacy.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>syntaxhighlighter/scripts/shAutoloader.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>syntaxhighlighter/src/shCore.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>syntaxhighlighter/src/shLegacy.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>syntaxhighlighter/src/shAutoloader.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>syntaxhighlighter/scripts/shBrushJScript.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>syntaxhighlighter/scripts/shBrushPhp.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>syntaxhighlighter/scripts/shBrushXml.js"></script>
    <!-- syntax highlighter -->
    
    <!-- Datatables -->
    <script type="text/javascript" src="<?php echo base_url(); ?>plugin/datatables/js/jquery.dataTables.min.js"></script>
    <!-- Datatables -->
    
    <script type="text/javascript">
    function show_mask(){
        // Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
    }

    CI_ROOT = "<?=base_url() ?>";
    
    var num = 100; //number of pixels before modifying styles

    $(window).bind('scroll', function () {
        if ($(window).scrollTop() > num) {
            $('#menu').addClass('fixed');
            $('#scroll_logout').show();
            $('#menu li').addClass('addLogout');
        } else {
            $('#menu').removeClass('fixed');
            $('#scroll_logout').hide();
            $('#menu li').removeClass('addLogout');
        }
    });
    </script>

    <?php if($title == 'Setting'){ ?>

    <script type="text/javascript">
    $(document).ready(function() {
        $(function(){
            var url = '<?php echo base_url() ?>';
            $( "#tabs" ).tabs();
        
        $('#form_profile').submit(function(evnt){
            evnt.preventDefault(); //Avoid that the event 'submit' continues with its normal execution, so that, we avoid to reload the whole page
            $.post(url+"index.php/setting/do_profile", //The variable 'url' must store the base_url() of our application
            $("form#form_profile").serialize(), //Serialize all the content of our form to URL format
            function (data) {
                //console.log(data); //Add the AJAX response to some div that is going to show the message
                var get_data = $.parseJSON(data);
                var name_value = $('input[name="name"').val();
                //console.log(get_data.result);
                $('#error-name, #error-username ,#error-email,#error-password,#success-profile').empty();
                $('#error-name').prepend(get_data.name);
                $('#error-username').prepend(get_data.username);
                $('#error-email').prepend(get_data.email);
                $('#error-password').prepend(get_data.password);
                $('input[name="password"]').val('');
                if(get_data.result=='Success'){
                    $('#success-profile').prepend(get_data.result);
                    $('#welcome_user').empty();
                    $('#welcome_user').prepend('Welcome, '+name_value);
                }
            });
        });
        
        $('#form_pass').submit(function(evnt){
            evnt.preventDefault(); //Avoid that the event 'submit' continues with its normal execution, so that, we avoid to reload the whole page
            $.post(url+"index.php/admin/pass_admin", //The variable 'url' must store the base_url() of our application
            $("form#form_pass").serialize(), //Serialize all the content of our form to URL format
            function (data) {
                //console.log(data); //Add the AJAX response to some div that is going to show the message
                var get_data = $.parseJSON(data);
                //console.log(get_data.old_pass);
                $('#error-old_pass, #error-new_pass ,#error-renew_pass,#success-pass').empty();
                $('#error-old_pass').prepend(get_data.old_pass);
                $('#error-new_pass').prepend(get_data.new_pass);
                $('#error-renew_pass').prepend(get_data.renew_pass);
                $('input.pass').val('');
                if(get_data.result=='Success'){
                    $('#success-pass').prepend(get_data.result);
                }
            });
        });

        });    
    });        

    </script>
    <?php }?>
    <?php if($title == 'Get Code'){ ?>
    <script type="text/javascript">
        SyntaxHighlighter.defaults['toolbar'] = false;
        //SyntaxHighlighter.defaults['html-script'] = true;
        SyntaxHighlighter.all()
    </script>
    <?php }?>
    
</body>
</html>

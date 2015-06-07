    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-ui-1.8.21.custom.min.js"></script>
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
</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>Iframe Captcha Testing</title>
    <!--<script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>-->
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>captcha/style.css" />
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-2.0.3.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>captcha/biomatcher.js"></script>                        
    
    
    
                            
</head>
<body>

<form action="test.php" method="post" id="myformid">

    <!-- ... your form code here ... -->
    <input type="button" value="Verify" onclick="biomatcher('#myformid')" />    

</form>

</body>
</html>
<script>
/*$(document).ready(function(){
$('#sendMatch').bind( "click",function(e){
    sendMatch();
});
});*/

</script>
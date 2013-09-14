<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>Iframe Captcha Testing</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script type="text/javascript">
    function show_mask(){
        // Add the mask to body
		$('body').append('<iframe style="height:441px; width:699px;" src="http://192.168.56.10/biomatcher/biomatcher.org/index.php/captcha/frame"></iframe>');
		$('#mask').fadeIn(300);
    }

    </script>
</head>
<body>
<script type="text/javascript">
    show_mask();
</script>

</body>
</html>
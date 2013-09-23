<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>Iframe Captcha Testing</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" charset='utf-8'>
    function biomatcher(){
		$('#biomatcher_captcha').append('<iframe src="http://192.168.56.10/biomatcher/biomatcher.org/index.php/captcha/frame" height="750px" width="761px" frameborder="0" ></iframe>');
    }
    </script>
</head>
<body style="width: 1000px;">

<form action="" method="post">

    <!-- ... your form code here ... -->
    <input type="button" value="Verify" onclick="biomatcher()" />    
    
    <div id="biomatcher_captcha" style="margin: 0 auto;"></div>

</form>

</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>Iframe Captcha Testing</title>
    <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.3.min.js"></script>
    <script type="text/javascript">
    function show_mask(){
        // Add the mask to body
		$('body').append('<iframe style="height:700px; width:725px;" src="http://192.168.56.10/biomatcher/biomatcher.org/index.php/captcha/frame"></iframe>');
		$('#mask').fadeIn(300);
    }
    
    var RecaptchaOptions = {
            theme : 'white'
         };

    </script>
</head>
<body>
<script type="text/javascript">
    show_mask();
</script>


<form action="" method="post">

    <!-- ... your form code here ... -->

    <script type="text/javascript"
       src="http://www.google.com/recaptcha/api/challenge?k=6LcqRuYSAAAAAPP6mZvCEUur8j_wVTIDAHPmmsZ-">
    </script>
    <noscript>
       <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LcqRuYSAAAAAPP6mZvCEUur8j_wVTIDAHPmmsZ-"
           height="300" width="500" frameborder="0"></iframe><br>
       <textarea name="recaptcha_challenge_field" rows="3" cols="40">
       </textarea>
       <input type="hidden" name="recaptcha_response_field"
           value="manual_challenge">
    </noscript>

</body>
</html>

<!-- please read later

http://stackoverflow.com/questions/14098802/how-to-create-embed-code-for-other-sites

-->
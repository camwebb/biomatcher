<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
    <title>Biomatcher Example Form</title>
    <script type="text/javascript" src="http://192.168.56.10/biomatcher/biomatcher.org/style/js/jquery-2.0.3.js"></script>
    <script type="text/javascript" src="http://192.168.56.10/biomatcher/biomatcher.org/captcha/biomatcher.js"></script>
    <script type="text/javascript">
        window.addEventListener( "message",
        function (e) {
            if(e.data == 'closed'){ 
                location.reload();
                document.forms["myForm"].submit();    
            } 
        },
        false);
        var url = 'http://192.168.56.10/biomatcher/biomatcher.org/index.php/captcha/test_frame';
        var token = 'd7dc1b45706edd6cfbd3a4743de3c391086b9629b11762840943285833fff984';
    </script>
    
    <style>
    body{
        margin: 0;
    }
    </style>
    
</head>
<body>

<fieldset>
    <legend>Example Form</legend>  
        
    <p class="note">
      This is an example PHP form that processes user information, checks for errors, and validates the captcha code.<br />
      This example form also demonstrates how to submit a form to itself to display error messages.
    </p>

    <form method="post" action="form.php" id="captcha_form" name="myForm">
      <p>
        <strong>Name*:</strong>&nbsp; &nbsp;<br />
        <input type="text" name="name" size="35" value="" />
      </p>
    
      <p>
        <strong>Email*:</strong>&nbsp; &nbsp;<br />
        <input type="text" name="email" size="35" value="" />
      </p>
    
      <p>
        <strong>Message*:</strong>&nbsp; &nbsp;<br />
        <textarea name="message" rows="12" cols="60"></textarea>
      </p>
    
      <p>
        <br />
        <!--<input type="submit" value="Submit Message" />-->
        <input type="button" value="Verify" onclick="biomatcher(url,token)" /> 
      </p>
    
    </form>
</fieldset>


</body>
</html>
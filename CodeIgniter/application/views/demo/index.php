<html>

<head>
	<script type="text/javascript" src="http://biomatcher.org/style/js/jquery-2.0.3.js"></script>
	<script type="text/javascript" src="http://biomatcher.org/captcha/biomatcher.js"></script>
	<script type="text/javascript">
	    window.addEventListener( "message",
	    function (e) {
	        if(e.data == 'verified'){
	            //do something with your form ex. submit
	            document.forms["myForm"].submit();    
	        } 
	    },
	    false);
	    var yourURL = 'http://biomatcher.org/index.php/demo'; //this is used to send a message to your site.
	    var token = '7e50ff0667c82da61df46f6d824045f7cf78896130cb1f78067de67e425dcabc'; //this token will allow you to use biomatcher captcha.
	</script>
</head>

<body>
	<p>This is an example form to use biomatcher captcha. Do not forget to include jquery and biomatcher.js into your html header.</p>
 
	<form method="post" action="<?php echo base_url('index.php/demo');?>" id="captcha_form" name="myForm">
	  <p>
	    <strong>Name*:</strong>   <br>
	    <input type="text" name="name" size="35" value="">
	  </p>
	 
	  <p>
	    <strong>Email*:</strong>   <br>
	    <input type="text" name="email" size="35" value="">
	  </p>
	   
	  <p>
	    <input type="button" value="Verify" onclick="biomatcher(yourURL,token);"> 
	  </p>
	 
	</form>
</body>

</html>
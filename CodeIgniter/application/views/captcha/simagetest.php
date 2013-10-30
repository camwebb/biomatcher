<html>
	<head>
		<script src="http://code.jquery.com/jquery-latest.js"></script>	
		<script>
			$(function(){
				$("#reload").click(function(){			 	
				 	$("#captcha").attr('src', '<?php echo site_url('captcha/securimage');?>');			 	
				});
			});
		</script>
	</head>
	<body>
		<?php
		echo form_open('captcha');
		echo img(array('src' => site_url('captcha/securimage'), 'alt' => 'captcha', 'id' => 'captcha'));
		echo form_input(array('name' => 'something', 'value' => set_value('something')));
		echo form_label('captcha', 'Type the captcha code');
		echo form_input(array('name' => 'captcha'));
		echo form_error('captcha');

		echo form_submit('submit', 'Submit');
		echo form_close();		
		?>
		<a href="" id="reload">Reload</a>

	</body>
</html>
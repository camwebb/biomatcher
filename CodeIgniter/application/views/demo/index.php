<div class="wrapper">
    <div id="content">
        <h2 style="float: left;">My Website</h2>  
        <div class="separator" style="float: left;"></div>
        <div class="clear"></div>
	    <h3>Example Form</h3><br>
		<p>This is an example form to use biomatcher captcha.</p><br>
	 
		<form method="post" action="<?php echo base_url('index.php/demo');?>" id="captcha_form" name="myForm">
		  
		  <table>
		  	<tr>
		  		<td style="width: 100px;"><strong>Name <sup>*</sup></strong></td>
		  		<td><input type="text" class="inputtext" name="name" style="width: 225px;" required/></td>
		  	</tr>
		  	<tr>
		  		<td><strong>Email <sup>*</sup></strong></td>
		  		<td><input type="text" class="inputtext" name="email" style="width: 225px;" required/></td>
		  	</tr>
		  	<tr>
		  		<td></td>
		  		<td style="padding-top: 10px;"><input type="button" class="box-button" value="Verify" onclick="biomatcher(yourURL,token);" /> </td>
		  	</tr>
		  </table>
		 
		</form>
	</div>
</div>

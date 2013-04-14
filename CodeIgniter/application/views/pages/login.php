<div style="font-size: 2em; text-align: center; margin: 20px 0; position: relative;" id="page_title">
    <h1>Biomatcher</h1>
    <p style="font-size: 25px; text-align: center; margin: 20px 0; position: relative;">Biomatcher : a tool for matching digital images</p>
</div>

<div id="loginbox">
    <p style="font-size: 2em; text-align: center; padding: 15px 0; position: relative;">Login Here</p>
 
    <div id="loginform">
        <?php if($this->session->flashdata('message')) : ?>
        <div class="errorbox">
    	<?php echo $this->session->flashdata('message'); ?>
        </div>
        <?php endif; ?>
        <?php echo form_open('pages/do_login'); ?>
            <div class="inputbox">
                <label class="labelinput" for="input_username">Username</label>
                <input class="inputtext" id="input_username" type="text" name="username" value="<?php echo set_value('username'); ?>"/><br />
            </div>
            <?php echo form_error('username'); ?>
            <div class="inputbox">
                <label class="labelinput" for="input_password">Password</label>
                <input class="inputtext" id="input_password" type="password" name="password" value="<?php echo set_value('password'); ?>"/><br />
            </div>
            <?php echo form_error('password'); ?>
            <div class="inputbox">
                <input id="button_login" type="submit" name="Submit" class="button" value="Login" />
            </div>
        <?php echo form_close(); ?>
    </div>
    <p style="font-size: 2em; text-align: center; padding: 0 0 15px 0; position: relative;"><a href="<?php echo base_url(); ?>index.php/pages/register">Register</a></p>
    
</div>


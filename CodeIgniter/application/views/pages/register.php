<div id="registerbox">
    <div id="registerform">
        <?php echo form_open('pages/do_register'); ?>
            
            <div class="inputbox_reg">
                <label class="labelinput-reg" for="input_name">Name</label>
                <input class="inputtext-reg" id="input_name" type="text" name="name" value="<?php echo set_value('name'); ?>"/><br />
            </div>
            <div class="inputbox_reg">
                <label class="labelinput-reg" for="input_username">Username</label>
                <input class="inputtext-reg" id="input_username" type="text" name="username" value="<?php echo set_value('username'); ?>"/><br />
            </div>
            <?php echo form_error('username', '<div class="errorbox">', '</div>'); ?> 
            <div class="inputbox_reg">
                <label class="labelinput-reg" for="input_email">Email</label>
                <input class="inputtext-reg" id="input_email" type="text" name="email" value="<?php echo set_value('email'); ?>"/><br />
            </div>
            <?php echo form_error('email', '<div class="errorbox">', '</div>'); ?>        
            <div class="inputbox_reg">
                <label class="labelinput-reg" for="option_type">Type</label>
                <select class="inputoption" size="1" name="type" id="type">
                	<option value="consumer">Consumer</option>
                    <option value="supplier">Supplier</option>
                </select>
            </div>
            <div class="inputbox_reg">
                <label class="labelinput-reg" for="input_password">Password</label>
                <input class="inputtext-reg" id="input_password" type="password" name="password" value="<?php echo set_value('password'); ?>"/><br />
            </div>
            <?php echo form_error('password', '<div class="errorbox">', '</div>'); ?>             
            <div class="inputbox_reg">
                <label class="labelinput-reg" for="input_password">Confirm Password</label>
                <input class="inputtext-reg" id="input_conpassword" type="password" name="conpassword" value="<?php echo set_value('conpassword'); ?>"/><br />
            </div>
            <?php echo form_error('conpassword', '<div class="errorbox">', '</div>'); ?>             
            <div class="inputbox_reg">
                <input id="button_register" type="submit" name="Submit" class="box-button" value="Register" />
            </div>
        <?php echo form_close(); ?>
    </div>
    
</div>

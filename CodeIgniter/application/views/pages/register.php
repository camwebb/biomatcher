<div id="page_title">
    <h1>Biomatcher</h1>
    <p style="font-size: 25px; text-align: center; margin: 20px 0; position: relative;">Biomatcher : a tool for matching digital images</p>
</div>

<div id="registerbox">
    <p style="font-size: 2em; text-align: center; padding: 15px 0; position: relative;">Register</p>
    
    <div id="registerform">
    <div class="errorbox">
        <?php echo validation_errors('<p>'); ?>
    </div>
        <?php echo form_open('pages/do_register'); ?>
            <div class="inputbox_reg">
                <label class="labelinput" for="input_username">Username</label>
                <input class="inputtext" id="input_username" type="text" name="username" value="<?php echo set_value('username'); ?>"/><br />
            </div>
            
            <div class="inputbox_reg">
                <label class="labelinput" for="option_type">Type</label>
                <select class="inputoption" size="1" name="type" id="type">
                	<option value="consumer">Consumer</option>
                    <option value="supplier">Supplier</option>
                </select>
            </div>
            
            <div class="inputbox_reg">
                <label class="labelinput" for="input_password">Password</label>
                <input class="inputtext" id="input_password" type="password" name="password" value="<?php echo set_value('password'); ?>"/><br />
            </div>
            
            <div class="inputbox_reg">
                <label class="labelinput" for="input_password">Confirm Password</label>
                <input class="inputtext" id="input_conpassword" type="password" name="conpassword" value="<?php echo set_value('conpassword'); ?>"/><br />
            </div>
            
            <div class="inputbox_reg">
                <input id="button_register" type="submit" name="Submit" class="button" value="Register" />
            </div>
        <?php echo form_close(); ?>
    </div>
    
</div>

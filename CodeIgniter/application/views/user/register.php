<div class="wrapper">
<div id="content">
    <div style="float: right;">
        <span>
            <a href="<?php echo base_url(); ?>" style="float: right;">
                <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                <p style="float: right; margin-top: 7px;">Back to login page</p>
            </a>
        </span>
    </div>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    <div id="registerbox">
        <div id="registerform">
            <?php echo form_open('user/do_register', array('style'=> 'min-height:387px')); ?>
            
                <table style="float:left">                
                    <tr class="inputbox_reg">
                        <td><label class="labelinput-reg" for="input_name">Name</label></td>
                        <td><p style="padding: 0 30px;">:</p></td>
                        <td><input class="inputtext-reg" id="input_name" type="text" name="name" value="<?php echo set_value('name'); ?>"/></td>
                        <td><?php echo form_error('name', '<div class="errorbox">', '</div>'); ?></td>                          
                    </tr>
                    <tr class="inputbox_reg">
                        <td><label class="labelinput-reg" for="input_username">Username</label></td>
                        <td><p style="padding: 0 30px;">:</p></td>
                        <td><input class="inputtext-reg" id="input_username" type="text" name="username" value="<?php echo set_value('username'); ?>"/></td>    
                        <td><?php echo form_error('username', '<div class="errorbox">', '</div>'); ?></td>                                            
                    </tr>
                    <tr class="inputbox_reg">
                        <td><label class="labelinput-reg" for="input_email">Email</label></td>
                        <td><p style="padding: 0 30px;">:</p></td>
                        <td><input class="inputtext-reg" id="input_email" type="text" name="email" value="<?php echo set_value('email'); ?>"/></td>
                        <td><?php echo form_error('email', '<div class="errorbox">', '</div>'); ?></td>                                             
                    </tr>
                    <tr class="inputbox_reg">
                        <td><label class="labelinput-reg" for="option_type">Type</label></td>
                        <td><p style="padding: 0 30px;">:</p></td>
                        <td><select class="inputoption" size="1" name="type" id="type">
                    	<option value="consumer">Consumer</option>
                        <option value="supplier">Supplier</option>
                    </select></td>
                    </tr>
                    <tr class="inputbox_reg">
                        <td><label class="labelinput-reg" for="input_password">Password</label></td>
                        <td><p style="padding: 0 30px;">:</p></td>
                        <td><input class="inputtext-reg" id="input_password" type="password" name="password" value="<?php echo set_value('password'); ?>"/></td>
                        <td><?php echo form_error('password', '<div class="errorbox">', '</div>'); ?></td>
                    </tr>
                    <tr class="inputbox_reg">
                        <td><label class="labelinput-reg" for="input_password">Confirm Password</label></td>
                        <td><p style="padding: 0 30px;">:</p></td>
                        <td><input class="inputtext-reg" id="input_conpassword" type="password" name="conpassword" value="<?php echo set_value('conpassword'); ?>"/></td>
                        <td><?php echo form_error('conpassword', '<div class="errorbox">', '</div>'); ?></td>
                    </tr >
                    <tr class="inputbox_reg">
                        <td></td>
                        <td></td>
                        <td><input id="button_register" type="submit" name="Submit" class="box-button" value="Register" /></td>
                    </tr>                                                                                                                        
                </table>             

            <?php echo form_close(); ?>
        </div>
        
    </div>
    <div class="separator"></div>
</div>
</div>

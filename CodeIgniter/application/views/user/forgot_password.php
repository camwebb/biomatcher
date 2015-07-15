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
    
    <?php if($this->session->flashdata('message')) : ?>
    <div class="errorbox" style="padding: 0;"><?php echo $this->session->flashdata('message'); ?></div>
    <?php endif; ?>
    
    <?php if($this->session->flashdata('success')) : ?>
    <div class="successbox" style="padding: 0;"><?php echo $this->session->flashdata('success'); ?></div>
    <?php endif; ?>
    
    <div id="registerbox">
        <div id="registerform">
            <?php echo form_open('user/send_reset_link', array('style'=> 'min-height:387px')); ?>
            
                <table style="float:left">
                    <tr class="inputbox_reg">
                        <td><label class="labelinput-reg" for="input_email">Email</label></td>
                        <td><p style="padding: 0 30px;">:</p></td>
                        <td><input class="inputtext-reg" id="input_email" type="text" name="email" value="<?php echo set_value('email'); ?>" required/></td>
                        <td><?php echo form_error('email', '<div class="errorbox">', '</div>'); ?></td>                                             
                    </tr>
                    <tr class="inputbox_reg">
                        <td></td>
                        <td></td>
                        <td><input id="button_register" type="submit" name="Submit" class="box-button" value="Send Reset Link" /></td>
                    </tr>                                                                                                                        
                </table>             

            <?php echo form_close(); ?>
        </div>
        
    </div>
    <div class="separator"></div>
</div>
</div>
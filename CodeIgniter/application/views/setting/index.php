<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">Setting</h1>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    
    <div id="tabs">
      <ul>
        <li><a href="#profile">Profile</a></li>
        <li><a href="#password">Change Password</a></li>
      </ul>
      
      <div id="profile">
        <?php echo form_open('setting/do_profile',array('id'=>'form_profile')); ?>
        <table>
            <div id="success-profile" style="color: blue;"></div>
            <tr>
                <td>Name</td>
                <td>:</td>
                <td><input class="inputtext-setting" type="text" name="name" value="<?php echo $this->session->userdata('name') ?>"/></td>
                <td><div id="error-name" class="errorbox"></div></td>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input class="inputtext-setting" type="text" name="username" value="<?php echo $this->session->userdata('username') ?>"/></td>
                <td><div id="error-username" class="errorbox"></div></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td><input class="inputtext-setting" type="text" name="email" value="<?php echo $this->session->userdata('email') ?>"/></td>
                <td><div id="error-email" class="errorbox"></div></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input class="inputtext-setting" type="password" name="password" value=""/></td>
                <td><div id="error-password" class="errorbox"></div></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input class="box-button" type="submit" value="Save" /></td>
            </tr>
        </table>
        
        
        <?php echo form_close(); ?>
      </div>
      
      <div id="password">
        <?php echo form_open('setting/do_pass',array('id'=>'form_pass')); ?>
        <table>
            <div id="success-pass" style="color: blue;"></div>
            <tr>
                <td>Old Password</td>
                <td>:</td>
                <td><input class="inputtext-setting pass" type="password" name="old_pass" value=""/></td>
                <td><div id="error-old_pass" class="errorbox"></div></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td>:</td>
                <td><input class="inputtext-setting pass" type="password" name="new_pass" value=""/></td>
                <td><div id="error-new_pass" class="errorbox"></td>
            </tr>
            <tr>
                <td>Re-New Password</td>
                <td>:</td>
                <td><input class="inputtext-setting pass" type="password" name="renew_pass" value=""/></td>
                <td><div id="error-renew_pass" class="errorbox"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input class="box-button" type="submit" value="Save" /></td>
            </tr>
        </table>
        
        
        <?php echo form_close(); ?>
      </div>
      <div id="asd"></div>
    </div>
    
    <div class="separator"></div>

</div>

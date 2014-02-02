<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">Administrator Setting</h1>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    
    <div id="tabs">
      <ul>
        <li><a href="#profile">Profile</a></li>
        <li><a href="#password">Change Password</a></li>
      </ul>
      
      <div id="profile">
        <?php echo form_open('admin/profile_admin'); ?>
        <table>
            <tr>
                <td>Name</td>
                <td>:</td>
                <td><input class="inputtext-admin" type="text" name="name" value="<?php echo $this->session->userdata('name') ?>"/></td>
                <td><?php echo form_error('name', '<div class="errorbox">', '</div>'); ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td>:</td>
                <td><input class="inputtext-admin" type="text" name="username" value="<?php echo $this->session->userdata('username') ?>"/></td>
                <td><?php echo form_error('username', '<div class="errorbox">', '</div>'); ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>:</td>
                <td><input class="inputtext-admin" type="text" name="email" value="<?php echo $this->session->userdata('email') ?>"/></td>
                <td><?php echo form_error('email', '<div class="errorbox">', '</div>'); ?></td>
            </tr>
            <tr>
                <td>Password</td>
                <td>:</td>
                <td><input class="inputtext-admin" type="password" name="password" value=""/></td>
                <td><?php echo form_error('password', '<div class="errorbox">', '</div>'); ?></td>
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
      sd
      </div>
      
    </div>
    
    
    
    
    <div class="separator"></div>

</div>
<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">Administrator Setting</h1>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <?php echo form_open('admin/do_setting'); ?>
    <table>
        <tr>
            <td>Username</td>
            <td>:</td>
            <td><input class="inputtext-admin" type="text" name="username" value="<?php echo $this->session->userdata('username') ?>"/></td>
        </tr>
        <tr>
            <td>Old Password</td>
            <td>:</td>
            <td><input class="inputtext-admin" type="text" name="old_pass" value=""/></td>
        </tr>
        <tr>
            <td>New Password</td>
            <td>:</td>
            <td><input class="inputtext-admin" type="text" name="new_pass" value=""/></td>
        </tr>
        <tr>
            <td>Retype New Password</td>
            <td>:</td>
            <td><input class="inputtext-admin" type="text" name="re_new_pass" value=""/></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td><input class="box-button" type="submit" value="Save" /></td>
        </tr>
    </table>
    
    
    <?php echo form_close(); ?>
    <div class="separator"></div>

</div>
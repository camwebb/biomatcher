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
        <?php echo form_open('admin/pass_admin',array('id'=>'form_pass_admin')); ?>
        <table>
            <div id="error" class="errorbox"></div>
            <tr>
                <td>Old Password</td>
                <td>:</td>
                <td><input class="inputtext-admin" type="password" name="old_pass" value=""/></td>
                <td><div id="error-old_pass" class="errorbox"></div></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td>:</td>
                <td><input class="inputtext-admin" type="password" name="new_pass" value=""/></td>
                <td><div id="error-new_pass" class="errorbox"></td>
            </tr>
            <tr>
                <td>Re-New Password</td>
                <td>:</td>
                <td><input class="inputtext-admin" type="password" name="renew_pass" value=""/></td>
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

<script type="text/javascript">
$(document).ready(function() {
    $(function(){
        var url = '<?php echo base_url() ?>';
    $('#form_pass_admin').submit(function(evnt){
        evnt.preventDefault(); //Avoid that the event 'submit' continues with its normal execution, so that, we avoid to reload the whole page
        $.post(url+"index.php/admin/pass_admin", //The variable 'url' must store the base_url() of our application
        $("form#form_pass_admin").serialize(), //Serialize all the content of our form to URL format
        function (data) {
            console.log(data); //Add the AJAX response to some div that is going to show the message
            $("div#error").empty();
            $("div#error").prepend(data);
        });
    });
});    
});        

</script>

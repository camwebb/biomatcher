<div id="panel_login">
    <?php echo form_open('admin/do_login',array('id'=>'login')); ?>
        <h1>ADMIN</h1>
        <fieldset id="inputs">
            <input id="username" type="text" placeholder="Username" name="username" />   
            <input id="password" type="password" placeholder="Password" name="password" />
        </fieldset>
        <fieldset id="actions">
            <input type="submit" class="box-button" id="btn_login" value="Log in" />
        </fieldset>
    <?php echo form_close(); ?>
</div>

<?php if($this->session->flashdata('message')) : ?>
<div id="login-box" class="popup" style="display: block;"><?php echo $this->session->flashdata('message'); ?><br /><a class="box-button" id="close" style="background-color: red !important; margin-left: 38%; cursor: pointer;">OK</a></div>
<?php endif; ?>
<?php if(validation_errors()) : ?>
<div id="login-box" class="popup" style="display: block;"><?php echo validation_errors(); ?><a class="box-button" id="close" style="background-color: red !important; margin-left: 38%; cursor: pointer;">OK</a></div>
<?php endif; ?>
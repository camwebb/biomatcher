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
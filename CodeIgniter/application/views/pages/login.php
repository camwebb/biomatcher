<div id="page_title">
    <h1>Biomatcher</h1>
    <p style="font-size: 25px; text-align: center; margin: 20px 0; position: relative;">Biomatcher : a tool for matching digital images</p>
</div>

<div id="loginbox">
    <p style="font-size: 2em; text-align: center; padding: 15px 0; position: relative;">Login Here</p>
    
    <div id="loginform">
        <form id="login" action="<?php echo base_url(); ?>index.php/pages/login" method="POST">
            <div class="inputbox">
                <label class="labelinput" for="input_username">Username</label>
                <input class="inputtext" id="input_username" type="text" name="username"/><br />
            </div>
            <div class="inputbox">
                <label class="labelinput" for="input_password">Password</label>
                <input class="inputtext" id="input_password" type="password" name="password"/><br />
            </div>
            <div class="inputbox">
                <input id="button_login" type="submit" name="Submit" class="button" value="Login" />
            </div>
        </form>
    </div>
    <p style="font-size: 2em; text-align: center; padding: 0 0 15px 0; position: relative;"><a href="<?php echo base_url(); ?>index.php/pages/register">Register</a></p>
    
</div>


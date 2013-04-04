<?php
if ($this->session->userdata('error') !="") 
{
?>
<script language="javascript">alert("<?php echo $this->session->userdata('error'); ?>");</script>
<?php
    $this->session->unset_userdata('error');
}
?>

<div id="page_title">
    <h1>Biomatcher</h1>
    <p style="font-size: 25px; text-align: center; margin: 20px 0; position: relative;">Biomatcher : a tool for matching digital images</p>
</div>

<div id="registerbox">
    <p style="font-size: 2em; text-align: center; padding: 15px 0; position: relative;">Register</p>
    
    <div id="registerform">
        <form id="register" action="<?php echo base_url(); ?>index.php/pages/register" method="POST">
            <div class="inputbox">
                <label class="labelinput" for="input_username">Username</label>
                <input class="inputtext" id="input_username" type="text" name="username"/><br />
            </div>
            
            <div class="inputbox">
                <label class="labelinput" for="input_password">Password</label>
                <input class="inputtext" id="input_password" type="password" name="password"/><br />
            </div>
            
            <div class="inputbox">
                <label class="labelinput" for="option_type">Type</label>
                <select class="inputoption" size="1" name="type" id="type">
                	<option value="supplier">Supplier</option>
                    <option value="consumer">Consumer</option>
                </select>
            </div>
            
            <div class="inputbox">
                <input id="button_register" type="submit" name="Submit" class="button" value="Register" />
            </div>
        </form>
    </div>
    
</div>

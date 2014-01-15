<script type="text/javascript">
    SyntaxHighlighter.defaults['toolbar'] = false;
    SyntaxHighlighter.all()
</script>
<div class="wrapper">
    <div id="content">
        <div style="float: left;">
            <a class="box-button" onclick="regenerate_token(<?php echo $this->uri->segment(4); ?>)" >Re-Generate Code</a><br />
        </div>
    
        <div style="float: right;">
            <span>
                <a href="<?php echo base_url(); ?>index.php/pages/view/my_website" style="float: right;">
                    <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                    <p style="float: right; margin-top: 7px;">Back to My Website</p>
                </a>
            </span>
        </div>
        
        <div class="separator" style="float: left;"></div>
        <div class="clear"></div>
        
        <?php echo form_error('url', '<div class="errorbox">', '</div>'); ?>
        
        <div>
            <div class="group"><p>STEP 1</p></div>
            <h2 id="myToken"><?php echo $token; ?></h2>
            <pre class="brush: js">
                <script type="text/javascript" src="http://biomatcher.org/style/js/jquery-2.0.3.js"></script>
                <script type="text/javascript" src="http://biomatcher/biomatcher.org/captcha/biomatcher.js"></script>
            </pre>
        </div>
        <div>
            <div class="group"><p>STEP 2</p></div>
            <pre class="brush: js">
                <script type="text/javascript">
                    window.addEventListener( "message",
                    function (e) {
                        if(e.data == 'verified'){
                            //do something with your form ex. submit
                            document.forms["myForm"].submit();    
                        } 
                    },
                    false);
                    var yourURL = 'http://yourWebsite.com/';
                    var token = '<?php echo $token; ?>';
                </script>
            </pre>
        </div>
        
        <div>
            <div class="group"><p>STEP 3</p></div>
        </div>
        
        
        <br /><br />
    
        <div class="separator"></div>
    </div>
</div>
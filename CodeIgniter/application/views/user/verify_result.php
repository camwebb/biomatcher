<div class="wrapper">
<div id="content" style="text-align:center;">
    <?php if($result == 'success'){ ?>
        <p>Your account was successfully verified.</p>
        <p>Redirecting you to your account page in 5 seconds.</p>
        <p>Alternatively, click <a href="<?php echo base_url();?>user/profile">here</a> to go directly.</p>
        <script type="text/javascript">
            var redirect = function() {
                window.location = "<?php echo site_url();?>/setting";
            };
            setTimeout(redirect, 5000);
        </script>
    <?php } elseif($result == 'verified'){ ?>
        <p>Your account has been verified before.</p>
        <p>Redirecting you to homepage in 5 seconds.</p>
        <p>Alternatively, click <a href="<?php echo base_url();?>">here</a> to go directly.</p>
        <script type="text/javascript">
            var redirect = function() {
                window.location = "<?php echo site_url();?>";
            };
            setTimeout(redirect, 5000);
        </script>
    <?php }else{ ?>
        <p>Your account has been failed to be verified. Please check the URL in your email or contact our administrator.</p>
        <p>Redirecting you to homepage in 5 seconds.</p>
        <p>Alternatively, click <a href="<?php echo base_url();?>">here</a> to go directly.</p>
        <script type="text/javascript">
            var redirect = function() {
                window.location = "<?php echo site_url();?>";
            };
            setTimeout(redirect, 5000);
        </script>
    <?php } ?>
</div>
</div>

<div class="wrapper">
    <div id="content">
        <div>
        <a class="box-button" onclick="regenerate_token(<?php echo $this->uri->segment(4); ?>)" >Re-Generate My Token</a><br /><br />
        <h2 id="myToken"><?php echo $token; ?></h2>
        </div>
    </div>
</div>
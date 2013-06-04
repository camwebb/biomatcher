<div class="wrapper">
<div id="content">

    <h2 style="float: left;">Matching Images</h2>
    
    <!--<div style="float: right;">
        <span>
            <a href="<?php echo base_url(); ?>index.php/pages/view/projects" style="float: right;">
                <img style="float:left; margin-right: 8px;" src="<?php echo base_url(); ?>style/img/setting.png" />
                <p style="float: right; margin-top: 7px;">Setting</p>
            </a>
        </span>
    </div>-->
    
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <div id="match">
        <?php
        //data for image A
        $image_A = $imageformatch['shuffled_image_A']['md5sum'];
        $user_A = $this->session->userdata('username_A');
        $pid_A = $imageformatch['shuffled_image_A']['projectID'];
        
        //data for image B
        $image_B = $imageformatch['shuffled_image_B']['md5sum'];
        $user_B = $this->session->userdata('username_B');
        $pid_B = $imageformatch['shuffled_image_B']['projectID'];
        ?>
        <div id="image1">
            <a href="" style="float: right;">
                <img style="height: 410px; width:410px;" src="<?php echo base_url().'data/'.$user_A.'/'.$pid_A.'/img/500px/'.$image_A.'.500px.jpg' ?>" />
            </a>
        </div>
        <div id="image2">
            <a href="" style="float: right;">
                <img style="height: 410px; width:410px;" src="<?php echo base_url().'data/'.$user_B.'/'.$pid_B.'/img/500px/'.$image_B.'.500px.jpg' ?>" />
            </a>
        </div>
    </div>
    
</div>
</div>
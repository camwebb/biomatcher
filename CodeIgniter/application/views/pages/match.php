<script type="text/javascript">
$(document).ready(function() {
    $('html,body').animate({scrollTop:$("#menu").offset().top},500);
});
</script>
<div class="wrapper">
<div id="content">

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
            <a href="">
                <img src="<?php echo base_url().'data/'.$user_A.'/'.$pid_A.'/img/500px/'.$image_A.'.500px.jpg' ?>" />
            </a>
        </div>
        <div id="image2">
            <a href="">
                <img src="<?php echo base_url().'data/'.$user_B.'/'.$pid_B.'/img/500px/'.$image_B.'.500px.jpg' ?>" />
            </a>
        </div>
        
        <!--<div style="text-align: center;">
            <button class="box-button" id="sameMatch">Same</button>
            <button class="box-button" id="differentMatch">Different</button>
        </div>-->                
    </div>
    
</div>
</div>
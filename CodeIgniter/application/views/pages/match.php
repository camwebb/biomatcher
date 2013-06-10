<script type="text/javascript">
$(document).ready(function() {
    $('html,body').animate({scrollTop:$("#menu").offset().top},500);
    $('#page_menu').remove();
    $('#page_title').remove();
    $('#header').css('height', '41px');
});
</script>
<div class="wrapper">
<div id="content" style="margin-top: 5px;">

    <div id="match">
        <?php
        if($this->session->userdata('username_A')!= "" && $this->session->userdata('username_B')!= ""){
        //data for image A
            $image_A = $imageformatch['shuffled_image_A']['md5sum'];
            $user_A = $this->session->userdata('username_A');
            $pid_A = $imageformatch['shuffled_image_A']['projectID'];
            $imageA = $imageformatch['shuffled_image_A']['id'];
            
            //data for image B
            $image_B = $imageformatch['shuffled_image_B']['md5sum'];
            $user_B = $this->session->userdata('username_B');
            $pid_B = $imageformatch['shuffled_image_B']['projectID'];
            $imageB = $imageformatch['shuffled_image_B']['id'];
        ?>
        <div id="imageForMatch">
            <div id="image1">
                <a href="">
                    <img src="<?php echo base_url().'data/'.$user_A.'/'.$pid_A.'/img/500px/'.$image_A.'.500px.jpg' ?>" />
                </a>
            </div>
            
            <div class="separator"></div>
            
            <div id="image2">
                <a href="">
                    <img src="<?php echo base_url().'data/'.$user_B.'/'.$pid_B.'/img/500px/'.$image_B.'.500px.jpg' ?>" />
                </a>
            </div>
        </div>
        <?php
        }else{
        ?>
        <div id="noActiveProject"><p>No Active Project</p></div>
        <?php
        }
        ?>
        
        <div id="formMatch">
            <input type="hidden" name="imageA" value="<?php echo $imageA; ?>" />
            <input type="hidden" name="imageB" value="<?php echo $imageB; ?>" />
            <button class="box-button" id="sameMatch">Same</button>
            <button class="box-button" id="differentMatch">Different</button>
        </div>               
    </div>
    
</div>
</div>
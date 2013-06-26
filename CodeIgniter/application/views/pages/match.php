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
        if($this->session->userdata('username_pid')!= ""){
        //data for image matching
            $user = $this->session->userdata('username_pid');
            $pid = $imageformatch['shuffled_image_A']['projectID'];
            
            $image_A = $imageformatch['shuffled_image_A']['md5sum'];
            $image_B = $imageformatch['shuffled_image_B']['md5sum'];
            
            $imageIDA = $imageformatch['shuffled_image_A']['id'];
            $imageIDB = $imageformatch['shuffled_image_B']['id'];
        ?>
        <div id="imageForMatch">
            <div id="image1">
                <a href="">
                    <img src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/500px/'.$image_A.'.500px.jpg' ?>" />
                </a>
            </div>
            
            <div class="separator"></div>
            
            <div id="image2">
                <a href="">
                    <img src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/500px/'.$image_B.'.500px.jpg' ?>" />
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
            <input id="imageIDA" type="hidden" name="imageA" value="<?php echo $imageIDA; ?>" />
            <input id="imageIDB" type="hidden" name="imageB" value="<?php echo $imageIDB; ?>" />
            <button class="box-button" id="sameMatch">Same</button>
            <button class="box-button" id="differentMatch">Different</button>
            <p>Count matches : <?php echo $this->session->userdata('count_match'); ?></p>
        </div>               
    </div>
    
</div>
</div>
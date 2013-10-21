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

    <h2>Match</h2>
    
    <div class="separator"></div>
    <div class="clear"></div>

    <div id="match">
    
        <?php
        if($this->session->userdata('username_pid')!= ""){
        //data for image matching
        if($this->session->userdata('count_match')=="15"){
            $user = $pair_match['username_pre'];
            $pid = $pair_match['projectID_pre'];
            
            $image_A = $pair_match['shuffled_image_pre_A']['md5sum'];
            $image_B = $pair_match['shuffled_image_pre_B']['md5sum'];
            
            $imageIDA = $pair_match['shuffled_image_pre_A']['id'];
            $imageIDB = $pair_match['shuffled_image_pre_B']['id'];
        }
        else{
            $user = $this->session->userdata('username_pid');
            $pid = $imageformatch['shuffled_image_A']['projectID'];
            
            $image_A = $imageformatch['shuffled_image_A']['md5sum'];
            $image_B = $imageformatch['shuffled_image_B']['md5sum'];
            
            $imageIDA = $imageformatch['shuffled_image_A']['id'];
            $imageIDB = $imageformatch['shuffled_image_B']['id'];
        }
        ?>        
        
        <div id="image1">
            <a href="" style="float: left;">
                <img style="height: 410px; width:410px;" src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/500px/'.$image_A.'.500px.jpg' ?>" />
            </a>
        </div>
        <div id="image2">
            <a href="" style="float: right;">
                <img style="height: 410px; width:410px;" src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/500px/'.$image_B.'.500px.jpg' ?>" />
            </a>
        </div>
        
        <div class="clear"></div>
        <br />
        
        <div style="text-align: center;">
            <input id="imageIDA" type="hidden" name="imageA" value="<?php echo $imageIDA; ?>" />
            <input id="imageIDB" type="hidden" name="imageB" value="<?php echo $imageIDB; ?>" />
            <button class="box-button" id="sameMatch">Same</button>
            <button class="box-button" id="differentMatch">Different</button>
            <p>Dev. info : <?php if($this->session->userdata('count_match')=="15"){ echo "pre-known";}else{ echo $this->session->userdata('count_match');} ?></p>
        </div>
        
        <?php
        }else{
        ?>
        <div id="noActiveProject"><p>No Active Project</p></div>
        <?php
        }
        ?>
        <div class="clear"></div>
        
        
    </div> 
    
</div>
</div>
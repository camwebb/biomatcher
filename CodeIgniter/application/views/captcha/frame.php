<?php
    $attributes = array('id' => 'myform');
    echo form_open('captcha/si_test',$attributes);
    echo form_error('captcha');
?>
    <?php
    $user = $pair_match['username_pre'];
    $pid = $pair_match['projectID_pre'];
    
    $image_A = $pair_match['shuffled_image_pre_A']['md5sum'];
    $image_B = $pair_match['shuffled_image_pre_B']['md5sum'];
    
    $imageIDA = $pair_match['shuffled_image_pre_A']['id'];
    $imageIDB = $pair_match['shuffled_image_pre_B']['id'];
    ?>
    
    <div class="biomatcher">
            
        <div id="match" style="padding: 10px 25px" >
        
        <h2 align="center">See images below, and choose Same or Different.</h2>
    
        <ul class="biomatcher-ul-image" style="float: left;">
            <li><img class="biomatcher-image" src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/500px/'.$image_A.'.500px.jpg' ?>" /></li>
        </ul>
        
        <ul class="biomatcher-ul-image" style="float: right;">
            <li><img class="biomatcher-image" src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/500px/'.$image_B.'.500px.jpg' ?>" /></li>
        </ul>
            
        <div class="clear"></div>
            
        <div style="text-align: center;">
            <input type="radio" name="match" value="Same" id="same" /><label for="same">Same</label>
            <input type="radio" name="match" value="Different" id="different" /><label for="different">Different</label>
        </div>
        
        <div align="center">
            <p>
                <?php
                    echo img(array('src' => site_url('captcha/securimage'), 'alt' => 'captcha', 'id' => 'captcha'));
                    echo form_input(array('name' => 'captcha'));
                ?>          
                <button type="submit" class="biomatcher-box-button" id="sameMatch">Send Information</button>               
            </p>
                                    
    
        </div>       
        </div>
        
    </div>
<?php
echo form_close();	?>

    <script type="text/javascript">
        $(document).ready(function(){
    
        $('#sameMatch').click(function(){
            
    		if($('input:radio[name=match]').is(':checked')){
                $.ajax({
                  url: "test.html",
                  context: document.body
                }).done(function() {
                  $( this ).addClass( "done" );
                });
            }
            
            else{
                alert('Choose same of different');
            }
        });
        });
    </script>


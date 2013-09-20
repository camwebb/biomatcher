<div class="biomatcher">
<div style="height: 700px; width:725px;" >
    
    <div id="match" style="padding: 10px;" >
    
    <h2 align="center">See images below, and choose Same or Different.</h2><br />
        <div class="clear"></div>

        <ul class="biomatcher-ul-image" style="float: left;">
            <li><img class="biomatcher-image" src="" /></li>
        </ul>
        
        <ul class="biomatcher-ul-image" style="float: right;">
            <li><img class="biomatcher-image" src="" /></li>
        </ul>
        <div class="clear"></div>
        
        <div style="text-align: center;">
            <input type="radio" name="match" value="Same" id="same" /><label for="same">Same</label>
            <input type="radio" name="match" value="Different" id="different" /><label for="different">Different</label>
        </div>
        <div align="center">
            <p>
                <img id="siimage" style="border: 1px solid #000; margin-right: 15px;" src="<?php echo base_url().'securimage_files/'; ?>securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" />
                
                <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '<?php echo base_url().'securimage_files/'; ?>securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="<?php echo base_url().'securimage_files/'; ?>images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a><br />
                
                <input class="biomatcher-inputtext-reg" type="text" name="ct_captcha" size="12" maxlength="8" />
                
                
                <button type="submit" class="biomatcher-box-button" id="sameMatch">Send Information</button>               
            </p>

        </div>
        
    </div>
</div>
</div>
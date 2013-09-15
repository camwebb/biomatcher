<div style="height: 700px; width:725px;">
    
    <div id="match" style="padding: 10px;" ><!-- #match height = 641px -->
    
    <h2>See images below, and choose Same or Different.</h2><br />
        <div class="clear"></div>
        <!--<div id="image1">
            <a href="" style="float: left;">
                <img style="height: 310px; width:310px;" src="" />
            </a>
        </div>
        <div id="image2">
            <a href="" style="float: right;">
                <img style="height: 310px; width:310px;" src="" />
            </a>
        </div>-->
        <ul style="list-style: none; margin-right: 15px; padding: 0; float: left;">
            <li><img style="height: 310px; width:310px;" src="" /></li>
        </ul>
        
        <ul style="list-style: none; margin-right: 15px; padding: 0; float: right;">
            <li><img style="height: 310px; width:310px;" src="" /></li>
        </ul>
        <div class="clear"></div>
        
        <div style="text-align: center;">
            <input type="radio" name="match" value="Same" id="same" /><label for="same">Same</label>
            <input type="radio" name="match" value="Different" id="different" /><label for="different">Different</label>
        </div>
        <div align="center">
            <p>
                <img id="siimage" style="border: 1px solid #000; margin-right: 15px;" src="<?php echo base_url().'securimage_files/'; ?>securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" />
                
                <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '<?php echo base_url().'securimage_files/'; ?>securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="<?php echo base_url().'securimage_files/'; ?>images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="top" border="0" /></a><br />
                <input align="top" class="inputtext-reg" type="text" name="ct_captcha" size="12" maxlength="8" style="float:none; width:150px; height: 37px;" />
                <button type="submit" class="box-button" id="sameMatch">Submit</button>
                               
                
            </p>

        </div>
        
    </div>
</div>
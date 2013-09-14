    
    
    <div id="match" style="padding: 10px;" ><!-- #match height = 641px -->
    
    <h2>See images below, and choose Same or Different.</h2>
        <div class="clear"></div>
        <div id="image1">
            <a href="" style="float: left;">
                <img style="height: 310px; width:310px;" src="" />
            </a>
        </div>
        <div id="image2">
            <a href="" style="float: right;">
                <img style="height: 310px; width:310px;" src="" />
            </a>
        </div>
        <!--<ul style="list-style: none; padding: 15px 0; position: absolute;">
            <li><img style="height: 310px; width:310px;" src="" /></li>
            <li><img style="height: 310px; width:310px;" src="" /></li>
        </ul>
        <ul style="list-style: none; padding: 15px 0;">
            <li><img style="height: 310px; width:310px;" src="" /></li>
        </ul>-->
        <div class="clear"></div>
        <br />
        <div style="text-align: center;">
            <button class="box-button" id="sameMatch">Same</button>
            <button class="box-button" id="differentMatch">Different</button>
        </div>
        <div>
            <p>
                <img id="siimage" style="border: 1px solid #000; margin-right: 15px" src="<?php echo base_url().'securimage_files/'; ?>securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" />
                <object type="application/x-shockwave-flash" data="<?php echo base_url().'securimage_files/'; ?>securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?php echo base_url().'securimage_files/'; ?>images/audio_icon.png&amp;audio_file=<?php echo base_url().'securimage_files/'; ?>securimage_play.php" height="32" width="32">
                <param name="movie" value="<?php base_url().'securimage_files/'; ?>securimage_play.swf?bgcol=#ffffff&amp;icon_file=<?php echo base_url().'securimage_files/'; ?>images/audio_icon.png&amp;audio_file=<?php echo base_url().'securimage_files/'; ?>securimage_play.php" />
                </object>
                &nbsp;
                <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '<?php echo base_url().'securimage_files/'; ?>securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="<?php echo base_url().'securimage_files/'; ?>images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a><br />
                <strong>Enter Code*:</strong><br />
                <input type="text" name="ct_captcha" size="12" maxlength="8" />
            </p>
            
            <p>
                <br />
                <input type="submit" value="Submit Message" />
            </p>
        </div>
        
    </div>

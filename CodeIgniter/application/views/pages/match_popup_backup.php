<div class="wrapper">
<div id="content">

    <h2 style="float: left;">Match</h2>
    
    <div style="float: right;">
        <span>
            <a href="<?php echo base_url(); ?>index.php/pages/view/projects" style="float: right;">
                <img style="float:left; margin-right: 8px;" src="<?php echo base_url(); ?>style/img/setting.png" />
                <p style="float: right; margin-top: 7px;">Setting</p>
            </a>
        </span>
    </div>
    
    <div class="separator" style="float: left;"></div>
    <ol>
        <table style="width: 100%;">
            <?php
            foreach($list_project as $list){
            ?>
            <tr>
                <td style="width: 90%;">
                    <li><?php echo $list->name; ?></li>
                </td>
                <td>
                    <button class="box-button" id="openMatch_panel">Match</button>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </ol>
    
    <br />
    
    <div id="match" style="display: none;">
        <div style="float: right;">
            <span>
                <a href="<?php echo base_url(); ?>index.php/pages/view/match" style="float: right;">
                    <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                    <p style="float: right; margin-top: 7px;">Back</p>
                </a>
            </span>
        </div>
        <div class="clear"></div>
        <div id="image1">
            <a href="" style="float: right;">
                <img style="height: 410px; width:410px;" src="" />
            </a>
        </div>
        <div id="image2">
            <a href="" style="float: right;">
                <img style="height: 410px; width:410px;" src="" />
            </a>
        </div>
        <div class="clear"></div>
        <br />
        <div style="text-align: center;">
            <button class="box-button" id="sameMatch">Same</button>
            <button class="box-button" id="differentMatch">Different</button>
        </div>
        
    </div>
    
</div>
</div>
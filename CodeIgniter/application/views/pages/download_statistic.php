<div class="wrapper">
<div id="content">
    <?php
    foreach($project_title as $p_title){
    ?>
    <h2 style="float: left;"><?php echo $p_title->name; ?></h2>
    
    <div style="float: right;">
        <span>
            <a href="<?php echo base_url(); ?>index.php/pages/view/projects" style="float: right;">
                <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                <p style="float: right; margin-top: 7px;">Back to project</p>
            </a>
        </span>
    </div>
    
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <div id="download_same">
        <p style="font-size: 18px; font-weight: bold; margin: 20px 0 0 0 !important;">SAME</p>
        <img src="<?php echo base_url(); ?>style/img/CSV.png" />
        <p style="font-size: 14px;">Same_Statistic-<?php echo $p_title->name; ?>.csv</p>
        <a href="<?php echo base_url(); ?>index.php/pages/download_stats/<?php echo $p_title->id; ?>/same" class="box-button" style="margin: 5px 10px 0 10px;">Download</a>
    </div>
    <div id="download_different">
        <p style="font-size: 18px; font-weight: bold; margin: 20px 0 0 0 !important;">DIFFERENT</p>
        <img src="<?php echo base_url(); ?>style/img/CSV.png" />
        <p style="font-size: 14px;">Diff_Statistic-<?php echo $p_title->name; ?>.csv</p>
        <a href="<?php echo base_url(); ?>index.php/pages/download_stats/<?php echo $p_title->id; ?>/different" class="box-button" style="margin: 5px 10px 0 10px;">Download</a>
    </div>
    
    <div class="clear"></div>
    <?php } ?>
</div>
</div>
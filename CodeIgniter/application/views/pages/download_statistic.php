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
    
    <?php
    $same_content = '<img src="'.base_url().'style/img/CSV.png" />
                    <p style="font-size: 14px;">Same_Statistic-'.$p_title->name.'.csv</p>
                    <a href="'.base_url().'index.php/pages/download_stats/'.$p_title->id.'/same" class="box-button" style="margin: 5px 10px 0 10px;">Download</a>';
                    
    $diff_content = '<img src="'.base_url().'style/img/CSV.png" />
                    <p style="font-size: 14px;">Diff_Statistic-'.$p_title->name.'.csv</p>
                    <a href="'.base_url().'index.php/pages/download_stats/'.$p_title->id.'/different" class="box-button" style="margin: 5px 10px 0 10px;">Download</a>';
    
    foreach($count_condition as $get_count){
    if($get_count['same']==0 && $get_count['diff']>0){
    ?>
        <div id="download_same">
            <p style="font-size: 18px; font-weight: bold; margin: 20px 0 0 0 !important;">SAME</p>
            <p style="margin-top: 30px; font-style: italic;">There is no Same Statistic results.</p>
        </div>
        <div id="download_different">
            <p style="font-size: 18px; font-weight: bold; margin: 20px 0 0 0 !important;">DIFFERENT</p>
            <?php echo $diff_content; ?>
        </div>
        <div class="clear"></div>
    <?php } 
    else if($get_count['same']>0 && $get_count['diff']==0){
    ?>
        <div id="download_same">
            <p style="font-size: 18px; font-weight: bold; margin: 20px 0 0 0 !important;">SAME</p>
            <?php echo $same_content; ?>
        </div>
        <div id="download_different">
            <p style="font-size: 18px; font-weight: bold; margin: 20px 0 0 0 !important;">DIFFERENT</p>
            <p style="margin-top: 30px; font-style: italic;">There is no Different Statistic results.</p>
        </div>
        <div class="clear"></div>
    <?php
    }
    else if($get_count['same']==0 && $get_count['diff']==0){
        echo 'This project has not made matching process.';
    }
    else{ ?>
        <div id="download_same">
            <p style="font-size: 18px; font-weight: bold; margin: 20px 0 0 0 !important;">SAME</p>
            <?php echo $same_content; ?>
        </div>
        <div id="download_different">
            <p style="font-size: 18px; font-weight: bold; margin: 20px 0 0 0 !important;">DIFFERENT</p>
            <?php echo $diff_content; ?>
        </div>
        <div class="clear"></div>
    <?php } } } ?>
</div>
</div>
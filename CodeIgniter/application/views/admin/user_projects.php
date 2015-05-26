<div class="wrapper">
<div id="content">
    <?php
    foreach($user_data as $p_title){
    ?>
    <h2 style="float: left;"><?php echo $p_title->name; ?></h2>
    <? } ?>
    <div style="float: right;">
        <span>
            <a href="<?php echo base_url(); ?>index.php/admin/view/users" style="float: right;">
                <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                <p style="float: right; margin-top: 7px;">Back to users</p>
            </a>
        </span>
    </div>
    
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <?php foreach($for_type as $type)
        if ($type['type_project']=='supplier'){
    ?>    
    
    <div class="project_table">
        <table style="width: 100%;" id="projectTable">
            <thead>
                <tr>
                    <td>
                        <p>Project Name</p>
                    </td>
                    <td>
                        <p>Owner</p>
                    </td>
                    <td>
                        <p>Action</p>
                    </td>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($user_projects as $projects){
            ?>
                <tr>
                    <td>
                        <p><?php echo $projects->project_name;?></p>
                    </td>
                    <td><?php echo $projects->name; ?></td>
                    <td style="width: 33%; text-align: center;">
                        <a href="<?php echo base_url(); ?>index.php/admin/view/project/<?php echo $projects->project_id; ?>" class="box-button">Go</a>
                        <a href="<?php echo base_url(); ?>index.php/admin/view/statistic/<?php echo $projects->project_id; ?>" class="box-button">Statistic</a>
                    </td>
                   
                </tr>
             <?php
                }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php
            }
            else if ($type['type_project']=='consumer'){
        ?>
        
        <div class="project_table">
        <table style="width: 100%;" id="projectTable">
            <thead>
                <tr>
                    <td>
                        <p>Site URL</p>
                    </td>
                    <td>
                        <p>Activated</p>
                    </td>
                    <td>Success of QC</td>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($user_projects as $projects){
            ?>
                <tr>
                    <td style="width: 50%;">
                        <p><?php echo $projects['site_url']; ?></p>
                    </td>
                    <td>
                        <?php if ($projects['url_activated'] == '1'){
                            $activated = "Yes";
                        }else{
                            $activated = "No"; 
                        } ?>
                        <p><?php echo $activated; ?></p>
                    </td>
                    <td><p><?php echo $projects['success_QC'] ?> %</p></td>
                   
                </tr>
             <?php
                }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php
            }
        ?>
        
    <br />
    
    <div class="separator"></div>
    
</div>

</div>
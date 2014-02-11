<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">User Project</h1>
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
                        <p><?php echo $projects->project_name; ?></p>
                    </td>
                    <td><?php echo $projects->project_name; ?></td>
                    <td style="width: 33%; text-align: center;">
                        <a href="<?php echo base_url(); ?>index.php/pages/view/project/<?php //echo $list->project_id; ?>" class="box-button">Go</a>
                        <a href="<?php echo base_url(); ?>index.php/pages/view/statistic/<?php //echo $list->project_id; ?>" class="box-button">Statistic</a>
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
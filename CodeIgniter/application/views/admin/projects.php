<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">All Project</h1>
    <div id="pagination" style="float: right;"> <?php echo $this->pagination->create_links(); ?> </div>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
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
                foreach($list_project as $list){
            ?>
                <tr>
                    <td>
                        <p><?php echo $list->project_name; ?></p>
                    </td>
                    <td><?php echo $list->user_name; ?></td>
                    <td style="width: 33%; text-align: center;">
                        <a href="<?php echo base_url(); ?>index.php/admin/view/project/<?php echo $list->project_id; ?>" class="box-button">Go</a>
                        <a href="<?php echo base_url(); ?>index.php/admin/view/statistic/<?php echo $list->project_id; ?>" class="box-button">Statistic</a>
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
    </div>
    <br />
    
    <div class="separator"></div>
    
</div>

</div>
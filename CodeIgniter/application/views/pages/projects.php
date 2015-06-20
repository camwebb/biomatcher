<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">Your Projects</h1>
    <div id="pagination" style="float: right;"> <?php echo $this->pagination->create_links(); ?> </div>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <?php echo form_error('nameProject', '<div class="errorbox">', '</div>'); ?>
    <?php echo form_error('qcSet', '<div class="errorbox">', '</div>'); ?>
    <?php 
        $page=$this->uri->segment(4, 0);
        $number=$page+1;
        if($this->agent->is_browser('Chrome')){
            $top="-21px";
            $top_btn = "-19";
            $top_btn_del = "-18";
        }
        else{
            $top="0";
            $top_btn = "3";
            $top_btn_del = "4";
        }
    ?>

    <div class="project_table" id="files">
        <table style="width: 100%;" id="projectTable">
            <thead>
                <tr>
                    <td>
                        <p>PROJECT NAME</p>
                    </td>
                    <td colspan = "4" style="text-align: center;">
                        <p>ACTION</p>
                    </td>
                </tr>
            </thead>
            
            <tbody id="test">
            <?php
                foreach($list_project as $list){
            ?>
                
                <tr>
                    <td>
                        <?php echo $list->name; ?>
                    </td>
                    <td style="width: 50px; text-align: center;">
                        <a class="project-btn-edit hvr-bounce-in" >
                            <img title="Rename Project" src="<?php echo base_url(); ?>style/img/edit.png" />
                        </a>
                    </td>
                    <td style="width: 50px; text-align: center;">
                        <!-- project_delete class is used in javascript -->
                        <a class="project-btn-edit hvr-bounce-in project_delete" title="<?php echo $list->id; ?>">
                            <img title="Delete Project" src="<?php echo base_url(); ?>style/img/delete.png" />
                        </a>
                    </td>
                    <td style="width: 50px; text-align: center;">
                        <a href="<?php echo base_url(); ?>index.php/pages/view/project/<?php echo $list->id; ?>" class="project-btn-edit hvr-bounce-in" >
                            <img title="View Project" src="<?php echo base_url(); ?>style/img/view.png" />
                        </a>
                    </td>
                    <td style="width: 50px; text-align: center;">
                        <a href="<?php echo base_url(); ?>index.php/pages/view/statistic/<?php echo $list->id; ?>" class="project-btn-edit hvr-bounce-in" >
                            <img title="Statistic Project" src="<?php echo base_url(); ?>style/img/statistic.png" />
                        </a>
                    </td>
                </tr>
                
            <?php
            }
            ?>
            </tbody>  
        </table>
    </div>
    
    <br />
    
    <button class="box-button" id="addProject">Add Project</button>
    <br /><br />
    
    <div id="addProject_panel" class="custom_panel">
        <?php echo form_open('pages/do_addProject',array('id'=>'form_addProject')); ?>
            
            <div class="inputbox_addProject">
                <label class="labelinput-addProject" for="input_nameProject">Name of Project</label>
                <input class="inputtext-addProject" id="input_nameProject" type="text" name="nameProject" value="<?php echo set_value('nameProject'); ?>"/><br />
            </div>
            <div class="inputbox_addProject">
                <label class="labelinput-addProject" for="option_qcset">QC Set</label>
                <select class="inputoption" size="1" name="type" id="option_qcset">
                	<option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
            </div>
            <div class="inputbox_addProject">
                <input id="button_addProject" type="submit" name="Submit" class="box-button" value="Add Project" />
                <input class="box-button button_cancelProject" type="button" id="button_cancelProject" style="margin-right: 5px;" value="Cancel" />
            </div>
        <?php echo form_close(); ?>
    </div>
    
    <div id="del_project_panel" class="custom_panel" >
        <?php //echo form_open('project/',array('id'=>'form_del_project')); ?>
            <div id="alert_delete" class="messagebox" style="padding: 0 !important; width:400px;">Test</div>
            <div id="hidden-input">
            </div>
            <div class="inputbox_addProject" style="width: 400px;">
                <input id="project_cancel_del" class="box-button" type="button" value="Cancel" />
                <input id="project_del_cascade" class="box-button button_cancelProject" type="submit" name="Submit" value="Delete" />
            </div>
        <?php //echo form_close(); ?>
    </div>
    
    <div class="separator"></div>
    
</div>

</div>
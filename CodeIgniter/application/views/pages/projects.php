<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">Your Projects</h1>
    <div id="pagination" style="float: right;"> <?php echo $this->pagination->create_links(); ?> </div>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <?php echo form_error('nameProject', '<div class="errorbox">', '</div>'); ?>
    <?php echo form_error('qcSet', '<div class="errorbox">', '</div>'); ?>
    
    <ol>
        <table style="width: 100%;">
            <?php
            foreach($list_project as $list){
            ?>
            <tr>
                <td style="width: 80%;">
                    <li><?php echo $list->name; ?></li>
                </td>
                <td>
                    <a href="<?php echo base_url(); ?>index.php/pages/view/project/<?php echo $list->id; ?>" class="box-button">Go</a>
                </td>
                <td>
                    <a href="<?php echo base_url(); ?>index.php/pages/view/statistic/<?php echo $list->id; ?>" class="box-button">Statistic</a>
                </td>                
            </tr>
            <?php
            }
            ?>
        </table>
    </ol>
    
    <br />
    
    <button class="box-button" id="addProject">Add Project</button>
    <br /><br />
    
    <div id="addProject_panel">
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
                <input class="box-button" type="button" id="button_cancelProject" style="margin-right: 5px;" value="Cancel" />
            </div>
        <?php echo form_close(); ?>
    </div>
    
    <div class="separator"></div>
    
</div>

</div>
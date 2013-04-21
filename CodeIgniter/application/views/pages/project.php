<div class="wrapper">
<div id="content">
    <?php
    foreach($project_title as $p_title){
    ?>
    <h2 style="float: left;"><?php echo $p_title->name; ?></h2>
    <?php
    }
    ?>
    <div style="float: right;">
        <span>
            <a href="<?php echo base_url(); ?>index.php/pages/view/projects" style="float: right;">
                <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                <p style="float: right; margin-top: 7px;">Back to project</p>
            </a>
        </span>
    </div>
    
    <div class="separator" style="float: left;"></div>

    <div class="project_table">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td>
                        <p>FILENAME</p>
                    </td>
                    <td>
                        <p>LABEL</p>
                    </td>
                    <td>
                        <p>THUMBNAIL</p>
                    </td>
                    <td style="width: 42px; text-align: center;">
                        <p>EDIT</p>
                    </td>
                    <td style="width: 60px; text-align: center;">
                        <p>DELETE</p>
                    </td>
                </tr>
            </thead>

            <tbody>
            <?php
            foreach ($list_images as $images){
            ?>
                
                <tr>
                    <td>
                        <p><?php echo $images->nameOri; ?></p>
                    </td>
                    <td><?php echo $images->label; ?></td>
                    <td>
                        <p>XXX</p>
                    </td>
                    <td style="text-align: center;">
                        <input type="radio" name="edit"/>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" />
                    </td>
                </tr>
                
            <?php
            }
            ?>
            </tbody>

            <tfoot>
                <tr style="height: 50px;">
                    <td>
                        <button class="box-button" id="upl_img">Upload Image</button>
                    </td>
                    <td>
                        <button class="box-button" id="add_label">Add Label</button>  
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        <button class="box-button" id="edit">Edit</button>
                    </td>
                    <td>
                        <button class="box-button" id="delete">Delete</button>
                    </td>
                </tr>
            </tfoot>    
        </table>
    </div>
   <br /><br />
   
   <div id="addProject_panel">
        <?php echo form_open_multipart('pages/do_upload'); ?>
            
            <div class="inputbox_Upload">
                <label class="labelinput-upload" for="zipped_file">Zipped File</label>
                <input class="inputtext-upload" id="zipped_file" type="file" name="zipped_file" value="<?php echo set_value('zipped_file'); ?>"/><br />
            </div>
            <?php echo form_error('zipped_file', '<div class="errorbox">', '</div>'); ?>            
            <div class="inputbox_Upload">
                <input id="button_Upload" type="submit" name="Submit" class="box-button" value="Upload" />
                <a class="box-button" id="button_cancelUpload" style="margin-right: 5px;">Cancel</a>
            </div>
        <?php echo form_close(); ?>
    </div>
   
    <div class="separator"></div>
</div>

</div>
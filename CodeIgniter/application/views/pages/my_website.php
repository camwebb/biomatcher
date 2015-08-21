<div class="wrapper">
    <div id="content">
        <h2 style="float: left;">My Website</h2>  
    
        <div style="float: right;">
            <button class="box-button" id="site_reg">Register My Website</button>
            <a href="<?php echo base_url();?>index.php/demo" class="box-button">Demo Page</a>
            <!--<span>
                <a href="<?php echo base_url(); ?>index.php/pages/view/projects" style="float: right;">
                    <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                    <p style="float: right; margin-top: 7px;">Back to project</p>
                </a>
            </span>-->
        </div>
        
        <div class="separator" style="float: left;"></div>
        <div class="clear"></div>
        
        <div id="pagination" style="margin-bottom: 5px;"> <?php echo $this->pagination->create_links(); ?> </div>
        
        <?php echo form_error('url', '<div class="errorbox">', '</div>'); ?>
        <?php echo form_error('renameProject', '<div class="errorbox">', '</div>'); ?>

        <?php if($this->session->flashdata('message')) : ?>
        <div class="errorbox" style="padding: 0;"><?php echo $this->session->flashdata('message'); ?></div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('success')) : ?>
        <div class="successbox" style="padding: 0;"><?php echo $this->session->flashdata('success'); ?></div>
        <?php endif; ?>
        
        <div class="project_table" id="files">
            <table style="width: 100%;" id="projectTable">
                <thead>
                    <tr>
                        <td style="width: 70%;" >
                            <p>Website</p>
                        </td>
                        <td colspan = "3" style="text-align: center;">
                            <p>Action</p>
                        </td>
                    </tr>
                </thead>
                
                <tbody id="test">
                    <?php if (!empty($site)){ ?>
                    <?php foreach ($site as $user_site){ ?>
                    <tr>
                        <td style="width: 70%;" >
                            <p><?php echo $user_site->url; ?></p>
                        </td>
                        <td style="width: 50px; text-align: center;">
                            <a class="project-btn-edit hvr-bounce-in renameProject" data-name="<?php echo $user_site->url; ?>" data-id="<?php echo $user_site->id; ?>">
                                <img title="Rename Project" src="<?php echo base_url(); ?>style/img/edit.png" />
                            </a>
                        </td>
                        <td style="width: 50px; text-align: center;">
                            <!-- project_delete class is used in javascript -->
                            <a class="project-btn-edit hvr-bounce-in website_delete" data-id="<?php echo $user_site->id; ?>">
                                <img title="Delete Project" src="<?php echo base_url(); ?>style/img/delete.png" />
                            </a>
                        </td>
                        <td style="width: 50px; text-align: center;">
                            <a href="<?php echo base_url().'index.php/pages/view/get_code/'.$user_site->id; ?>" class="project-btn-edit hvr-bounce-in" >
                                <img title="Get Code" src="<?php echo base_url(); ?>style/img/view.png" />
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php } ?>
                </tbody> 
            </table>
        </div>
        <br /><br />
        
        <div id="addProject_panel" class="custom_panel">
        <?php echo form_open('pages/add_site'); ?>
            
            <div class="inputbox_addProject">
                <label class="labelinput-addProject" for="url">URL</label>
                <input class="inputtext-addProject wide" id="url" type="text" name="url" value="<?php echo set_value('url'); ?>"/><br />
            </div>
            <div class="inputbox_addProject">
                <input id="button_addProject" type="submit" name="Submit" class="box-button" value="Register" />
                <input class="box-button" type="button" id="button_cancelProject" style="margin-right: 5px;" value="Cancel" />
            </div>
        <?php echo form_close(); ?>
        </div>

        <div id="renameProject_panel" class="custom_panel">
        <?php echo form_open('pages/do_renameWebsite',array('id'=>'form_renameProject')); ?>
            
            <div class="inputbox_renameProject">
                <label class="labelinput-renameProject" for="input_renameProject">Website URL</label>
                <input class="inputtext-renameProject" id="input_renameProject" type="text" name="renameProject"/><br />
            </div>
            <input type="hidden" name="idProject" id="input_idProject">
            <input type="hidden" name="oldName" id="input_oldName">
            <br>
            <div class="inputbox_addProject">
                <input class="box-button button_cancelProject" type="button" id="button_cancelRename" style="margin-left: 5px;" value="Cancel" />
                <input id="button_renameProject" type="submit" name="Submit" class="box-button" value="Rename Project" />
            </div>
        <?php echo form_close(); ?>
        </div>

        <div id="del_website_panel" class="custom_panel" >
        <?php echo form_open('pages/do_deleteWebsite',array('id'=>'form_del_website')); ?>
            <div id="alert_delete" class="messagebox" style="padding: 0 !important; width:400px;">
                Are you sure you want to delete you website URL?
            </div>
            <div id="hidden-input"></div>
            <div class="inputbox_addProject">
                <input class="box-button button_cancelProject" type="button" id="button_cancelDelWebsite" style="margin-left: 5px;" value="Cancel" />
                <input id="project_del_cascade" type="submit" name="Submit" class="box-button" value="Delete" />
            </div>
        <?php echo form_close(); ?>
        </div>
    
        <div class="separator"></div>
    </div>
</div>
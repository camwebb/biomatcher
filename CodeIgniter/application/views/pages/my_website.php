<div class="wrapper">
    <div id="content">
        <h2 style="float: left;">My Website</h2>  
    
        <div style="float: right;">
            <button class="box-button" id="site_reg">Register My Website</button>
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
        
        <div class="project_table" id="files">
            <table style="width: 100%;" id="projectTable">
                <thead>
                    <tr>
                        <td style="width: 70%;" >
                            <p>Website</p>
                        </td>
                        <td>
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
                        <td>
                            <p align="center">
                                <a href="<?php echo base_url().'index.php/pages/view/get_code/'.$user_site->id; ?>" class="box-button" align="center">Get Code</a>
                            </p>
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
    
        <div class="separator"></div>
    </div>
</div>
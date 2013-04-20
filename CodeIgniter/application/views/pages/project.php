<div class="wrapper">
<div id="content">
    
    <h2 style="float: left;">Fish of Borneo</h2>
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
                <tr>
                    <td>
                        <p>IMG1.JPG</p>
                    </td>
                    <td></td>
                    <td>
                        <p>XXX</p>
                    </td>
                    <td style="text-align: center;">
                        <input type="radio" value="1" name="edit"/>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>IMG1.JPG</p>
                    </td>
                    <td>
                        <p>Fish</p>    
                    </td>
                    <td>
                        <p>XXX</p>
                    </td>
                    <td style="text-align: center;">
                        <input type="radio" value="0" name="edit"/>							
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" />
                    </td>
                </tr>
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
   
    <div class="separator"></div>
</div>

</div>
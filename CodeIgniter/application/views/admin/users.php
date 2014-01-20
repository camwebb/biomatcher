<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">All Project</h1>
    <div id="pagination" style="float: right;"> <?php echo $this->pagination->create_links(); ?> </div>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <div class="project_table" id="files">
        <table style="width: 100%;" id="projectTable">
            <thead>
                <tr>
                    <td>
                        <p>Name</p>
                    </td>
                    <td>
                        <p>Username</p>
                    </td>
                    <td>
                        <p>Email</p>
                    </td>
                    <td>
                        <p>Type</p>
                    </td>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($list_user as $list){
            ?>
                <tr>
                    <td><p><?php echo $list->name; ?></p></td>
                    <td><p><?php echo $list->username; ?></p></td>
                    <td><p><?php echo $list->email; ?></p></td>
                    <td><p><?php echo $list->type; ?></p></td>
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
    <br />
    
    <div class="separator"></div>
    
</div>

</div>
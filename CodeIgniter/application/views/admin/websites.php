<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">All Website</h1>
    <div id="pagination" style="float: right;"> <?php echo $this->pagination->create_links(); ?> </div>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <div class="project_table">
        <table style="width: 100%;" id="projectTable">
            <thead>
                <tr>
                    <td>
                        <p>Website URL</p>
                    </td>
                    <td>
                        <p>Owner</p>
                    </td>
                    <td>
                        <p>Activated</p>
                    </td>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($list_website as $list){
            ?>
                <tr>
                    <td><p><?php echo $list->url; ?></p></td>
                    <td><p><?php echo $list->name; ?></p></td>
                    <?php
                        if($list->url_activated == 1){
                            $activated = 'Yes';
                        }
                        else{
                            $activated = 'No';
                        }
                    ?>
                    
                    <td><p><?php echo $activated; ?></p></td>
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
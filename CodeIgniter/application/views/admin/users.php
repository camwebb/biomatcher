<div class="wrapper">
<div id="content">
    
    <h1 style="float: left;">All User</h1>
    <div id="pagination" style="float: right;"> <?php echo $this->pagination->create_links(); ?> </div>
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <div class="project_table">
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
                    <td>
                        <p>Action</p>
                    </td>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach($list_user as $list){
                    if($list->type == 'supplier'){
                        $link = base_url().'index.php/admin/view/user_projects/'.$list->id;
                        $action = 'List Projetcs';
                    }
                    else if($list->type == 'consumer'){
                        $link = base_url().'index.php/admin/view/user_projects/'.$list->id;
                        $action = 'List Websites';
                    } 
                    else{
                        $link = base_url().'index.php/admin/view/setting';
                        $action = 'Setting';
                    }
                    
            ?>
                <tr>
                    <td><p><?php echo $list->name; ?></p></td>
                    <td><p><?php echo $list->username; ?></p></td>
                    <td><p><?php echo $list->email; ?></p></td>
                    <td><p><?php echo $list->type; ?></p></td>
                    <td style="text-align: center;"><a href="<?php echo $link; ?>" class="box-button" style="min-width: 113px;"><?php echo $action; ?></a></td>
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
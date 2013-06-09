<div class="wrapper">
<div id="content">
    <?php
    foreach($project_title as $p_title){
    ?>
    <h2 style="float: left;"><?php echo $p_title->name; ?></h2>  
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <h3 style="margin-top: 20px;">Total Matches : </h3>
    
    <div class="project_table" id="files">
        <table style="width: 100%;" id="projectTable">
            <thead>
                <tr>
                    <td>
                        <p>Project A</p>
                    </td>
                    <td>
                        <p>Project B</p>
                    </td>
                    <td>
                        <p>Same</p>
                    </td>
                    <td>
                        <p>Different</p>
                    </td>
                </tr>
            </thead>
            
            <tbody id="test">
            <?php
                foreach($get_projectB as $projectB){
                foreach($get_projectA as $projectA) {           
            ?>
                <tr>
                    <td>
                        <p><?php echo $projectA->nameOri;?></p>
                    </td>
                    <td>
                        <p><?php echo $projectB->nameOri; ?></p>
                    </td>
                    <td>
                        <p>3</p>
                    </td>
                    <td>
                        <p>4</p>
                    </td>
                </tr> 
             <?php } } ?>   
            </tbody> 
        </table>
    </div>
    <br /><br />
    
    
    
</div>
<?php
    }
    ?>
</div>
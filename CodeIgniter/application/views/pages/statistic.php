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
                    $project_id = $this->uri->segment(4, 0);
                    $this->db->distinct();
                    $this->db->select('imageA,imageB');    
                    $this->db->from('matches');
                    $this->db->join('image', 'matches.imageA = image.id');
                    $this->db->where('projectID', $project_id); 
                    $query = $this->db->get();
                    foreach ($query->result() as $row)
                    {
                       $imageA_id=$row->imageA;
                       $imageB_id=$row->imageB;
                       $query2=$this->db->query("SELECT same FROM matches WHERE imageA=$imageA_id and imageB=$imageB_id and same='yes'");
                       $query3=$this->db->query("SELECT same FROM matches WHERE imageA=$imageA_id and imageB=$imageB_id and same='no'");
                       $same= $query2->result_array();
                       $diff= $query3->result_array();    
                       $count_same = count($same); 
                       $count_diff = count($diff);        
            ?>
                <tr>
                    <td>
                        <p><?php echo $imageA_id;?></p>
                    </td>
                    <td>
                        <p><?php echo $imageB_id; ?></p>
                    </td>
                    <td>
                        <p><?php echo $count_same; ?></p>
                    </td>
                    <td>
                        <p><?php echo $count_diff; ?></p>
                    </td>
                </tr> 
             <?php } //} ?>   
            </tbody> 
        </table>
    </div>
    <br /><br />
    
    
    
</div>
<?php
    }
    ?>
</div>
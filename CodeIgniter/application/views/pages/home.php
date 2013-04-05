<?php
if ($this->session->userdata('username') ==""){
    redirect(base_url().'index.php/pages/login', 'refresh');
}
?>
<h1>Biomatcher</h1>
<p>Biomatcher : a tool for matching digital images</p>


<span>Welcome, 
    <b><?php echo $this->session->userdata('username') ?></b>
</span>

<a href="<?php echo base_url(); ?>index.php/pages/logout">Logout</a>
<h1>Biomatcher</h1>
<p>Biomatcher : a tool for matching digital images</p>
<?php
if ($this->session->userdata('username') !="")
{
echo '

<span>Welcome, 
    <b>'.$this->session->userdata('username').'</b>
</span>

<a href="logout">Logout</a>';
}else{
echo '<span>Login First</span>';
}
?>
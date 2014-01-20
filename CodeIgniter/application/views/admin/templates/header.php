<html>
<head>
	<title>Administrator :: <?php echo $title ?></title>
    <link href="<?php echo base_url(); ?>style/css/style.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Noto+Serif' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'/>
</head>

<body>

<?php
    $selected = $title;
    if ($this->session->userdata('type') == 'admin' ){   
?>    

<div id="header">
<div class="wrapper">
    <div id="wrap-header">
        <div id="page_title">
            <h1 style="font-size: 31px; text-align: left; margin-top: 20px;">Biomatcher-Administrator</h1>
            <p style="font-size: 20px; text-align: left;">A tool for matching digital images</p>
        </div>
        <div id="page_menu">
            <div style="float: left; padding-top: 13px;">
                <p>Welcome, <?php echo $this->session->userdata('name'); ?></p>
            </div>
            <div id="cmenu">
            <!-- menu -->
                <ul class="dropdown2">
                    <li><a href="javascript:void(0)"><span><img style="padding: 8px 10px;" src="<?php echo base_url(); ?>style/img/arrow.png"/></span></a>
                    <ul class="sub_menu">
                        <li><a style="padding-left: 15px;" href="<?php echo base_url(); ?>index.php/admin/logout">Logout</a></li>
                    </ul>
                    </li>
                </ul>
            <!-- close menu -->
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div id="menu">
            <ul class="tabs">
              <li id="scroll_logout" style="display: none;"><a href="#">Logout</a></li>
              <li class="<?php echo $selected == 'Websites'?'selected':''; ?>"><a href="<?php echo base_url(); ?>index.php/admin/view/websites">Web Pages</a></li>
              <li class="<?php echo $selected == 'Users'?'selected':''; ?>"><a href="<?php echo base_url(); ?>index.php/admin/view/users">Users</a></li>
              <li class="<?php echo $selected == 'Projects'?'selected':''; ?>"><a href="<?php echo base_url(); ?>index.php/admin/view/projects">Projects</a></li>
            </ul>
        </div>
            </div>
</div>
</div>





<?php                                
            
    }
?>
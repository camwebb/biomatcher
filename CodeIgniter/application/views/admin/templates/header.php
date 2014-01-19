<html>
<head>
	<title>Biomatcher :: <?php echo $title ?></title>
    <link href="<?php echo base_url(); ?>style/css/style.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Noto+Serif' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'/>
</head>

<body>

<?php
    //later will be session
    if ($title == 'Admin-projects'){
        
    
?>    

<div id="header">
<div class="wrapper">
    <div id="wrap-header">
        <div id="page_title">
            <h1 style="font-size: 2.9em; text-align: left;">Biomatcher</h1>
            <p style="font-size: 20px; text-align: left;">A tool for matching digital images</p>
        </div>
        <div id="page_menu">
            <div style="float: left; padding-top: 13px;">
                <p>Welcome, Kartika Siregar</p>
            </div>
            <div id="cmenu">
            <!-- menu -->
                <ul class="dropdown2">
                    <li><a href="javascript:void(0)"><span><img style="padding: 8px 10px;" src="http://192.168.56.10/biomatcher/biomatcher.org/style/img/arrow.png"/></span></a>
                    <ul class="sub_menu">
                        <li><a style="padding-left: 15px;" href="http://192.168.56.10/biomatcher/biomatcher.org/index.php/pages/logout">Logout</a></li>
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
              <li class=""><a href="#">Web Pages</a></li>
              <li class=""><a href="#">User</a></li>
              <li class="selected"><a href="#">Projects</a></li>
            </ul>
        </div>
            </div>
</div>
</div>





<?php                                
            
    }
?>
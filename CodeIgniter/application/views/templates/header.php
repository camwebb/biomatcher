<html>
<head>
	<title>Biomatcher :: <?php echo $title ?></title>
    <link href="<?php echo base_url(); ?>style/css/style.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Noto+Serif' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'/>
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>style/css/jquery-ui-1.10.3.css" />
    
    <!-- syntax highlighter -->
    <link href="<?php echo base_url(); ?>syntaxhighlighter/styles/shCore.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>syntaxhighlighter/styles/shThemeDefault.css" rel="stylesheet" type="text/css" />
    <!-- syntax highlighter -->
    
    <!-- Bootstrap Datatable -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>plugin/datatables/css/jquery.dataTables.min.css" />
    <!-- Bootstrap Datatable -->

</head>
<body>

<div id="toppanel-disable"> </div>
<?php $selected = $title;?>

<div id="header">
<div class="wrapper">
    <div id="wrap-header">
        <div id="page_title">
            <h1 style="font-size: 2.9em; text-align: left;">Biomatcher</h1>
            <p style="font-size: 20px; text-align: left;">A tool for matching digital images</p>
        </div>
        <?php
        if ($this->session->userdata('username') ==""){
            if($title == 'Register'){
        ?>
        <div id="page_reg">
            <h1 style="float: right;">Register</h1>
        </div>        
        <?php
        }elseif($title == 'Auth_register'){
        ?>
        <div id="page_reg">
            <h1 style="float: right;">Login</h1>
        </div>
        <?php
        }elseif($title == 'Home'){
            if($this->input->cookie('user') !== FALSE){
                redirect('pages/userlog');
            }
            //session is empty, show login box.
        ?>
        <div id="page_menu">
            <div id="loginform">
                <?php if($this->session->flashdata('message')) : ?>
                <script type="text/javascript">
                    show_mask();
                </script>
                <div id="login-box" class="popup" style="display: block;"><?php echo $this->session->flashdata('message'); ?><br /><a class="box-button" id="close" style="background-color: red !important; margin-left: 38%; cursor: pointer;">OK</a></div>
                <?php endif; ?>
                <?php if(validation_errors()) : ?>
                <script type="text/javascript">
                    show_mask();
                </script>
                <div id="login-box" class="popup" style="display: block;"><?php echo validation_errors(); ?><a class="box-button" id="close" style="background-color: red !important; margin-left: 38%; cursor: pointer;">OK</a></div>
                <?php endif; ?>
                <?php echo form_open('pages/do_login',array('id'=>'form_login')); ?>
                    <div class="inputbox">                
                        <input class="inputtext" id="input_username" type="text" name="username" value="<?php echo set_value('username'); ?>"/>
                    </div>
                    <div class="inputbox">
                        <input class="inputtext" id="input_password" type="password" name="password" value="<?php echo set_value('password'); ?>"/>
                        </div>
                    <div class="inputbox">
                        <input id="button_login" type="submit" name="Submit" class="box-button" value="Login" />
                    </div>
                <?php echo form_close(); ?>
                <div id="register_link">
                    <a>Do not have an Account?</a>&nbsp;<a href="<?php echo base_url(); ?>index.php/pages/view/register">Register</a>
                </div>
            </div>
            
        </div>
        
        <?php
        }elseif($title == 'Register_success'){

        }elseif ($title != 'Register' && $title != 'Home' && $title != 'Register_success'){
            $this->session->set_flashdata('message', 'Please login first.');
            redirect('');
        }
        }elseif ($this->session->userdata('username') !=""){
            if ($this->session->userdata('type') == 'supplier' || $this->session->userdata('type') == 'admin'){
                
        ?>
        <div id="page_menu">
            <div style="float: left; padding-top: 13px;">
            <p>Welcome, <?php echo $this->session->userdata('name'); ?></p>
            </div>
            <div id="cmenu">
            <!-- menu -->
                <ul class="dropdown2">
                    <li><a href="javascript:void(0)"><span><img style="padding: 8px 10px;" src="<?php echo base_url(); ?>style/img/arrow.png"/></span></a>
                    <ul class="sub_menu">
                        <li><a style="padding-left: 15px;" href="<?php echo base_url(); ?>index.php/pages/logout">Logout</a></li>
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
              <li id="scroll_logout" style="display: none;"><a href="<?php echo base_url(); ?>index.php/pages/logout">Logout</a></li>
              <li class="<?php echo $selected == 'Match'?'selected':''; ?>"><a href="<?php echo base_url(); ?>index.php/pages/view/match">Match Now!</a></li>
              <li class="<?php echo $selected == 'Projects'?'selected':''; ?>"><a href="<?php echo base_url(); ?>index.php/pages/view/projects">My Project(s)</a></li>
              <li class="<?php echo $selected == 'Home'?'selected':''; ?>"><a href="<?php echo base_url(); ?>">Home</a></li>
            </ul>
        </div>
        <?php
            }
            else{
        ?>
        
        <div id="page_menu">
            <div style="float: left; padding-top: 13px;">
            <p>Welcome, <?php echo $this->session->userdata('name'); ?></p>
            </div>
            <div id="cmenu">
            <!-- menu -->
                <ul class="dropdown2">
                    <li><a href="javascript:void(0)"><span><img style="padding: 8px 10px;" src="<?php echo base_url(); ?>style/img/arrow.png"/></span></a>
                    <ul class="sub_menu">
                        <li><a style="padding-left: 15px;" href="<?php echo base_url(); ?>index.php/pages/logout">Logout</a></li>
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
              <li id="scroll_logout" style="display: none;"><a href="<?php echo base_url(); ?>index.php/pages/logout">Logout</a></li>
              <li class="<?php echo $selected == 'Match'?'selected':''; ?>"><a href="<?php echo base_url(); ?>index.php/pages/view/match">Match Now!</a></li>
              <li class="<?php echo $selected == 'My Website'?'selected':''; ?>"><a href="<?php echo base_url(); ?>index.php/pages/view/my_website">My Website(s)</a></li>
              <li class="<?php echo $selected == 'Home'?'selected':''; ?>"><a href="<?php echo base_url(); ?>">Home</a></li>
            </ul>
        </div>
        
        <?php
            }
        }
        ?>
    </div>
</div>
</div>

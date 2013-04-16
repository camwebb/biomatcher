<html>
<head>
	<title>Biomatcher :: <?php echo $title ?></title>
    <link href="<?php echo base_url(); ?>style/css/style.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Noto+Serif' rel='stylesheet' type='text/css'/>
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-ui-1.8.21.custom.min.js"></script>
    
    <script type="text/javascript">
    function show_mask(){
        // Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
    }
    $('a#close, #mask').live('click', function() { 
        $('#mask , .popup').fadeOut(300 , function() {
            $('#mask').remove();  
        });
        return false;
	});
    </script> 
</head>
<body>

<?php $selected = $title;?>

<div id="header">
    <div class="wrapper">
        <div id="page_title">
            <h1 style="font-size: 2.9em; text-align: left; position: relative;">Biomatcher</h1>
            <p style="font-size: 20px; text-align: left; position: relative;">A tool for matching digital images</p>
        </div>
        <?php
        if ($this->session->userdata('username') ==""){
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
                    <a>Do not have an Account?</a>&nbsp;<a href="<?php echo base_url(); ?>index.php/pages/register">Register</a>
                </div>
            </div>
            
        </div>
        
        <?php
        }else{
        ?>
        <div id="page_menu">
            <div style="float: left;"><p>Welcome, <?php echo $this->session->userdata('username'); ?></p></div>
            
            <div id="menu">
                <ul class="tabs">
                  <li class="<?php echo $selected == 'Match'?'selected':''; ?>"><a href="<?php echo base_url(); ?>index.php/pages/view/match">Match Now!</a></li>
                  <li class="<?php echo $selected == 'Project'?'selected':''; ?>"><a href="<?php echo base_url(); ?>index.php/pages/view/project">My Project(s)</a></li>
                  <li class="<?php echo $selected == 'Home'?'selected':''; ?>"><a href="<?php echo base_url(); ?>">Home</a></li>
                </ul>
            </div>
        </div>
        <?php
        }
        ?>
    </div>

</div>

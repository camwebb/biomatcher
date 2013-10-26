<?php session_start(); ?>
<html>
<head>
	<title>Biomatcher :: <?php echo $title ?></title>
    
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-ui-1.8.21.custom.min.js"></script>
    <style type="text/css">
    
    .error { color: #f00; font-weight: bold; font-size: 1.2em; }
    .success { color: #00f; font-weight: bold; font-size: 1.2em; }
    .note { font-size: 18px; }
    
    body {
    margin:0;
	padding:0;
    }
    
    h2{
        margin: 0;
    }
    
    #biomatcher_captcha{
        margin: 0 auto;    
    }
    
    .biomatcher{
        border: 0;
        margin: 0;
    }
    
    .biomatcher img{
        border: 0px; 
    }
    
    .biomatcher a {
    	text-decoration:none;
    }
    
    .biomatcher a:hover {
        text-decoration:none;
    }
    
    .biomatcher * { outline: 0 none; }
    
    .biomatcher input:hover, input:focus, textarea:hover, textarea:focus, select:hover, select:focus {
    	border-color: #ccc;
        -webkit-box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 8px;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
    	}
    
    .biomatcher-box-button {
        background-color: #353535;
        font-weight: bold;
        text-decoration: none;
        color: #fff;
        line-height: 36px;
        height: 36px;
        display: inline-block;
        padding: 0 15px;
        -webkit-transition: all .2s ease-in-out;
        -moz-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        cursor: pointer;
        font-family: arial;
        font-size: 13px;
        border: none;
    }
    
    .biomatcher-box-button:hover{
        color: #515151;
        background-color: #e6e6e6;
        border: none;
    }
    
    .clear {
    	clear:both;
    }
    
    .biomatcher-inputtext-reg{
        float:none;
        width:150px;
        height: 37px;
        font-size: 18px;
        padding: 0 4px;
        border: 1px solid #999999;
        -moz-box-shadow: 0px 0px 6px #000000;
        -webkit-box-shadow: 0px 0px 6px #000000;
        box-shadow: 0px 0px 6px #000000;
    }
    
    .biomatcher{
    	background: #ffffff;
    	padding: 10px; 	
    	/*border: 2px solid #333;*/
    	font-size: 1.2em;
        color: black;
    	position: relative;
    	z-index: 99999;
    	box-shadow: 0px 0px 5px #999;
    	-moz-box-shadow: 0px 0px 5px #999; /* Firefox */
        -webkit-box-shadow: 0px 0px 5px #999; /* Safari, Chrome */
    	border-radius:5px 5px 5px 5px;
        -moz-border-radius: 5px; /* Firefox */
        -webkit-border-radius: 5px; /* Safari, Chrome */
    }
    
    .biomatcher-image{
        height: 310px;
        width:310px;
    }
    
    .biomatcher-ul-image{
        list-style: none;
        padding: 0;
    }
    
    </style>


</head>
<body>

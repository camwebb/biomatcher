<html>
<head>
	<title>Biomatcher :: <?php echo $title ?></title>
    <link href="<?php echo base_url(); ?>style/css/captcha.css" rel="stylesheet" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Noto+Serif' rel='stylesheet' type='text/css'/>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'/>
    
    <link rel="stylesheet" href="<?php echo base_url(); ?>style/css/jquery-ui-1.10.3.css" />
    
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>style/js/jquery-ui-1.8.21.custom.min.js"></script>
    
    <script type="text/javascript">
    function show_mask(){
        // Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
    }

    CI_ROOT = "<?=base_url() ?>";

    </script>

</head>
<body>

<?php $selected = $title;?>


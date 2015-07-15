<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd ">
<html xmlns="http://www.w3.org/1999/xhtml ">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Biomatcher</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body style="margin: 0; padding: 0;font-family: 'Noto Serif', serif;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
            <td bgcolor="#f3f3f3" style="padding: 0 30px 0 30px;">
                <div id="page_title">
                    <h1 style="font-size: 2.9em;text-align: left;text-shadow: 3px 2px 1px #8E8E8E;">Biomatcher</h1>
                    <p style="font-size: 20px; text-align: left;">A tool for matching digital images</p>
                    <!--<img src="<?php //echo base_url('style/img/logo-mail.png'); ?>" />-->
                </div>
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td style="padding: 0 0 20px 0;">
                        Hi, <?php echo $username; ?>!
                        </td>
                    </tr>
                    <?php if($content){
                            foreach($content as $item){    
                    ?>
                    <tr>
                        <td style="padding: 0 0 20px 0;">
                        <?php echo $item; ?>
                        </td>
                    </tr>
                    <?php   }
                        } ?>
                    <tr>
                        <td style="padding: 10px 0 0 0;">
                        <?php echo $thank_message; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f3f3f3" style="padding: 20px 30px 20px 30px;">
                <p align="right">&reg; Biomatcher 2015</p>
            </td>
        </tr>
    </table>

</body>

</html>
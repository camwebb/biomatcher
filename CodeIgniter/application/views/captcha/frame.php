<?php

process_si_contact_form(); // Process the form, if it was submitted

if (isset($_SESSION['ctform']['error']) &&  $_SESSION['ctform']['error'] == true): /* The last form submission had 1 or more errors */ ?>
<span class="error">There was a problem with your submission.  Errors are displayed below in red.</span><br /><br />
<?php elseif (isset($_SESSION['ctform']['success']) && $_SESSION['ctform']['success'] == true): /* form was processed successfully */ ?>
<span class="success">The captcha was correct and the message has been sent!</span><br /><br />
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI'] . $_SERVER['QUERY_STRING']) ?>" id="contact_form">
<input type="hidden" name="do" value="contact" />

<?php
$user = $pair_match['username_pre'];
$pid = $pair_match['projectID_pre'];

$image_A = $pair_match['shuffled_image_pre_A']['md5sum'];
$image_B = $pair_match['shuffled_image_pre_B']['md5sum'];

$imageIDA = $pair_match['shuffled_image_pre_A']['id'];
$imageIDB = $pair_match['shuffled_image_pre_B']['id'];
?>

<div class="biomatcher">
        
    <div id="match" style="padding: 10px 25px" >
    
    <h2 align="center">See images below, and choose Same or Different.</h2>

    <ul class="biomatcher-ul-image" style="float: left;">
        <li><img class="biomatcher-image" src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/500px/'.$image_A.'.500px.jpg' ?>" /></li>
    </ul>
    
    <ul class="biomatcher-ul-image" style="float: right;">
        <li><img class="biomatcher-image" src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/500px/'.$image_B.'.500px.jpg' ?>" /></li>
    </ul>
        
    <div class="clear"></div>
        
    <div style="text-align: center;">
        <input type="radio" name="match" value="Same" id="same" /><label for="same">Same</label>
        <input type="radio" name="match" value="Different" id="different" /><label for="different">Different</label>
    </div>
    
    <div align="center">
        <p>
            <img id="siimage" style="border: 1px solid #000; margin-right: 15px;" src="<?php echo base_url().'securimage_files/'; ?>securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" />
            
            <a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '<?php echo base_url().'securimage_files/'; ?>securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="<?php echo base_url().'securimage_files/'; ?>images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a><br />
            
            <input class="biomatcher-inputtext-reg" type="text" name="ct_captcha" size="12" maxlength="8" />
            
            
            <button type="submit" class="biomatcher-box-button" id="sameMatch">Send Information</button>               
        </p>

    </div>       
    </div>
    
</div>
</form>

<?php

// The form processor PHP code
function process_si_contact_form()
{
  $_SESSION['ctform'] = array(); // re-initialize the form session data

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && @$_POST['do'] == 'contact') {
  	// if the form has been submitted

    foreach($_POST as $key => $value) {
      if (!is_array($key)) {
      	// sanitize the input data
        if ($key != 'ct_message') $value = strip_tags($value);
        $_POST[$key] = htmlspecialchars(stripslashes(trim($value)));
      }
    }

    $name    = @$_POST['ct_name'];    // name from the form
    $email   = @$_POST['ct_email'];   // email from the form
    $URL     = @$_POST['ct_URL'];     // url from the form
    $message = @$_POST['ct_message']; // the message from the form
    $captcha = @$_POST['ct_captcha']; // the user's entry for the captcha code
    $name    = substr($name, 0, 64);  // limit name to 64 characters

    $errors = array();  // initialize empty error array

    if (isset($GLOBALS['DEBUG_MODE']) && $GLOBALS['DEBUG_MODE'] == false) {
      // only check for errors if the form is not in debug mode

      if (strlen($name) < 3) {
        // name too short, add error
        $errors['name_error'] = 'Your name is required';
      }

      if (strlen($email) == 0) {
        // no email address given
        $errors['email_error'] = 'Email address is required';
      } else if ( !preg_match('/^(?:[\w\d]+\.?)+@(?:(?:[\w\d]\-?)+\.)+\w{2,4}$/i', $email)) {
        // invalid email format
        $errors['email_error'] = 'Email address entered is invalid';
      }

      if (strlen($message) < 20) {
        // message length too short
        $errors['message_error'] = 'Please enter a message';
      }
    }

    // Only try to validate the captcha if the form has no errors
    // This is especially important for ajax calls
    if (sizeof($errors) == 0) {
      require_once $_SERVER['DOCUMENT_ROOT'] . '/biomatcher/biomatcher.org/securimage_files/securimage.php';
      $securimage = new Securimage();

      if ($securimage->check($captcha) == false) {
        $errors['captcha_error'] = 'Incorrect security code entered<br />';
      }
    }

    if (sizeof($errors) == 0) {
      // no errors, send the form
      $time       = date('r');
      $message = "A message was submitted from the contact form.  The following information was provided.<br /><br />"
                    . "Name: $name<br />"
                    . "Email: $email<br />"
                    . "URL: $URL<br />"
                    . "Message:<br />"
                    . "<pre>$message</pre>"
                    . "<br /><br />IP Address: {$_SERVER['REMOTE_ADDR']}<br />"
                    . "Time: $time<br />"
                    . "Browser: {$_SERVER['HTTP_USER_AGENT']}<br />";

      $message = wordwrap($message, 70);

      if (isset($GLOBALS['DEBUG_MODE']) && $GLOBALS['DEBUG_MODE'] == false) {
      	// send the message with mail()
        mail($GLOBALS['ct_recipient'], $GLOBALS['ct_msg_subject'], $message, "From: {$GLOBALS['ct_recipient']}\r\nReply-To: {$email}\r\nContent-type: text/html; charset=ISO-8859-1\r\nMIME-Version: 1.0");
      }

      $_SESSION['ctform']['error'] = false;  // no error with form
      $_SESSION['ctform']['success'] = true; // message sent
    } else {
      // save the entries, this is to re-populate the form
      $_SESSION['ctform']['ct_name'] = $name;       // save name from the form submission
      $_SESSION['ctform']['ct_email'] = $email;     // save email
      $_SESSION['ctform']['ct_URL'] = $URL;         // save URL
      $_SESSION['ctform']['ct_message'] = $message; // save message

      foreach($errors as $key => $error) {
      	// set up error messages to display with each field
        $_SESSION['ctform'][$key] = "<span style=\"font-weight: bold; color: #f00\">$error</span>";
      }

      $_SESSION['ctform']['error'] = true; // set error floag
    }
  } // POST
}

$_SESSION['ctform']['success'] = false; // clear success value after running
?>
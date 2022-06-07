<?php
if (isset($_POST['Email'])) {


	
    function problem($error)
    {
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
        echo "These errors appear below.<br><br>";
        echo $error . "<br><br>";
        echo "Please go back and fix these errors.<br><br>";
        die();
    }

    // validation expected data exists
    if (
        !isset($_POST['Name']) ||
        !isset($_POST['Email']) ||
        !isset($_POST['Message']) ||
		!isset($_POST['Configuration'])
    ) {
        problem('We are sorry, but there appears to be a problem with the form you submitted.');
    }
	
    $name = $_POST['Name']; // required
    $email = $_POST['Email']; // required
    $message = $_POST['Message']; // required
	$configuration = $_POST['Configuration']; //required


	if(isset($_POST['Image'])) {
		$image_render = $_POST['Image'];
	} else {
		$image_render = 'https://configurator.ione360.com/images/logo.png';
	}
	if(isset($_POST['ProductName'])) {
		$product_name = $_POST['ProductName'];
	} else {
		$product_name = 'iOne configurator';
	}
	if(isset($_POST['ProductPrice'])) {
		$product_price = $_POST['ProductPrice'];
	} else {
		$product_price = '0,00';
	}
    $error_message = "";
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';

    if (!preg_match($email_exp, $email)) {
        $error_message .= 'The Email address you entered does not appear to be valid.<br>';
    }

    $string_exp = "/^[A-Za-z .'-]+$/";

    if (!preg_match($string_exp, $name)) {
        $error_message .= 'The Name you entered does not appear to be valid.<br>';
    }

    if (strlen($message) < 2) {
        $error_message .= 'The Message you entered do not appear to be valid.<br>';
    }

    if (strlen($error_message) > 0) {
        problem($error_message);
    }


    function clean_string($string)
    {
        $bad = array("content-type", "bcc:", "to:", "cc:", "href");
        return str_replace($bad, "", $string);
    }
	
	$email_title = "configuration@ione360.com";
    $email_to = clean_string($email);
    $email_subject = "New question about configuration";
	

	$email_message .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>iOne360 Configurator Demo</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>';
	$email_message = '<img src="https://configurator.ione360.com/images/logo.png" style="margin: 30px 0;"/>';
    $email_message .= '<h2 style="font-size: 18px;font-weight:bold">Hi ' . clean_string($name) . '!</h2>';
	$email_message .= '<p style="font-size: 14px">Thank you for contacting us. We will be in touch soon.<br/>Form details below.</p>'; 	
	
    $email_message .= 'Name: ' . clean_string($name) . '<br/>';
    $email_message .= 'Email: ' . clean_string($email) . '<br/>';
    $email_message .= 'Message: ' . clean_string($message) . '<br/><br/><br/>';
	$email_message .= '<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;max-width: 800px;">
						<tr>
						<th align="left" style="padding: 5px 15px;">Render</th>
						<th align="left" style="padding: 5px 15px;">Name</th>
						<th align="left" style="padding: 5px 15px;">Configuration</th>
						<th align="left" style="padding: 5px 15px;">Price</th>
						</tr>
						<tr>
						<td align="left" style="padding: 5px 15px;"><img style="max-width:200px;" src="' .  clean_string($image_render) . '"/></td>
						<td align="left" style="padding: 5px 15px;">' . clean_string($product_name) . '</td>
						<td align="left" style="padding: 5px 15px;">' . clean_string($configuration) . '</td>
						<td align="left" style="padding: 5px 15px;">' . clean_string($product_price) . '</td>
						</tr>
					   </table><br/><br/><br/><br/>';
	$email_message .= '<p style="display: block; width: 100%; float: left;margin: 60px 0 30px 0;">Kind regards,<br/>Team iOne360</p><br/>';				   
	$email_message .= '<table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
						<tr>
						<td align="left" style="padding: 5px 15px;">
						<img style="max-height:50px; margin-right: 20px;" src="https://www.ione360.com/wp-content/uploads/sites/4/2020/11/BC2020_RD-1.png"/>
						<img style="max-height:50px; margin-right: 20px;" src="https://www.ione360.com/wp-content/uploads/sites/4/2021/06/adesign_150.png"/>
						<img style="max-height:50px;" src="https://www.ione360.com/wp-content/uploads/sites/4/2021/06/106446-prime-design-mark-1024x1024.png"/>
						</td>
						</tr>
					   </table>';
	$email_message .= '</html></body>';
    // create email headers
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";	
    $headers .= 'From: ' . $email_title . "\r\n" .
        'Reply-To: ' . $email_to . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
    @mail($email_to, $email_subject, $email_message, $headers);
?>

    <!-- include your success message below -->

    Thank you for contacting us. We will be in touch with you very soon.

<?php
}
?>
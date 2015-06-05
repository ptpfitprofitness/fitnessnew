<?php
include 'connect.php';

$sql = "SELECT id, trainer_id, trainer_name, trainer_email, subscriptionplan, paymenttype, paymentdate, nextbillingdate FROM payments";
$payment_result = mysql_query($sql) or die("Query Error ".mysql_error());

if (mysql_num_rows($payment_result) > 0) {
    // output data of each row
    while($payment_row = mysql_fetch_assoc($payment_result)) {
	echo "<pre>";print_r($payment_row);echo "</pre>";    
	$today_date=date_create(date("Y/m/d"));
	$payment_date=date_create($payment_row["paymentdate"]);
	$next_payment_date=date_create($payment_row["nextbillingdate"]);
	
	$diff=date_diff($today_date,$next_payment_date);
	$date_diff = $diff->format("%R%a");
		
	
	if ($date_diff <= 5 && $date_diff >= 0 && ($payment_row["subscriptionplan"] != '' || $payment_row["subscriptionplan"] != NULL))
		{
			//echo "This is true condition";
			$to = $payment_row["trainer_email"];
			$subject = 'Subscription Payment Reminder';
			$from = 'Personal Trainer<notifications@ptpfitpro.com>';
			 
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
			// Create email headers
			$headers .= 'From: '.$from."\r\n".
				'Reply-To: '.$from."\r\n" .
				'X-Mailer: PHP/' . phpversion();
			 
			// Compose a simple HTML email message
			$message = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
			$message .= '<img src="http://ptpfitpro.com/images/logo.png"/>';
			$message .= '</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$payment_row["first_name"].'!</p>';
			$message .= '</td></tr><tr><td>This is gentle reminder that your subscription has been come to an end. Please renew it.<br /><br /><a href="http://www.ptpfitpro.com/">Log in to PTPFitPro</a><br /><br />Thank you, <br />The Personal Training Partner Team</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					 
			// Sending email
			if(mail($to, $subject, $message, $headers)){
				echo 'Your mail Subscription Payment Reminder has been sent successfully.';
			} else{
				echo 'Unable to send email. Please try again.';
			}
		}
	else if ($date_diff <= 0 && ($payment_row["subscriptionplan"] != '' || $payment_row["subscriptionplan"] != NULL))
	{	
		$email_dea = $payment_row["trainer_email"];
		$sql_deactivate = "UPDATE `trainers` SET `status`= '1' WHERE `email`= '$email_dea' AND `trainer_type` = 'I'";
		$result_deactivate = mysql_query($sql_deactivate) or die("Query Error ".mysql_error());
		//echo "Row effected";
		$to_dea = $payment_row["trainer_email"];
			$subject_dea = 'Your Subscription period has expired';
			$from_dea = 'Personal Trainer<notifications@ptpfitpro.com>';
			 
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
			// Create email headers
			$headers .= 'From: '.$from_dea."\r\n".
				'Reply-To: '.$from_dea."\r\n" .
				'X-Mailer: PHP/' . phpversion();
			 
			// Compose a simple HTML email message
			$message_dea = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
			$message_dea .= '<img src="http://ptpfitpro.com/images/logo.png"/>';
			$message_dea .= '</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$payment_row["first_name"].'!</p>';
			$message_dea .= '</td></tr><tr><td>Thanks for trying Personal Training Partners and PTPFitPro.  Your Subscription period has ended.  If you would like to activate your account just get in touch with us via mail or call.<br /><br />Thank you, <br />The Personal Training Partner Team</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					 
			// Sending email
			if(mail($to_dea, $subject_dea, $message_dea, $headers)){
				echo 'Your mail Subscription period expired has been sent successfully.';
			} else{
				echo 'Unable to send email. Please try again.';
			}
	}
		 
	
    }
}
 
?>
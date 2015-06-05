<?php
include 'connect.php';


$sql = "SELECT id, first_name, last_name, email, added_date, subscriptionplan, phone FROM clubs";
$result = mysql_query($sql) or die("que ".mysql_error());


if (mysql_num_rows($result) > 0) {
    // output data of each row
    while($row = mysql_fetch_assoc($result)) {
	echo "<pre>";print_r($row);echo "</pre>";    
	$today_date=date_create(date("Y/m/d"));
	$user_added=date_create($row["added_date"]);
	$diff=date_diff($today_date,$user_added);
	$date_diff = $diff->format("%R%a");
	echo $actual_diff = 30 + $date_diff;
	//if ($actual_diff <= 5 && $actual_diff >= 0 && $row["trainer_type"] == I && ($row["subscriptionplan"] == '' || $row["subscriptionplan"] == NULL))
	if ($actual_diff == 17 && ($row["subscriptionplan"] == '' || $row["subscriptionplan"] == NULL))
		{
			echo "This is true condition";
			$to = $row["email"];
			$subject = 'Your PTPFitPro trial is ending soon';
			$from = 'Personal Trainer<notifications@ptpfitpro.com>';
			$ccc  = 'Personal Trainer Admin<trial@ptpfitpro.com>';
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
			// Create email headers
			$headers .= 'From: '.$from."\r\n".
				'Bcc : '.$ccc."\r\n" .
				'Reply-To: '.$from."\r\n" .
				'X-Mailer: PHP/' . phpversion();
			 
			// Compose a simple HTML email message
			$message = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
			$message .= '<img src="http://ptpfitpro.com/images/logo.png"/>';
			$message .= '</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hi '.$row["first_name"].'!</p>';
			$message .= '</td></tr><tr><td>Thank you for trying Personal Training Partners PTPFitPro. My name is Scott and I help new and existing Clubs & Trainers get the most out of their account.<br /><br />Either Ryan Hunt or I would be happy to get with you personally to discuss ways you can best utilize the site to achieve growth in your client retention rates and overall revenue.  Please give me a call at your convenience if there’s anything I can do to help!<br /><br />Best Regards,<br /><br />Scott Clare<br />Director of Sales & Marketing<br /><br />208-863-0536<br /><a href="#">scott@ptpfitpro.com</a></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					 
			// Sending email
			if(mail($to, $subject, $message, $headers)){
				echo 'Your mail for Reminder has been sent successfully.';
			} else{
				echo 'Unable to send email. Please try again.';
			}
		}
		
		
	elseif ($actual_diff > -15 && $actual_diff <= -1 && ($row["subscriptionplan"] == '' || $row["subscriptionplan"] == NULL))
	{
		$email_dea_left = $row["email"];
		$sql_deactivate_left = "UPDATE `clubs` SET `after_sub_trial_end`= '1' WHERE `email`= '$email_dea_left'";
		$result_deactivate_left = mysql_query($sql_deactivate_left) or die("Query Error ".mysql_error());
	}
	
	elseif ($actual_diff == -15 && ($row["subscriptionplan"] == '' || $row["subscriptionplan"] == NULL))
	{	
		$email_dea_left = $row["email"];
		$sql_deactivate_left = "UPDATE `clubs` SET `after_sub_trial_end`= '1' WHERE `email`= '$email_dea_left'";
		$result_deactivate_left = mysql_query($sql_deactivate_left) or die("Query Error ".mysql_error());
		//echo "Row effected";
			$email_dea_left = $row["email"];
			$subject_dea_left = 'Your PTPFitPro trial period has ended';
			$from_dea_left = 'Personal Trainer<notifications@ptpfitpro.com>';
			 
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
			// Create email headers
			$headers .= 'From: '.$from_dea_left."\r\n".
				'Reply-To: '.$from_dea_left."\r\n" .
				'X-Mailer: PHP/' . phpversion();
			 
			// Compose a simple HTML email message
			$message_dea_left = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
			$message_dea_left .= '<img src="http://ptpfitpro.com/images/logo.png"/>';
			$message_dea_left .= '</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$row["first_name"].'!</p>';
			$message_dea_left .= '</td></tr><tr><td>Thanks for trying Personal Training Partners and PTPFitPro.  Your trial period has ended.  If you would like to activate your account just log in and click “Purchase Now” at the top of the screen. <br /><br />We really appreciate you giving us a try and look forward to serving you further.<br /><br /><a href="http://www.ptpfitpro.com/">Log in to PTPFitPro</a><br /><br />Thank you, <br />The Personal Training Partner Team</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					 
			// Sending email
			/*if(mail($email_dea_left, $subject_dea_left, $message_dea_left, $headers)){
				echo 'Your mail for expired soon has been sent successfully.';
			} else{
				echo 'Unable to send email. Please try again.';
			}*/
	}
	
	//elseif ($actual_diff <= -16 && $row["trainer_type"] == I && ($row["subscriptionplan"] == '' || $row["subscriptionplan"] == NULL))
	elseif ($actual_diff == -16 && ($row["subscriptionplan"] == '' || $row["subscriptionplan"] == NULL))
	{	
		$email_dea = $row["email"];
		$sql_deactivate = "UPDATE `clubs` SET `status`= '0' WHERE `email`= '$email_dea'";
		$result_deactivate = mysql_query($sql_deactivate) or die("Query Error ".mysql_error());
		//echo "Row effected";
			$email_dea = $row["email"];
			$subject_dea = 'Your trial period has expired';
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
			$message_dea .= '</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$row["first_name"].'!</p>';
			$message_dea .= '</td></tr><tr><td>Thanks for trying Personal Training Partners and PTPFitPro.  Your free trial period has ended.  If you would like to activate your account just get in touch with us via email or call (208) 863-0536.<br /><br /><a href="http://www.ptpfitpro.com/">Log in to PTPFitPro</a><br /><br />Thank you, <br />The Personal Training Partner Team</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
			
			$admin_id = 'craigaaland@gmail.com';
			$admin_subject = 'An Account has been deactivated';
			$message_dea_admin = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
			$message_dea_admin .= '<img src="http://ptpfitpro.com/images/logo.png"/>';
			$message_dea_admin .= '</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello Admin!</p>';
			$message_dea_admin .= '</td></tr><tr><td>Following Account has been deactivated.<br /><br />Name- '.$row["first_name"].'<br />Email- '.$email_dea.'<br /><br />Phone- '.$row["phone"].'<br /><br />Thank you, <br />The Personal Training Partner Team</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';
			mail($admin_id, $admin_subject, $message_dea_admin, $headers);
					 
			// Sending email
			/*if(mail($email_dea, $subject_dea, $message_dea, $headers)){
				echo 'Your mail for expire has been sent successfully.';
			} else{
				echo 'Unable to send email. Please try again.';
			}*/
	}
	elseif ($actual_diff == 0 && ($row["subscriptionplan"] == '' || $row["subscriptionplan"] == NULL))
		{
			//echo "This is true condition";
			$to = $row["email"];
			$subject = 'Your PTPFitPro trial is ending soon';
			$from = 'Personal Trainer<notifications@ptpfitpro.com>';
			$ccc  = 'Personal Trainer Admin<trial@ptpfitpro.com>';
			
			// To send HTML mail, the Content-type header must be set
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			 
			// Create email headers
			$headers .= 'From: '.$from."\r\n".
				'Bcc : '.$ccc."\r\n" .				
				'Reply-To: '.$from."\r\n" .
				'X-Mailer: PHP/' . phpversion();
			 
			// Compose a simple HTML email message
			$message = '<html><body><table width="550" border="1" align="center" cellpadding="0" cellspacing="0" style="border-color:#21aded;"><tr><td height="30" align="left" valign="middle" bgcolor="#21aded"><div align="center">';
			$message .= '<img src="http://ptpfitpro.com/images/logo.png"/>';
			$message .= '</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hi '.$row["first_name"].'!</p>';
			$message .= '</td></tr><tr><td>Hope you\'re doing well! Just following up because I noticed your PTPFitPro trial wraps up tomorrow and I wanted to check in with you and see how everything went. Please let me know if you have any remaining questions or if there\'s anything else I can do to help!<br /><br />Best Regards,<br /><br />Craig Aaland<br />CEO<br /><br />(714) 319-1362<br /><a href="#">craig@ptpfitpro.com</a></td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					 
			// Sending email
			if(mail($to, $subject, $message, $headers)){
				echo 'Your mail for Reminder has been sent successfully.';
			} else{
				echo 'Unable to send email. Please try again.';
			}
		}
		 
	
    }
}
?>
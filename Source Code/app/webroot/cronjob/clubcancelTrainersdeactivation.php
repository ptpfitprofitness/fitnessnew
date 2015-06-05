<?php
include 'connect.php';

$sql = "SELECT id, first_name, last_name, email, added_date, trainer_type, subscriptionplan, phone, club_cancel_date, club_cancel_status FROM trainers";
$result = mysql_query($sql) or die("Query Error ".mysql_error());

if (mysql_num_rows($result) > 0) {
    // output data of each row
    while($row = mysql_fetch_assoc($result)) {
	echo "<pre>";print_r($row);echo "</pre>";    
	$today_date=date_create(date("Y/m/d"));	
	$trainer_unassign=date_create($row["club_cancel_date"]);
	$unassigndiff=date_diff($trainer_unassign,$today_date);
	echo $unassign_date_diff = $unassigndiff->format("%R%a");
	
	if ($unassign_date_diff == 15 && $row['trainer_type'] == I && $row['club_cancel_status'] == 1 && ($row['subscriptionplan'] == "" || $row['subscriptionplan'] == NULL))
		{
			$email_dea = $row["email"];
			$sql_deactivate = "UPDATE `trainers` SET `status`= '0' WHERE `email`= '$email_dea'";
			$result_deactivate = mysql_query($sql_deactivate) or die("Query Error ".mysql_error());
			//echo "This is true condition";
			//$to = 'synapseindia8@gmail.com';
			$to = 'registration@ptpfitpro.com';
			$subject = 'A Trainer Account Deactivated';
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
			$message .= '</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello Admin!</p>';
			$message .= '</td></tr><tr><td>A Trainer Account that has been Associated by Club earlier has been deactivated as subscription not purchased by Trainer. Following are the details-:
			<br /><br />Trainer Name-: '.$row["first_name"].' <br /><br />Trainer Email-: '.$row["email"].'<br /><br />Trainer Phone-: '.$row["phone"].'</a><br /><br />Thank you, <br />The Personal Training Partner Team</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					 
			// Sending email
			if(mail($to, $subject, $message, $headers)){
				echo 'Mail to Admin has been sent successfully.';
			} else{
				echo 'Unable to send email. Please try again.';
			}
		}
		
		
	elseif ($unassign_date_diff > 16 && $unassign_date_diff < 20 && $row['trainer_type'] == I && $row['club_cancel_status'] == 1 && ($row['subscriptionplan'] == "" || $row['subscriptionplan'] == NULL))
	{
		$email_dea = $row["email"];
		$sql_deactivate = "UPDATE `trainers` SET `status`= '0' WHERE `email`= '$email_dea'";
		$result_deactivate = mysql_query($sql_deactivate) or die("Query Error ".mysql_error());
	}
	
	
	
		 
	
    }
}
 
?>
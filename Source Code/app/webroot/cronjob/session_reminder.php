<?php
include 'connect.php';

$sql = "SELECT schedule_calendar.id,schedule_calendar.appointment_type,schedule_calendar.session_type,schedule_calendar.trainer_id,schedule_calendar.trainee_id,schedule_calendar.start,schedule_calendar.added_date,trainees.email as trainee_email,trainees.first_name as trainee_fname,trainees.session_reminder_notification as trainee_session_reminder_notification,trainers.email as trainers_email,trainers.first_name as trainers_fname,trainers.phone as trainers_phone,trainers.website_logo as trainers_website_logo
FROM schedule_calendar
INNER JOIN trainees 
ON schedule_calendar.trainee_id=trainees.id
INNER JOIN trainers 
  ON schedule_calendar.trainer_id=trainers.id";

$result = mysql_query($sql) or die("que ".mysql_error());

if (mysql_num_rows($result) > 0) {
    // output data of each row
    while($row = mysql_fetch_assoc($result)) {
	echo "<pre>";print_r($row);echo "</pre>";    
	$today_date=date_create(date("Y/m/d"));
	$user_added=date_create($row["start"]);
	$diff=date_diff($today_date,$user_added);
	echo $date_diff = $diff->format("%R%a");
	$date_formated = date('m/d/Y',strtotime($row["start"]));
	$time_formated = date('H:i',strtotime($row["start"]));
	if ($date_diff <= 1 && $date_diff > 0 && $row["appointment_type"] == "Booked" && $row["trainee_session_reminder_notification"] == 1)
		{
			//echo "This is true condition";
			$to = $row["trainee_email"];
			$subject = 'Session Reminder';
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
			$message .= '<img src="http://www.ptpfitpro.com/uploads/'.$row["trainers_website_logo"].'"/>';
			$message .= '</div></td></tr><tr><td width="548" valign="top" bgcolor="#FFFFFF"><table width="500" border="0" align="center" cellpadding="0" cellspacing="0"><tr><td>&nbsp;</td></tr><tr><td><p>Hello '.$row["trainee_fname"].'!</p>';
			$message .= '</td></tr><tr><td>Just a reminder that we have a '.$row["session_type"].' workout scheduled for '.$date_formated.' at '.$time_formated.'. See you then!<br /><br />Thank you, <br />'.$row["trainers_fname"].'<br />'.$row["trainers_phone"].'<br />'.$row["trainers_email"].'</td></tr><tr><td></td></tr></table></td></tr></table></body></html>';

					 
			// Sending email
			if(mail($to, $subject, $message, $headers)){
				echo 'Your mail has been sent successfully.';
			} else{
				echo 'Unable to send email. Please try again.';
			}
		}
		 
	
    }
}
 
?>
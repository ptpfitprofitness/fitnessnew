<?php
	
	class EmailComponent extends Component {
	/*
		public $donationsubject;
		public $signupsubject;
		public $gmailsubject;
		public $guesbookemailsubject;
		public $donationtip;
		public $guestbooktip;
		public $gmailtip;
		public $signuptip;
	*/
		/*public function setDefaults() {
			
			$default = Configure::read("Email");
			
			$this->donationsubject	 		=	$default["donationsubject"];
			$this->signupsubject	 		=	$default["signupsubject"];
			$this->gmailsubject	 			=	$default["gmailsubject"];
			$this->guesbookemailsubject	 	=	$default["guesbookemailsubject"];
			
			$this->donationtip	 			=	$default["donationtip"];
			$this->guestbooktip		 		=	$default["guestbooktip"];
			$this->gmailtip		 			=	$default["gmailtip"];
			$this->signuptip		 		=	$default["signuptip"];
			
		}*/
		
		public function sendevertalkemail($emailvar){
			
			echo "<pre>";
			print_r($this);exit;			
			
			echo $type;
			
			exit;
			
			echo "<pre>";
			print_r($emailvar);

			exit;
			
			/*if($type == 'Donation'){
				
				$title = 'Hello '.$emailvars['profile_creator'].'  -  '.$emailvars['cname'].' just made a donation in the amount of $'.$emailvars['donatedamount'].' in remembrance of '.$emailvar['dname'];
				
				$message = 'With this contribution you are one step closer to your funding goal. '.$emailvars['cname'].' donated $'.$emailvar['donatedamount'].' to '.$emailvar['charity_name'].'. Send a thank you note to '.$emailvars['cname'].' by clicking on their photo to the right.<br/><br/>Thank you for using Evertalk.';
				
				$right_pic = '<a href="https://www.facebook.com/profile.php?id='.$emailvar['uid'].'"><img src="https://graph.facebook.com/'.$emailvar['username'].'/picture?type=large" width="180px" height="180px" style="display: block;" border="0"></a>';
				
				$tip = $this->donationtip;
				
				$subject = str_replace(array('{cname}','{amount}','{dname}'),array($emailvars['cname'],$emailvar['donatedamount'],$emailvar['dname']),$this->donationsubject);
				$email = $emailvar['email'];
			
			}
			
			$message_body = '<table width="100%" bgcolor="#7dd2e1" link="#FF6600" vlink="#FF6600" alink="#FF6600" height="100%"><tr><td><table width="600"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="39%" align="center"><font color="#000000" face="Arial, Helvetica, sans-serif" style="font-size:16px; line-height:18px;"><strong><a href="'.$this->config['appurl'].'"><img src="'.$this->config['url'].'img/evertalk/01.jpg" width="197" height="94" border="0" style="display: block;"></a></strong></font></td>
        <td width="61%" align="center" valign="bottom"><table width="82%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right" valign="top"><a href="http://www.staysherpa.com/beta/" style="text-decoration:none"><font color="#FF6600" face="Arial, Helvetica, sans-serif" style="font-size:12px; line-height:17px;"> </font></a><font color="#000000" face="Arial, Helvetica, sans-serif" style="font-size:16px; line-height:18px;"><strong>&nbsp;</strong></font></td>
          </tr>
        </table></td>
      </tr>
    </table>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="10"></td>
        </tr>
      </table>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="'.$this->config['url'].'img/evertalk/02.jpg" width="600" height="17" style="display: block;"></td>
        </tr>
      </table>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="31" valign="top" style="background:url('.$this->config['url'].'img/evertalk/03.jpg) 0 0 repeat-y;">&nbsp;</td><td width="539" align="center" valign="middle" bgcolor="#FFFFFF"><table width="514"  border="0" cellspacing="0" cellpadding="6">
            <tr>
              <td align="left"><font color="#333333" face="Arial, Helvetica, sans-serif" style="font-size:15px; line-height:19px;"> <strong>'.$title.' </strong></font></td>
            </tr>
          </table>
            <table width="514"  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="59%" align="left" valign="top"><table  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="center"><img src="'.$this->config['url'].'img/evertalk/a01a.jpg" width="300" height="17" style="display: block;"></td>
                </tr>
              </table>
                <table  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                  	<td width="8" align="center" valign="top" style="background:url('.$this->config['url'].'img/evertalk/a02.jpg) 0 0 repeat-y;">&nbsp;</td>
                    <td width="284" align="center" valign="top" bgcolor="#DCDADB"><table width="98%"  border="0" cellspacing="0" cellpadding="4">
                        <tr>
                          <td align="left" valign="top"><font color="#000000" face="Arial, Helvetica, sans-serif" style="font-size:12px; line-height:17px;">'.$message.'</font></td>
                        </tr>
                    </table></td>
                     <td width="8" align="center" valign="top" style="background:url('.$this->config['url'].'img/evertalk/a03.jpg) 0 0 repeat-y;">&nbsp;</td>
                  </tr>
                </table>
                <table  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center"><img src="'.$this->config['url'].'img/evertalk/a04a.jpg" width="300" height="18" style="display: block;"></td>
                  </tr>
                </table></td>
              <td width="41%" align="left" valign="top" style="padding-top:10px;padding-left:10px;">'.$right_pic.'</td>
            </tr>
          </table>
            <table width="514"  border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td align="left"><a href="'.$evertalk_page_link.'"><img src="'.$this->config['url'].'img/evertalk/btn-take-me.png" style="display: block;" border="0"></a></td>
              </tr>
            </table>
            <table width="514"  border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td align="center"><img src="'.$this->config['url'].'img/evertalk/07a.jpg" width="500" height="11" style="display: block;"></td>
              </tr>
            </table>
            <table width="514"  border="0" cellspacing="0" cellpadding="6">
              <tr>
                <td align="left"><font color="#666666" face="Arial, Helvetica, sans-serif" style="font-size:12px; line-height:17px;"><strong>Tip:</strong> '.$tip.'<br>
                  <br>
                  Cheers,<br>
                  <img src="'.$this->config['url'].'img/evertalk/07.jpg" width="200" height="39" style="display: block;"></font></td>
              </tr>
            </table></td> <td width="30" valign="top" style="background:url('.$this->config['url'].'img/evertalk/04.jpg) 0 0 repeat-y;">&nbsp;</td>
        </tr>
      </table>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><img src="'.$this->config['url'].'img/evertalk/05.jpg" width="600" height="21" style="display: block;"></td>
        </tr>
      </table>
      <table width="100%"  border="0" cellspacing="0" cellpadding="8">
        <tr>
          <td align="center"><font color="#000000" face="Arial, Helvetica, sans-serif" style="font-size:11px; line-height:17px;">Sent from Evertalk HQ in San Francisco, CA USA. <br>
          To stop receiving emails from Evertalk, please change your settings within your Evertalk account. <br>
          &copy; Copyright 2012, Evertalk LLC</font></td>
        </tr>
      </table></td>
  </tr>
</table></td>
  </tr>
</table>';
			
			
		$this->sendEmailMessage($email, $subject, $message_body, 'signup', 'signup');	*/
			
		}

	}
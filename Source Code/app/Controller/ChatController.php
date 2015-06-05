<?php
##******************************************************************
##  Project		:		Fitness
##  Done by		:		921
##	Create Date	:		06/03/2014
##  Description :		This file contains function related to the Home page
## *****************************************************************
App::uses('CakeTime', 'Utility');
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/specialists-controller.html
 */

	class ChatController extends AppController { 

		public $name 		= 'Chat';
		public $helpers 	= array('Html','Session','Cksource','GoogleChart');
		public $uses 		= array('Country','Member','ClubBranch','Club','ClubContact','Trainer','Corporation','Trainee','CertificationOrganization','Certification','Degree','Page','TraineeTrainer','ScheduleCalendar','SevensiteBodyfat','ThreesiteBodyfat','BodymassIndex','EstimatedenergyRequirement','FoodNutritionLog','AdddailyNutritionDiary','CertificationTrainers','ExerciseHistorys','Goal','WarmUps','CoreBalancePlyometric','SpeedAgilityQuickness','Resistence','CoolDown','WorkOuts','FoodUsda','ExerciseLibrary','Emessage','Chat');
		public $components  = array('Upload');				
	   
		
	
		public function chatHeartbeat() {
			$this->layout='';
			$this->autoRender=false;
			
			
if (!isset($this->Session->read('chatHistory'))) {
	$this->Session->write('chatHistory')=array();

}

if (!isset($this->Session->read('openChatBoxes'))) {
	$this->Session->write('openChatBoxes',array());
	
}
	 $chatsessuser=$this->Session->read('username_chat');

	
	$setChatArr=$this->Country->query("select * from chat where (chat.to = '".mysql_real_escape_string($chatsessuser)."' AND recd = 0) order by id ASC");
	
	$items = '';

	
	
	$items = '';

	$chatBoxes = array();
  $i=0;
  $chfrm=$setChatArr[$i]['chat']['from'];
	while ($setChatArr) {

		if (!isset($this->Session->read("openChatBoxes.$chfrm")) && isset($this->Session->read("chatHistory.$chfrm"))) {
			$items = $this->Session->read("chatHistory.$chfrm");
		}

		$chat['message'] = $this->sanitize($setChatArr[$i]['chat']['message']);

		$items .= <<<EOD
					   {
			"s": "0",
			"f": "{$setChatArr[$i]['chat']['from']}",
			"m": "{$setChatArr[$i]['chat']['message']}"
	   },
EOD;

	if (!isset($this->Session->read("chatHistory.$chfrm"))) {
		$this->Session->write("chatHistory.$chfrm")='';
		
	}

	$this->Session->write("chatHistory.$chfrm") .= <<<EOD
						   {
			"s": "0",
			"f": "{$setChatArr[$i]['chat']['from']}",
			"m": "{$setChatArr[$i]['chat']['message']}"
	   },
EOD;
		
		$this->Session->delete("tsChatBoxes.$chfrm");
		$this->Session->write("openChatBoxes.$chfrm") = $setChatArr[$i]['chat']['sent'];
		$i++;
	}

	if (!empty($this->Session->read("openChatBoxes"))) {
	foreach ($this->Session->read("openChatBoxes") as $chatbox => $time) {
		if (!isset($this->Session->read("tsChatBoxes.$chatbox"))) {
			$now = time()-strtotime($time);
			$time = date('g:iA M dS', strtotime($time));

			$message = "Sent at $time";
			if ($now > 180) {
				$items .= <<<EOD
{
"s": "2",
"f": "$chatbox",
"m": "{$message}"
},
EOD;

	if (!isset($this->Session->read("chatHistory.$chatbox"))) {
		
		$this->Session->write("chatHistory.$chatbox")='';
	}

	$this->Session->write("chatHistory.$chatbox") .= <<<EOD
		{
"s": "2",
"f": "$chatbox",
"m": "{$message}"
},
EOD;
			$this->Session->write("tsChatBoxes.$chatbox") = 1;
		}
		}
	}
}
$chatsessuser=$this->Session->read('username_chat');

	$sql = $this->Country->query("update chat set recd = 1 where chat.to = '".mysql_real_escape_string($chatsessuser)."' and recd = 0");
	
	if ($items != '') {
		$items = substr($items, 0, -1);
	}
header('Content-type: application/json');
?>
{
		"items": [
			<?php echo $items;?>
        ]
}

<?php
			exit(0);
}

public function chatBoxSession($chatbox) {
	$this->layout='';
			$this->autoRender=false;
	$items = '';
		if (!isset($this->Session->read('chatHistory'))) {
		$this->Session->write("chatHistory") = array();	
		}
		
		if (!isset($this->Session->read('openChatBoxes'))) {
		$this->Session->write("openChatBoxes") = array();	
		}
	if (isset($this->Session->read("chatHistory.$chatbox"))) {
		$items =$this->Session->read("chatHistory.$chatbox");
	}

	return $items;
}

public function startChatSession() {
	$this->layout='';
			$this->autoRender=false;
	$items = '';
	if (!isset($this->Session->read('chatHistory'))) {
		$this->Session->write("chatHistory") = array();	
		}
		
		if (!isset($this->Session->read('openChatBoxes'))) {
		$this->Session->write("openChatBoxes") = array();	
		}
	if (!empty($this->Session->read('openChatBoxes'))) {
		foreach ($this->Session->read('openChatBoxes') as $chatbox => $void) {
			$items .= $this->chatBoxSession($chatbox);
		}
	}


	if ($items != '') {
		$items = substr($items, 0, -1);
	}
$chatsessuser=$this->Session->read('username_chat');
header('Content-type: application/json');
?>
{
		"username": "<?php echo $chatsessuser;?>",
		"items": [
			<?php echo $items;?>
        ]
}

<?php


	exit(0);
}
public function sendChat() {
	$this->layout='';
			$this->autoRender=false;
			$chatsessuser=$this->Session->read('username_chat');
	$from = $chatsessuser;
	$to = $_REQUEST['to'];
	$message = $_REQUEST['message'];
   echo $this->Session->write("openChatBoxes.$to")=date('Y-m-d H:i:s', time());
	die();
	
	$messagesan = $this->sanitize($message);

	if (!isset($this->Session->read("chatHistory.$to"))) {
		$this->Session->write("chatHistory.$to")='';
		
	}

	$this->Session->write("chatHistory.$to") .= <<<EOD
					   {
			"s": "1",
			"f": "{$to}",
			"m": "{$messagesan}"
	   },
EOD;

   $this->Session->delete("tsChatBoxes.$to");
	//unset($_SESSION['tsChatBoxes'][$_POST['to']]);

	$sql = $this->Country->query("insert into chat (chat.from,chat.to,message,sent) values ('".mysql_real_escape_string($from)."', '".mysql_real_escape_string($to)."','".mysql_real_escape_string($message)."',NOW())");
	
	echo "1";
	exit(0);
}

public function closeChat() {
$this->layout='';
			$this->autoRender=false;
			$pt=$_POST['chatbox'];
			$this->Session->delete("openChatBoxes.$pt");
	//unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);
	
	echo "1";
	exit(0);
}

public function sanitize($text=null) {
	$this->layout='';
			$this->autoRender=false;
	$text = htmlspecialchars($text, ENT_QUOTES);
	$text = str_replace("\n\r","\n",$text);
	$text = str_replace("\r\n","\n",$text);
	$text = str_replace("\n","<br>",$text);
	return $text;
}

		
		
}
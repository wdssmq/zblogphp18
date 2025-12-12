<?php
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'phpmailer.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 'smtp.php';
function tpure_SendEmail($mailto,$subject,$content){
	global $zbp;
	date_default_timezone_set('Asia/Shanghai');
	$mail = new tpure_PHPMailer();
	$mail->CharSet = "UTF-8";
	$mail->tpure_isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Host = $zbp->Config('tpure')->SMTP_HOST;
	$mail->Port = $zbp->Config('tpure')->SMTP_PORT;
	$mail->SMTPAuth = true;
	$mail->Username = $zbp->Config('tpure')->FROM_EMAIL;
	$mail->Password = $zbp->Config('tpure')->SMTP_PASS;
	$mail->tpure_setFrom($zbp->Config('tpure')->FROM_EMAIL, $zbp->Config('tpure')->FROM_NAME);
	$mail->tpure_addAddress($mailto);
	$mail->Subject = $subject;
	$mail->tpure_msgHTML($content);
	if($zbp->Config('tpure')->SMTP_SSL){
		$mail->SMTPSecure = "ssl";
	}
	if(!$mail->tpure_send()){
		echo 'Mailer Error: ' . $mail->ErrorInfo;
		return false;
	} else {
		return true;
	}
}
<?php

class Utility
{
	static public function getRandomKey($length = 10, $chars = '')
	{
		if(!is_string($chars) || $chars === '')
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$len = strlen($chars);
		$makepass = '';
		$stat = @stat(__FILE__);
		if(empty($stat) || !is_array($stat)) $stat = array(php_uname());
		mt_srand(crc32(microtime() . implode('|', $stat)));
		
		for ($i = 0; $i < $length; $i ++) {
			$makepass .= $chars[mt_rand(0, $len -1)];
		}
		
		return $makepass;
	}
	
	static public function sendMail($toEmail, $nameEmail, $subject, $body, $fromEmail = '', $fromName = '', $html = true)
	{
		if(!$fromEmail)
			$fromEmail = Yii::app()->params['noreplyEmail'];
		if(!$fromName)
			$fromName = Yii::app()->name;
		$mailer = Yii::createComponent('ext.mailer.EMailer');
		$mailer->setFrom($fromEmail, $fromName);
		$mailer->CharSet = 'utf-8';
		$mailer->IsHTML($html);
		$mailer->AddAddress($toEmail, $nameEmail);
		$mailer->Subject = $subject;
		$mailer->Body = $body;
		return $mailer->Send();
	}
}
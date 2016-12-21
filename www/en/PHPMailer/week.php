<?php
/**
* 每周发送一次
* @package phpmailer
* @version $Id$
*/
ini_set('date.timezone','Asia/Shanghai');

require 'class.phpmailer.php';

require 'cdb.class.php';


try {
	
	$rs = $dbh->query("SELECT value FROM ".$config->db->prefix."config WHERE owner='system' AND module='common' AND section='crontab' ORDER BY id ASC");
	$smtps = $rs->fetchAll();
	
	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	$body             = $smtps[5]->value;
	$body             = preg_replace('/\\\\/','', $body); //Strip backslashes

	$mail->IsSMTP();                           // tell the class to use SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = $smtps[2]->value;                    // set the SMTP server port
	$mail->Host       = $smtps[1]->value; // SMTP server
	$mail->Username   = $smtps[0]->value;     // SMTP server username
	$mail->Password   = $smtps[3]->value;            // SMTP server password

	//$mail->IsSendmail();  // tell the class to use Sendmail

	//$mail->AddReplyTo("393104627@qq.com","First Last");

	$mail->From       = $smtps[0]->value;
	$mail->FromName   = "上海东软载波微电子有限公司";

	$rs = $dbh->query("SELECT account, email FROM ".$config->db->prefix."user WHERE informupdate='week'");
	$_smtps = $rs->fetchAll();
	foreach($_smtps AS $k => $v) {
		if($v->email) {
			$mail->AddBCC($v->email, $v->account);
		}
	}

	$rsContent = $dbh->query("SELECT a.id, a.title, a.addedDate FROM ".$config->db->prefix."article a LEFT JOIN ".$config->db->prefix."relation r ON a.id=r.id WHERE r.category=19");
	$_rsContents = $rsContent->fetchAll();
	$date1 = time();//当前时间
	$date2 = strtotime(date('Y-m-d', $date1 - 3600 * 24 * 4).' 00:00:00');//减4天后的时间
	$content = '';
	if($_rsContents) {
		foreach($_rsContents AS $k => $v) {
			$date3 = strtotime($v->addedDate);
			if($date2 <= $date3 && $date3 <= $date1) {
				$content .= '<a href="'.$config->db->domain.'/article/'.$v->id.'.html">'.$v->title.'</a><br>';
			}
		}
	}
	
	if($content) {
		$content .= '<br><br>谢谢您关注上海东软载波微电子，我们会及时通知您相关的变更信息。
如欲了解更详细的公司及产品信息，请登陆公司网站www.essemi.com。 <br> Thank you for your interest in Shanghai Haier IC Co. Ltd.
More information about Company and Products, please visit our website www.essemi.com.';
		
		$mail->Subject  = '上海东软载波微电子变更通知';
		
		$mail->WordWrap   = 80; // set word wrap
		
		$mail->MsgHTML($content);
		
		$mail->IsHTML(true); // send as HTML
		
		$mail->Send();
	}
	
	echo 'Message has been sent.';
} catch (phpmailerException $e) {
	echo $e->errorMessage();
}
?>
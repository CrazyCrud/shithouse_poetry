<?php

$adminEmails = array("support@latrinalia.de");//array("bastian@latrinalia.de", "franziska@latrinalia.de", "constantin@latrinalia.de", "thomas@latrinalia.de");

$emailBody = '<html>
<head><meta charset="utf-8"/></head>
<body style="font-family:Helvetica">
<img src="http://latrinalia.de/img/global/top-img-bw.jpg" style="width:100%"></img>
<div>%1</div>
<br/>
Vielen Dank und liebe Gr&uuml;&szlig;e,<br/>
Dein Team von Latrinalia
</body>
</html>';

$emailBodyContent =
'<h2>Willkommen bei Latrinalia, %2</h2>
<p>Danke, dass du dich bei uns registriert hast und mit uns die Welt der Toiletten-Schmierereien erkunden und anlaysieren m&ouml;chtest.</p>
<p>Das Ziel von Latrinalia ist mit Hilfe von Crowdsourcing eine wissenschaftlich relevante Datenbasis zum Thema Toiletten-Graffiti zu erstellen. Du bist uns dabei eine gro&szlig;e Hilfe, denn  je mehr Leute Eintr&auml;ge erstellen, bewerten und transkribieren, desto besser k&ouml;nnen wir arbeiten.</p>
<br/>
Diese E-Mail wurde dir geschickt, weil du dich bei http://www.latrinalia.de registriert hast und nun deinen Email-Account verifizieren musst. 
Falls du dich dort nicht registiert hast und nicht wei&szlig;t, warum du diese E-Mail bekommen hast, ignoriere sie einfach.
<p>Um deine Registrierung abzuschlie&szlig;en, klicke bitte <a href="http://www.latrinalia.de/verify.php?verification=%1">auf diesen Link</a>.</p>
<p>Sollte der Link aus irgendwelchen Gr&uuml;nden nicht funktionieren, kopiere einfach folgenden Text in deine Browser-Addressleiste:<br/>
http://www.latrinalia.de/verify.php?verification=%1</p>
<br/>';

$contentAdminMail =
'<h2>Diese Email wurde mit Hilfe des Kontaktformulars auf Latrinalia.de an dich gesendet:</h2>
<div>%1</div><br/><br/>
<div>Diese Mail wurde von %2 versendet.</div>';

$contentUserMail =
'<h2>Folgende Nachricht wurde in deinem Namen an die Ansprechpartner von Latrinalia.de gesendet:</h2>
<div>%1</div>';

$contentRecoveryMail =
'<h2>Dein neues Passwort</h2>
<div><p>Diese Mail wurde dir geschickt, weil du bei latrinalia.de ein neues Passwort angefordert hast.<br/>
Hast du dies nich getan, so wende dich bitte umgehend an unseren <a href="mailto:support@latrinalia.de">Support</a>
 (support@latrinalia.de).</p>
 <p>Aus Sicherheitsgr&uuml;nden senden wir dir nicht dein Passwort und deinen Nutzernamen in einer Mail.</p>
 <p>Dein neues Passwort lautet:</p>
 <b>%1</b>
 <p>Bitte &auml;ndere dein Passwort umgehend wieder.</p></div>';

function sendVerificationMail($email, $username, $key){
	global $emailBodyContent;
	$url = "http://www.latrinalia.de/verify.php?verification=".$key;

	$subject = "Willkommen bei Latrinalia";
	$message = str_replace("%1", $key, $emailBodyContent);
	$message = str_replace("%2", $username, $message);

	sendMail($email, $subject, $message);
}

function sendMail($email, $title, $content, $from = "Latrinalia <noreply@latrinalia.de>"){
	global $emailBody;
	
	$subject = $title;

	$content = str_replace("\\r\\n", "<br/>", $content);
	$content = str_replace("\\n", "<br/>", $content);
	$content = str_replace("\\r", "<br/>", $content);

	$message = str_replace("%1", $content, $emailBody);

	$header  = "MIME-Version: 1.0\n";
	$header .= "Content-type: text/html; charset=utf-8\n";
	 
	$header .= "From: $from\n";
	$header .= "X-Mailer: PHP ". phpversion()."\n";

	mail($email, $subject, $message,$header);
}

function sendUserMail($email, $title, $content){
	global $contentUserMail;
	$message = str_replace("%1", $content, $contentUserMail);
	sendMail($email, $title, $message);
}

function sendAdminMail($admin, $sender, $title, $content){
	global $contentAdminMail;
	$message = str_replace("%1", $content, $contentAdminMail);
	$message = str_replace("%2", $sender, $message);
	sendMail($admin, $title, $message, $sender);
}

function sendMailToAdmins($sender, $title, $content){
	global $adminEmails;
	foreach($adminEmails as $admin){
		sendAdminMail($admin, $sender, $title, $content);	
	}
}

function sendRecoveryMail($mail, $pwd){
	global $contentRecoveryMail;
	
	$subject = "Neues Passwort für Latrinalia";
	$message = str_replace("%1", $pwd, $contentRecoveryMail);

	sendMail($mail, $subject, $message);
}

?>
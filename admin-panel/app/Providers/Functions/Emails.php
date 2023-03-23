<?php
	global $vihangammail; global $sendgrid;
	$vihangammail = new \SendGrid\Mail\Mail();
	$sendgrid = new \SendGrid("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");
	function send_email_verification_code($uname, $uemail, $secode){
		$to = $uemail;
		$subject = $secode. " Vihangam Confirmation Code";
		$message = '<!DOCTYPE html>
		<html>
			<head></head>
			<body style="background-color: #eee; margin: 0px; padding: 0px;">
				<div style="float:left; width:100%;  margin:0;padding:0;font-family: sans-serif;font-size: 13px;text-align: center;">
					<div style="display:inline-block; max-width:780px;  background-color:#ffffff;margin:30px 0 30px;padding:30px 0 30px 0px;text-align: left;">
						<table style="border:none; border-collapse:collapse;margin: 0 30px 0 30px;" border="0">
							<tbody>
								<tr>
									<td style="padding: 0 0 20px; border-bottom: 1px solid #e4e4e4; vertical-align: top; text-align: center;"><img src="'.url('img/logo.png').'" alt="Vihangam" style="max-width: 280px;display: inline-block;"></td>
								</tr>
								<tr>
									<td style="padding: 30px 0 20px;">Use the verification code: <span style="display: inline-block; font-size: 15px; font-weight: bold; padding: 0 0 0 5px;">'.$secode.'</span><br><span style="display: inline-block; padding: 5px 0 0 0; color: #993300;">Please use the verification code:</span><span style="display: inline-block; font-size: 15px; font-weight: bold; padding: 5px 0 0 5px; color: #993300;">'.$secode.'</span></td>
								</tr>
								<tr>
									<td style="padding: 20px 0 20px;"><span style="display: inline-block; width: 100%; padding: 5px 0 0 0; color: #993300;">If this email is irrelevant or still face issues, please report to <a style="text-decoration: none; color: #0052cc;" href="mailTo:support@vihangam.in">support@vihangam.in</a></span></td>
								</tr>
								<tr>
									<td></td>
								</tr>
								<tr>
									<td style="color: #000;font-weight: bold;font-size: 14px;">Team - Vihangam<br><a style="text-decoration: none; color: #0052cc; font-size: 11px;font-weight: normal;" href="https://www.vihangam.in">https://www.vihangam.in</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</body>
		</html>';
		$message = wordwrap($message,70); 
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";		
		$headers .= "From: info@vihangam.in";
		//mail($to, $subject, $message, $headers); 
		global $vihangammail; global $sendgrid;
		$vihangammail->setFrom("noreply@vihangam.com", "Vihangam");
		$vihangammail->setSubject($subject);
		$vihangammail->addTo($to, $uname);
		$vihangammail->addContent("text/html", $message);
		try {
			$response = $sendgrid->send($vihangammail); 
			if($response->statusCode() == 202){
				return true;
			}else{
				return false;
			}
		} catch (Exception $e) {
			echo 'Caught exception: '. $e->getMessage() ."\n";
		} 
		return true;
	} 
?>
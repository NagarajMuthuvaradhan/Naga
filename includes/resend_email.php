 <?php
include('mail/SMTPconfig.php');
include('mail/SMTPClass.php');
if($_SESSION['gate']==1)
{
	$_SESSION['gate']==0;
	header("Location: logout.php");
	exit();
}
$confirm=0;
if($_GET['confirm'])
{
	$confirm=1;
}

//stalin -taf start
$promo_campaign =  $dbslave->query("SELECT SENDER_USER_ID  FROM taf_campaign_to_user WHERE (RECEIVER_USER_ID ='".$_SESSION['rs_userid']."');");
$promo_campaign_cnt = mysql_fetch_array($promo_campaign);
$sender = $promo_campaign_cnt['SENDER_USER_ID'];
$useremail=$dbslave->query("SELECT EMAIL_ID FROM user WHERE USER_ID='".$_SESSION['rs_userid']."'");
$mailval=mysql_fetch_array($useremail);
$usrmail = $mailval['EMAIL_ID'];		
//stalin -taf end
			
if($_POST['submit'])
{

	if ($_SESSION['rs_userid'])		
	{
		// print_r($_SESSION);
		$user_name=$_SESSION['rs_username'];
		$user_id=$_SESSION['rs_userid'];
		$fname=$_SESSION['rs_firstname'];
		$email=trim($_REQUEST['email']);
	
		if(strlen($email)>0)
		{
		//*************************************************
			if(emailcheck($email)==false) 		
			{	
		//		echo "Invalid Email";	
				$empty=1;
				$err_msg="Invalid Email";	
				
				//Log file info
				$log->write_log($email." Invalid  Email (Resend Activation)","Login_out","error"); 	
			}
			else{
			$_SESSION['el'] = $email;
		//***************************************************	
		
				$random_password=md5(uniqid(rand()));
				$new_password=substr($random_password, 0, 6);	
				$your_password=md5($new_password);
		
				$query="SELECT USER_ID FROM user WHERE EMAIL_ID='{$email}'";
				$result = $dbslave->query($query) or die (mysql_error());								
				$num=mysql_num_rows($result);		
					if($num>0){
						$row = mysql_fetch_array($result);			
						$users_id=$row['USER_ID'];	
														
							if($users_id==$user_id){
							    $confirm=2;	
								//Log file info
								$log->write_log($email." Given Email address already Exists (Resend Activation)","Login_out","error");							
								$email_code=base64_encode($email);
								//$from="admin@chumbaworld.com";
								//$from=chumba_config("Site email address");
								$url=BASE_PATH;
								$activationKey = base64_encode($user_id);
								if($sender!="")
								{
									$link = $url."confirm.php?reg_usr=$sender&userid=$activationKey&e=$email_code'";
								}
								else
								{
									$link = $url."confirm.php?userid=$activationKey&e=$email_code'";
								}
								
$email_code=base64_encode($email);
$from=chumba_config("Site email address");
$subject = " Welcome to Chumbacasino";
$message="<pre><font size='4'>
Hello $fname <br />

Here are your details for your <b>CHUMBA REAL MONEY ACCOUNT</b><br />
<b>
Email: $email<br /></b>

Click this link or cut and paste the link below on your browser to activate your account <br />
<a href='$link'>$link</a><br />

If you did not sign up for this please click the link below:<br>
<a href='$url"."index.php'>$url</a><br />

Enjoy and meet other people in CHUMBA REAL MONEY ACCOUNT.<br />

Your Chumba Team<br />

If you ever need support or have comments for us contact our Customer Service Team<br />
<a href='".$url="http://".$_SERVER['HTTP_HOST']."/ticket/upload/'>http://".$_SERVER['HTTP_HOST']."/ticket/upload/</a><br />

Disclaimer: This is an automated message. Please do not respond to this.</font></pre>";							
							
//***************************************MAY -02 ******************************	
$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $email, $subject, $message);
$SMTPChat = $SMTPMail->SendMail();


		//Log file info
		$log->write_log($email." Resend activation mail sent successfully (Resend Activation)","Login_out"); 	
		
header("Location: ".url_rewrite('user','resend_email_confirmation'));
exit;
//***************************************MAY -02 ******************************		
							}else
							{
								
								//Log file info
								$log->write_log($email." Given Email address already Exists with another user (Resend Activation)","Login_out","error"); 	
								$confirm=3;
								//exit();
							}
					//	exit();							
					}
					else{			
$update_email = "UPDATE user set EMAIL_ID='{$email}' WHERE USER_ID={$user_id}";
$result = $dbmaster->query($update_email) or die (mysql_error());
if($result)
{						
$email_code=base64_encode($email);
$from=chumba_config("Site email address");
$url=BASE_PATH;
$activationKey = base64_encode($user_id);
	if($sender!="")
		{
			$link = $url."confirm.php?reg_usr=$sender&userid=$activationKey&e=$email_code'";
		}
		else
		{
			$link = $url."confirm.php?userid=$activationKey&e=$email_code'";
		}
$subject = " Welcome to Chumbacasino";
$message="<pre><font size='4'>
Hello $fname <br />

Here are your details for your <b>CHUMBA REAL MONEY ACCOUNT</b><br />
<b>
Email: $email<br /></b>

Click this link or cut and paste the link below on your browser to activate your account <br />
<a href='$link'>$link</a><br />

If you did not sign up for this please click the link below:<br>
<a href='$url"."index.php'>$url</a><br />

Enjoy and meet other people in CHUMBA REAL MONEY ACCOUNT.<br />

Your Chumba Team<br />

If you ever need support or have comments for us contact our Customer Service Team<br />
<a href='".$url="http://".$_SERVER['HTTP_HOST']."/ticket/upload/'>http://".$_SERVER['HTTP_HOST']."/ticket/upload/</a><br />

Disclaimer: This is an automated message. Please do not respond to this.</font></pre>";

//***************************************MAY -02 ******************************								

$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $email, $subject, $message);
$SMTPChat = $SMTPMail->SendMail();

		//Log file info
		$log->write_log($email." Resend activation mail sent successfully (Resend Activation)","Login_out");
		
header("Location: ".url_rewrite('user','resend_email_confirmation'));
exit;
//***************************************MAY -02 ******************************									
						}		
					}
		
/*				else
				{
					
				}*/
			}
		}
		else
		{	
			$empty=1;
			$err_msg="Please enter your Email";	
		}
	}
	else
	{
		$empty=1;
		$err_msg="Please enter your Email";	
	}
}else{
//	echo $confirm;
}
 ?> 
<form method="post" name="activation" action="<?php echo url_rewrite('user','resend_email'); ?>" >
<div id="Hdr_Register">
  Resend E-mail
</div><div id="Reg_Fields_Wrap">
<div id="Reg_Success">
<span id='activationCodeTxt' width="100" class="errmsg" style="color:#FF0000;text-align:center;"><? if($confirm==2){echo "Given Email address already Exists";} if($confirm==3){echo "Given Email address already Exists with another user";}  if($empty==1){echo $err_msg;} ?></span><br /><br />
Your account is not activated. Please enter below the e-mail address to resend the activation code.  
</div>
<div id="Reg_Email">
<?php
if($sender!="")
{
?>
	<input name="email" type="text" class="text_field_big watermarked"  id="email" value="<?php echo $usrmail;?>" readonly="readonly"    title="E-mail Address" /> 
<?php
}
else
{
?>
	<input name="email" type="text" class="text_field_big watermarked"  id="email"       title="E-mail Address"/>
<?php
}
?>
</div>
<div id="Reg_Success">
Check your SPAM folder to see if the verification has ended up in there. 
</div>
<div id="Btn_SignupWrap">
<button value="submit" class="submitBtn" type="submit" name="submit"></button>
</div>
</div>
</form>
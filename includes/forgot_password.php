<?php
include('mail/SMTPconfig.php');
include('mail/SMTPClass.php');
if($_GET['f']){

	$confirm=0;
	$err=1;
	
}else{	 
	$confirm=0;
	$err=0;
}
if(isset($_REQUEST['email_to']))
	{

	$email_to=$_POST['email_to'];
	$err_flg=0;
	if(isEmpty($email_to)==true)	
	{		
		$pem=1;
		$err_flg=1;
		$_SESSION['err1']="Please Enter Your E-Mail Id";
	}
	else if(emailcheck($email_to)==false) 		
	{
		$err_flg=1;
		//Log file info
		$log->write_log($email_to." Invalid Email (Forget Password)","Login_out","error");	
		$_SESSION['err1']="Invalid Email";
		$pn=1;
	}
	if ($err_flg==1) 
	{
		//url_rewrite('user','forgot_password');
		header("Location:".url_rewrite('user','forgot_password')."&reg=101&err_flg=1&e=".trim($email_to));
		exit();
	}
	
	// retrieve password from table where e-mail = $email_to(mark@phpeasystep.com)
	$sql="SELECT PASSWORD FROM user WHERE EMAIL_ID='{$email_to}'";	
	$result=$dbslave->query($sql);
	
	// if found this e-mail address, row must be 1 row
	// keep value in variable name "$count"
	$count=mysql_num_rows($result);	
	// compare if $count =1 row
	if($count==1){
	$rows=mysql_fetch_array($result);	
	// keep password in $your_password
	$random_password=md5(uniqid(rand()));
	$new_password=substr($random_password, 0, 6);	
	$your_password=md5($new_password);

	$sql_update = "update user set PASSWORD='{$your_password}' where EMAIL_ID='{$email_to}'";
	$res=$dbmaster->query($sql_update) or die(mysql_error());	
	
	//Log file info
	$log->write_log($email_to." - $new_password - "." Password Updated (Forget Password)","Login_out","error");	
	
	$query="SELECT FIRSTNAME,LASTNAME,USERNAME,USER_ID FROM user WHERE EMAIL_ID='{$email_to}'";
	$result = $dbslave->query($query) or die (mysql_error());								
	$num=mysql_num_rows($result);		
	if($num>0){		
		$row = mysql_fetch_array($result);			
		$user_name=$row['USERNAME'];
		$user_id=$row['USER_ID'];	
		$username=$row['FIRSTNAME']." ".$row['LASTNAME'];
	}

		$mqry=$dbslave->query("SELECT * FROM etemplate WHERE TITLE='forgot_password_ccrm'");
		$mrow=mysql_fetch_array($mqry);
		//$to = $email_to; //
		include('mail/SMTPconfig.php');
		include('mail/class.phpmailer.php');

		$eurl = $url."common_template.php?et=forgot_password_ccrm";
		$ch = curl_init();
		// set URL and other appropriate options  
		curl_setopt($ch, CURLOPT_URL, $eurl);  
		curl_setopt($ch, CURLOPT_HEADER, 0);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
		// grab URL and pass it to the browser  			  
		$content = curl_exec($ch);
		curl_close($ch);

		$farr=array('%USERNAME%','%NEWPASSWORD%');
		$rarr=array($username,$new_password);
		$message=str_replace($farr,$rarr,$content);

		//send mail activity started here
		$replayto=chumba_config("Site email address");//"noreplay@chumbaworld.com";
		$msg=$message;
		$from=chumba_config("Site email address");//chumba_config("Site email address");	//from address
		$frmname="Chumba Casino"; //from name
		//$to = $mval['EMAIL']; //to address
		$toname = $email_to;//chumba_config("Site email address"); //$mval['EMAIL']; //to name "support@testzendekcom.zendesk.com"
		$subject=$mrow['SUBJECT']; //subject
		//exit;
		try {
			$mail = new PHPMailer(true); //New instance, with exceptions enabled
		
			$body             = $msg;//file_get_contents($eurl);
			$body             = preg_replace('/\\\\/','', $body); //Strip backslashes
			
			$mail->IsSMTP();                           // tell the class to use SMTP
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			$mail->Port       = $SmtpPort;//25;                    // set the SMTP server port
			$mail->Host       = $SmtpServer;//"mail.yourdomain.com"; // SMTP server
			$mail->Username   = $SmtpUser;//"name@domain.com";     // SMTP server username
			$mail->Password   = $SmtpPass;//"password";            // SMTP server password
		
			$mail->AddReplyTo($replayto,"Chumba Casino");
		
			$mail->From       = $from;
			$mail->FromName   = $frmname;
		
			$to = $toname;
		
			$mail->AddAddress($to);
		
			$mail->Subject  = $subject;
		
			//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
			
			$mail->WordWrap   = 80; // set word wrap
		
			$mail->MsgHTML($body);
		
			$mail->IsHTML(true); // send as HTML
		
			$mail->Send();
			//echo 'Message has been sent.';
			$log->write_log($user_name." forget password mail sent to ".$email_to." successfully (Forget Password)","Login_out");
		} catch (phpmailerException $e) {
			$log->write_log($user_name." forget password mail not sent".$e->errorMessage(),"Login_out");
		}
		//exit;
	header("location: ".url_rewrite('user','forgot_password_confirmation'));
	exit(0);
		 }
	
	// else if $count not equal 1
	else {
	
	//Log file info
	$log->write_log($email_to." Given email address not found in our database.(Forget Password)","Login_out","error");	
			 
	header("Location:".url_rewrite('user','forgot_password')."&f=1");
	exit(0);	
	}	
}
?>
<div id="Hdr_Register">
  Forgot Password
</div>
<script type="text/javascript">
function CheckEmail(Email,ids)
{
      //var match = (/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/i);
 
      var match = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9_-]+\.)+[a-zA-Z0-9.-]{2,5}$/;
      if(match.test(Email)){document.getElementById("err").innerHTML="";document.getElementById("Reg_UsrName").style="border:solid 0px red"; return true}
      else
      {	    document.getElementById("err").innerHTML="Please Enter Valid Email Address.";
	  		document.getElementById("Reg_UsrName").style="border:solid 1px red";
		   return false
      }
 
}
function submitformfor(){
var emid=document.getElementById("email_to").value;
	if(emid!=""){
		if(CheckEmail(emid,email_to)){
		document.getElementById("err").innerHTML="";
		return true;
		}
		else{
		document.getElementById("Reg_UsrName").style="border:solid 1px red";
		document.getElementById("err").innerHTML="Please Enter Valid Email Address.";
		return false;
		}
	}
	else{
	document.getElementById("Reg_UsrName").style="border:solid 1px red";
	document.getElementById("err").innerHTML="Please Enter Valid Email Address.";
	return false;
	}
}

</script>
<form name="forgot" action="" method="post" id="forgot" onsubmit="return submitformfor()">
<?PHP
echo '<span id="phperr">';
if($_GET['f']==1) { $msg="Given email address not found in our database."; } if($_REQUEST['f']==3) { $msg="Cannot send password to your e-mail address.";} echo '</span>' ?>
<ul id="RegError_wrap">
  <li id="RegError_Txt"> <span  id='forgetpasswordtxt'>
  <span id="err">
      <? 	  
	  if($_GET['err_flg']==1)
      { 
          echo $_SESSION["err1"];
          //$_SESSION["err1"]="";          
      }
      else if($err==1)
       {
         echo $msg; 
       } 
         ?>
         </span>    
    </span></li>
</ul>
<div id="Reg_Fields_Wrap">
  <div id="Reg_UsrName">
    <input name="email_to" type="text" id="email_to" class="text_field_big watermarked" autocomplete="off" onblur="return CheckEmail(this.value,this.id)" value="<?PHP echo $_REQUEST['e']; ?>" title="E-Mail Address" />
</div>
<div id="Btn_SignupWrap">
<button value="submit" class="sendBtn" type="submit"></button>
</div>
</div>
</form>

<?php
//print_r($_SESSION);
$locale = $_SESSION['LOCALE_ID'] = "16";
if(!isset($_SESSION['ccrm_userid'])){
$_SESSION['ccrm_userid']=$_REQUEST['usrid'];
}
if(isset($_POST['upload']) && $_POST['upload']=='Upload')
{
if($_SESSION['ccrm_userid']!=""){
		@extract($_POST);
		//echo '<pre>';
		//print_r($_POST);
		//echo '</pre>';
		$email=addslashes($email);
		$scqt=$secqust;
		$answer=addslashes($answer);
		
		if($email!='' && $secqust!='' && $answer!=''){
		//echo "SELECT EMAIL from user_verification WHERE USER_ID='$_SESSION[ccrm_userid]' and EMAIL='".mysql_escape_string($email)."'";
		//exit;
			$selQry = $dbslave->query("SELECT EMAIL from user_verification WHERE USER_ID='$_SESSION[ccrm_userid]' and EMAIL='".mysql_escape_string($email)."'");
			if(mysql_num_rows($selQry)>0){
				//echo "SELECT EMAIL, SECRET_QTN, ANSWER from user_verification WHERE USER_ID='$_SESSION[ccrm_userid]' and SECRET_QTN='".mysql_escape_string($scqt)."' and ANSWER='".mysql_escape_string($answer)."'";
				///exit;
				$selQry1 = $dbslave->query("SELECT EMAIL, SECRET_QTN, ANSWER from user_verification WHERE USER_ID='$_SESSION[ccrm_userid]' and SECRET_QTN='".mysql_escape_string($scqt)."' and ANSWER='".mysql_escape_string($answer)."'");
				if(mysql_num_rows($selQry1)>0){
				$vPin = time().rand(10,99);
				$sqlupd=$dbmaster->query("UPDATE user_verification SET VERIFICATION_PIN='$vPin' WHERE USER_ID='$_SESSION[ccrm_userid]'");
				
				$mdata = $dbslave->query("SELECT FIRST_NAME,LAST_NAME,EMAIL,VERIFICATION_PIN FROM user_verification where USER_ID ='".$_SESSION['ccrm_userid']."'");
				$mval=mysql_fetch_array($mdata);
				$mqry=$dbslave->query("SELECT * FROM etemplate WHERE TITLE='forgot_pin_request'");
				$mrow=mysql_fetch_array($mqry);
				include('mail/SMTPconfig.php');
				include('mail/class.phpmailer.php');
		
				$eurl = $url."common_template.php?et=forgot_pin_request";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $eurl);  // set URL and other appropriate options  
				curl_setopt($ch, CURLOPT_HEADER, 0);  
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  			  
				$content = curl_exec($ch);  			  // grab URL and pass it to the browser  			  
				curl_close($ch);
				$farr=array('%FULLNAME%','%VERIFICATION_PIN%');
				$rarr=array($mval['FIRST_NAME']." ".$mval['LAST_NAME'],$mval['VERIFICATION_PIN']);
				$message=str_replace($farr,$rarr,$content);
		
				//send mail activity started here
				$from = chumba_config("Site email address"); //admin email address
				$frmname="Chumba Casino";
				$replayto=$from;
				$msg=$message;
				$toname = $mval['EMAIL']; //to name
				$subject=$mrow['SUBJECT']; //subject
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
						$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
						$mail->WordWrap   = 80; // set word wrap
						$mail->MsgHTML($body);
						$mail->IsHTML(true); // send as HTML
						$mail->Send();
						//echo 'Message has been sent.';
					} catch (phpmailerException $e) {
						echo $e->errorMessage();
					}
				header("Location: ".url_rewrite1('user','forgotpin','msg=success'));
				exit;
				}
				else{
				header("Location: ".url_rewrite1('user','forgotpin','msg=fpin3'));
				exit;
				}
			}
			else{
				header("Location: ".url_rewrite1('user','forgotpin','msg=fpin2'));
				exit;
			}
		}
		else{
				header("Location: ".url_rewrite1('user','forgotpin','msg=fpin1'));
				exit;
		}
	}
	else{
				header("Location: ".url_rewrite1('user','forgotpin','msg=fpin4'));
				exit;
	}
		
}
?>
<script type="text/javascript">
function LTrim( value ) {
	
	var re = /\s*((\S+\s*)*)/;
	return value.replace(re, "$1");	
}

// Removes ending whitespaces
function RTrim( value ) {
	
	var re = /((\s*\S+)*)\s*/;
	return value.replace(re, "$1");
	
}
// Removes leading and ending whitespaces
function trim( value ) {
	
	return LTrim(RTrim(value));
}
function CheckEmail(Email,ids)
{
      var match = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9_-]+\.)+[a-zA-Z0-9.-]{2,5}$/;
      if(match.test(Email)){return true}
      else
      {
           document.getElementById(ids).value='';
		   document.getElementById("Error-username").innerHTML="<span style='color:#FF0000'>Please Enter valid Email Address</span>";
		   document.getElementById(ids).focus();
		   return false
      }
 
}
function isAlphaNumeric(e){
            var k;
            //document.all ? k=e.keycode : k=e.which;
            k = (e.which) ? e.which : event.keyCode;
            return((k>47 && k<58)||(k>64 && k<91)||(k>96 && k<123)||k==0 || k==32);
}
function emptyValidation(fieldList) {
var counter=0;
var substr = fieldList.split(',');
$.each(substr , function(i, val) { 
  if(trim(document.getElementById(substr [i]).value)=="") {
   var fldspn="marked-"+i;
   document.getElementById(fldspn).style.color="#FF0000";
   counter++;
  } else {
   var fldspn="marked-"+i;
   document.getElementById(fldspn).style.color="#000000";
  }
});
 if(counter>0) {
  document.getElementById("Error-username").innerHTML="Please fill out all areas marked with red.* ";
  return false;
 }  else {
  return true;
 }
}
function fmvalidate(){
var field11="email,secquest,answer";
	if(emptyValidation(field11)){
	return true;
	}
	else{
	document.getElementById("Error-username").innerHTML="<span style='color:#FF0000'>Please fill out all areas marked with red.* </span>";
	return false;
	}
}
</script>
<style>
.selectBox-dropdown { position: relative; cursor: default; background-position: left top; height: 25px;  padding-top: 0px; font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif; font-size:11px; color: #000000; text-align:left; }
.selectBox-dropdown .selectBox-label { padding: 7px 8px; display: inline-block; white-space: nowrap; overflow: hidden; font-size:11px; }
.selectBox-dropdown .selectBox-arrow { position: absolute; top: 0; right: 0; width: 23px; height: 100%; background: url(images/combo_arrow_history.png) top center no-repeat;  }
.selectBox-dropdown-menu { position: absolute; z-index: 99999; max-height: 200px; min-height: 1em; border: solid 1px #BBB; -moz-box-shadow: 0 2px 6px rgba(0, 0, 0, .2); -webkit-box-shadow: 0 2px 6px rgba(0, 0, 0, .2); box-shadow: 0 2px 6px rgba(0, 0, 0, .2); overflow: auto; font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif; font-size:11px; color: #000000; background-color: #e5e5e5; }
</style>
<?php if($_GET['msg']=="success"){ ?>
<div id="fpin_Hdr_Register">Chumba Casino PIN Sent</div>
<div id="Age_conf_Ver_Wrap">
<div style="padding:20px;margin:20px;text-align:center;">
<p>Thank you for submitting all information.</p>
<p>Please check your email for your new PIN.</p>
<br/><div id="Btn_BackGanmeWrap">
<button value="submit" class="BackGameBtn" type="submit" onclick="javascript:parent.jQuery.fancybox.close(); parent.egamestatus('visible');"></button>
</div>
</div>
</div>
<?php } else {?>
<div id="fpin_Hdr_Register">Forgot PIN</div>
<div id="Age_conf_Ver_Wrap">
<?php if($_GET['msg']=="") { ?>
<div class="notify_txt" id="Error-username"><span>Enter your details below to receive your new PIN.</span></div>
<?php } else { ?>
<div id="Error-username" style="width:100%;padding-top:10px;color:red;text-align:center;">
<?php 
if($_GET['msg']=="fpin1"){
	echo "Please fill out all areas marked*";
}
elseif($_GET['msg']=="fpin2")
{
	echo "<span style='color:#FF0000'>Please enter Registered email</span>";
}
elseif($_GET['msg']=="fpin3"){
	echo "<span style='color:#FF0000'>Please enter your correct Question and Answer</span>";
}
elseif($_GET['msg']=="fpin4"){
echo "<span style='color:#FF0000'>Please login</span>";
}
?>
</div>
<?php }?>
<form name="ageVerification" method="post" enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:12px; font-weight:lighter; color:#3F3F3F;">
<tr><td>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>
<div id="Id_proof_Wrap1">
<div id="Id_Txt_cnt2"><span id="marked-0" style="color:#000000"><b>*</b></span> Email: </div>
<div id="Id_Field05">
<input type="text" name="email" id="email" autocomplete="off" class="Id_txtField1" onblur="return CheckEmail(this.value,this.id)" onchange="return CheckEmail(this.value,this.id)" value="<?php echo $EMAIL; ?>" tabindex="6"/>
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap1">
<div id="Id_Txt_cnt2"><span id="marked-1" style="color:#000000"><b>*</b></span> Questions: </div>
<div id="sect_drop_menu">
<select name="secqust" id="secquest" class="custom-class1 custom-class2" style="width:301px;" tabindex="13">
<option value="">Select Secret Question--></option>
<?php
$sqlCountry = $dbslave->query("SELECT * FROM secret_question order by SECRET_QUESTION_ID");
while ($row = mysql_fetch_array($sqlCountry)) {
if(isset($SECRET_QTN) && $row['QUESTION']==stripslashes($SECRET_QTN)){
$select='selected="selected"';
}
else{
$select='';
}
?>
<option value="<?php echo $row['QUESTION'];?>" <?php echo $select;?>><?php echo $row['QUESTION'];?></option>
<?php } ?>
</select>
<br/>
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap1">
<div id="Id_Txt_cnt2"><span id="marked-2" style="color:#000000"><b>*</b></span> Answer</div>
<div id="Id_Field05"><input type="text" autocomplete="off" name="answer" onkeypress="return isAlphaNumeric(event)" id="answer" class="Id_txtField1" value="<?php echo $ANSWER;?>" tabindex="14"/></div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Btn_UploadWrap">
<button type="submit" name="upload" id="upload" value="Upload" class="submitBtn" onclick="return fmvalidate();" tabindex="18"></button>
</div>
</div>
</td>
</tr>
</table>
</td>
</tr>
</table>
</form>
</div>
<?php } ?>
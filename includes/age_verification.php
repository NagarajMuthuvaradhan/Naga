<?php 
$locale = $_SESSION['LOCALE_ID'] = "16";
if(!isset($_SESSION['ccrm_userid'])){
$_SESSION['ccrm_userid']=$_REQUEST['usrid'];
}
$selQry = $dbslave->query("SELECT * from user_verification WHERE USER_ID='$_SESSION[ccrm_userid]'");
if(mysql_num_rows($selQry)>0){
	$selRes = mysql_fetch_assoc($selQry);
	$faxnumber = ($selRes['FAX_NO'] != '')?$selRes['FAX_NO']:$_SESSION['ccrm_userid'].time();
} else {
	$faxnumber = $_SESSION['ccrm_userid'].time();
}
$concatName = $_SESSION['ccrm_userid'].'_';
	
if($_SESSION['ccrm_userid'])
{
	
	if(isset($_POST['upload']) && $_POST['upload']=='Upload')
	{
		 	@extract($_POST);
			//print_r($_POST);
			//exit;
			$ddob=$dobyear."-".$dobmonth."-".$dobday;
			$_SESSION['formfield']=array('FIRST_NAME'=>$fname,'LAST_NAME'=>$lname,'DOB'=>$ddob,'EMAIL'=>$email,'PAYPAL_EMAIL'=>$paypalemail,'ADDRESS'=>$address,'CITY_TOWN'=>$city,'STATE'=>$state,'ZIPCODE'=>$zipcode,'COUNTRY'=>$country,'SECRET_QTN'=>$secqust,'ANSWER'=>$answer,'PROOF_OF_AGE'=>'','PROOF_OF_ADDRESS'=>'');
			if($termCon=="on"){
			if(trim($fname)!='' && trim($lname)!='' && trim($dobmonth)!='' && trim($dobday)!='' && trim($dobyear)!='' && trim($email)!='' && trim($paypalemail)!='' && trim($address)!=''  && trim($city)!='' && trim($state)!='' && trim($zipcode)!='' && trim($country)!='' && trim($secqust)!='' && trim($answer)!=''){
			if (($_FILES['proof1']['name'] != '' && $_FILES['proof2']['name'] != '') || ($faxno != "" && $_POST['faxchk'] == 1) ) {
				$Ageverify=0;
				$Idverify=0;
					//echo print_r($_FILES);
					//exit;
				if($_POST['faxchk'] != 1) {
					if ((($_FILES["proof1"]["type"] == "image/gif") || ($_FILES["proof1"]["type"] == "image/jpeg") || ($_FILES["proof1"]["type"] == "image/pjpeg")  || ($_FILES["proof1"]["type"] == "image/png")) && ($_FILES["proof1"]["size"] < 5242880)){
							$pf1icon = $concatName.$_FILES['proof1']['name'];
							$pathicon1 = 'assets/ageverification/identificationproof/';
							$filepathicon1 = $pathicon1.$pf1icon;
		
								$tmpisopf1 = $_FILES['proof1']['tmp_name'];
								if($selRes['ID_PROOF']!='' && file_exists($selRes['ID_PROOF'])){
									unlink($selRes['ID_PROOF']);
								}
								move_uploaded_file($tmpisopf1, $filepathicon1);
								$Idverify=1;
					}
					else
					{
						$log->write_log($_SESSION['ccrm_username']." Identification proof file not supported (Age Verification)","UserInfo","error");
						$err = 1;
					}
					
					if ((($_FILES["proof2"]["type"] == "image/gif") || ($_FILES["proof2"]["type"] == "image/jpeg") || ($_FILES["proof2"]["type"] == "image/pjpeg") || ($_FILES["proof2"]["type"] == "image/png")) && ($_FILES["proof2"]["size"] < 5242880)){
							$pf2icon = $concatName.$_FILES['proof2']['name'];
							$pathicon2 = 'assets/ageverification/addressproof/';
							$filepathicon2 = $pathicon2.$pf2icon;
							
							$tmpisopf2 = $_FILES['proof2']['tmp_name'];
							if($selRes['ADDRESS_PROOF']!=''  && file_exists($selRes['ID_PROOF'])){
								unlink($selRes['ADDRESS_PROOF']);
							}
							move_uploaded_file($tmpisopf2, $filepathicon2);
							$Ageverify=1;
					}
					else{
						$log->write_log($_SESSION['ccrm_username']." Address proof file not supported (Age Verification)","UserInfo","error");
					}
					$isfax = 'no';
					$faxno = "";
				} else {
					$isfax = 'yes';
					$filepathicon1 = "";
					$filepathicon2 = "";
					$log->write_log($_SESSION['ccrm_username']." Address proof and Age proof details sent through fax ($faxno)","UserInfo","error");
				}
				
				if(($Ageverify==1 && $Idverify==1) || ($faxno != "" && $_POST['faxchk'] == 1)){
				$uid=$_SESSION['ccrm_userid'];
				$dob=$dobyear."-".$dobmonth."-".$dobday;
				$secqust1=addslashes($secqust);
					if(isset($selRes['STATUS']) && ($selRes['STATUS']==2 || $selRes['STATUS']==0)){
					$upd="UPDATE user_verification SET FIRST_NAME='".mysql_secure($fname)."', LAST_NAME='".mysql_secure($lname)."', DOB='".mysql_secure($dob)."', EMAIL='".mysql_secure($email)."', PAYPAL_EMAIL='".mysql_secure($paypalemail)."', ADDRESS='".mysql_secure($address)."', CITY_TOWN='".mysql_secure($city)."', STATE='".mysql_secure($state)."', ZIPCODE='".mysql_secure($zipcode)."', COUNTRY='".mysql_secure($country)."', SECRET_QTN='".mysql_secure($secqust1)."', ANSWER='".mysql_secure($answer)."', PROOF_OF_AGE='".mysql_secure($filepathicon1)."', PROOF_OF_ADDRESS='".mysql_secure($filepathicon2)."', FAX_NO='".mysql_secure($faxno)."', STATUS='0', REASON='', CREATED_DATE=NOW(), UPDATED_DATE=NOW() where USER_ID=$uid";
					$dbmaster->query($upd);
					$upd1="UPDATE user SET ID_PROOF='0' where USER_ID=$uid";
					$dbmaster->query($upd1);
					$err = 6;
					}
					else{
					$sql="INSERT INTO user_verification (USER_ID, FIRST_NAME, LAST_NAME, DOB, EMAIL, PAYPAL_EMAIL, ADDRESS, CITY_TOWN, STATE, ZIPCODE, COUNTRY, SECRET_QTN, ANSWER, PROOF_OF_AGE, PROOF_OF_ADDRESS, FAX_NO, STATUS, VERIFICATION_PIN, REASON, CREATED_DATE, UPDATED_DATE) VALUES ($uid,'".mysql_secure($fname)."','".mysql_secure($lname)."','".mysql_secure($dob)."','".mysql_secure($email)."','".mysql_secure($paypalemail)."','".mysql_secure($address)."','".mysql_secure($city)."','".mysql_secure($state)."','".mysql_secure($zipcode)."','".mysql_secure($country)."','".mysql_secure($secqust1)."','".mysql_secure($answer)."','".mysql_secure($filepathicon1)."','".mysql_secure($filepathicon2)."','".mysql_secure($faxno)."','0','','',NOW(),NOW())";
					$dbmaster->query($sql);
					$upd1="UPDATE user SET ID_PROOF='0' where USER_ID=$uid";
					$dbmaster->query($upd1);
					$err = 6;
					}
				}
				else{
					if($faxno != "" && $_POST['faxchk'] == 1){
					$err = 7;
					} else {
					$err = 2;
					}
				}
				
				
			}
			else
			{
				$log->write_log($_SESSION['ccrm_username']." Identification proof files not supported (Age Verification)","UserInfo","error");
				$err = 3;
			}
		}
		else{
		$err = 5;
		}
		}
		else{
		$err = 4;
		}
	}			
	if($err == 6)			
	{
		$mdata = $dbslave->query("SELECT uv.FIRST_NAME,uv.LAST_NAME,uv.CREATED_DATE,uv.EMAIL,uv.COUNTRY,u.EMAIL_ID FROM user_verification uv INNER JOIN user u ON u.USER_ID=uv.USER_ID where u.USER_ID ='".$_SESSION['ccrm_userid']."' LIMIT 1");
		$mval=mysql_fetch_array($mdata);
		$mqry=$dbslave->query("SELECT * FROM etemplate WHERE TITLE='verification_request'");
		$mrow=mysql_fetch_array($mqry);
		$to = chumba_config("Site email address"); //admin email address
		include('mail/SMTPconfig.php');
		include('mail/class.phpmailer.php');
		
		//$message = 'YOUR AGE PROOF ACCEPTED BY CHUMBACASINO ADMIN';
		//$subject=$mrow['SUBJECT'];
		//$from=$mval['EMAIL'];
/*		$eurl = $url."common_template.php?et=verification_request";
		$bourl = $url."admin/admin-home.php?p=Vproof7&chk=7&userId=".$_SESSION['ccrm_userid'];
		$burl='<a href="'.$bourl.'">'.$bourl.'</a>';
		$ch = curl_init();
		// set URL and other appropriate options  
		curl_setopt($ch, CURLOPT_URL, $eurl);  
		curl_setopt($ch, CURLOPT_HEADER, 0);  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  			  
		// grab URL and pass it to the browser  			  
		$content = curl_exec($ch);  			  
		curl_close($ch);  
*/		$content=$mrow['DESCRIPTION'];

		if($isfax == 'no') {
			$content = str_replace('Unique Fax Pin No:','',$content);
			$content = str_replace('%FAXNO%','',$content);
			$content = preg_replace('/<faxdet>(.*?)<\/faxdet>/s', '', $content);
			//preg_match_all('/<faxdet>(.*?)<\/faxdet>/s', $content, $content);
		}
		
		$farr=array('%FIRSTNAME%','%LASTNAME%','%EMAIL%','%COUNTRY%','%DATETIME%','%FB_EMAIL%','%FAXNO%');
		$rarr=array($mval['FIRST_NAME'],$mval['LAST_NAME'],$mval['EMAIL'],$mval['COUNTRY'],$mval['CREATED_DATE'],$mval['EMAIL_ID'],$faxno);
		$message=str_replace($farr,$rarr,$content);

		//send mail activity started here
		$replayto=$mval['EMAIL'];//"noreplay@chumbaworld.com";
		$msg=$message;
		$from=$mval['EMAIL'];//chumba_config("Site email address");	//from address
		$frmname=$mval['FIRST_NAME']; //from name
		//$to = $mval['EMAIL']; //to address
		$toname = chumba_config("Site email address"); //$mval['EMAIL']; //to name "support@testzendekcom.zendesk.com"
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
		
			$mail->AddReplyTo($replayto,"chumbaworld");
		
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
		} catch (phpmailerException $e) {
			echo $e->errorMessage();
		}
		//echo $body;
		?>
        <a id="ageredirect" href="javascript: parent.jQuery.fancybox.open({href : 'userpages_new.php?pname=age_verification_confirmation&prfupld=<?php echo $isfax?>', width:'500', type : 'iframe', openEffect : 'fade', closeEffect : 'fade', fitToView : false, nextSpeed : 0, prevSpeed : 0});" title="Facebook"></a>
        <script type="text/javascript">
		window.location = document.getElementById('ageredirect').href;
		parent.egamestatus('invisible');
		</script>
        <?php
		exit;
	}
	
	if($err == 1 || $err == 2 || $err == 3)
	{
		header("Location: ".url_rewrite1('user','age_verification','err='.$err.'&msg=uppf2tsplz9&usrid='.$_SESSION['ccrm_userid']));
		exit;
	}
	if($err == 5){
		header("Location: ".url_rewrite1('user','age_verification',"msg=uppf2tsplz10&usrid=".$_SESSION['ccrm_userid']));
		exit;
	}
	if($err == 4){
		header("Location: ".url_rewrite1('user','age_verification',"msg=uppf2tsplz8&usrid=".$_SESSION['ccrm_userid']));
		exit;
	}
	if($err == 7){
		header("Location: ".url_rewrite1('user','age_verification',"msg=faxplz&usrid=".$_SESSION['ccrm_userid']));
		exit;
	}

}
else{
	//header("Location: index.php");
	//exit;
	echo "User not found";
}
/*if(!empty($selRes) && count($selRes)>0){
@extract($selRes);
}
else{
@extract($_SESSION['formfield']);
}*/
if(empty($_SESSION['formfield']) && count($_SESSION['formfield'])==0 || $_SESSION['formfield']==""){
@extract($selRes);
}
else{
@extract($_SESSION['formfield']);
}


$userbrowser=addslashes($_SERVER['HTTP_USER_AGENT']);


?>
<link href="css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<?php if(strstr($userbrowser,"MSIE")){
    ?>
<script type="text/javascript" src="js/jquery.fancybox.ie.js?v=2.1.4"></script>
<?php }else{
    ?>
<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.4"></script>
<?php } ?>
<script type="text/javascript">
function isNumberKey(evt) {
    
    var charCode = (evt.which) ? evt.which : event.keyCode;
    
    if (charCode >= 48 && charCode <= 57 || charCode == 46) {
        return true;
    }
    else {
        return false;
    }
}
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

function specialChar(txt,ids)
{
	var exp_username = /^[A-Za-z0-9_..]{3,20}$/;	
	//	var ck_name = /^[A-Za-z0-9 ]{3,20}$/;
	var exp_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i 
	var exp_password =  /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/;	

	if (!exp_username.test(txt)) 
	{
		document.getElementById(ids).value='';
		document.getElementById(ids).focus();
		alert("Special Char Not allowed");
		
		//document.getElementById(errarea).innerHTML = err;
		return false;
	}
	return true;
}
function CheckEmail(Email,ids)
{
      //var match = (/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/i);
 
      var match = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9_-]+\.)+[a-zA-Z0-9.-]{2,5}$/;
      if(match.test(Email)){return true}
      else
      {
           document.getElementById(ids).value='';
		   document.getElementById("Error-username").innerHTML="Please Enter valid Email Address";
		   document.getElementById(ids).focus();
		   return false
      }
 
}
function isAlphaNumeric(e){ // Alphanumeric only
            var k;
            
            //document.all ? k=e.keycode : k=e.which;
             k = (e.which) ? e.which : event.keyCode;
            
            return((k>47 && k<58)||(k>64 && k<91)||(k>96 && k<123)||k==0 || k==32);
}

function onlyAlphabets(e, t) {

            try {

                if (window.event) {

                    var charCode = window.event.keyCode;

                }

                else if (e) {

                    var charCode = e.which;

                }

                else { return true; }
                
                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode==0 || charCode==8 || charCode==32)

                    return true;

                else

                    return false;

            }

            catch (err) {

                alert(err.Description);

            }

}
function emptyValidation(fieldList) {
var counter=0;
var ct=0;
var substr = fieldList.split(',');
$.each(substr , function(i, val) { 
 // console.log(i+'==='+substr [i]);
//   console.log('marked-'+j+'counter==='+ct);
     j=i;
  if(trim(document.getElementById(substr [i]).value)=="") {
	   if(i==8 || i==9 || i==10){
		  j=7; ct=','+i;
	   }
   //console.log(ct);
   var fldspn="marked-"+j;
   document.getElementById(fldspn).style.color="#FF0000";
   counter++;
  } else {
   var fldspn="marked-"+j;
   document.getElementById(fldspn).style.color="#000000";
  }
});
//console.log('counter='+counter);
 if(counter>0) {
  document.getElementById("Error-username").innerHTML="Please fill out all areas marked with red.* ";
  return false;    
 }  else {
  return true;
 }
}


function fmvalidate(){

	var faxchk = document.getElementById('faxchk');
	if(faxchk.checked==true) {
		var field11="fname,lname,dobmonth,dobday,dobyear,email,paypalemail,address,city,state,zipcode,country,secquest,answer,faxno,termCon";
	} else {
		var field11="fname,lname,dobmonth,dobday,dobyear,email,paypalemail,address,city,state,zipcode,country,secquest,answer,proof1,proof2,termCon";
	}
	if(emptyValidation(field11)){
		if(document.getElementById('termCon').checked==true){
		return true;
		}
		else{
		document.getElementById('termCon').style.border="#FF0000 1px solid";
		document.getElementById("Error-username").innerHTML="Please agree to the Terms and Conditions";
		return false;
		}
	}
	else{
	document.getElementById("Error-username").innerHTML="Please fill out all areas marked with red.* ";
	return false;
	}
}

function faxCheck() {
	//imgCont idproofCont ageproofCont faxCont faxchk
	var faxchk = document.getElementById('faxchk');
	if(faxchk.checked==true) {
		document.getElementById('faxCont').style.display='block';
		document.getElementById('faxCont').style.display='table-row';
		document.getElementById('ageproofCont').style.display='none';
		document.getElementById('idproofCont').style.display='none';
		document.getElementById('imgCont').style.display='none';
	} else {
		document.getElementById('ageproofCont').style.display='block';
		document.getElementById('ageproofCont').style.display='table-row';
		document.getElementById('idproofCont').style.display='block';
		document.getElementById('idproofCont').style.display='table-row';
		document.getElementById('imgCont').style.display='block';
		document.getElementById('imgCont').style.display='table-row';
		document.getElementById('faxCont').style.display='none';
	}
}

function termsofcon() {
	jQuery.fancybox.open({
		openEffect : 'elastic',
		closeEffect : 'elastic',
		fitToView: false,
		nextSpeed: 0, //important
		prevSpeed: 0, //important
		href : 'agetermspages.php?pid=3',
		type : 'iframe',
		padding : 5,
		beforeShow: function(){
			// added 50px to avoid scrollbars inside fancybox
                        this.width = 650;
                        this.height = 900;
			//this.width = (jQuery('.fancybox-iframe').contents().find('html').width())+50;
			//this.height = (jQuery('.fancybox-iframe').contents().find('html').height())+50;
			this.style ="background:red";
		}
	});
}
</script>
<div id="Hdr_Register">Verification</div>
<div id="Age_Ver_Wrap">
<div id="Error-username" style="color:red;text-align:center;padding-right:30px;">
<?php 
if($_GET['msg']=="uppf2tsplz8"){
	echo "Please agree to the Terms and Conditions";
}
elseif($_GET['msg']=="uppf2tsplz10"){
	echo "Please fill out all areas marked*";
}
elseif($_GET['msg']=="uppf2tsplz9")
{
	echo "Please upload only Image maximum file size is 5MB any format.";
}
elseif($_GET['msg']=="faxplz")
{
	echo "Please enter fax details.";
}

?>
</div>
<div class="notify_txt"><span>To verify your identification please complete all fields below.</span></div>
<form name="ageVerification" method="post" enctype="multipart/form-data">
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:12px; font-weight:lighter; color:#3F3F3F;">
<tr><td>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt1"><span id="marked-0" style="color:#000000"><b>*</b></span> First Name</div>
<div id="Id_Field03"><input type="text" name="fname" autocomplete="off" id="fname" class="Id_txtField" onkeypress="return onlyAlphabets(event,this);" style="width:150px;text-decoration:none;" value="<?php echo $FIRST_NAME;?>" tabindex="1" /></div>
</div>
</td>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt1"><span id="marked-1" style="color:#000000"><b>*</b></span> Last Name</div>
<div id="Id_Field03"><input type="text" name="lname" autocomplete="off" id="lname" class="Id_txtField" style="width:150px" onkeypress="return onlyAlphabets(event,this);" value="<?php echo $LAST_NAME?>" tabindex="2" /></div>
</div>
</td>
</tr>
</table>
</td></tr>
<?php
	if(isset($DOB)){
	$exdob=explode("-",$DOB);
	}

$month = array(array("01","Jan"),array("02","Feb"),array("03","Mar"),array("04","Apr"),array("05","May"),array("06","Jun"),array("07","Jul"),array("08","Aug"),array("09","Sep"),array("10","Oct"),array("11","Nov"),array("12","Dec"));
$currentyear=date("Y");
?>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-2" style="color:#000000"><b>*</b></span> Date of birth</div>
<div id="aeg_DOB_Wrap"> 
    <select id="dobmonth" name="dobmonth" class="custom-class1 custom-class2" style="width: 68px;" rel="dobmonth" tabindex="3">
    <option value="">mm</option>
    <?php for($i=0; $i<12; $i++) {
if($exdob[1]==$month[$i][0]){
$select='selected="selected"';
}
else{
$select='';
}
	 ?>
    <option value="<?PHP echo $month[$i][0];?>" <?php echo $select;?>><?PHP echo $month[$i][0]; ?></option> 
    <?php } ?>
    </select>
</div>
<div id="aeg_DOB01_Wrap"><span id="marked-3" style="color:#000000;display:none;"><b>*</b></span> 
    <select id="dobday" name="dobday" class="custom-class1 custom-class2" style="width: 60px;" rel="dobday" tabindex="4">
    <option value="">dd</option>
    <?php for($i=1; $i<32; $i++) {

	if($exdob[2]==$i){
$select='selected="selected"';
}
else{
$select='';
}

	
	 ?>
    <option value="<?PHP echo $i;?>" <?php echo $select;?>><?PHP echo $i; ?></option> 
    <?php } ?>    
    </select>
             
</div>
<div id="aeg_DOB02_Wrap"><span id="marked-4" style="color:#000000;display:none;"><b>*</b></span> 
    <select id="dobyear" name="dobyear" class="custom-class1 custom-class2" style="width: 77px;" rel="dobyear" tabindex="5">
    <option value="">yy</option>
    <?php for($i=$currentyear-18; $i>1910; $i--) { 
	
	if($exdob[0]==$i){
$select='selected="selected"';
}
else{
$select='';
}

	?>
    <option value="<?php echo $i ;?>" <?php echo $select;?>> <?php echo $i; ?> </option>
    <?php } ?>
    </select>              
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-5" style="color:#000000"><b>*</b></span> Email</div>
<div id="Id_Field02">
<input type="text" name="email" id="email" class="Id_txtField" autocomplete="off" value="<?php echo $EMAIL; ?>" tabindex="6"/>
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-6" style="color:#000000"><b>*</b></span> Paypal Email</div>
<div id="Id_Field02" style="width:250px;">
<input type="text" name="paypalemail" id="paypalemail" autocomplete="off" class="Id_txtField" value="<?php echo $PAYPAL_EMAIL?>" tabindex="7" />
</div>
<div style="float:left"><a href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-submit" target="_blank"><img src="images/pp_cc_mark_37x23.jpg" height="35" /></a></div>
</div>
</td>
</tr>
<tr>
<td>
<span style="font-size:12px;font-weight:normal">Click the Paypal logo to open a Paypal account or click <a target="_blank" href="https://www.paypal.com/us/cgi-bin/webscr?cmd=_login-submit">here</a></span>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-7" style="color:#000000"><b>*</b></span> Residential / Postal address</div>
<div id="Id_Field02">
<input type="text" name="address" id="address" autocomplete="off" class="Id_txtField" value="<?php echo $ADDRESS; ?>" tabindex="8" />
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-8" style="color:#000000;display:none;"><b>*</b></span> </div>
<div id="Id_Field02">
<input type="text" name="city" id="city" autocomplete="off" onkeypress="return isAlphaNumeric(event)" class="Id_txtField" value="<?php echo $CITY_TOWN;?>" tabindex="9" />
</div>
</div>
</td>
</tr>
<tr>
<td style="text-align:center;padding-right:40px;"><span>City/Town</span></td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"></div>
<div id="Id_Field04">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>
<div id="Id_proof_Wrap"><span id="marked-9" style="color:#000000;display:none;"><b>*</b></span> 
<div id="Id_Field03"><input type="text" name="state" id="state" autocomplete="off" onkeypress="return isAlphaNumeric(event)" class="Id_txtField" style="width:127px" value="<?php echo $STATE;?>" tabindex="10"/></div>
</div>
</td>
<td>
<div id="Id_proof_Wrap"><span id="marked-10" style="color:#000000;display:none;"><b>*</b></span> 
<div id="Id_Field03"><input type="text" autocomplete="off" name="zipcode" id="zipcode" class="Id_txtField" onkeypress="return isAlphaNumeric(event)" style="width:127px" value="<?php echo $ZIPCODE;?>" tabindex="11" /></div>
</div>
</td>
</tr>
</table>
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap" style="padding-bottom:0px">
<div id="Id_Txt_cnt"></div>
<div id="Id_Field04">
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td style="text-align:center;padding-right:120px;"><span>State</span></td>
<td  style="text-align:center;padding-right:100px;"><span>Zipcode</span></td>
</tr>
</table>
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-11" style="color:#000000"><b>*</b></span> Country</div>
<div id="aeg_country_Wrap">
    <select id="country" name="country" class="custom-class1 custom-class2" style="width: 300px;" rel="country" tabindex="12">
    <option value="">Country</option>
    <?php
    $sqlCountry = $dbslave->query("SELECT * FROM countries where CountryID!='169' order by CountryName");
    while ($row = mysql_fetch_array($sqlCountry)) {
	if(isset($COUNTRY) && $row['CountryName']==$COUNTRY){
	$select='selected="selected"';
	}
	else{
	$select='';
	}
    ?>
    <option value="<?php echo $row['CountryName'];?>" <?php echo $select; ?>><?php echo $row['CountryName'];?></option>
    <?php } ?>
    </select>         
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-12" style="color:#000000"><b>*</b></span> Secret Question</div>
<div id="sect_drop_menu">
<select name="secqust" id="secquest" class="custom-class1 custom-class2" style="width:301px; font-size:9px;" tabindex="13">
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
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-13" style="color:#000000"><b>*</b></span> Answer</div>
<div id="Id_Field02"><input type="text" name="answer" autocomplete="off" onkeypress="return isAlphaNumeric(event)" id="answer" class="Id_txtField" value="<?php echo $ANSWER;?>" tabindex="14"/></div>
</div>
</td>
</tr>

<tr>
<td>
<div id="Id_proof_Wrap" style="margin-top:5px;">    <span id="marked-16" style="color:#000000;display:none"><b>*</b></span>
<div  style="float:left;width:20px;"><input type="checkbox" name="faxchk" id="faxchk" value="1" onclick="faxCheck();"  /></div>
<div class="id_valid_info"> An email confirmation with your details and your Chumba Casino PIN will be sent to you once we have verified your information. Please keep a record of your PIN for all future transactions. If you are sending your identification by fax, please include your unique fax number so we can complete your verification process.</div>
</div>    
</td>
</tr>

<tr id="faxCont" style="display:none;">
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-14" style="color:#000000"><b>*</b></span> Fax Unique Id</div>
<div id="Id_Field02">
<input type="text" name="faxno" id="faxno" class="Id_txtField" autocomplete="off" value="<?php echo $faxnumber; ?>" tabindex="6" readonly="readonly" style="color:#FF0000; font-weight:bold;"/>
</div>
</div>
</td>
</tr>

<tr id="ageproofCont">
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-14" style="color:#000000"><b>*</b></span> Proof of Age</div>
<div id="Id_Field02">
    <div id="divinputfile">
        <input name="proof1" type="file" size="22" autocomplete="off"  id="proof1" <?php echo 'class="filepc"'; ?> onchange="document.getElementById('fakefilepc').value = this.value;" tabindex="15"/>
        <div id="fakeinputfile"><input autocomplete="off" name="fakefilepc" type="text" id="fakefilepc" /></div>
    </div>
</div>
</div>
</td>
</tr>
<tr id="idproofCont">
<td>
<div id="Id_proof_Wrap">
<div id="Id_Txt_cnt"><span id="marked-15" style="color:#000000"><b>*</b></span> Proof of Address</div>
<div id="Id_Field02">
    <div id="divinputfile">
            <input name="proof2" type="file" size="22"  id="proof2" <?php echo 'class="filepc"';  ?> onchange="document.getElementById('fakefilepc1').value = this.value;" autocomplete="off" tabindex="16"/>
            <div id="fakeinputfile"><input name="fakefilepc1" type="text" autocomplete="off" id="fakefilepc1" /></div>
    </div>
</div>
</div>
</td>
</tr>
<tr id="imgCont">
<td style="text-align:right;padding-right:55px;">
<span>Image maximum file size is 5MB any format</span>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap">
<div id="Btn_UploadWrap">
<button type="submit" name="upload" id="upload" value="Upload" <?php echo 'class="uploadBtn"'; ?> onclick="return fmvalidate();" tabindex="18"></button>
</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap" style="margin-top:5px;">    <span id="marked-16" style="color:#000000;display:none"><b>*</b></span>
<div  style="float:left;width:20px;"><input name="termCon" id="termCon" type="checkbox" autocomplete="off" tabindex="17" /></div>
<div class="id_valid_info"> I acknowledge that I have a Paypal account to receive payment. I agree that all information I provide is true and correct at the time of submission and I accept and agree to the <a href="#" onclick="javascript:termsofcon()">Terms and Conditions.</a></div>
</div>    
</td>
</tr>
<tr>
<td>
<div id="Id_proof_Wrap" style="margin-top:-5px;">
    <div id="Id_error_info" style="text-align:left">
	<?php
     if($selRes['STATUS'] == '0') {
	 ?>
	 <span class="ErrorBig">Your Address & Identification Proof: <?php echo 'Waiting for admin approval'; ?></span>
	 <?php
	 }
     if($selRes['STATUS'] == '2') {
	 ?>
	 <span class="ErrorBig">Verification: <?php echo 'REJECTED'; ?>. <span class="ErrorBig"> <?php echo $selRes['REASON']; ?></span>
     </span>
	 <?php
	 }
	?>
   </div>
</div>
</td>
</tr>
</table>
</form>
</div>

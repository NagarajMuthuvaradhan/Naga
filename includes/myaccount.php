<?php
if(isset($_POST['hdnProcess']) && $_POST['hdnProcess'] == 'changepword') {
	
	$dbmaster->query("UPDATE user SET PASSWORD= '".md5($_POST['npass'])."' WHERE USER_ID=".$_SESSION['ccrm_userid']);
		
	
	include('mail/SMTPconfig.php');
	include('mail/class.phpmailer.php');
	//send mail activity started here
	
	$mqry=$dbslave->query("SELECT * FROM etemplate WHERE TITLE='change_password_confirm'");
	$mrow=mysql_fetch_array($mqry);
	 
	$eurl = $url."common_template.php?et=change_password_confirm";
	$ch = curl_init();
	// set URL and other appropriate options  
	curl_setopt($ch, CURLOPT_URL, $eurl);  
	curl_setopt($ch, CURLOPT_HEADER, 0);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  			  
	// grab URL and pass it to the browser  			  
	$content = curl_exec($ch);  			  
	curl_close($ch); 
	
	$farr=array('%FIRSTNAME%','%USERNAME%','%PWD%');
	$rarr=array($_POST['cfname'],$_POST['cuname'],$_POST['npass']);
	$message=str_replace($farr,$rarr,$content);
	
	$replayto=chumba_config("Site email address");//"noreplay@chumbaworld.com";
	$msg=$message;
	$from=chumba_config("Site email address");//chumba_config("Site email address"); //from address
	$frmname=$_POST['cfname']; //from name
	//$to = $mval['EMAIL']; //to address
	$toname = $_POST['cemail'];//$mval['EMAIL']; //to name
	$_SESSION['CPASS_EMAIL'] = $_POST['cemail'];
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
	
	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
	
	$mail->WordWrap   = 80; // set word wrap
	
	$mail->MsgHTML($body);
	
	$mail->IsHTML(true); // send as HTML
	
	$mail->Send();
	//echo 'Message has been sent.';
	} catch (phpmailerException $e) {
	echo $e->errorMessage();
	}
	header("location: ".url_rewrite('user','account_confirm'));
} else if(isset($_POST['hdnProcess']) && $_POST['hdnProcess'] == 'changecountry') {
	$dbmaster->query("UPDATE user SET COUNTRY= '".$_POST['country']."' WHERE USER_ID=".$_SESSION['ccrm_userid']);
}
?>
<script type="text/javascript" src="js/jquery.crypt.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	
	if (!jQuery.browser.msie) {
        $("input:password").each(function() {
            if (this.value == '') {
                this.type = "text";
            }
            $(this).focus(function() {
                this.type = "password";
            });
            $(this).blur(function() {
                if (this.value == '') {
                    this.type = "text";
                }
            });
        });
    }

    $("input:text, input:password").each(function() {
        if (this.value == '') {
            this.value = this.title;
        }
    });
	
	$("#cpass").Watermark("Current Password");
	$("#npass").Watermark("New Password");
	$("#rpass").Watermark("New Password again");
	$("#email").Watermark("E-mail Address");
	$("#epass").Watermark("Enter your Password");
	
});

/*$('#btncpword').click(function() {
    var errors = 0;
    $("#editPword input").map(function(){
		alert('tester');
         if( !$(this).val() ) {
              $(this).addClass('errTxtBox');
              errors++;
        } else if ($(this).val()) {
              $(this).removeClass('errTxtBox');
        }   
    });
    if(errors > 0){
        $('#errMsg').text("All fields are required");
        return false;
    }
    // do the ajax..    
});*/

function validateTextBoxes()
{
	$("#editPword input ").each( function()
	{
		
		if ( $(this).is('[type=text]') && !parseInt( $(this).val() ) )
		{
			$(this).blur();
			$(this).addClass('errTxtBox');
		} else {	
		  	$(this).removeClass('errTxtBox');
		}
	});
}


function emptyValidation(fieldList) {
var counter=0;
var substr = fieldList.split(',');
var firstIds = "";

$.each(substr , function(i, val) { 
var ids=substr [i];
$("#"+ids).removeClass('errTxtBox');
  if(trim(document.getElementById(ids).value)=="" || document.getElementById(ids).value==document.getElementById(ids).title) {
		if(firstIds == "") firstIds = ids;
		//document.getElementById(ids).focus();
		$("#"+ids).addClass('errTxtBox');
		var txt='Enter '+document.getElementById(ids).title;
		//$("#"+ids).Watermark(txt,"#F00");
		$("#"+ids+":password").blur(function() {
			if (this.value == '') {
				this.type = "text";
			}
		});
   		counter++;
  } else {
		$("#"+ids).removeClass('errTxtBox');
  }
});
//console.log('counter='+counter);
 if(counter>0) {
	 $('#errMsg').text("All fields are required");
	 $('#errMsg').css('color', '#f50000');
	 document.getElementById(firstIds).focus();
  return false;    
 }  else {
  return true;
 }
}



function fmvalidateCpass(){
	var field11="cpass,npass,rpass";
	var cpass = document.getElementById('cpass');
	var npass = document.getElementById('npass');
	var rpass = document.getElementById('rpass');
	var opass = document.getElementById('oldpass');
	var comp = $().crypt({method:"md5",source:$("#cpass").val()});
	//console.log(comp+' '+opass.value);
	$('#errMsg').text("");
	if(!emptyValidation(field11)){
		return false;
	} else if(opass.value!="" && opass.value!="1" && comp != opass.value) {
		$('#errMsg').text("Your old Password Incorrect");
		$("#regpwd1").addClass('errTxtBox');
		$('#errMsg').css('color', '#f50000');
		return false;
	//alert("Successfully form validated");
	} else if(npass.value != rpass.value) {
		$('#errMsg').text("Your new Password Mismatch");
		$("#regpwd2").addClass('errTxtBox');
		$('#errMsg').css('color', '#f50000');
		return false;
	
	} else {
		$("#regpwd1").removeClass('errTxtBox');
		return true;
	}
}

function fmvalidateCpass1(idval){
	var cpass = idval;
	var opass = document.getElementById('oldpass');
	var comp = $().crypt({method:"md5",source:$("#cpass").val()});
	$('#errMsg').text("");
	if(opass.value!="" && opass.value!="1" && comp != opass.value) {
		$('#errMsg').text("Your old Password Incorrect");
		$("#regpwd1").addClass('errTxtBox');
		$('#errMsg').css('color', '#f50000');
		return false;
	} else {
		$("#regpwd1").removeClass('errTxtBox');
		return true;
	}
}

function fmvalidateCpass2(idval){
	var npass = document.getElementById('npass');
	var rpass = document.getElementById('rpass');
	$('#errMsg').text("");
	if(npass.value != rpass.value) {
		$('#errMsg').text("Your new Password Mismatch");
		$("#regpwd2").addClass('errTxtBox');
		$("#regpwd3").addClass('errTxtBox');
		$('#errMsg').css('color', '#f50000');
		return false;
	} else {
		$("#regpwd2").removeClass('errTxtBox');
		$("#regpwd3").removeClass('errTxtBox');
		return true;
	}
}
function frmvalidatecountry(){
var cnt=document.getElementById('country');
if(cnt.value!=""){
return true;
}
else{
$('#errMsg1').css('color', '#f50000');
$('#errMsg1').text("Please Select Country");
$("#reg_country_Wrap").addClass('errTxtBox');
return false;
}
}
</script>
<style>
.selectBox-dropdown { position: relative; cursor: default; background-position: left top; height: 30px;  padding-top: 5px; font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif; font-size:12px; color:#808080; }
.selectBox-dropdown .selectBox-label { padding: 3px 8px; display: inline-block; white-space: nowrap; overflow: hidden; font-size:12px; }
.selectBox-dropdown .selectBox-arrow { position: absolute; top: 0; right: 0; width: 23px; height: 100%; background: url(images/combo_arrow_down.png) top center no-repeat;  }
.selectBox-dropdown-menu { position: absolute; z-index: 99999; max-height: 200px; min-height: 1em; border: solid 1px #BBB; -moz-box-shadow: 0 2px 6px rgba(0, 0, 0, .2); -webkit-box-shadow: 0 2px 6px rgba(0, 0, 0, .2); box-shadow: 0 2px 6px rgba(0, 0, 0, .2); overflow: auto; font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif; font-size:12px; color:#808080; background-color: #e5e5e5; }

.errBorder {
    float:right;
    border:2px solid #dadada;
    border-radius:7px;
    font-size:20px;
    padding:5px;
    margin-top:-10px;  
	outline:none;
    border-color:#9ecaed;
    box-shadow:0 0 10px #9ecaed;  
}

.tblpad td { padding:10px 0px; }

</style>
<?php
$month = array(array("01","Jan"),array("02","Feb"),array("03","Mar"),array("04","Apr"),array("05","May"),array("06","Jun"),array("07","Jul"),array("08","Aug"),array("09","Sep"),array("10","Oct"),array("11","Nov"),array("12","Dec"));
$currentyear=date("Y");
?>
<div id="Reg_Wrap">
<div id="Reg_top"></div>
<div id="Reg_mid">
<div id="Hdr_Register">Your Account</div>
<div id="Reg_Fields_Wrap">
<?php
$userid=$_SESSION['ccrm_userid']!=""?$_SESSION['ccrm_userid']:0;
$query=$dbslave->query("select USERNAME,FIRSTNAME,LASTNAME,PASSWORD,DATE_FORMAT(DATE_OF_BIRTH, '%d/%m/%Y') DATE_OF_BIRTH,EMAIL_ID,CITY,STATE,COUNTRY,PINCODE, MEMBERSHIP_ID,MEMBERSHIP_FLAG,MEMBERSHIP_DATE,ACCOUNT_STATUS from user where USER_ID=$userid");
if(mysql_num_rows($query)>0){
$row=mysql_fetch_assoc($query);
@extract($row);
}
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:12px; font-weight:lighter; color:#3F3F3F;">
<tr><td>
<table class="tblpad" border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>
<div>
<div id="Reg_Txt_cnt_lbl">Name</div>
<div id="Reg_Txt_cnt2"><?php echo $FIRSTNAME." ".$LASTNAME;?></div>
</div>
</td>
</tr>
<tr>
<td>
<div>
<div id="Reg_Txt_cnt_lbl">Username</div>
<div id="Reg_Txt_cnt2"><?php echo $USERNAME;?></div>
</div>
</td>
</tr>
<tr>
<td>
<div>
<div id="Reg_Txt_cnt_lbl">Password</div>
<div id="Reg_Txt_cnt2">
			<span id="disPword"><span style="font-weight:bold;">.................</span>
            <!--<input type="password" style="background:transparent;border:none;" readonly="readonly"  value="<?php echo $PASSWORD;?>"/>-->
            <div id="reg_btn" style="float:right;padding-right:25px;"><span><a href="javascript://" onclick="document.getElementById('editPword').style.display='block'; document.getElementById('disPword').style.display='none';">(Edit)</a></span></div>
            </span>
            <span id="editPword" style="display:none;">
            <form name="frmcpass" action="" method="post">
            <input type="hidden" name="hdnProcess" id="hdnProcess" value="changepword" />
            <input type="hidden" name="cuname" id="cuname" value="<?php echo $USERNAME;?>" />
            <input type="hidden" name="cfname" id="cfname" value="<?php echo $FIRSTNAME;?>" />
            <input type="hidden" name="cemail" id="cemail" value="<?php echo $EMAIL_ID;?>" />
            <input type="hidden" id="oldpass" name="oldpass"  value="<?php echo $PASSWORD;?>"/>
            <div style="width:250px;margin-top:10px; font-size:13px;"><span id="errMsg">Password must be 6-15 characters, space not allowed</span><br />
            <?php if($PASSWORD !="" && $PASSWORD != "1") { ?>
            <div class="Reg_Password" style="float:left" id="regpwd1">
            <input name="cpass" type="password" class="text_field_small_pass watermark_ot" id="cpass" value=""  title="Current Password" onblur="return fmvalidateCpass1(this.value)" onchange="return fmvalidateCpass1(this.value)" onfocus="this.type='password'; this.style.color='#000';" maxlength="15" tabindex="3"/>
            </div>
            <?php } ?>
            <div class="Reg_CPassword"  style="float:left" id="regpwd2">
              <input name="npass" type="password" class="text_field_small_pass watermark_ot" id="npass" value="" title="New Password" onfocus="this.type='password'; this.style.color='#000';" maxlength="15" tabindex="4"/>
            </div>
            <div class="Reg_CPassword"  style="float:left" id="regpwd3">
              <input name="rpass" type="password" class="text_field_small_pass watermark_ot" id="rpass" value="" title="New Password again" onfocus="this.type='password'; this.style.color='#000';" onblur="return fmvalidateCpass2(this.value)" onchange="return fmvalidateCpass2(this.value)"  maxlength="15" tabindex="4"/>
            </div>
            </div>
            <div id="reg_btn">
            <div>
            <div style="float:left"><button value="submit" class="okBtn" name="btncpword" id="btncpword" type="submit" onclick="return fmvalidateCpass();" tabindex="15"></button></div><div style="float:left"><div style="margin-top:7px;"><a href="javascript://" onclick="document.getElementById('editPword').style.display='none'; document.getElementById('disPword').style.display='block';" style="color:#0869be">(Cancel)</a></div></div>
            </div>
            </div>
            </form>
            </span>
            
</div>
</div>
</td>
</tr>
<tr>
<td>
<div>
<div id="Reg_Txt_cnt_lbl">E-mail Address</div>
<div id="Reg_Txt_cnt2"><?php echo $EMAIL_ID;?></div>
</div>
</td>
</tr>
<tr>
<td>
<div>
<div id="Reg_Txt_cnt_lbl">Date of Birth</div>
<div id="Reg_Txt_cnt2"><?php echo $DATE_OF_BIRTH?></div>
</div>
</td>
</tr>
<tr>
<td>
<div>
<div id="Reg_Txt_cnt_lbl">Country</div>
<div id="Reg_Txt_cnt2">
	<span id="disCountry">
	<?php echo $COUNTRY;?><div id="reg_btn" style="float:right;padding-right:25px;"><span><a href="javascript://" onclick="document.getElementById('editCountry').style.display='block'; document.getElementById('disCountry').style.display='none';">(Edit)</a></span></div>
    </span>
    <div id="editCountry" style="width:250px;margin-top:10px; display:none;">
    <span id="errMsg1"></span>
    <form name="frmCountry" id="frmCountry" action="" method="post" onsubmit="return frmvalidatecountry()">
    <input type="hidden" name="hdnProcess" id="hdnProcess" value="changecountry" />
    <div id="reg_country_Wrap" style="margin-bottom:10px;">
        <select id="country" name="country" class="custom-class1 custom-class2" style="width: 280px;" rel="country" tabindex="11">
        <option value="">Country</option>
        <?php
        $sqlCountry = $dbslave->query("SELECT * FROM countries where CountryID!='169' order by CountryName");
        while ($row = mysql_fetch_array($sqlCountry)) {
        if($row['CountryName']==$COUNTRY ){
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
    <div id="reg_btn">
    <div>
    <div style="float:left"><button value="submit" class="okBtn" name="btnpwd" type="submit" tabindex="15"></button></div><div style="float:left"><div style="margin-top:7px;"><a href="javascript://" onclick="document.getElementById('editCountry').style.display='none'; document.getElementById('disCountry').style.display='block';" style="color:#0869be">(Cancel)</a></div></div>
    </div>
    </div>
    </form>
    </div>
</div>
</div>
</td>
</tr>
<tr style="display:none">
<td>
<div>
<div id="Reg_Txt_cnt_lbl">VIP Membership</div>
<div id="Reg_Txt_cnt2"><?php echo $FIRSTNAME." ".$LASTNAME;?></div>
</div>
</td>
</tr>
<tr style="display:none">
<td>
<div>
<div id="Reg_Txt_cnt_lbl" style="width:200px;">Deactive Your Account</div>
<div id="Reg_Txt_cnt2" style="width:130px;padding:0px;margin-top:6px;"><?php $dec=$ACCOUNT_STATUS!=1?"(Activate)":"(Deactivate)";?>
<div id="reg_btn" style="float:left;"><span><a href="javascript:alert('Not available');" style="top:0px;"><?php echo $dec?></a></span></div>
</div>
</div>
</td>
</tr>


</table>
</td>
</tr>
</table>
</div>
</div>
<div id="Reg_bot"></div>
</div>

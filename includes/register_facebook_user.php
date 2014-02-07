<?php
	if(isset($_SESSION['ccrm_username']) && $_SESSION['ccrm_username']!="" && !$fbuser)
	{
		header("location: index.php");
	}
	
	if($_REQUEST['chk']=='1')
	{
		$fbemail_id = $_REQUEST['email'];	
		$fid       = $_REQUEST['fid'];		
		
		if(isEmpty($txt)==true)
		{	
			$err="Enter Email";
		}	
		else if($txt=='E-mail Address')	
		{
			$err="Enter Email";
		}	
		else if(firstChar($txt)==true)	
		{
			$err="First character should be alphabet or numeric";
		}	
		else if(endChar($txt)==true)	
		{
			$err="Last character should be alphabet or numeric";
		}
		else if(isSpaceExists($txt)==true)	
		{
			$err="Space not allowed";
		}	
		else if(emailcheck($txt)==false) 		
		{
			$err="Invalid Email";
		}					
		else if(emailexists($txt)==true) 
		{
			$err="Email id already Exists";		
		}				
		else
		{	
			
			$sqlinsert=$dbmaster->query("update `user` set USERNAME='{$fbemail_id}',EMAIL_ID='{$fbemail_id}' where FB_USER_ID='{$fid}'");	
			//Log file info
			$log->write_log($fusername." Facebook Email-Id Updated Successfully","Register");  
			$_SESSION['ccrm_username']=$fusername;
			//$user_id=$_SESSION['ccrm_userid'];
			$sqltack=$dbmaster->query("INSERT INTO `tracking` (`USERNAME`,`ACTION_NAME`,`DATE_TIME`,`SYSTEM_IP`,`STATUS`,`LOGIN_STATUS`) 
			VALUE ('$fbemail_id','registration',NOW(),'".$_SERVER['REMOTE_ADDR']."','1','3')");						
			echo '<script type="text/javascript"> window.location="'.BASE_PATH.'index.php?off=33&pg='.$_REQUEST['pg'].'&id='.$fid.'"; </script>';
			exit();
		}
	}	
?>
<script type="text/javascript">

$(document).ready(function() {

$("#email").Watermark("E-mail Address");

function notWatermark(value, element){
	return value != element.title;
}
$.validator.addMethod("notWatermark", notWatermark, "Field cannot be empty.");	
	// validate signup form on keyup and submit
	var validator = $("#frmfbuser").validate({
		errorElement: "div",
		errorPlacement: function(error, element) {
			error.appendTo('#Error-' + element.attr('id'));
		},
		rules: {
			email: {
				required: true,
				notWatermark: true,
				remote: "validations.php?var=email&fldname=email&sid="+Math.random()
			}
		},		
		messages: {
			email: {
				required: "Enter Email",
				notWatermark: "Enter Email",
				remote: jQuery.format("{0}")
			}
		}		
	});

});
</script>
<div id="Hdr_Register">Register</div>
<div id="Reg_Fields_Wrap">
<form class="frmpro" name="frmfbuser" id="frmfbuser" method="post" action="">
<input type="hidden" name="fid" id="fid" value="<?PHP echo $_GET['fid']; ?>" /> 
<input type="hidden" name="pg" id="pg" value="<?PHP echo $_GET['pg']; ?>" /> 
<input type="hidden" name="chk" id="chk" value="1" /> 
<div class="Reg_UsrName">
  <input name="email" type="text" class="text_field_big watermarked_ot" id="email" value="" title="E-mail Address" autocomplete="off"/>
  <div class="ErrorBig" id="Error-email"></div>  
</div>
<div id="Btn_SignupWrap">
<button value="submit" class="signupBtn" type="submit"></button>
</div>
</form>
</div>
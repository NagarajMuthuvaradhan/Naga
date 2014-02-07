<script type="text/javascript">
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
$("input:text, textarea, input:password").each(function() {
	if (this.value == '') {
		this.value = this.title;
	}
});
</script> 
<!--<ul id="social_icon_warp">
<li id="btn_fb"><a href="javascript://" title="Facebook"></a></li>
<li id="btn_twitter" title="Twitter"><a href="javascript://"></a></li>
</ul>-->
<ul id="signup_icon_warp">
<li id="btn_signup"><a href="<?php echo url_rewrite('signup','register'); ?>" title="Sign up"></a></li>
</ul>
<div id="Teaser">
    <ul id="btn_HomeLink_Homehdr_wrap">
    	<li id="btn_HomeLink_Homehdr" title="Home"><a href="<?php echo ROOT_PATH.'index.php'; ?>"></a></li>
    </ul>
	<div id="loginBox_warp">
    	<form name="frmlogtop" method="post" action="" onsubmit="return login_check();">
    	<span id="divLogin">
            <ul id="txtfield_UN_wrap">
                <li id="txtfield_UN"><input type="text" class="txtfieldTr watermarked" id="username2" name="username2" value="<?PHP echo $_COOKIE['member_username']; ?>" title="E-mail Address" onkeydown="if(this.value!='') txtBlur('user');" onblur="//if(this.value=='') ajaxCall(this.value,'email','login');" onkeyup="//ajaxCall(this.value,'email','login');" /></li>
            </ul>
            <ul id="txtfield_PWD_wrap">
                <li id="txtfield_PWD"><input type="password" class="txtfieldTr_pass watermarked" name="pass" id="pass" value="<?PHP echo $_COOKIE['member_pass']; ?>" title="Password" onkeydown="if(this.value!='') txtBlur('user');" onfocus="this.type='password'; this.style.color='#000';" onblur="//if(this.value!='') ajaxCall(this.value,'user','loginpassword');" /></li>
            </ul>
            <ul id="Remme_wrap">
            <li id="Remme_Txt">
              <label>              
              <input type="checkbox" name="remember" value="10" id="remember" <?PHP if($_COOKIE['member_username']!="") { ?> checked="checked" <?PHP } ?>/>
              <span style="color:#A4A4A7">Remember me</span></label>
            </li>
            </ul>
            <ul id="Fpwd_wrap">
                <li id="FPwd_Txt"><a href="<?php echo url_rewrite('user','forgot_password'); ?>" class="FpwdTxtColor">Forgot password?</a></li>
            </ul>           
            <ul id="LogError_wrap">
				<li id="LogError_Txt"><div id="user"></div></li>
			</ul>
        </span>
		<div id="loginAct_icon_warp">
			<button value="submit" id="log_link" class="logintopBtn" type="submit"></button>
		</div>
        </form>
	</div>
</div>
<script type="text/javascript">
/*$("#log_link").click(function () {
	//$("#log_link").replaceWith( '<button value="submit" class="logintopBtn" type="submit" onclick="return login_check();"></button>' );
	$("#log_link").replaceWith( '<button value="submit" class="logintopBtn" type="submit" ></button>' );
	$("#divLogin").css('visibility','visible');
});*/

 /* $(document).ready(function() {
	var tbval1 = $('#username2').val();
	$('#username2').focus(function() { $(this).val('');});
	$('#username2').blur(function() { $(this).val(tbval1);});
	var tbval2 = $('#pass').val();
	$('#pass').focus(function() { $(this).val('');});
	$('#pass').blur(function() { $(this).val(tbval2);});
  });*/
</script>
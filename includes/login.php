<?php session_start(); ?>
<div id="Hdr_Register">
  Login
</div>
<ul id="RegError_wrap">
  <li id="RegError_Txt"><span id="user"><?PHP echo $_GET['q']; ?><?PHP if($_GET['a']=='c') echo "Invalid  Activation Code";  if($_GET['a']=='a') echo "Your Account is Activated Successfully";  if($_GET['a']=='b') echo "Your Account is Already Activated";?></span></li>
</ul>
<form name="login" action="" method="post" id="login" onsubmit="return login_check();">
<div id="Reg_Fields_Wrap">
  <div class="Reg_UsrName">
    <input name="username2" type="text" class="text_field_big watermarked" id="username2" value="<?PHP echo $_COOKIE['member_username']; ?>" title="E-mail Address"/>
  </div>
  <div class="Reg_UsrName">
    <input name="pass" type="password" class="text_field_big_pass watermarked" id="pass" value="<?PHP echo $_COOKIE['member_pass']; ?>" onfocus="this.type='password'; this.style.color='#000';" title="Password" />
  </div>
  <div class="Reg_Rules">
  <input type="checkbox" tabindex="3" name="remember" value="10" id="remember" <?PHP if($_COOKIE['member_username']!="") { ?> checked="checked" <?PHP } ?>/>
  Remember me
</div> 
 
  <div id="Fpassword_link">
    <a href="<?php echo url_rewrite('user','forgot_password'); ?>" class="altFpwd">Forgot Password?</a>
  </div>
 <div id="Btn_AltLoginWrap">
  <button value="submit" class="loginBtn" type="submit" ></button>
</div>  
</div>
</form>
<script src = "js/login.js"  type="text/javascript" language="javascript"></script>
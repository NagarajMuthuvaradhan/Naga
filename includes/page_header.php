<?php
if($_SESSION['ccrm_username'] != "" && $_SESSION['ccrm_userid'] != "") { 
if($fbuser) { $lout = $logoutUrl; $loutid = 'id="fb-auth"'; } else { $lout='logout.php'; $loutid=""; }
if($fbuser) $loutonclick = 'onclick="'.$loginout.'"'; else $loutonclick=''; 
$lout='logout.php'; $loutid="";
$_SESSION['userid'];
$sqlres1 = $dbslave->query("SELECT * FROM user WHERE USER_ID = '".$_SESSION['ccrm_userid']."'");
$usrdets = mysql_fetch_array($sqlres1);
//print_r($usrdets); echo '-----------'.$_SESSION['username'].'-----------'
?>
<div id="subcontent2">
<div class="poptop"></div>
<div class="popmid">
<?php if($usrdets['USER_IMAGE'] != 'none') { ?><img src="<?php echo $usrdets['USER_IMAGE']; ?>" width="25" height="25" /><?php } ?><a href="javascript://" class="PopLink">Welcome, <?php if(trim($usrdets['FIRSTNAME']) !="" && trim($usrdets['FIRSTNAME']) !="none") echo substr(ucfirst($usrdets['FIRSTNAME']), 0, 7); else echo substr(ucfirst($_SESSION['ccrm_username']), 0, 7); ?>!</a><a href="javascript:dropdowncontent.hidediv('subcontent2<?php echo $cpop; ?>')" class="PopLink"><img src="images/arrow-up.png" /></a>
<!--<div id="Uname_img_wrap">
<img src="images/icon_facebook.png" /><span id="fbConn"><?php// if($fbuser) { ?><a href="javascript://" onclick="<?php// echo $loginout; ?>" <?php// echo $loutid; ?> class="PopLink_fb"><span id="nmsg">Disconnect</span></a><?php// } else { ?><a href="javascript://" onclick="<?php// echo $loginout; ?>" id="fb-auth" class="PopLink_fb"><span id="nmsg">Connect with Facebook</span></a><?php// } ?></span></div>-->
<?php if(curPageName() != 'index.php') { ?>
<div id="Game_history_pop_wrap">
<a href="<?php echo BASE_PATH.'index.php'; ?>" class="PopLink_fb">Back to Chumba Casino</a></div><?php } ?>
<div id="Pop_Logout"><a href="<?php if($_GET['pname'] == 'myaccount') echo 'javascript://'; else echo 'userpages_ccrm.php?pname=myaccount'; ?>" class="<?php if($_GET['pname'] == 'myaccount') echo 'Pop_Link_Disable'; else echo 'Pop_Link_Logout'; ?>">Your account</a></div>
<!--<div id="Pop_Logout"><a href="userpages_ccrm.php?pname=subscription" class="Pop_Link_Logout">VIP Membership</a></div>-->
<div id="Pop_Logout"><a href="<?php if($_GET['pname'] == 'myhistory') echo 'javascript://'; else echo 'userpages_ccrm.php?pname=myhistory'; ?>" class="<?php if($_GET['pname'] == 'myhistory') echo 'Pop_Link_Disable'; else echo 'Pop_Link_Logout'; ?>">My History</a></div>
<div id="Pop_Logout"><a href="<?php if($_GET['pname'] == 'gamehistory') echo 'javascript://'; else echo 'userpages_ccrm.php?pname=gamehistory'; ?>" class="<?php if($_GET['pname'] == 'gamehistory') echo 'Pop_Link_Disable'; else echo 'Pop_Link_Logout'; ?>">Game History</a></div>
<div id="Pop_Logout"><a href="<?php if($_GET['pname'] == 'paymentmethod') echo 'javascript://'; else echo 'userpages_ccrm.php?pname=paymentmethod'; ?>" class="<?php if($_GET['pname'] == 'paymentmethod') echo 'Pop_Link_Disable'; else echo 'Pop_Link_Logout'; ?>">Payment Method</a></div>
<div id="Pop_Logout"><a href="logout.php" <?php //echo $loutonclick; ?> <?php //echo $loutid; ?> id="nlout" class="Pop_Link_Logout">Log out</a></div>
</div>
<div class="popbot"></div>
</div>
<div id="In_Hdr">
<ul id="social_icon_inhdr_warp">
<li id="btn_fb_inhdr"><a class="fancybox fancybox.iframe" href="Email-Input.php" id="linkInvite" title="Facebook"></a></li>
<li id="btn_twitter_inhdr" title="Twitter"><a href="javascript://" onclick="newSendGift();" ></a><!--onclick="openInvite();"--></li>
</ul>
<ul id="btn_HomeLink_inhdr_wrap">
<li id="btn_HomeLink_inhdr" title="Home"><a href="<?php //echo ROOT_PATH; ?>index.php"></a></li>
</ul>
<div id="UsrDet_logout"> <a href="javascript://" id="contentlink" rel="subcontent2<?php echo $cpop; ?>" class="uname">Welcome, <?php if(trim($usrdets['FIRSTNAME']) !="" && trim($usrdets['FIRSTNAME']) !="none") echo substr(ucfirst($usrdets['FIRSTNAME']), 0, 7); else echo substr(ucfirst($_SESSION['ccrm_username']), 0, 7); ?>!&nbsp; <img src="images/arrow-down.png" /></a></div>
<div id="UsrImg_thumb"><?php if($usrdets['USER_IMAGE'] != 'none') { ?><img src="<?php echo $usrdets['USER_IMAGE']; ?>" width="25" height="25" /><?php } ?></div></div>
<?php } else { ?>
<div id="In_Hdr">
<ul id="social_icon_inhdr_warp">
<li id="btn_fb_inhdr"><a href="javascript://" id="linkInvite" title="Facebook"></a></li>
<li id="btn_twitter_inhdr" title="Twitter"><a href="javascript://"></a></li>
</ul>

<ul id="btn_HomeLink_inhdr_wrap">
<li id="btn_HomeLink_inhdr" title="Home"><a href="<?php echo ROOT_PATH; ?>index.php"></a></li>
</ul>

<div id="Top_login_button_wrap">
<?php
$fpname = trim(str_replace("../","",$_REQUEST['pname']));
$fpname = trim(str_replace("..%2F","",$_REQUEST['pname']));
 if($fpname == "forgot_password" || $fpname == "forgot_password_confirmation") { ?>
<div id="Top_btns">
<button value="submit" class="TSignupBtn" type="submit" onclick="window.location='<?php echo url_rewrite('signup','register'); ?>';"></button>
</div>
<?php } ?>
<div id="Top_btns">
<button value="submit" class="TloginBtn" type="submit" onclick="window.location='<?php echo url_rewrite('user','login'); ?>';"></button>
</div>
<div id="Top_btns">
<button value="submit" class="FloginBtn" id="fb-auth222" onclick="javascript:CallAfterLogin('yes');" type="submit"></button>
</div>
</div>
</div>
<?php } ?>

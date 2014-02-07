<?php if($_SESSION['SITE_LOC']=="LOCAL") { ?>
<div id="Foot_Links_Wrap">
  <ul id="social_icon_bot_warp">
    <span id="btn_flw_us">Follow Us!</span>
    <li id="btn_fb_bot"><a href="https://www.facebook.com/ChumbaCasino" title="Facebook" target="_blank"></a></li>
    <li id="btn_twitter_bot" title="Twitter"><a href="https://twitter.com/ChumbaCasino"  target="_blank"></a></li>
  </ul>
    <ul id="footer_links">
    <!--<a class="fancybox fancybox.iframe" href="Email-Input.php" id="linkInvite" title="Facebook">--><a href="javascript:;" onclick="javascript:ccrminvite_popup()">Invite Friends</a>&nbsp;&nbsp; <a href="sitepages.php?pname=4" target="_blank">Gambling</a>&nbsp;&nbsp; <a href="sitepages.php?pname=1" target="_blank">FAQ</a>&nbsp;&nbsp; <a href="sitepages.php?pname=2" target="_blank">Privacy Policy</a>&nbsp;&nbsp; <a href="sitepages.php?pname=3" target="_blank">Terms Of Use</a>
    </ul>
   <ul id="footer_links_contact_cant">
   Can't find what you're looking for?&nbsp;<a href="https://chumbacasino.zendesk.com/home" target="_blank" class="footer_contact_link">Contact Us</a>
  </ul>
  <ul id="footer_copyrights">
Copyright &copy; 2002 - <?php $today = date("Y"); echo $today;?>  Chumba Casino
  </ul>   
</div>
<?php if($dialogmsg != '') { ?>
	<div id="object" class="message warning"> 
      <img id="close_message" style="float:right;cursor:pointer; vertical-align:middle;"  src="images/msg/deactive.png" />
      &nbsp;&nbsp;<?php echo $dialogmsg; ?>
    </div>
<?php } ?>
<script type="text/javascript">
//Call dropdowncontent.init("anchorID", "positionString", glideduration, "revealBehavior") at the end of the page:
dropdowncontent.init("contentlink", "left-bottom", 100, "click");
<!--$(window).unload( function () { alert('<?php
		//session_start();
		//if(isset($_SESSION['username']))
		//{
			//echo $fusername = $_SESSION['username'];
			//$dbmaster->query("INSERT INTO `tracking` (`USERNAME`,`ACTION_NAME`,`DATE_TIME`,`SYSTEM_IP`,`STATUS`,`LOGIN_STATUS`) 
			//VALUE ('$fusername','logout',NOW(),'".$_SERVER['REMOTE_ADDR']."','1','3')"); // for tracking the logout session for user;
		//}
	?>'); } );-->
/*$(window).bind("beforeunload", function() { 
    confirm("Do you really want to close?"); 
})*/
</script>
<?php } ?>
<?php 
$dbslave->closecon();
$dbmaster->closecon();
if($con){mysql_close($con);} ?>
<?PHP ob_flush(); ?>
<?php include 'mfs_list.php'; ?>
<?php include 'fbads.php'; ?>
<div id="sess_pop" style="width:336px; height:276px; display: none;">
<img src="images/sesserror.gif" />
</div>
<?php include 'comunitypopup.php'; ?>
<?php if($compopup=="true"){ ?>
<link rel="stylesheet" href="css/nanoscroller.css">
<script type="text/javascript" src="js/jquery.nanoscroller.js"></script>
<?php } ?>
<?php if($_SESSION['NEW_USER'] != "") { ?>
<script language="javascript" type="text/javascript">
     var _sa1 = _sa1 || [];
     _sa1.push(['initialize', 'cfbbdc7d-8b3c-413c-be1d-bae9de6e89df']);

     (function () {
         var sa1 = document.createElement('script');
         sa1.type = 'text/javascript';
         sa1.async = true;
         sa1.src = '//admin.appnext.com/tki.js';
         var s = document.getElementsByTagName('script')[0];
         s.parentNode.insertBefore(sa1, s);
     })();
</script>
<?php } ?>
</body>
</html>
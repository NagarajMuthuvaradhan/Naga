<?php
//ini_set("session.save_path",dirname(__FILE__)."/");
header('P3P: CP="CAO PSA OUR"');
ob_start();
session_start();
require_once("dbs.php");
require_once( "classes/sessionclass.php" ); 
require_once( "classes/config.php" );
include("microgames/API/conf.php");

if(chumba_config("Site_underconstruction") == 1 && $_GET['test']!="test")
{
	header("location: error.php?p=m");	
}

$fpname = trim(str_replace("../","",$_REQUEST['pname']));
$fpname = trim(str_replace("..%2F","",$_REQUEST['pname']));

if(!$_SESSION['ccrm_fbuserid'] || ($fpname != 'gamehistory' || $fpname != 'age_verification_confirmation'|| $fpname != 'age_verification' || $fpname != 'myaccount' || curPageName() != 'paypal.php') ) {
	include("fb_login/fbmain.php");
}
include("validations.php");
$_SESSION['LOCALE_ID']="16";
//Is_Activated(); // SEssion check the user activation status

$log_chk = array('forgot_password','login','forgot_password_confirmation','registration_success','register','logout', 'index.php');

$lin_chk = array('subscription');

if($_REQUEST['pname']!="resend_email")
{
	if((!$fbuser && (!Is_Activated1() && !Is_Logged_In1())) && curPageName() == 'avatar.php') header("location: index.php");
}

//if( in_array($_REQUEST['pname'], $lin_chk ) && !isset($_SESSION['username']))
// header( "Location: ".url_rewrite('user','login'));

if($fbuser)
{
	//if( in_array($_REQUEST['pname'], $log_chk )) header( "Location: ".BASE_PATH."avatar.php?pa=1&off=33&pg=fb&id=".$fbuser );
}
else if(isset($_SESSION['username']))
{
	//if( in_array($_REQUEST['pname'], $log_chk )) header("location: ".BASE_PATH."avatar.php?pa=1");
	//if( in_array(curPageName(), $log_chk )) header("location: ".BASE_PATH."avatar.php?pa=1");
}

// get fb Ads

if($_SESSION['ccrm_userid'] != ""){

$fbadsShow = "false";
if($_GET['type'] == 'ads' && $_GET['ids'] != '') {
	$fbadsSql = "select *,  TIME_TO_SEC(TIMEDIFF(DATE_ADD(START_TIME, INTERVAL DURATION second), NOW())) AS remtime from fb_ads WHERE TYPE='ads' AND REF_CODE='".mysql_secure($_GET['ids'])."' order by FB_ADS_ID ASC LIMIT 1";
	$fadsRes = $dbslave->query($fbadsSql);
	if(mysql_num_rows($fadsRes) > 0) {
		$adsRow = mysql_fetch_assoc($fadsRes);
		//$_SESSION['ccrm_userid']
		if($adsRow['remtime'] > 0) {
			$userfbads=$dbslave->query("select * from user_fbads where FB_ADS_ID='".$adsRow['FB_ADS_ID']."' AND USER_ID='".$_SESSION['ccrm_userid']."'");
			$userfbadsres=mysql_num_rows($userfbads);
			if($userfbadsres>0){
			$fbexpire=1;
			$fbstring1 = "You already, Claim your free Sweepstakes tokens!";
			$fbstring2 = "";
			$fbexist=1;
			$fbadsShow = "false";
			}
			else{
			$fbstring1 = "Congratulations! You have won! Claim your ".$adsRow['AMOUNT']." free Sweepstakes tokens! ";
			$fbstring2 = "Get free Sweepstakes tokens for click claim button and sharing us on facebook ";
			$fbadsRes1=$dbslave->query("select * from fb_share where TYPE=7 AND SHARE_ITEMS_ID='".$adsRow['COIN_TYPE_ID']."'");
			$fbshareDet=mysql_fetch_assoc($fbadsRes1);
			$title=$fbshareDet['TITLE'];
			$heading=$fbshareDet['HEADING'];
			$description=str_replace("@REWARD@", number_format($adsRow['AMOUNT'], 0, '.', ','),$fbshareDet['DESCRIPTION']);
			$wallPic=$fbshareDet['IMG_URL'];
			$fbadsId=$adsRow['FB_ADS_ID']; //$_GET['ids'];
			$adsAmount=$adsRow['AMOUNT'];
			$coinTypeId=$adsRow['COIN_TYPE_ID'];
			$fbexpire=0;
			$fbexist=0;
			
			$fbadsres1 = mysql_fetch_assoc($dbslave->query("SELECT FIRSTNAME, LASTNAME FROM user WHERE USER_ID = '".$_SESSION['ccrm_userid']."' LIMIT 1"));
			$fbadsFname = $fbadsres1['FIRSTNAME'];
			$fbadsLname = $fbadsres1['LASTNAME'];
			$fbadsname="$fbadsFname $fbadsLname";
			$description=str_replace("@NAME@",$fbadsres1['FIRSTNAME'],$description);
			if(strlen($fbadsname) > 21)
				$fbadsname="$fbadsFname ".$fbadsLname[0];
				
			$fbadsShow = "true";
			}
			
		} else {
			$fbexpire=1;
			$fbexist=0;
			$fbstring1 = "Sorry! This link has expired! ";
			$fbstring2 = "";
			$fbadsShow = "true";
		}
	}

}

$fbsdayShow = "false";
if($_GET['type'] == 'sday' && $_GET['ids'] != '') {
	$fbadsSql = "select *,  TIME_TO_SEC(TIMEDIFF(DATE_ADD(START_TIME, INTERVAL DURATION second), NOW())) AS remtime from fb_ads WHERE TYPE='sday' AND REF_CODE='".mysql_secure($_GET['ids'])."' order by FB_ADS_ID ASC LIMIT 1";
	$fadsRes = $dbslave->query($fbadsSql);
	if(mysql_num_rows($fadsRes) > 0) {
		$adsRow = mysql_fetch_assoc($fadsRes);
		//$_SESSION['ccrm_userid']
		if($adsRow['remtime'] > 0 && $adsRow['remtime'] != NULL) {
			$userfbads=$dbslave->query("select * from user_fbads where FB_ADS_ID='".$adsRow['FB_ADS_ID']."' AND USER_ID='".$_SESSION['ccrm_userid']."'");
			$userfbadsres=mysql_num_rows($userfbads);
			if($userfbadsres>0){
				$fbexist=1;
				$fbsdayShow = "false";
				$vgid = 0;
			} else {
				//$dbslave->query("INSERT INTO `user_fbads` (`FB_ADS_ID`, `USER_ID`, `COIN_TYPE_ID`, `REWARDS`, `DATE_CREATED`) VALUES  ('".$adsRow['FB_ADS_ID']."','".$_SESSION['ccrm_userid']."', '1','".$adsRow['AMOUNT']."',NOW())");
				$vgid = $adsRow['AMOUNT'];
				$fbsdayShow = "true";
			}
			
		} else {
			$fbexpire=1;
			$fbexist=0;
			$vgid = 0;
			$fbsdayShow = "true";
			$fbadsShow = "true";
		}
	}

}

$fbofferShow = "false";
if($_GET['type'] == 'offers' && $_GET['ids'] != '') {
	$fbadsSql = "select *,  TIME_TO_SEC(TIMEDIFF(DATE_ADD(START_TIME, INTERVAL DURATION second), NOW())) AS remtime from fb_ads WHERE TYPE='offers' AND REF_CODE='".mysql_secure($_GET['ids'])."' order by FB_ADS_ID ASC LIMIT 1";
	$fadsRes = $dbslave->query($fbadsSql);
	if(mysql_num_rows($fadsRes) > 0) {
		$adsRow = mysql_fetch_assoc($fadsRes);
		//$_SESSION['ccrm_userid']
		if($adsRow['remtime'] > 0 && $adsRow['remtime'] != NULL) {
			/*$userfbads=$dbslave->query("select * from user_fbads where FB_ADS_ID='".$adsRow['FB_ADS_ID']."' AND USER_ID='".$_SESSION['ccrm_userid']."'");
			$userfbadsres=mysql_num_rows($userfbads);
			if($userfbadsres>0){
				$fbexist=1;
				$fbsdayShow = "false";
				$vgid = 0;
			} else {
				$fbsdayShow = "true";
			}*/
			$fbofferShow = "true";
		} else {
			$fbexpire=1;
			$fbexist=0;
			$vgid = 0;
			$fbofferShow = "false";
			$fbadsShow = "true";
		}
	}

}

	$compopup="false";
	$comsql=$dbslave->query("select * from community_popup where COM_STATUS=1");
	if(mysql_num_rows($comsql)>0){
		$comresult=mysql_fetch_assoc($comsql);
		$comid=$comresult['COMMUNITY_POPUP_ID'];
		$ucompop=$dbslave->query("select * from user_community_popup where POPUP_TYPE='COMPOP' AND COMMUNITY_POPUP_ID=$comid AND USER_ID=".$_SESSION['ccrm_userid']);
			if(mysql_num_rows($ucompop)>0){
			$compopup="false";
			}
			else{
			$comuserid=$_SESSION['ccrm_userid'];
			$compoptype="COMPOP";
			$incompopup="INSERT INTO user_community_popup (`USER_ID`,`COMMUNITY_POPUP_ID`,`POPUP_TYPE`) VALUE('$comuserid','$comid','$compoptype')";
			$dbmaster->query($incompopup);
			$comsqlres1 = $dbslave->query("SELECT FIRSTNAME FROM user WHERE USER_ID = '".$_SESSION['ccrm_userid']."'");
			$comusrdets = mysql_result($comsqlres1,0);
			$compophead="Hey $comusrdets";
			$pageDesc=$comresult['RELEASE_V_TEXT'];
			$comimage=$comresult['BANNER'];
			$compoptext="We made some exciting additions to the game. Don't miss out on learning about all the fun features we have added for you!";
			$compopup="true";
			}
	}
}

?>
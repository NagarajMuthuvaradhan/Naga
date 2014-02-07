<?php
header("Cache-Control: no-cache");
header("Pragma: no-cache");
header("Expires: Wed, 12 Dec 1990 12:12:12 GMT");
?>
<?php include 'includes/includes.php'; ?>
<?PHP
//if($_SESSION['ccrm_username'] == 'nagaraj2007@aim.com') 
//echo $_SESSION['SITE_LOC'];
//Cookie Checking
$extGame = 'false';
$cookId = 'ccrm_v24Dev';
if(isset($_COOKIE[$cookId]))
 {  	
 	//echo "Welcome back!";
	///exit;
 } 
 else 
 { 
	header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	$expire = time() + 60 * 60 * 24 * 1; // expires in one month
	setcookie($cookId,'yes',$expire,httpOnly);
 }
 
if($_SESSION['ccrm_userid']!="")
{
	if($_SESSION['ccrm_uastatus'] != 1)
	{  
		header("location: error.php?p=d");	
	}
	$userlogin_type=$_SESSION['USER_LOGIN_TYPE'];		
	
	if($_REQUEST['dev']!="") {
	$filename="chumbacasino_".str_replace('/','',$_REQUEST['dev'])."?v=".$cookId;
	}else { 
		$filename="chumbacasino"."?v=".$cookId;
	}
	
	if($userlogin_type == "REAL") {
		$reUrl = $url;
	} else {
		$reUrl = FB_APP_URL;
	}	
	
	if($_SESSION['SITE_LOC']=="APPS")
	{ 
		//$width="850";
		//$height="670";
		$width="760";
		$height="926";	
		//include("facebook_login/fcredits.php");
	}else
	{
		$width="760";
		$height="926";	
	}
	
	//Check user already exists or not Start----------------
	$query = $dbslave->query("select USER_ID from user_bonus where USER_ID='{$_SESSION['ccrm_userid']}' LIMIT 0,1");	
	$num=mysql_num_rows($query);
	if($num >0)
	{
		$usertype="old_user";
	}else
	{
		$usertype="new_user";		
	}
	
	//Check user already exists or not End----------------

	//Check user gender START----------------------
	/*$querygen =$dbslave->query("select GENDER from avatar_master where USER_ID='{$_SESSION['ccrm_userid']}' LIMIT 0,1");	
	$num=mysql_num_rows($querygen);
	if($num >0)
	{
		$res = mysql_fetch_row($querygen);
		$gendertype=$res[0];
	}else
	{
		$gendertype="1";		
	}*/
	//Check user gender END------------
	
	//Check user gender END----------------------
	$querygen =excuteQuery("select user.GENDER AS OGENDER,avatar_master.GENDER AS NGENDER, user.FIRSTNAME, user.LEVEL_CONFIG_ID from user LEFT JOIN avatar_master ON avatar_master.USER_ID=user.USER_ID where user.USER_ID='{$_SESSION['ccrm_userid']}' LIMIT 0,1");	
	$num=mysql_num_rows($querygen);
	if($num >0)
	{
		$res = mysql_fetch_row($querygen);
		$gendertype=$res[0];
		$usrLevel=$res[3];
		if($res[1] != NULL)
			$gendertype=$res[1];
		else if($res[0] == 'male') 
			$gendertype=1;
		else 
			$gendertype=2;
	} else {
		$usrLevel=1;
		$gendertype="2";		
	}
	//Check user gender START------------	
	$ulike=excuteQuery("select LIKE_COUNT from user_likeus where USER_ID='{$_SESSION['ccrm_userid']}'"); //Total User
	if(mysql_num_rows($ulike)>0)
	$ulikeReward=mysql_result($ulike,0);
	else
	$ulikeReward=0;	
	//$_SESSION['SITE_LOC']="APPS";
	//$comfname=$res[2];
}
?>
<?PHP
//Page Hits Start
if($_SESSION['ccrm_userid']!="")
{
	$user_id=$_SESSION['ccrm_userid'];
}
else
{
	$user_id="0";
}

$sqldata = $dbslave->query("SELECT count(*) FROM `page_hits` WHERE USER_ID='$user_id' AND DATE=date_format(NOW(),'%Y-%m-%d')");
$r=mysql_fetch_row($sqldata);
$rcnt=$r['0'];
if($rcnt == 0) {
	$hits_clicks = $dbmaster->query("INSERT INTO `page_hits` (`USER_ID`, `HITS_COUNT`, `PAGE_URL`, `DATE`) VALUES ('$user_id','1','http://chumba-casino.net/chumbacasino/',NOW())");
} else {
	$hits_clicks = $dbmaster->query("UPDATE `page_hits` SET `HITS_COUNT` = (`HITS_COUNT` + 1) WHERE USER_ID='$user_id' AND DATE=date_format(NOW(),'%Y-%m-%d')");
}
//Page Hits End
?>
<?php include 'includes/common.head.php'; ?>
<?php include 'fb_login/fbcheck.php'; ?>
<?php
/*echo "<pre>";
print_r($_SESSION);
echo "<pre>";*/
//&& $_SESSION['ccrm_fbuserid']==""
if($_SESSION['ccrm_userid']!="") {
	include 'avatar.php';	
} else {
	include 'home.php';	
}
?>

<?php include 'includes/footer.php'; ?>
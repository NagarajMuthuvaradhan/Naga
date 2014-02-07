<?php 
if($_SESSION['SITE_LOC']=="APPS") { ?> 
<link href="css/stylesheet.css?v=<?php echo $cookId; ?>" rel="stylesheet" type="text/css" />
<?php } else { ?>
<?PHP if(curPageName() != 'sitepages.php') { ?>
<base href="<?php echo BASE_PATH; ?>" />
<?PHP  } ?>
<!--<link href="css/style_landpage.css" rel="stylesheet" type="text/css" />-->
<?php } ?>
<link rel="stylesheet" href="font/stylesheet.css" type="text/css" charset="utf-8" />
<link type="text/css" rel="stylesheet" href="css/pagination.css" />
<link type="text/css" rel="stylesheet" href="css/jquery.selectBox.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/jquery_tinywatermark-3_1_0.js"></script>
<script type="text/javascript" src="js/jquery.watermarkinput.js"></script>
<script type="text/javascript" src="js/jquery.selectBox.js"></script>
<script type="text/javascript" src="js/dropdowncontent.js" ></script>
<script type="text/javascript" src="js/uservalidate.js"></script>

<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript" src="js/ajaxCall.js"></script>
<script type="text/javascript" src="js/ajax1.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>

<link rel="stylesheet" href="css/nanoscroller.css">
<script type="text/javascript" src="js/jquery.nanoscroller.js"></script>
<script type="text/javascript">
jQuery(function($){
 $(".nano").nanoScroller();
});
</script>
<?php if($_SESSION['SITE_LOC']!="APPS") { ?> 
<link rel="stylesheet" href="css/stylesheet1.css" type="text/css" charset="utf-8" />
<script type="text/javascript" src="js/balloontip.js"></script>
<script type="text/javascript">
$(function(){
  $("#NewsFeed_Hdr").click(function(){
    $(".NewsFeed").hide();
	$("#btn_news_deactive_tab").attr('id','btn_news_tab');
	$(".FriendsList").height("800px");
	$(".nano").height("661px");
	if(!$('.FriendsList').is(':visible')){
	$('#panel-list3').hide();
	}
  });
  $("#FriendsList_Hdr").click(function(){
    $(".FriendsList").hide();
	$("#btn_friends_deactive_tab").attr('id','btn_friends_tab');
    $(".NewsFeed").height("800px");
	$(".nano").height("746px");
	if(!$('.NewsFeed').is(':visible')){
	$('#panel-list3').hide();
	}
  });
});
$(function(){
$("#Toggle").click(function(){
if(!$('.NewsFeed').is(':visible') || !$('.FriendsList').is(':visible')){
	$("#togglepanel").show();
	$(".FriendsList").height("70px").show();
	$(".NewsFeed").height("370px").show();
	$('#panel-list3').show();
	$(".FriendsList .nano").height("290px");
	$(".NewsFeed .nano").height("340px");
	$("#btn_news_tab").attr('id','btn_news_deactive_tab');
	$("#btn_friends_tab").attr('id','btn_friends_deactive_tab');
}
else{
	$("#togglepanel").toggle();
	$(".FriendsList").height("354px").show();
	$(".NewsFeed").height("354px").show();
	$('#panel-list3').show();
	$(".FriendsList .nano").height("290px");
	$(".NewsFeed .nano").height("340px");
	$("#btn_news_tab").attr('id','btn_news_deactive_tab');
	$("#btn_friends_tab").attr('id','btn_friends_deactive_tab');
}
});
});

$(function(){
if($(".NewsFeed").show()){
$("#btn_news_tab").attr('id','btn_news_deactive_tab');
}
if($(".FriendsList").show()){
$("#btn_friends_tab").attr('id','btn_friends_deactive_tab');
}
});

function shownewslist(idr){
if(idr=="btn_news_tab"){
$('.NewsFeed').height('370px').show();
$('.FriendsList').height('370px');
$(".NewsFeed .nano").height("340px");
$(".FriendsList .nano").height("290px");
$("#btn_news_tab").attr('id','btn_news_deactive_tab');
return true;
}
else{
return false;
}
}

function showfrndlist(idr){
if(idr=="btn_friends_tab"){
$('.FriendsList').height('370px').show();
$('.NewsFeed').height('370px');
$(".NewsFeed .nano").height("340px");
$(".FriendsList .nano").height("290px");
$("#btn_friends_tab").attr('id','btn_friends_deactive_tab');
return true;
}
else{
return false;
}
}

</script>
<script type="text/javascript">
function insertnewsfeed(nwuserid,nwmsg,fn_ln){
$.ajax({
type: "POST",
url: "insertnews.php",
data: { userid: nwuserid , desc: nwmsg }
}).done(function( msg ) {
//alert( "Data Saved: " + msg );
});
}

function removefeed(userid,ids){
var idsval="#feed-"+ids;
$(idsval).hide();
$.ajax({
type: "POST",
url: "feed_tmp_removal.php",
data: { userid: userid , feed_id: ids }
}).done(function( msg ) {
//alert( "Data Saved: " + msg );
});
//$(idsval).hide();
}


var auto_refresh = setInterval(
function (){
//insertnewsfeed("193","testttttttttttt game");
$('.NewFeed_Cnt_Wrap').load('getnews.php').fadeIn("slow");
}, 10000); // refresh every 10000 milliseconds

</script>
<?php 
}
 ?>
<!-- External game loader --------> 
<script type="text/javascript">
function mgs_open_popup($link,$gpid,$ctype){
    //alert($link);
	obj = JSON.parse($link);
	if($gpid=="3"){
		//$link=$link+'&ctype='+$ctype;
		jQuery('#external-game-content').show();
		var demoUrl = "<?php echo BETSOFT_DEMOURL;?>&gameId="+obj.gameid+"&lang=en";
		var liveUrl = "<?php echo BETSOFT_URL;?>&gameId="+obj.gameid+"&mode=real&token="+trim(obj.authtoken)+"&lang=en";
		jQuery("#aDlink").attr('onClick', "mgs_open_popup('"+$link+"','"+$gpid+"','1')");
		jQuery("#aLlink").attr('onClick', "updatebgs(); mgs_open_popup('"+$link+"','"+$gpid+"','2')");
		if($ctype == 1) {
			jQuery('#reallink').show();
			jQuery('#demolink').hide();
			var playUrl = demoUrl;
		} else {
			jQuery('#demolink').show();
			jQuery('#reallink').hide();
			var playUrl = liveUrl;
		}
		//var eurl="http://"+obj.url+"microgames/index_pop.php?authtoken="+trim(obj.authtoken)+"&gameid="+obj.gameid+"&pid=3";
		//alert(eurl);
		jQuery('#external-game-content').find('iframe').remove();
		jQuery('#external-game-content').append('<iframe src="'+playUrl+'" width="760" height="550" id="inneriframe" scrolling="no" frameBorder="0"></iframe>');
	}
}
function showpopup(){
jQuery('#external-game-content').show();
//$("a").attr('onClick', "myfunction('parameter2a','parameter2b')");
jQuery('#external-game-content').find('iframe').remove();
jQuery('#external-game-content').append('<iframe src="http://lobby.chumba.discreetgaming.com/cwguestlogin.do?bankId=517&gameId=177&lang=en" width="760" height="550" id="inneriframe" scrolling="no" frameBorder="0"></iframe>');
}
function egamestatus(view){
	if(view == 'visible') {
		//jQuery('#external-game-content').show();
		jQuery('#external-game-content').css('visibility', 'visible');
		jQuery('#external-game-content').find('iframe').css({"height":"550", "width":"760", "border":"none"});
		
	} else if(view == 'invisible') {
		//jQuery('#external-game-content').hide();
		jQuery('#external-game-content').find('iframe').css({"height":"0", "width":"0", "border":"none"});
		jQuery('#external-game-content').css('visibility', 'hidden');
	} else { //close
		jQuery('#external-game-content').hide();
		jQuery('#external-game-content').find('iframe').remove();
		closeMGS(fb_swfname);
	}
}
function bsgdemo(urls,ids){

	   if(ids=="howtoplaylink"){
	   jQuery('#'+ids).hide();
	   jQuery('#demolink').show();
	   jQuery('#reallink').show();
           jQuery('#modetype1').text('How to play section');
           jQuery('#modetype2').text('');
	   }
           
	   if(ids=="demolink"){
	   jQuery('#'+ids).hide();
	   jQuery('#howtoplaylink').show();
	   jQuery('#reallink').show();
           jQuery('#modetype2').text('You are in practice mode');
	   }
           
	   if(ids=="reallink"){
	   jQuery('#'+ids).hide();
           jQuery('#modetype1').text('You are in real play mode');
	   jQuery('#howtoplaylink').show();
	   jQuery('#demolink').show();
	   }
          document.getElementById("ExtObject").src=urls;
}
</script>
<?PHP //if($_SESSION['SITE_LOC']!="APPS") { ?>
<!--Lightbox Scripts Start-->
<link href="css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.4"></script>

<script type="text/javascript">
//Friends list
var fbAllFriendsList = <?php echo json_encode($allFrd); ?>;
var fbInviteFriendsList = <?php echo json_encode($invtFrd); ?>;
var fbChumbaFriendsList = <?php echo json_encode($chumbaFrd); ?>;

var fbFriendsAll = new Array();
var fbFriendsChumba = new Array();
var fbFriends = new Array();
var fbFriendsAll_rem = new Array();
var fbFriendsChumba_rem = new Array();
var fbFriends_rem = new Array();
sendGiftObj=new Object();
var mfsSendReq = "";
var max_selected = 25;
var fbExcludeIds = "";
var max_selected_message = "{0} of {1} selected";

jQuery(document).ready(function($) {
	jQuery('.fancybox').fancybox($);
	
});
/*href : 'userpages_new.php?pname='+pagename,*/
function ageproofpopup(cvar) {
	egamestatus('invisible');
	var pagename = cvar;
	jQuery.fancybox.open({
		openEffect : 'elastic',
		closeEffect : 'elastic',
		fitToView: false,
		nextSpeed: 0, //important
		prevSpeed: 0, //important
		href : 'userpages_new.php?pname='+pagename+'&usrid=<?php echo $_SESSION['ccrm_userid']?>',
		type : 'iframe',
		padding : 5,
		beforeShow: function(){
			egamestatus('invisible');
			// added 50px to avoid scrollbars inside fancybox
			//this.width = (jQuery('.fancybox-iframe').contents().find('html').width())+1;
			//this.height = (jQuery('.fancybox-iframe').contents().find('html').height())+1;
                        if(pagename=='age_verification'){
                            this.width = 650;
                            this.height = 900;
                        }else if(pagename=='age_verification_confirmation'){
                            this.width = 480;
                            this.height = 270;
                        }else if(pagename=='forgotpin'){
                            this.width = 480;
                            this.height = 380;
                        }else{
                            this.width = 650;
                            this.height = 800;
                        }
		},
		afterClose: function(){
			egamestatus('visible');
		}
	});
}

function ageproofpopup1(cvar) {
	jQuery.colorbox({iframe:true, width:"650px", height:"850px", href:"userpages_new.php?pname=age_verification&usrid=<?php echo $_SESSION['ccrm_userid']?>"});
}

function ccrminvite_popup() {
	jQuery.fancybox.open({
		openEffect : 'elastic',
		closeEffect : 'elastic',
		fitToView: false,
		nextSpeed: 0, //important
		prevSpeed: 0, //important
		href : 'Email-Input.php',
		type : 'iframe',
		padding : 5,
		beforeShow: function(){
			// added 50px to avoid scrollbars inside fancybox
			this.width = (jQuery('.fancybox-iframe').contents().find('html').width())+1;
			this.height = (jQuery('.fancybox-iframe').contents().find('html').height())+1;
		}
	});
}

function newSendGift1(obj) {
	//document.getElementById('linkInvite').click();
	var productsJSON = JSON.stringify(obj);
	//alert(productsJSON);
	jQuery.fancybox.open({
		openEffect : 'elastic',
		closeEffect : 'elastic',
		fitToView: false,
		nextSpeed: 0, //important
		prevSpeed: 0, //important
		href : 'mfs_list.php?arr='+productsJSON,
		type : 'iframe',
		padding : 5,
		beforeShow: function(){
			// added 50px to avoid scrollbars inside fancybox
			this.width = (jQuery('.fancybox-iframe').contents().find('html').width())+1;
			this.height = (jQuery('.fancybox-iframe').contents().find('html').height())+1;
		}
	});
}
function changetheme(type) {
	if(type == 'sendgift') {
		jQuery("#mfsTheme").attr('class', 'MFS_gift_Wrap');
		jQuery("#popTop").attr('class', 'MFS_getItem_PopTop');	
		jQuery("#inAllFrd").attr('class', 'afriends current');
		jQuery("#inAllFrd").attr("onClick","test('all')");	
		jQuery("#appFr").show();	
		jQuery("#mfsUsrCnt").show();		
		jQuery("#mfsDesc").show();		
		jQuery("#srchTop").attr('class', 'MFS_MailIDWrap');	
	} else if(type == 'getitems') {
		jQuery("#mfsTheme").attr('class', 'MFS_getItem_Wrap');
		jQuery("#popTop").attr('class', 'MFS_getItem_PopTop');	
		jQuery("#inAllFrd").attr('class', 'afriends current');
		jQuery("#inAllFrd").attr("onClick","test('all')");		
		jQuery("#appFr").show();		
		jQuery("#mfsUsrCnt").hide();		
		jQuery("#mfsDesc").show();		
		jQuery("#srchTop").attr('class', 'MFS_MailIDWrap');	
	} else if(type == 'invite') {
		jQuery("#mfsTheme").attr('class', 'MFS_Invite_Wrap');
		jQuery("#popTop").attr('class', 'MFS_inviteFriend_PopTop');	
		jQuery("#inAllFrd").attr('class', 'orgafriends current');
		jQuery("#inAllFrd").attr("onClick","test('recommend')");		
		jQuery("#appFr").hide();		
		jQuery("#mfsUsrCnt").hide();		
		jQuery("#mfsDesc").hide();	
		jQuery("#srchTop").attr('class', 'MFS_MailID_InviteWrap');	
	}
}
function newSendGift(obj) {
//alert('test');
console.log(obj);
	if(obj.fbId != 0 && obj.fbId > 0) {
		oneFB = obj.fbId;
		newSendGiftMFS(obj,oneFB);
		return true;
	}
	mfsFriendsList(obj);
}
function newSendGift123(obj) {
	//document.getElementById('linkInvite').click();
	//var productsJSON = JSON.stringify(obj);
	//alert(obj.userlevel);
			var dataArray = new Array;
			for(var o in obj) {
				//alert(o);
				dataArray.push(obj[o]);
				console.log(o + ": " + obj[o]);
			}
			for(i=0; i<dataArray.length; i++) {
				//alert(dataArray[i]);
			}
			//alert(dataArray);
			//console.log("IDS : " + obj.request_ids);
			
	if(obj.fbId != 0 && obj.fbId > 0) {
		oneFB = obj.fbId;
		newSendGiftMFS(obj,oneFB);
		return true;
	}
	
	sendGiftObj = obj;
	fbGiftType = obj.type;
	var totvg = 0;
	var oneFB = "";
	var gText = "";
	if(fbGiftType == 'GIFT_HOME') {
		fbGift = obj.vgid;
		fbExIds = obj.exIds;
		fbFrndPday = parseInt(obj.totcnt - obj.cnt);
/*		if(obj.vgcnt > 0 && obj.vgcnt <= fbFrndPday) {
			fbFrndPday = obj.vgcnt;
		}
		if(parseInt(obj.vgcnt) != 'NaN' && parseInt(obj.vgcnt) > 0) {
			totvg = parseInt(obj.vgcnt);
		}
*/		gText = "Free Virtual Goods";
		//fbPubImg = obj.url;
	} 
	else if(fbGiftType == 'GIFT_AVATAR') {
		fbGift = obj.vgid;
		fbExIds = obj.exIds;
		fbFrndPday = parseInt(obj.totcnt - obj.cnt);
/*		if(obj.vgcnt > 0 && obj.vgcnt <= fbFrndPday) {
			fbFrndPday = obj.vgcnt;
		}
		if(parseInt(obj.vgcnt) != 'NaN' && parseInt(obj.vgcnt) > 0) {
			totvg = parseInt(obj.vgcnt);
		}
*/		gText = "Free Avatar Items";
		//fbPubImg = obj.url;
	} 
	else if(fbGiftType == 'SWTOKEN') {	
		fbGift = obj.giftCoins;
		var usrTot = parseInt(obj.tokenCount / fbGift);
		fbFrndPday = parseInt(obj.totcnt - obj.cnt);
		if(usrTot < fbFrndPday) {
			fbFrndPday	= usrTot;
		}
		gText = fbGift + " Free Sweepstakes Tokens";
		fbExIds = obj.exIds;
	} else {
		fbGift = obj.giftItem;	
		fbFrndPday = (obj.totcnt - obj.cnt);
		fbExIds = obj.exIds;
		gText = "";
	}
	fbPubImg = obj.url;	
//		alert(fbPubImg);
	//fbExIds = '';
	//fbFrndPday = obj.totcnt;
	//fbExcludeIds = '';
	max_selected = fbFrndPday;
	fbExcludeIds = obj.exIds;
	
	//fbExcludeIds = fbExIds;
	var fbGImg = obj.url;
	changetheme('sendgift');
	mfsSendReq = 'sendgift';
	test('all');
	document.getElementById('toSend').innerHTML=max_selected;
	var onemulti = 'gift';
	if(max_selected > 1)
		onemulti = 'gifts';
		
	var sask = 'sent';
	document.getElementById('oneMulti').innerHTML=onemulti;
	document.getElementById('oneAsk').innerHTML=sask;
	
	//document.getElementById('giftName').innerHTML=gText;
	//document.getElementById('gImg').innerHTML='<img src="'+fbGImg+'" width="93" height="100" />';
	jQuery.fancybox.open({
		'width' : '720',
		'height' : '545',
		'autoScale' : false,
		'href' : '#inline1',
		'transitionIn' : 'none',
		'transitionOut' : 'none',
		helpers : {
		overlay : true
		}
	});
}


function newInvite() {
var gametype="<?php echo $_SESSION['USER_LOGIN_TYPE'];?>";
//alert(gametype);
mfsSendReq = 'invite';

if(gametype=="REAL"){
ccrminvite_popup();
}
else{
	max_selected = 25;
	changetheme('invite');
	test('recommend');
	
	jQuery.fancybox.open({
		'width' : '720',
		'height' : '545',
		'autoScale' : false,
		'href' : '#inline1',
		'transitionIn' : 'none',
		'transitionOut' : 'none',
		beforeShow: function(){
			egamestatus('invisible');
		},
		afterClose: function(){
			egamestatus('visible');
		}
	});
}	
}

function newGetItems(obj) {
	
	sendGiftObj = obj;
	fbGiftType = obj.type;
	
	fbGift = obj.giftItem;	
	fbFrndPday = (obj.totcnt - obj.cnt);
	//fbExIds = obj.exIds;
	//fbExcludeIds = obj.exIds;
	
	fbExIds = '';
	fbExcludeIds = '';
	
	mfsSendReq = 'getitems';
	max_selected = fbFrndPday;
	changetheme('getitems');
	test('all');

	if(fbGiftType == 'MINIGAME_BONUS')
		var	sask = 'asked';
	document.getElementById('oneAsk').innerHTML=sask;
	
	jQuery.fancybox.open({
		'width' : '720',
		'height' : '545',
		'autoScale' : false,
		'href' : '#inline1',
		'transitionIn' : 'none',
		'transitionOut' : 'none'
	});
}

function newSendGift123() {
	
	jQuery.fancybox.open({
		'width' : '720',
		'height' : '540',
		'autoScale' : false,
		'href' : '#inline1',
		'transitionIn' : 'none',
		'transitionOut' : 'none'
	});
}

jQuery(document).ready(function($) {
	$("a.fancybox").fancybox({
		openEffect : 'elastic',
		closeEffect : 'elastic',
		fitToView: false,
		nextSpeed: 0, //important
		prevSpeed: 0, //important
		beforeShow: function(){
			// added 50px to avoid scrollbars inside fancybox
			this.width = (jQuery('.fancybox-iframe').contents().find('html').width())+1;
			this.height = (jQuery('.fancybox-iframe').contents().find('html').height())+1;
		}
	}); // fancybox
}); // ready

function fbadspopshow(){
	jQuery.fancybox.open({
		'width' : '640',
		'height' : '400',
		'autoScale' : false,
		'href' : '#popup_box',
		'transitionIn' : 'none',
		'transitionOut' : 'none'
	});
}

function session_Expired(){
	jQuery.fancybox.open({
		'width' : '350',
		'height' : '300',
		'autoScale' : false,
		'href' : '#sess_pop',
		'transitionIn' : 'none',
		'transitionOut' : 'none'
	});
}
</script>
<?php //if($compopup=="true"){ ?>
<script type="text/javascript">
function compopupshow(){
jQuery(document).ready(function($){
	jQuery.fancybox.open({
		'width' : '550',
		'height' : '650',
		'autoScale' : false,
		'href' : '#compopup_box',
		'transitionIn' : 'none',
		'transitionOut' : 'none'
	});
});
}
</script>
<?php //} ?>

<!--Lightbox Scripts End-->
<?php //} ?>

<!--Facebook Scripts-->
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script> 
<script type="text/javascript" src="js/fbscript.js"></script>
<script type="text/javascript">
var fbInviteExids = "<?php if($fidAll !="") echo str_replace('~',',',$fidAll); ?>";
var fb_swfname = "<?php echo $filename; ?>";
var fb_siteurl = "<?php echo SITE_URL; ?>";
<?php if($_SESSION['SITE_LOC']=="LOCAL") { ?> 
var fb_appurl = "<?php echo $url; ?>";
<?php } else { ?>
var fb_appurl = "<?php echo FB_APP_URL; ?>";
<?php } ?>
var site_loc = "<?php echo $_SESSION['SITE_LOC']; ?>";

var fbRandFriends = new Array();
</script>
<?php if($_SESSION['SITE_LOC']=="APPS") { ?> 

<script type="text/javascript" src="js/prototype.js" charset="utf-8"></script>
<script type="text/javascript" src="js/scriptaculous.js" charset="utf-8"></script>
<script type="text/javascript" src="js/modalbox.js"></script>
<link type="text/css" rel="stylesheet" href="css/modalbox.css"  />

<script type="text/javascript">
function myFriends(str) {

	var invtrandfrd = jQuery.parseJSON( '<?php echo json_encode($randMyfriends); ?>' );
	//console.log(invtrandfrd);
	fbRandomFriends('<?php echo $filename; ?>', invtrandfrd,str);
}
function fbOpenWin(lvl) {
	var vreward = <?php echo $ulikeReward; ?>;
	FB.api('me/likes/364772296942114', function (response) {
		if (!response || response.error) {
			if(lvl > 3)
				document.getElementById('fblikeBox').style.display='block';
			else
				document.getElementById('fblikeBox_3').style.display='block';
				
			document.getElementById('fadeLike').style.display='block';
			//alert('Error occured');
		} else if (response.data.length === 0) {
			if(lvl > 3)
				document.getElementById('fblikeBox').style.display='block';
			else
				document.getElementById('fblikeBox_3').style.display='block';
				
			document.getElementById('fadeLike').style.display='block';
			// user likes the page
			//alert('Unlikes page');
		} else if (response.data.length === 1) {
			//alert(response.data.length+' - '+vreward);
			 if(vreward == 0) {
				fbLikeRewards('<?php echo $filename; ?>');
			}
			// user likes the page
		}
	});
	return false;
}
function fbCloseWin() {
	document.getElementById('fadeLike').style.display='none';
	document.getElementById('fblikeBox').style.display='none';
	document.getElementById('fblikeBox_3').style.display='none';
	return false;
}
</script>
<?php } ?>

<script type="text/JavaScript">
	jQuery(function ($) {
		jQuery('.watermarked').watermark('watermark');
	});
</script>
<script type="text/javascript">
//  Developed by Roshan Bhattarai 
//  Visit http://roshanbh.com.np for this script and more.
//  This notice MUST stay intact for legal use
jQuery(document).ready(function()
{
	//first slide down and blink the alert box
    jQuery("#object").animate({ 
        top: "0px"
      }, 2000 ).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
   
   //close the message box when the cross image is clicked 
   jQuery("#close_message").click(function()
	{
	   jQuery("#object").fadeOut("slow");
	});
	
	setTimeout(function() {
		jQuery('#object').fadeOut(2000);
	 },5500);
});
</script>
<?PHP 
if($trackcnt=='1'){
?>
	<script type="text/javascript">
    (function() {var p = function(x) {var q=[],s=(x!=null)?x.toString():'';if(window.RegExp)
    s.replace(new RegExp("(sb_[^?=&]+|__sb_[^?=&]+)(=([^&]*))?", "g"),function($0,$1,$2,$3){ q.push($1+'='+$3); }); 
    else q=['sb_err=NoRegExp'];var i=s.indexOf('?');s=(i>0)?s.substr(0,i+1)+q.join('&'):s;return(escape(s));};
    var l=[p(window.location),p(document.referrer)];var u=(document.location.protocol)+"//track.brighteroption.com/b?p=sx2rmy&l=0"+
    "&src="+l[0]+"&sref="+l[1]+"&rnd="+(Math.random()*(1 << 30)).toString(16).replace('.', '');
    var px=document.createElement('iframe');px.src=u;px.width=0;px.height=0;px.setAttribute('frameborder',0);
    px.setAttribute('marginheight',0);px.setAttribute('marginwidth',0);px.setAttribute('scrolling','no');document.body.appendChild(px);})();
    </script>
    
    <script type="text/javascript">
    (function() {var p = function(x) {var q=[],s=(x!=null)?x.toString():'';if(window.RegExp)
    s.replace(new RegExp("(sb_[^?=&]+|__sb_[^?=&]+)(=([^&]*))?", "g"),function($0,$1,$2,$3){ q.push($1+'='+$3); }); 
    else q=['sb_err=NoRegExp'];var i=s.indexOf('?');s=(i>0)?s.substr(0,i+1)+q.join('&'):s;return(escape(s));};
    var l=[p(window.location),p(document.referrer)];var u=(document.location.protocol)+"//track.brighteroption.com/b?p=sx2rmy&l=3"+
    "&src="+l[0]+"&sref="+l[1]+"&rnd="+(Math.random()*(1 << 30)).toString(16).replace('.', '');
    var px=document.createElement('iframe');px.src=u;px.width=0;px.height=0;px.setAttribute('frameborder',0);
    px.setAttribute('marginheight',0);px.setAttribute('marginwidth',0);px.setAttribute('scrolling','no');document.body.appendChild(px);})();
    </script>

	
<?PHP }else if($trackcnt=='2') { ?>

	<script type="text/javascript">
    (function() {var p = function(x) {var q=[],s=(x!=null)?x.toString():'';if(window.RegExp)
    s.replace(new RegExp("(sb_[^?=&]+|__sb_[^?=&]+)(=([^&]*))?", "g"),function($0,$1,$2,$3){ q.push($1+'='+$3); }); 
    else q=['sb_err=NoRegExp'];var i=s.indexOf('?');s=(i>0)?s.substr(0,i+1)+q.join('&'):s;return(escape(s));};
    var l=[p(window.location),p(document.referrer)];var u=(document.location.protocol)+"//track.brighteroption.com/b?p=sx2rmy&l=4"+
    "&src="+l[0]+"&sref="+l[1]+"&rnd="+(Math.random()*(1 << 30)).toString(16).replace('.', '');
    var px=document.createElement('iframe');px.src=u;px.width=0;px.height=0;px.setAttribute('frameborder',0);
    px.setAttribute('marginheight',0);px.setAttribute('marginwidth',0);px.setAttribute('scrolling','no');document.body.appendChild(px);})();
    </script>

<?PHP } ?>
<style type="text/css">
form.frmpro label.error, label.error {
	display: block;
	left:0px; 
	/*font-family: 'CaeciliaLTStd75Bold', Arial, sans-serif; font-size:12px; color: #f50000; text-decoration: none;
	font-weight:normal !important;*/
	/* remove the next line when you have trouble in IE6 with labels in list */
}
div.error { display: none; }
input.error { border: 1px dotted red; }
.watermark {font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif;	color: #808080 !important;}
.watermark2 {font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif;color: #808080 !important;font-style: italic !important;}
.watermark3 {font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif;color: #c77 !important;}
.watermark_ot {font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif !important;}
/*img { border:none; }*/
.info, .success, .warning, .error_msg, .validation {border: 1px solid;margin: 10px 0px;padding:10px 10px 10px 50px;background-repeat: no-repeat;background-position: 10px center;}
.info {color: #00529B;background-color: #BDE5F8;background-image: url('images/msg/info.png');}
.success {color: #4F8A10;background-color: #DFF2BF;background-image:url('images/msg/success.png');}
.warning {color: #9F6000;background-color: #FEEFB3;background-image: url('images/msg/warning.png');}
.error_msg {color: #D8000C;background-color: #FFBABA;background-image: url('images/msg/error.png');}
.message { 
   position: absolute;
   margin-top:350px;
   font-weight:bold; 
   top: 30px; left: 300px; 
   z-index: 10000; 
   /*background:#ffc;
   padding:5px;
   border:1px solid #CCCCCC;
   text-align:center; 
   font-weight:bold; */
   width:50%;
  }
</style>
<script type="text/javascript">
function openTermAndCond(pth){
if(pth=="REAL"){
var url="<?php echo SITE_URL; ?>sitepages.php?pname=6";
window.open(url, '_blank');
window.focus();
}
else{
var url="<?php echo SITE_URL; ?>pages.php?pid=6";
buyClose('<?php echo $filename; ?>','btn_game'); Modalbox.show1(url, {title: false, height: 800 }); return false;
}
}
</script>
<script type="text/javascript" src="js/mgs.js"></script>
<script type="text/javascript">
function listText(menuid)
{
	// Get the UL
	/*var ul = document.getElementById("main_menu");
	// Get the LI in the UL
	var liNodes = ul.getElementsByTagName("li");
	// Iterate through the LI's
	for( var i = 0; i < liNodes.length; i++ )
	{
		liNodes.item(i).id = liNodes.item(i).id.replace('Active', '');
	
	}
	document.getElementById(menuid).id=document.getElementById(menuid).id+"Active";*/
} 
$(function() {
    $('form,input,select,button').attr('autocomplete', 'off');
});
</script>

<?php if($_SESSION['ccrm_userid'] != "") { ?>
<script type="text/javascript">
var sess_interval = setInterval ( makeRequest, 5000 );
function makeRequest(){
    console.log("Getting tweets...");
    jQuery.ajax({
        url: "sess_check.php?user_id=<?php echo $_SESSION['ccrm_userid']; ?>",
        success: function(data){
            console.log(data);
			if(data == 'Session false') {
				session_Expired();
				clearInterval(sess_interval);
      			sess_interval = null
			}
        }
    });
}


</script>
<?php } ?>
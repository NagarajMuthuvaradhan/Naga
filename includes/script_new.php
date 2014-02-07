<?php 
if($_SESSION['SITE_LOC']=="APPS") { ?> 
<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<?php } else { ?>
	<?PHP if(curPageName() != 'sitepages.php') { ?>
    <base href="<?php echo BASE_PATH; ?>" />
    <?PHP  } ?>
	<link href="css/style_landpage.css" rel="stylesheet" type="text/css" />
   <!-- <link href="css/stylesheet.css" rel="stylesheet" type="text/css" />-->
	<!--<link rel="stylesheet" href="css/nanoscroller.css">
    <link rel="stylesheet" href="font/stylesheet.css" type="text/css" charset="utf-8" /> -->
<?php } ?>
<?php if($_SESSION['SITE_LOC']=="APPS") { ?>
<link rel="stylesheet" href="font/stylesheet.css" type="text/css" charset="utf-8" />
<?php } ?>
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
<script type="text/javascript" src="js/AC_RunActiveContent.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="js/jquery.nanoscroller.js"></script>
<script type="text/javascript" src="js/splitter.js"></script>

<?php if($_SESSION['SITE_LOC']!="APPS") { ?>
<!--<link rel="stylesheet" href="font/stylesheet1.css" type="text/css" charset="utf-8" />
<script type="text/javascript" src="js/balloontip.js"></script>
<script type="text/javascript" src="js/jquery.nanoscroller.js"></script>
<script type="text/javascript">
jQuery(function($){
 $(".nano").nanoScroller();
});
</script>
<script type="text/javascript">
$(function(){
  $("#NewsFeed_Hdr").click(function(){
    $(".NewsFeed").hide();
	$("#btn_news_deactive_tab").attr('id','btn_news_tab');
	$(".FriendsList").height("800px");
	$(".nano").height("746px");
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
	$(".FriendsList .nano").height("370px");
	$(".NewsFeed .nano").height("340px");
	$("#btn_news_tab").attr('id','btn_news_deactive_tab');
	$("#btn_friends_tab").attr('id','btn_friends_deactive_tab');
}
else{
	$("#togglepanel").toggle();
	$(".FriendsList").height("354px").show();
	$(".NewsFeed").height("354px").show();
	$('#panel-list3').show();
	$(".FriendsList .nano").height("370px");
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
$(".FriendsList .nano").height("370px");
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
$(".FriendsList .nano").height("370px");
$("#btn_friends_tab").attr('id','btn_friends_deactive_tab');
return true;
}
else{
return false;
}
}
</script>
-->
<?php } ?>


<?PHP //if($_SESSION['SITE_LOC']!="APPS") { ?>
<!--Lightbox Scripts Start-->
<link href="css/jquery.fancybox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.mousewheel-3.0.6.pack.js"></script>
<script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.4"></script>

<script type="text/javascript">
//Friends list
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

function ageproofpopup(cvar) {
	var pagename = cvar;
	jQuery.fancybox.open({
		openEffect : 'elastic',
		closeEffect : 'elastic',
		fitToView: false,
		nextSpeed: 0, //important
		prevSpeed: 0, //important
		href : 'userpages.php?pname='+pagename,
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
	mfsSendReq = 'invite';
	max_selected = 25;
	changetheme('invite');
	test('recommend');
	
	jQuery.fancybox.open({
		'width' : '720',
		'height' : '545',
		'autoScale' : false,
		'href' : '#inline1',
		'transitionIn' : 'none',
		'transitionOut' : 'none'
	});
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
	//alert('tester');
	//return false;
	jQuery.fancybox.open({
		'width' : '595',
		'height' : '391',
		'autoScale' : false,
		'href' : '#popup_box',
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
		'width' : '460',
		'height' : '240',
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

FB.api(
  {
    method: 'fql.query',
    query: 'SELECT uid, name, pic_square FROM user WHERE has_added_app!=1 AND uid IN (SELECT uid2 FROM friend WHERE uid1 = me() order by rand() limit 10)'
  },
  function(response) {
	  var fDet="";
	  var fbRandFriends = new Array();
	  for( var i = 0 ; i < response.length ; i++ ) {
		  
  		fDet = response[i].uid+"~"+response[i].name+"~"+response[i].pic_square;
		fbRandFriends.push(fDet);
	  }
	  fbRandomFriends('<?php echo $filename; ?>', fbRandFriends,str);
	  //return fbRandFriends;
  }
);
}
function fbOpenWin() {
	var vreward = <?php echo $ulikeReward; ?>;
	FB.api('me/likes/364772296942114', function (response) {
		if (!response || response.error) {
			document.getElementById('fadeLike').style.display='block';
			document.getElementById('fblikeBox').style.display='block';
			//alert('Error occured');
		} else if (response.data.length === 0) {
			document.getElementById('fadeLike').style.display='block';
			document.getElementById('fblikeBox').style.display='block';
			// user likes the page
			//alert('Unlikes page');
		} else if (response.data.length === 1) {
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

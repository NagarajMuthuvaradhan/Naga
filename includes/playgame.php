<?php
if(isset($_GET['egame']) && $_GET['egame'] == 'true') { $extGame = 'true';	$security = 'true'; } else { $security = 'false';}
if(isset($_GET['localeNow']) && $_GET['localeNow'] != "") $localeNow = $_GET['locale']; else $localeNow = "en";
if($_SERVER['HTTP_HOST'] == 'www.chumba-casino.net') $isLive = 'YES'; else  $isLive = 'NO';
?>
<div id="<?php echo $filename; ?>">
	<script type="text/javascript">
                    //wmode=opaque
                    var params = {}; 
                    params.wmode = "opaque";
                    params.menu = "false";
                    params.allowfullscreen="true";
                    params.bgcolor="#02061C";
                    params.scale = "noscale";
                    params.salign = "";
					params.align = "middle";
                    var flashvars = {user_id:'<?php echo $_SESSION['ccrm_userid']; ?>',username:'<?php echo $_SESSION['ccrm_username']; ?>',usertype:'<?php echo $usertype; ?>',gender:'<?php echo $gendertype; ?>',url:'<?php echo $url; ?>',gateway:'<?php echo $gateway; ?>',sfsip:'<?php echo $sfsip; ?>',sfsport:'<?php echo $sfsport; ?>',userlogin_type:'<?php echo $userlogin_type; ?>',locale:'<?php echo $localeNow; ?>',todaybonus:'<?php echo $todaybonus; ?>',appURL:'<?php echo $reUrl; ?>',blueport:'<?php echo $sfsblueport; ?>',release_version:'<?php echo $cookId; ?>',islive:'<?php echo $isLive; ?>',fbads:'<?php echo $fbadsShow; ?>',compopup:'<?php echo $compopup?>',splday:'<?php echo $vgid; ?>',buymoredbl:'<?php echo $fbofferShow; ?>',directgamelink:'<?php echo $_REQUEST['id'];?>',directlid:'<?php echo $_REQUEST['lid'];?>',shareid:'<?php echo $_REQUEST['postreqid'];?>',externalgame:'<?php echo $extGame;?>',security:'<?php echo $security;?>'}; 
                    swfobject.embedSWF("<?php echo $filename1; ?>", "<?php echo $filename; ?>", "100%", "926", "9.0", null, flashvars, params, {name:"<?php echo $filename; ?>"});
	        </script> 
</div>

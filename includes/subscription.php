<div id="Common_Cnt_hdr_txt">
  Become a VIP!
</div>
<div id="VIP_wrap">
<div id="VIP_top"></div>
<div id="VIP_midbg">
<div id="VIP_midCnt">
<div id="vip_hdrTxt"><h13>VIP membership entitles you to:</h13></div>
<div id="vip_Shdr"><h14>- Enter VIP-only levels and attend exclusive in-game events</h14></div>
<div id="vip_Shdr"><h14>- Purchase unique items at discounted prices</h14></div>
<div id="vip_Shdr"><h14>- Embark on special quests for fabulous rewards</h14></div>
<div id="vip_Shdr"><h14>- Many more!</h14></div>
<div id="vip_subscription_wrap"> 
<form name="subfrm" id="subfrm" method="post" action="payment.php">
<?PHP 
$k=0; $j=1;
$query=$dbmaster->query("select premium_membership.*, locale_content.LOCALE_VALUE from premium_membership LEFT JOIN locale_content ON locale_content.LOCALE_KEY=premium_membership.DEAL_TYPES where ITEM_TYPE='VIP' AND  LOCALE_ID='16' AND PRICE > 0 AND LOCALE_VALUE!='Normal' and LOCALE_VALUE!='Promo' and STATUS='1'");
$num_row = mysql_num_rows($query);
while($row=mysql_fetch_array($query))
{	
	@extract($row);
	?>
<button value="<?PHP echo $PRICE."/".$MEMBERSHIP_ID; ?>" class="SubcPlan" name="subdetails" id="subdetails" type="submit">
<span class="Month"><?PHP echo $LOCALE_VALUE; ?></span>
<span class="Fees">$<?PHP echo $PRICE; ?></span>
</button>
<?php } ?>
</form>
</div>
</div>
</div>
<div id="VIP_bottom"></div>
<div id="vip_buynow"></div>
<div id="vip_girl"></div>
<div id="vip_Remind_wrap">
<button value="submit" class="Remind" type="button" onclick="window.location='<?php echo BASE_PATH.'index.php'; ?>';"></button>
</div>
</div>

<?php 
if(isset($_POST['Save'])){
//echo '<pre>';
//print_r($_POST);
//echo '</pre>';
//exit;

/*Array
(
    [upmid] = > 1
	[fname] => kamatchi
    [lname] => selvam
    [crdno] => 371383108036006 
    [cvvcvs] => 6419
    [Expmon] => 09
    [Expyear] => 2013
    [address1] => sdasd
    [address2] => asdasd
    [city] => chennai
    [state] => TN
    [zipcode] => 600017
    [Save] => Save
)
*/

@extract($_POST);
$fstname=addslashes($fname);
$lstname=addslashes($lname);
$addr1=addslashes($address1);
$addr2=addslashes($address2);
$expiration=$Expyear."-".$Expmon."-01";
$expdate=date('Y-m-t',strtotime($expiration));
$city=addslashes($city);
$state=addslashes($state);
//USER_PAYMENT_METHOD_ID, FIRST_NAME, LAST_NAME, CARD_NUMBER, CVC_CVS, EXP_DATE, ADDRESS1, ADDRESS2, CITY, STATE, ZIPCODE, USER_ID, PM_USE_STATUS, CREATED_DATE, UPDATED_DATE
$userId=$_SESSION['ccrm_userid']!=""?$_SESSION['ccrm_userid']:0;
$_SESSION['crdno']=$crdno;
$sqlres=$dbslave->query("select * from user_payment_method where CARD_NUMBER=$crdno and USER_ID=$userId");
if($upmid=="" && mysql_num_rows($sqlres)>0){
header("Location: ".url_rewrite2('user','paymentmethod','err=3'));
exit;
}
else{
if($upmid!=""){
$sql="UPDATE user_payment_method SET FIRST_NAME='$fstname', LAST_NAME='$lstname', CARD_NUMBER='$crdno', CVC_CVS='$cvvcvs', EXP_DATE='$expdate', ADDRESS1='$addr1', ADDRESS2='$addr2', CITY='$city', STATE='$state', ZIPCODE='$zipcode', PM_USE_STATUS='0', CREATED_DATE=NOW() where USER_ID='$userId' AND USER_PAYMENT_METHOD_ID=$upmid";
}
else{
$sql="INSERT INTO user_payment_method(FIRST_NAME, LAST_NAME, CARD_NUMBER, CVC_CVS, EXP_DATE, ADDRESS1, ADDRESS2, CITY, STATE, ZIPCODE, USER_ID, PM_USE_STATUS, CREATED_DATE) VALUES ('$fstname','$lstname','$crdno','$cvvcvs','$expdate','$addr1','$addr2','$city','$state','$zipcode','$userId','0',NOW())";
}
}
if($dbmaster->query($sql)){
header("Location: ".url_rewrite2('user','paymentmethod','err=1'));
exit;
}
else{
header("Location: ".url_rewrite2('user','paymentmethod','err=2'));
exit;
}
}
?>
<script type="text/javascript" src="js/jquery.creditCardValidator.js"></script>
<script type="text/javascript">
$(document).ready(function() {
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

    $("input:text, input:password").each(function() {
        if (this.value == '') {
            this.value = this.title;
        }
    });
	
	$("#fname").Watermark("First Name");
	$("#lname").Watermark("Last Name");
	$("#crdno").Watermark("Card Number");
	$("#cvvcvs").Watermark("CVC or CVS");
	$("#address1").Watermark("Address Line 1");
	$("#address2").Watermark("Address Line 2");
	$("#city").Watermark("City");
	$("#state").Watermark("State/Province");
	$("#zipcode").Watermark("Zipcode");
	
});
function showeditcreditcard(idr,ids){
	$("#"+idr).append('<img id="aimg" src="images/ajax-loader.gif"/>');
	$.ajax({
	type: "GET",
	url: "ajax.editpayment.php",
	data: {id:ids,mdef:0}
	}).done(function( result ) {
	if(result==2){
	alert("Invalid data");
	}
	else{
	var resarr=new Array();
	resarr=$.parseJSON(result);
		$.each(resarr, function(key, val) {
			$("#"+key).val(val);
			if(key=="Expmon"){
			$("#Reg_DOB_Wrap .selectBox-label").html($('#Reg_DOB_Wrap .selectBox-label').html().replace('mm',val ));
			}
			if(key=="Expyear"){
			$("#Reg_DOB02_Wrap .selectBox-label").html($('#Reg_DOB02_Wrap .selectBox-label').html().replace('yy',val ));
			}
			$('#addcreditcard').show();
			$("#aimg").remove();
		});
		}
	});

}
function showaddcreditcard(){
//alert($("#upmid").val());
if((trim($("#upmid").val())!="") && $("#addcreditcard").show()){
$("#upmid").val('');
clearform();
}
else{
$('#addcreditcard').toggle();
}
}
function showadpaypalpayment(){
if((trim($("#upmid").val())!="") && $("#addpaypal").show()){
$("#upmid").val('');
clearform();
}
else{
$('#addpaypal').toggle();
}
}

function makedefaultcrd(idr,ids){
	$("input[type='checkbox']:checked").each( 
		function() { 
		 //alert($(this).attr("id"));
		 var idvr="";
		 idvr=$(this).attr("id");
		 if(idvr!=idr){
		 $("#"+idvr).removeAttr('checked');
		 }
		}
	);

	if ($('#'+idr).is(":checked"))
	{
	var st=1;
	}
	else{
	var st=0;
	}
	$("#cursts"+idr).append('<img id="aimg" src="images/ajax-loader.gif"/>');
	$.ajax({
	type: "GET",
	url: "ajax.editpayment.php",
	data: {id:ids,mdef:1,sts:st}
	}).done(function( result ) {
		if(result==2){
		alert("Invalid data");
		}
		else{
		
		$("#aimg").remove();
		}
	});
}

function validmonth(){
if($('#Expmon').val()!="" && $('#Expyear').val()!=""){
CheckDate("Expyear","Expmon");
}
}
</script>
<style>
.selectBox-dropdown { position: relative; cursor: default; background-position: left top; height: 30px;  padding-top: 5px; font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif; font-size:18px; color:#808080; }
.selectBox-dropdown .selectBox-label { padding: 2px 8px; display: inline-block; white-space: nowrap; overflow: hidden; font-size:18px; }
.selectBox-dropdown .selectBox-arrow { position: absolute; top: 0; right: 0; width: 23px; height: 100%; background: url(images/combo_arrow_down.png) top center no-repeat;  }
.selectBox-dropdown-menu { position: absolute; z-index: 99999; max-height: 200px; min-height: 1em; border: solid 1px #BBB; -moz-box-shadow: 0 2px 6px rgba(0, 0, 0, .2); -webkit-box-shadow: 0 2px 6px rgba(0, 0, 0, .2); box-shadow: 0 2px 6px rgba(0, 0, 0, .2); overflow: auto; font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif; font-size:18px; color:#808080; background-color: #e5e5e5; }
.errBorder {
    float:left;
    border:1px solid #F00;
    border-radius:7px;
	outline:none;
    border-color:#F00;
	font-size:17px !important;
    box-shadow:0 0 1px #FF4040;
}
</style>
<?php
$month = array(array("01","Jan"),array("02","Feb"),array("03","Mar"),array("04","Apr"),array("05","May"),array("06","Jun"),array("07","Jul"),array("08","Aug"),array("09","Sep"),array("10","Oct"),array("11","Nov"),array("12","Dec"));
$currentyear=date("Y");
?>
<div id="Reg_Wrap">
<div id="Reg_top"></div>
<div id="Reg_mid">
<div id="Hdr_Register">Payment Method</div>
<div id="Reg_Fields_Wrap">
<?php
if(isset($_GET['err']) && $_GET['err']==1){
echo "<span style='color:green'>Successfully payment method created</span>";
}
elseif(isset($_GET['err']) && $_GET['err']==2){
echo "<span style='color:red'>Unsuccessfully payment method created</span>";
}
elseif(isset($_GET['err']) && $_GET['err']==3){
$crdnumberw="xxxx-".substr($_SESSION['crdno'], -4);
echo "<span style='color:red'>Already exist in this ".$crdnumberw." card number</span>";
}
else{
}
?>
<?php
$userid=$_SESSION['ccrm_userid']!=""?$_SESSION['ccrm_userid']:0;
$query=$dbslave->query("select USER_PAYMENT_METHOD_ID, FIRST_NAME, LAST_NAME, CARD_NUMBER, CVC_CVS, EXP_DATE, ADDRESS1, ADDRESS2, CITY, STATE, ZIPCODE, USER_ID, PM_USE_STATUS, CREATED_DATE, UPDATED_DATE, PM_USE_STATUS from user_payment_method where USER_ID=$userid");
?>
<div id="Reg_Fields_Wrap1">
<div id="Reg_Txt_cnt1" style="width:100%">Your Payment Methods</div>
</div>
<?php
if(mysql_num_rows($query)>0){
?>
<?php 
while($row=mysql_fetch_assoc($query)){
@extract($row);
?>
<div id="Reg_Fields_Wrap1">
<div id="Reg_Txt_cnt1" style="width:100%">
<?php 
$crdnumber="xxxx-".substr($CARD_NUMBER, -4);
?>
<div id="Reg_Txt_cnt5" style="width:450px;">
<?php if($PM_USE_STATUS==1){$checked='checked="checked"';}else{$checked="";} ?>
<input type="checkbox" name="cursts" id="chk<?php echo $USER_PAYMENT_METHOD_ID?>" onclick="javascript:makedefaultcrd(this.id, '<?php echo $USER_PAYMENT_METHOD_ID?>');" <?php echo $checked;?> />
<?php echo "&nbsp;".$FIRST_NAME.' '.$LAST_NAME. "&nbsp;&nbsp;".$crdnumber; ?> &nbsp;&nbsp;&nbsp;
<span><a href="javascript:;" onclick="javascript:showeditcreditcard(this.id, '<?php echo $USER_PAYMENT_METHOD_ID?>');" id="<?php echo $USER_PAYMENT_METHOD_ID?>">(Edit)</a></span><span id="cursts<?php echo $USER_PAYMENT_METHOD_ID?>"></span></div><br/>
</div>
</div>
<?php }
}
else{
?>
<div id="Reg_Fields_Wrap1">
<div id="Reg_Txt_cnt5" style="width:100%">
You have no payment methods on file.
</div>
</div>
<?php
}
 ?>
<div id="Reg_Fields_Wrap1">
<div id="reg_btn">
<div style="float:left;width:140px;"><button value="submit" class="addpaypal" name="addpaypal" type="button" onclick="javascript:showadpaypalpayment()"></button></div>
<div style="float:left;width:140px;"><button value="submit" class="addcreditcrd" name="addcreditcrd" type="button"  onclick="javascript:showaddcreditcard();"></button></div>
</div>
</div>

<table border="0" cellpadding="0" id="addpaypal" cellspacing="0" width="100%" style="font-size:12px; font-weight:lighter; color:#3F3F3F;display:none;">
<tr><td>
<form method="post" name="frmpayment" id="frmpayment" >
<input type="hidden" id="upmid" name="upmid" value="" />
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>
<div id="Reg_Fields_Wrap1">
<div id="Reg_Txt_cnt1">Add Paypal</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Reg_Fields_Wrap1">
<div class="Reg_UsrName">
<input name="paypalemail" type="text" class="text_field_big watermark_ot" id="paypalemail" value="" onkeypress="return onlyAlphabets(event,this);" title="Paypal Email" onblur="return validatefield(this.id)" onchange="return validatefield(this.id)" tabindex="1" />
</div>
<div class="Reg_UsrName">
<input name="lname" type="text" class="text_field_big watermark_ot" id="lname" value="" onkeypress="return onlyAlphabets(event,this);" title="Last Name" onblur="validatefield(this.id)" tabindex="2" />
</div>
</div>
</td>
</tr>
</table>
</form>
</td>
</tr>
</table>

<table border="0" cellpadding="0" id="addcreditcard" cellspacing="0" width="100%" style="font-size:12px; font-weight:lighter; color:#3F3F3F;display:none;">
<tr><td>
<form method="post" name="frmpayment" id="frmpayment" >
<input type="hidden" id="upmid" name="upmid" value="" />
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tr>
<td>
<div id="Reg_Fields_Wrap1">
<div id="Reg_Txt_cnt1">Add Credit Card Info</div>
</div>
</td>
</tr>
<tr>
<td>
<div id="Reg_Fields_Wrap1">
<div class="Reg_UsrName">
<input name="fname" type="text" class="text_field_big watermark_ot" id="fname" value="" onkeypress="return onlyAlphabets(event,this);" title="First Name" onblur="return validatefield(this.id)" onchange="return validatefield(this.id)" tabindex="1" />
</div>
<div class="Reg_UsrName">
<input name="lname" type="text" class="text_field_big watermark_ot" id="lname" value="" onkeypress="return onlyAlphabets(event,this);" title="Last Name" onblur="validatefield(this.id)" tabindex="2" />
</div>
<div class="Reg_UsrName">
<input name="crdno" type="text" class="text_field_big watermark_ot" id="crdno" value="" onchange="return Mod10(this.value,this.id);" onblur="return Mod10(this.value,this.id);" onkeypress="return isNumberKey(event)" title="Card Number" tabindex="3" />
</div>
<div class="Reg_UsrName">
<div style="float:left;width:231px">
<input name="cvvcvs" type="text" class="text_field_small watermark_ot" id="cvvcvs" value="" onchange="cvvvalidate(document.getElementById('crdno').value,this.value,this.id)" onblur="cvvvalidate(document.getElementById('crdno').value,this.value,this.id)"  onkeypress="return isNumberKey(event)" title="CVC or CVS" tabindex="4" maxlength="4" />
</div>
<div style="float:left;"><span style="font-weight:bold">Last 3 digits on back of card.</span><br/><span style="font-weight:bold">Amex: 4 digit code on front</span></div>
</div>
<div class="Reg_UsrName">
<div style="float:left;width:231px"><div id="payment_expiartion">Expiration Date</div></div>
<div style="float:left">
<div id="Reg_DOB_Wrap">
    <select id="Expmon" name="Expmon" class="custom-class1 custom-class2"  onchange="return validmonth()" style="width: 68px;" rel="dobmonth" tabindex="5" >
    <option value="">mm</option>
    <?php for($i=0; $i<12; $i++) { ?>
    <option value="<?PHP echo $month[$i][0];?>"><?PHP echo $month[$i][0]; ?></option> 
    <?php } ?>
    </select>
</div>
<div id="Reg_DOB02_Wrap" style="margin-left:10px;">
    <select id="Expyear" name="Expyear" class="custom-class1 custom-class2" style="width: 77px;" rel="dobyear" onchange="return CheckDate('Expyear','Expmon')" tabindex="6">
    <option value="">yy</option>
    <?php for($i=$currentyear; $i<=$currentyear+10; $i++) { ?>
    <option value="<?php echo $i ;?>"> <?php echo $i; ?> </option>
    <?php } ?>
    </select>
</div>
</div>
</div>
<div id="Reg_Txt_cnt1">Add Billing Address</div>
<div class="Reg_UsrName">
<input name="address1" type="text" class="text_field_big watermark_ot" id="address1" onblur="return validatefield(this.id)" onchange="return validatefield(this.id)" value="" title="Address Line 1"  tabindex="7" />
</div>
<div class="Reg_UsrName">
<input name="address2" type="text" class="text_field_big watermark_ot"  id="address2" onblur="return validatefield(this.id)" onchange="return validatefield(this.id)" value="" title="Address Line 2"  tabindex="8" />
</div>
<div class="Reg_UsrName">
<input name="city" type="text" class="text_field_big watermark_ot" id="city" onkeypress="return onlyAlphabets(event,this);" onblur="return validatefield(this.id)" onchange="return validatefield(this.id)" value="" title="City" tabindex="9" />
</div>
<div class="Reg_UsrName">
<input name="state" type="text" class="text_field_big watermark_ot" id="state" onkeypress="return onlyAlphabets(event,this);" onblur="return validatefield(this.id)" onchange="return validatefield(this.id)" value="" title="State/Province" tabindex="10" />
</div>
<div class="Reg_UsrName">
<input name="zipcode" type="text" class="text_field_big watermark_ot" id="zipcode" onblur="return validatefield(this.id)" onchange="return validatefield(this.id)" onkeypress="return isNumberKey(event)" value="" title="Zipcode" tabindex="11" />
</div>
<div id="reg_btn">
<input type="hidden" value="Save" name="Save" />
<button value="Save" class="btnSave" name="btnSave" id="btnSave" type="button" onclick="return fmvalidate();" tabindex="12" ></button>
</div>
</div>
</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
</div>
</div>
<div id="Reg_bot"></div>
</div>

<div id="Hdr_Register">Verification Confirmation</div>
<div id="Age_conf_Ver_Wrap">
<?php
if(isset($_REQUEST['prfupld']) && $_REQUEST['prfupld']=='yes'){
?>
<p style="font-size:11px;padding-top:10px;">Thank you for submitting your documents.</p>
<p  style="font-size:11px;padding-top:10px;padding-bottom:10px;">Chumba Casino fax number is 1-415-520-9884. Please send your unique fax PIN number together with your proof of identification documents.</p>
<?php }else{
?>
<p>Thank you for submitting your documents.</p>
<p>An email confirmation with your details and your Chumba Casino PIN will be sent to you once we have verified all information.</p>
<p>Please keep a record of your PIN for all future transactions.</p>
<?php }?>
<div id="Btn_BackGanmeWrap">
<button value="submit" class="BackGameBtn" type="submit" onclick="javascript:parent.jQuery.fancybox.close(); parent.egamestatus('visible');"></button>
</div>
</div>

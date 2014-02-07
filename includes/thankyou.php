<?PHP
include('mail/SMTPconfig.php');
include('mail/SMTPClass.php');
if($_REQUEST['s']=='s')
{
	$item_val=explode("~",$_REQUEST['custom']);		
	$membership_id = base64_decode($item_val[0]);
	$referenceNoId = base64_decode($item_val[1]);	
	$userid=base64_decode($_REQUEST['item_number']);
	$transactionAmount=$_REQUEST['mc_gross'];	
				
				//Paypal Status Checking START
				if($_REQUEST['payment_status'] == 'Completed' || $_REQUEST['payment_status'] == 'Created' || $_REQUEST['payment_status'] == 'Processed')
				{
					$status = 115;
				}
				else if($_REQUEST['payment_status'] == 'Failed' || $_REQUEST['payment_status'] == 'Voided' || $_REQUEST['payment_status'] == 'Denied' || $_REQUEST['payment_status'] == 'Expired' || $_REQUEST['payment_status'] == 'Fraud_Management_Filters_x')
				{
					$status = 117;
				}
				else if($_REQUEST['payment_status'] == 'Refunded')
				{
					$status = 108;
				}
				else if($_REQUEST['payment_status'] == 'Pending')
				{
					$status = 116;
				}
				/*else
				{
					$status = 116;
				}*/
				//Paypal Status Checking END		
				
				$qrycheck =$dbslave->query("SELECT count(PAYMENT_TRANSACTION_STATUS) as cnt FROM payment_transaction WHERE PAYMENT_TRANSACTION_STATUS='115' AND INTERNAL_REFERENCE_NO=".$referenceNoId." AND USER_ID=".$userid);				
				$numcnt=mysql_fetch_row($qrycheck);			
				
				if($numcnt['0']=="0" && $status = "115")
				{					
					//Update For User Membership						
					$query=$dbmaster->query("Update user set MEMBERSHIP_ID='$membership_id',MEMBERSHIP_DATE=NOW(),MEMBERSHIP_FLAG='1' where USER_ID='$userid'");	
					//Log file info
    				$log->write_log($_SESSION['username']."(Membership) Membership updated successfully(Amt:".$transactionAmount.")","Payment");			
				}
				else
				{				
					$path = 'http://'.$_SERVER['HTTP_HOST'];
					header("Location:".$path."/chumba/index.php");
					exit;
				}	
				
				$balanceTypeId="1";
				$transactionStatusId = $status;
				$transactionTypeId="20";
				$transactionAmount=$transactionAmount;
				$coinTypeId="3";
				$gameId="0";			
				$xP="0";
				$goodsKey="0";	
				$userId=$userid;			
				include("transactiondetailssuccess.php");				
				$smsg = "Thank you for becoming a VIP member.";	
				//header("Location:avatar.php?pa=1");
}

elseif($_REQUEST['s']=='f')
{
			include("dbs.php");			
			
			$item_val=explode("~",$_REQUEST['custom']);		
			$membership_id = base64_decode($item_val[0]);
			$referenceNoId = base64_decode($item_val[1]);			
			$userid=base64_decode($_REQUEST['item_number']);							
			
			$balanceTypeId="1";
			$transactionStatusId="118";
			$transactionTypeId="20";
			$transactionAmount=$_REQUEST['amount'];
			$coinTypeId="3";
			$gameId="0";			
			$xP="0";
			$goodsKey="0";			
			$userId=$userid;
			include("transactiondetailssuccess.php");						
			$smsg = "Your Transaction has been Cancelled";
			
			//Log file info
			$log->write_log($_SESSION['username']."(Membership) Transaction has been Cancelled(Amt:".$transactionAmount.")","Payment");			
			//header("Location:avatar.php?pa=1");
}
?>

<div id="Hdr_Register">
  Thank You!!
</div><div id="Reg_Fields_Wrap">
<div id="Reg_Success">
<?php echo $smsg; ?>
<br /> 
We have sent a confirmation email to <?php echo $email_to; ?>
</div>
<div id="Btn_BackGanmeWrap">
<button value="submit" class="BackGameBtn" type="button" onclick="window.location='<?php echo BASE_PATH.'index.php'; ?>';"></button>
</div>
</div>
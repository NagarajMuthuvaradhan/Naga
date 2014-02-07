<div style="width:100%;">
<div id="Common_Cnt_hdr_txt"><h1>My History</h1></div>
<div id="Common_Cnt_hdr_txt" style="margin-top:0px;"><h3><b>Cash Transaction</b></h3></div>
<?php
include("classes/CSSPagination.class.php");
$userid=$_SESSION['ccrm_userid']!=""?$_SESSION['ccrm_userid']:0;
function vg_query_res($monthly,$today,$stdate,$endate,$colname){
		$sql="";
		if($today==1){
		$curdate=date("Y-m-d");
		$conQuery=$conQuery."((SELECT date_format($colname,'%Y-%m-%d'))='".$curdate."') AND ";
		$sql = 	$conQuery;				
		}
		elseif($monthly!=""){
		$curmonth=date("Y")."-".$monthly;
		$conQuery=$conQuery."((SELECT date_format($colname,'%Y-%m'))='".$curmonth."') AND ";
		$sql = 	$conQuery;				
		}
		elseif($stdate!="" || $endate!=""){
				
				if($stdate!="" && $endate=="" )
				{
				   $conQuery=$conQuery."((SELECT date_format($colname,'%Y-%m-%d'))='".$stdate."') AND ";
				}
		
				if($endate!="" && $stdate=="")
				{
				 $conQuery=$conQuery."((SELECT date_format($colname,'%Y-%m-%d'))='".$endate."') AND ";
				}
				if($stdate!="" && $endate!="")
				{
				   $conQuery=$conQuery."((SELECT date_format($colname,'%Y-%m-%d'))>='".$stdate."') AND ((SELECT date_format($colname,'%Y-%m-%d'))<='".$endate."') AND ";
				}
		
				$sql = 	$conQuery;				
		}
	return $sql;
}
function build_http_query( $query ){

    $query_array = array();

    foreach( $query as $key => $key_value ){

        $query_array[] = urlencode( $key ) . '=' . urlencode( $key_value );

    }

    return implode( '&', $query_array );

}
?>
<?php
$perpage = $pagePerRecord;//limit in each page
$startpoint = ($page * $perpage) - $perpage;
if($_REQUEST['search']){
$sql=vg_query_res($_REQUEST['monthly'],$_REQUEST['today'],$_REQUEST['st_time'],$_REQUEST['end_time'],"PAYMENT_TRANSACTION_CREATED_ON");
}
else{
$sql=vg_query_res($_REQUEST['monthly'],1,$_REQUEST['st_time'],$_REQUEST['end_time'],"PAYMENT_TRANSACTION_CREATED_ON");
}
if(trim($_REQUEST['history'])!=""){
$trsctids=$_REQUEST['history'];
}
else{
$trsctids="8, 9, 10, 20";
}
$query="select USER_ID, INTERNAL_REFERENCE_NO, TRANSACTION_TYPE_ID, PAYMENT_PROVIDER_ID,PAYMENT_TRANSACTION_CREATED_ON from payment_transaction where $sql  TRANSACTION_TYPE_ID IN ($trsctids) AND PAYMENT_TRANSACTION_STATUS IN(103,111,115) AND USER_ID=$userid";

$sql1 = $query;//"SELECT * FROM whatevertable WHERE whateverfilter ORDER BY whateverorder "; 
$rowsperpage = 10; // 5 records per page. You can change it.
if(isset($_POST) && !empty($_POST)){
$querystring=build_http_query($_POST);
}
else{
$querystring2=$_SERVER['QUERY_STRING'];
}
$website = $_SERVER['PHP_SELF']."?pname=myhistory&tpage=ctsh&".$querystring; // other arguments if need it.
$pagination = new CSSPagination($sql1, $rowsperpage, $website); // create instance object
if($_GET['tpage']=="ctsh"){
$pagination->setPage($_GET[page]); // dont change it
}
else{
$pagination->setPage(0); // dont change it
}
// Second select is similar at the top one, but it follows by limitation.
$sql2 = "$query ORDER BY PAYMENT_TRANSACTION_CREATED_ON  LIMIT " . $pagination->getLimit() . ", " . $rowsperpage; 
$result = $dbslave->query($sql2) or die("failed");
$tbody_conent="";
if(mysql_num_rows($result)>0){
while ($rows = mysql_fetch_array($result))
{
@extract($rows);
$desc="";
if($TRANSACTION_TYPE_ID==8 || $TRANSACTION_TYPE_ID==9)
{
$desc="Buymore";
$res1=$dbslave->query("select AMOUNT, PROVIDER_NAME from product_transaction AS PRT, payment_provider AS PP where PRT.PAYMENT_TRANSACTION_ID='$INTERNAL_REFERENCE_NO'");
$row1="";
	if(mysql_num_rows($res1)>0){
	$row1=mysql_fetch_array($res1);
	@extract($row1);
	$tbody_conent=$tbody_conent.'<tr>
			<td><h12>'.$INTERNAL_REFERENCE_NO.'</h12></td>
			<td><h12>'.$PAYMENT_TRANSACTION_CREATED_ON.'</h12></td>
			<td><h12>'.$desc.'</h12></td>
			<td><h12>'.$PROVIDER_NAME.'</h12></td>
			<td><h12>'.$AMOUNT.'</h12></td>
		  </tr>';
	} 

}
elseif($TRANSACTION_TYPE_ID==10){
$desc="Cashout";
$res2=$dbslave->query("select 
WT.WITHDRAW_AMOUNT as AMOUNT, PTM.MODE_NAME AS PROVIDER_NAME
from withdraw AS WT
LEFT JOIN payment_transfer_mode AS PTM ON PTM.PAYMENT_TRANSFER_MODE_ID=WT.PAYMENT_TRANSFER_MODE_ID 
WHERE WT.INTERNAL_REFERENCE_NUMBER='$INTERNAL_REFERENCE_NO'");
	if(mysql_num_rows($res2)>0){
	$row2=mysql_fetch_array($res2);
	@extract($row2);
	$tbody_conent =$tbody_conent.'<tr>
			<td><h12>'.$INTERNAL_REFERENCE_NO.'</h12></td>
			<td><h12>'.$PAYMENT_TRANSACTION_CREATED_ON.'</h12></td>
			<td><h12>'.$desc.'</h12></td>
			<td><h12>'.$PROVIDER_NAME.'</h12></td>
			<td><h12>'.$AMOUNT.'</h12></td>
		  </tr>';
	}  

}
elseif($TRANSACTION_TYPE_ID==20){
$desc="VIP Membership";
$tbody_conent=$tbody_conent."";
}

}
}
else{
$tbody_conent .='<tr><td colspan="5"><h12>No Records Found</h12></td></tr>';
}
if(!isset($_REQUEST['search'])){
$ttoday=1;
}
else{
$ttoday=0;
}
?>
<div id="Player_Game_History_Wrap">
<form method="post" name="tsearchform-1" id="tsearchform-1" enctype="multipart/form-data">
<div style="width:100%;text-align:center;padding-left:90px;">
<div id="History_wrap">
<div class="HistoryWrap">
<div id="Historyxtx"><h10>History:</h10></div>
<div id="History_drop_menu">
<select id="history" name="history" class="custom-class1 custom-class2" style="width:178px;" rel="history" tabindex="1">
<option value="">All</option>
<!--<option value="1" <?php if($_REQUEST['history'] == "1"){ echo selected;}?>>VIP Membership</option>-->
<option value="8,9" <?php if($_REQUEST['history'] == "8,9"){ echo selected;}?>>Buy More</option>
<option value="10" <?php if($_REQUEST['history'] == "10"){ echo selected;}?>>Cash Out</option>
</select>
</div>
</div>
<div class="History_month_Wrap">
<div id="Historyxtx"><h10>Month:</h10></div>
<div id="History_month_drop_menu">
    <select name="monthly" id="monthly" class="custom-class1 custom-class2" style="width: 80px;" tabindex="2">
        <option value="">mm</option>
        <option value="01"<?php if($_REQUEST['monthly'] == "01"){ echo selected;}?> >Jan</option>
        <option value="02"<?php if($_REQUEST['monthly'] == "02"){ echo selected;}?> >Feb</option>
        <option value="03"<?php if($_REQUEST['monthly'] == "03"){ echo selected;}?> >Mar</option>
        <option value="04"<?php if($_REQUEST['monthly'] == "04"){ echo selected;}?> >Apr</option>
        <option value="05"<?php if($_REQUEST['monthly'] == "05"){ echo selected;}?> >May</option>
        <option value="06"<?php if($_REQUEST['monthly'] == "06"){ echo selected;}?> >Jun</option>
        <option value="07"<?php if($_REQUEST['monthly'] == "07"){ echo selected;}?> >Jul</option>
        <option value="08"<?php if($_REQUEST['monthly'] == "08"){ echo selected;}?> >Aug</option>
        <option value="09"<?php if($_REQUEST['monthly'] == "09"){ echo selected;}?> >Sep</option>
        <option value="10"<?php if($_REQUEST['monthly'] == "10"){ echo selected;}?>>Oct</option>
        <option value="11"<?php if($_REQUEST['monthly'] == "11"){ echo selected;}?> >Nov</option>
        <option value="12"<?php if($_REQUEST['monthly'] == "12"){ echo selected;}?>>Dec</option>
    </select>
</div>
</div>

<div class="History_today_Wrap">
<div id="Historyxtx"><h10>Today:</h10></div>
<div id="History_today_input">
  <input type="checkbox" name="today" id="today" value="1" <?PHP if($ttoday==1 || ( $_REQUEST['today']=="1" && $_REQUEST['st_time']=="" )) { ?>checked="checked" <?PHP } ?> tabindex="3"/>
</div>
</div>
<div id="History_Date_wrap">
<div id="Date_fromto_Wrap">
<div id="Date_Name_text">
<h10>Start Date:</h10>
</div>
<div id="Date_bg">
<div id="Date_Field">
<input name="st_time" type="text" class="Date_txtField" id="st_time" value="<?PHP echo $_REQUEST['st_time']; ?>"  size="12" tabindex="4" readonly="readonly" />
</div>
<ul id="Calender_icon">
<li id="Icon_Cal"><a href="javascript:;" onclick="NewCssCal('st_time','yyyymmdd','arrow',false,24,false)"></a></li>
</ul>
</div>
</div>
<div id="Date_fromto_Wrap">
<div id="Date_Name_text">
<h10>End  Date:</h10>
</div>
<div id="Date_bg">
<div id="Date_Field">
  <input name="end_time" type="text" class="Date_txtField" id="end_time" size="12" value="<?PHP echo $_REQUEST['end_time']; ?>" onfocus="return txt();" tabindex="5" readonly="readonly" />
</div>
<ul id="Calender_icon">
<li id="Icon_Cal"><a href="javascript:;" onclick="NewCssCal('end_time','yyyymmdd','arrow',false,24,false)"></a></li>
</ul>
</div>
</div>
</div>
</div>
<div id="Btn_Search_Clear_Wrap" style="margin-left:20px;">
<button name="search" value="submit" class="GsearchBtn" type="submit" tabindex="6"></button>
<button value="submit" class="GclearBtn" type="button" onclick="javascript:clearform();" tabindex="7"></button>
</div>
</div>
</form>
</div>
<div id="Player_Game_History_Wrap">
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="tbl-grid">
<thead>
<tr>
<th><h11>Reference No</h11></th>
<th><h11>Date</h11></th>
<th><h11>Description</h11></th>
<th><h11>Payment Method</h11></th>
<th><h11>Amount</h11></th>
</tr>
</thead>
<tbody>
<?php 
echo $tbody_conent;
?>
</tbody>
</table>
    <div style="width:100%;text-align:center">
    <div class="pagination">
    <table width="100%">
    <tr><td style="text-align:center"><?php echo $pagination->showPage(); ?></td></tr>
    </table>
    </div>
    </div>
</div>
</div>

<!--<div style="width:100%;" style="display:none">
<div id="Common_Cnt_hdr_txt" style="margin-top:-10px;"><h3><b>Virtual Transaction</b></h3></div>
<?php
$perpage = $pagePerRecord;//limit in each page
$startpoint = ($page * $perpage) - $perpage;
if($_REQUEST['searchfrm1']){
$sql=vg_query_res($_REQUEST['vmonthly'],$_REQUEST['vtoday'],$_REQUEST['vst_time'],$_REQUEST['vend_time'],"c.TRANSACTION_CREATED_ON");
}
else{
$sql=vg_query_res($_REQUEST['vmonthly'],1,$_REQUEST['vst_time'],$_REQUEST['vend_time'],"c.TRANSACTION_CREATED_ON");
}
if(trim($_REQUEST['virtualhistory'])!=""){
$virtualhistoryids=$_REQUEST['virtualhistory'];
}
else{
$virtualhistoryids="3,4";
}
if(trim($_REQUEST['avatarcategory'])!="" && trim($_REQUEST['shopcategory'])!=""){
$cate=$_REQUEST['avatarcategory'].",".$_REQUEST['shopcategory'];
}
elseif(trim($_REQUEST['avatarcategory'])=="" && trim($_REQUEST['shopcategory'])!=""){
$cate=$_REQUEST['shopcategory'];
}
elseif(trim($_REQUEST['avatarcategory'])!="" && trim($_REQUEST['shopcategory'])==""){
$cate=$_REQUEST['avatarcategory'];
}
else{
$cate="";
}

if(trim($cate)!=""){
$where="v.CATEGORY_ID IN($cate) AND";
}


$query="select c.INTERNAL_REFERENCE_NO,v.PRODUCT_NAME,v.CATEGORY_ID,c.COIN_TYPE_ID,
c.TRANSACTION_AMOUNT,c.TRANSACTION_CREATED_ON from virtual_goods as v
inner join coin_transaction as c on c.TRANSACTION_GOODS_KEY=v.VIRTUAL_GOODS_ID
where $where $sql c.TRANSACTION_TYPE_ID IN($virtualhistoryids) and c.USER_ID=$userid";

//include("classes/CSSPagination.class.php");
$sql1 = $query;//"SELECT * FROM whatevertable WHERE whateverfilter ORDER BY whateverorder "; 
$rowsperpage = 10; // 5 records per page. You can change it.
if(isset($_POST) && !empty($_POST)){
$querystring2=build_http_query($_POST);
}
else{
$querystring2=$_SERVER['QUERY_STRING'];
}
$website = $_SERVER['PHP_SELF']."?pname=myhistory&tpage=vtsh&".$querystring2; // other arguments if need it.
$pagination = new CSSPagination($sql1, $rowsperpage, $website); // create instance object
if($_GET['tpage']=="vtsh"){
$pagination->setPage($_GET[page]); // dont change it
}
else{
$pagination->setPage(0); // dont change it
}
//echo $pagination->showPage();
// Second select is similar at the top one, but it follows by limitation.
$sql2 = "$query ORDER BY TRANSACTION_CREATED_ON  DESC LIMIT " . $pagination->getLimit() . ", " . $rowsperpage;

$result = $dbslave->query($sql2) or die("failed");
$tbody_conent="";
if(mysql_num_rows($result)>0){
	while ($rows = mysql_fetch_array($result))
	{
	@extract($rows);
	$desc="";
		if($COIN_TYPE_ID==1)
		{
		$desc="Gold";
		} 
		elseif($COIN_TYPE_ID==2){
		$desc="Platinum";
		}
		elseif($COIN_TYPE_ID==3){
		$desc="Cash";
		}
		elseif($COIN_TYPE_ID==4){
			$desc="Token";
		}
		else{
		}
		$tbody_conent=$tbody_conent.'<tr>
			<td><h12>'.$INTERNAL_REFERENCE_NO.'</h12></td>
			<td><h12>'.$TRANSACTION_CREATED_ON.'</h12></td>
			<td><h12>'.$PRODUCT_NAME.'</h12></td>
			<td><h12>'.$desc.'</h12></td>
			<td><h12>'.$TRANSACTION_AMOUNT.'</h12></td>
		  </tr>';
	}
}
else{
		$tbody_conent .='<tr><td colspan="5"><h12>No Records Found</h12></td></tr>';
}
if(!isset($_REQUEST['searchfrm1'])){
$dtoday=1;
}
else{
$dtoday=0;
}

?>
        <div id="Player_Game_History_Wrap">
        <form method="post" name="tsearchform-2" id="tsearchform-2" enctype="multipart/form-data">
        <div style="width:100%;text-align:center;">
        <div id="Virtual_History_wrap">
        <div class="Virtual_HistoryWrap">
        <div id="Virtual_Historyxtx"><h10>History:</h10></div>
        <div id="Virtual_History_drop_menu">
        <select id="virtualhistory" name="virtualhistory" class="custom-class1 custom-class2" style="width:80px;" rel="virtualhistory" tabindex="7">
        <option value="">All</option>
        <option value="3" <?php echo $vh=$_REQUEST['virtualhistory']==3?'selected=selected':" ";?>>Buy</option>
        <option value="4" <?php echo $vh=$_REQUEST['virtualhistory']==4?'selected=selected':" ";?>>Sell</option>
        </select>
        </div>
        </div>

        <div class="Virtual_avatarWrap">
        <div id="Virtual_Historyxtx"><h10>Avatar:</h10></div>
        <div id="Virtual_avatar_drop_menu">
        <select id="avatarcategory" name="avatarcategory" class="custom-class1 custom-class2" style="width:100px;" rel="avatarcategory" tabindex="8">
        <option value="">All</option>
		<?php
        $sqlCountry = $dbslave->query("SELECT MAINCATEGORY_ID, NAME AS VGGOODS FROM maincategory where PARENT_CATEGORY_ID='1' order by MAINCATEGORY_ID");
        while ($row = mysql_fetch_array($sqlCountry)) {
        ?>
        <?php $ah=$_REQUEST['avatarcategory']==$row['MAINCATEGORY_ID']?'selected=selected':" ";?>
        <option value="<?php echo $row['MAINCATEGORY_ID'];?>" <?php echo $ah;?>><?php echo $row['VGGOODS'];?></option>
        <?php } ?>
        </select>
        </div>
        </div>

        <div class="Virtual_shopWrap">
        <div id="Virtual_Historyxtx"><h10>Shop:</h10></div>
        <div id="Virtual_shop_drop_menu">
        <select id="shopcategory" name="shopcategory" class="custom-class1 custom-class2" style="width:130px;" rel="shopcategory" tabindex="9">
        <option value="">All</option>
        <option value="21,22,64" <?php echo $sh=$_REQUEST['shopcategory']=="21,22,64"?'selected=selected':" ";?>>Furniture</option>
        <option value="23" <?php echo $sh=$_REQUEST['shopcategory']=="23"?'selected=selected':" ";?>>Decor</option>
        <option value="24" <?php echo $sh=$_REQUEST['shopcategory']=="24"?'selected=selected':" ";?>>Room Themes</option>
        </select>
        </div>
        </div>
        <div id="Virtual_History_month_Wrap">
        <div id="Virtual_Historyxtx"><h10>Month:</h10></div>
        <div id="Virtual_History_month_drop_menu">
        <select name="vmonthly" id="vmonthly" class="custom-class1 custom-class2" style="width: 80px;" tabindex="10">
        <option value="">mm</option>
        <option value="01"<?php if($_REQUEST['vmonthly'] == "01"){ echo selected;}?> >Jan</option>
        <option value="02"<?php if($_REQUEST['vmonthly'] == "02"){ echo selected;}?> >Feb</option>
        <option value="03"<?php if($_REQUEST['vmonthly'] == "03"){ echo selected;}?> >Mar</option>
        <option value="04"<?php if($_REQUEST['vmonthly'] == "04"){ echo selected;}?> >Apr</option>
        <option value="05"<?php if($_REQUEST['vmonthly'] == "05"){ echo selected;}?> >May</option>
        <option value="06"<?php if($_REQUEST['vmonthly'] == "06"){ echo selected;}?> >Jun</option>
        <option value="07"<?php if($_REQUEST['vmonthly'] == "07"){ echo selected;}?> >Jul</option>
        <option value="08"<?php if($_REQUEST['vmonthly'] == "08"){ echo selected;}?> >Aug</option>
        <option value="09"<?php if($_REQUEST['vmonthly'] == "09"){ echo selected;}?> >Sep</option>
        <option value="10"<?php if($_REQUEST['vmonthly'] == "10"){ echo selected;}?>>Oct</option>
        <option value="11"<?php if($_REQUEST['vmonthly'] == "11"){ echo selected;}?> >Nov</option>
        <option value="12"<?php if($_REQUEST['vmonthly'] == "12"){ echo selected;}?>>Dec</option>
        </select>
        </div>
        </div>
        </div>
        <div id="Virtual_History_Date_wrap">
        <div id="Virtual_Date_fromto_Wrap">
        <div id="Date_Name_text">
        <h10>Start Date:</h10>
        </div>
        <div id="Date_bg">
        <div id="Date_Field">
        <input name="vst_time" type="text" class="Date_txtField" id="vst_time" value="<?PHP echo $_REQUEST['vst_time']; ?>"  size="12" tabindex="11" readonly="readonly" />
        </div>
        <ul id="Calender_icon">
        <li id="Icon_Cal"><a href="javascript:;" onclick="NewCssCal('vst_time','yyyymmdd','arrow',false,24,false)"></a></li>
        </ul>
        </div>
        </div>
        <div id="Virtual_Date_fromto_Wrap">
        <div id="Date_Name_text">
        <h10>End  Date:</h10>
        </div>
        <div id="Date_bg">
        <div id="Date_Field">
          <input name="vend_time" type="text" class="Date_txtField" id="vend_time" size="12" value="<?PHP echo $_REQUEST['vend_time']; ?>" onfocus="return txt();" tabindex="12" readonly="readonly" />
        </div>
        <ul id="Calender_icon">
        <li id="Icon_Cal"><a href="javascript:;" onclick="NewCssCal('vend_time','yyyymmdd','arrow',false,24,false)"></a></li>
        </ul>
        </div>
        </div>
        <div id="Virtual_Date_fromto_Wrap" style="float:left">
        <div id="Date_Name_text"><h10>Today:</h10></div>
        <div id="History_today_input">
        <input type="checkbox" name="vtoday" id="vtoday" value="1" <?PHP if($dtoday==1 || ( $_REQUEST['vtoday']=="1" && $_REQUEST['vst_time']=="" )) { ?>checked="checked" <?PHP } ?> tabindex="13"/>
        </div>
        </div>
        </div>
        </div>
        <div id="Btn_Search_Clear_Wrap" style="margin-left:20px;">
        <button name="searchfrm1" value="submit" class="GsearchBtn" type="submit" tabindex="14"></button>
        <button value="submit" class="GclearBtn" type="button" onclick="javascript:clearform1();" tabindex="15"></button>
        </div>       
        </form>
        </div>
        <div style="clear:both"></div>
        <div id="Player_Game_History_Wrap">
        <table width="100%" border="0" cellspacing="0" cellpadding="3" class="tbl-grid">
        <thead>
        <tr>
        <th><h11>Reference No</h11></th>
        <th><h11>Date</h11></th>
        <th><h11>Description</h11></th>
        <th><h11>Payment Method</h11></th>
        <th><h11>Amount</h11></th>
        </tr>
        </thead>
        <tbody>
        <?php 
        echo $tbody_conent;
        ?>
        </tbody>
        </table>
            <div style="width:100%;text-align:center">
            <div class="pagination">
            <table width="100%">
            <tr><td style="text-align:center"><?php echo $pagination->showPage(); ?></td></tr>
            </table>
            </div>
            </div>
        </div>
    	</div>-->
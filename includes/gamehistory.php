<script src = "admin/js/datetimepicker_css.js"  type="text/javascript" language="javascript"></script>
<style type="text/css">
.tbl-grid {
    border-collapse: separate;
    border-spacing: 0;
    border: 1px solid black;
    border-radius: 5px;
    -moz-border-radius: 5px;
    padding: 0px .8px;
}
.tbl-grid thead {
	background:url(images/tblhead_bg.png) top left repeat-x;
	height:34px;
}
.tbl-grid thead tr {height:34px;}
.tbl-grid tbody { }
.tbl-grid tbody td { padding:7px 3px 0px 3px; text-align:center;}

#GH_Game_Wrap { float: left; width: 150px; margin-bottom: 14px; height: 26px; background-image: url(images/game_name_drop_bg.png); background-repeat: no-repeat; }
#GH_Gameid_Wrap { float: left; width: 200px; margin-bottom: 14px; height: 26px; background-image: url(images/gameid_sel_bg.png); background-repeat: no-repeat; }
#GH_cointype_Wrap { float: left; width: 68px; margin-bottom: 14px; height: 26px; background-image: url(images/mm1.png); background-repeat: no-repeat; }

</style> 
<script type="text/javascript">

	$(document).ready( function() {
	
		$("SELECT")
			.selectBox()
			.focus( function() {
				$('#'+$(this).attr('rel')).val($(this).val());
			})
			.blur( function() {
				$('#'+$(this).attr('rel')).val($(this).val());
			})
			.change( function() {				
				$('#'+$(this).attr('rel')).val($(this).val());
			});

	});
</script>
<script type="text/javascript">
function selstyle(){
		$("SELECT")
			.selectBox()
			.focus( function() {
				$('#'+$(this).attr('rel')).val($(this).val());
			})
			.blur( function() {
				$('#'+$(this).attr('rel')).val($(this).val());
			})
			.change( function() {				
				$('#'+$(this).attr('rel')).val($(this).val());
			});
}

function gameHistory_sel(gtype,fval,valId)
{
	var aimg= "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>"; 
		
	var obj = document.getElementById(gtype);
	if(fval == 0 && fval == "") {
		obj.innerHTML = '';
		if(gtype == 'gameList')
			document.getElementById('coinList').innerHTML = '';
		return false;	
	}
	obj.innerHTML = aimg;
	
	start = new Date(); 
	start = start.getTime();			

	var exec = function(str)
	{
			alert(str);
		if(trim(str) != "") {
			alert(str);
			//obj.innerHTML = str;
			document.getElementById("standard-dropdown-1").innerHTML=str;
		} else {
			obj.innerHTML = "";
		}
	}
	var ajax = new doAjax();
	ajax.doGet('ajax.ghistory.php?gtype='+gtype+'&valid='+valId+'&fval='+fval+'&start='+start, exec);	
}

function gamehistorysel(gtype,fval,valId,divId){
	
	var aimg= "<img src='images/ajax-loader.gif' width='16' height='16' border='0'>"; 
	var obj = document.getElementById('loadData');
	if(fval == 0 && fval == "") {
		obj.innerHTML = '';
		if(gtype == 'gameList')
			document.getElementById('coinList').innerHTML = '';
		return false;	
	}
	obj.innerHTML = aimg;

	$.ajax({
	  type: "GET",
	  url: "ajax.ghistory.php?",
	  data: {gtype:gtype,valid:valId,fval:fval},
	  success: function(msg){
		document.getElementById(divId).innerHTML=msg;
		obj.innerHTML = "";
		selstyle();
	  }
	});
}

function addSizeToList(JSON) {
	o = '<option value="'+JSON.Size_ID+'"  label="'+JSON.Size_Name+'">'+JSON.Size_Name+'</option>';
	$("#Size_ID").prepend(o);
}

function removeSizeToList(JSON) {
    $("#Size_ID option[value='"+JSON.Size_ID+"']").remove();
}

function removeSizeToList1(JSON) {
    $("#Size_ID").find('[value="' + JSON.Size_ID+ '"]').remove()
}

function gameHistory_sel1(gtype,fval,valId) {
	//alert('ajax.ghistory.php?gtype='+gtype+'&valid='+valId+'&fval='+fval);
	$.getJSON('ajax.ghistory.php?gtype='+gtype+'&valid='+valId+'&fval='+fval, function(data){
		var html = '';
		var len = data.length;
		for (var i = 0; i< len; i++) {
			//$("#gameId").html("<option value='text'>text</option>");
			html += '<option value="' + data[i].value + '">' + data[i].name + '</option>';
		}
		//alert(html);
		$("#gameId").append(html);
	});
		
}


function gameHistory_valid() {
	var gameType = document.getElementById('gameType');
	var gameId = document.getElementById('gameId');
	var coinType = document.getElementById('coinType');
	if(gameType.value == '') {
		alert('Please select game type');
		gameType.focus();
		return false;
	} else if(gameId.value == '') {
		alert('Please select game id');
		gameId.focus();
		return false;
	} else if(coinType.value == '') {
		alert('Please select coin type');
		coinType.focus();
		return false;
	}
}

</script>
<?php include("classes/CSSPagination.class.php");
//print_r($_REQUEST); 
if(!isset($_REQUEST['gameType'])) $tday = 1; else $tday = $_REQUEST['today'];
?>
<div id="Common_Cnt_hdr_txt">
 Player Game History
</div>
<div id="Player_Game_History_Wrap">
<div style="clear:both;"></div>
<form name="frmsearch" method="post" action="userpages_ccrm.php?pname=gamehistory">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
    <tr>
    	<td>
            <div id="Game_Name_text"><h10>Game Type:</h10></div>
            <div id="GH_Game_Wrap">
            <select id="gameType" name="gameType" class="custom-class1 custom-class2" style="width: 150px;" onchange="gamehistorysel('gameList',this.value,'','standard-dropdown-1')">
            <option value="">Select Type</option>
            <?php
			$sqlQ = $dbslave->query("select GAME_NAME, DISPLAY_GAME_NAME FROM minigames WHERE  MINIGAMES_CATEGORY_ID=1 GROUP BY GAME_NAME ORDER BY GAME_NAME");
			while($rowZ = mysql_fetch_assoc($sqlQ)) {
				if($rowZ['GAME_NAME'] == $_REQUEST['gameType']) $sel = "selected"; else $sel = "";
				echo '<option value="'.$rowZ['GAME_NAME'].'" '.$sel.'>'.$rowZ['DISPLAY_GAME_NAME'].'</option>';
			}
			?>
            </select>
            </div>
            <div id="Game_Name_text" style="width:100px;"><h10>Game Id:</h10></div>
            <div id="GH_Gameid_Wrap">
            <div id="standard-dropdown-1">
            <select name="gameId" class="custom-class1 custom-class2" id="gameId" style="width: 200px;" onchange="gamehistorysel('coinList',this.value,'','standard-dropdown-2')">
                <option value="">--- Select Game ---</option>
                <?php
                /*$sqlQ = $dbslave->query("select DISTINCT GAME_ID, DISPLAY_NAME FROM minigames WHERE GAME_NAME='".$fval."'");
                while($rowZ = mysql_fetch_assoc($sqlQ)) {
                    if($rowZ['GAME_ID'] == $valid) $sel = "selected"; else $sel = "";
                    echo '<option value="'.$rowZ['GAME_ID'].'" '.$sel.'>'.$rowZ['DISPLAY_NAME'].'</option>';
                }*/
                ?>
            </select>
            </div>
            </div>
            <div id="Game_Name_text" style="width:70px;"><h10>Coin:</h10></div>
            <div id="GH_cointype_Wrap" style="margin-left:10px;">
            <div id="standard-dropdown-2">
            <select name="coinType" class="custom-class1 custom-class2" id="coinType" style="width: 68px;">
                <?php
                /*$sqlQ = $dbslave->query("select COIN_TYPE_ID FROM minigames WHERE GAME_ID='".$fval."'");
                while($rowZ = mysql_fetch_assoc($sqlQ)) {
                    if($rowZ['GAME_ID'] == $valid) $sel = "selected"; else $sel = "";
                    echo '<option value="'.$rowZ['COIN_TYPE_ID'].'" '.$sel.'>'.$rowZ['COIN_TYPE_ID'].'</option>';
                }*/
                ?>
            </select>
            </div>
            </div>
            <span id="loadData"></span>
            <script type="text/javascript">
			<?php if($_REQUEST['gameId'] != "") { ?>
			gamehistorysel('gameList','<?php echo $_REQUEST['gameType'];?>','<?php echo $_REQUEST['gameId'];?>','standard-dropdown-1');
			gamehistorysel('coinList','<?php echo $_REQUEST['gameId'];?>','<?php echo $_REQUEST['coinType'];?>','standard-dropdown-2');
			<?php } ?>
			</script>
		</td>
    </tr>
    <tr>
    	<td>
        	<div id="Date_fromto_Wrap">
            <div id="Date_Name_text">
              <h10>Start Date:</h10>
            </div>
            <div id="Date_bg">
            <div id="Date_Field">
              <input name="st_time" type="text" class="Date_txtField" id="st_time" size="12" value="<?php echo $_REQUEST['st_time'];?>" />
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
              <input name="end_time" type="text" class="Date_txtField" id="end_time" size="12" value="<?php echo $_REQUEST['end_time'];?>" />
            </div>
            <ul id="Calender_icon">
            <li id="Icon_Cal"><a href="javascript:;" onclick="NewCssCal('end_time','yyyymmdd','arrow',false,24,false)"></a></li>
            </ul>
            
            
            </div>
            </div>
        
        
        	<div id="Game_month_Wrap">
            <div id="Game_month_text"><h10>Month:</h10></div>
            <div id="Game_month_drop_menu">
            <select id="monthly" name="monthly" class="custom-class1 custom-class2" style="width: 80px;">
            <option value="">MM</option>
            <option value="01"<?php if($_REQUEST['monthly'] == "01"){ echo 'selected';}?> >Jan</option>
            <option value="02"<?php if($_REQUEST['monthly'] == "02"){ echo 'selected';}?> >Feb</option>
            <option value="03"<?php if($_REQUEST['monthly'] == "03"){ echo 'selected';}?> >Mar</option>
            <option value="04"<?php if($_REQUEST['monthly'] == "04"){ echo 'selected';}?> >Apr</option>
            <option value="05"<?php if($_REQUEST['monthly'] == "05"){ echo 'selected';}?> >May</option>
            <option value="06"<?php if($_REQUEST['monthly'] == "06"){ echo 'selected';}?> >Jun</option>
            <option value="07"<?php if($_REQUEST['monthly'] == "07"){ echo 'selected';}?> >Jul</option>
            <option value="08"<?php if($_REQUEST['monthly'] == "08"){ echo 'selected';}?> >Aug</option>
            <option value="09"<?php if($_REQUEST['monthly'] == "09"){ echo 'selected';}?> >Sep</option>
            <option value="10"<?php if($_REQUEST['monthly'] == "10"){ echo 'selected';}?>>Oct</option>
            <option value="11"<?php if($_REQUEST['monthly'] == "11"){ echo 'selected';}?> >Nov</option>
            <option value="12"<?php if($_REQUEST['monthly'] == "12"){ echo 'selected';}?>>Dec</option>
            </select>
            </div>
            </div>
            <div id="Game_today_Wrap">
            <div id="Game_today_text"><h10>Today:</h10></div>
            <div id="Game_today_drop_menu">
              <input type="checkbox" name="today" id="today" value="1" <?php if($tday == 1) echo 'checked'; ?> />
            </div>
            </div>
        </td>
    </tr>
    <tr>
    	<td style="padding:10px;">
        <div id="Btn_Search_Clear_Wrap">
        <button value="submit" class="GsearchBtn" type="submit" onclick="return gameHistory_valid();"></button>
        <button value="submit" class="GclearBtn" type="button" onclick="window.location='userpages_ccrm.php?pname=gamehistory';"></button>
        </div>
        </td>
    </tr>
</table>

</form>

<div id="Game_Table_Wraps">
<?php
//echo "SELECT DISTINCT(GAME_ID),GAME_TABLE_NAME FROM minigames WHERE GAME_ID='".$_REQUEST['gameId']."'";
$tblname = "";
$userId = $_SESSION['ccrm_userid'];
$whr = " WHERE 1=1 AND USER_ID='$userId' ";
if(trim($_REQUEST['gameId']) !="" || trim($_REQUEST['coinType']) !="" || trim($_REQUEST['st_time']) !="" || trim($_REQUEST['end_time']) !="" || trim($_REQUEST['monthly']) !="" || trim($_REQUEST['today']) !="") {
	$tblname = mysql_result($dbslave->query("SELECT DISTINCT(GAME_ID),GAME_TABLE_NAME,REF_GAME_CODE FROM minigames WHERE GAME_ID='".$_REQUEST['gameId']."'"),0,1);
	
	if($_REQUEST['gameId'] != "") {
		$whr .= " AND GAME_ID='".$_REQUEST['gameId']."' ";
	}
	if($_REQUEST['coinType'] != "") {
		
		$scol = $dbslave->query("SHOW columns from $tblname where field='COIN_TYPE_ID'") or die('Query 2'.mysql_error());
		$colcnt = mysql_num_rows($scol);
		if($colcnt > 0) $whr .= " AND COIN_TYPE_ID = '".$_REQUEST['coinType']."' "; else if($_REQUEST['coinType'] != 1) $whr .= " AND GAME_ID = '0' ";
	}
	
	if($_REQUEST['today'] == 1) {
		$whr .= " AND (DATE_FORMAT(STARTED,'%Y%m%d') BETWEEN DATE_FORMAT(NOW(),'%Y%m%d') AND DATE_FORMAT(NOW(),'%Y%m%d')) ";
	} else if($_REQUEST['monthly'] != "") {
		$whr .= " AND YEAR(STARTED) = YEAR(NOW()) AND MONTH(STARTED) = '".$_REQUEST['monthly']."' ";
	} else if($_REQUEST['st_time'] != "" && $_REQUEST['end_time'] == "") {
		$whr .= " AND (DATE_FORMAT(STARTED,'%Y%m%d') BETWEEN DATE_FORMAT('".$_REQUEST['st_time']."','%Y%m%d') AND DATE_FORMAT(NOW(),'%Y%m%d')) ";
	} else if($_REQUEST['st_time'] == "" && $_REQUEST['end_time'] != "") {
		$whr .= " AND DATE_FORMAT(STARTED,'%Y%m%d') <= DATE_FORMAT('".$_REQUEST['end_time']."','%Y%m%d') ";
	} else if($_REQUEST['st_time'] != "" && $_REQUEST['end_time'] != "") {
		$whr .= " AND (DATE_FORMAT(STARTED,'%Y%m%d') BETWEEN DATE_FORMAT('".$_REQUEST['st_time']."','%Y%m%d') AND DATE_FORMAT('".$_REQUEST['end_time']."','%Y%m%d')) ";
	}
		
} else {
	$whr = " AND GAME_ID='0' ";	
}
if($tblname !="") {
	
	$perpage = $pagePerRecord;//limit in each page
	$startpoint = ($page * $perpage) - $perpage;
	
	$rowsperpage = 10; // 5 records per page. You can change it.
	$website = $_SERVER['PHP_SELF']."?pname=gamehistory&gameType=".$_REQUEST['gameType']."&gameId=".$_REQUEST['gameId']."&coinType=".$_REQUEST['coinType']."&st_time=".$_REQUEST['st_time']."&end_time=".$_REQUEST['end_time']."&monthly=".$_REQUEST['monthly']."&today=".$_REQUEST['today']; // other arguments if need it.
	$sql = "SELECT * FROM $tblname $whr ";
	$pagination = new CSSPagination($sql, $rowsperpage, $website); // create instance object
	if($_GET['page']>0){
	$pagination->setPage($_GET['page']); // dont change it
	}
	else{
	$pagination->setPage(0); // dont change it
	}
	
	$sqlfull = $sql . 'LIMIT '.$pagination->getLimit() . ", " . $rowsperpage; 
	//echo $sqlfull;
	$result = $dbslave->query($sqlfull);
	$rCnt = mysql_num_rows($result);
	$pagin = $pagination->showPage();
} else {
	$rCnt = 0;	
}
// gameType gameId coinType st_time end_time monthly today
?>
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="tbl-grid" style=" width:100%;">
  <thead>
      <tr>
        <th><h11>Reference No</h11></th>
        <th><h11>Start Date</h11></th>
        <th><h11>End Date</h11></th>
        <th><h11>Stake</h11></th>
        <th><h11>Win</h11></th>
        <th><h11>Bonus</h11></th>
        <th><h11>Total</h11></th>
        <th><h11>Details</h11></th>
      </tr>
  </thead>
  <tbody>
  <?php
  if($rCnt > 0) {
	  while($row = mysql_fetch_assoc($result)) {
		  @extract($row);
  ?>
  	<tr>
        <td><h12><?php echo $INTERNAL_REFERENCE_NO; ?></h12></td>
        <td><h12><?PHP echo date('Y-m-d',strtotime($STARTED)).'<br />'.date('H:i:s',strtotime($STARTED)); ?></h12></td>
        <td><h12><?PHP echo date('Y-m-d',strtotime($ENDED)).'<br />'.date('H:i:s',strtotime($ENDED)); ?></h12></td>
        <td><h12><?PHP if($STAKE > 0) echo $STAKE; else echo 'FREE'; ?></h12></td>
        <td><h12><?PHP echo $WIN; ?></h12></td>
        <td><h12><?PHP if($BONUS_WIN > 0) echo $BONUS_WIN; else echo $FREE_SPIN_WIN; ?></h12></td>
        <td><h12><?PHP echo $TOTAL_WIN; ?></h12></td>
        <td><a id="goods" href="javascript:parent.jQuery.fancybox.open({href : 'historyswf.php?userid=<?PHP echo $USER_ID; ?>&gtype=<?PHP echo $_REQUEST['gameType']; ?>&gameid=<?PHP echo $GAME_ID; ?>&intRef=<?PHP echo $INTERNAL_REFERENCE_NO; ?>', type : 'iframe', openEffect : 'fade', closeEffect : 'fade', fitToView : false, nextSpeed : 0, prevSpeed : 0});" title="Facebook"><h12>Click Here</h12></a></td>
      </tr>
  <?php
	  }
  } else {
  ?>
    <tr>
    	<td colspan="8"><h12>No Record</h12></td>
    </tr>
  <?php
  } 
  ?>
  </tbody>
</table>
<div style="width:100%;text-align:center">
<div class="pagination">
<table width="100%">
<tr><td style="text-align:center"><?php echo $pagin; ?></td></tr>
</table>
</div>
</div>

</div>
</div>
<div id="Common_Cnt_hdr_txt">
  <h1>Player Game History</h1>
</div>
<div id="Player_Game_History_Wrap">
<form action="history.php" method="post" name="tsearchform" id="tsearchform" >
<div id="Game_Name_wrap">
<div id="Game_Wrap">
<div id="Game_Name_text"><h10>Game Name:</h10></div>
<div id="Game_drop_menu">
    <select name="gameid" id="gameid" class="custom-class1 custom-class2" style="width: 150px;">
        <option value="">Select</option>
        <option value="slotreel5_chumbacash"<?php if($_REQUEST['gameid'] == "slotreel5_chumbacash"){echo "selected";}?>>slotreel5_chumbacash</option>
        <option value="slotreel3_chumbacash"<?php if($_REQUEST['gameid'] == "slotreel3_chumbacash"){echo "selected";}?>>slotreel3_chumbacash</option>
        <option value="roulette_chumbacash"<?php if($_REQUEST['gameid'] == "roulette_chumbacash"){echo "selected";}?>>roulette_chumbacash</option>
        <option value="jacksorbetter_chumbacash"<?php if($_REQUEST['gameid'] == "jacksorbetter_chumbacash"){echo "selected";}?>>jacksorbetter_chumbacash</option>
        <option value="keno_chumbacash"<?php if($_REQUEST['gameid'] == "keno_chumbacash"){echo "selected";}?>>keno_chumbacash</option>
        <option value="scratchcard_chumbacash"<?php if($_REQUEST['gameid'] == "scratchcard_chumbacash"){echo "selected";}?>>scratchcard_chumbacash</option>
        <option value="bingo_gold"<?php if($_REQUEST['gameid'] == "bingo_gold"){echo "selected";}?>>bingo_gold</option>
    </select>
</div>
</div>
<div id="Game_month_Wrap">
<div id="Game_month_text"><h10>Month:</h10></div>
<div id="Game_month_drop_menu">                    
    <select name="monthly" id="monthly" class="custom-class1 custom-class2" style="width: 80px;"  onchange="return lrchk(this.form);">
        <option value="">Select</option>
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
<div id="Game_today_Wrap">
<div id="Game_today_text"><h10>Today:</h10></div>
<div id="Game_today_drop_menu">
  <input type="checkbox" name="today" id="today" value="1" <?PHP if($_REQUEST['today']=="1" && $_REQUEST['st_time']=="" ) { ?>checked="checked" <?PHP } ?> onclick="return logrep();"/>
</div>
</div>
</div>

<div id="Date_wrap">
<div id="Date_fromto_Wrap">
<div id="Date_Name_text">
  <h10>Start Date:</h10>
</div>
<div id="Date_bg">
<div id="Date_Field">
  <input name="st_time" type="text" class="Date_txtField" id="st_time" value="<?PHP echo $_REQUEST['st_time']; ?>" onfocus="return txt();" size="12" />
</div>
<ul id="Calender_icon">
<li id="Icon_Cal"><a href="javascript://" title=""></a></li>
</ul>


</div>
</div>
<div id="Date_fromto_Wrap">
<div id="Date_Name_text">
  <h10>End  Date:</h10>
</div>
<div id="Date_bg">
<div id="Date_Field">
  <input name="end_time" type="text" class="Date_txtField" id="end_time" size="12" value="<?PHP echo $_REQUEST['end_time']; ?>" onfocus="return txt();" />
</div>
<ul id="Calender_icon">
<li id="Icon_Cal"><a href="javascript://" title=""></a></li>
</ul>


</div>
</div>


</div>

<div id="Btn_Search_Clear_Wrap">
<button value="submit" class="GsearchBtn" type="submit"></button>
<button value="submit" class="GclearBtn" type="button" onclick="window.location='<?php echo ROOT_PATH.'/games/history.html'; ?>';"></button>
</div>

</form>

<div id="Game_Table_Wrap">
<div id="Game_table_hdr_Wrap">
<div id="GT_Game_name_Hdr"><h11>Game Name</h11></div>
<div id="GT_Game_Sdate_Hdr"><h11>Start Date</h11></div>
<div id="GT_Game_Edate_Hdr"><h11>End Date</h11></div>
<div id="GT_Game_Stake_Hdr"><h11>Staked($)</h11></div>
<div id="GT_Game_Win_Hdr"><h11>Win($)</h11></div>
<div id="GT_Game_Lose_Hdr"><h11>Lose($)</h11></div>
</div>
<div id="Game_table_det_wrap">
<div class="scroll-pane">
<div id="Game_table_Sub_Wrap"><h12>No Records Found.</h12></div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div><div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>
<div id="Game_table_Sub_Wrap">
<div id="GT_Game_name_Sub"><h12>Game Name</h12></div>
<div id="GT_Game_Sdate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Edate_Sub"><h12>09/12/2011</h12></div>
<div id="GT_Game_Stake_Sub"><h12>10$</h12></div>
<div id="GT_Game_Win_Sub"><h12>10$</h12></div>
<div id="GT_Game_Lose_Sub"><h12>10$</h12></div>
</div>	
</div>
</div>
</div>
</div>
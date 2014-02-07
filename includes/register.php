<script type="text/javascript">

	$(document).ready( function() {
	
		$("SELECT")
			.selectBox()
			.focus( function() {
				$('#'+$(this).attr('rel')).val($(this).val());
				if($(this).val() != '') {
					$('#Error-'+$(this).attr('rel')).html("");
				}
				//$("#console").append('Focus on ' + $(this).attr('rel') + '<br />');
				//$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
			})
			.blur( function() {
				$('#'+$(this).attr('rel')).val($(this).val());
				if($(this).val() != '') {
					$('#Error-'+$(this).attr('rel')).html("");
				}
				//$("#console").append('Blur on ' + $(this).attr('rel') + '<br />');
				//$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
			})
			.change( function() {				
				$('#'+$(this).attr('rel')).val($(this).val());
				if($(this).val() != '') {
					$('#Error-'+$(this).attr('rel')).html("");
				}
				//$("#console").append('Change on ' + $(this).attr('rel') + ': ' + $(this).val() + '<br />');
				//$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
			});

	});

</script>
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
	
    $("input:text, textarea, input:password").each(function() {
        if (this.value == '') {
            this.value = this.title;
        }
    });

	
	//$("#username").Watermark("User Name");
	$("#fname").Watermark("First Name");
	$("#lname").Watermark("Last Name");
	$("#pass").Watermark("Password");
	$("#cpass").Watermark("Retype Password");
	$("#email").Watermark("E-mail Address");
	$("#cc").Watermark("Promo code");
	$("#vcode").Watermark("Type the characters you see in the box above.");
	
	function notWatermark(value, element){
        return value != element.title;
    }

	// validate signup form on keyup and submit
	$.validator.addMethod("notWatermark", notWatermark, "Field cannot be empty.");
	
	//custom validation rule - age
	
	$.validator.addMethod("ageCheck", function(value, element) {
		
		var day = $("#dobday").val();
		var month = $("#dobmonth").val();
		var year = $("#dobyear").val();
		
		var now = new Date();
 		var mm = $("#dobmonth").val();
 		var dd = $("#dobday").val();
 		var yy = $("#dobyear").val();
		
		bDay = dd + "/" + mm + "/" + yy;
		bD = bDay.split('/');
		
		if (bD.length == 3) {
        	born = new Date(bD[2], bD[1] * 1 - 1, bD[0]);
            years = Math.floor((now.getTime() - born.getTime()) / (365.25 * 24 * 60 * 60 * 1000));
			if (years < 18) {
				return false;
			}
			else if (years = 18 || years > 18) {
				return true;
			}
		}
	}, "Sorry, only persons over the age of 18 may enter this site.");

	// validate signup form on keyup and submit

	var validate = $("#frmsignup").validate({
		//errorLabelContainer: $("div.error"),
		errorElement: "div",
		errorPlacement: function(error, element) {
			error.appendTo('#Error-' + element.attr('id'));
		},
		rules: {
			/*username: {
				required: true,
				notWatermark: true,
				remote: "validations.php?var=user&fldname=username&sid="+Math.random()
			},*/
			fname: {
				required: true,
				notWatermark: true
			},
			lname: {
				required: true,
				notWatermark: true
			},
			pass: {
				required: true,
				notWatermark: true,
				remote: "validations.php?var=password&fldname=pass&sid="+Math.random()
			},
			cpass: {
				required: true,
				notWatermark: true,
				equalTo: "#pass",
				remote: "validations.php?var=rpassword&fldname=cpass&sid="+Math.random()
			},
			email: {
				required: true,
				notWatermark: true,
				remote: "validations.php?var=email&fldname=email&sid="+Math.random()
			},
			dobmonth: {
				required: true,
				remote: "validations.php?var=month&fldname=dobmonth&sid="+Math.random()
			},
			dobday: {
				required: true,
				remote: "validations.php?var=day&fldname=dobday&sid="+Math.random()
			},
			dobyear: {
				required: true,
				remote: "validations.php?var=year&fldname=dobyear&sid="+Math.random(),
				ageCheck:true
			},
			gender: {
				required: true
			},
			country: {
				required: true,
				remote: "validations.php?var=try&fldname=country&sid="+Math.random()
			},
			cc: {
				//notWatermark: true,
				remote: "validations.php?var=camp&fldname=cc&sid="+Math.random()
			},
			vcode: {
				required: true,
				notWatermark: true,
				remote: "validations.php?var=vcode&fldname=vcode&sid="+Math.random()
			},
			/*grules: {
				required: true,
				remote: "validations.php?var=rules&fldname=grules&sid="+Math.random()
			},*/
			gterms: {
				required: true,
				remote: "validations.php?var=terms&fldname=gterms&sid="+Math.random()
			}
		},
		//dobmonth dobday dobyear country cc grules gterms
		messages: {
			/*username: {
				required: "Enter Username",
				notWatermark: "Enter Username",
				remote: jQuery.format("{0}")
			},*/
			fname: {
				required: "Enter Firstname",
				notWatermark: "Enter Firstname",
				remote: jQuery.format("{0}")
			},
			lname: {
				required: "Enter Lastname",
				notWatermark: "Enter Lastname",
				remote: jQuery.format("{0}")
			},
			pass: {
				required: "Enter Password",
				notWatermark: "Enter Password",
				remote: jQuery.format("{0}")
			},
			cpass: {
				required: "Enter Confirm Password",
				notWatermark: "Enter Confirm Password",
				remote: jQuery.format("{0}"),
				equalTo: "Password Mismatch"
			},
			email: {
				required: "Enter Email",
				notWatermark: "Enter Email",
				remote: jQuery.format("{0}")
			},
			dobmonth: {
				required: " Select Month ",
				remote: jQuery.format("{0}")
			},
			dobday: {
				required: " Select Day ",
				remote: jQuery.format("{0}")
			},
			dobyear: {
				required: " Select Year ",
				ageCheck: "Sorry, only persons over the age of 18 may enter this site.",
				remote: jQuery.format("{0}")
			},
			gender: {
				required: "Select Gender",
				remote: jQuery.format("{0}")
			},
			country: {
				required: "Select Country",
				remote: jQuery.format("{0}")
			},
			cc: {
				//notWatermark: "Enter Promo Code",
				remote: jQuery.format("{0}")
			},
			vcode: {
				required: "Enter Verification code",
				notWatermark: "Enter Verification code",
				remote: jQuery.format("{0}")
			},
			/*grules: {
				required: "Please agree Game Rules",
				remote: jQuery.format("{0}")
			},*/
			gterms: {
				required: "Please agree the Terms & Use",
				remote: jQuery.format("{0}")
			}
		}
		// specifying a submitHandler prevents the default submit, good for the demo
		/*submitHandler: function() {
			alert("submitted!");
		}*/
	});
	//$('.watermark_ot').watermark('watermark');

});

function ccc() {	
alert($('#dobmonth').val()+$('#dobday').val()+$('#dobyear').val()+$('#country').val());
}
</script>
<style>
.selectBox-dropdown { position: relative; cursor: default; background-position: left top; height: 30px;  padding-top: 5px; font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif; font-size:18px; color:#808080; }
.selectBox-dropdown .selectBox-label { padding: 2px 8px; display: inline-block; white-space: nowrap; overflow: hidden; font-size:18px; }
.selectBox-dropdown .selectBox-arrow { position: absolute; top: 0; right: 0; width: 23px; height: 100%; background: url(images/combo_arrow_down.png) top center no-repeat;  }
.selectBox-dropdown-menu { position: absolute; z-index: 99999; max-height: 200px; min-height: 1em; border: solid 1px #BBB; -moz-box-shadow: 0 2px 6px rgba(0, 0, 0, .2); -webkit-box-shadow: 0 2px 6px rgba(0, 0, 0, .2); box-shadow: 0 2px 6px rgba(0, 0, 0, .2); overflow: auto; font-family: 'CaeciliaLTStd85Heavy', Arial, sans-serif; font-size:18px; color:#808080; background-color: #e5e5e5; }
</style>
<?php
$month = array(array("01","Jan"),array("02","Feb"),array("03","Mar"),array("04","Apr"),array("05","May"),array("06","Jun"),array("07","Jul"),array("08","Aug"),array("09","Sep"),array("10","Oct"),array("11","Nov"),array("12","Dec"));
$currentyear=date("Y");
?>
<div id="Hdr_Register">Register</div>
<ul id="RegError_wrap">
<!--<li id="RegError_Txt"></li>-->
</ul>
<div class="error11" id="RegError_Txt" style="text-align:left; margin:0px 40px 10px 40px; display:none; clear:both;">
</div>
<div id="Reg_Fields_Wrap">
<form class="frmpro" id="frmsignup" action="regact.php" method="post">
<!--<input type="hidden" name="u" value="<?php echo $_GET['u']; ?>" />
<input type="hidden" name="v" value="<?php echo $_GET['v']; ?>" />
<input type="hidden" name="t" value="<?php echo $_GET['t']; ?>" />
--><!--<div class="Reg_UsrName">
  <input name="username" type="text" class="text_field_big watermark_ot" id="username" value="" title="User Name" maxlength="15" autocomplete="off" />
  <div class="ErrorBig" id="Error-username"></div>
</div>-->
<div class="Reg_Password">
  <input name="fname" type="text" class="text_field_small_pass watermark_ot" id="fname" value="" title="First Name" maxlength="15" tabindex="1" />
  <div class="ErrorSmall" id="Error-fname"></div>
</div>

<div class="Reg_CPassword">
  <input name="lname" type="text" class="text_field_small_pass watermark_ot" id="lname" value="" title="Last Name" maxlength="15" tabindex="2"/>
  <div class="ErrorSmall" id="Error-lname"></div>
</div>
<div style="clear:both;"></div>
<div class="Reg_Password">
  <input name="pass" type="password" class="text_field_small_pass watermark_ot" id="pass" value="" title="Password" onfocus="this.type='password'; this.style.color='#000';" maxlength="15" tabindex="3"/>
  <div class="ErrorSmall" id="Error-pass"></div>
</div>

<div class="Reg_CPassword">
  <input name="cpass" type="password" class="text_field_small_pass watermark_ot" id="cpass" value="" title="Retype Password" onfocus="this.type='password'; this.style.color='#000';" maxlength="15" tabindex="4"/>
  <div class="ErrorSmall" id="Error-cpass"></div>
</div>

<div class="Reg_Email">
  <?php
  if($_REQUEST['e']=="" || $_REQUEST['usrx']=="")
  {
  ?>
 	 <input name="email" type="text" class="text_field_big watermark_ot" id="email" value="" title="E-mail Address" autocomplete="off"  tabindex="5"/>
  	 <div class="ErrorBig" id="Error-email"></div>
  <?php
  }
  else
  {
  ?>
   	<input name="email" type="text" class="text_field_big watermark_ot" id="email" value="<?php echo $_REQUEST['e'];?>" readonly="readonly" title="E-mail Address" autocomplete="off" tabindex="5"/>
  	<div class="ErrorBig" id="Error-email"></div>  
  <?php
  }
  ?>
</div>
<input type="text" name="dobmonth" id="dobmonth" value="" style="visibility:hidden; height:1px; width:1px;" />
<input type="text" name="dobday" id="dobday" value="" style="visibility:hidden; height:1px; width:1px;" />
<input type="text" name="dobyear" id="dobyear" value="" style="visibility:hidden; height:1px; width:1px;" />
<input type="text" name="country" id="country" value="" style="visibility:hidden; height:1px; width:1px;" />
<input type="text" name="gender" id="gender" value="" style="visibility:hidden; height:1px; width:1px;" />
<div style="clear:both; height:1px;"></div>
<div class="DOBWrap">
<div id="Reg_DOBxtx">Birthday</div>
<div id="Reg_DOB_Wrap">
    <select id="dobmonth_dup" name="dobmonth_dup" class="custom-class1 custom-class2" style="width: 68px;" rel="dobmonth" tabindex="6">
    <option value="">mm</option>
    <?php for($i=0; $i<12; $i++) { ?>
    <option value="<?PHP echo $month[$i][0];?>"><?PHP echo $month[$i][0]; ?></option> 
    <?php } ?>
    </select>
</div>
<div id="Reg_DOB01_Wrap">
    <select id="dobday_dup" name="dobday_dup" class="custom-class1 custom-class2" style="width: 60px;" rel="dobday" tabindex="7">
    <option value="">dd</option>
    <?php for($i=1; $i<32; $i++) { ?>
    <option value="<?PHP echo $i;?>"><?PHP echo $i; ?></option> 
    <?php } ?>    
    </select>
             
</div>
<div id="Reg_DOB02_Wrap">
    <select id="dobyear_dup" name="dobyear_dup" class="custom-class1 custom-class2" style="width: 77px;" rel="dobyear" tabindex="8">
    <option value="">yy</option>
    <?php for($i=$currentyear-18; $i>1910; $i--) { ?>
    <option value="<?php echo $i ;?>"> <?php echo $i; ?> </option>
    <?php } ?>
    </select>              
</div>
<div class="ErrorDOB_yy" id="Error-dobyear"></div>
<div class="ErrorDOB_dd" id="Error-dobday"></div>
<div class="ErrorDOB_mm" id="Error-dobmonth"></div>
</div>

<div class="DOBWrap">
<div id="Reg_DOBxtx">Gender</div>
<div id="Reg_Gender_Wrap">
   <select id="gendery_dup" name="gender_dup" class="custom-class1 custom-class2" style="width: 130px;" rel="gender" tabindex="9">
    <option value="">Gender</option>
    <option value="male">Male</option>
    <option value="female">Female</option>
    </select>
</div>

<div class="ErrorDOB" id="Error-gender"></div>
</div>
<div id="Reg_country_Wrap">
    <select id="country_dup" name="country_dup" class="custom-class1 custom-class2" style="width: 430px;" rel="country" tabindex="10">
    <option value="">Country</option>
    <?php
    $sqlCountry = $dbslave->query("SELECT * FROM countries where CountryID!='169' order by CountryName");
    while ($row = mysql_fetch_array($sqlCountry)) {
    ?>
    <option value="<?php echo $row['CountryName'];?>"><?php echo $row['CountryName'];?></option>
    <?php } ?>
    </select>         
</div>
<div class="ErrorCountry" id="Error-country"></div>
<div class="Reg_Promo" style=" margin-bottom:2px;">
<?php
if(isset($_GET['cc']))
 {
?>
	<input type="hidden" name="cc" id="cc" value="<?php echo $_REQUEST['cc'];?>" class="text_field_big watermark_ot" />
	<input type="hidden" name="USR" id="USR" value="<?PHP echo $_REQUEST['usrx'];?>" />
<?php
}
else
{
?>
  <input name="cc" type="text" class="text_field_big watermark_ot" id="cc" value="" tabindex="11"/>
  <div class="ErrorBig" id="Error-cc" ></div>
<?php
}
?> 
</div>
<div class="Reg_Optional" style=" float:right; margin-top:0px; text-align:right;">*Optional</div>
<div class="Reg_Optional">Having trouble? <a href="javascript://" class="regLink" onclick="document.getElementById('captcha').src='captcha.php?'+Math.random();  document.getElementById('vcode').focus();" id="change-image">Try new words.</a>
</div>
<div id="Captcha_alert"><!--<h5 class="CapError">Please try again</h5>-->
</div>
<div class="Reg_Captcha"><img src="captcha.php" id="captcha" /></div>
<div class="Reg_CaptchaTxt">
  <input name="vcode" type="text" class="text_field_big watermark_ot" id="vcode" value="" title="Type the characters you see in the box above." tabindex="12"/>
  <div class="ErrorBig" id="Error-vcode"></div>
</div>
<!--<div class="Reg_Rules">
  <input type="checkbox" name="grules" id="grules" tabindex="13"/>
  I have read and agree to the <a href="sitepages.php?pname=5" id="submit" target="_blank" class="regLink">Games Rules</a>
<div class="ErrorBig" id="Error-grules"></div>  
</div>
--><div class="Reg_Rules">
  <input type="checkbox" name="gterms" id="gterms" tabindex="14"/>
  I have read and agree to the <a href="sitepages.php?pname=3" target="_blank" class="regLink">Terms of Use</a>
<div class="ErrorBig" id="Error-gterms"></div>  
</div>
<div id="Btn_SignupWrap">
<button value="submit" class="signupBtn" name="btnregister" type="submit" tabindex="15"></button>
</div>
</form>
</div>
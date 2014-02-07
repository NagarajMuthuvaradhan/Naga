<script type="text/javascript">

jQuery(document).ready(function($) {

jQuery("#email").Watermark("E-mail Address");

function notWatermark(value, element){
	return value != element.title;
}
jQuery.validator.addMethod("notWatermark", notWatermark, "Field cannot be empty.");	
	// validate signup form on keyup and submit
	var validator = jQuery("#frmfbuser").validate({
		errorElement: "div",
		errorPlacement: function(error, element) {
			error.appendTo('#Error-' + element.attr('id'));
		},
		rules: {
			email: {
				required: true,
				notWatermark: true,
				remote: "validations.php?var=emailchkfb&fldname=email&sid="+Math.random()
			}
		},		
		messages: {
			email: {
				required: "Enter Email",
				notWatermark: "Enter Email",
				remote: jQuery.format("{0}")
			}
		},		
		
		// specifying a submitHandler prevents the default submit, good for the demo
		submitHandler: function() {
			//alert("submitted!");
			chkfbemail();
			return false;
		}
		
	});

});
</script>
<div style="text-align:center;padding-top:200px;">
<div style=" margin:auto; padding-top:50px; background:url(images/cc_likepop-logo_BG.png) center no-repeat; width:507px; height:271px;">
<div class="likechumbaemail">"Please enter your Email address"</div>

<div style="padding-left:80px;">
<form class="frmpro" name="frmfbuser" id="frmfbuser" method="post" action=""> 
<input type="hidden" name="chk" id="chk" value="1" /> 
<div class="Reg_Password">
  <input name="email" type="text" class="text_field_small watermarked_ot" id="email" value="" title="E-mail Address" autocomplete="off"/>
  <div class="ErrorBig" id="Error-email"></div>  
</div>
<div id="Btn_SignupWrap">
<button value="submit" class="signupBtn" type="submit"></button>
</div>
</form>
</div>
</div>
</div>
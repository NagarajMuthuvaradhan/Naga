<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo chumba_config("Site name"); ?></title>
<meta name="keywords" content="<?php echo chumba_config("Site keywords"); ?>" />
<meta name="description" content="<?php echo chumba_config("Site description"); ?>" />
<link REL="SHORTCUT ICON" HREF="<?php echo SITE_URL; ?>favicon.ico">
<?php include 'includes/script.php'; ?>

<?php if(curPageName() == 'index.php') { ?>

<script src="js/login.js" type="text/javascript" language="javascript"></script>

<?php } else if(curPageName() == 'avatar.php') { ?>

<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>	

<?php } else if(curPageName() == 'games.php') { ?>

<style type="text/css" id="page-css">	
.scroll-pane { width: 98%; height: 288px; overflow: auto; float: left; font-weight: normal; color: #333333; text-decoration: none; text-align: justify; font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
</style>
<link type="text/css" rel="stylesheet" href="css/jquery-ui-1.8.18.custom.css" />
<link type="text/css" rel="stylesheet" href="css/datepickerui.css" />
<script src="js/jquery.ui.core.js"></script>
<script src="js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="js/jquery.jscrollpane.min.js"></script>
<!-- scripts specific to this demo site -->
<script>
$(function() {
	var dates = $( "#st_time, #end_time" ).datepicker({
		defaultDate: "+1w",
		changeMonth: false,
		numberOfMonths: 2,
		dateFormat: "yy-mm-dd",
		onSelect: function( selectedDate ) {
			var option = this.id == "st_time" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
});
</script>
<link type="text/css" rel="stylesheet" href="css/jquery.HistoryselectBox.css" />
<script type="text/javascript" id="sourcecode">
    $(function()
    {
        var api = $('.scroll-pane').jScrollPane(
            {
                showArrows:true,
                maintainPosition: false
            }
        ).data('jsp');
        
        $('#do-ajax').bind(
            'click',
            function()
            {
                api.getContentPane().load(
                    'ajax_content.html',
                    function()
                    {
                        api.reinitialise();
                    }
                );
                return false;
            }
        );
    });
</script>
<script type="text/javascript">

	$(document).ready( function() {

		$("SELECT")
			.selectBox()
			.focus( function() {
				$("#console").append('Focus on ' + $(this).attr('name') + '<br />');
				$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
			})
			.blur( function() {
				$("#console").append('Blur on ' + $(this).attr('name') + '<br />');
				$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
			})
			.change( function() {
				$("#console").append('Change on ' + $(this).attr('name') + ': ' + $(this).val() + '<br />');
				$("#console")[0].scrollTop = $("#console")[0].scrollHeight;
			});

	});

</script>

<?php } else if(curPageName() == 'userpages.php') { ?>

<link href="css/ddm.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/customselect.js"></script>

<?php } else if(curPageName() == 'subscription.php') { ?>

<?php } else if(curPageName() == 'pages.php') { ?>

<?php } ?>

</head>
<body>
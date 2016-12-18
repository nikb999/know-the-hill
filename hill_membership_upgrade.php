<?PHP
	require_once("./include/membersite_config.php");

	if(!$hill_func->CheckLogin())
	{
	    $hill_func->RedirectToURL("hill_login.php");
	    exit;
	}
?>

<div id="wrap">

<!-- Site header is called from site-header file -->
<?php include('site_header.php');?>

<!-- Main document commands here -->
				           
<div id="body_sty">


	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
	<head>
	      <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
	      <title>Change password</title>
	      <link rel="STYLESHEET" type="text/css" href="style/hillcss.css" />
	      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
	      <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />
	      <script src="scripts/pwdwidget.js" type="text/javascript"></script>       
	</head>
	<body>

	<h2>Upgrade Membership</h2>

	<p>Click below to upgrade your membership to the Premier Level. </p>
	<p>You can choose to pay either on a monthly basis or an annual basis.</p>
	<h3>Save 50% by choosing the annual payment option.</h3>
	<p>We use Paypal to securely accept payments.  After your payment is accepted, you will receive an email confirming the membership upgrade.  Please allow upto 12 hours for the upgrade to be effective. </p>
	
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
		<input type="hidden" name="cmd" value="_s-xclick">
		<input type="hidden" name="hosted_button_id" value="6BM5MZEBCKSW2">
		<table>
		<tr><td><input type="hidden" name="on0" value="Payment Options:">Payment Options:</td></tr><tr><td><select name="os0">
			<option value="Monthly Option">Monthly Option: $15.00 USD - monthly</option>
			<option value="Annual Option">Annual Option: $120.00 USD - yearly</option>
		</select> </td></tr>
		</table>
		<input type="hidden" name="currency_code" value="USD">
		<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
		<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
	</form>

	<!--
	Form Code End (see html-form-guide.com for more info.)
	-->

	</body>
	</html>
	
	
<!-- put in the code for right box and footer -->

</div>
	

<div id="rightbox_sty">
		<?php
			//test the system execute command
			echo exec('pwd');
			include('right_box_text.php');
		?>
</div>
 
<!-- Site footer is called from site-footer file -->
<?php include('site_footer.php');?>

</div>


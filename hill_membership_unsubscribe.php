<?PHP
	require_once("./include/membersite_config.php");
	if(!$hill_func->CheckLogin())
	{
	    $hill_func->RedirectToURL("hill_login.php");
	    exit;
	}
?>


<div id="wrap">
<?php include('site_header.php');?>

<!-- Site header is called from site-header file -->

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

	<h2>Unsubscribe</h2>

	<p>We are sorry that  you are leaving the Premier Membership. </p>
	<p>You are still welcome to use the service as a Basic Member.</p>

	<A HREF="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=HYCA6FGV2DHBW">
	<IMG SRC="https://www.paypalobjects.com/en_US/i/btn/btn_unsubscribe_LG.gif" BORDER="0">
	</A>

	</div>
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


<?php 
	//-- check if_there is a valid_user logged on -->
	if (!isset($_COOKIE[ini_get('session_name')])) 
		{ 
			session_start(); 
		}
?>
<?PHP
	require_once("./include/membersite_config.php");
	if(isset($_POST['submitted']))
	{
	   if($hill_func->RegisterUser())
	   {
		$hill_func->RedirectToURL("thank-you.html");
	   }
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
	      <title>Login</title>
	      <link rel="STYLESHEET" type="text/css" href="style/hillcss.css" />
	      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
	      <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />
	      <script src="scripts/pwdwidget.js" type="text/javascript"></script>       
	</head>
	<body>

	<!-- Form Code Start -->

	<p>If you have already registered, please click to enter the <a href="confirmreg.php">confirmation code</a>.</p><hr/>

<table border="0">
<tr>
<td>
	<div id='hillsite'>
		<form id='register' action='<?php echo $hill_func->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
		<fieldset >
		<legend>Register</legend>

		<input type='hidden' name='submitted' id='submitted' value='1'/>

		<div class='short_explanation'>* required fields</div>
		<input type='text'  class='spmhidip' name='<?php echo $hill_func->GetSpamTrapInputName(); ?>' />

		<div><span class='error'><?php echo $hill_func->GetErrorMessage(); ?></span></div>
		<div class='container'>
		    <label for='name' >Your Full Name*: </label><br/>
		    <input type='text' name='name' id='name' value='<?php echo $hill_func->SafeDisplay('name') ?>' maxlength="50" /><br/>
		    <span id='register_name_errorloc' class='error'></span>
		</div>
		<div class='container'>
		    <label for='email' >Email Address*:</label><br/>
		    <input type='text' name='email' id='email' value='<?php echo $hill_func->SafeDisplay('email') ?>' maxlength="50" /><br/>
		    <span id='register_email_errorloc' class='error'></span>
		</div>
		<div class='container'>
		    <label for='username' >UserName*:</label><br/>
		    <input type='text' name='username' id='username' value='<?php echo $hill_func->SafeDisplay('username') ?>' maxlength="50" /><br/>
		    <span id='register_username_errorloc' class='error'></span>
		</div>

		<div class='container' style='height:80px;'>
		    <label for='password' >Password*:</label><br/>
		    <div class='pwdwidgetdiv' id='thepwddiv' ></div>
		 <noscript> 
		    <input type='password' name='password' id='password' maxlength="50" />
		 </noscript>
		    <span id='register_password_errorloc' class='error' style='clear:both'></span>
		</div>

		<div class='container'>
		    <input type='submit' name='Submit' value='Submit' />
		</div>

		</fieldset>
		</form>
		<!-- client-side Form Validations:
		Uses the excellent form validation script from JavaScript-coder.com-->

		<script type='text/javascript'>
		// <![CDATA[
		    var pwdwidget = new PasswordWidget('thepwddiv','password');
		    pwdwidget.MakePWDWidget();
		    
		    var frmvalidator  = new Validator("register");
		    frmvalidator.EnableOnPageErrorDisplay();
		    frmvalidator.EnableMsgsTogether();
		    frmvalidator.addValidation("name","req","Please provide your name");

		    frmvalidator.addValidation("email","req","Please provide your email address");

		    frmvalidator.addValidation("email","email","Please provide a valid email address");

		    frmvalidator.addValidation("username","req","Please provide a username");
		    
		    frmvalidator.addValidation("password","req","Please provide a password");

		// ]]>
		</script>
	</div>

</td>
<td valign="top">
	<div id='hillsite'>
		<fieldset>
			<legend>Fees</legend>
			<p>Basic registration is free.</p>
			<p>Premier membership costs only $10 per month if you choose the Annual Subscription (50% savings over the monthly subscription).</p>
			<p>Premier membership gets you all the search options.  To subscribe to the Premier membership level, please fill out the Registration form on this page and click on Membership Upgrade link when your basic registration is complete.</p>
		</fieldset>
	</div>
</td>
</tr>
</table>
</div>
	
<!--
Form Code End (see html-form-guide.com for more info.)
-->
</body>
</html>

<div id="rightbox_sty">
		<?php
			//test the system execute command
			//echo exec('pwd');
			include('right_box_text.php');
		?>
</div>
 
<!-- Site footer is called from site-footer file -->
<?php include('site_footer.php');?>

</div>
        


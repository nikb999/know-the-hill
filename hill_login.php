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
	   if($hill_func->Login())
	   {
		//$hill_func->RedirectToURL("login-home.php");
		$hill_func->RedirectToURL("hill_start.php");
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
	</head>
	<body>

	<!-- Form Code Start -->
	<div id='hillsite'>
		<form id='login' action='<?php echo $hill_func->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
		<fieldset >
		<legend>Login</legend>

		<input type='hidden' name='submitted' id='submitted' value='1'/>

		<div class='short_explanation'><p>* required fields</p></div>

		<div><span class='error'><?php echo $hill_func->GetErrorMessage(); ?></span></div>
		<div class='container'>
		    <label for='username' >UserName*:</label><br/>
		    <input type='text' name='username' id='username' value='<?php echo $hill_func->SafeDisplay('username') ?>' maxlength="50" /><br/>
		    <span id='login_username_errorloc' class='error'></span>
		</div>
		<div class='container'>
		    <label for='password' >Password*:</label><br/>
		    <input type='password' name='password' id='password' maxlength="50" /><br/>
		    <span id='login_password_errorloc' class='error'></span>
		</div>

		<div class='container'>
		    <input type='submit' name='Submit' value='Submit' />
		</div>
		<div class='short_explanation'><a href='reset-pwd-req.php'>Forgot Password?</a></div>
		</fieldset>
		</form>

		<!-- client-side Form Validations:
		Uses the excellent form validation script from JavaScript-coder.com-->

		<script type='text/javascript'>
		// <![CDATA[

		    var frmvalidator  = new Validator("login");
		    frmvalidator.EnableOnPageErrorDisplay();
		    frmvalidator.EnableMsgsTogether();

		    frmvalidator.addValidation("username","req","Please provide your username");
		    
		    frmvalidator.addValidation("password","req","Please provide the password");

		// ]]>
		</script>
	</div>
<!--
Form Code End (see html-form-guide.com for more info.)
-->

</div>
	

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
         


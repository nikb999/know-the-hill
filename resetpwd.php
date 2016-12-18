<?php 
	//-- check if_there is a valid_user logged on -->
	if (!isset($_COOKIE[ini_get('session_name')])) 
		{ 
			session_start(); 
		}
?>
<?PHP
require_once("./include/membersite_config.php");

$success = false;
if($hill_func->ResetPassword())
{
    $success=true;
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
      <title>Reset Password</title>
      <link rel="STYLESHEET" type="text/css" href="style/hillcss.css" />
      <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
</head>
<body>
<div id='hillsite_content'>
<?php
if($success){
?>
<h2>Password is Reset Successfully</h2>
Your new password has been sent to your email address.
<?php
}else{
?>
<h2>Error</h2>
<span class='error'><?php echo $hill_func->GetErrorMessage(); ?></span>
<?php
}
?>
</div>


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
         


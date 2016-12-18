<?php 
	//-- check if_there is a valid_user logged on -->
	if (!isset($_COOKIE[ini_get('session_name')])) 
		{ 
			session_start(); 
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
      <title>Thank you!</title>
      <link rel="STYLESHEET" type="text/css" href="style/hillcss.css">
</head>
<body>
<div id='hillsite_content'>
<h2>Thanks for registering!</h2>
<p>Your basic registration is now complete.</p>
<p>You can upgrade your membership by logging in and click on Upgrade Membership on the menu bar.</p>

<p>
<a href='hill_login.php'>Click here to login.</a>
</p>


</div>
</body>
</html>


<!-- section below is for right box and footer -->
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
         


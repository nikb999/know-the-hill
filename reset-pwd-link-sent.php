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


<div id='hillsite_content'>
<h2>Reset password link sent</h2>
An email has been sent to your email address that contains the link to reset the password. 
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
         


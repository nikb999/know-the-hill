<?php 
	//-- check if_there is a valid_user logged on -->
	if (!isset($_COOKIE[ini_get('session_name')])) 
		{ 
			session_start(); 
		}
?>
<div id="wrap">
<?PHP  include('site_header.php');?>
<!-- Site header is called from site-header file -->


<div id="body_sty">

<?PHP include('hill_termsofuse.txt'); ?>

<!-- code for the right box and footer -->
</div>
	

<div id="rightbox_sty">
		<?PHP 
			//test the system execute command
			//echo exec('pwd');
			include('right_box_text.php');
		?>
</div>
  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>
         


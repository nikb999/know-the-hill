<?PHP
	require_once("./include/hill_functions.php");
	if (!isset($_COOKIE[ini_get('session_name')])) 
		{session_start();}
	//-- the lines above check if_there is a valid_user logged on -->
?>

<!-- Form to undertake the search -->
<!-- only run this script is a valid user is logged in -->

<div id="wrap">
<?PHP  include('site_header.php');?>

<!-- main body with the form -->
<!-- Site header is called from site-header file -->

		
<div id="body_sty">
	<!-- Get the data input from a list -->

	<h3>Select the Search Option </h3>
	<p><a href="hill_search_state_agency.php">Search by State and Federal Agency</a><p>
	<p><a href="hill_search_state_committee.php">Search by State and Congressional Committee</a><p>
	
	
</div>

<div id="rightbox_sty">
	<?php include('./right_box_text.php'); ?>
</div>

		
	
<!-- Site footer is called from site-footer file -->
<?php 
		$ft_file = "./site_footer.php";
		include($ft_file);
?>

</div>
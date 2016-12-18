<?PHP
	require_once("./include/membersite_config.php");
	if (!isset($_COOKIE[ini_get('session_name')])) 
		{session_start();}

	if(!$hill_func->CheckLogin())
	{
	    //$hill_func->RedirectToURL("login.php");
	    //exit;
			$redirect_user_to = "hill_login.php";
			$submitbuttontext = "Please Login to Search";		
	}
	else
	{
		if (strtoupper($hill_func->UserType())=="BASIC")
		{
			$max_search_elements = $max_elements_basic;
		}
		else
		{
			$max_search_elements = $max_elements_premier;
		}			
	}
?>
<!-- Form to undertake the search -->
<!-- only run this script is a valid user is logged in -->

<div id="wrap">

<!-- main body with the form -->
<!-- Site header is called from site-header file -->

<?php 
		$hd_file = "./site_header.php";
		//echo $hd_file;
		include($hd_file);
		//main program now
?>
		
<div id="body_sty">
	<p></p>
	<h3>Find the link between your State Representatives and Federal Agencies</h3>
	<p></p>
	<p>Select the State and Federal Agencies below.</p>
	<p></p>
	<p></p>

	<?php
		if ($hill_func->UserType() == "BASIC")
		{
			echo '<p>Basis users are limited to '. $max_elements_basic . ' selection only.</p> <p>Premier users can select up to '.$max_elements_premier.' states or agencies in a single search.</p> <p>To <a href="hill_membership_upgrade.php">Upgrade Membership</a>, please click here.</p>';
			//$redirect_user_to = "hill_membership_upgrade.php";
			//$submitbuttontext = "Upgrade Membership";
			$show_upgrade_mem_button = "YES";
			$redirect_user_to = "hill_search_q_st_ag.php";
			$submitbuttontext = "Submit Query";
		}
		elseif ($hill_func->UserType() == "ADMIN" or $hill_func->UserType() == "PREMIER") 
		{
			$redirect_user_to = "hill_search_q_st_ag.php";
			$submitbuttontext = "Submit Query";
			$show_upgrade_mem_button = "NO";
		}
		
		if (isset($_SESSION['qstag_error']))
		{
			//echo '<div id="hillsite"><span class="error"><p>'.$_SESSION['qstag_error'].'</span></div></p>';
			unset($_SESSION['qstag_error']);

		}
	?>
	
	
	<!-- Get the data input from a list -->
	<form id="datalist" method="post" action="<?PHP echo $redirect_user_to ?>">

		<table>
		<tr>
		<th>State</th><th>Agency</th>
		</tr>
		<tr>
		<td>
			<select multiple="multiple" name="stname[]" size="15">
				<?php include("hill_state_names_only.txt"); ?>
			</select>
		</td>
		<td>
			<select multiple="multiple" name="agencyid[]" size="15">
				<?php include("hill_agency_list_only.txt"); ?>
			</select>		
		</td>
		</tr>
		</table>
		<br>
		<br>
		<input type="reset" value="Reset" />   		
		<input type="submit" value="<?PHP echo $submitbuttontext; ?>" />   
		
	</form>	
    <p>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</p>
 
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


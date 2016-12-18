<?PHP 
	require_once("./include/membersite_config.php");
	//create a variable if the user is already logged in.
	$alreadyloggedin=1;
	if(!$hill_func->CheckLogin())
	{
	    $alreadyloggedin=0;
            $username_for_comment_box=null;
            header('Location:hill_login.php');
	    //exit;
	}
	else
	{
	    $username_for_comment_box=$hill_func->UserFullName();
		if(strtoupper($hill_func->UserType())!="ADMIN")
		{header('Location:hill_login.php');}
	}
	
?>

<div id="wrap">

<!-- Site header is called from site-header file -->
<?PHP  include('site_header.php');?>

<div id="body_sty">

<!-- CODE To PUT A NEW CATEGORY -->

<?PHP 
	//session_start();
	include "./include/hillarticleconfig.php";

	//retrieve the main article 
	if(!isset($_POST['new_catid']) && !isset($_POST['confirm_new_catid']) )
	{
		//if the add_new_article is not set, then show an empty form for adminuser to fill out
		?>
		<!-- code to show the existing article info -->
		<h3>Add New Category</h3>
		<p>Please fill out the details for the new category.</p>		
		<form name="input" action="hill_admin_categories_addnew.php" method="post">
			<p>Category ID: <input type="text" name="new_catid" value="Auto Generated" readonly="readonly" /></p>
			<p>Category: <input type="text" name="new_category" /></p>
			<p>Category Order: <input type="text" name="new_catorder" /></p>
			<input type="submit" value="Submit" />
		</form> 
		<?PHP 
	}
	elseif (isset($_POST['new_catid']) && !isset($_POST['confirm_new_catid'])) 
	{
		//new category has been posted back to the page.
		//show the new info and then ask user to confirm
		?>
		<!-- code to show the new article info -->
		<h3>Confirm New Category</h3>
		<p>Please check out the details for the new category that you entered.</p>
		<form name="input" action="hill_admin_categories_addnew.php" method="post">
			<p>Category ID: <input type="text" name="confirm_new_catid" value="Auto Generated" readonly="readonly" /></p>
			<p>Category: <input type="text" name="confirm_new_category" value="<?PHP echo $_POST['new_category']; ?>" /></p>
			<p>Category Order: <input type="text" name="confirm_new_catorder" value="<?PHP echo $_POST['new_catorder']; ?>" /></p>
			<input type="submit" value="Confirm!" />
		</form> 
		<?PHP 
	}
	elseif (isset($_POST['confirm_new_catid'])) 
	{
		//if you are here -- all conditions good
		$newcategory_query= 	"INSERT INTO categories
						(category, cat_order) 	
					VALUES ('".trim($_POST['confirm_new_category']) ."',
							'".trim($_POST['confirm_new_catorder']) ."') ";
				
		echo $newcategory_query;
		echo '<p>Current date '.date("Y-m-d",time()).'</p>';
		if(!$newcategoryresult = mysql_query($newcategory_query))
		{
			echo '<p>Error in adding the new category: <br/> '.mysql_error().'</p>';
		}
		else
		{
			echo '<p>Update Successfull. <br/>'.$newcategory_query.'</p>';
			//unset the variables
			unset($_POST['new_catid']);
			unset($_POST['new_category']);
			unset($_POST['new_catorder']);
			unset($_POST['confirm_new_catid']);
			unset($_POST['confirm_new_category']);
			unset($_POST['confirm_new_catorder']);
			header('location: hill_admin.php');
		}
	}
	else
	{
		echo '<p>New Catid = '.$_POST['new_catid'].' confirm new catid = '.$_POST['confirm_new_catid'].'</p>';
		echo '<p> Error in putting the new article to the database </p>';
	}
?>





<!-- code for the right box and footer -->
</div>
	

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>

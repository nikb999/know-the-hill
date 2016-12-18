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
		{header('Location:hill_login.php');exit;}
	}
	
?>

<div id="wrap">

<!-- Site header is called from site-header file -->
<?PHP  include('site_header.php');?>

<div id="body_sty">

<!-- CODE To PUT A NEW ARTICLE -->

<?PHP  
	//session_start();
	include "./include/hillarticleconfig.php";

	//retrieve the main article 
	if(!isset($_POST['new_artid']) && !isset($_POST['confirm_new_artid']) )
	{
		//if the add_new_article is not set, then show an empty form for adminuser to fill out
		?>
		<!-- code to show the existing article info -->
		<h3>Add New Article</h3>
		<p>Please fill out the details for the new article.</p>		
		<form name="input" action="hill_admin_articles_addnew.php" method="post">
			<p>Article ID: <input type="text" name="new_artid" value="Auto Generated" readonly="readonly" /></p>
			<p>Author: <input type="text" name="new_name" /></p>
			<p>Title: <br/><textarea name="new_title" rows="2" cols="50"> </textarea></p>
			<p>Main Text/Comments:  <br/><textarea name="new_comments" rows="20" cols="50"> </textarea>  </p>
			<p>Article Summary: <br/><textarea name="new_artsummary" rows="5" cols="50"> </textarea>  </p>
			<p>Date Posted: <input type="text" name="new_date_posted" value="Auto Generated" readonly="readonly" /></p>
			<p>Category ID. Pick one:</p>
				<?PHP  
				$get_categories="SELECT * FROM categories";
				$res_categories=mysql_query($get_categories);
				while($row_cat_xx=mysql_fetch_assoc($res_categories))
				{
					?>
					<input type="radio" name="new_categoryID" value="<?PHP echo $row_cat_xx['catid']; ?>"/><?PHP  echo 'ID '.$row_cat_xx['catid'].': '.$row_cat_xx['category'];?><br/>
					<?PHP  
				}
				?>
			<p>Article Child: <input type="text" name="new_artchild" value="Auto Generated" readonly="readonly" /></p>
			<input type="submit" value="Submit" />
		</form> 
		<?PHP  
	}
	elseif (isset($_POST['new_artid']) && !isset($_POST['confirm_new_artid'])) 
	{
		//echo '<p>New Artid = '.$_POST['new_artid'].'</p>';
		//new article has been posted back to the page.
		//show the new info and then ask user to confirm
		?>
		<!-- code to show the new article info -->
		<h3>Confirm New Article</h3>
		<p>Please check out the details for the new article that you entered.</p>
		<form name="input" action="hill_admin_articles_addnew.php" method="post">
			<p>Article ID: <input type="text" name="confirm_new_artid" value="Auto Generated" readonly="readonly" /></p>
			<p>Author: <input type="text" name="confirm_new_name" value="<?PHP  echo $_POST['new_name']; ?>" /></p>
			<p>Title: <br/> <textarea name="confirm_new_title" rows="2" cols="50"><?PHP  echo $_POST['new_title']; ?></textarea></p>
			<p>Main Text/Comments:<br/><textarea name="confirm_new_comments" rows="20" cols="50"><?PHP  echo $_POST['new_comments']; ?></textarea>  </p>
			<p>Article Summary:  <br/><textarea name="confirm_new_artsummary" rows="5" cols="50"><?PHP  echo $_POST['new_artsummary']; ?></textarea>  </p>
			<p>Date Posted: <input type="text" name="confirm_new_date_posted" value="Auto Generated" readonly="readonly" /></p>
			<p>Category ID: <input type="text" name="confirm_new_categoryID" value="<?PHP  echo $_POST['new_categoryID']; ?>" />  </p>
			<p>Article Child: <input type="text" name="confirm_new_artchild" value="Auto Generated"  readonly="readonly" /></p>
			<input type="submit" value="Confirm!" />
		</form> 
		<?PHP  
	}
	elseif (isset($_POST['confirm_new_artid'])) 
	{
		//echo '<p>New Artid = '.$_POST['new_artid'].'. Confirm new artid = '.$_POST['confirm_new_artid'].'</p>';
		$newarticle_query= 	"INSERT INTO article
						(name,title,comments,art_summary,date_posted,categoryID,artchild) 	
					VALUES ('".trim($hill_func->fix_intext($_POST['confirm_new_name'])) ."',
						'".trim($hill_func->fix_intext($_POST['confirm_new_title'])) ."',
						'".trim($hill_func->fix_intext($_POST['confirm_new_comments'])) ."',
						'".trim($hill_func->fix_intext($_POST['confirm_new_artsummary'])) ."',
						'".date("Y-m-d",time()) ."',
						".$_POST['confirm_new_categoryID'] .",
						0
						) ";
				
		echo $newarticle_query;
		echo '<p>Current date '.date("Y-m-d",time()).'</p>';
		if(!$newarticleresult = mysql_query($newarticle_query))
		{
			echo '<p>Error in adding the new article: <br/> '.mysql_error().'</p>';
		}
		else
		{
			echo '<p>Update Successfull.</p>';
			//unset session variables
			unset($_POST['confirm_new_artid']);
			unset($_POST['confirm_new_name']);
			unset($_POST['confirm_new_title']);
			unset($_POST['confirm_new_comments']);
			unset($_POST['confirm_new_artsummary']);
			unset($_POST['confirm_new_categoryID']);
		}
	}
	else
	{
		echo '<p>New Artid = '.$_POST['new_artid'].' confirm new artid = '.$_POST['confirm_new_artid'].'</p>';
		echo '<p> Error in putting the new article to the database </p>';
	}
?>

<form name="redirect_to_admin" action="hill_admin.php" method="get">
	<input type="submit" value="Return back to Admin Page" />
</form> 



<!-- code for the right box and footer -->
</div>
	

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>

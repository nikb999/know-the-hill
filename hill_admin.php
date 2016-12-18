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
<?php include('site_header.php');?>

<div id="body_sty">



<h2>Hill Administrator Page</h2>
<?php echo '<p>'.date("Y-m-d h:m",time()).' ('.date_default_timezone_get().')</p>';?>

<h3><hr/>Part A:  User Databases</h3>
<p></p>
	<?php
		require_once("./include/membersite_config.php");
		mysql_connect($xhost, $xusername, $xpassword) or die("Line 37 Cannot Connect to DB");
		mysql_select_db($xdb_name) or die("Line 38 Cannot select DB");
		
		$user_query = "SELECT * FROM $xtbl_name"; 
		if (!$result_user_query =  mysql_query($user_query) )
		{
			echo mysql_error();
			echo '<p>Query submitted: '.$user_query.'</p>';
		}
		else
		{
			echo '<p>User database: '.$xdb_name.'--->'.$xtbl_name.'</p>';
			?>
			<table width="100%" border="1" cellspacing="1" div id='smallfont'>
				<tr>
					<th>ID_User</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone Number</th>
					<th>User Name</th>
					<th>Confirm Code</th>
					<th>User Type</th>
					<th>Registration Date</th>
					<th>Last Update</th>
				</tr>
			<?php 
			while ($user_row=mysql_fetch_assoc($result_user_query))
			{
				?>
				<tr>
					<td> <?php echo $user_row['id_user']?></td>
					<td> <?php echo $user_row['name']?></td>
					<td> <?php echo $user_row['email']?></td>
					<td> <?php echo $user_row['phone_number']?></td>
					<td> <?php echo $user_row['username']?></td>
					<td> <?php echo $user_row['confirmcode']?></td>
					<td> <?php echo $user_row['usertype']?></td>
					<td><?php echo $user_row['regisdate']?></td>
					<td><?php echo $user_row['lastupdate']?></td>
				</tr>
				<?php 
			}
			?>
			</table>
			<?php 
		}
	?>

	<!-- Code to ask if ADMIN wants to change any info -->
	<!-- Edit Users-->
	<br/><br/><br/>
	<h3>Edit Users</h3><br/>
	<form name="input" action="hill_admin_users_edit.php" method="post">
		USER ID to Edit: <input type="text" name="user_id_to_edit" size=5/>
		<input type="submit" value="Edit" /><br/><br/>
		<input type="submit" formaction="" value="Delete User - DISABLED" />
		<input type="submit" formaction="register.php" value="Add New User- Do via REGISTER" />
	</form> 

<p>............ In Development .............</p>

<p></p>

<h3><hr/>Part B:  Knowledge Databases</h3>

	<?php
		include "./include/hillarticleconfig.php";
		$getallarticles="SELECT * FROM article ORDER by date_posted ASC";
		$getallcategories="SELECT * FROM categories";
		$resultallcategories=mysql_query($getallcategories);
		
		if(!$resultallarticles = mysql_query($getallarticles))
		{
			echo mysql_error();
		}
		else
		{
			echo '<p>Knowledge database: '.$blogdb.'</p>';
			$numallarticles=mysql_num_rows($resultallarticles);
			//show all the articles info
			//start the table - close off the php loop first.
			?>
			<p>Existing Articles and Comments</p>			
			<!-- first show the categories -->
			<p>Categories</p>
			<table width="100%" border="1" cellspacing="1" div id='smallfont'>
			<tr>
				<th>ID</th>
				<th>Category</th>
				<th>Category Order</th>
			</tr>
			<?php 
			while($row_cat=mysql_fetch_assoc($resultallcategories))
			{
			?>
			<tr>
			<td><?php echo $row_cat['catid'];?></td>
			<td><?php echo $row_cat['category'];?></td>
			<td><?php echo $row_cat['cat_order'];?></td>	
			</tr>
			<?php 
			}
			?></table>

			<!-- now the main articles and their comments -->
			<p>Articles and Comments</p>
			
			<table width="750px" border="1" cellspacing="1" div id='smallfont'>
			<tr>
				<th>ID</th>
				<th>Author</th>
				<th>Title</th>
				<th>Comment (100 chars only)</th>
				<th>Post Date</th>
				<th>Cat</th>
				<th>Art_Child</th>
			</tr>
			<?php 
			while($row_art=mysql_fetch_assoc($resultallarticles))
			{
			?>
			<tr>
			<td><?php echo  $row_art['artid'];?></td>
			<td><?php echo $row_art['name'];?></td>
			<td><?php echo $row_art['title'];?></td>
			<td><?php echo substr($row_art['comments'],0,100);?></td>
			<td><?php echo $row_art['date_posted'];?></td>
			<td><?php echo $row_art['categoryID']?></td>
			<td><?php echo $row_art['artchild']?></td>
			</tr>
			<?php 
			}
			?></table>
			<?php 
		}
	?>

	<!-- Code to ask if ADMIN wants to change any info -->
	<!-- Edit Categories -->
	<br/><br/><br/>
	<h3>Edit Categories and Articles</h3><br/>
	<form name="input" action="hill_admin_categories_edit.php" method="post">
		Category ID to Edit: <input type="text" name="cat_id_to_edit" size=5/>
		<input type="submit" value="Edit" />
	</form>
	<form name="input" action="hill_admin_categories_delete.php" method="post">
		Category ID to Delete: <input type="text" name="cat_id_to_edit" size=5/>
		<input type="submit" value="Delete" />
	</form>
	<form name="input" action="hill_admin_categories_addnew.php" method="post">
		Category ID to ADD new: <input type="hidden" name="cat_id_to_edit" size=5/>
		<input type="submit" value="Add New" />
	</form> 

	<form name="input" action="hill_admin_articles_edit.php" method="post">
		Article ID to Edit: <input type="text" name="art_num_to_edit" size=5/>
		<input type="submit" value="Edit" />
	</form>
	<form name="input" action="hill_admin_articles_delete.php" method="post">
		Article ID to Delete: <input type="text" name="art_num_to_edit" size=5/>
		<input type="submit" value="Delete" />
	</form>
	<form name="input" action="hill_admin_articles_addnew.php" method="post">
		Article ID to ADD new: <input type="hidden" name="art_num_to_edit" size=5/>
		<input type="submit" value="Add New" />
	</form> 


<h3><hr/>Part C:  Congressional Databases</h3>
<p></p>
<p>............ In Development .............</p>
<p></p>

<h3><hr/>Misc</h3>
<h4>Site Mechanics </h4>
		<ul style="margin-left:20px; line-height:150%;">
		<li>Aesthetics </li>
			<ul>	
			<li>Site layout is strightforward.  
				<ul>
				<li>Header at the top, footer at the bottom.</li>
				<li>Main body split as two boxes - text goes on the left and the right box reserved for pictures and ads.</li>
				</ul>
			<li>Color scheme is white with some shading on the header rows.</li>
			<li>Fonts are Arial/Sans-Serif as default for most pages.</li>
			<li>Font color is gray for most text.</li>
			</ul>
			<br/>
		<li>Programming</li>
			<ul>
			<li>Principal script: PHP. </li>
			<li>Database: MySQL. </li>
			<li>Intent is to have pages generated dynamically as much as possible.</li>
			</ul>
			<br/>
		</ul>


<!-- InstanceEnd -->

<!-- code for the right box and footer -->
</div>

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?php include('site_footer.php');?>

</div>
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

<h2>Hill Administrator Page</h2>
<?PHP  echo '<p>'.date("Y-m-d h:m",time()).' ('.date_default_timezone_get().')</p>';?>

<h3><hr/>Part A:  User Databases</h3>
<p></p>
	<?PHP 
		require_once("./include/membersite_config.php");
		mysql_connect($xhost, $xusername, $xpassword) or die("Line 37 Cannot Connect to DB");
		mysql_select_db($xdb_name) or die("Line 38 Cannot select DB");
		
		$user_query = "SELECT * FROM $xdb_name.$xtbl_name"; 
		if (!$result_user_query =  mysql_query($user_query) )
		{
			echo mysql_error();
			echo '<p>Query submitted: '.$user_query.'</p>';
		}
		else
		{
			echo '<p>User database: '.$xdb_name.'--->'.$xtbl_name.'</p>';
			echo '<p>Query submitted: '.$user_query.'</p>';
			$r_u_q = mysql_fetch_array($result_user_query);
			print_r(array_values($r_u_q));
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
			<?PHP 
			while ($user_row=mysql_fetch_assoc($result_user_query))
			{
				?>
				<tr>
					<td><?PHP  echo $user_row['id_user']?></td>
					<td><?PHP  echo $user_row['name']?></td>
					<td><?PHP  echo $user_row['email']?></td>
					<td><?PHP  echo $user_row['phone_number']?></td>
					<td><?PHP  echo $user_row['username']?></td>
					<td><?PHP  echo $user_row['confirmcode']?></td>
					<td><?PHP  echo $user_row['usertype']?></td>
					<td><?PHP  echo $user_row['regisdate']?></td>
					<td><?PHP  echo $user_row['lastupdate']?></td>
				</tr>
				<?PHP 
			}
			?>
			</table>
			<?PHP 
		}
	?>

	<!-- Code to ask if ADMIN wants to change any info -->
	<!-- Edit Users-->
	<br/><br/><br/>
	<h3>Edit Users</h3><br/>
	<form name="input" action="hill_admin_users_edit.php" method="post">
		Category ID to Edit: <input type="text" name="user_id_to_edit" size=5/>
		<input type="submit" value="Edit" /><br/>
		<input type="submit" formaction="" value="Delete User - DISABLED" />
		<input type="submit" formaction="register.php" value="Add New User- Do via REGISTER" />
	</form> 

<p>............ In Development .............</p>

<p></p>

<h3><hr/>Part B:  Knowledge Databases</h3>


<h3><hr/>Part C:  Congressional Databases</h3>
<p></p>
<p>............ In Development .............</p>
<p></p>

<!-- InstanceEnd -->

<!-- code for the right box and footer -->
</div>

<!-- Right box with ads disabled for the admin pages -->  
		  
<!-- Site footer is called from site-footer file -->
<?PHP  include('site_footer.php');?>

</div>
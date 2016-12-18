<?PHP 
	require_once("./include/membersite_config.php");
	//create a variable if the user is already logged in.
	$alreadyloggedin=1;
	if(!$hill_func->CheckLogin())
	{
	    $alreadyloggedin=0;
            $username_for_comment_box=null;
	    //exit;
	}
	else
	{
	    $username_for_comment_box=$hill_func->UserFullName();
	}
?>

<div id="wrap">
<!-- Site header is called from site-header file -->
<?PHP  include('site_header.php');?>

<div id="body_sty">


<?PHP 
	include "./include/hillarticleconfig.php";

	//set some style parameters for comment rows
	$odd_row = "background:rgb(210,210,210);color:black;padding:10px 0 10px 0;";
	$even_row = "background:white;color:rgb(110,110,110);padding:10px 0 10px 0;";
	$comment_to_show=1;
	

	//retrieve the main article 
	if(isset($_GET['aid']))
	{
		$_SESSION['aid']=$_GET['aid'];
		$getarticle="SELECT * FROM article WHERE artid = ".$_GET['aid']." ORDER by date_posted ASC";
		if(!$result = mysql_query($getarticle))
		{
		echo mysql_error();
		}
		else
		{
		$num=mysql_num_rows($result);
		}
		//retrieve all comments made to this article
		$getcomments="SELECT * FROM article WHERE artchild = ".$_GET['aid']." ORDER by date_posted ASC";
		$getcomments_result = mysql_query($getcomments);
		$comment_num=mysql_num_rows($getcomments_result);
	}

	//store a new comment in the database and retrieve all comments.
	if(isset($_POST['theComment']))
	{
		if (strlen($hill_func->Sanitize($_POST['comment']))>0)
		{		
			if (strlen(trim($_POST['name']))==0) {$_POST['name']="Anonymous";}
			$query = "INSERT INTO article SET name='".$hill_func->fix_intext($_POST['name'])."',title='".$hill_func->fix_intext($_POST['theTitle'])."',comments='".$hill_func->fix_intext($_POST['comment'],false)."',";
			$query .="date_posted=NOW(),categoryID='".$_POST['CID']."',artchild='".$_POST['theID']."'";
			if(!mysql_query($query))
			{
				echo mysql_error();
				echo '<p>Comment: '.$_POST['comment'].'</p>';
				echo '<p>Query: '.$query.'</p>';				
				echo '<p>S with true: '.$hill_func->fix_intext($_POST['comment'],true).'</p>';
				echo '<p>S with false: '.$hill_func->fix_intext($_POST['comment'],false).'</p>';
				echo '<p>S with blank: '.$hill_func->fix_intext($_POST['comment']).'</p>';
				echo '<p>Sanitize for SQL function: '.$hill_func->SanitizeforSQL($_POST['comment']).'</p>';
			}
			else
			{
				//getthe article
				$getarticle="SELECT * FROM article WHERE artid = ".$_SESSION['aid']." ORDER by date_posted ASC";
				if(!$result = mysql_query($getarticle))
				{
					echo mysql_error();
				}
				else
				{
					$num=mysql_num_rows($result);
				}
			}
		}
		else
		{
			//echo '<h3>'.$_POST['name'].': Please re-enter your comment</h3>';
		}
		//retrieve all comments made to this article
		$getcomments="SELECT * FROM article WHERE artchild = ".$_SESSION['aid']." ORDER by date_posted ASC";
		$getcomments_result = mysql_query($getcomments);
		$comment_num=mysql_num_rows($getcomments_result);
		//unset the comment variable to avoid posting by reloading the page
		//echo '<p>before unset '.$_POST['theComment'].'</p>';
		unset($_POST['theComment']);
		//echo '<p>after unset '.$_POST['theComment'].'</p>';
	}
?>

<!-- Show the main article and comments in a table -->
<table width="100%" border="0" cellspacing="1">
  <tr>
   <td width="74%" valign="top">    
	    <table width="100%" border="0" cellspacing="1">
		<tr>	</tr>
			<?PHP 
			if(isset($num) && ($num > 0))
			{
			while($row_article=mysql_fetch_assoc($result))
			{
			?>
		<tr>
		  <td>&nbsp;</td>
		</tr>
		<tr class="title">
		  <td><h3> <?PHP  $_SESSION['title']=$row_article['title'];
			  echo $_SESSION['title'];?> </h3> </td>
		</tr>
		<tr>
		  <td><h5>&nbsp;&nbsp;By: <?PHP echo $hill_func->fix_outtext($row_article['name']);?> (<?PHP echo $hill_func->fix_outtext($row_article['date_posted']);?>)</h5></td>
		</tr>
		<tr class="tbody">
		  <td><?PHP echo '<p>'.$hill_func->fix_outtext($row_article['comments']).'</p>';?> </td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		</tr>
		
		<?PHP 
			}
			}
			else
			{
			?>
			<tr>
				<td><p>Could not find this article.</p></td>
			</tr>
			<?PHP  
			}
			?>
	    </table>
		  <br />
		  <br />

	  <!-- table for the bottom part of the comments -->  
	  <table width="100%" border="0" cellspacing="1">
	      
		  <tr>
		  <td class="commentsheader"><hr/><h3>Comments</h3></td>
		</tr>
		    
		<tr>
		  <td>&nbsp;</td>
		</tr>
			<?PHP 
			if(isset($comment_num) && ($comment_num>0)){
			while($row_comments=mysql_fetch_assoc($getcomments_result)){
			?>
		<tr class="tbody">
		  <td style="<?PHP  if ($hill_func->is_even($comment_to_show)) {echo $even_row;} else {echo $odd_row;}?>">
		  	<?PHP  if(strlen(trim($row_comments['name']))==0)
		  		{$comm_name="Anonymous";} 
		  		else {$comm_name=$hill_func->fix_outtext($row_comments['name']);} 
		  	?> 
		  	<?PHP echo $comm_name; ?> (<?PHP echo $row_comments['date_posted']; ?>) posted: &nbsp; &nbsp; &nbsp; &nbsp; <?PHP echo $hill_func->fix_outtext($row_comments['comments'],false); $comment_to_show=$comment_to_show+1;?> 
		  </td>
		</tr>
		
			<?PHP 
			}
			}
			else
			{
			?>
			<tr>
				<td><p>This article does not have any comments.</p></td>
			</tr>
	      		<?PHP  
	      		}
	      		?>
	  </table>

		  <br />
	
		<!-- posting allowed only for logged in users -->
		<?PHP  if ($alreadyloggedin==0)
			{echo '<hr/><h4>Please log in to post your comments.</h4>';}
			else
			{
			?>
				  <form action="hill_articles_comments.php?aid=<?PHP echo $_SESSION['aid']?>" method="post" name="form1">
				  <table width="100%" border="0" cellspacing="1">
				<tr class="commentsheader">
				  <td width="100%"><hr/><h3>Post a comment.</h3>
				  	<br/>Please be civil and do not use inappropriate language.
				  </td>
				 </tr>
				<tr>
				  <td>&nbsp;</td>
				</tr>
				<tr>
				  <td>Name*</td>
				</tr>
				<tr>
				  <td colspan="2"><input name="name" type="text" class="input" id="name" size="45" value="<?PHP echo  $username_for_comment_box?>" />
				    <input type="hidden" name="theID" value="<?PHP echo $_GET['aid']?>" />
			     	    <input type="hidden" name="CID" value="<?PHP echo $_GET['cid']?>" />
				    <input type="hidden" name="theTitle" value="<?PHP echo $_SESSION['title'];?>" /></td>
				  </tr>
				<tr>
				  <td>
					<div id='hillsite'> <div class='short_explanation'>
					  *You can change the name if you don't want the comment to appear with your full name.</td>
					</div></div>
				</tr>
				<tr>
				  <td><span class="style1 style2 style3">Comment</span></td>
				</tr>

				<tr>
				  <td colspan="2"><textarea name="comment" cols="60" rows="9" class="input" id="comment"></textarea></td>
				  </tr>
				<tr>
				  <td colspan="2">&nbsp;</td>
				</tr>
				<tr>
				  <td colspan="2"><input name="theComment" type="submit" class="input" id="theComment" value="Post Comment" /></td>
				</tr>
			
			<?PHP 
			}
		?>
	</table>
		  
		  </form>
		  
		  <!-- InstanceEndEditable -->
   </td>
  </tr>
  
</table>

<!-- InstanceEnd -->




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
         

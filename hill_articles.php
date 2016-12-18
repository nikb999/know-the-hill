<?php 
	//-- check if_there is a valid_user logged on -->
	if (!isset($_COOKIE[ini_get('session_name')])) 
		{ 
			session_start(); 
		}
?>

<!-- Site header is called from site-header file -->

<div id="wrap">
<?PHP  include('site_header.php');?>


<div id="body_sty">
		
<?PHP 
	include "./include/hillarticleconfig.php";
	$query1="Select *, DATE_FORMAT(date_posted,'%W,%d %b %Y') as thedate FROM article INNER JOIN categories ON categoryID=catid WHERE DATE_SUB(CURDATE(),INTERVAL 30 DAY)AND artchild='0' ORDER BY date_posted DESC LIMIT 10 ";
	$blogarticles = mysql_query($query1) or die(mysql_error());
	$num = mysql_num_rows($blogarticles);
	$query_category="SELECT * FROM categories ORDER BY cat_order";
	$q_cat_res=mysql_query($query_category) or die(mysql_error());
	$num_cat = mysql_num_rows($q_cat_res);
	
	//To show what results are available
	//print_r(array_values(mysql_fetch_assoc($q_cat_res)));
	
?>

<!-- Intro to the site -->

	<h2>Lobbying, The Business of Lobbying and Other Related Issues</h2>

<!-- Main document -->

	<!-- option 1 to show data -->
        <p>To contribute an article or to start a new topic within the Discussion Forum, please email the <a href="mailto:editor@knowthehill.com">Editor</a> a copy of the article or discussion forum topic suggestion.</p><br/>       

	<ul>
	<?PHP  while($qcatrow=mysql_fetch_assoc($q_cat_res))
	{
		echo '<br/><li><h3>'.$qcatrow['category'].'</h3></li><br/>';
		?>
		<ul>
		<?PHP  
			$artquery="SELECT * FROM article WHERE categoryID='".$qcatrow['catid']."' AND artchild='0'";
			$artqueryresult=mysql_query($artquery) or die(mysql_error());
			while($row_articles=mysql_fetch_assoc($artqueryresult))
			{
			?>
			<li><p>
				<a href="hill_articles_comments.php?aid=<?PHP echo $row_articles['artid'];?>&cid=<?PHP echo $row_articles['categoryID'];?>"> <?PHP echo $row_articles['title'];?></a> &nbsp;&nbsp;  
				(<?PHP   
				$getcomments = "SELECT * FROM article WHERE artchild='".$row_articles['artid']."'";
				if(!$theResult=mysql_query($getcomments))
					{
						echo mysql_error();
					}
					else
					{
						$num_comments=mysql_num_rows($theResult);
						echo $num_comments;
					}
					?>
				Comments)
			</p></li>
			<?PHP 
			}
			?>
		</ul>
	<?PHP 
	}	
	?>
	</ul>


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
         


<?php 
	//-- check if_there is a valid_user logged on -->
	if (!isset($_COOKIE[ini_get('session_name')])) 
		{ 
			session_start(); 
		}
?>

<div id="wrap">

<!-- Site header is called from site-header file -->
<?php include('site_header.php');?>

<div id="body_sty">
		
	<!-- Intro to the site -->

		<h3>About This Site</h3>
		<p>
		A key challenge facing Government Relations (GR) professionals is to
		determine who in Congress is the right person to talk to regarding
		issues that are important to th GR person.  These could be related to
		the particular US Government agency that the GR person's firm does
		business with and/or specific legislation consideration that can
		affect the GR person's firm/interests.
		</p>

		<p>
		This task of identifying the right audience has typically been the
		purveiw of lobbyists and other professional organziations.  A GR
		professional working for a private business often relies on such
		lobbying assistance and pay a substantial sum in fees and retainers to
		engage the lobbyists.
		</p>

		<p>
		This site is intended to assist the GR Professional to start
		identifying the key Senators and Representatives who have a
		disproportional influence on the business interests that the GR
		professional is supporting.   The Senators and Representatives have
		this influence via their membership to the Congressional Committees
		that provide oversight to the Federal Agencies.
		</p>

		<p>
		The site does not replace the important role that professional
		lobbyists play.  The site seeks to provide an alternative mechanisms
		and tools to the GR Professional to better educate themselves on the
		inter-relationships between the Legislative Branch and the Executive
		Branch of the US Government.
		</p>

		<p>
		The site navigation bars provide the links within the site that are
		self explanatory.  To explore the links between the Executive Branch
		and Legislative Branch, please click on HILLQUERY tab on the
		navigation bar.
		</p>

		<br/>
		<h3>Credits</h3>
		<ul style="margin-left:20px; line-height:150%;">
		<li>Data Sources</li>
			<ul>
			<li>FedSYS (www.gpo.gov): for data relating to committee hearings. </li>
			<li>GovTrack (www.govtrack.us): for data on committee assignments.  Great site with a lot of useful information.</li>
			</ul>
		<li>Pictures</li>
			<ul>
			<li>National Park Service (www.nps.gov)</li>
			<li>NASA (nix.nasa.gov)</li>
			<li>www.clker.com</li>
			</ul>
			<br/>
		</ul>

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
         


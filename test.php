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

<?PHP include('site_header.php');?>

 <html>
    <head>
      <title>My Facebook Login Page</title>
    </head>
    <body>
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            appId      : '216288108492646',
            status     : true, 
            cookie     : true,
            xfbml      : true,
            oauth      : true,
          });
        };
        (function(d){
           var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
           js = d.createElement('script'); js.id = id; js.async = true;
           js.src = "//connect.facebook.net/en_US/all.js";
           d.getElementsByTagName('head')[0].appendChild(js);
         }(document));
      </script>
      <div class="fb-login-button" scope="email">Login with Facebook</div>
    </body>
 </html>

 

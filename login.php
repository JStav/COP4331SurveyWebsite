<?php include('mysql_adapter.php'); ?>

<?php
function clearCookies()
{
		// nuke the cookies
		setcookie("user_id", "", time()-3600);
		setcookie("email", "", time()-3600);
		setcookie("first_name", "", time()-3600);
		setcookie("last_name", "", time()-3600);
	
}
// Clear cookie check
if($_GET["logout"]==1)
{
	clearCookies();
}
$user_id = $_COOKIE['user_id'];
if(isset($user_id) && $user_id > 0)
{
	// Valid user then!
	//echo "Cookie value = " . $_COOKIE['user_id'];
	//echo 'Hello ' . $first_name . ' ' . $last_name . ' ( <a href="mailto:' . $email . '">' . $email . '</a> ) ';
	//echo '<a href="./login2.php?logout=1">logout</a>';
	// Already logged in, don't display this page
	header("Location: surveylist.php");
	die();
}

?>

<?php

//print_r($_POST);
//if(isset($_POST['userid']) && isset($_POST['pswrd']))  // apparently isset is true if teh value is "" hrm...
if($_POST['userid'] != "" && $_POST['pswrd'] != "") 
{ 

    $user = $_POST['userid'];
	$pass = $_POST['pswrd'];
	// Check password in DB
	$pass = md5($pass);
	
	$query = "select * from users where email = '" . $user . "' and password = '" . $pass . "'";
	//print_r("<p><p><p>");
	//print_r($query);
	//print_r("<p><p><p>");
	$result = run_query($query);
	// TODO: refactor this if time permits.
	$num_rows = mysql_num_rows($result); // really lame way to authenticate, but it's almost midnight and time is a factor tonight.
	$row = mysql_fetch_array($result);
	$user_id = $row["user_id"];
	
	if($num_rows > 0)
	{
		setcookie("user_id", $row["user_id"], time()+3600);  /* expire in 1 hour */
		setcookie("email", $row["email"], time()+3600);  /* expire in 1 hour */
		setcookie("first_name", $row["first_name"], time()+3600);  /* expire in 1 hour */
		setcookie("last_name", $row["last_name"], time()+3600);  /* expire in 1 hour */
		header("Location: surveylist.php");
		die();
	}
	else
	{
		echo "Bad Login!";
		clearCookies();
	}
	// Set Cookie (php has built in functions for this)
	// redirect to surveys page.
	
	
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sweet Survey</title>
</head>

<body>
<header id="top">
  <h1>Welcome to Sweet Surveys!</h1>
  <article id="main">
    <p>Here at Sweet Surveys, we like to have all of the places where we should have actual information filled with useless text for our noob web designer!</p>
    <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum</p>
  </article>
</header>
<aside id="login">
<h1> Login </h1>
<?php echo $current_path; ?>
  <form name="login" id="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            Username<input type="text" name="userid" id="userid" />
            Password<input type="password" name="pswrd" id="pswrd" />
            <!-- <input type="submit" onclick="check(this.form)" value="Login"/> -->
			<input type="submit" id="submit" value="Login"/>
            <input type="reset" value="Clear"/>
        </form>

  </aside>
 <aside id="signup">
<h1> Don't have an account? <a href="signup.php"> Sign up! </a></h1>
 </aside> 
</body>
</html>

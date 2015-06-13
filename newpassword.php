<?php include('mysql_adapter.php'); ?>

<?php
nice_print_r($_POST);
nice_print_r($_GET);
$user_id = $_GET['user_id'];
if($user_id == ""){$user_id = $_POST["user_id"];}

$token = $_GET['token_id'];
if($token == ""){$token = $_POST["token"];}

nice_print_r($user_id);
$newpswrd = $_POST['pswrd'];
$confirmpswrd = $_POST['confirmpswrd'];

if($newpswrd == "" || $confirmpswrd == "")
{
	// do nothing, display the page
	echo "null";
}
else if($newpswrd == $confirmpswrd)
{
	// perform logic
	$user_id = sanitize_value($user_id);
	$query = "select * from users where user_id = " . $user_id;
	$results = run_query($query);
	$row = mysql_fetch_array($results);
	$token2 = md5($row['email']) . "R12245";

	if($token == $token2)
	{
		$query = "UPDATE users SET password = '" . md5(sanitize_value($newpswrd)) . "' WHERE user_id = " . $user_id;
		$results = run_query($query);
		header("Location: login.php");
		die();
	
	}
	else
	{
		echo "Bad Token: ";// . $token . " vs " . $token2;
	}
}	
else
{
// passwords don't match msg
	echo "<p>Passwords do not match</p>";
}


?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>New Password</title>
</head>
<header>
<h1> Account Recovery </h1>
<form name="newPswrdForm" id="newPswrdForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
New Password <input type="password" name="pswrd" id="pswrd"/>
Confirm New Password <input type="password" name="confirmpswrd" id="confirmpswrd"/>
<input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
<input type="hidden" id="token" name="token" value="<?php echo $token; ?>">
<input type="submit" value="Submit"/>
</form>
</header>
<body>
</body>
</html>

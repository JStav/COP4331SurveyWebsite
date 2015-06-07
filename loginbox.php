<?php 
// TODO: This needs to be put into a separate php include for the login box and stuff
// ---- This is currently just a demo page showing login functionality.

// Confirm cookie exists:
$user_id = $_COOKIE['user_id'];
$email = $_COOKIE['email'];
$first_name = $_COOKIE['first_name'];
$last_name = $_COOKIE['last_name'];
if(isset($user_id) && $user_id > 0)
{
	$user_id = (int) $user_id; // recast as int
	// Valid user then!
	//echo "Cookie value = " . $_COOKIE['user_id'];
	echo 'Hello ' . $first_name . ' ' . $last_name . ' ( <a href="mailto:' . $email . '">' . $email . '</a> ) ';
	echo '<a href="./login.php?logout=1">logout</a>';
}
else
{
	header("Location: login.php");
	die();
}

?>
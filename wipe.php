<?php include('mysql_adapter.php'); ?>
<?php
	$query = array("delete from answers;","delete from question_options;","delete from user_surveys;","delete from questions;","delete from surveys;","delete from users;");
	foreach ($query as &$value)
	{
		$result = mysql_query($value) or die("Database Error: " . mysql_error()); 
	}
	// nuke the cookies
		setcookie("user_id", "", time()-3600);
		setcookie("email", "", time()-3600);
		setcookie("first_name", "", time()-3600);
		setcookie("last_name", "", time()-3600);
	echo "EVERYTHING WIPED!";
	echo '<p><a href="http://jstav.site50.net/will_working_dir/surveylist.php">Go to survey list</a></p>';
?>
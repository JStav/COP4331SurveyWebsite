<?php include('mysql_adapter.php'); ?>
<?php
	$query = "DELETE FROM `answers` where user_id = 1";
	$result = mysql_query($query) or die("Database Error: " . mysql_error()); 
	echo "ANSWERS TABLE WIPED!";
	echo '<p><a href="http://jstav.site50.net/will_working_dir/surveylist.php">Go to survey list</a></p>';
?>
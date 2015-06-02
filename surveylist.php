<?php include('mysql_adapter.php'); ?>
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
	// Valid user then!
	//echo "Cookie value = " . $_COOKIE['user_id'];
	echo 'Hello ' . $first_name . ' ' . $last_name . ' ( <a href="mailto:' . $email . '">' . $email . '</a> ) ';
	echo '<a href="#">logout</a>';
}
else
{
	header("Location: login2.php");
	die();
}

?>

<?php
// Query Data
$query = "SELECT * FROM surveys";
?>

<?php
// Get all the data
$result = mysql_query($query) or die("Database Error: " . mysql_error()); 
?>

<!--Processes of Object Oriented Software Project 1-->
<!--Survey List Page-->
<!DOCTYPE html>
<html lang="en-US">

<head>
  <title>Survey List</title>
  <meta charset="UTF-8">
	
</head>


<body>

<h1>Survey List </h1>
<p> </p>

<table id="surveys" style="width:100%">
	<tr>
		<th>Survey Name</th>
		<th colspan="3"> </th>
	</tr>
		<?php
			while($row = mysql_fetch_array($result)) 
			{
				echo '<tr>';
				echo '<td>'. $row['survey_name'] .'</td><td><a href="surveypage.php?survey_id="'. $row['survey_id'] .'">Take Survey</a></td><td><a href="surveyresults.php?survey_id="'. $row['survey_id'] .'">View Results</a></td>';
				echo '</tr>';
			}
		?>
</table>

<br>
<br>

<form action="">
<input type="submit" value="New Survey">
</form>

<br><br><br><br>

<footer>
	Robert Simon, William Mollenkopf, Richard DiBacco, Jason Stavrinaky
</footer>

</body>
</html>
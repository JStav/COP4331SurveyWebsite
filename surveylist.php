<?php include('mysql_adapter.php'); ?>

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
<?php

$current_path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']);

 include('mysql_adapter.php'); ?>
 
 
 <?php
 //print_r($_GET);
 $survey_id = $_GET["survey_id"];
 if(!isset($survey_id)){die("Error.");} // fail the page if it doesn't have a survey_id
 $question_id = -1; // preset to something not possible as a future lockout
 
 if(isset($_GET["question_id"])){$question_id = $_GET["question_id"];}
 else
 {
	$query0 = "select question_id from questions where survey_id = " . $survey_id . " order by question_id asc";
	//print_r($query0);
	$result0 = mysql_query($query0) or die("Database Error0: " . mysql_error()); 
	$row0 = mysql_fetch_array($result0);
	$question_id = $row0["question_id"];
 }
 
 // TODO: Add binding of php variable to avoid php injections
 $query = "
 select *
 from questions
 where survey_id = " . $survey_id . " and question_id = " . $question_id;
 //print_r($query);
 
 // Get the data
 $result = mysql_query($query) or die("Database Error1: " . mysql_error()); 
 $row = mysql_fetch_array($result);
 
 // check if it's not a fill in the blank type question
 if($row["question_id"]!=3) // that hardcoding tho...
 {
	$query2 = "select * from question_options where question_id = " . $question_id . " order by option_id asc";
	$result2 = mysql_query($query2) or die("Database Error2: " . mysql_error()); 
 }

 
 // Need another query to populate previously answered questions
 
 ?>
<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Take Survey</title>
	<meta charset="UTF-8">

</head>

<body>

	<form id="takeSurveyForm">
	Question: <span id="questionNumber"><?php echo $row["question_id"]; ?></span> 
	<!--Load question number above-->
	<br>
	
	<div id="questionText"><?php echo $row["question_text"]; ?></div>
	<!--Load question Text here-->
	
	<div id="questionAnswerChoices">
	
	<?php
		if($row["question_id"]==3)
		{
			echo '<input type="text" id="answer" name="answer">';
		}
		else
		{
			echo "<table>";
			while($row2 = mysql_fetch_array($result2)) 
			{
				echo '<tr>';
				echo '<td><input type="radio" id="o_id' . $row2['option_id'] . '" value="' . $row2['option_id'] . '"> '. $row2['option_text'] .'</td>';
				echo '</tr>';
			}
			echo "</table>";
		}
	?>
	</div>
	<!--Load question answer choices here-->
	</form> 
	
	<br><br>
	
	 <button type="button" form="takeSurveyForm" onclick="">Next Question</button> 
	 <button type="reset" form="takeSurveyForm">Clear</button>
	 <button type="submit" form="takeSurveyForm">Done</button> 
	
</body>
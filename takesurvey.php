 <?php include('mysql_adapter.php'); ?>
 <?php include('loginbox.php'); ?>
 
 <?php
 $survey_id = $_POST["survey_id"];
 $qtype_id = (int)$_POST["qtype_id"];
 if($survey_id == "")
 {
	$survey_id = $_GET["survey_id"];	 
 }
 if(!isset($survey_id)){die("Error.");} // fail the page if it doesn't have a survey_id
 $question_id = -1; // preset to something not possible as a future lockout
 
 
	// DO NOT RENAME THESE $query0 variable names (it'll break things)
 	$query0 = "select count(question_id) as counter_value, min(question_id) as question_id from questions where survey_id = " . $survey_id . " order by question_id asc";
	$result0 = run_query($query0);
	$row0 = mysql_fetch_array($result0);
	$total_questions = (int)$row0["counter_value"];
	
	// Logic:
	// If we can find an answer for the final question, then this user has already DONE this survey, so return a response saying they have.
	
	$query = "select count(*) as counter_value from answers where user_id = " . $user_id . " and survey_id = " . $survey_id . " and question_id = " . $total_questions . " order by question_id asc";
	$result = run_query($query);
	$row = mysql_fetch_array($result);
	
	$final_output = '<p>Thank you for completing the survey.<br><a href="surveylist.php">Click Here</a> to return to survey list.</p>';
	if((int)$row["counter_value"]>0)
	{
		//nice_print_r((int)$row["counter_value"]);
		die($final_output);
		
	}
	
	if(isset($_POST["question_id"]))
	{
		$question_id = $_POST["question_id"];
		// check to see if next or previous or final submit was used here
		$question_submitted = false;
		$nextBtn =$_POST['nextBtn']; 
		$prevBtn =$_POST['prevBtn']; 
		$finshBtn =$_POST['finshBtn']; 
		if((int)$nextBtn==1 || (int)$prevBtn==-1 || (int)$finshBtn==2)
		{
			$question_submitted = true;
		}
		else
		{
			//echo '<pre>'.print_r($_POST).'</pre>';
			//echo "Button not pressed";
		}
		
		if($question_submitted)
		{
			// if not short answer question
			if($qtype_id != 3)
			{
				$options = $_POST["options"];
				sanitize_value($options);
				if($options == ""){$options = 1;} // defaults to the first option if nothing was selected
				
				$query = "INSERT into answers (question_id, user_id, survey_id, answer) VALUES(".$question_id.",".$user_id.",".$survey_id.",'".$options."')";	
				//echo "<p>NOT QTYPE 3:".$query."</p>";
			}
			else if($qtype_id==3)
			{
				// short answer type			
				$answer = $_POST["answer"];
				sanitize_value($answer);	
				if($answer == ""){$answer = "No response.";}	// defaults to "No Response" if no response is given.
				$query = "INSERT into answers (question_id, user_id, survey_id, answer) VALUES(".$question_id.",".$user_id.",".$survey_id.",'".$answer."')";	
				//echo "<p>QTYPE 3:".$query."</p>";
				//die($query);
			}
			// we need to store the last question in the database
			
			//print_r($query0);
			$result = run_query($query);
			
			if((int)$finshBtn==2)
			{
				die($final_output);
			}
		}
		if((int)$nextBtn==1)
		{
			if($question_id < $total_questions){$question_id++;}
		}
		else if((int)$prevBtn==-1)
		{
			if($question_id <= $total_questions && $question_id > 1){$question_id--;}
		}

		
	}
	else
	{
		$question_id = $row0["question_id"];
		
		
	}

 // TODO: Add binding of php variable to avoid php injections
 $query = "
 select *
 from questions
 where survey_id = " . $survey_id . " and question_id = " . $question_id;
 
 // Get the data
 $result = run_query($query);
 $row = mysql_fetch_array($result);
 
 // check if it's not a fill in the blank type question
 $qtype_id = $row["qtype_id"];
 //nice_print_r($qtype_id);
 if((int)$qtype_id!=3) // that hardcoding tho...
 {
	$query2 = "select * from question_options where question_id = " . $question_id . " order by option_id asc";
	//nice_print_r($query2);
	$result2 = run_query($query2);
	//echo "<p>got question id: " . $question_id . "</p>";
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

	<form name="takeSurveyForm" id="takeSurveyForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	Question: <span id="questionNumber"><?php echo $question_id . " / " . $total_questions; ?></span> 
	<!--Load question number above-->
	<br>
	
	<div id="questionText"><?php echo $row["question_text"]; ?></div>
	<!--Load question Text here-->
	
	<div id="questionAnswerChoices">
	
	<?php
		if($row["qtype_id"]==3)
		{
			echo '<input type="text" id="answer" name="answer">';
		}
		else if($row["qtype_id"]==1)
		{
			echo "<table>";
			echo '<tr><td><input type="radio" name="options" id="o_id1" value="True">True</td></tr>';
			echo '<tr><td><input type="radio" name="options" id="o_id2" value="False">False</td></tr>';
			echo "</table>";
		}
		else if($row["qtype_id"]==2)
		{
			echo "<table>";
			while($row2 = mysql_fetch_array($result2)) 
			{
				echo '<tr>';
				echo '<td><input type="radio" name="options" id="o_id' . $row2['option_id'] . '" value="' . $row2['option_id'] . '"> '. $row2['option_text'] .'</td>';
				echo '</tr>';
			}
			echo "</table>";
		}
	?>
	</div>
	<!--Load question answer choices here-->

	
	<br><br>
	<button type="reset" >Clear</button>
	<input type="hidden" id="survey_id" name="survey_id" value="<?php echo $survey_id; ?>">
	<input type="hidden" id="question_id" name="question_id" value="<?php echo $question_id; ?>">
	<input type="hidden" id="qtype_id" name="qtype_id" value="<?php echo $qtype_id; ?>">
	<?php
	/*
	if($question_id <= $total_questions && $question_id > 1)
	{
		echo '<button type="submit" id="prevBtn" name="prevBtn" value="-1">Previous Question</button> ';
	}
	*/
	if($question_id < $total_questions)
	{
		echo '<button type="submit" id="nextBtn" name="nextBtn"  value="1">Next Question</button> ';
	}
	else
	{
		echo '<button type="submit" id="finshBtn" name="finshBtn"  value="2">Submit Survey</button>';
	}
	?> 
	  
	</form> 
</body>
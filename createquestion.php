<?php include('mysql_adapter.php'); ?><?php include('loginbox.php'); ?>

 <?php
	//print_r($_POST);
 $surveyname = $_POST['surveyname']; // from previous page
 $validSubmission = true; // used as a flag to check that a question option has been filled out properly.
 
 $surveyid = $_POST['surveyid']; // generated from this page after a person clicks add or done button (we only need one or the other, name for brand new, id for rest)
 /*
 if($surveyname == "" && $surveyid == "")
 {
 	die("Error: Survey name is blank");
 }*/
		
if($_POST['questionTextBox'] != "")
{	
	$questionTextBox = $_POST['questionTextBox'];
	$questionType = $_POST['questionType'];
	$choice1 = $_POST['c1'];
	$choice2 = $_POST['c2'];
	$choice3 = $_POST['c3'];
	$choice4 = $_POST['c4'];
	$questionNum = $_POST['questionNum'];
	$surveyid = $_POST['surveyid'];
	//print_r($questionNum);
	//print_r($_POST['questionType']);
	if($questionNum == "" || $surveyid == "")
	{		
		$questionNum = (int) 1;				
		// Force the survey_id by getting the current max id and adding+1
		$query = "SELECT max(survey_id) as survey_id from surveys";
		$result = run_query($query);
 		$row = mysql_fetch_array($result);
		$surveyid = (int) $row["survey_id"];
		$surveyid++; // now add one to it

		// surveys table
		$query = "INSERT into surveys(survey_id, survey_name) VALUES(".$surveyid.",'".$surveyname."')";
		$result = run_query($query);
		
		// user_surveys table
		$query = "INSERT into user_surveys(user_id, survey_id, relation_id) VALUES(".$user_id.",".$surveyid.",1)"; // relation_id = 1 creator
		$result = run_query($query);
	}
	else
	{
		$questionNum = (int) $questionNum;
	}
	if($questionType == "1")
	{		
		// question table
		$query = "INSERT into questions(question_id, survey_id, qtype_id, question_text) VALUES(".$questionNum.",".$surveyid.",1,'".$questionTextBox."')";
		$result = run_query($query);		
		// choice Doesn't matter

	}
	else if($_POST['questionType'] == "2")
	{
		// If any of the choices are blank, it'll flag this as false and won't allow the question to be inserted.
		$validSubmission = ($choice1 != "" && $choice2 != "" && $choice3 != "" && $choice4 != ""); 
		//choices Do matter!
		// question table
		
		
		if($validSubmission)
		{
		$query = "INSERT into questions(question_id, survey_id, qtype_id, question_text) VALUES(".$questionNum.",".$surveyid.",2,'".$questionTextBox."')";
		$result = run_query($query);
		
		// question options table
		$query = "INSERT into question_options(option_id, question_id, survey_id, option_text) VALUES(1, ".$questionNum.",".$surveyid.",'".$choice1."')";
		$result = run_query($query);       
		
		$query = "INSERT into question_options(option_id, question_id, survey_id, option_text) VALUES(2, ".$questionNum.",".$surveyid.",'".$choice2."')";
		$result = run_query($query);  
		
		$query = "INSERT into question_options(option_id, question_id, survey_id, option_text) VALUES(3, ".$questionNum.",".$surveyid.",'".$choice3."')";
		$result = run_query($query);
		
		$query = "INSERT into question_options(option_id, question_id, survey_id, option_text) VALUES(4, ".$questionNum.",".$surveyid.",'".$choice4."')";
		$result = run_query($query);
		}
		else
		{
			echo '<p class="error">Missing text for multiple choice(s).</p>';
		}
	}	
	else if($_POST['questionType'] == "3")
	{
		// choices don't matter
		// question table
		$query = "INSERT into questions(question_id, survey_id, qtype_id, question_text) VALUES(".$questionNum.",".$surveyid.",3,'".$questionTextBox."')";	
		$result = run_query($query);
	}
	
	if(isset($_POST['donebtn']) && $_POST['donebtn']=='Done' && $validSubmission)
	{
		//echo 'donebtn clicked';
		header("Location: surveylist.php");

		die();
	
	}	
	//die();
	//if(isset($_POST['addquestionbtn']) && $_POST['addquestionbtn']=='Add Question'){echo 'addquestionbtn clicked';}
	if($validSubmission){$questionNum++;}
}
else if(isset($_POST['donebtn']) && $_POST['donebtn']=='Done' && $validSubmission)
	{
		//echo 'donebtn clicked';
		header("Location: surveylist.php");

		die();
	
	}	

 ?>
 <!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Create New Question</title>
	<meta charset="UTF-8">
	<script type="text/javascript" src="./js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript">
	function toggleChoices(qtype_id)
	{
		if(qtype_id == 2){$("#choicesDiv").show();}
		else{$("#choicesDiv").hide();}
	}
	var qtype_id = 1;
	$( document ).ready(function()
	{
		console.log( "ready!" );
		$("#questionType").change(function()
		{
			 var qtype_id = $(this).val();
			toggleChoices(qtype_id)
			 //alert("changed to: " + qtype_id);
		});
		// set the default.
		qtype_id=$("#questionType").val();
		toggleChoices(qtype_id)		
	});
	</script>
</head>

<body>

	<form name="newQuestionForm" id="newQuestionForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	Question #<?php if($questionNum==""){echo 1;}else{echo $questionNum;}; ?>: 
	<br>
	<input type="text" name="questionTextBox" id="questionTextBox">
	<br><br>
	Select the type of question: 
	<select name="questionType" id="questionType">
		<option value="1">True or False</option>
		<option value="2">Multiple Choice</option>
		<option value="3">Free Response</option>
		
	</select><br>
	    <div id="choicesDiv">
	        Choice 1:<input type="text" name="c1" id="c1"/><br>
            Choice 2:<input type="text" name="c2" id="c2"/><br>
            Choice 3:<input type="text" name="c3" id="c3"/><br>
            Choice 4:<input type="text" name="c4" id="c4"/><br>
		</div>

	<input type="hidden" id="questionNum" name="questionNum" value="<?php echo $questionNum; ?>">	
	<input type="hidden" id="surveyid" name="surveyid" value="<?php echo $surveyid; ?>">
	<input type="hidden" id="surveyname" name="surveyname" value="<?php echo $surveyname; ?>">
	

	<br><br>

	 <button type="submit" name="addquestionbtn" id="addquestionbtn" value="Add Question">Add Question</button> 
	 <button type="submit" name="donebtn" id="donebtn" value="Done">Done</button> 
	</form> 
	
	
	
</body>
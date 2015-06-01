<?php

$current_path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']);

 include('mysql_adapter.php'); ?>
 <!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Create New Survey</title>
	<meta charset="UTF-8">

</head>

<body>

	<form id="newQuestionForm">
	Question: 
	<br>
	<textarea name="questionTextBox" cols ="50" rows="1"></textarea>
	<br><br>
	Select the type of question: 
	<select name="questionType">
		<option value="multiplechoice">Multiple Choice</option>
		<option value="freeresponse">Free Response</option>
		<option value="checkbox">Check Box</option>
	</select>
	</form> 
	
	<br><br>
	
	 <button type="button" form="newQuestionForm" onclick="">Add Question</button> 
	 <button type="submit" form="newQuestionForm">Done</button> 
	
</body>
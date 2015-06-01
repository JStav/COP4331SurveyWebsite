<?php

$current_path = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']);

 include('mysql_adapter.php'); ?>
<!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Take Survey</title>
	<meta charset="UTF-8">

</head>

<body>

	<form id="takeSurveyForm">
	Question: <span id="questionNumber"></span> 
	<!--Load question number above-->
	<br>
	
	<div id="questionText"></div>
	<!--Load question Text here-->
	
	<div id="questionAnswerChoices"></div>
	<!--Load question answer choices here-->
	</form> 
	
	<br><br>
	
	 <button type="button" form="takeSurveyForm" onclick="">Next Question</button> 
	 <button type="reset" form="takeSurveyForm">Clear</button>
	 <button type="submit" form="takeSurveyForm">Done</button> 
	
</body>
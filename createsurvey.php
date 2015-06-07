<?php include('mysql_adapter.php'); ?>
<?php include('loginbox.php'); ?>
 <!DOCTYPE html>
<html lang="en-US">

<head>
	<title>Create New Survey</title>
	<meta charset="UTF-8">

</head>

<body>

	<form name="newSurveyForm" id="newSurveyForm" method="post" action="createquestion.php">
	Survey name: <input type="text" name="surveyname" id="surveyname">
	
	 <button type="submit" name="Continue" id="Continue" value="Continue">Continue</button> 
	</form> 
	
</body>
<?php

$survey_id = $_GET["survey_id"];


if($survey_id == "")
{
	die("Error, survey_id not found.");
}





?>


<html lang="en-US">

<head>
	<title>Live Results</title>
	<meta charset="UTF-8">
	<script type="text/javascript" src="./js/jquery-1.11.3.min.js"></script>
	<script type="text/javascript">
	$( document ).ready(function()
	{
		console.log( "ready!" );
		var dateVar = new Date();
		var secondsVar = dateVar.getSeconds();
		var refreshID = setInterval(function() 
		{ 
			// every 6 seconds check the database
			//$("#timer").html(secondsVar%6); // this isn't working ugh
			//if(secondsVar%6==0)
			//{
				$.get("./livejson.php", function(data)
				{
					$("#result").html(data);
				});
			//}
			
		}, 6*1000); // 6 second interval


		// Used for initial
		$.get("./livejson.php", function( data )
		{
		  $("#result").html(data);
		});	
	});
	</script>
</head>

<body>
	<div id="timer"></div>
	<div id="result">Nothing here.</div>
	
	
</body>
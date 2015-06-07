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
	
	function getJSONURL()
	{
		var milliseconds = (new Date).getTime();
		var jsonPAGEURL = "./livejson.php?milli="+milliseconds+"&survey_id=<?php echo $survey_id; ?>";
		//alert(jsonPAGEURL);
		return jsonPAGEURL;
	}
	var obj;
	function displayData()
	{
		var outputHTML = "<table border=1><tr><th>Answered Date</th><th>Question</th><th>Answer Submitted</th><th>Answered By</th></tr>";
		for(var i = 0; i<obj.data.length;i++)
		{
			/*
				$jsonString .= '"question_id":"' . $row["question_id"] . '",';
	$jsonString .= '"qtype_id":"' . $row["qtype_id"] . '",';
	$jsonString .= '"question_text":"' . $row["question_text"] . '",';
	$jsonString .= '"user_id":"' . $row["user_id"] . '",';
	$jsonString .= '"email":"' . $row["email"] . '",';
	$jsonString .= '"first_name":"' . $row["first_name"] . '",';
	$jsonString .= '"last_name":"' . $row["last_name"] . '",';
	$jsonString .= '"answer":"' . $row["answer"] . '"';
			*/
			outputHTML+='<tr><td>'+obj.data[i].ans_timestamp+'</td><td>Question '+obj.data[i].question_id+':<br> '+obj.data[i].question_text+'</td><td>'+obj.data[i].answer+'</td><td><a href="mailto:'+obj.data[i].email+'">'+obj.data[i].first_name+' '+obj.data[i].last_name+'</a></td></tr>';
		}
		outputHTML +="</table>"
		$("#result").html(outputHTML);
		$("#lastUpdated").html("Last Updated: " + Date());
		 
	}
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
				$.get(getJSONURL(), function(data)
				{
					obj = jQuery.parseJSON(data);
					displayData();
				});
			//}
			
		}, 6*1000); // 6 second interval


		// Used for initial
		$.get(getJSONURL(), function( data )
		{
		  obj = jQuery.parseJSON(data);
		  displayData();
		});	
	});
	</script>
</head>

<body>
	<h1>Live Results Page</h1>
	<div id="timer"></div>
	<div id="lastUpdated"></div>
	<div id="result">Nothing here.</div>
	
	
</body>
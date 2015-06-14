<?php include('mysql_adapter.php'); ?>

<?php
//$today = getdate();
//print_r($today);
$survey_id = $_GET["survey_id"];
if($survey_id == "" || !is_numeric($survey_id))
{
	die("ERROR");
}
$query = "
SELECT *
FROM answers
INNER JOIN users 
on users.user_id = answers.user_id
INNER JOIN questions
ON questions.question_id = answers.question_id
AND questions.survey_id = answers.survey_id
LEFT OUTER JOIN question_options
ON question_options.question_id = answers.question_id
AND question_options.survey_id = answers.survey_id
AND question_options.option_id = answers.answer
WHERE answers.survey_id = " . sanitize_value($survey_id) . "
ORDER BY answers.ans_timestamp desc";
//nice_print_r($query);
// DO NOT USE run_query for this query!! the data this page echos must be perfect!
$result = mysql_query($query) or die("Database Error: " . mysql_error()); 
$jsonString = '{"data":[';

while($row = mysql_fetch_array($result)) 
{
	$answer = $row["answer"];
	if($row["option_text"] != "" AND !is_null($row["option_text"]))
	{
		// we're dealing with a multiple choice question, use the option_text instead of the answer value (which is the option_id in this case)
		$answer = $row["option_text"];
		//nice_print_r($row);
	}
	$jsonString .= '{';
	$jsonString .= '"question_id":"' . $row["question_id"] . '",';
	$jsonString .= '"qtype_id":"' . $row["qtype_id"] . '",';
	$jsonString .= '"question_text":"' . $row["question_text"] . '",';
	$jsonString .= '"user_id":"' . $row["user_id"] . '",';
	$jsonString .= '"email":"' . $row["email"] . '",';
	$jsonString .= '"first_name":"' . $row["first_name"] . '",';
	$jsonString .= '"last_name":"' . $row["last_name"] . '",';
	$jsonString .= '"ans_timestamp":"' . $row["ans_timestamp"] . '",';
	$jsonString .= '"answer_db_value":"' . $row["answer"] . '",';
	$jsonString .= '"option_id":"' . $row["option_id"] . '",';
	$jsonString .= '"option_text":"' . $row["option_text"] . '",';
	$jsonString .= '"answer":"' . $answer . '"';
	$jsonString .= '},';
}
$jsonString = rtrim($jsonString, ","); // remove that last comma.
$jsonString .= "]}";
echo $jsonString;
?>

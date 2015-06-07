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
WHERE answers.survey_id = " . sanitize_value($survey_id) . "
ORDER BY answers.ans_timestamp desc";
//nice_print_r($query);
$result = mysql_query($query) or die("1Database Error: " . mysql_error());
$row = mysql_fetch_array($result);
$jsonString = '{"data":[';
 
while($row = mysql_fetch_array($result)) 
{
	$jsonString .= '{';
	$jsonString .= '"question_id":"' . $row["question_id"] . '",';
	$jsonString .= '"qtype_id":"' . $row["qtype_id"] . '",';
	$jsonString .= '"question_text":"' . $row["question_text"] . '",';
	$jsonString .= '"user_id":"' . $row["user_id"] . '",';
	$jsonString .= '"email":"' . $row["email"] . '",';
	$jsonString .= '"first_name":"' . $row["first_name"] . '",';
	$jsonString .= '"last_name":"' . $row["last_name"] . '",';
	$jsonString .= '"ans_timestamp":"' . $row["ans_timestamp"] . '",';
	$jsonString .= '"answer":"' . $row["answer"] . '"';
	$jsonString .= '},';
}
$jsonString = rtrim($jsonString, ","); // remove that last comma.
$jsonString .= "]}";
echo $jsonString;
?>

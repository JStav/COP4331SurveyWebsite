<?php include('mysql_adapter.php'); ?>

<?php
//Variables for the connection
$mysql_host = "mysql4.000webhost.com";
$mysql_database = "a9634422_survey";
$mysql_user = "a9634422_survey";
$mysql_password = "testpass1";



//Code for connection
$connect = mysqli_connect("mysql4.000webhost.com","a9634422_survey","testpass1") or die(mysqli_connect_errno());

mysqli_select_db($connect, $mysql_database) or die(mysql_error());

$response = array();

$action = $_GET['action'];

switch ($action) {

	case 'login':
		$username = $_GET['username'];
		$result = mysqli_query($connect, " SELECT * FROM users WHERE email = '$username' ") or die(mysql_error());

		$response["user"] = array();

		while($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp["email"] = $row["email"];
			$temp["user_id"] = $row["user_id"];
			$temp["password"] = $row["password"];
			array_push($response["user"], $temp);
		}

		echo json_encode($response);
		break;

	case 'get_surveys':
		$result = mysqli_query($connect, " SELECT * FROM `surveys` ") or die(mysql_error());

		$response["surveys"] = array();
		while($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp["id"] = $row["survey_id"];
			$temp["survey_name"] = $row["survey_name"];
			array_push($response["surveys"], $temp);
		}
		echo json_encode($response);
		break;

	case 'get_questions':
		$survey_id = $_GET['survey_id'];

		$result = mysqli_query($connect, " SELECT * FROM `questions` WHERE survey_id = '$survey_id' ") or die(mysql_error());

		$response["questions"] = array();
		while($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp["question_text"] = $row["question_text"];
			$temp["question_id"] = $row["question_id"];
			$temp["qtype_id"] = $row["qtype_id"];
			array_push($response["questions"], $temp);
		}
		echo json_encode($response);

		break;

	case 'get_options':
		$question_id = $_GET['question_id'];
		$result = mysqli_query($connect, " SELECT * FROM `question_options` WHERE question_id = '$question_id' ") or die(mysql_error());

		$response["options"] = array();
		while($row = mysqli_fetch_array($result)){
			$temp = array();
			$temp ["option_text"] = $row["option_text"];
			$temp ["option_id"] = $row["option_id"];
			array_push($response["options"], $temp);
 		}
 		echo json_encode($response);
 		break;
	case 'is_taken_survey'
		// just a demo query, Implemented in the laziest way I could do as an example more than anything.
		
		$user_id = $_GET['user_id'];
		$survey_id = $_GET['survey_id'];
		$query = "
		SELECT
			count(*) as counter
		FROM user_surveys 
		WHERE user_id = " . sanitize_value($user_id) . "
			AND survey_id = " . sanitize_value($survey_id) . "
			AND relation_id = 2"; // relation_id 2 for someone who has taken the survey aka taker.
			
		$result = run_query($query);
		$row = mysql_fetch_array($result);
		$counter = $row["counter"];
		if($counter > 0)
		{
			echo "False";
		}
		else
		{
			echo "True";
		}
		
		break;
/* 	case 'submit_answers':
 		$answers = $_GET['answers'];
		$user_id = $_GET['user_id'];
		$survey_id = $_GET['survey_id'];
		$query = "INSERT INTO user_surveys(user_id, survey_id, relation_id) VALUES (" . sanitize_value($survey_id) . ", " . sanitize_value($survey_id).", 2)"; // 2 for taker
		$result = run_query($query);
 		$answers = stripslashes($answers);
 		$result = mysqli_query($connect, " INSERT INTO answers (question_id, user_id, survey_id, answer) VALUES $answers ");
 		echo $result;
 		break;
*/
	// default:
	// 	# code...
	// 	break;
}
mysqli_close($connect);
?>
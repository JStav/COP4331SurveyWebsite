<?php include('mysql_adapter.php'); ?>

<?php
include('Mail.php');

//if(isset($_POST('submit')) && $_POST['submit'] == 'Submit')
//{
$email = $_POST['email'];

$query = "select * from users where email = '" . $email ."'";

 $result = run_query($query);
    // TODO: refactor this if time permits.
    //$num_rows = mysql_num_rows($result); 
    $row = mysql_fetch_array($result);
//    $user_id = $row["user_id"];

//Searches the database to see if the email typed is registered in the system.
    //I don't know what I'm doing
    /*
for($i = $num_rows; $row["user_id"] != $email || $row["user_id"] != ""; $i--) 
	$row = mysql_fetch_array($result);
	*/

nice_print_r($row);

if($email!="")
{
$subject = "Reset Password Form";
$headers = "From: Super Sweet Surveys";
$token = md5($email) . "R12245";
$message = "To reset your password, follow this link: http://jstav.site50.net/newpassword.php?user_id=" . $row["user_id"] . "&token_id=" . $token;
$makeit = mail($email, $subject, $message, $headers);
if($makeit)
{
	echo "E-mail Sent!";
	echo $message;
}
else
{
	echo "Error sending email";
}
die();
//else echo ":(";
}
//}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Reset Password</title>
</head>
<header>
<h1> Account Recovery </h1


<article>
Don't worry, you'll get your account back soon! Just type in your email!
</article>
<form name="pswrdResetForm" id="pswrdResetForm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

Email <input type="text" name="email" id="email"/>
<input type="submit" value="Submit" id="submit"/>
<input type="button" onclick="javascript: void(0); window.location='login.php'" value="Back"/>
</form>
</header>
<body>
</body>
</html>

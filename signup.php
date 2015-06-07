<?php include('mysql_adapter.php'); ?>

<?php
/*
print_r($_POST['firstName']);
echo "<p>";
print_r($_POST['lastName']);
echo "<p>";
print_r($_POST['email']);echo "<p>";
print_r($_POST['pswrd']);echo "<p>";
print_r($_POST['confirmpswrd']);
*/
if($_POST['firstName'] != "" && $_POST['lastName'] != "" 
&& $_POST['email'] != "" && $_POST['pswrd'] != "" && $_POST['confirmpswrd'] != "")
{
   // echo "made it!";
    if($_POST['pswrd'] != $_POST['confirmpswrd'])
    {
        echo "Passwords do not match.";
    }
    else
    {

    $email = $_POST['email'];

    $password = $_POST['pswrd'];
    $password = md5($password);

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];

    $query = "insert into users(email, password, first_name, last_name) 
              values('". $email ."', '". $password ."', '". $firstName ."', '". $lastName ."')";
    $result = mysql_query($query) or die("Database Error: " . mysql_error());

    echo "Account Created!";

    $query = "select * from users where email = '" . $email . "' and password = '" . $password . "'";

    $result = mysql_query($query) or die("Database Error: " . mysql_error());
    // TODO: refactor this if time permits.
    $num_rows = mysql_num_rows($result); 
    $row = mysql_fetch_array($result);
    $user_id = $row["user_id"];
    
    if($num_rows > 0)
    {
        setcookie("user_id", $row["user_id"], time()+3600);  /* expire in 1 hour */
        setcookie("email", $row["email"], time()+3600);  /* expire in 1 hour */
        setcookie("first_name", $row["first_name"], time()+3600);  /* expire in 1 hour */
        setcookie("last_name", $row["last_name"], time()+3600);  /* expire in 1 hour */
        header("Location: surveylist.php");
        die();
    }
}
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Create An Account</title>
</head>
<header>
<h1> Create An Account </h1>
  <form name="login" id="login" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>"><ul>
  			First name <input type="text" name="firstName" id="firstName"/><br>
            Last name <input type="text" name="lastName" id="lastName"/><br>
            Email <input type="text" name="email" id="email"/><br>
            Password <input type="password" name="pswrd" id="pswrd"/><br>
            Confirm Password <input type="password" name="confirmpswrd" id="confirmpswrd"   /><br>
            </ul>
            <input type="submit" onclick="check(this.form)" value="Submit"/>
            <input type="reset" value="Clear"/>
            <input type="button" onclick="javascript: void(0); window.location='login.php'" value="Back"/>
        </form>
</header>
<body>
</body>
</html>

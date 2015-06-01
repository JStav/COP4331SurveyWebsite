<?php
error_reporting(E_ERROR | E_PARSE); // hide php server level warning messages to users about db being offline etc

$mysql_host = "mysql4.000webhost.com";
$mysql_database = "a9634422_users";
$mysql_user = "a9634422_stav";
$mysql_password = "testpass1";

	// Create connection
	$con = mysqli_connect($mysql_host,$mysql_user,$mysql_password,$mysql_database);

	// Check connection
	if (mysqli_connect_errno())
	{
		echo "Failed to connect to Database";//: " . mysqli_connect_error();
	}
	
	//echo "Connected successfully";
?> 
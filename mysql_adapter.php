<?php
error_reporting(E_ERROR | E_PARSE); // hide php server level warning messages to users about db being offline etc

$mysql_host = "mysql4.000webhost.com";
$mysql_database = "a9634422_survey";
$mysql_user = "a9634422_survey";
$mysql_password = "testpass1";

	mysql_connect($mysql_host, $mysql_user,$mysql_password) or die(mysql_error());
	mysql_select_db($mysql_database) or die(mysql_error());
	//echo "Connected successfully";
?> 
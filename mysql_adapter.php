<?php
error_reporting(E_ERROR | E_PARSE); // hide php server level warning messages to users about db being offline etc

$mysql_host = "mysql4.000webhost.com";
$mysql_database = "a9634422_survey";
$mysql_user = "a9634422_survey";
$mysql_password = "testpass1";

	mysql_connect($mysql_host, $mysql_user,$mysql_password) or mysql_connect("localhost", $mysql_user,$mysql_password) or die(mysql_error());
	mysql_select_db($mysql_database) or die(mysql_error());
	//echo "Connected successfully";
	
	function sanitize_value($input)
	{
		// sanitize a value BEFORE placing it into the query string!
		$input = stripslashes($input);
		$input = str_replace('"', '\"',$input);
		$input = str_replace("'", "\'",$input);
		return $input;
	}
	
	function nice_print_r($input)
	{
		//echo '<p><pre>Nice Print_R: |';
		//print_r($input);
		//echo '|</pre></p>'; 
	}
	
	
	function run_query($query)
	{
		nice_print_r($query);
		$result = mysql_query($query) or die("Database Error: " . mysql_error()); 
		return $result;
	}
?> 

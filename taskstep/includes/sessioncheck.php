<?php
//Allow sessions
session_start();  
header("Cache-control: private");
$_SESSION["user_id"] = 1;
$_SESSION["lang"] = "en";

//Include the configuration
include("config.php");
$_SESSION["lang"] = $language;
$_SESSION["menu_date_format"] = $menu_date_format;	
$_SESSION["task_date_format"] = $task_date_format;

//Grab the setting for "sessions"
//Select the results of the query in the format (query,row,column)
$session = 1;

//If sessions are enabled...
if ($session == '1')
{
  //and there is no session for "loggedin"...
	if(!$_SESSION['loggedin'])
		{
			//...send them packing to the login page
			$host  = $_SERVER['HTTP_HOST'];
			$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'login.php';
			session_write_close();
			header("Location: http://$host$uri/$extra");
			exit;
		}
}
?>
<?php
//Allow sessions
session_start();  
header("Cache-control: private");
require_once("model/SettingDAO.php");
$settingdb = new SettingDAO();
$_SESSION["user_id"] = 1;

//Include the configuration
include("config.php");

//Connect and select the database
$mysqli = new mysqli($server, $user, $password, $db);
if ($mysqli->connect_error) {
	die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

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
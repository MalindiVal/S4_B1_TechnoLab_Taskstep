<?php
include("includes/header.php");
include("Controller/injectorContoller.php");
require_once("model/SettingDAO.php");
require_once("model/Setting.php");
require_once("model/SectionDAO.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");
require_once("model/ItemDAO.php");

$setting = null;
$user = null ;
//Variable récupérer depuis la connexion via la session
if (isset($_SESSION['user_id'])){
	$settingController = InjectorContoller::getSettingController();
	$setting = $settingController->getSettingByUser($_SESSION['user_id']);
}


$settingdb = new SettingDAO();
$itemdb = new ItemDAO();
//"Settings Updated" block
if (isset($_POST["submit"]))
{
	$hidden = '';
	$settingsstatus = '';
	
	$tips = (isset($_POST['tips'])) ? 1 : 0;
	if ($tips) $settingsstatus .= $l_cp_display_tipson;
	else $settingsstatus .= $l_cp_display_tipsoff;

	$style = $_POST['style'];
	if ($style == 'none') $settingsstatus .= "<br />".$l_cp_display_defaultcss;
	else $settingsstatus .= "<br />".$style;
	
	$setting->setTips($tips>0);
	$setting->setStylesheet($_POST['style']);
	$settingdb->UpdateSetting($setting);
	$updatedblock = "<div id='updated' style='width: 20em;'>";
	$updatedblock .= "<img src='images/accept.png' alt='' />&nbsp;$l_cp_display_settingsupdated:<br />";
	$updatedblock .= "<span class='italic'>$settingsstatus</span></div>";
}
else $updatedblock = '';

//Show/Hide Tips checkbox
	
	$tipsON = intval($setting->getTips());
	$checked = ($tipsON) ? ' checked="checked"' : '';
	$tipsfield = $l_cp_display_tips.": <input type='checkbox' value='Display tips' name='tips'$checked />";

//Stylesheets code
	$style = $setting->getStylesheet();
	$styleoptions = '';

	//Define the folder and path
	$folder="styles";
	$path = $_SERVER['DOCUMENT_ROOT']."/".$folder;
	//Split the contents into an array
	$files=array();
	if ($handle=opendir("$folder"))
	{
		while (false !== ($file = readdir($handle)))	//For each file...
		{
			if ($file != "." && $file != "..")
			{
				if (substr($file,-3)=='css')	//...if it is CSS...
				{
					$selected = ($style == $file) ? ' selected="selected"' : '';
					$styleoptions .= "<option value='$file'$selected>$file</option>";	//...echo the file name as an option
				}
			}
		}
	}
	closedir($handle); 

//Password code
if (isset($_POST["passchanges"]))
{
	//Get the hashed password
	$oldpass = $user->getPassword();

	//Massive error trapping going on here
	$submittotal = password_hash($_POST['currentpass']);
	if($submittotal !== $oldpass) $pwmessage = $l_cp_password_incorrect;
	elseif($_POST['newpass1'] !== $_POST['newpass2']) $pwmessage = $l_cp_password_nomatch;
	else	//Everything works, so slam it all in
	{
		if($_POST['newpass1'] !== '')
		{
			$newsalt = substr(uniqid(rand(), true), 0, 5);
			$secure_password = password_hash($_POST['newpass1']);
			$user->setPassword($secure_password); 
			//UpdateUser($secure_password)
		}
		$svalue = (isset($_POST['sessions'])) ? 1 : 0;
		$setting->setSession($svalue);
		$pwmessage = $l_cp_password_updated;
	}
}
else $pwmessage = '';

//"Use Passwords" checkbox
$use = $setting->getSession();
$checked = ($use) ? ' checked="checked"' : '';
$usepwfield = $l_cp_password_use.": <input type='checkbox' value='Sessions' name='sessions'$checked />";

//Purge functionality
if (!isset($_GET['delete'])) $purgetext = '<a href="#" onclick="check()">' . $l_cp_tools_purge . '</a>';
else
{
	$del_rows = $itemdb->getChecked(true);
	$num_affected = count($del_rows);
	$itemdb->PurgeDoneItem();
	$purgetext = $num_affected.$l_cp_tools_purged;
}

//CSV Export functionality
if(!isset($_GET['export'])) $exporttext = '<a href="settings.php?export=csv">' . $l_cp_tools_export . '</a>';
else
{
	$result =$itemdb->getAll(null,null,"done");
	foreach($result as $res)
	{
		$title=htmlentities($res->getTitle());
		$date = ($res->getDate() != 00-00-0000) ? $res->getDate()." | " : '';
		$notes=htmlentities($res->getNotes());
		$url=htmlentities($res->getUrl());
		$done=$res->isDone() ;
		$id=$res->getId();

		$context=htmlentities($res->getContext());
		
		$project=htmlentities($res->getProject());

		$data = "$id,$title,$date,$notes,$context,$project,$url,$done\r\n";
		$file = "exported_results.csv";   
		if (!$file_handle = fopen($file,"a")) echo "Cannot open file";
		if (!fwrite($file_handle, $data)) echo "Cannot write to file";

		fclose($file_handle);
	}
	$exporttext = 'Exported to ' . $file;
}

include('includes/settings.htm');
include('includes/footer.php');
?>
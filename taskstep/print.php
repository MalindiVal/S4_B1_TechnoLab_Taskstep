<?php
include("includes/sessioncheck.php");
include("config.php");
require_once("model/SectionDAO.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");
require_once("model/ItemDAO.php");
$itemdb = new ItemDAO();
include("lang/".$language.".php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TaskStep - <?php echo $l_print_commontitle; ?></title>
<link rel="stylesheet" type="text/css" href="styles/system/print-style.css" />
</head>
<body>
<!--Open container-->
<div id="container">
<?php
$print = (isset($_GET['print'])) ? $_GET['print'] : '';

switch ($print)
{
case 'section':
	$tid = intval($_GET["id"]);
	$sectiondb = new SectionDAO();
	$idresult = $sectiondb->getById($tid);
	$result = $itemdb->getAll($print,$tid,"date");
	$title=$l_sectionlist[$idresult->getTitle()];
	$result = $itemdb->getAll($print,$tid,"date");
	break;
case 'project':
	$tid = intval($_GET["id"]);
	$projectdb = new ProjectDAO();
	$idresult = $projectdb->getById($tid);
	$title = $idresult->getTitle();
	$result = $itemdb->getAll($print,$tid);
	break;
case 'context':
	$tid = intval($_GET["id"]);
	$contextdb = new ContextDAO();
	$idresult = $contextdb->getById($tid);
	$title = $idresult->getTitle();
	$result = $itemdb->getAll($print,$tid);
	break;
case 'all':
	$title = $l_print_printalltasks;
	$result = $itemdb->getAll(null,null,"done");
	break;
case 'today':
	$fancytoday = date("jS M Y");
	$title = "$l_print_printtoday ($fancytoday)";
	$today = date("Y-m-d");
	$result = $itemdb->getAll($print,null,"done");
	break;
}

echo "<h1>$title</h1>\n";

if(!isset($cmd))	//If cmd is not set
{
	echo"<ul>";
	//grab all the content
	foreach($result as $res)
	{
	   //the format is $variable = $r["nameofmysqlcolumn"];

		$title=htmlentities($res->getTitle());
		$date = ($res->getDate() != 00-00-0000) ? $res->getDate()." | " : '';
		$notes=htmlentities($res->getNotes());
		$url=htmlentities($res->getUrl());
		$done=$res->isDone() ;
		$id=$res->getId();

		$contextdb = new ContextDAO();
		$idresult = $contextdb->getById($res->getContextId());
		$Contexttitle = $idresult->getTitle();
		$context=htmlentities($Contexttitle);
		
		$projectdb = new ProjectDAO();
		$idresult = $projectdb->getById($res->getProjectId());
		$projecttitle = $idresult->getTitle();
		$project=htmlentities($projecttitle);

	   //nested if statement
	   //display the row

	   //if the action is marked as done, then do not apply any current or old markings to it
	    echo "<li>$title<br />\n";
		echo "$date$context<br />\n";
		echo "$url</li>\n";
	}
	echo"</ul>\n";
}
?>
<!--Close container-->
</div>
</body>
</html>
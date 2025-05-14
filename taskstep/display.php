<?php
include("includes/header.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");
require_once("model/ItemDAO.php");
$itemdb = new ItemDAO();
//This is where all the action happens. Most php files in TaskStep link here in some form or another, so best advice is DON'T CHANGE IT!

if (isset($_GET["cmd"]))
{
	$id = $_GET["id"];
	switch ($_GET["cmd"])
	{
		case "delete":
			$itemdb->Delete($id);
		break;
		case "do":
			$itemdb->setChecked(true,$id);
		  	echo "<div id='updated' class='fade'><img src='images/accept.png' alt='' /> ".$l_msg_itemdo."</div>";
		break;
		case "undo":
			$itemdb->setChecked(false,$id);
		  	echo "<div id='deleted' class='fade'><img src='images/undone.png' alt='' /> ".$l_msg_itemundo."</div>";
		break;  
		default:	//Error trap it so that if a dodgy command is given it doesn't drop dead
			echo "<div class='error'><img src='images/exclamation.png' alt='' /> ".$l_msg_actionerror."</div>";
		break;
	}
}

//This is the sorting form, as promised

$display = (isset($_GET["display"])) ? $_GET["display"] : '';
$sortby = (isset($_GET["sort"])) ? $_GET["sort"] : 'date';
$section = (isset($_GET["section"])) ? $_GET["section"] : '';
$tid = (isset($_GET["tid"])) ? $_GET["tid"] : '';

$title = "";
switch ($display)
{
	case "section":
		//Massively cleaned up section which obtains section titles from the language file
		foreach($l_sectionlist as $key=>$value){
			if($section==$key){
				$currentsection = $key;
				$sectiontitle = $value;
			}
		}
		$result = $mysqli->query("SELECT * FROM items WHERE section='$currentsection' ORDER BY $sortby");
		$title  =$sectiontitle;
		$noresultsurl = '?section=' . $section;
	break;
	case "project":
		$projectdb = new ProjectDAO();
		$idresult = $projectdb->getById($tid);
		$disptitle = $idresult->getTitle();
		$result = $mysqli->query("SELECT * FROM items WHERE project='$disptitle' ORDER BY $sortby");
		$title = $disptitle;
		$noresultsurl = '?tid=' . $tid;
	break;
	case "context":
		$contextdb = new ContextDAO();
		$idresult = $contextdb->getById($tid);
		$disptitle = $idresult->getTitle();
		$result = $mysqli->query("SELECT * FROM items WHERE context='$disptitle' ORDER BY $sortby");
		$title = $disptitle;
		$noresultsurl = '?tid=' . $tid;
	break;
	case "all":
		$result = $mysqli->query("SELECT * FROM items ORDER BY $sortby");
		$title = $l_nav_allitems;
		$noresultsurl = '';
	break;
	case "today":
		$today = date("Y-m-d");
		$todayf = date($menu_date_format);
		$result = $mysqli->query("SELECT * FROM items WHERE date='$today' ORDER BY $sortby");
		$title = $l_nav_today.": ". $todayf.
		$noresultsurl = '';
	break;
}
?>

<div id='sectiontitle'><h1><?=$title ?></h1></div>

<?php

sort_form($display, $section, $tid, $sortby);
$numberrows = $result->num_rows;
if ($numberrows == 0)
{
	$message = ( $display == "today" ) ? $l_msg_notoday : $l_msg_noitems;
	echo "<div class='inform'><img src='images/information.png' alt='' />&nbsp;".$message." <a href='edit.php$noresultsurl'>".$l_msg_addsome."</a></div>";
}
else display_items($display, $section, $tid, $sortby);

if(isset($_POST['submit'])) //If submit is hit
{
  $section=$_POST['section'];
  $sortby=$_POST['sort'];
}

include('includes/footer.php');
?>
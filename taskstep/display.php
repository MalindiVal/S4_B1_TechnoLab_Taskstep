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
		
		$result = $itemdb->getAll($display,$tid,$sortby); 
		$title  =$sectiontitle;
		$noresultsurl = '?section=' . $section;
	break;
	case "project":
		$projectdb = new ProjectDAO();
		$idresult = $projectdb->getById($tid);
		$disptitle = $idresult->getTitle();
		$projectid = $idresult->getId();
		$result = $itemdb->getAll($display,$tid,$sortby); 
		$title = $disptitle;
		$noresultsurl = '?tid=' . $tid;
	break;
	case "context":
		$contextdb = new ContextDAO();
		$idresult = $contextdb->getById($tid);
		$disptitle = $idresult->getTitle();
		$result = $itemdb->getAll($display,$tid,$sortby); ;
		$title = $disptitle;
		$noresultsurl = '?tid=' . $tid;
	break;
	case "all":
		$result = $itemdb->getAll(null,null,$sortby); 
		$title = $l_nav_allitems;
		$noresultsurl = '';
	break;
	case "today":
		$today = date("Y-m-d");
		$todayf = date($menu_date_format);
		$result = $itemdb->getAll($display,null,$sortby);
		$title = $l_nav_today.": ". $todayf.
		$noresultsurl = '';
	break;
}
?>

<div id='sectiontitle'><h1><?=$title ?></h1></div>

<?php

sort_form($display, $section, $tid, $sortby);
$numberrows = count($result);
if ($numberrows == 0)
{
	$message = ( $display == "today" ) ? $l_msg_notoday : $l_msg_noitems;
	echo "<div class='inform'><img src='images/information.png' alt='' />&nbsp;".$message." <a href='edit.php$noresultsurl'>".$l_msg_addsome."</a></div>";
}
else{
	foreach($result as $res)
	{	
	//the format is $variable = $r["nameofmysqlcolumn"];
	$title=htmlentities($res->getTitle());
	$date=$res->getDate();
	$date_display=date($task_date_format, strtotime($date));
	$notes=htmlentities($res->getNotes());
	$urlfull=htmlentities($res->getUrl());
	$done=$res->isDone();
	$id=$res->getId();
	$contextdb = new ContextDAO();
	$context=htmlentities($contextdb->getById($res->getContextId())->getTitle());
	$projectdb = new ContextDAO();
	$project=htmlentities($projectdb->getById($res->getProjectId())->getTitle());

	if ($urlfull == "") $url = "";
	else
	{
		$limit = 40; // set character limit
		$url = "<a href='$urlfull'>";
		// display URL up to character limit, shorten & add ellipsis if it is too long
		$url .= (strlen($urlfull) > $limit) ? substr($urlfull,0,$limit) . '...</a>' : $urlfull . '</a>';
	}
	
	//Set up a few variables for the do/undo button
	$cmd = 'do';
	$link = $l_items_do;
	$icon = 'undone';
	
	//display the row
   
	//if the action is marked as done, then do not apply any current or old markings to it
    if($done == 1)
	{
		echo "<div class='np'> <span style='text-decoration:line-through;'> $title - $date_display | $project | $context</span>";
		$cmd = 'undo';
		$link = $l_items_undo;
		$icon = 'accept';
	}

	//if the date doesn't exist, then don't display the date
	elseif($date == 00-00-0000) echo "<div class='np'> $title | $project | $context";

	//if the date is equal to the current date, flag it as current
   	elseif(date("Y-m-d") == $date) echo "<div class='current'><img src='images/flag_yellow.png' alt='' /> $title - $date_display | $project | $context";

	//if the date is older than the current date, flag it as old
	elseif(date("Y-m-d") > $date) echo "<div class='old'><img src='images/flag_red.png' alt='' /> $title - $date_display | $project | $context";

	//if the date is neither of these, don't flag it.
	else echo "<div class='np'> $title - $date_display | $project | $context";
	
	echo "<a href='display.php?display=$display&amp;{$section}{$tid}{$sortby}cmd=delete&amp;id=$id' title='$l_items_del' class='actionicon'><img src='images/bin_empty.png' alt='$l_items_del' /></a>
	<a href='edit.php?id=$id' title='$l_items_edit' class='actionicon'><img src='images/pencil.png' alt='$l_items_edit' /></a> 
	<a href='display.php?display=$display&amp;{$section}{$tid}{$sortby}cmd=$cmd&amp;id=$id' title='$link' class='actionicon'><img src='images/$icon.png' alt='$link' /></a>
	<br />$notes<br />$url</div>";
	}
} 

if(isset($_POST['submit'])) //If submit is hit
{
  $section=$_POST['section'];
  $sortby=$_POST['sort'];
}

include('includes/footer.php');
?>
<?php 
include("includes/header.php");
require_once("model/SettingDAO.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");
require_once("model/ItemDAO.php");
require_once("Controller/injectorContoller.php");
$itemdb = new ItemDAO();

?>
<h1>&nbsp;<?php echo $l_nav_home; ?></h1>
<div id="welcomebox">

<h2><img src="images/page.png" alt="" />&nbsp;<?php echo $l_index_welcome; ?></h2>
<p>
	<?php
		$var = date("H");
		if ($var <= 11) echo $l_index_introm;
		else if ($var > 11 and $var < 18) echo $l_index_introa;
		else echo $l_index_introe;
		echo $l_index_introtext;
	?>
	<p><img src="images/chart_bar.png" alt="" />&nbsp;
	<?php
		$tasktotal = $itemdb->getChecked(false);
		$numtasks = count($tasktotal);
		if($numtasks == 1) echo $l_index_1task;
		else echo $l_index_mtasks.$numtasks.$l_index_mtaske;
	?>
</p>
</div>

<?php
//select the table
$todaydate = date("Y-m-d");
$result = $itemdb->getImediateItems();
$numrows= count($result);
?>
<div id="immediateblock">
<h2><img src="images/lightning.png" alt="" /> <?php echo $l_sectionlist['immediate'] ?> (<?php echo $numrows; ?>)</h2>
<?php
foreach($result as $res)
{	
	//the format is $variable = $r["nameofmysqlcolumn"];
	$title=htmlentities($res->getTitle());
	$date = ($res->getDate() != 00-00-0000) ? ' - '.date($_SESSION["task_date_format"], strtotime($res->getDate())) : '';
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
	echo "<div class='immediateitem'><a href='display.php?display=section&amp;section=immediate&amp;cmd=do&amp;id=$id' title='".$l_items_do."'><img src='images/undone.png' alt='".$l_items_do."' class='valign'/></a>\n";
	echo "<a href='edit.php?id=$id' title='".$l_items_edit."'>$title</a>$date | $context</div>\n";
}
if ($numrows == 0) echo $l_index_noimmediate;
echo '</div>';

	$tips = 0;
	if (isset($_SESSION['user_id'])) {
		$settingController = InjectorContoller::getSettingController();
		$setting = $settingController->getSettingByUser($_SESSION['user_id']);
		$tips = intval($setting->getTips());
	}
	
	if($tips == 1)
	{
		echo '<div id="tipsbox"><img src="images/information.png" alt="" />&nbsp;' . $l_index_tip . ':&nbsp;';
		//TEMPORARY LANGUAGE VALUE
		srand((double)microtime()*1000000); 
		$arry_txt=preg_split("/--NEXT--/",join('',file("lang/tips_" . $_SESSION["lang"] .".txt"))); 
		echo $arry_txt[rand(0,sizeof($arry_txt)-1)] . '</div>'; 
	}


include('includes/footer.php');
?>
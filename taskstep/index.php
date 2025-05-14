<?php 
include("includes/header.php");
require_once("model/SettingDAO.php");
require_once("model/ItemDAO.php");
$itemdb = new ItemDAO();
$settingdb = new SettingDAO();
?>

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
display_frontpage();

	//Tips Box
	$tips = intval($settingdb->getSetting('tips'));
	if($tips == 1)
	{
		echo '<div id="tipsbox"><img src="images/information.png" alt="" />&nbsp;' . $l_index_tip . ':&nbsp;';
		//TEMPORARY LANGUAGE VALUE
		srand((double)microtime()*1000000); 
		$arry_txt=preg_split("/--NEXT--/",join('',file("lang/tips_$language.txt"))); 
		echo $arry_txt[rand(0,sizeof($arry_txt)-1)] . '</div>'; 
	}


include('includes/footer.php');
?>
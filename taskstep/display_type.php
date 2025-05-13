<?php
include("includes/header.php");
require_once("model/SectionDAO.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");

$sortby = (isset($_GET["sort"])) ? $_GET["sort"] : '';

$type = (isset($_GET['type'])) ? $_GET['type'] : '';


echo "<div id='editlist'>\n<p>".$l_dbp_l1[$type]."</p>";
//display the add project/context link
echo "<a href='edit_types.php?type=$type&amp;cmd=add' class='listlinkssmart'><img src='images/add.png' alt='' /> ".$l_dbp_add[$type]."</a>";

if ($type == "context"){
	$contextdb = new ContextDAO();
	$contexts = $contextdb->getAll();
	
	
	foreach($contexts as $s){
		//grab the title and the ID of the project/context
		$title=$s->getTitle();
		$id=$s->getId();

		//make the title a link
		echo "<a href='display.php?display=$type&amp;tid=$id&amp;sort=date' class='listlinkssmart'><img src='images/$type.png' alt='' /> $title</a>";
	}
}

if ($type == "project"){
	$contextdb = new ProjectDAO();
	$contexts = $contextdb->getAll();
	
	foreach($contexts as $s){
		//grab the title and the ID of the project/context
		$title=$s->getTitle();
		$id=$s->getId();

		//make the title a link
		echo "<a href='display.php?display=$type&amp;tid=$id&amp;sort=date' class='listlinkssmart'><img src='images/$type.png' alt='' /> $title</a>";
	}
}

echo "\n<a href='edit_types.php?type=$type' class='listlinkssmart'><img src='images/{$type}_edit.png' alt='' /> ".$l_dbp_edit[$type]."</a>\n</div>";

include('includes/footer.php');
?>
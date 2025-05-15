<?php
include("includes/header.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");

$sortby = (isset($_GET["sort"])) ? $_GET["sort"] : '';

$type = (isset($_GET['type'])) ? $_GET['type'] : '';

$type = (isset($_GET['type'])) ? $_GET['type'] : '';
$getcmd = (isset($_GET['cmd'])) ? $_GET['cmd'] : '';
$postcmd = (isset($_POST['cmd'])) ? $_POST['cmd'] : '';
$contextdb = new ContextDAO();
$projectdb = new ProjectDAO();
//actual mysql editing
if($postcmd == "edit" && isset($_POST["submit"]))
{
	$eid = $_POST["id"];
	$enewtitle = addslashes($_POST["title"]);
	if ($type == "context"){
		$context = $contextdb->getById($eid);
		$context->setTitle($enewtitle);
		$contextdb->Update($context);
	}
	
	if ($type == "project"){
		$project = $projectdb->getById($eid);
		$project->setTitle($enewtitle);
		$projectdb->Update($project);
	}
	
	
	echo "<div id='updated' class='fade'><img src='images/pencil_go.png' alt=''/> ".$l_msg_updated[$type]."</div>";
}

//adding in mysql
if($postcmd == "add" && isset($_POST["add"]))
{
	$title = addslashes($_POST["newtitle"]);

	if ($type == "context"){
		$context = new Context();
		$context->setTitle($title);
		$contextdb->Add($context);
	}
	
	if ($type == "project"){
		$project = new Project();
		$project->setTitle($title);
		$projectdb->Add($project);
	}
	
	echo "<div id='updated' class='fade'><img src='images/add.png' alt=''/> ".$l_msg_added[$type]."</div>";
}

//deleting in mysql
if($getcmd=="delete")
{
    $delid = $_GET["id"];
	if ($type == "context"){
		$contextdb = new ContextDAO();
		$contextdb->Delete($delid);
	}
	
	if ($type == "project"){
		$projectdb = new ProjectDAO();
		$projectdb->Delete($delid);
	}

    echo "<div id='deleted' class='fade'><img src='images/bin.png' alt='' /> ".$l_msg_deleted[$type]."</div>";
}

?>

<div id="sectiontitle">
	<?php if ($type == "context") :?>
		<h1><?= $l_nav_context?></h1>
	<?php endif; ?>
	<?php if ($type == "project")  :?>
		<h1><?= $l_nav_project?></h1>
	<?php endif; ?>
</div>

<div class="breaker"></div>
<div id='editlist'>
	<p><?= $l_dbp_l1[$type] ?></p>
	<a href='edit_types.php?type=<?= $type?>&cmd=add' class='listlinkssmart'><img src='images/add.png' alt='' /> <?= $l_dbp_add[$type] ?></a>

	<?php
		if ($type == "context"){
			$contextdb = new ContextDAO();
			$res = $contextdb->getAll();
		}

		if ($type == "project"){
			$contextdb = new ProjectDAO();
			$res = $contextdb->getAll();
		}
	?>

			<?php foreach($res as $s) : ?>
				<?php
					$title=$s->getTitle();
					$id=$s->getId();
				?>
				<div>
					<a href="display.php?display=<?= $type?>&tid=<?= $id ?>&sort=date" class='listlinkssmart' >
						<img src='images/<?= $type ?>.png' alt='' /> <?= $title ?>
					</a>
					<a href="edit_types.php?type=<?= $type ?>&amp;cmd=edit&amp;id=<?= $id ?>" >
						<img src="images/pencil.png" alt=""> 
						<?= $l_dbp_edit[$type] ?>
					</a>
					<a href="display_type.php?type=<?= $type ?>&cmd=delete&id=<?= $id ?>" 
						onclick="return confirm('Are you sure you want to delete this <?= $type ?>?');">
						<img src="images/bin_empty.png" alt="" />
						<?=  $l_dbp_del[$type] ?>
					</a>
				</div>
			<?php endforeach; ?>
</div>
<?php
include('includes/footer.php');
?>
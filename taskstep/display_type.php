<?php
include("includes/header.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");

$sortby = (isset($_GET["sort"])) ? $_GET["sort"] : '';

$type = (isset($_GET['type'])) ? $_GET['type'] : '';

?>

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
				<a href="display.php?display=<?= $type?>&tid=<?= $id ?>&sort=date" class='listlinkssmart'><img src='images/<?= $type ?>.png' alt='' /> <?= $title ?></a>
			<?php endforeach; ?>
<a href="edit_types.php?type=<?= $type?>" class='listlinkssmart'><img src='images/<?= $type ?>_edit.png' alt='' /> <?= $l_dbp_edit[$type] ?></a></div>
<?php
include('includes/footer.php');
?>
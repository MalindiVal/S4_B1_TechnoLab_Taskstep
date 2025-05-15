<?php
include("includes/header.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");
require_once("model/Context.php");
require_once("model/Project.php");
require_once("model/ItemDAO.php");
$itemdb = new ItemDAO();
$contextdb = new ContextDAO();
$projectdb = new ProjectDAO();
$type = (isset($_GET['type'])) ? $_GET['type'] : '';
$getcmd = (isset($_GET['cmd'])) ? $_GET['cmd'] : '';
$postcmd = (isset($_POST['cmd'])) ? $_POST['cmd'] : '';

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

//if the GET cmd has not been initialized, display a list of everything
if(!$getcmd || $getcmd == "delete")
{
	echo "<p>".$l_dbp_l2[$type]."</p>";
	echo "<div id='editlist'><a href='edit_types.php?type=$type&amp;cmd=add' class='listlinkssmart'><img src='images/add.png' alt='' /> ".$l_dbp_add[$type]."</a>";
	
	if ($type == "context"){
		$contextdb = new ContextDAO();
		$contexts = $contextdb->getAll();
		
		
		foreach($contexts as $s){
			//grab the title and the ID of the project/context
			$title=$s->getTitle();
			$id=$s->getId();
	
			//make the title a link
			echo "<a href='edit_types.php?type=$type&amp;cmd=edit&amp;id=$id' class='listlinkssmart'><img src='images/pencil.png' alt='' /> $title</a>";
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
			echo "<a href='edit_types.php?type=$type&amp;cmd=edit&amp;id=$id' class='listlinkssmart'><img src='images/pencil.png' alt='' /> $title</a>";
		}
	}
		
	echo "</div>";
}
	
//Edit form
elseif($getcmd == "edit")
{
	//DEBUG NB: quick error trap
			
	if(!$_GET["id"])
	{
		echo "<div class='error' style='font-size:9pt; padding:5px; '><img src='images/exclamation.png' alt='' style='vertical-align:-3px;' /> ".$l_msg_noid."</div>";
		echo "<span class='linkback'><a href='edit_types.php?type=$type' class='linkback'>Return to editing {$type}s</a></span></div>";
		die;
	}
	
	$editid = intval($_GET["id"]);
	
	//DEBUG echo "This would produce an edit form for the context with id $editid <br />";
	
	if ($type == "context"){
		$contextdb = new ContextDAO();
		$context = $contextdb->getById($editid);
		
		
		$title=$context->getTitle();
		$id=$context->getId();
	}
	
	if ($type == "project"){
		$projectdb = new ProjectDAO();
		$project = $projectdb->getById($editid);
		
		$title=$project->getTitle();
		$id=$project->getId();
	}

	//DEBUG echo "The MySQL code has matched this to the context with the following: <br />";
	//DEBUG echo "ID: $editid2 <br />";
	//DEBUG echo "Title: $edittitle <br />";
?>
	<form action="display_type.php?type=<?php echo $type ?>" method="post">
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="hidden" name="oldtitle" value="<?php echo $title; ?>" />
		<?php echo $l_forms_title ?>&nbsp;<input type="text" name="title" value="<?php echo $title; ?>" size="30" required/><br /><br />
		<input type="hidden" name="cmd" value="edit">
		<input type="checkbox" name="tasks" checked>&nbsp;<?php echo $l_msg_updateassoctasks; ?><br />
		<br />
		<input type="submit" name="submit" value="<?php echo $l_dbp_edit[$type]; ?>" onclick="return confirm('Are you sure you want to update this <?= $type ?>?');"/>
	</form>
	<?php
	}

//Add form
elseif($getcmd == "add")
{?>
	<form action="display_type.php?type=<?= $type ?>" method="post">
		<?= $l_forms_title ?>&nbsp;<input type="text" name="newtitle" value="<?= $l_dbp_new[$type];?>" size="30" required/><br />
		<br />
		<input type="hidden" name="cmd" value="add" />
		<input type="submit" name="add" value="<?= $l_dbp_add[$type]; ?>"  onclick="return confirm('Are you sure you want to create this <?= $type ?>?');" />
	</form>
<?php
}

include('includes/footer.php');
?>

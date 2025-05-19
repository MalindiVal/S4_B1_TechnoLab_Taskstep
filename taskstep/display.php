<?php
include("includes/header.php");
require_once("model/SectionDAO.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");
require_once("model/ItemDAO.php");
$itemdb = new ItemDAO();
//This is where all the action happens. Most php files in TaskStep link here in some form or another, so best advice is DON'T CHANGE IT!

if (isset($_GET["cmd"])) {
	$id = intval($_GET["id"]);
	switch ($_GET["cmd"]) {
		case "delete":
			$itemdb->Delete($id);
			break;
		case "do":
			$itemdb->setChecked(true, $id);
			echo "<div id='updated' ><img src='images/accept.png' alt='' /> " . $l_msg_itemdo . "</div>";
			break;
		case "undo":
			$itemdb->setChecked(false, $id);
			echo "<div id='deleted' ><img src='images/undone.png' alt='' /> " . $l_msg_itemundo . "</div>";
			break;
		default:	//Error trap it so that if a dodgy command is given it doesn't drop dead
			echo "<div class='error'><img src='images/exclamation.png' alt='' /> " . $l_msg_actionerror . "</div>";
			break;
	}
}

//This is the sorting form, as promised

$display = (isset($_GET["display"])) ? $_GET["display"] : '';
$sortby = (isset($_GET["sort"])) ? $_GET["sort"] : 'date';
$section = (isset($_GET["section"])) ? $_GET["section"] : '';
$tid = (isset($_GET["tid"])) ? intval($_GET["tid"]) : 0;
$page = (isset($_GET["page"])) ? intval($_GET["page"]) : 1;
$items_per_page = 10;

$title = "";
$backlink = "";
switch ($display) {

	case "section":
		//Massively cleaned up section which obtains section titles from the language file
		foreach ($l_sectionlist as $key => $value) {
			if ($section == $key) {
				$currentsection = $key;
				$sectiontitle = $value;
			}
		}

		$result = $itemdb->getAll($display, $tid, $sortby);
		$sdb = new SectionDAO();
		$title = $l_sectionlist[$sdb->getById($tid)->getTitle()];
		$noresultsurl = '?tid=' . $tid;
		$total_items = count($result);
		$total_pages = ceil($total_items / $items_per_page);
		$start_index = ($page - 1) * $items_per_page;
		$result = array_slice($result, $start_index, $items_per_page);
		break;
	case "project":
		$backlink = "display_type.php?type=project";
		$projectdb = new ProjectDAO();
		$idresult = $projectdb->getById($tid);
		$disptitle = $idresult->getTitle();
		$projectid = $idresult->getId();
		$result = $itemdb->getAll($display, $tid, $sortby);
		$title = $disptitle;
		$noresultsurl = '?tid=' . $tid;
		$total_items = count($result);
		$total_pages = ceil($total_items / $items_per_page);
		$start_index = ($page - 1) * $items_per_page;
		$result = array_slice($result, $start_index, $items_per_page);
		break;
	case "context":
		$backlink = "display_type.php?type=context";
		$contextdb = new ContextDAO();
		$idresult = $contextdb->getById($tid);
		$disptitle = $idresult->getTitle();
		$result = $itemdb->getAll($display, $tid, $sortby);
		;
		$title = $disptitle;
		$noresultsurl = '?tid=' . $tid;
		$total_items = count($result);
		$total_pages = ceil($total_items / $items_per_page);
		$start_index = ($page - 1) * $items_per_page;
		$result = array_slice($result, $start_index, $items_per_page);
		break;
	case "all":
		$result = $itemdb->getAll(null, null, $sortby);
		$title = $l_nav_allitems;
		$noresultsurl = '';
		$total_items = count($result);
		$total_pages = ceil($total_items / $items_per_page);
		$start_index = ($page - 1) * $items_per_page;
		$result = array_slice($result, $start_index, $items_per_page);
		break;
	case "today":
		$today = date("Y-m-d");
		$todayf = date($_SESSION["menu_date_format"]);
		$result = $itemdb->getAll($display, null, $sortby);
		$title = $l_nav_today . ": " . $todayf .
			$noresultsurl = '';
		$total_items = count($result);
		$total_pages = ceil($total_items / $items_per_page);
		$start_index = ($page - 1) * $items_per_page;
		$result = array_slice($result, $start_index, $items_per_page);
		break;
}
?>
<?php if ($display == "context" || $display == "project"): ?>
	<a href=<?= $backlink ?>><- Back</a>
		<?php endif; ?>
		<div id='sectiontitle'>
			<h1><?= $title ?></h1>
		</div>

		<?php
		sort_form($display, $section, $tid, $sortby); ?>

		<div> <?php
		$numberrows = count($result);
		if ($numberrows == 0) {
			$message = ($display == "today") ? $l_msg_notoday : $l_msg_noitems;
			echo "<div class='inform'><img src='images/information.png' alt='' />&nbsp;" . $message . " <a href='edit.php$noresultsurl'>" . $l_msg_addsome . "</a></div>";
		} else {
			foreach ($result as $res) {
				//the format is $variable = $r["nameofmysqlcolumn"];
				$title = htmlentities($res->getTitle());
				$date = $res->getDate();
				$date_display = date($_SESSION["task_date_format"], strtotime($date));
				$notes = htmlentities($res->getNotes());
				$urlfull = htmlentities($res->getUrl());
				$done = $res->isDone();
				$id = $res->getId();
				$context = htmlentities($res->getContext());
				$project = htmlentities($res->getProject());

				if ($urlfull == "")
					$url = "";
				else {
					$limit = 40; // set character limit
					$url = "<a href='$urlfull'>";
					// display URL up to character limit, shorten & add ellipsis if it is too long
					$url .= (strlen($urlfull) > $limit) ? substr($urlfull, 0, $limit) . '...</a>' : $urlfull . '</a>';
				}

				//Set up a few variables for the do/undo button
				$cmd = 'do';
				$link = $l_items_do;
				$icon = 'undone';

				//display the row
		
				//if the action is marked as done, then do not apply any current or old markings to it
				if ($done == 1) {
					echo "<div class='np'> <span style='text-decoration:line-through;'> $title - $date_display | $project | $context</span>";
					$cmd = 'undo';
					$link = $l_items_undo;
					$icon = 'accept';
				}

				//if the date doesn't exist, then don't display the date
				elseif ($date == 00 - 00 - 0000)
					echo "<div class='np'> $title | $project | $context";

				//if the date is equal to the current date, flag it as current
				elseif (date("Y-m-d") == $date)
					echo "<div class='current'><img src='images/flag_yellow.png' alt='' /> $title - $date_display | $project | $context";

				//if the date is older than the current date, flag it as old
				elseif (date("Y-m-d") > $date)
					echo "<div class='old'><img src='images/flag_red.png' alt='' /> $title - $date_display | $project | $context";

				//if the date is neither of these, don't flag it.
				else
					echo "<div class='np'> $title - $date_display | $project | $context";
				?>

					<br /><?= $notes ?> <br /><?= $url ?>
					<div class="actions">
						<a href="display.php?display=<?= $display ?>&cmd=delete&id=<?= $id ?>&tid=<?= $tid ?>"
							title="<?= $l_items_del ?>" class="actionicon"
							onclick="return confirm('Are you sure you want to delete this item?');">
							<img src="images/bin_empty.png" alt="<?= $l_items_del ?>" />
							<?= $l_items_del ?>
						</a>
						<a href="edit.php?id=<?= $id ?>" title="<?= $l_items_edit ?>" class="actionicon">
							<img src="images/pencil.png" alt="<?= $l_items_edit ?>" />
							<?= $l_items_edit ?>
						</a>
						<a href="display.php?display=<?= $display ?>&cmd=<?= $cmd ?>&id=<?= $id ?>&tid=<?= $tid ?>"
							title="<?= $link ?>" class="actionicon">
							<img src="images/<?= $icon ?>.png" alt="<?= $link ?>">
							<?= $link ?>
						</a>
					</div>
				</div>
			<?php
			}

			// Ajout de la pagination
			if ($total_pages > 1) {
				echo '<div class="pagination">';
				if ($page > 1) {
					echo '<a href="display.php?display=' . $display . '&sort=' . $sortby . '&section=' . $section . '&tid=' . $tid . '&page=' . ($page - 1) . '" class="btn btn-primary">Précédent</a> ';
				}
				echo '<span>Page ' . $page . ' sur ' . $total_pages . '</span>';
				if ($page < $total_pages) {
					echo ' <a href="display.php?display=' . $display . '&sort=' . $sortby . '&section=' . $section . '&tid=' . $tid . '&page=' . ($page + 1) . '" class="btn btn-primary">Suivant</a>';
				}
				echo '</div>';
			}
		}
		?>
		</div>

		<?php
		if (isset($_POST['submit'])) //If submit is hit
		{
			$section = $_POST['section'];
			$sortby = $_POST['sort'];
		}

		include('includes/footer.php');
		?>
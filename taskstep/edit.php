<?php
include("includes/header.php");
require_once("model/SectionDAO.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");
require_once("model/ItemDAO.php");
$itemdb = new ItemDAO();
$clear = false;

if ( isset($_GET["id"]) )	//If 'id' is set in the request URL, then the user is editing a task and we need to grab its data from the database
{
	$type = 'edit';
	$id = $_GET["id"];
	$result = $itemdb->getById($id);
	$title = $result->getTitle();
	$date  = $result->getDate();
	$section  = $result->getSectionId();
	$notes  = $result->getNotes();
	$url  = $result->getUrl();
	$done  = $result->isDone();
	$context  = $result->getContextId();
	$project  = $result->getProjectId();
	$date = ($date == 00-00-0000) ? '' : $date;
}
else if ( isset($_POST["submit"]) )	//Otherwise, if the user has submitted a form, grab the rest of the form data
{
	$type = (!empty($_POST['id'])) ? 'edit' : 'add';
	$title = addslashes($_POST['title']);
	$date = $_POST['end_date'];
	$section = isset($_POST['section_id']) ? $_POST['section_id'] : '';
	$notes = addslashes($_POST['notes']);
	$url = addslashes($_POST['url']);
	$done = '0';
	$context = isset($_POST['context_id']) ? addslashes($_POST['context_id']) : '';
	$project = isset($_POST['project_id']) ? addslashes($_POST['project_id']) : '';
	$item = new Item();
	$item->hydrate($_POST);
	$item->setDone(false);
	if( empty($section) || empty($context) || empty($project) )	//Make sure that the form data is valid
	{
		$id = '';
		echo "<div class='inform' style='font-size:9pt;'><img src='images/information.png' alt='' style='vertical-align:-3px;' /> ".$l_msg_unspecific."</div>";
	}
	else if ( !empty($_POST['id']) )	//If a task id was also sent in the form data, update that task
	{
		$id = $_POST['id'];
		$itemdb->Update($item);
		echo "<div id='updated' ><img src='images/pencil_go.png' alt=''/> ".$l_msg_itemedit."</div>";
	}
	else	//Otherwise, add the data as a new task
	{
		$itemdb->Add($item);
		echo "<div id='updated' ><img src='images/note_go.png' alt='' /> ".$l_msg_itemadd."</div>";
		$clear = true;
	}
}
else	//If neither of the previous conditionals were true, we simply need to create a blank "Add" form
{
	$type = 'add';
	$clear = true;
}

if ($clear)	//If 'clear' is true, we set the form values to blank/default values
{
	$id = '';
	$title = $l_forms_titledefval;
	$date = '';
	$section = (isset($_GET['section'])) ? $_GET['section'] : '';
	$notes = '';
	$url = '';
	$context = (isset($_GET['context'])) ? $_GET['context'] : '';
	$project = (isset($_GET['project'])) ? $_GET['project'] : '';
}
?>
<h1>
	<?= $l_forms_button[$type] ?> <?php if ($type == 'edit') : ?> : <?php echo $title ?><?php endif ; ?>
</h1>
<form method="post" action="edit.php" id="addform" class="container mt-4">
  <input type="hidden" name="id" value="<?php echo $id ?>" />

  <!-- Title -->
  <div class="mb-3 row">
    <label for="addtitle" class="col-sm-2 col-form-label"><?php echo $l_forms_title; ?>:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="addtitle" name="title" value="<?php echo $title ?>" required />
    </div>
  </div>

  <!-- Notes -->
  <div class="mb-3 row">
    <label for="notes" class="col-sm-2 col-form-label"><?php echo $l_forms_notes; ?>:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="notes" name="notes" value="<?php echo $notes ?>" required />
    </div>
  </div>

  <!-- Section / Context / Project -->
  <div class="row mb-3">
    <div class="col-md-4">
      <label for="section_id" class="form-label"><?php echo $l_forms_section; ?>:</label>
      <select class="form-select" id="section_id" name="section_id" size="7" required>
        <?php
          $sectiondb = new SectionDAO();
          $sections = $sectiondb->getAll();
          foreach ($sections as $s) {
            $selected = ($section == $s->getId()) ? 'selected' : '';
            echo "<option value='" . $s->getId() . "' $selected>" . $l_sectionlist[$s->getTitle()] . "</option>\n";
          }
        ?>
      </select>
    </div>

    <div class="col-md-4">
      <label for="context_id" class="form-label"><?php echo $l_forms_context; ?>:</label>
      <select class="form-select" id="context_id" name="context_id" size="7" required>
        <?php
          $contextdb = new ContextDAO();
          $contexts = $contextdb->getAll();
          foreach ($contexts as $s) {
            $selected = ($context == $s->getId()) ? 'selected' : '';
            echo "<option value='" . $s->getId() . "' $selected>" . $s->getTitle() . "</option>\n";
          }
        ?>
      </select>
      <div class="mt-1">
        <a href="edit_types.php?type=context" class="listlinkstyle">
          <img src="images/context_edit.png" alt="" /> <?php echo $l_forms_contexte; ?>
        </a>
      </div>
    </div>

    <div class="col-md-4">
      <label for="project_id" class="form-label"><?php echo $l_forms_project; ?>:</label>
      <select class="form-select" id="project_id" name="project_id" size="7" required>
        <?php
          $projectdb = new ProjectDAO();
          $projects = $projectdb->getAll();
          foreach ($projects as $s) {
            $selected = ($project == $s->getId()) ? 'selected' : '';
            echo "<option value='" . $s->getId() . "' $selected>" . $s->getTitle() . "</option>\n";
          }
        ?>
      </select>
      <div class="mt-1">
        <a href="edit_types.php?type=project" class="listlinkstyle">
          <img src="images/project_edit.png" alt="" /> <?php echo $l_forms_projecte; ?>
        </a>
      </div>
    </div>
  </div>

  <!-- End Date -->
<div class="mb-3 row">
  <label for="end_date" class="col-sm-2 col-form-label">
    <?= $l_forms_date; ?>:
  </label>
  <div class="col-sm-10">
    <input 
      type="date"
      class="form-control"
      id="end_date"
      name="end_date"
      value="<?= htmlspecialchars($date); ?>"
      required
      aria-describedby="dateHelp"
    />
    <div id="dateHelp" class="form-text">
      <?= $l_forms_date_hint ?? 'Select a due date.'; ?>
    </div>
  </div>
</div>


  <!-- URL -->
  <div class="mb-3 row">
    <label for="url" class="col-sm-2 col-form-label"><?php echo $l_forms_url; ?>:</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="url" name="url" value="<?php echo $url ?>" required />
    </div>
  </div>

  <!-- Submit -->
  <div class="row">
    <div class="col-sm-10 offset-sm-2">
      <button type="submit" class="btn btn-primary" name="submit"
              onclick="return confirm('Are you sure of those informations?');">
        <?php echo $l_forms_button[$type]; ?>
      </button>
    </div>
  </div>
</form>

<?php include('includes/footer.php') ?>
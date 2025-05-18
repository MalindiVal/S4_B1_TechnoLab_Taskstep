<?php
include("sessioncheck.php");	//Initialize DB connection and make sure the user is logged in
include("lang/".$language.".php");
include("functions.php");
require_once("./model/SettingDAO.php");
require_once("./model/SectionDAO.php");
?>
<!DOCTYPE html >
<html lang="en" >
<head>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TaskStep</title>

<link href="public/bootstrap-5.3.6-dist/css/bootstrap.min.css" rel="stylesheet" >
<?php 
	if (isset($_SESSION["user_id"])){
		$settingdb = new SettingDAO();
		$setting = $settingdb->getAll();
		$value = $setting->getStylesheet();
	} else {
		$value = "default.css";
	}
	
	echo "<link rel='stylesheet' type='text/css' href='styles/".$value."' media='screen' />";
?>
<link rel="stylesheet" type="text/css" href="styles/system/print.css" media="print" />
<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php selfref_url(); ?>rss.php" /> 
<script src="public/bootstrap-5.3.6-dist/js/bootstrap.bundle.min.js" ></script>
<?php pagespecific()?>
<script type="text/javascript" src="script/fat.js"></script>
</head>

<body>

<!--Open container-->
<div id="sexyBG"></div><div id="sexyBOX" onmousedown="document.onclick=function(){};" onmouseup="setTimeout('sexyTOG()',1);"></div>



<!--Header-->
<!-- Responsive Header and Navigation -->
<nav class="navbar navbar-expand-lg sticky-top" id="headernav">
  <div class="container-fluid">
    <!-- Brand / Logo -->
    <a class="navbar-brand d-flex align-items-center" href="index.php">
      <img src="images/icon.png" alt="TaskStep Icon" width="30" height="30" class="d-inline-block align-text-top me-2">
      TaskStep <span class="subtitle ms-1">1.1</span>
    </a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTaskstep" aria-controls="navbarTaskstep" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible nav items -->
    <div class="collapse navbar-collapse" id="navbarTaskstep">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="display.php?display=today&amp;sort=done">
            <img src="images/calendar_view_day.png" alt="" class="me-1" />
            <?php echo $l_nav_today; ?>: <?php echo date($menu_date_format); ?>
          </a>
        </li>
        <li class="nav-item"><a class="nav-link" href="index.php"><img src="images/house.png" alt="" class="me-1" /><?php echo $l_nav_home; ?></a></li>
        <li class="nav-item"><a class="nav-link" href="display.php?display=all&amp;sort=date"><img src="images/page_white_text.png" alt="" class="me-1" /><?php echo $l_nav_allitems; ?></a></li>
        <li class="nav-item"><a class="nav-link" href="display_type.php?type=context"><img src="images/context.png" alt="" class="me-1" /><?php echo $l_nav_context; ?></a></li>
        <li class="nav-item"><a class="nav-link" href="display_type.php?type=project"><img src="images/project.png" alt="" class="me-1" /><?php echo $l_nav_project; ?></a></li>
        <li class="nav-item"><a class="nav-link" href="settings.php"><img src="images/textfield_rename.png" alt="" class="me-1" /><?php echo $l_nav_settings; ?></a></li>
        <li class="nav-item"><a class="nav-link" href="http://www.cunningtitle.com/taskstep"><img src="images/help.png" alt="" class="me-1" /><?php echo $l_nav_help; ?></a></li>
        <li class="nav-item"><a class="nav-link" href="login.php?action=logout"><img src="images/door_in.png" alt="" class="me-1" /><?php echo $l_nav_logout; ?></a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid ">
  <div class="row">

    <!-- Sidebar -->
    <nav id="sidebar" class="col-md-3 col-lg-2 d-none d-md-block  sidebar py-3">
      <ul class="nav flex-column">
        <li class="nav-item"><a class="nav-link" href="edit.php"><?php echo $l_side_add; ?></a></li>
        <?php
          $db = new SectionDAO();
          $results = $db->getRatio();
        ?>
        <?php foreach ($results as $result): ?>
          <?php
            $title = htmlspecialchars($result->getTitle(), ENT_QUOTES, 'UTF-8');
            $finished = (int)$result->getFinished();
            $total = (int)$result->getTotal();
            $percentage = ($total > 0) ? round((100 * $finished) / $total) : 0;
            $label = htmlspecialchars($l_sectionlist[$result->getTitle()] ?? $result->getTitle(), ENT_QUOTES, 'UTF-8');
          ?>
          <li class="nav-item">
            <a class="nav-link <?= $title ?>" href="display.php?display=section&amp;section=<?= urlencode($result->getTitle()) ?>&amp;sort=date&tid=<?= $result->getId() ?>">
              <?= $label ?>
              <div>(<?= $finished ?> / <?= $total ?>)</div>
            </a>
          </li>
        <?php endforeach; ?>
      </ul>
    </nav>
	<!-- Toggle button for mobile -->
	<button class="btn d-md-none my-2 ms-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
	☰ Sections
	</button>

	<!-- Offcanvas Sidebar -->
	<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
	<div class="offcanvas-header">
		<h5 class="offcanvas-title" id="offcanvasSidebarLabel">Sections</h5>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body">
		<ul class="nav flex-column">
		<li class="nav-item"><a class="nav-link" href="edit.php"><?php echo $l_side_add; ?></a></li>
		<?php
			$db = new SectionDAO();
			$results = $db->getRatio();
		?>
		<?php foreach ($results as $result): ?>
			<?php
			$title = htmlspecialchars($result->getTitle(), ENT_QUOTES, 'UTF-8');
			$finished = (int)$result->getFinished();
			$total = (int)$result->getTotal();
			$label = htmlspecialchars($l_sectionlist[$result->getTitle()] ?? $result->getTitle(), ENT_QUOTES, 'UTF-8');
			?>
			<li class="nav-item <?= $title ?>">
			<a class="nav-link <?= $title ?>" href="display.php?display=section&amp;section=<?= urlencode($result->getTitle()) ?>&amp;sort=date&tid=<?= $result->getId() ?>">
				<?= $label ?>
				<div>(<?= $finished ?> / <?= $total ?>)</div>
			</a>
			</li>
		<?php endforeach; ?>
		</ul>
	</div>
	</div>
	

    <!-- Main content -->
    <main id="content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">

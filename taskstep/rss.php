<?php
Header('Content-type: text/xml; charset=utf-8');
require_once("model/SectionDAO.php");
require_once("model/ContextDAO.php");
require_once("model/ProjectDAO.php");
require_once("model/ItemDAO.php");
require_once("config.php");
require_once("includes/functions.php");

$itemdb = new ItemDAO();
$contextdb = new ContextDAO();
$projectdb = new ProjectDAO();

connect();

// Build base URL
$dirstuff = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
$full = "http://" . $_SERVER['HTTP_HOST'] . $dirstuff;

// Fetch all completed tasks
$result = $itemdb->getAll(null, null, "done");

// Output RSS
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<rss version="2.0">
	<channel>
		<title>TaskStep</title>
		<link><?php echo htmlspecialchars($full); ?></link>
		<description>TaskStep Items Feed</description>
		<language>en-us</language>
		<generator>IceMelon RSS Feeder</generator>

<?php
foreach ($result as $res) {
	$title = htmlspecialchars($res->getTitle());
	$dateRaw = $res->getDate();
	$date = (!empty($dateRaw) && $dateRaw != '0000-00-00') ? $dateRaw . " | " : '';
	$notes = htmlspecialchars($res->getNotes());
	$url = htmlspecialchars($res->getUrl());
	$id = $res->getId();

	// Context
	$context = htmlspecialchars($res->getContext());

	// Project
	$project = htmlspecialchars($res->getProject());

	$rssnotes = !empty($notes) ? " | " . $notes : '';

	echo <<<XML
		<item>
			<title>{$title}</title>
			<link>{$full}edit.php?id={$id}</link>
			<description><![CDATA[{$date}{$project} | {$context}{$rssnotes}]]></description>
		</item>

XML;
}
?>

	</channel>
</rss>

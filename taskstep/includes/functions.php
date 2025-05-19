<?php
require_once("./model/SettingDAO.php");

function pagespecific(){
	global $language, $l_cp_tools_purgecheck;
	$currentFile = $_SERVER["SCRIPT_NAME"];
    $parts = Explode('/', $currentFile);
    $currentFile = $parts[count($parts) - 1];
	switch ($currentFile)
	{
	case 'edit.php':
		echo '<style type="text/css">';
		readfile('styles/system/jacs.css');
		echo '</style>' . "\n";
		echo '<script type="text/javascript" src="script/jacsLang.js"></script>' . "\n";
		echo '<script type="text/javascript" src="script/jacs.js"></script>' . "\n";
		echo '<script type="text/javascript">
		function setLanguages(jacsLanguage) {	// Set all calendars to the chosen language
		for (var i=0;i<JACS.cals().length;i++)
		{
			var jacsCal = document.getElementById(JACS.cals()[i]);

			jacsCal.language = jacsLanguage;
			jacsSetLanguage(jacsCal);

			// Refresh any static calendars so that the change shows immediately.
			if (!jacsCal.dynamic) JACS.show(jacsCal.ele,jacsCal.id,jacsCal.days);
		}
		};
		window.onload = function() {
			JACS.make("jacs",true);
			setLanguages("'.$_SESSION["lang"] .'");
			if (document.getElementById("addtitle")) {
				document.getElementById("addtitle").focus();
				document.getElementById("addtitle").select();
			}
		};
		</script>' . "\n";
	break;
	case 'settings.php':
		echo '<script type="text/javascript">function check(){
				var message;
				message = confirm("'.$l_cp_tools_purgecheck.'");
				if (message) {
					this.location.href = "settings.php?delete=confirm";
				} else {
					this.location.href = "settings.php";
				}
			}</script>';
	break;
	}
}



function selfref_url(){
	$dirstuff = str_replace(basename($_SERVER['PHP_SELF']), '', $_SERVER['PHP_SELF']);
	$full = "http://".$_SERVER['HTTP_HOST'].$dirstuff;
	echo $full;
}

function sort_form($type = '', $section = '', $tid = '', $sortby = ''){
	
	global $l_items_sorttext, $l_items_sort, $l_items_sortbutton, $l_items_print;
	$sortby = ($sortby) ? $sortby : 'done';
	
	switch($type) {
		case 'section':
			$printurl = "print=section&amp;id=$tid";
			$hidden = "<input type='hidden' name='tid' value='$tid' />";
		break;
		case 'context':
			$printurl = "print=$type&amp;id=$tid";
			$hidden = "<input type='hidden' name='tid' value='$tid' />";
		break;
		case 'project':
			$printurl = "print=$type&amp;id=$tid";
			$hidden = "<input type='hidden' name='tid' value='$tid' />";
		break;
		case 'today':
			$printurl = "print=today";
			$hidden = "";
		break;
		case 'all':
			$printurl = "print=all";
			$hidden = "";
		break;
	}
	?>
	<div class="sortform">
	<p><span class='printer'><a href="print.php?<?php echo $printurl; ?>"><img src='images/printer.png' alt='' /> <?php echo $l_items_print; ?></a></span></p>
	<form action="display.php" method="get">
	<div>
	<input type="hidden" name="display" value="<?php echo $type ?>" />
	<?php echo $hidden . $l_items_sorttext ?>
	<select name="sort">
		<?php
		foreach ($l_items_sort AS $key=>$value)
		{
			if ($key != $type)
			{
				$selected = ($sortby == $key) ? ' selected="selected"' : '';
				echo '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
			}
		}
		?>
	</select>
	<input type="submit" value="<?php echo $l_items_sortbutton; ?>" />
	</div>
	</form>
	</div><?php
}
?>
<?php
session_start();

include("config.php");
include("includes/functions.php");
include("Controller/injectorContoller.php");

//Appelle de la méthode permettant la connexiuon
$userController = InjectorContoller::getLoginController();
$user = $userController->connexion();

$settingController = InjectorContoller::getSettingController();


if ($user){
	//Récupération de variable réutilisable
	$setting = $settingController->getSettingByUser($user->getId());
	$_SESSION['user'] = $user;
	$_SESSION["user_id"] = $user->getId();
	$_SESSION['setting'] = $setting;
	
}
else{
	$setting = new Setting(); 
    $setting->setStylesheet("default.css"); 
    $setting->setSession(1); 
}



header("Cache-control: private");
include("lang/".$language.".php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>TaskStep - Login</title>
<?php 
	$value = $setting->getStylesheet();
	echo "<link rel='stylesheet' type='text/css' href='styles/".$value."' media='screen' />";
?>
</head>

<body>

<!--Open container-->
<div id="container">
<?php
$sessionssetting = $setting->getSession();
?>
<div id="loginbox">
<h1><img src="images/icon.png" alt="" /> TaskStep</h1>
<?php if($sessionssetting == '1'){ ?>
<p><img src="images/shield.png" alt="" />&nbsp;<?php echo $l_login_l1; ?></p>
<form action="login.php" method="post">
	<div>
		<label for="MailConnexion">Email</label>
		<input type="text" name="identifiant">
	</div>
	<div>
		<label for="PwdConnexion">Passord</label>
		<input type="password" name="password" />&nbsp;
	</div>
	<div>
		<input type="text" style="display: none;" />	<!--IE workaround: pressing "enter" will submit the form-->
		<input type="submit" name="submit" value="<?php echo $l_login_button; ?>" />
	</div>
</form> <?php }
else{ ?>
  <p><img src="images/shield_error.png" alt="" />&nbsp;<?php echo $l_login_l5; ?></p>
<form action="login.php" method="post">
<p><input type="password" disabled="disabled" name="password" /> <input type="submit" disabled="disabled" name="submit" value="<?php echo $l_login_button; ?>" /></p>
</form>
<p><a href='index.php'><?php echo $l_login_l3; ?></a></p>
<?php }

//Uncomment the next line for session debugging
//echo $_SESSION["loggedin"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($user == null) {
        echo "<p><img src='images/cross.png' alt='' /> ".$l_login_l4."</p>";
    }
}
?>

<span class="securityinfo">TaskStep login system version 1.0</span>

<?php include('includes/footer.php') ?>
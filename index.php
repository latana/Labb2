<?php

require_once("controller.php");
require_once("HTMLPageView.php");

setlocale(LC_ALL, "sv_SE", "sv_SE.utf-8", "sv", "swedish");

session_start();

// Kontrollerar session
if(isset($_SESSION["Session controller"]) == false){
	$_SESSION["Session controller"] = array();
	$_SESSION["Session controller"]["webbläsare"] = $_SERVER["HTTP_USER_AGENT"];
	$_SESSION["Session controller"]["ip"] = $_SERVER["REMOTE_ADDR"];
}
// Tar bort session och cookies om session inte stämmer
if($_SESSION["Session controller"]["webbläsare"] != $_SERVER["HTTP_USER_AGENT"]){
			
		unset($_SESSION['mySess']);
		setcookie("cookieUser", "", time()-9999999);
		setcookie("cookiePass", "", time()-9999999);	
}

$login = new \controller\Controller();
echo $login->myLogin();
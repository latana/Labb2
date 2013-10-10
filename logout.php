<?php

namespace logout; // Kommer hit när man trycker på logga ut

	session_start();
	
	unset($_SESSION['mySess']);
	
	setcookie("cookieUser", "", time()-9999999);
		
	setcookie("cookiePass", "", time()-9999999);
	
	$_SESSION['outMessage'] = "<p>Du är nu utloggad</p>";
	
	header('Location: index.php');
	
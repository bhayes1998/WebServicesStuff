<?php
// Bryan Hayes
// CSE451
// 2/22/2021
// Week5 Assignment - CAS
session_start();
require_once 'config.php';   //get configuration
// Load the CAS lib
require_once 'vendor/autoload.php';
require_once 'vendor/apereo/phpcas/CAS.php';


// Initialize phpCAS from settings in config.php
phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);

phpCAS::setNoCasServerValidation();  // disables ssl server verification - ok for testing and required for now

if (!isset($_SESSION["user"])) {
	// force CAS authentication -> this is where the system does the CAS authentication.
	phpCAS::forceAuthentication();
	$user = phpCAS::getUser();
	$_SESSION["user"] = $user;
} else {
	$user = $_SESSION["user"];
}

// logout if desired
if (isset($_REQUEST['logout'])) {
    phpCAS::logout();
}

?>
<html>
<head>
<title>Week5 Assignment</title> 
</head>
<body>
	<script>
	function onClick(){
		location.href("/Display.php");
	}
	</script>

	<h1>Welcome <?php echo $user ?>!</h1>

	<form action="Display.php"><input type="submit" value="Go to Display.php"></form>
</body> 
</html>

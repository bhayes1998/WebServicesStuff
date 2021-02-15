<?php
// Bryan Hayes
// CSE451
// 2/15/2021
// Assignment - PHP Sessions and Database
// Resource I used: https://phppot.com/php/user-authentication-using-php-and-mysql/
session_start();
if (isset($_SESSION["uid"])){
        header("Location: Display.php");
}

require_once("config.php");
$message="";
if(count($_POST)>0) {
	$conn = mysqli_connect("localhost",$name,$password,"auth");
	$result = mysqli_query($conn,"SELECT * FROM users WHERE name='" . $_POST["userName"] . "' and password = md5('". $_POST["password"]."')");
	$count  = mysqli_num_rows($result);
	if($count==0) {
		$message = "Invalid Username or Password!";

	} else {
		$_SESSION["uid"] = $_POST["userName"];
		error_log("User " + $_SESSION["uid"] + " has logged in", 0);
		header("Location: Display.php");
	}
}
?>
<html>
<body>
<form name="frmUser" method="post" action="">
	<div class="message"><?php if($message!="") { echo $message; } ?></div>
		<table border="0" cellpadding="10" cellspacing="1" width="500" align="center" class="tblLogin">
			<tr class="tableheader">
			<td align="center" colspan="2">Enter Login Details</td>
			</tr>
			<tr class="tablerow">
			<td>
			<input id="nameInput" type="text" name="userName" placeholder="User Name" class="login-input"></td>
			</tr>
			<tr class="tablerow">
			<td>
			<input type="password" name="password" placeholder="Password" class="login-input"></td>
			</tr>
			<tr class="tableheader">
			<td align="center" colspan="2"><input type="submit" name="submit" value="Submit" class="btnSubmit"></td>
			</tr>
		</table>
</form>
</body>
</html>


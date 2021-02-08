<?php
/*
   scott campbell
   week 2 rest server

   api:

   Get list of keys from server

   url: /api/v1/info
   method: get
   json_in: Um, there is none with get
   json_out: {status:OK|fail, msg: string, keys:[array of strings]}

   Get data with key:
   url: /api/v1/info
   method: post
   json_in: {key:string}
   json_out: {status:OK|fail, msg: string, value:string}

 */


//the following is used to allow any site to access our rest api

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUSH,OPTIONS");
header("content-type: application/json");
header("Access-Control-Allow-Headers: Content-Type");
session_start();
include "info.php";


function sendJson($status,$msg,$result) {
	$returnData = array();
	$returnData['status'] = $status;
	$returnData['msg'] = $msg;
    if (count($result) >0)
	foreach ($result as $k=>$v) {
		$returnData[$k] = $v;
	}

	print json_encode($returnData);
	exit;
}

//parse parts
if (isset($_SERVER['PATH_INFO'])) {
	$parts = explode("/",$_SERVER['PATH_INFO']);
	//sanitize
	for ($i=0;$i<count($parts);$i++) {
		$parts[$i] = htmlspecialchars($parts[$i]);
	}
} else {
	$parts = array();
}

array_shift($parts);	//get rid of first part of url which is bogus
//get method type

$method = strtolower($_SERVER['REQUEST_METHOD']);

if ($method == "options") {
	exit;
}

/*
$a=rand(1,100);
if ($a<80) {
	header("HTTP/1.1 500 NO");
	exit;
}
 */


if ($method=="get" &&  sizeof($parts) == 3 && $parts[0] == "api"  && $parts[1] == "v1" && $parts[2] == "info") {
	$keys = getKeys();
	$retData = array("keys"=>$keys);
	$a = print_r($retData,true);
	error_log($a);
	sendJSON("ok","",$retData);

}
elseif ($method=="get" &&  sizeof($parts) == 4 && $parts[0] == "api"  && $parts[1] == "v1" && $parts[2] == "info") {
	$value= getValue(htmlspecialchars($parts[3]));
	$retData = array("value"=>$value);
	$a = print_r($retData,true);
	error_log("key=" . $parts[3] . " response= " .$a);

	sendJSON("ok","",$retData);
}
elseif ($method=="post" &&  sizeof($parts) == 3 && $parts[0] == "api"  && $parts[1] == "v1" && $parts[2] == "info") {
	//get and parse body
	$jsonBody = array();
	$errormsg = "none";
	try {
# Get JSON as a string
		$json_str = file_get_contents('php://input');

# Get as an object
		$jsonBody = json_decode($json_str,true);
	} catch (Exception $e) {
		$errormsg = $e->getMessage();
		sendJson("FAIL","JSON DECODE ERROR " . $errormsg,array());
	}

	if (!isset($jsonBody['key'])) {
		sendJson("FAIL","JSON DECODE ERROR no key",array());
	}
	$key = htmlspecialchars($jsonBody['key']);

	error_log("POST " . $key);
	$v = getValue($key);
	sendJson("OK","",array('value'=>$v));

}
elseif ($method=="put" &&  sizeof($parts) == 3 && $parts[0] == "api"  && $parts[1] == "v1" && $parts[2] == "info") {
	//get and parse body
	$jsonBody = array();
	$errormsg = "none";
	try {
# Get JSON as a string
		$json_str = file_get_contents('php://input');

# Get as an object
		$jsonBody = json_decode($json_str,true);
	} catch (Exception $e) {
		$errormsg = $e->getMessage();
		sendJson("FAIL","JSON DECODE ERROR " . $errormsg,array());
	}

	if (!isset($jsonBody['key']) || !isset($jsonBody['value']) || !isset($jsonBody['pass'])) {
		sendJson("FAIL","JSON DECODE ERROR missing parameters",array());
	}
	$key = htmlspecialchars($jsonBody['key']);
	$value = htmlspecialchars($jsonBody['value']);
	$pass = htmlspecialchars($jsonBody['pass']);
    
    $result = add($key,$value,$pass);
    sendJson($result,"",array());

}

else
{
  sendJSON("INVALID URL","",array());
}


header($_SERVER['SERVER_PROTOCOL'] . ' 404 Invalid URL' , true, 400);
?>

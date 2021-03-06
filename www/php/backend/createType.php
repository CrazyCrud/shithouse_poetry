<?php

####################### ADMIN ONLY #############################

// How to use this page:
// open it with the info about the type you wish to create,
// your authkey and the description of the type:
//
// createType.php?authkey=xxx&name=bla&desc=moep
//
// required parameters are:
// authkey, name, desc
//
// The answer looks as follows:
// a json with a successcode and the type id:
/* 
{
	"success":1,
	"data":2
}
*/
// for success codes see ../php/config.php

// HEADER
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);
include_once("../settings/config.php");
include_once("../helpers/dbhelper.php");
// END HEADER

// PREPARE RESULT
$json = array();
$json["success"]=$CODE_INSUFFICIENT_PARAMETERS;

if(isset($_POST["authkey"])){
	$_GET = $_POST;
}

if(isset($_GET["authkey"])){
	$key = $_GET["authkey"];
}else{
	$json["message"]="authkey missing";
	echo json_encode($json);
	exit();
}

if(isset($_GET["name"])){
	$name = $_GET["name"];
}else{
	$json["message"]="name missing";
	echo json_encode($json);
	exit();
}

if(isset($_GET["desc"])){
	$desc = $_GET["desc"];
}else{
	$json["message"]="description missing";
	echo json_encode($json);
	exit();
}

$db = new DBHelper();
$db->setAuthKey($key);
$type = $db->createType($name, $desc);

if($type == false){
	$json["success"]=$CODE_ERROR;
	if(DBConnection::getInstance()->status == DBConfig::$dbStatus["offline"]){
		$json["message"] = "Database error";$json["success"] = $CODE_DB_ERROR;
	}else{
		$json["message"] = "Type could not be created";
	}
	echo json_encode($json);
	exit();
}

$json["data"] = $type;

$json["success"] = $CODE_SUCCESS;
echo json_encode($json);

?>
<?php

#################### ADMIN ONLY #######################

// How to use this page:
// open it with the info about the type you wish to update:
//
// updateType.php?authkey=123&id=1&name=bla&desc=much bla
//
// required parameters are:
// authkey, id, name, desc
//
// The answer looks as follows:
// a json with a successcode and true if the operation was successfull:
/* 
{
	success : 1 ,
	data : true
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

if(isset($_GET["id"])){
	$id = $_GET["id"];
}else{
	$json["message"]="id missing";
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
$data = $db->updateType($id, $name, $desc);

if($data == false){
	$json["success"]=$CODE_ERROR;
	if(DBConnection::getInstance()->status == DBConfig::$dbStatus["offline"]){
		$json["message"] = "Database error";$json["success"] = $CODE_DB_ERROR;
	}else{
		$json["message"] = "User not found or not authorized";
	}
	echo json_encode($json);
	exit();
}

$json["data"] = $data;

$json["success"] = $CODE_SUCCESS;
echo json_encode($json);

?>
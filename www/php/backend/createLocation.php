<?php

######################## ONLY ADMIN ##########################

// How to use this page:
// open it with the info about the location you wish to create
// the starting and ending longitude and latitude and your authkey:
//
// createLocation.php?authkey=xxx&locations=location1,location2&flat=10&
// flong=30&tlat=60&tlong=50
//
// required parameters are:
// authkey, locations (array with locations seperated by comma), flat, 
// flong, tlat, tlong
//
// The answer looks as follows:
// a json with a successcode and the location id:
/* 
{
	"success":1,
	"data":5
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

if(isset($_GET["locations"])){
	$locations = $_GET["locations"];
}else{
	$json["message"]="locations missing";
	echo json_encode($json);
	exit();
}

if(isset($_GET["flat"])){
	$flat = $_GET["flat"];
}else{
	$json["message"]="flat missing";
	echo json_encode($json);
	exit();
}

if(isset($_GET["flong"])){
	$flong = $_GET["flong"];
}else{
	$json["message"]="flong missing";
	echo json_encode($json);
	exit();
}

if(isset($_GET["tlat"])){
	$tlat = $_GET["tlat"];
}else{
	$json["message"]="tlat missing";
	echo json_encode($json);
	exit();
}

if(isset($_GET["tlong"])){
	$tlong = $_GET["tlong"];
}else{
	$json["message"]="tlong missing";
	echo json_encode($json);
	exit();
}

$locations = str_replace(",", ";" , $locations);

$db = new DBHelper();

$db->setAuthKey($key);
$status = $db->createLocation($locations, $flat, $flong, $tlat, $tlong);

if($status == false){
	$json["success"]=$CODE_ERROR;
	if(DBConnection::getInstance()->status == DBConfig::$dbStatus["offline"]){
		$json["message"] = "Database error";$json["success"] = $CODE_DB_ERROR;
	}else{
		$json["message"] = "Location could not be created";
	}
	echo json_encode($json);
	exit();
}

$json["data"] = $status;

$json["success"] = $CODE_SUCCESS;
echo json_encode($json);

?>
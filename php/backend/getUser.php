<?php

// How to use this page:
// open it with the info about the course to create
// as described in the database and your sessionkey:
//
// getUser.php?id=123
//
// required parameters are:
// id
//
// The answer looks as follows:
// a json with a successcode and the course id:
/* 
{
	success : 1 ,
	data : [
		{
			"0":"123",
			"id":"123",
			"1":"mustermann@mail.com",
			"email":"mustermann@mail.com",
			"2":"mustermann",
			"username":"mustermann",
			"3":"2014-02-13 22:06:03",
			"joindate":"2014-02-13 22:06:03",
			"4":"2014-02-17 13:47:16",
			"lastaction":"2014-02-17 13:47:16",
			"5":"0",
			"status":"0"
		}
	]
}
*/
// for success codes see ../php/config.php

// HEADER
header('Content-Type: application/json; charset=utf-8');
error_reporting(0);
include("../settings/config.php");
include("../helpers/dbhelper.php");
// END HEADER

// PREPARE RESULT
$json = array();
$json["success"]=$CODE_INSUFFICIENT_PARAMETERS;

if(isset($_GET["id"])){
	$id = $_GET["id"];
}else{
	$json["message"]="id missing";
	echo json_encode($json);
	exit();
}

$db = new DBHelper();
$user = $db->getUser($id);

if($user == false){
	$json["success"]=$CODE_ERROR;
	if(DBConnection::getInstance()->status == DBConfig::$dbStatus["offline"]){
		$json["message"] = "Database error";
	}else{
		$json["message"] = "User not found";
	}
	echo json_encode($json);
	exit();
}

$json["data"] = $user;

$json["success"] = $CODE_SUCCESS;
echo json_encode($json);

?>
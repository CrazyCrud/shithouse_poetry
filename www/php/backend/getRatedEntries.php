<?php

// How to use this page:
// open it with the your authkey and additionally you can give
// a start for the entries you get:
//
// getRatedEntries.php?authkey=xxx&start=10
//
// required parameters are:
// authkey
//
// optional parameters are:
// start
//
// The answer looks as follows:
// a json with a successcode and the data about the entries:
/* 
{
	"success":1,
	"data":[
		{
			"id":"1",
			"title":"lustiges bild",
			"date":"2014-02-18 13:29:28",
			"sex":"m",
			"userid":"1",
			"username":"tikiblue",
			"typename":"Text",
			"typedescription":"Ein an eine Wand, T\u00fcr oder auf einen anderen Gegenstand geschriebener Text.",
			"artist":"slivr33",
			"transcription":"dont hate me because im beautiful, hate me because i did your dad.\r\n\r\ngo home mom, youre drunk",
			"location":"in einer toilette irgendwo im nirgendwo",
			"longitude":"-1",
			"latitude":"-1",
			"imageid":"1",
			"path":"http:\/\/i.imgur.com\/YZmJoCz.jpg",
			"x":"50",
			"y":"50",
			"width":"350",
			"height":"250",
			"rating":"0.0000",
			"ratingcount":"6"
		}
	]
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
$json["success"]=$CODE_ERROR;

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

if(isset($_GET["start"])){
	$start = $_GET["start"];
}

$db = new DBHelper();
$db->setAuthKey($key);

$entries = $db->getAllEntriesRatedByMe($start);

if($entries == false){
	$json["success"]=$CODE_ERROR;
	if(DBConnection::getInstance()->status == DBConfig::$dbStatus["offline"]){
		$json["message"] = "Database error";$json["success"] = $CODE_DB_ERROR;
	}else{
		$json["success"] = $CODE_NOT_FOUND;
		$json["message"] = "No entries found";
	}
	echo json_encode($json);
	exit();
}

$json["data"] = $entries;

$json["success"] = $CODE_SUCCESS;
echo json_encode($json);

?>
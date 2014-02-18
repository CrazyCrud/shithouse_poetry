<?php

class Constants{
	const NUMCOMMENTS = 10;
	const NUMENTRIES = 20;
}

/*
Configuration class containing only constants concerning the database
*/
class DBConfig{

	public static $settings = array(
		"sqllocation" => "localhost",
		"sqluser" => "root",
		"sqlpwd" => "",
		"sqldb" => "latrinalia"
	);

	public static $tables = array(
		"comments" => "comment",
		"entries" => "entry",
		"images" => "images",
		"information" => "information",
		"ratings" => "rating",
		"reports" => "report",
		"tags" => "tags",
		"types" => "type",
		"users" => "user",
		"usertags" => "usertags"
	);

	public static $dbStatus = array(
		"idle" => 0,
		"ready" => 1,
		"busy" => 2,
		"offline" => 3
	);

	public static $userStatus = array(
		"deleted" => -1,
		"newUser" => 0,
		"default" => 0,
		"admin" =>1
	);

}

/*
Generic Database Helper
*/
class DBConnection{
	
	private $link;
	private static $singleton;
	public $status = 0;

	// DO NOT CALL THIS!!! USE getInstance() INSTEAD
	function __construct() {
		$this->initConnection();
	}

	private function initConnection(){
		$link = mysql_connect(
			DBConfig::$settings["sqllocation"],
			DBConfig::$settings["sqluser"],
			DBConfig::$settings["sqlpwd"])
		or $this->error(DBConfig::$dbStatus["offline"]);
		mysql_select_db(
			DBConfig::$settings["sqldb"],
			$link)
		or $this->error(DBConfig::$dbStatus["offline"]);
		mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $link);
		$this->link = $link;
		$this->status = DBConfig::$dbStatus["ready"];
	}

	private function error($status){
		$this->status = $status;
	}

	public function query($q){
		$rows = array();
		$result = mysql_query($q, $this->link)
		or $this->error(DBConfig::$dbStatus["offline"]);
		if(is_bool($result))return $result;
		while ($row = mysql_fetch_array($result)){
			$rows[count($rows)]=$row;
		}
		return $rows;
	}

	// Use this function to get the singleton
	public static function getInstance(){
		if(!isset(self::$singleton)){
			self::$singleton = new DBConnection();
		}
		return self::$singleton;
	}

}


/*
Latrinalia DataBase Queries
*/
class Queries{
	/**
	USER QUERIES
	**/
	public static function getuser($sessionkey){
		return
		"SELECT id, email, username, joindate, lastaction, status
		FROM `".DBConfig::$tables["users"]."` WHERE `sessionkey` = \"$sessionkey\"";
	}
	public static function getuserbyid($id){
		return
		"SELECT id, email, username, joindate, lastaction, status
		FROM `".DBConfig::$tables["users"]."` WHERE `id` = \"$id\"";
	}
	public static function update($key){
		$u = DBConfig::$tables["users"];
		$date = date( 'Y-m-d H:i:s', time());
		return "UPDATE $u
		SET lastaction='$date'
		WHERE sessionkey='$key'";
	}
	public static function updateuserwithoutpassword($userid, $mail, $name){
		return "UPDATE $u
		SET email='$mail',
		username='$name'
		WHERE id=$userid";
	}
	public static function updateuser($userid, $mail, $name, $pwd){
		$u = DBConfig::$tables["users"];
		return "UPDATE $u
		SET email='$mail',
		username='$name',
		password='$pwd'
		WHERE id=$userid";
	}
	public static function createuser($key, $mail, $name, $pwd){
		$u = DBConfig::$tables["users"];
		return "INSERT INTO $u
		(email, username, joindate, lastaction, status, sessionkey, password)
		VALUES
		('$mail','$name','$date','$date',".DBConfig::$userStatus["newUser"].",'$key','$pwd')";
	}
	public static function deleteuser($accesskey){
		$u = DBConfig::$tables["users"];
		return "UPDATE $u
		SET sessionkey='".uniqid()."',
		status = ".DBConfig::$userStatus["deleted"]."
		WHERE sessionkey='$accesskey'";
	}
	/**
	COMMENT QUERIES
	**/
	public static function getcomments($entryid, $commentid){
		$u = DBConfig::$tables["users"];
		$c = DBConfig::$tables["comments"];
		return "SELECT 
		`$c`.id AS 'commentid',
		`$c`.comment AS 'comment',
		`$c`.timestamp AS 'time',
		`$u`.id AS 'userid',
		`$u`.username AS 'username'
		FROM `$c`, `$u`
		WHERE `$u`.id = `$c`.userid
		AND `comment`.id<$commentid
		AND `$c`.entryid = $entryid
		ORDER BY `$c`.timestamp DESC
		LIMIT 0,".Constants::NUMCOMMENTS;
	}
	public static function addcomment($entryid, $comment, $userid){
		$c = DBConfig::$tables["comments"];
		$date = date( 'Y-m-d H:i:s', time());
		return "INSERT INTO $c
		(entryid, userid, comment, timestamp)
		VALUES
		($entryid, $userid, '$comment', '$date')";
	}
	public static function getcomment($commentid){
		$c = DBConfig::$tables["comments"];
		return "SELECT * FROM $c
		WHERE id = $commentid";
	}
	public static function deletecomment($commentid, $uid){
		$c = DBConfig::$tables["comments"];
		return "UPDATE $c
		SET comment=''
		WHERE id=$commentid
		AND userid=$uid";
	}
	/**
	ENTRY QUERIES
	**/
	public static function getentry($entryid){
		$e = DBConfig::$tables["entries"];
		$u = DBConfig::$tables["users"];
		$t = DBConfig::$tables["types"];
		$r = DBConfig::$tables["ratings"];
		$i = DBConfig::$tables["information"];
		$img = DBConfig::$tables["images"];
		if(isset($entryid)){
			$id = "`$e`.id = $entryid AND";
		}else{
			$id = "";
		}
		$query = 
			"SELECT
			`$e`.id AS id,
			`$e`.title AS title,
			`$e`.date AS date,
			`$e`.sex AS sex,
			`$e`.userid AS userid,
			`$u`.username AS username,
			`$t`.name AS typename,
			`$t`.description AS typedescription,
			`$i`.artist AS artist,
			`$i`.transcription AS transcription,
			`$i`.location AS location,
			`$i`.longitude AS longitude,
			`$i`.latitude AS latitude,
			`$img`.id AS imageid,
			`$img`.path AS path,
			`$img`.xposition AS x,
			`$img`.yposition AS y,
			`$img`.width AS width,
			`$img`.height AS height,
			AVG(`rating`.rating) AS rating,
			COUNT(`rating`.rating) AS ratingcount

			FROM
			`$e`, `$u`, `$t`, `$i`, `$r`, `$img`

			WHERE
			$id
			`$e`.id = `$i`.entryid
			AND
			`$u`.id = `$e`.userid
			AND
			`$e`.typeid = `$t`.id
			AND
			`$e`.id = `$r`.entryid
			AND
			`$e`.id = `$img`.entryid

			GROUP BY
			`$r`.entryid";
		return $query;
	}
	public static function getallentries($start, $limit, $order){
		if(!isset($order)){
			$order = "date";
		}
		return Queries::getentry()." ORDER BY ".$order." DESC LIMIT $start, $limit";
	}
	public static function getusertags($entryid){
		$u = DBConfig::$tables["usertags"];
		$t = DBConfig::$tables["tags"];
		if(isset($entryid)){
			$id = "`$u`.entryid = $entryid AND";
		}else{
			$id = "";
		}
		$query = "SELECT 
			`$t`.tagid, `$t`.tag
			FROM `$t`, `$u`
			WHERE $id
			`$u`.tagid = `$t`.tagid";
		return $query;
	}
}

/*
Latrinalia DataBase Helper
*/
class DBHelper{
	
	private $authkey = -1;
	private static $connection;

	function __construct(){
		$this->connection = DBConnection::getInstance();
	}

	/**
	BASIC FUNCTIONS
	**/

	public function setAuthKey($key){
		$this->authkey = $key;
	}

	public function getAuthKey(){
		return $this->authkey;
	}

	private function loggedin(){
		if($this->authkey==-1)return false;
		return true;
	}

	private function query($query){
		//echo $query;
		if($this->connection->status != DBConfig::$dbStatus["ready"])
			return false;
		if($this->loggedin()){
			$this->update();
		}
		return $this->internalQuery($query);
	}

	// use with caution!!!
	public function getComplete($table){
		return $this->query("SELECT * FROM `".$table."`");
	}

	private function internalQuery($query){
		return $this->connection->query($query);
	}

	// this function updates the last action of the user
	private function update(){
		$q = Queries::update($this->authkey);
		$this->internalQuery($q);
	}

	/**
	USER FUNCTIONS
	**/

	// returns the complete user with the previously defined authkey
	// or a user by id
	public function getUser($id){
		if(isset($id)){
			$query = Queries::getuserbyid($id);
			$users = $this->query($query);
			if(count($users)==0)return false;
			return $users[0];
		}else{
			$query = Queries::getuser($this->authkey);
			$users = $this->query($query);
			if(count($users)==0)return false;
			return $users[0];
		}
	}

	public function updateUser($mail, $name, $pwd){
		$user = $this->getUser();
		if(!isset($user["id"])){
			return false;
		}
		if(isset($pwd)){
			$query = Queries::updateuser($user["id"], $mail, $name, $pwd);
		}else{
			$query = Queries::updateuserwithoutpassword($user["id"], $mail, $name);
		}
		return $this->query($query);
	}

	public function createUser($mail, $name, $pwd){
		$key = md5($mail).uniqid();
		$query = Queries::createuser($key, $mail, $name, $pwd);
		if($this->query($query)){
			return $key;
		}else{
			return false;
		}
	}

	public function deleteUser(){
		$query = Queries::deleteuser($this->authkey);
		return $this->query($query);
	}

	/**
	COMMENT FUNCTIONS
	**/

	// get the 10 previous comments (older than $commentid)
	// for $count=-1 delivers the 10 newest comments
	// (assuming the 10th newest comment has the id 123)
	// for $count=123 delivers the 11th to 20th newest comments
	// and so on ...
	// (for endless scrolling/pagination loading purposes)
	public function getComments($entryid, $commentid){
		if($commentid == -1)$commentid = PHP_INT_MAX;
		$query = Queries::getcomments($entryid, $commentid);
		return $this->query($query);
	}

	// adds a comment to an entry
	// returns whether successfull
	public function addComment($entryid, $comment){
		$comment = trim($comment);
		if(strlen($comment)==0)return false;
		$user = $this->getUser();
		$entry = $this->getEntry($entryid);
		if(!isset($user["id"])||!isset($entry["id"])){
			return false;
		}
		$query = Queries::addcomment($entryid, $comment, $user["id"]);
		return $this->query($query);
	}

	// returns the complete comment of the given id
	public function getComment($commentid){
		$query = Queries::getcomment($commentid);
		return $this->query($query);
	}

	// delete a comment
	// returns whether successfull
	public function deleteComment($commentid){
		$user = $this->getUser();
		$comment = $this->getComment($commentid);
		if(!isset($user["id"])||!isset($comment["id"])){
			return false;
		}
		if($user["status"] == DBConfig::$userStatus["admin"]){
			$id = $comment["userid"];
		}else{
			$id = $user["id"];
		}
		$query = Queries::deletecomment($commentid, $id);
		return $this->query($query);
	}

	/**
	ENTRY FUNCTIONS
	**/

	// returns the complete entry of the given id
	public function getEntry($entryid){
		$query = Queries::getentry($entryid);
		$entry = $this->query($query);
		if(count($entry)==0)return false;
		$entry = $entry[0];
		$query = Queries::getusertags($entryid);
		$entry["tags"]=$this->query($query);
		return $entry;
	}

	// returns the first 20 entries after $start ordered by $orderby
	// (for $orderby select a name of one of the attributes returned)
	public function getAllEntries($orderby, $start){
		if(!isset($start)){
			$start = 0;
		}
		$query = Queries::getallentries($start, Constants::NUMENTRIES, $orderby);
		return $this->query($query);
	}

	public function saveImage($entryid, $url){
		
	}

}

?>
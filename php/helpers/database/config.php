<?php
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
		"usertags" => "usertags",
		"index" => "index"
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

	public static $tagStatus = array(
		"usercreated" => 0,
		"global" => 1
	);

	public static $reportStatus = array(
		"closed" => -1,
		"open" => 0,
		"important" => 1
	);

}
?>
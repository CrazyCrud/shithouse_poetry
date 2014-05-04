<?php
$type = 'image/jpeg';
header('Content-Type:'.$type);
error_reporting(0);
include_once("../helpers/dbhelper.php");

if(isset($_GET["id"])){
	$entryid = $_GET["id"];
	printPreview($entryid);
}else{
	printIcon();
}

function printPreview($id){
	$db = new DBHelper();
	$entry = $db->getEntry($id);
	if(!isset($entry)
		||$entry==false
		||!isset($entry["information"])
		||!isset($entry["information"][0])
		||!isset($entry["information"][0]["transcription"])){
		printIcon();
	}else{
		$txt = $entry["information"][0]["transcription"];
		$type = $entry["typeid"];
		if($type == 1){
			$size = 1;
			if(isset($_GET["size"])){
				switch($_GET["size"]){
					case "l": $size=1;break;
					case "m": $size=.6;break;
					case "s": $size=.3;break;
				}
			}
			printOnWall($txt, $size);
		}else{
			printIcon();
		}
	}
}

function printOnWall($text, $size){
	$charsPerLine = 48;
	$url = "../../img/dummy/wall.jpg";

	$text = html_entity_decode($text);
	$text = iconv("utf-8","ascii//TRANSLIT",$text);
	$text = wordwrap($text, $charsPerLine, "\n", true);
	$img = writeOnImage($url, $text, $size);

	$lineheight = 36*$size;
	$charWidth = 18*$size;
	$lines = preg_match_all('/\n/s', $text);
	$height = $lines * $lineheight;
	$dst_height = $height + 2*256*$size;
	$dst_width = $charWidth*strlen($text) + 2*128*$size;
	if($dst_width > 1024*$size){
		$dst_width = 1024*$size;
	}
	$dest = imagecreatetruecolor($dst_width, $dst_height);
	imagecopyresized($dest, $img, 0, 0, 0, 0, $dst_width, $dst_height, $dst_width, $dst_height);

	imagejpeg($dest);
  	imagedestroy($dest);
}

function printIcon(){
	$file = "../../img/dummy/none.jpg";
	readfile($file);
}

function writeOnImage($url, $txt, $size){
  // Create Image From Existing File
  $jpg_image = imagecreatefromjpeg($url);

  // Allocate A Color For The Text
  $color = imagecolorallocate($jpg_image, 0, 0, 0);

  // Set Path to Font File
  $font_path = '../../img/dummy/font.ttf';

  // Set Text to Be Printed On Image
  $text = $txt;

  // Print Text On Image
  imagettftext($jpg_image, 25*$size, 0, 128*$size, 256*$size, $color, $font_path, $text);

  return $jpg_image;
}

?>
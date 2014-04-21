<?php

function get_extension($filename){
    return pathinfo($filename, PATHINFO_EXTENSION);
}


$title = $_POST["title"];
$description = $_POST["description"];
$cat = $_POST["cat"];

if($title=="" || $description=="")
{
	die("sorry");
}

$conn = mysql_connect("localhost", "njuvideo", "videoPWD");
if (!$conn)
{
	die('Could not connect: ' . mysql_error());
}
mysql_query("set character set 'utf8'");
mysql_query("set names 'utf8'");
mysql_select_db("njuvideo", $conn);

$query = mysql_query("SHOW TABLE STATUS WHERE name='video'"); 
$row = mysql_fetch_array($query);
$n = $row["Auto_increment"]; 


$tfile = $_FILES['thumbnail']['name'];
$vfile = $_POST["flash_uploader_0_tmpname"];

$tf = $n.".".get_extension($tfile);
$vf = $n.".".get_extension($vfile);

$time = date("Y-n-j H:i:s", time());
$sql = "INSERT INTO video(title, description, cat_id, publish_time, video_file, thumbnail_file)
VALUES(\"$title\", \"$description\", $cat, \"$time\", \"$vf\", \"$tf\")";
//echo $sql."\n";
if(!mysql_query($sql))
{
	echo mysql_error();
}

$dir = "../video/";
rename($dir.$vfile, $dir.$vf);
$dir = "../thumbnail/";
move_uploaded_file($_FILES['thumbnail']['tmp_name'], $dir.$tf);

if(preg_match("/mp4/i", get_extension($vfile))) {
	system("qtfaststart/bin/qtfaststart -d ".$dir.$tf);
}

die("ok");

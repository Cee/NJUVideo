<?php
function showlist() {
	$conn = mysql_connect("localhost", "njuvideo", "videoPWD");
	if (!$conn)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_query("set character set 'utf8'");
	mysql_query("set names 'utf8'");
	mysql_select_db("njuvideo", $conn);

	$query = mysql_query("SELECT * FROM category");
	if(!$query) {
	    die(mysql_error());
	}
	while($row = mysql_fetch_array($query)) {
		echo "<option value=\"{$row['id']}\">{$row['name']}</option>\n";
	}
}

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

<title>视频上传 - 我视</title>

<link rel="stylesheet" href="js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />

<script src="js/jquery-2.1.0.js"></script>

<!-- production -->
<script type="text/javascript" src="js/plupload.full.min.js"></script>
<script type="text/javascript" src="js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
<script type="text/javascript" src="js/i18n/zh_CN.js"></script>
<!-- debug 
<script type="text/javascript" src="../../js/moxie.js"></script>
<script type="text/javascript" src="../../js/plupload.dev.js"></script>
<script type="text/javascript" src="../../js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
-->

</head>
<body style="font: 13px Verdana; background: #eee; color: #333">

<form id="form" method="post" action="postupload.php" enctype="multipart/form-data">
	<h1>视频上传</h1>

	标题：<input name="title" type="text" /><br />
	视频简介：<br />
	<textarea id="description" name="description" cols="40" rows="4"></textarea><br />
	类别：<select name="cat">
		<?php showlist(); ?>
	</select><br />
	缩略图：<input id="thumbnail" name="thumbnail" type="file" accept="image/png, image/jpeg"/><br />

	<div style="float: left; margin-right: 20px">
		<h3>选择视频文件</h3>
		<div id="flash_uploader" style="width: 500px; height: 330px;">你的浏览器不支持 Flash 或 HTML5。</div>

	<br style="clear: both" />

	<input type="submit" value="下一步" />
</form>

<script type="text/javascript">
$(function() {
	// Setup flash version
	$("#flash_uploader").pluploadQueue({
		// General settings
		runtimes : 'flash',
		url : './uploadf.php',
		chunk_size : '4mb',
		unique_names : true,
		multi_selection : false,
		
		filters : {
			max_file_size : '2048mb',
			mime_types: [
				{title : "Video files", extensions : "flv,mp4"}
			]
		},

		// Resize images on clientside if we can
		// resize : {width : 320, height : 240, quality : 90},

		// Flash settings
		flash_swf_url : 'js/Moxie.swf'
	});
	var uploader = $("#flash_uploader").pluploadQueue();

	uploader.bind("PostInit", function(up) {
		$('a.plupload_start').unbind("click");
		$('a.plupload_start').click(function(e) {
			if (!$(this).hasClass('plupload_disabled')) {
				if(uploader.files.length!=1) {
					alert("只能上传一个视频文件！");
				} else {
					uploader.start();
				}
			}

			e.preventDefault();
		});
	});
	
	var f_done = false;
	uploader.bind("UploadComplete", function(f) {
		f_done = true;
	});

	$("#form").submit(function(e) {
		if($("#title").val() == ''){
			alert("标题不能为空！");
			return false;

		}
		if($("#description").val() == ''){
			alert("简介不能为空！");
			return false;
		}
		if($("#thumbnail").val() == ''){
			alert("未选择缩略图！");
			return false;
		}
		if(!f_done){
			alert("视频尚未上传成功");
			return false;
		}
		return true;
	});

});
</script>

</body>
</html>

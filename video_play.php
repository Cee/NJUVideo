<?php
$conn = mysql_connect("localhost", "njuvideo", "videoPWD");
if (!$conn)
{
    die('Could not connect: ' . mysql_error());
}
mysql_query("set character set 'utf8'");
mysql_query("set names 'utf8'");
mysql_select_db("njuvideo", $conn);

$vid = $_GET['id'];
if($vid=="") {
    die();
}
if(!preg_match("/^[0-9]+$/", $vid)) {
    die();
}
$query = mysql_query("SELECT * FROM video, category WHERE video.id=$vid AND category.id=video.cat_id");
if(!$query) {
    die(mysql_error());
}
$row = mysql_fetch_array($query);
if(!$row) {
    die();
}
$video_title = $row['title'];
$video_url = "video/".$row['video_file'];
$video_date = $row['publish_time'];
$video_description = $row['description'];
$video_wcount = $row['wcount'];

$cat_id = $row['cat_id'];
$cat_name = $row['name'];

session_start();
$set = false;
if(!isset($_SESSION["video"][$vid]["firsttime"])) {
    $_SESSION["video"][$vid]["firsttime"] = time();
    $set = true;
}
if(time() - $_SESSION["video"][$vid]["firsttime"] > 300) {
    $_SESSION["video"][$vid]["firsttime"] = time();
    $set = true;
}
if($set) {
    $query = mysql_query("UPDATE video SET wcount=wcount+1 WHERE id=$vid");
    if(!$query) {
        die(mysql_error());
    }
}

function related_video($cid, $vid) {
    $t = array();
    $query = mysql_query("SELECT * FROM video WHERE cat_id=$cid AND id!=$vid ORDER BY wcount DESC LIMIT 0, 3");
    if(!$query) {
        die(mysql_error());
    }
    while($row = mysql_fetch_array($query)) {
        $a = array(
                "id" => $row['id'],
                "title" => $row['title'],
                "tn" => "thumbnail/".$row['thumbnail_file'],
                "date" => $row['publish_time'],
                "wcount" => $row['wcount'],
                "url" => "/video_play.php?id=".$row['id']
            );
        $t[] = $a;
    }
    return $t;
}
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $video_title; ?> - 我视</title>
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="video_play.css">     
        <link rel="stylesheet" href="functional.css">
        
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/fix_navi.js" type="text/javascript"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
            <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- nav bar -->
        <div id="navBar" class="nav navbar-inverse" role="navigation">
            <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-header-collapse" wt-tracker="Header|Collapse|Toggle Navbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/"><img class="nav-logo" src="images/logo%20small.png"></a>
                </div>
                <ul class="nav navbar-nav collapse navbar-collapse navbar-header-collapse">
                    <li<?php if($id==5){?> class="active li"<?php } ?>><a href="video.php?id=5">毕业季</a></li>
                    <li<?php if($id==2){?> class="active li"<?php } ?>><a href="video.php?id=2">微电影</a></li>
                    <li<?php if($id==3){?> class="active li"<?php } ?>><a href="video.php?id=3">微课程</a></li>
                    <li<?php if($id==4){?> class="active li"<?php } ?>><a href="video.php?id=4">NJU视角</a></li>
                </ul>
                <div class="nav-search col-md-3 pull-right visible-md visible-lg">
                    <form action="" method="">
                        <div class="input-group">
                            <input type="text" class="form-control" id="search" placeholder="search">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div><!-- navbar end -->
        <div class="container">
        <!-- BreadCrumb -->
            <div class="row">
                <div id="breadcrumb" class="col-md-12 main-content">
                <ol class="breadcrumb">
                    <li><a href="/">首页</a></li>
                    <li><a href="video.php?id=<?php echo $cat_id; ?>"><?php echo $cat_name; ?></a></li>
                    <li class="active"><?php echo $video_title; ?></li>
                </ol>
                </div>
            </div><!-- breadcrumb end -->
            <div class="row vedio-contant">
                <div class="col-md-9 video-panel">
                    <div id="player-panel">
                    <a href="<?php echo $video_url; ?>" id="player"></a>
                    </div>
                    <!-- HTML player
                    <div data-swf="js/flowplayer.swf" class="flowplayer play-button" data-ratio="0.416" data-embed="false">
                        <video>
                            <source src="<?php echo $video_url; ?>"/>
                        </video>
                    </div>
                    -->
                    <div class="video_header row">
                        <h2 class="col-md-4"><?php echo $video_title; ?></h2>
                        <p class="col-md-4 pull-right">播放数：<?php echo $video_wcount; ?></p>
                    </div>
                    <div class="video_info">
                        <h3>视频信息</h3>
                        <div class="info_seperator"></div>
                        <p>发布时间：<?php echo $video_date; ?></p>
                        <p>作者：南京大学团委</p>
                        <!--<p>所属标签：微电影、青春</p>-->
                        <p>简介：<?php echo $video_description; ?></p>
                    </div>
                </div><!-- video player end -->
                <div class="col-md-3 video-list-left">
                    <h4>相关视频</h4>
                    <?php
                        $r = related_video($cat_id, $vid);
                        for($i=0; $i<3; $i++) {
                    ?>
                        <div class="video-list-left video-item" id="videoItem<?php echo $i+1; ?>">
                            <img src="<?php echo $r[$i]['tn']; ?>" alt="videoItem<?php echo $i+1; ?>">
                            <h5><?php echo $r[$i]['title']; ?></h5>
                            <p>所属：<?php echo $cat_name; ?></p>
                            <p class="num-play"><span class="glyphicon glyphicon-expand"></span><?php echo $r[$i]['wcount']; ?></p>
                        </div>
                    <?php
                        }
                    ?>
                </div><!-- video list end -->
            </div>
        </div><!-- main container end-->
        <!-- footer -->
        <div id="footer">
            <div class="container">
            <div class="row">
                <div class="col-md-3"><img id="footer-logo" src="images/logo%20footer.PNG"></div>
                <div class="col-md-7 footer-info">
                    <p>Copyright&copy; 2014. All right reserved</p>
                    <p>南京市栖霞区仙林大道163号。电话：025-89680321 89680322</p>
                    <p>Technical support: Lilystudio</p>
                </div>
            </div>
            </div>
        </div>
        <!-- js -->
        <script src="js/jquery.min.js"></script>
        <script src="js/flowplayer.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/flowplayer-3.2.13.min.js"></script>
        <script src="js/stickUp.min.js" type="text/javascript"></script>
        <script type="text/javascript">
              //initiating jQuery
              jQuery(function($) {
                $(document).ready( function() {
                  //enabling stickUp on the '.navbar-wrapper' class
                  $('#navBar').stickUp();
                    
                //start flash player
                    flowplayer("player", "js/flowplayer-3.2.18.swf", {
                        clip: {
                            autoBuffering: true
                        }
                    });
                });
              });
        </script>
    </body>
</html>
<?php
$id = $_GET['id'];
if($id=="") {
    die();
}
if(!preg_match("/^[0-9]+$/", $id)) {
    die();
}

$conn = mysql_connect("localhost", "njuvideo", "videoPWD");
if (!$conn)
{
    die('Could not connect: ' . mysql_error());
}
mysql_query("set character set 'utf8'");
mysql_query("set names 'utf8'");
mysql_select_db("njuvideo", $conn);

$query = mysql_query("SELECT * FROM category WHERE id=$id");
if(!$query) {
    die(mysql_error());
}
$row = mysql_fetch_array($query);
if(!$row) {
    die();
}
$cat_name = $row['name'];


function tophot($id) {
    $t = array();
    $query = mysql_query("SELECT * FROM video WHERE cat_id=$id ORDER BY wcount DESC LIMIT 0, 5");
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

function topnew($id) {
    $t = array();
    $query = mysql_query("SELECT * FROM video WHERE cat_id=$id ORDER BY id DESC LIMIT 0, 5");
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

        <title><?php echo $cat_name; ?></title>
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="index.css">
        
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
        </div>
        <div class="container">
        <!-- BreadCrumb -->
        <div class="row">
            <div id="breadcrumb" class="col-md-12 main-content">
            <ol class="breadcrumb">
                <li><a href="/">首页</a></li>
                <li class="active"><?php echo $cat_name; ?></li>
            </ol>
            </div>
        </div>
        <!-- 微电影 热门视频 -->
        <?php
            $t = tophot($id);
        ?>
        <div class="row">
        <div class="col-md-12 main-content no-margin-top">
            <div class="header"><h3><?php echo $cat_name; ?></h3>&nbsp;&nbsp;&nbsp;&nbsp;<a href="video_list.php?id=<?php echo $id; ?>&type=h"><h4>热门视频</h4></a></div>
            <div class="underline"></div>
            <div class="row">
                <div class="col-md-6">
                    <a href="<?php echo $t[0]["url"]; ?>"><img class="huge image" src="<?php echo $t[0]["tn"]; ?>"></a>
                    <div class="video-info">
                    <h4><?php echo $t[0]["title"]; ?></h4>
                    <p class="video-info-spc"><span class="time"><?php echo $t[0]["date"]; ?></span> <span class="clicks">点击率：<?php echo $t[0]["wcount"]; ?></span></p>
                    </div>
                </div>
                <div class="videoList col-md-6">
                    <ul>
                        <div class="row">
                        <div class="col-md-6">
                            <li><a href="<?php echo $t[1]["url"]; ?>"><img class="small image" src="<?php echo $t[1]["tn"]; ?>"></a><h5 class="video-info"><?php echo $t[1]["title"]; ?></h5></li>
                            <li><a href="<?php echo $t[2]["url"]; ?>"><img class="small image" src="<?php echo $t[2]["tn"]; ?>"></a><h5 class="video-info"><?php echo $t[2]["title"]; ?></h5></li>
                        </div>
                        <div class="col-md-6">
                            <li><a href="<?php echo $t[3]["url"]; ?>"><img class="small image" src="<?php echo $t[3]["tn"]; ?>"></a><h5><?php echo $t[3]["title"]; ?></h5></li>
                            <li><a href="<?php echo $t[4]["url"]; ?>"><img class="small image" src="<?php echo $t[4]["tn"]; ?>"></a><h5><?php echo $t[4]["title"]; ?></h5></li>
                        </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        <!-- 微电影 最新上传-->
        <?php
            $t = topnew($id);
        ?>
        <div class="row">
        <div class="col-md-12 main-content">
            <div class="header"><h3><?php echo $cat_name; ?></h3>&nbsp;&nbsp;&nbsp;&nbsp;<a href="video_list.php?id=<?php echo $id; ?>&type=n"><h4>最新上传</h4></a></div>
            <div class="underline"></div>
            <div class="row">
                <div class="col-md-6">
                    <a href="<?php echo $t[0]["url"]; ?>"><img class="huge image" src="<?php echo $t[0]["tn"]; ?>"></a>
                    <div class="video-info">
                    <h4><?php echo $t[0]["title"]; ?></h4>
                    <p class="video-info-spc"><span class="time"><?php echo $t[0]["date"]; ?></span> <span class="clicks">点击率：<?php echo $t[0]["wcount"]; ?></span></p>
                    </div>
                </div>
                <div class="videoList col-md-6">
                    <ul>
                        <div class="row">
                        <div class="col-md-6">
                            <li><a href="<?php echo $t[1]["url"]; ?>"><img class="small image" src="<?php echo $t[1]["tn"]; ?>"></a><h5 class="video-info"><?php echo $t[1]["title"]; ?></h5></li>
                            <li><a href="<?php echo $t[2]["url"]; ?>"><img class="small image" src="<?php echo $t[2]["tn"]; ?>"></a><h5 class="video-info"><?php echo $t[2]["title"]; ?></h5></li>
                        </div>
                        <div class="col-md-6">
                            <li><a href="<?php echo $t[3]["url"]; ?>"><img class="small image" src="<?php echo $t[3]["tn"]; ?>"></a><h5><?php echo $t[3]["title"]; ?></h5></li>
                            <li><a href="<?php echo $t[4]["url"]; ?>"><img class="small image" src="<?php echo $t[4]["tn"]; ?>"></a><h5><?php echo $t[4]["title"]; ?></h5></li>
                        </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
        </div>
        </div>
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
        <script src="js/bootstrap.min.js"></script>
        <script src="js/stickUp.min.js" type="text/javascript"></script>
        <script type="text/javascript">
              //initiating jQuery
              jQuery(function($) {
                $(document).ready( function() {
                  //enabling stickUp on the '.navbar-wrapper' class
                  $('#navBar').stickUp();
                });
              });
        </script>
    </body>
</html>
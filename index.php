<?php
$conn = mysql_connect("localhost", "njuvideo", "videoPWD");
if (!$conn)
{
    die('Could not connect: ' . mysql_error());
}
mysql_query("set character set 'utf8'");
mysql_query("set names 'utf8'");
mysql_select_db("njuvideo", $conn);

function rankingList() {
    $query = mysql_query("SELECT * FROM video ORDER BY wcount DESC LIMIT 0, 10");
    if(!$query) {
        die(mysql_error());
    }
    while($row = mysql_fetch_array($query)) {
        echo "<li><a href=\"video_play.php?id={$row['id']}\"><h5>{$row['title']}</h5></a></li>\n";
    }
}

function top($cid, $c) {
    $t = array();
    $query = mysql_query("SELECT * FROM video WHERE cat_id=$cid ORDER BY wcount DESC LIMIT 0, $c");
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

        <title>我视 - 南京大学团委旗下视频网站</title>
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="index.css">
        
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/index.js" type="text/javascript"></script>
        
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
            <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <!-- top slider bar-->
        <div class="banner visible-md visible-lg">
            <img class="banner-logo" src="images/logo.png">
            <div id="carousel-banner" class="carousel slide" data-ride="carousel">
                <!-- indicator -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-banner" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-banner" data-slide-to="1"></li>
                    <li data-target="#carousel-banner" data-slide-to="2"></li>
                </ol><!-- indicator end -->
                <!-- wrapper for slides -->
                <div class="carousel-inner" data-wrap="true">
                    <div class="item active" style="background-image:url(/images/slider/slider_0.jpg);background-size:cover;height: 360px;overflow:hidden;background-position:center;">
<!--                        <span style="background-image:url(/images/slider/slider_0.jpg);background-size:cover;height: 360px;overflow:hidden;background-position:center;"></span>-->
<!--                        <img src="/images/slider/slider_0.jpg" alt="slider-item-1" height="360">-->
                        <div class="carousel-caption">
                            <h3>我是一张图片</h3>
                            <p>我才是一张图片，楼上的不要作死！</p>
                        </div>
                    </div>
                    <div class="item" style="background-image:url(/images/slider/slider_1.jpg);background-size:cover;height: 360px;overflow:hidden;background-position:center;">
<!--                        <span style="background-image:url(/images/slider/slider_1.jpg);background-size:cover;height: 360px;overflow:hidden;background-position:center;"></span>-->
<!--                        <img src="images/slider/slider_1.JPG" alt="slider-item-2" height="360">-->
                        <div class="carousel-caption">
                            <h3>我也是一张图片</h3>
                            <p>我不是图片，我是一段文字！</p>
                        </div>
                    </div>
                    <div class="item" style="background-image:url(/images/slider/slider_2.jpg);background-size:cover;height: 360px;overflow:hidden;background-position:center;">
<!--                        <span style="background-image:url(/images/slider/slider_2.jpg);background-size:cover;height: 360px;overflow:hidden;background-position:center;"></span>-->
<!--                        <img src="images/slider/slider_2.jpg" alt="slider-item-3" height="360">-->
                        <div class="carousel-caption">
                            <h3>我还是一张图片</h3>
                            <p>我实在想不出其他话了，楼上的都把话说完了！</p>
                        </div>
                    </div>
                </div><!-- inner end -->
            </div><!-- carousel end-->
<!--            <img class="banner-logo" src="images/logo.png">-->
        </div>
        <!-- shadow -->
	    <div class="banner-shadow visible-md visible-lg"></div>
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
                    <!-- <li><a href="video.php?id=5">毕业季</a></li> -->
                    <li><a href="video.php?id=2">微电影</a></li>
                    <li><a href="video.php?id=3">微课程</a></li>
                    <li><a href="video.php?id=4">NJU视角</a></li>
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
        <!-- 毕业季 -->
        <?php
             // $t = top(5, 3);
        	$t = top(2,3);
        ?>
        <div class="row">
        <div id="graduate" class="col-md-9 main-content">
            <h3><a class="pageTitle" href="video.php?id=2">微电影</a></h3>
            <div class="underline"></div>
            <div class="row">
                <div class="col-md-8">
                    <a href="<?php echo $t[0]["url"]; ?>"><img class="huge image" src="<?php echo $t[0]["tn"]; ?>"></a>
                    <div class="video-info">
                    <h4><?php echo $t[0]["title"]; ?></h4>
                    <p><span class="time"><?php echo $t[0]["date"]; ?></span> <span class="clicks">点击率：<?php echo $t[0]["wcount"]; ?></span></p>
                    </div>    
                </div>
                <div class="videoList col-md-4">
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $t[1]["url"]; ?>"><img class="small image" src="<?php echo $t[1]["tn"]; ?>"></a><h5><?php echo $t[1]["title"]; ?></h5></li>
                        <li><a href="<?php echo $t[2]["url"]; ?>"><img class="small image" src="<?php echo $t[2]["tn"]; ?>"></a><h5><?php echo $t[2]["title"]; ?></h5></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- 排行榜 -->
        <div id="rankingList" class="col-md-3 main-content visible-md visible-lg">
            <h3><a class="pageTitle" href="#">排行榜</a></h3>
            <div class="underline"></div>
            <div>
                <ol>
                    <?php rankingList(); ?>
                </ol>
            </div>
        </div>
        </div>
        <!-- 微课程 -->
        <?php
            $t = top(3, 5);
        ?>
        <div class="row">
        <div id="microCourse" class="col-md-12 main-content">
            <h3><a class="pageTitle" href="video.php?id=3">微课程</a></h3>
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
                            <li><a href="<?php echo $t[1]["url"]; ?>"><img class="small image" src="<?php echo $t[1]["tn"]; ?>"></a><h5><?php echo $t[1]["title"]; ?></h5></li>
                            <li><a href="<?php echo $t[2]["url"]; ?>"><img class="small image" src="<?php echo $t[2]["tn"]; ?>"></a><h5><?php echo $t[2]["title"]; ?></h5></li>
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
        <!-- 微电影 -->
         <?php
        //     $t = top(2, 5);
         ?>
       <!-- <div class="row">
        <div id="microMovie" class="col-md-12 main-content">
            <h3><a class="pageTitle" href="video.php?id=2">微电影</a></h3>
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
                            <li><a href="<?php echo $t[1]["url"]; ?>"><img class="small image" src="<?php echo $t[1]["tn"]; ?>"></a><h5><?php echo $t[1]["title"]; ?></h5></li>
                            <li><a href="<?php echo $t[2]["url"]; ?>"><img class="small image" src="<?php echo $t[2]["tn"]; ?>"></a><h5><?php echo $t[2]["title"]; ?></h5></li>
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
        </div> -->
        <!-- NJU视角 -->
        <?php
            $t = top(4, 5);
        ?>
        <div class="row">
        <div id="NJUVideoSight" class="col-md-12 main-content">
            <h3><a class="pageTitle" href="video.php?id=4">NJU视角</a>
                <span class="subtitle">
                    <a href="video_list.php?id=2">新闻</a>&#8226;<a href="video_list.php?id=2">趣事</a>&#8226;<a href="video_list.php?id=2">活动</a>
                </span>
            </h3>
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
                            <li><a href="<?php echo $t[1]["url"]; ?>"><img class="small image" src="<?php echo $t[1]["tn"]; ?>"></a><h5><?php echo $t[1]["title"]; ?></h5></li>
                            <li><a href="<?php echo $t[2]["url"]; ?>"><img class="small image" src="<?php echo $t[2]["tn"]; ?>"></a><h5><?php echo $t[2]["title"]; ?></h5></li>
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
                <div class="col-md-4 hidden-xs hidden-sm"><img id="footer-logo img-responsive" src="images/logo%20footer.PNG"></div>
                <div class="col-md-7 footer-info visible-md visible-lg">
                    <p>Copyright&copy; 2014. All right reserved</p>
                    <p>南京市栖霞区仙林大道163号。电话：025-89680321 89680322</p>
                    <p>Technical support: Lilystudio</p>
                </div>
                <div class="col-md-7 footer-info-mobile hidden-md hidden-lg">
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
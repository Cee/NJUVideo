<?php
$id = $_GET['id'];
$t = $_GET['t'];
if($id=="") {
    die();
}
if(!preg_match("/^[0-9]+$/", $id)) {
    die();
}

$conn = mysql_connect("localhost", "lldev", "lilystudio");
if (!$conn)
{
    die('Could not connect: ' . mysql_error());
}
mysql_query("set character set 'utf8'");
mysql_query("set names 'utf8'");
mysql_select_db("54", $conn);

$query = mysql_query("SELECT * FROM category WHERE id=$id");
if(!$query) {
    die(mysql_error());
}
$row = mysql_fetch_array($query);
if(!$row) {
    die();
}
$cat_name = $row['name'];

function top($id, $type) {
    $t = array();
    $by = "id";
    if($type=="h") {
        $by = "wcount";
    }
    $query = mysql_query("SELECT * FROM video WHERE cat_id=$id ORDER BY $by DESC LIMIT 0, 5");
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
$t = top($id, $type);

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php echo $cat_name; ?> - 分类列表</title>
        
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="index.css">
        <link rel="stylesheet" href="video_list.css">
        
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
                <li><a href="video.php?id=<?php echo $id; ?>"><?php echo $cat_name; ?></a></li>
                <li class="active">分类列表</li>
            </ol>
            </div>
        </div>
        <!-- 微电影 分类列表-->
        <div class="row">
        <div id="microMovie" class="col-md-12 main-content">
            <div class="row" id="sort">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            按时间:&nbsp;
                            <a class="pageTitle" href="#">最近</a>&nbsp;|&nbsp;
                            <a class="pageTitle" href="#">一周</a>&nbsp;|&nbsp;
                            <a class="pageTitle" href="#">一个月</a>&nbsp;|&nbsp;
                            <a class="pageTitle" href="#">两个月</a>&nbsp;|&nbsp;
                            <a class="pageTitle" href="#">更久</a>
                        </div>
                    </div>
                    <div class="underline"></div>
                    <div class="row">
                        <div class="col-md-12">
                            按类别:&nbsp;
                            <a class="pageTitle" href="#">青春</a>&nbsp;|&nbsp;
                            <a class="pageTitle" href="#">奋斗</a>&nbsp;|&nbsp;
                            <a class="pageTitle" href="#">理想</a>&nbsp;|&nbsp;
                            <a class="pageTitle" href="#">爱情</a>&nbsp;|&nbsp;
                            <a class="pageTitle" href="#">其他</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="videoList col-md-12">
                    <ul>
                        <div class="row">
                        <div class="col-md-3">
                            <?php
                                for($i=0; $i<16; $i+=4) {
                                    ?>
                                        <li><a href="<?php echo $t[$i]["url"]; ?>"><img class="small image" src="<?php echo $t[$i]["tn"]; ?>"></a><h5><?php echo $t[$i]["title"]; ?></h5></li>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                                for($i=1; $i<16; $i+=4) {
                                    ?>
                                        <li><a href="<?php echo $t[$i]["url"]; ?>"><img class="small image" src="<?php echo $t[$i]["tn"]; ?>"></a><h5><?php echo $t[$i]["title"]; ?></h5></li>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                                for($i=2; $i<16; $i+=4) {
                                    ?>
                                        <li><a href="<?php echo $t[$i]["url"]; ?>"><img class="small image" src="<?php echo $t[$i]["tn"]; ?>"></a><h5><?php echo $t[$i]["title"]; ?></h5></li>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-md-3">
                            <?php
                                for($i=3; $i<16; $i+=4) {
                                    ?>
                                        <li><a href="<?php echo $t[$i]["url"]; ?>"><img class="small image" src="<?php echo $t[$i]["tn"]; ?>"></a><h5><?php echo $t[$i]["title"]; ?></h5></li>
                                    <?php
                                }
                            ?>
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
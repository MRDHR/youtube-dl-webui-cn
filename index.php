<?php
header("Content-type:text/html;charset=utf-8");
require_once 'class/Session.php';
require_once 'class/Downloader.php';
require_once 'class/FileHandler.php';

$session = Session::getInstance();
$file = new FileHandler;

require 'views/header.php';

if (!$session->is_logged_in()) {
    header("Location: login.php");
} else {
    if (isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all") {
        Downloader::kill_them_all();
    }

    if (isset($_POST['urls']) && !empty($_POST['urls']) && isset($_POST['videoPaths']) && !empty($_POST['videoPaths'])) {
        $downloader = new Downloader($_POST['urls'], $_POST['videoNames'], $_POST['videoPaths']);

        if (!isset($_SESSION['errors'])) {
            header("Location: index.php");
        }
    }
}
?>
<div class="container">
    <h1>下载</h1>
    <?php

    if (isset($_SESSION['errors']) && $_SESSION['errors'] > 0) {
        foreach ($_SESSION['errors'] as $e) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
        }
    }

    ?>
    <form id="download-form" class="form-horizontal" action="index.php" method="post">
        <div class="form-group">
            <div class="col-md-12">
                <input class="form-control" id="url" name="urls" placeholder="视频链接" type="text">
            </div>
            <br/>
            <br/>
            <br/>
            <div class="col-md-6">
                <input class="form-control" id="videoPath" name="videoPaths" placeholder="保存的文件夹(例：/video/郡道roa组/油管/)"
                       type="text">
            </div>
            <div class="col-md-6">
                <input class="form-control" id="videoName" name="videoNames"
                       placeholder="保存的文件名(如：金刚熊.mp4，不修改文件名，则不需填写)"
                       type="text">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">开始扒源</button>
    </form>
    <br/>
    <div>
        <h3 class="panel-title"><b>扒封面图</b></h3>
        <p>获取封面图功能只支持油管，有其他的网站需要请私聊我</p>
        <p>使用方法：<br />1：填写油管视频的链接<br />2：点击下面的俩按钮<br /><b>如果高清版封面没有图片，请点击低清版。</b></p>
        <br/>
        <button class="btn btn-primary" onclick="getMaxCover()">获取高清版封面图</button>
        <button class="btn btn-primary" onclick="getHqCover()">获取低清版封面图</button>
    </div>
    <br />
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading"><h3 class="panel-title">信息</h3></div>
                <div class="panel-body">
                    <p>剩余空间 : <?php echo $file->free_space(); ?></b></p>
                </div>
                <div id="back_jobs">
                    <?php
                    echo '<div class="panel-heading"><h3 class="panel-title">正在执行的扒源任务</h3></div>';
                    echo '<div class="panel-body">';
                    if (Downloader::get_current_background_jobs() != null) {
                        foreach (Downloader::get_current_background_jobs() as $key) {
                            $pos = strpos($key['cmd'], '-o') + 2;
                            $videoName = trim(substr($key['cmd'], $pos), ' ');
                            echo "<p>视频名称：" . $videoName . "  已用时 : " . $key['time'] . "</p>";
                        }
                    } else {
                        echo "<p>当前没有扒源任务。</p>";
                    }
                    echo '</div>';
                    ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-info">
                <div class="panel-heading"><h3 class="panel-title">帮助</h3></div>
                <div class="panel-body">
                    <p><b>它是如何工作的？</b></p>
                    <p>只需在编辑框中粘贴视频链接</p>
                    <p><img src="img/path_screenshoot.png"/>
                    <p>保存的文件夹（例：/video/郡道roa组/油管/）<br/>保存的视频名称（带后缀 如：金刚熊.mp4）<br/><b>推特的视频最好是提供名字，不然会报错</b><br/>然后点击“下载”
                    </p>
                    <p><b>支持哪些网站？</b></p>
                    <p><a href="http://rg3.github.io/youtube-dl/supportedsites.html" target="view_window">点我 </a>
                        支持的网站列表</p>
                    <p><b>如何在计算机上下载视频？</b></p>
                    <p>转到 <a href="http://www.mrdvh.info" target="view_window">视频源网站</a> -> 自己看着嗨 </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
unset($_SESSION['errors']);
require 'views/footer.php';
?>

<?php
header("Content-type:text/html;charset=utf-8");
require_once 'class/Session.php';
require_once 'class/Downloader.php';
require_once 'class/FileHandler.php';

$session = Session::getInstance();
$file = new FileHandler;

require 'views/header.php';

if (isset($_GET['kill']) && !empty($_GET['kill']) && $_GET['kill'] === "all") {
    Downloader::kill_them_all();
}

if (isset($_POST['urls']) && !empty($_POST['urls']) && isset($_POST['videoPaths']) && !empty($_POST['videoPaths'])) {
    echo "<p>" . '获取的输入：' . $_POST['urls'] . $_POST['videoNames'] . $_POST['videoPaths'] . "</p>";
    $downloader = new Downloader($_POST['urls'], $_POST['videoNames'], $_POST['videoPaths']);

    if (!isset($_SESSION['errors'])) {
        header("Location: index.php");
    }
}
?>
<div class="container">
    <?php
    if (isset($_SESSION['errors']) && $_SESSION['errors'] > 0) {
        foreach ($_SESSION['errors'] as $e) {
            echo "<div class=\"alert alert-warning\" role=\"alert\">$e</div>";
        }
    }
    ?>
    <div class="panel panel-info" style="width: 100%">
        <div class="panel-heading" style="background:#1976D2">
            <h2 class="panel-title"><b style="font-size: 24px;color: white">扒源</b></h2>
        </div>
        <div class="panel-body" style="background: #B3E5FC">
            <form id="download-form" style="width: 100%" action="index.php" method="post">
                <div style="width: 98%">
                    <input id="url" class="form-control" name="urls" placeholder="请输入视频链接"
                           type="text"/>
                </div>
                <div style="display: flex;justify-content: space-between;margin-top: 10px;width: 98%;">
                    <div style="width: 49.5%;margin-right: 0.5%;display: flex;justify-content: space-between;">
                        <input class="form-control" id="videoPath" name="videoPaths" placeholder="保存的文件夹"
                               type="text" readonly="readonly" style="background-color: white"/>
                        <button type="button" class="btn btn-default path-select">选择文件夹</button>
                    </div>
                    <div style="width: 49.5%;margin-left: 0.5%">
                        <input class="form-control" id="videoName" name="videoNames" placeholder="保存的文件名" type="text"
                               style="width: 100%"/>
                    </div>
                </div>
                <button type="submit" class="btn btn-default" style="margin-top: 10px">开始扒源</button>
            </form>
        </div>
    </div>
    <div class="panel panel-info" style="width: 100%">
        <div class="panel-heading" style="background:#1976D2">
            <h2 class="panel-title"><b style="font-size: 24px;color: white">扒封面图</b></h2>
        </div>
        <div class="panel-body" style="background: #B3E5FC">
            <p>获取封面图功能只支持油管，有其他的网站需要请私聊我</p>
            <p>使用方法：<br/>1：填写油管视频的链接<br/>2：点击下面的俩按钮<br/><b style="font-size: 16px">如果高清版封面没有图片，请点击低清版。</b></p>
            <button class="btn btn-default" onclick="getMaxCover()">获取高清版封面图</button>
            <button class="btn btn-default" onclick="getHqCover()">获取低清版封面图</button>
        </div>
    </div>
    <div style="display: flex;justify-content: space-between;margin-top: 10px">
        <div style="width: 49.5%;margin-right: 0.5%">
            <div class="panel panel-info" style="width: 100%;">
                <div class="panel-heading" style="background:#1976D2">
                    <b class="panel-title" style="font-size: 16px;color: white"> 信息</b>
                </div>
                <div class="panel-body" style="background: #B3E5FC">
                    <p>剩余空间 : <?php echo $file->free_space(); ?></p>
                </div>
                <div id="back_jobs" style="background: #B3E5FC">
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
        <div style="width: 49.5%;margin-left: 0.5%">
            <div class="panel panel-info" style="width: 100%;">
                <div class="panel-heading" style="background:#1976D2">
                    <b class="panel-title" style="font-size: 16px;color: white">帮助</b></div>
                <div class="panel-body" style="background: #B3E5FC">
                    <p><b>它是如何工作的？</b></p>
                    <p>1.只需在编辑框中粘贴视频链接</p>
                    <p>2.选择保存的文件夹</p>
                    <p>
                        <b>推特的视频最好是提供名字，不然会报错</b><br/>然后点击“下载”
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

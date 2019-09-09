<?php
header("Content-type:text/html;charset=utf-8");
require_once 'class/Session.php';
require_once 'class/Downloader.php';
require_once 'class/FileHandler.php';

if (isset($_POST['urls']) && !empty($_POST['urls']) && isset($_POST['videoPaths']) && !empty($_POST['videoPaths'])) {
    $downloader = new Downloader($_POST['urls'], $_POST['videoNames'], $_POST['videoPaths']);

    if (!isset($_SESSION['errors'])) {
        header("Location: index.php");
    }
}
?>

<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

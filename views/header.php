<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>搬运组扒源工具</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script type="application/javascript">
        window.setInterval(() => {
            setTimeout(function () {
                $('#back_jobs').load(document.URL + ' #back_jobs');
            }, 0)
        }, 1000);

        function getMaxCover() {
            const url = document.getElementById('url').value;
            if (url.indexOf("youtube") != -1 && url.indexOf("v=") != -1) {
                window.open("https://i.ytimg.com/vi/" + url.substring(url.indexOf("v=") + 2) + "/maxresdefault.jpg");
            }
        }

        function getHqCover() {
            const url = document.getElementById('url').value;
            if (url.indexOf("youtube") != -1 && url.indexOf("v=") != -1) {
                window.open("https://i.ytimg.com/vi/" + url.substring(url.indexOf("v=") + 2) + "/hqdefault.jpg");
            }
        }
    </script>
</head>
<body>
<div class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="">搬运组扒源工具</a>
    </div>
</div>


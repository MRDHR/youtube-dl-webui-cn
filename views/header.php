<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>搬运组扒源工具</title>
    <script type="application/javascript">
        window.setInterval(() => {
            setTimeout(function () {
                $('#back_jobs').load(document.URL + ' #back_jobs');
            }, 0)
        }, 1000);

        function getMaxCover() {
            let url = document.getElementById('url').value;
            if (url.indexOf('youtube') != -1 || url.indexOf('youtu.be') != -1) {
                if (url.endsWith('/')) {
                    url = url.substring(0, url.length)
                }
                url = url.substring(url.lastIndexOf("/") + 1).replace("watch?v=", "").replace('&feature=youtu.be', '');
                window.open("https://res.mrdvh.info/vi/" + url + "/maxresdefault.jpg");
            }
        }

        function getHqCover() {
            let url = document.getElementById('url').value;
            if (url.indexOf('youtube') != -1 || url.indexOf('youtu.be') != -1) {
                if (url.endsWith('/')) {
                    url = url.substring(0, url.length)
                }
                url = url.substring(url.lastIndexOf("/") + 1).replace("watch?v=", "").replace('&feature=youtu.be', '');
                window.open("https://res.mrdvh.info/vi/" + url + "/hqdefault.jpg");
            }
        }
    </script>
</head>
<body class="can-select">
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


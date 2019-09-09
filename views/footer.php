<div id="footer"
     style="background-color:#B3E5FC;color:#1976D2;clear:both;text-align:center;height: 40px;font-size: 16px;line-height: 40px"
     onclick="window.open('https://github.com/oldiy/youtube-dl-webui-cn')">
    根据oldiy的中文版进行修改
</div>
<script type="text/javascript">
    var baseUrl = 'http://static.mrdvh.info/';
    seajs.config({
        base: baseUrl + "static/js/",
        preload: [
            baseUrl + "static/style/font-awesome/css/font-awesome.css",
            baseUrl + "static/style/common.css",
            baseUrl + "static/style/skin/base/app_setting.css",
            baseUrl + "static/style/skin/win10.css",
            baseUrl + "?share/commonJs",
            "lib/jquery-1.8.0.min"
        ]
    });
    seajs.use('app/src/api/default/main', function () {
        $.addStyle('body .aui-outer .aui-title{border-bottom: 1px solid #eee;}');
        $('.path-select').die('click').live('click', function () {
            var parse = $.parseUrl(baseUrl);
            G.webHost = baseUrl.replace(parse.relative, '/');
            G.appHost = baseUrl + "?";
            G.appRoot = baseUrl;
            var imageExt = "png|jpg|bmp|gif|jpeg";
            var config = {
                type: 'folder',            //选择类型；file|folder|all
                single: false,            //是否单个
                allowExt: imageExt,        //类型为文件时; 此配置生效; 多个用|隔开;
                firstPath: '{groupPath}:1/video/',        //默认进入的目录
                makeUrl: false,            //生成文件url

                //对话框配置
                title: "选择文件夹",        //标题文字
                width: 900,
                height: 500,
                top: '50%'
            }
            core.api.pathSelect(config, function (list) {
                var str = jsonEncode(list);
                str = str.replace('["{groupPath}:1', "").replace('"]', '');
                document.getElementById('videoPath').value = str;
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#url").focus();
    });

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

    function check() {
        var url = $("#url").val();
        if (url == null || url == "") {
            alert("视频链接不能为空");
            return false;
        }

        var path = $("#videoPath").val();
        if (path == null || path == "") {
            alert("保存的文件夹不能为空");
            return false;
        }
        return true;
    }

</script>
</body>
</html>

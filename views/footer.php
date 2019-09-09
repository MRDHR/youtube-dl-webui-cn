<footer class="footer">
    <div class="well text-center">
        <p><a href="https://github.com/oldiy/youtube-dl-webui-cn" target="_blank">根据oldiy的中文版进行修改</a></p>
    </div>
</footer>
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#url").focus();
    });
</script>
<script type="text/javascript" src="http://www.mrdvh.info/static/js/lib/seajs/sea.js"></script>
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
</body>
</html>

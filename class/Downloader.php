<?php
header("Content-type:text/html;charset=utf-8");
include_once('FileHandler.php');

class Downloader
{
    private $url = "";
    private $config = [];
    private $videoName = "";
    private $errors = [];
    private $videoPath = "";

    public function __construct($postUrl, $postName, $postPath)
    {
        setlocale(LC_ALL, 'en_US.UTF-8');
        $this->config = require dirname(__DIR__) . '/config/config.php';
        $this->videoName = $postName;
        $this->url = $postUrl;
        $this->videoPath = $postPath;

        if (!$this->is_valid_url($this->url)) {
            $this->errors[] = "\"" . $this->url . "\" 不是一个真实可用的视频链接";
        }
        $pos = strpos($this->videoPath, '/video/');
        if (0 != $pos) {
            $this->errors[] = "\"" . $this->videoPath . "\" 您输入的保存路径不正确，请重新输入";
        }
        if (isset($this->errors) && count($this->errors) > 0) {
            $_SESSION['errors'] = $this->errors;
            return;
        }

        if ($this->config["max_dl"] == 0) {
            $this->do_download();
        } elseif ($this->config["max_dl"] > 0) {
            if ($this->background_jobs() >= 0 && $this->background_jobs() < $this->config["max_dl"]) {
                $this->do_download();
            } else {
                $this->errors[] = "Simultaneous downloads limit reached !";
            }
        }

        if (isset($this->errors) && count($this->errors) > 0) {
            $_SESSION['errors'] = $this->errors;
            return;
        }
    }

    public static function background_jobs()
    {
        return shell_exec("export LANG='zh_CN.UTF-8' && ps aux | grep -v grep | grep /bin/youtube-dl | wc -l");
    }

    public static function max_background_jobs()
    {
        $config = require dirname(__DIR__) . '/config/config.php';
        return $config["max_dl"];
    }

    public static function get_current_background_jobs()
    {
        exec("export LANG='zh_CN.UTF-8' && ps -A -o user,pid,etime,cmd | grep -v grep | grep '/bin/youtube-dl'", $output);

        $bjs = [];

        if (count($output) > 0) {
            foreach ($output as $line) {
                $line = explode(' ', preg_replace("/ +/", " ", $line), 4);
                $bjs[] = array(
                    'user' => $line[0],
                    'pid' => $line[1],
                    'time' => $line[2],
                    'cmd' => $line[3]
                );
            }

            return $bjs;
        } else {
            return null;
        }
    }

    public static function strToGBK($strText)
    {
        $encode = mb_detect_encoding($strText, array('UTF-8', 'GB2312', 'GBK'));
        if ($encode == "UTF-8") {
            return @iconv('UTF-8', 'GB18030', $strText);
        } else {
            return $strText;
        }
    }

    public static function kill_them_all()
    {
        exec("ps -A -o pid,cmd | grep -v grep | grep youtube-dl | awk '{print $1}'", $output);

        if (count($output) <= 0)
            return;

        foreach ($output as $p) {
            shell_exec("kill " . $p);
        }

        $config = require dirname(__DIR__) . '/config/config.php';
        $folder = $this->download_path;

        foreach (glob($folder . '*.part') as $file) {
            unlink($file);
        }
    }


    private function is_valid_url($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    private function do_download()
    {
        $cmd = '/www/wwwroot/video.mrdvh.info/shell/youtube-dl-webui-shell.sh';
        $cmd .= " " . escapeshellarg($this->url);
        $cmd .= " " . escapeshellarg($this->videoPath);
        $cmd .= " " . escapeshellarg($this->videoName);
        $cmd .= " > /dev/null & echo $!";
        system($cmd);
    }
}

?>

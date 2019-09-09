#!/usr/bin/env bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/sbin:~/bin
export PATH

#=================================================
#	System Required: CentOS 6/7,Debian 8/9,Ubuntu 16+
#	Description: youtube-dl快捷脚本
#	Version: 1.0.0
#	Author: MR_D
#	Blog:
#=================================================
export LANG="zh_CN.UTF-8"
saveUrl=$1
saveDir=$2
cd ${saveDir}
saveName=$3
if [ "$saveName" = "" ]; then
  youtube-dl -f 'bestvideo[ext=mp4]+bestaudio[ext=m4a]/best[ext=mp4]/best' --hls-prefer-ffmpeg ${saveUrl}
else
  youtube-dl -f 'bestvideo[ext=mp4]+bestaudio[ext=m4a]/best[ext=mp4]/best' --hls-prefer-ffmpeg ${saveUrl} -o ${saveName}
fi

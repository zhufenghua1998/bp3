<?php
    // BP3辅助工具模块

    /**
     * 高可用显示文件大小
     * @param $byte 字节
     * @return $hstr 高可用大小字符串
     */
    function height_show_size($byte){
        $hstr = '';
        if($byte<1024){
         $hstr = $byte.'B';
        }elseif($byte<1048576){
         $num=$byte/1024;
         $hstr = number_format($num,2).'kB';
        }elseif($byte<1073741824){
         $num=$byte/1048576;
         $hstr = number_format($num,2).'MB';
        }elseif($byte<1099511627776){
         $num=$byte/1073741824;
         $hstr = number_format($num,2)."GB";
        }
        return $hstr;
    }
?>
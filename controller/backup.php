<?php

session_start();
require_once("../functions.php");

force_login("/controller/backup.php");

// 备份缓存文件
$filename = "bp3-main-back.zip";

// 删掉旧压缩包
if(file_exists($filename)){
    
    unlink($filename);
    
}

// 整站备份

ExtendedZip::zipTree('../', $filename, ZipArchive::CREATE);

// 开始下载

header("Cache-Control: public"); 
header("Content-Description: File Transfer"); 
header('Content-disposition: attachment; filename='.basename($filename)); //文件名   
header("Content-Type: application/zip"); //zip格式的   
header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件    
header('Content-Length: '. filesize($filename)); //告诉浏览器，文件大小  
@readfile($filename);  // 输出内容

// 删掉压缩包
unlink($filename);

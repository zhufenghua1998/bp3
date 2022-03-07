<?php

// 导出config.php文件
    session_start();
    $config = require('../config.php');
    require_once("../functions.php");
    force_login("/controller/get_config.php");//强制登录

// 开始下载
$filename = "../config.php";

header("Cache-Control: public"); 
header("Content-Description: File Transfer"); 
header('Content-disposition: attachment; filename='.basename($filename)); //文件名   
header("Content-Type: application/zip"); //zip格式的   
header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件    
header('Content-Length: '. filesize($filename)); //告诉浏览器，文件大小  
@readfile($filename);  // 输出内容


?>
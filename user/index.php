<?php

    // session域解析版
    
    session_start();
    require_once("../functions.php");
    
    // 未登录，重定向至登录页面
    if(empty($_SESSION['access_token'])){
        header("Location: ./login.php");
    }
    // 正在注销
    if($_GET['logout']){
        $_SESSION['access_token'] = null;
        header("Location: ./login.php");
    }
    
    echo "<p>您已登录，本次token为 ".$_SESSION['access_token']."，退出时请 <a href='./index.php?logout=1'>注销</a></p>";

    echo "<p>功能列表：<a href='file.php'>文件管理</a></p>";
?>
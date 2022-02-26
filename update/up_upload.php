<?php

    session_start();
    
    $config = require("../config.php");
    
    require_once("../functions.php");
    
    force_login();
    
    
    // 保存上传的文件
    $temp_uri = "./bp3-main.zip";
    move_uploaded_file($_FILES["file"]["tmp_name"],$temp_uri);
    
    // 调用自动更新核心代码
    
    require("./up_core.php");
?>
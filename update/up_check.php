<?php
    // 检测更新
    require_once("../functions.php");
    
    // 如果明确不使用国内，则原接口
    if($update_type == 'en'){
        $url = "https://api.github.com/repos/zhufenghua1998/bp3/releases/latest";
    }
    // 默认使用国内加速
    else {
        $url = "http://bp3-fc.52dixiaowo.com/";
    }
    echo easy_file_get_content($url,easy_build_opt("GET",null,["User-Agent:zhufenghua1998"]));

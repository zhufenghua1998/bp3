<?php
    // 导入配置文件
    require_once("./functions.php");
    
    $init = false;
    if(file_exists("./config.php"))
    {
        $init = true;
    }
    
    if(!$init){
        
        // 接收上传的config文件
        $temp_uri = "config_cache.php";
        move_uploaded_file($_FILES["file"]["tmp_name"],$temp_uri);
        
        // 获取该文件
        $config_cache = require($temp_uri);
        
        // 尝试合并
        $base = require("./conf_base.php");
        
        $config = arr2_merge($config_cache,$base);
        
        // 尝试更新版本号（可能从旧版本配置文件导入！！）
        $config['version'] = $base['version'];
        
        save_config("./config.php");
        
        unlink($temp_uri);
        
        echo '{"errno":0,"errmsg":"导入配置文件成功!"}';
        
    }else{
        // 已安装过了
        echo '{"errno":1,"errmsg":"您已经安装过了，本次导入无效！请删掉config.php再试。"}';
   }

?>
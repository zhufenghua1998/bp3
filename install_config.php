<?php
    // 导入配置文件
    require_once("./functions.php");
    
    if(!$install){
        
        // 接收上传的config文件
        $temp_uri = "config_cache.php";
        move_uploaded_file($_FILES["file"]["tmp_name"],$temp_uri);
        
        // 获取该文件
        $config_cache = require($temp_uri);
        
        // 尝试合并base
        $config = arr2_merge($config_cache,$base);
        
        // 尝试更新版本号（可能从旧版本配置文件导入！！）
        $config['version'] = $base['version'];
        
        save_config();
        
        unlink($temp_uri);

        build_success("导入配置文件成功");

    }else{
        // 已安装过了
        build_err("已经安装过了，本次导入无效，请删除config.php再试");
   }

<?php

require_once("../functions.php");

force_login();

$lock_file = "up_lock.php";  // 版本更新锁定文件

// 指定一个临时目录
$temp_dir = __DIR__.DIRECTORY_SEPARATOR."temp";

// 把zip解压
$zip = new \ZipArchive;
$zip->open($temp_uri, \ZipArchive::CREATE);  // 指定$temp_uri是上传的压缩包名
$zip->extractTo($temp_dir);
$zip->close();


// 简单判断上传的文件是否合法
$check_dir = $temp_dir.DIRECTORY_SEPARATOR."bp3-main";
if(!is_dir($check_dir)){

    echo "请从github下载bp3代码，现在上传的不是bp3代码";
    del_dir($temp_dir);

}else{

    if(file_exists($lock_file)){

        echo "更新失败，已经存在另一个正在执行的升级任务";

    }else{
        file_put_contents($lock_file,"1");  // 升级锁定

        // echo "后台更新中，请勿乱动，过几秒后刷新即可（版本号变化）";

        // 开始进行文件覆盖
        $arr = ls_deep($check_dir);

        // 遍历第一层，注意update文件夹与config.php特殊处理
        foreach($arr as $key=>$value)
        {
            if($value['is_dir']==1){
                // 说明是文件夹

                // 从原文件夹 temp/bp3-main/dir 到 ../dir 的所有文件全部覆盖
                // 使用特定函数，递归复制一个目录下的文件
                recurse_copy($check_dir.DIRECTORY_SEPARATOR.$value['name'],"../".$value['name']);

            }else{
                // 是文件
                if($value['name']=='conf_base.php'){

                    if(file_exists($check_dir.DIRECTORY_SEPARATOR."config.php")){
                        // 如果导入了新的config，那么conf_base不进行特殊处理
                    }else{
                        // 基础配置文件，单独处理
                        $base = require($check_dir.DIRECTORY_SEPARATOR."conf_base.php");
                        // 新增base中独立项，但不会覆盖config原有项
                        $config = arr2_merge($config,$base);
                        // 手动指定更新版本号
                        $config['version'] = $base['version'];
                        // 存储合并后的新配置文件
                        save_config();
                    }
                    // 覆盖旧conf_base.php
                    copy($check_dir.DIRECTORY_SEPARATOR."conf_base.php","../conf_base.php");
                }else{
                    // 全部覆盖
                    $src_name = $check_dir.DIRECTORY_SEPARATOR.$value['name'];
                    $dest_name = "../".$value['name'];
                    copy($src_name,$dest_name);
                }
            }
        }
        // 删除缓存zip，删除解压临时文件夹, 删除锁定文件
        unlink($temp_uri);
        del_dir($temp_dir);
        unlink($lock_file);
        echo "程序已更新完毕，可能看起来无变化，一般版本号会不同";
    }
}

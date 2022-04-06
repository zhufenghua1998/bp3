<?php

    require_once("../functions.php");
    
    force_login();

    $lock_file = "up_lock.php";  // 版本更新锁定文件
    
    $zip = new \ZipArchive;
    $zip->open($temp_uri, \ZipArchive::CREATE);
    
    $file_name = $zip->getNameIndex(0);

    // 简单判断上传的文件是否合法
    if($file_name != "bp3-main/"){
        // 一般来说，仅包含bp3-main的文件夹的压缩包（名字为 bp3-main/）
        $zip->close();
        unlink("bp3-main.zip");
        echo "请从github下载bp3代码，现在上传的不是bp3代码";
    }else{
        // 解压到当前目录（将取得一个子文件夹：bp3-main）
        $zip->extractTo(__DIR__);
        $zip->close();
        
        if(file_exists($lock_file)){
            echo "更新失败，已经存在另一个正在执行的升级任务";
        }else{
            file_put_contents($lock_file,"1");
            
            // echo "后台更新中，请勿乱动，过几秒后刷新即可（版本号变化）";
            
            // 开始进行文件覆盖
            $arr = ls_deep("bp3-main");
            
            // 遍历第一层，注意update文件夹与config.php特殊处理
            foreach($arr as $key=>$value)
            {
                if($value['is_dir']==1){
                    // 说明是文件夹
                    
                     // 从原文件夹 bp3-main/dir 到 ../dir 的所有文件全部覆盖
                    // 使用特定函数，递归复制一个目录下的文件
                    recurse_copy("bp3-main".DIRECTORY_SEPARATOR.$value['name'],"../".$value['name']);

                }else{
                    // 是文件
                    if($value['name']=='conf_base.php'){
                        
                        if(file_exists("bp3-main".DIRECTORY_SEPARATOR."config.php")){
                            // 如果导入了新的config，那么conf_base不进行特殊处理
                        }else{
                            // 基础配置文件，单独处理
                            $base = require("bp3-main".DIRECTORY_SEPARATOR."conf_base.php");
                             // 新增base中独立项，但不会覆盖config原有项
                            $config = arr2_merge($config,$base);
                            // 手动指定更新版本号
                            $config['version'] = $base['version'];
                            // 存储合并后的新配置文件
                            save_config("../config.php");
                        }
                        // 覆盖旧conf_base.php
                        copy("bp3-main".DIRECTORY_SEPARATOR."conf_base.php","../conf_base.php");
                    }else{
                        // 全部覆盖
                        $src_name = "bp3-main".DIRECTORY_SEPARATOR.$value['name'];
                        $dest_name = "../".$value['name'];
                        copy($src_name,$dest_name);
                    }
                }
            }
            // 删除bp3-main.zip，删除bp3-main文件夹, 删除锁定文件
            unlink("bp3-main.zip");
            del_dir("bp3-main");
            unlink($lock_file);
            echo "程序已更新完毕，可能看起来无变化，一般版本号会不同";
        }
    }

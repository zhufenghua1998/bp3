<?php
/**
 * 后台基本帮助接口
 */
require_once("../functions.php");

force_login();

$method = force_get_param("method");

// 导出配置文件
if($method=="getconfig"){
    // 开始下载
    $filename = "../config.php";

    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header('Content-disposition: attachment; filename='.basename($filename)); //文件名
    header("Content-Type: application/zip"); //zip格式的
    header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
    header('Content-Length: '. filesize($filename)); //告诉浏览器，文件大小
    @readfile($filename);  // 输出内容

}
// 导入配置文件
elseif($method=="setconfig"){
    // 接收上传的config文件
    $temp_uri = "config_cache.php";
    move_uploaded_file($_FILES["file"]["tmp_name"],$temp_uri);

    // 获取该文件
    $config_cache = require($temp_uri);

    // 尝试合并
    $config = arr2_merge($config_cache,$base);

    // 尝试更新版本号（版本信息以base文件为准）
    $config['version'] = $base['version'];

    save_config();

    unlink($temp_uri);

    build_success();
}
// 还原基础配置
elseif($method=="resetbasic"){
    $config = arr2_merge($base,$config);
    save_config();
    build_success();
}
// 重置系统（删除config）
elseif($method=="resetsys"){

    if (!unlink("../config.php")){
        build_err();
    }
    else{
        build_success();
    }
}
// 整站导出压缩包
elseif($method=="backup"){
    // 备份缓存文件
    $filename = "./bp3-main-back.zip";

    // 删掉旧压缩包
    if(file_exists($filename)){
        unlink($filename);
    }

    // 整站备份，子目录为bp3-main

    ExtendedZip::zipTree(get_base_root(), $filename, ZipArchive::CREATE,"bp3-main");

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

}
// 保存配置文件
elseif($method=="savesettings"){
    $check = true;

    $config['site']['title'] = $_POST['s1'];
    $config['site']['subtitle'] = $_POST['s2'];
    $config['user']['name'] = $_POST['s3'];
    $config['user']['pwd'] = $_POST['s4'];
    $config['user']['lock'] = $_POST['s5'];
    $config['connect']['app_id'] = $_POST['s6'];
    $config['connect']['secret_key'] = $_POST['s7'];
    $config['connect']['redirect_uri'] = $_POST['s8'];
    $config['control']['pre_dir'] = $_POST['s9'];
    $config['site']['blog'] = $_POST['s10'];
    $config['site']['github'] = $_POST['s11'];
    $config['baidu']['baidu_account'] = $_POST['s12'];
    $config['baidu']['baidu_pwd'] = $_POST['s13'];
    $config['control']['close_dlink'] = $_POST['s14'];
    $config['control']['close_dload'] = $_POST['s15'];
    $config['control']['open_grant'] = $_POST['s16'];
    $config['identify']['grant_url'] = $_POST['s17'];
    $config['control']['grant_type'] = $_POST['s17s'];
    $config['control']['open_grant2'] = $_POST['s18'];
    $config['control']['open_session'] = $_POST['s19'];
    $config['site']['description'] = $_POST['s20'];
    $config['site']['keywords'] = $_POST['s21'];
    $config['inner']['app_id'] = $_POST['s22'];
    $config['inner']['secret_key'] = $_POST['s23'];
    $config['control']['update_type'] = $_POST['s24'];
    $config['control']['update_url'] = $_POST['s24u'];
//    $config['control']['dn_limit'] = $_POST['s25'];
//    $config['control']['dn_speed'] = $_POST['s26'];
//    if(!is_numeric($_POST['s26'])){
//        $check = false;
//    }

    if($check){
        save_config();
        build_success();
    }else{
        build_err("请填写正确的数据格式！");
    }

}
else{
    build_err("无效method");
}
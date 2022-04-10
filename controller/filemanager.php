<?php
/**
 * 文件管理接口，文件批量复制、移动、重命名、删除
 */

require_once("../functions.php");

force_login();

// 官方文档参阅：https://pan.baidu.com/union/doc/mksg0s9l4

$method = force_get_param("method");

$async = isset($_POST['async'])? $_POST['async'] : 0;  // 请求策略，默认

$ondup = isset($_POST['ondup'])? $_POST['ondup'] : 'newcopy';  // 遇到重复文件的处理策略

$filelist = force_post_param("filelist");  // 待操作文件列表

// 拼接url
$api_url = "https://pan.baidu.com/rest/2.0/xpan/file?method=filemanager&access_token=$access_token&opera=$method";

//请求直接返回给前端，无论是成功或失败
echo easy_file_get_content($api_url,easy_build_opt("POST",['async'=>$async,'filelist'=>$filelist,'ondup'=>$ondup]));




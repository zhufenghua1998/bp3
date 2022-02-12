<?php
  // 获取basic信息
  
  session_start();
  require("../config.php");
  require_once("../functions.php");
  
  force_login();
  
  // 请求http
  $token = $config['identify']['access_token'];
  $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$token&method=uinfo";
  $result = @file_get_contents($url);
  
  errmsg_file_get_content();
  
  $arr = json_decode($result,true);
  
  $config['basic'] = $arr;
  
  save_config("../config.php");
  // 完成
?>

  
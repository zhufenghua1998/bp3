<?php
  // 获取basic信息
  
  session_start();
  $config = require('../config.php');
  require_once("../functions.php");
  
  force_login();
  
  // 请求http
  $token = $config['identify']['access_token'];
  $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$token&method=uinfo";
  
  $opt = easy_build_http("GET");
  $result = easy_file_get_content($url,$opt);
  
  $arr = json_decode($result,true);
  
  $config['basic'] = $arr;
  
  save_config("../config.php");
  // 完成
?>

  
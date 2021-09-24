<?php
  // 获取basic，只能被connect.php调用，无法直接访问
  // 1.判断是否登录
  session_start();
  if(!$_SESSION['user']){
      echo "您还未登录";
      die;
  }
  $config_file = "../config.php";
  require_once($config_file);
  // 2.获取basic
  $token = $config['identify']['access_token'];
  $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$token&method=uinfo";
  $result = file_get_contents($url,false);
  $json = json_decode($result);
  $config['basic']['baidu_name'] = $json->baidu_name;
  $config['basic']['netdisk_name'] = $json->netdisk_name;
  $config['basic']['uk'] = $json->uk;
  $config['basic']['vip_type'] = $json->vip_type;
  $text='<?php $config='.var_export($config,true).';'; 
  $config_file = "../config.php";
  file_put_contents($config_file,$text);
  // 完成
?>

  
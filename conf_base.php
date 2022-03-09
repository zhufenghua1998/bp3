<?php return array (  // 至多2维、务必是关联数组的基础配置文件
  'version'=>"v1.3.2",
  'user' => 
  array (
    'lock' => '3',
    'chance' => '3',
  ),
  'site' => 
  array (
    'title' => 'bp3',
    'subtitle' => '免费、开源的网盘程序',
    'blog' => 'https://www.52dixiaowo.com',
    'github' => 'https://github.com/zhufenghua1998/bp3',
    'description' => 'bp3是一款开源的百度网盘开发者接口程序，解锁更多炫酷的技能。',
    'keywords' => '开源,bp3,网盘,百度网盘,直链,百度网盘直链,百度网盘目录树,文件列表,文件搜索,文件下载',
  ),
  'control' => 
  array (
    'pre_dir' => '',
    'close_dlink' => 0,
    'close_dload' => 1,
    'open_grant' => 1,
    'open_grant2' => 1,
    'open_session' => 1,
    'grant_type' =>'url',
    'update_type' => 'sps',
    'update_url' => 'http://bp3-plus.52dixiaowo.com/bp3-main.zip',
  ),
  'inner'=>array(
    'app_id' => 'NtcmMLFqq4Vf0IKBlVIDFGXAqjuYpvWN',
    'secret_key' => 'K0Y8zrTmHX98APHRlSqSAQl5N8rtS2kz',
    'redirect_uri' => 'oob',
   ),
);
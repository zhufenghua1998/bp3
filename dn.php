<?php
    /**
     *  文件下载模块
     */
    session_start();
    require_once('./config.php');
    require_once("./functions.php");

    // 1.获取fsid
    $fsid = force_get_param("fsid");
    // $fsid = $_GET['fsid'];
    
    if($config['control']['close_dload']==1){
        force_login();
    }
    // 2.查询下载链接
    $access_token = $config['identify']['access_token'];
    $url = "http://pan.baidu.com/rest/2.0/xpan/multimedia?access_token=$access_token&method=filemetas&fsids=[$fsid]&dlink=1&thumb=1&dlink=1&extra=1";
    $opts = array(
        'http' => array(
            'method' => 'GET', 
            'header' => 'User-Agent: pan.baidu.com'
            ));
    $context = stream_context_create($opts);
    $result = @file_get_contents($url, false, $context);
    
    errmsg_file_get_content();
    
    $json = json_decode($result);
    $dlink =  $json->list[0]->dlink;


    $file_size = $json->list[0]->size;
    $file_name = $json->list[0]->filename;

    // 3.下载文件（方式一，直接下载）
      //get请求参数
    $request_data = array('access_token' => $access_token);
    //初始化curl对象
    $ch = curl_init();
    //设置URL
    curl_setopt($ch, CURLOPT_URL, $dlink);
    // 直接返回给浏览器
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    // 设置access_token
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request_data);
    // 设置user-agent
    curl_setopt($ch, CURLOPT_USERAGENT,"pan.baidu.com");
    // 允许301,302
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // 取消https验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);


    // 返回header给浏览器，并执行curl
    header("Content-type: application/octet-stream"); 
    header("Accept-Ranges: bytes"); 
    header("Content-Disposition: attachment; filename=$file_name");
    header("Content-Length: $file_size");
    header('Content-Transfer-Encoding: binary');
    curl_exec($ch);  

    // 3.下载文件（方式二，获取地址再下载）
    
//     $dlink = $dlink.'&access_token='.$access_token;
//     $headerArray = array('User-Agent: pan.baidu.com');
//     $getRealLink = head($dlink, $headerArray); // 禁止重定向
// 	$getRealLink = strstr($getRealLink, "Location");
// 	$realLink =  substr($getRealLink, 10);
// 	$realLink = substr($realLink,0,strpos($realLink,"\n")-1);
//     // echo $realLink;
//     $context = stream_context_create($opts);
//     $fp = fopen($realLink, 'rb', false, $context);
    
//     set_time_limit(0);
//     ini_set('max_execution_time', '0');
//     header('Content-Description: File Transfer');
//     header('Content-Type: application/octet-stream');
//     header('Content-Transfer-Encoding: binary');
//     header('Accept-Ranges: bytes');
//     header('Expires: 0');
//     header('Cache-Control: must-revalidate');
//     header('Pragma: public');
//     header('Content-Length: ' . $file_size);
//     header('Content-Disposition: attachment; filename=' . $file_name);

//     // 设置指针位置
//     fseek($fp, 0);
    
//     ob_end_clean();//缓冲区结束
//     while (!feof($fp)) {
//         $chunk_size = 1024 * 1024 * 2; // 2MB
//         echo fread($fp, $chunk_size);
//         flush(); //输出缓冲(切记,没有清楚缓存,下载会中断)
//         ob_flush();
//     }
//     fclose($fp);
?>
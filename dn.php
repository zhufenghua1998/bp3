<?php
    /**
     *  文件下载模块
     */
    require_once("./functions.php");

    // 1.获取fsid
    $fsid = force_get_param("fsid");

    if($close_dload==1){
        force_login();
    }
    // 2.查询下载链接

    $header = getallheaders();

    // 支持断点续传
    $range = isset($header['Range'])? $header['Range'] : "";   // 指定获取字节，从已下载文件大小字节开始，例如已下载2,022,040，则 bytes=2022040-

    $info = m_file_info($access_token,$fsid);

    // 原始dlink
    $dlink =  $info['list'][0]['dlink'];

    $file_size = $info['list'][0]['size'];
    $file_name = $info['list'][0]['filename'];

    // 3.下载文件（方式一，使用curl下载，支持断点续传）
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

    // 允许301,302
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // 取消https验证
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

    if(!empty($range)){  // 断点续传

        $cus_header = ["User-Agent: pan.baidu.com","Range: $range"];
        curl_setopt($ch,CURLOPT_HTTPHEADER,$cus_header);
        // 处理得到int类型的range
        $range_int = explode("=",$range);
        $range_int = $range_int[1];
        $range_int = explode("-",$range_int);
        $range_int = (int)$range_int[0];
        // 计算得到剩余大小
        $length = $file_size-$range_int;

        header('HTTP/1.1 206 Partial Content');
        header("Content-Range: bytes $range_int-$file_size/$file_size"); // 开始-总大小/总大小
        header('Content-Length: ' . $length);  // 剩余大小
    }else{
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . $file_size);
    }

    // 返回header给浏览器，并执行curl
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$file_name");
    header('Content-Transfer-Encoding: binary');

    curl_exec($ch);


    // 3.下载文件（方式二，使用fopen下载，无需curl、支持断点续传，且支持限速）
    
//     $dlink = $dlink.'&access_token='.$access_token;
//     // 取得无需重定向链接
//     $realLink = m_redirect_dlink($dlink);
//     // 使用fopen()进行http请求
//
//     // 基本处理
//     $fp = null;
//
//    header("Content-type: application/octet-stream");
//    header("Content-Disposition: attachment; filename=$file_name");
//    header('Content-Transfer-Encoding: binary');
//
//     if(!empty($range)){  // 存在断点续传（字符串类型，保留）
//         $opt = easy_build_opt("GET",null,["User-Agent:pan.baidu.com","Range:$range"]);
//         // 处理得到int类型的range
//         $range_int = explode("=",$range);
//         $range_int = $range_int[1];
//         $range_int = explode("-",$range_int);
//         $range_int = (int)$range_int[0];
//         // 计算得到剩余大小
//         $length = $file_size-$range_int;
//
//         header('HTTP/1.1 206 Partial Content');
//         header("Content-Range: bytes $range_int-$file_size/$file_size"); // 开始-总大小/总大小
//         header('Content-Length: ' . $length);  // 剩余大小
//
//         $fp = easy_fopen($realLink, 'rb',$opt);
//     }else{ // 普通下载
//         header('Accept-Ranges: bytes');
//         header('Content-Length: ' . $file_size);
//
//         $fp = easy_fopen($realLink, 'rb');
//     }
//     //设置缓冲大小
//    $read_buffer = $dn_limit==1? $dn_speed : 10240; // 限速主要设置
//    ob_clean();
//    flush();
//    while (!feof($fp)) {
//        echo  fread($fp, $read_buffer);
//        if($dn_limit==1){
//            usleep(100); //值越小，限速越稳定，这里一般不动
//        }
//    }
//
//    fclose($fp);


<?php

    /**
     * 高可用显示文件大小
     * @param $byte 字节
     * @return $hstr 高可用大小字符串
     */
    function height_show_size($byte){
        $hstr = '';
        if($byte<1024){
         $hstr = $byte.'B';
        }elseif($byte<1048576){
         $num=$byte/1024;
         $hstr = number_format($num,2).'kB';
        }elseif($byte<1073741824){
         $num=$byte/1048576;
         $hstr = number_format($num,2).'MB';
        }elseif($byte<1099511627776){
         $num=$byte/1073741824;
         $hstr = number_format($num,2)."GB";
        }
        return $hstr;
    }
    
    /**
     * 获取当前页面的Url绝对地址
     */ 
    function getPageUrl(){
        $page_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";
        return $page_url;
    }
    
    
    /**
     * 获取token，并可以自动更新
     * @param $config 配置参数数组
     * @param $refresh_php 刷新地址的绝对路径
     * @return false|access_token
     * 如果返回false，则说明执行了刷新token，请重新加载config文件
     */
     function get_token_refresh($config,$refresh_php){
        //自动刷新token
        if($config['identify']['access_token']){
            $pass_time = time()-$config['identify']['conn_time'];
            $express_time = $config['identify']['expires_in']-$pass_time;
            if($express_time<1728000){ //有效期小于20天，自动刷新token
                $arrContextOptions = [
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ]
                ];
                @file_get_contents($refresh_php,false,stream_context_create($arrContextOptions));
                return false;
            }
        }
        return $config['identify']['access_token'];
     }
    /**
     * 获取当前页面的目录的url地址
     * 获取方式：getDirUrl(basename(__FILE__))
     */ 
     function getDirUrl($fileName){
         $pageUrl = getPageUrl();
         $dirUrl = substr($pageUrl,0,-strlen($fileName));
         return $dirUrl;
     }
    function setCurl(&$ch, array $header)
    { // 批处理 curl
    	$a = curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 忽略证书
    	$b = curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 不检查证书与域名是否匹配（2为检查）
    	$c = curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 以字符串返回结果而非输出
    	$d = curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // 请求头
    	return ($a && $b && $c && $d);
    }
    function head(string $url, array $header)
    { // 获取响应头
    	$ch = curl_init($url);
    	setCurl($ch, $header);
    	curl_setopt($ch, CURLOPT_HEADER, true); // 返回响应头
    	curl_setopt($ch, CURLOPT_NOBODY, true); // 只要响应头
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    	$response = curl_exec($ch);
    	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE); // 获得响应头大小
    	$result = substr($response, 0, $header_size); // 根据头大小获取头信息
    	curl_close($ch);
    	return $result;
    }
?>
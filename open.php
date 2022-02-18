<?php
    session_start();
    $config = require('./config.php');
    require_once("functions.php");
    
    function getip()
    {
        //客户端IP 或 NONE
        $ip = false;
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        //多重代理服务器下的客户端真实IP地址（可能伪造）,如果没有使用代理，此字段为空
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ip) {
                array_unshift($ips, $ip);
                $ip = FALSE;
            }
            for ($i = 0; $i < count($ips); $i++) {
                if (!preg_match("/^(10│172.16│192.168)./i", $ips[$i])) {
                    $ip = $ips[$i];
                    break;
                }
            }
        }
        return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
    }
    $remote_ip = getip();
    // getServerIp
    $server_hostname=$_SERVER['SERVER_NAME'];
    $server_ip=gethostbyname($server_hostname);
    
    if($remote_ip == $server_ip){
        
        $base_url = get_base_url("/open.php");
        
        $refresh_url = $base_url."/admin/refresh_token.php";
        
        //自动刷新token
        $access_token = get_token_refresh($refresh_url);
        if(!$access_token){
            $config = require('./config.php');
            echo $config['identify']['access_token'];
        }else{
            echo $access_token;
        }
    }else if($_SESSION['user']){
        // 存在session情况下，也可以直接访问本页面获取token
        echo $config['identify']['access_token'];
    }


?>
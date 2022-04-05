<?php

/**
    http请求函数
 */

    /** 1
     * 快速 file_get_content()
     * @param string $url 目标url
     * @param array|null $opt 请求配置
     * @return false|string 请求结果字符串
     */
    function easy_file_get_content(string $url,array $opt=null){
        $result = null;
        if($opt){
            $result = @file_get_contents($url,false,stream_context_create($opt));
            err_msg_file_get_content($opt,$http_response_header);
        }else{
            $result = @file_get_contents($url,false,stream_context_create(easy_build_opt()));
            err_msg_file_get_content(null,$http_response_header);
        }
        return $result;
    }

    /** 2
     * 如果file_get_content失败，则输出提示
     * 无需参数，
     * @param array|null $opts 请求头信息
     * @param array|null $response 请求响应信息
     * @param string|null $user 用户信息
     */
    function err_msg_file_get_content(array $opts=null,array $response=null,string $user=null){

        // 如果未传递$response，尝试获取global的$http_response_header变量
        if(isset($response)){
            $http_response_header = $response;
        }else{
            global  $http_response_header;
        }
        // 校验程序是否传递了http返回变量
        if(!is_array($http_response_header)){
            echo '{"msg":"please give http response info!"}';
            die;
        }
        if(empty($user)){
            global $user;
        }
        // 校验程序是否传递了user变量
        if(!isset($user)){
            echo '{"msg":"please give user info!"}';
            die;
        }
        if(empty($_SESSION[$user])){
            // 请求失败且未登录
            if(!check_http_code($http_response_header[0])){
                echo '{"msg":"http request error!"}';
                die;
            }
        }else if(!check_http_code($http_response_header[0])){
            // 请求失败，但已登录
            echo '{"msg":"http request error!"}';
            easy_dump(error_get_last());
            if($opts){
                echo '{"msg":"The following is the HTTP request header information!"}';
                echo '<br>';
                easy_dump($opts);
            }
            echo '{"msg":"The following is the HTTP response header information!"}';
            echo '<br>';
            easy_dump($http_response_header);
            die;
        }
    }

    /** 3
     * 创建file_get_content或fopen的opt
     *
     * @param string $method 指定请求方法，默认GET
     * @param string|array $content 指定请求参数键值对
     * @param array $header 指定请求头数组（注意只能是一维字符串数组，每个一条），默认使用使用百度网盘ua
     * 例如  ['User-Agent:pan.baidu.com','Cookie:age=12'])
     * @return array
     */
    function easy_build_opt(string $method="GET",$content=null, array $header=["User-Agent:pan.baidu.com"]){

        if(!empty($content)){
            // 是否为数组？
            if(is_array($content)){
                $content = http_build_query($content);
            }
        }

        return [
            'http'=>[
                'method'=>$method,
                'header'=>$header,
                'content'=>$content,
            ],
            'ssl'=>[
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
        ];
    }

    /** 4
     * 设置内置允许的状态码
     * @param string $response_line 返回的请求行
     * @return bool 是否为允许的响应状态码，如果true为允许，false为失败
     */
    function check_http_code(string $response_line){
        $arr = explode(" ",$response_line);
        $code = (int)$arr[1]; // 响应状态码
        $check = [200,302];   // 合法的状态码，不在这其中的为不合法.
        foreach ($check as $k=>$v){
            if($v==$code){
                return true;
            }
        }
        return false;
    }

    /** 5
     * 获取重定向地址
     * @param array $response_header
     * @return mixed|string
     */
    function get_http_redirect(array $response_header){
        foreach ($response_header as $k=>$v){
            $split = explode(": ",$v);
            if(count($split)>1){
                if($split[0]=="Location"){
                    return $split[1];
                }
            }
        }
        return "";
    }

    /** 6
     * 快速进行fopen
     * @param string $filename
     * @param string $mode
     * @param array|null $opt
     * @return false|resource
     */
    function easy_fopen(string $filename,string $mode,array $opt=null){
        $result = null;
        if($opt){
            $result = @fopen($filename,$mode,false,stream_context_create($opt));
        }else{
            $result = @fopen($filename,$mode,false,stream_context_create(easy_build_opt()));
        }
        return $result;
    }


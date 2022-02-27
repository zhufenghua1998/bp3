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
    function get_page_url(){
        $page_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";
        return $page_url;
    }
    
    
    /**
     * 获取token，并可以自动更新
     * @param $config 配置参数数组
     * @param $refresh_php 刷新地址的绝对路径
     * @return false|access_token
     * 如果返回false，则说明执行了刷新token，请重新加载config文件
     * if(get_token_refresh(...)) { require(...config.php )}
     * 注意别使用 require_once 加载config.php文件
     */
     function get_token_refresh($refresh_php){
        //自动刷新token
        global $config;
        
        if($config['identify']['access_token']){
            $pass_time = time()-$config['identify']['conn_time'];
            $express_time = $config['identify']['expires_in']-$pass_time;
            if($express_time<1728000){ //有效期小于20天，自动刷新token
            
                $opt = easy_build_http("GET");
                easy_file_get_content($url,$opt);
                
                return false;
            }
        }
        return $config['identify']['access_token'];
     }
    /**
     * 获取当前页面的目录的url地址
     * 获取方式：get_dir_url(basename(__FILE__));
     */ 
     function get_dir_url($fileName){
         $pageUrl = get_page_url();
         $dirUrl = substr($pageUrl,0,-strlen($fileName));
         return $dirUrl;
     }
    /**
     * 获取网站根目录，但需要手写当前目录与根目录的前缀
     */ 
    function get_base_url($endstr){
        $pageUrl = get_page_url();
        $base_url = str_cut_end($pageUrl,$endstr);
        
        return $base_url;
    }
     // 拷贝参数，不常用
    function setCurl(&$ch, array $header)
    { // 批处理 curl
    	$a = curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 忽略证书
    	$b = curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 不检查证书与域名是否匹配（2为检查）
    	$c = curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 以字符串返回结果而非输出
    	$d = curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // 请求头
    	return ($a && $b && $c && $d);
    }
    // 拷贝参数，不常用
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
    /**
     * 强制登录，其中开启session必须在第一行填写：  session_start();
     * 在强制登录页面，填写：    force_login();  // 强制登录
     */ 
     function force_login(){
        if(empty($_SESSION['user'])){
            echo '{"error":"user not login"}';
            die;
        }
     }
     
     /**
      * 强制传递指定get参数
      * @param param_name 参数名称（字符串）
      * 例如，必须传递名为path的get参数，则：$path = force_get_param("path");
      */
     function force_get_param($param_name){
        $param = $_GET[$param_name];
        if(empty($param)){
            echo '{"error":"miss thie get type param, param_name is： '.$param_name.'"}';
            die;
        }
        return $param;
     }
     /**
      * 强制传递指定post参数
      * @param param_name 参数名称（字符串）
      * 例如，必须传递名为path的post参数，则：$path = force_post_param("path");_
      */ 
     function force_post_param($param_name){
        $param = $_POST[$param_name];
        if(empty($param)){
            echo '{"error":"miss thie post type param, param_name is： '.$param_name.'"}';
            die;
        }
        return $param;
     }
     
     /**
      * 默认http请求设置，可用于file_get_content参数
      * 
      * @param $method 指定请求方法
      * @param $header 指定请求头数组（注意只能是一维字符串数组，每个一条）
      * 例如  ['User-Agent:pan.baidu.com','Coookie:age=12'])
      * @param $content 指定请求参数键值对
      */ 
     function easy_build_http($method, array $header=[], array $content=[]){
         
         // 使用内置函数生成content
         $content = http_build_query($content);
         
         $opt = [
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
        return $opt;
     }
      
    /**
     * 快速 file_get_content()
     */ 
    function easy_file_get_content($url,array $opt=null){
        $result = null;
        if($opt){
            $result = @file_get_contents($url,false,stream_context_create($opt));
            errmsg_file_get_content($opt,$http_response_header);
        }else{
            $result = @file_get_contents($url);
            errmsg_file_get_content(null,$http_response_header);
        }
        return $result;
    }
    
     /**
      * 如果file_get_content失败，则输出提示
      * 无需参数，无返回值，需要首行开启session，否则不输出错误提示
      */ 
      function errmsg_file_get_content(array $opts=null,$response=null){
        
        // 如果未传递$http_response_header，尝试获取global
        if(isset($response)){
            $http_response_header = $response;
        }else{
            global  $http_response_header;
        }
        
        if(empty($_SESSION['user'])){
            // 请求失败且未登录
            if(!strstr($http_response_header[0],"200")){
                echo '{"errmsg":"http request error!"}';
                die;
            }
        }else if(!strstr($http_response_header[0],"200")){
            // 请求失败，但已登录
            echo '{"errmsg":"http request error!"}';
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

    /**
     * 解码后重新进行url编码，以消除js编码带来的诡异错误
     * 非必要不使用js进行urlencode，而使用php进行urlencode
     * @param $param 使用js编码后的变量
     * @return $encode 使用php解码后重新编码的变量
     */ 
    function re_urlencode($param){
        
        $decode = urldecode($param);
        $encode = urlencode($decode);
        
        return $encode;
    }
        
    /**
     * 消除一个str的部分str，从后往前开始
     * 比如当前文件地址 xx文件前置目录xx/apps/abc.php 
     * 这里的xx文件前置目录xx，表示在服务器中的前置目录
     * 从后往前消掉，可在任意php文件中取得bp3根目录所在服务器目录
     * @param $srcstr 原字符串
     * @param $endstr 去掉的字符串
     * @return $newstr 新字符串
     */ 
    function str_cut_end($srcstr,$endstr){
        
        $endlength = strlen($endstr);
        $newstr = substr($srcstr,0,-$endlength);
        
        return $newstr;
    }
    
    /**
     * 快速保存全局config变量到config.php文件中
     * @param $config_file 调用函数的页面相对config.php的地址
     * 例如，config.php在父目录中，则 "../config.php"
     * 注意！！！请确保全局config变量不为空，否则将清空config.php
     */ 
    function save_config($config_file){
        global $config;        
        $text='<?php return '.var_export($config,true).';'; 
        file_put_contents($config_file,$text);
    }
    
    /**
     * 快速重载本页面
     * 单位毫秒，如果未传值则200毫秒
     */ 
    function easy_reload($lazy_time=200){
        echo("<script>setTimeout('location.reload()', $lazy_time )</script>");
    }


    /**
     * 快速重定向到指定地址
     * @param $url 需要重定向的地址 (完整的http，或者相对地址如../)
     * @param lazy_time 指定的延迟加载时间，默认200毫秒
     */ 
    function easy_location($url,$lazy_time=200){
        echo("<script>setTimeout('window.location=\'$url\'', $lazy_time )</script>");
    }
    
    /**
     * php延迟指定毫秒
     * @lazy_time  默认200毫秒
     * 注释：sleep(time), usleep(time)，分别为秒（1）和微秒（-6），而毫秒（-3）
     */ 
    function lazy($lazy_time=200){
     $lazy_time = $lazy_time*1000;
     
     usleep($lazy_time);
    }
    
    /**
     * 格式化调试变量
     * @param @name 要调试的变量
     */ 
    function easy_dump($name){
        echo "<pre>";
        print_r($name);
        echo "</pre>";
    }
    
    /**
     * 递归遍历列出文件
     * @param $dir 要列出的文件夹，可使用相对路径或绝对路径
     */ 
    function ls_deep($dir){
        $files = array();
        if(@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
            while(($file = readdir($handle)) !== false) {
                if($file != ".." && $file != ".") { //排除根目录
                    if(is_dir($dir."/".$file)) { //如果是子文件夹，就进行递归
                        $arr = ["is_dir"=>1,"name"=>$file,"son"=>ls_deep($dir."/".$file)];
                        $files[] = $arr;
                    } else { //文件
                        $arr = ["is_dir"=>0,"name"=>$file];
                        $files[] = $arr;
                    }
                }
            }
            closedir($handle);
            return $files;
        }
    }
    
    /**
     * 递归复制文件夹
     */ 
    function recurse_copy($src,$dst){ 
      $dir = opendir($src); 
      @mkdir($dst); 
      while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
          if ( is_dir($src . '/' . $file) ) { 
            recurse_copy($src.'/'.$file,$dst.'/'.$file); 
          } 
          else { 
            copy($src.'/'.$file,$dst.'/'.$file); 
          } 
        } 
      } 
      closedir($dir); 
    } 
    /**
     * 递归删除文件夹及其文件
     */ 
    function deldir($dir) {
      //先删除目录下的文件：
      $dh=opendir($dir);
      while ($file=readdir($dh)) {
        if($file!="." && $file!="..") {
          $fullpath=$dir."/".$file;
          if(!is_dir($fullpath)) {
              unlink($fullpath);
          } else {
              deldir($fullpath);
          }
        }
      }
     
      closedir($dh);
      //删除当前文件夹：
      if(rmdir($dir)) {
        return true;
      } else {
        return false;
      }
    }
    
    /**
     * 检测百度账户类型
     * @param $vip_type 账户vip的数字标识
     * @return $vip_str 账户vip的字符串标识
    */ 
    function str_vip($vip_type){
        
        $vip_str = "";
        if(isset($vip_type)){
            if($vip_type==2){
                $vip_str = '超级会员';
            }
            elseif($vip_type==1){
                $vip_str = '普通会员';
            }
            elseif($vip_type==0){
                $vip_str = '普通用户';
            }
        }else{
            $vip_str = "用户不存在";
        }
        return $vip_str;
    }
    
    /**
     * zip扩展类
     * // Example
     *   ExtendedZip::zipTree('../', 'archive.zip', ZipArchive::CREATE);
     */
     
    class ExtendedZip extends ZipArchive {
    
        // Member function to add a whole file system subtree to the archive
        public function addTree($dirname, $localname = '') {
            if ($localname)
                $this->addEmptyDir($localname);
            $this->_addTree($dirname, $localname);
        }
    
        // Internal function, to recurse
        protected function _addTree($dirname, $localname) {
            $dir = opendir($dirname);
            while ($filename = readdir($dir)) {
                // Discard . and ..
                if ($filename == '.' || $filename == '..')
                    continue;
    
                // 排除.user.ini
                if($filename==".user.ini"){
                    continue;
                }
                // Proceed according to type
                $path = $dirname . '/' . $filename;
                $localpath = $localname ? ($localname . '/' . $filename) : $filename;
                if (is_dir($path)) {
                    // Directory: add & recurse
                    $this->addEmptyDir($localpath);
                    $this->_addTree($path, $localpath);
                }
                else if (is_file($path)) {
                    // File: just add
                    $this->addFile($path, $localpath);
                }
            }
            closedir($dir);
        }
    
        // Helper function
        public static function zipTree($dirname, $zipFilename, $flags = 0, $localname = '') {
            $zip = new self();
            $zip->open($zipFilename, $flags);
            $zip->addTree($dirname, $localname);
            $zip->close();
        }
    }
    
    /**
     * 业务模型，获取basic
     */ 
    
    function get_m_basic($config = null){
        if(empty($config)){
            global $config;
        }
        $token = $config['identify']['access_token'];
        $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$token&method=uinfo";
        
        $opt = easy_build_http("GET");
        $result = easy_file_get_content($url,$opt);
        
        $arr = json_decode($result,true);
        
        $config['basic'] = $arr;
        
        return $config;
    }
?>
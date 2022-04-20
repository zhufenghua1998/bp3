<?php

/**
        基本内置函数，命名随意
 */

    /** 1
     * 高可用显示文件大小
     * @param int $byte 字节
     * @return string $h_str 高可用大小字符串
     */
    function height_show_size(int $byte){
        $h_str = '';
        if($byte<1024){
            $h_str = $byte.'B';
        }elseif($byte<1048576){
            $num=$byte/1024;
            $h_str = number_format($num,2).'kB';
        }elseif($byte<1073741824){
            $num=$byte/1048576;
            $h_str = number_format($num,2).'MB';
        }elseif($byte<1099511627776){
            $num=$byte/1073741824;
            $h_str = number_format($num,2)."GB";
        }
        return $h_str;
    }

    /** 2
     * 获取网站真实的根目录Url
     * 注意，程序不一定安装在根目录，如果获取程序所在根目录，请使用get_base_url()
     */
    function get_site_url(){
        return (isset($_SERVER['HTTPS'])?"https":"http").'://'.$_SERVER['HTTP_HOST'];
    }
    /** 3
     * 获取当前页面的目录的url地址
     * 如果指定当前所在目录与层级，可以使用返回指定层级的地址
     * 例如，参数为1时，返回上一层目录
     *       参数为2时，返回上两层目录
     * @param int $parent 指定获取目录层级
     * @return string 获取目录url
     */
    function get_dir_url($parent=0){
        $page_url = get_page_url();

        $dir_url = "";
        $arr = explode("/",$page_url);
        $count = count($arr) - $parent;
        for($i=0; $i< $count-1; $i++){
            // 拼接字段
            $dir_url .= $arr[$i];
            // 拼接分隔符
            if($i < $count-2){
                $dir_url .= "/";
            }
        }

        return $dir_url;
    }
    /** 4
     * 获取部署的根目录
     * 首先必须指定当前页面与程序根目录的关系（上一层）
     * 从而经过一系列操作后得到程序根目录url
     */
    function get_base_url(){

        // 获取当前物理根目录
        $cur_ph_dir = get_base_root();
        // 取得网站物理根目录
        $base_ph_dir = get_site_root();

        if(strlen($cur_ph_dir) == strlen($base_ph_dir)){
            // 长度一致，说明部署在根目录下
            return get_site_url();
        }else{
            // 取得子目录的目录名 （$cur 更长，只取后部分）
            $sub_url = substr($cur_ph_dir,strlen($base_ph_dir));
            $sub_url = str_replace("\\","/",$sub_url); // 兼容win
            // 加入到网站真实url后，形成网站根目录url
            return get_site_url().$sub_url;
        }

    }

    /** 5
     * 获取当前页面的Url绝对地址
     */
    function get_page_url(){
        return get_site_url().$_SERVER['REQUEST_URI'];
    }

    /** 6
     * 获取指定文件的url（相对程序根目录）
     * @param string $file
     * @return string 指定文件的url
     */
    function get_file_url(string $file){
        return get_base_url().$file;
    }

    /** 7
     * 强制传递指定get参数
     * @param string $param_name
     * @return mixed
     */
    function force_get_param(string $param_name){
        $param = $_GET[$param_name];
        if(isset($param)){
            return $param;
        }else{
            build_err("缺少get参数：".$param_name);
        }
    }

    /** 8
     * 强制传递指定post参数
     * @param string $param_name 参数名称（字符串）
     * 例如，必须传递名为path的post参数，则：$path = force_post_param("path");_
     * @return mixed
     */
    function force_post_param(string $param_name){
        $param = $_POST[$param_name];
        if(isset($param)){
            return $param;
        }else{
            build_err("缺少post参数：".$param_name);
        }
    }

    /** 9
     * 快速重定向（302）
     * @param string $url 需要重定向的地址 (完整的http，或者相对地址如../)
     * @param int $lazy_time 延迟单位毫秒，如果未传值则0毫秒
     */
    function redirect(string $url,int $lazy_time=0){
        usleep($lazy_time);
        header("Location: $url");
    }

    /** 10
     * 快速重载本页面
     * @param int $lazy_time 延迟单位毫秒，如果未传值则200毫秒
     */
    function js_reload(int $lazy_time=200){
        echo("<script>setTimeout('window.location.reload()', $lazy_time )</script>");
    }

    /** 11
     * 快速重定向到指定地址
     * @param string $url 需要重定向的地址 (完整的http，或者相对地址如../)
     * @param int $lazy_time 延迟单位毫秒，如果未传值则200毫秒
     */
    function js_location(string $url,$lazy_time=200){
        echo("<script>setTimeout('window.location=\'$url\'', $lazy_time )</script>");
    }

    /** 12
     * 强制登录
     * @param string $user 需要检测的session，默认使用全局变量
     * @param string $login_url 需要重定向的地址，默认使用全局变量
     */
    function force_login(string $user='user',string $login_url=""){
        if(!isset($_SESSION[$user])){
            build_err("您必须登录系统，才可访问本页面！3秒后自动返回登录页面",false);
            // 重定向
            if(empty($login_url)){
                global $login_url;
            }
            js_location($login_url,3000);
            die;
        }
    }

    /** 13
     * 解码后重新进行url编码，以消除js编码带来的编码错误
     * @param string $param 使用js编码后的变量，或未编码变量
     * @return string $encode 使用php解码后重新编码的变量
     */
    function re_url_encode(string $param){

        $decode = urldecode($param);

        return urlencode($decode);
    }

    /** 14
     * php延迟指定毫秒
     * @lazy_time  默认200毫秒
     * 注释：sleep(time), usleep(time)，分别为秒（1）和微秒（-6），而毫秒（-3）
     * @param int $lazy_time
     */
    function easy_sleep($lazy_time=200){
        $lazy_time = $lazy_time*1000;

        usleep($lazy_time);
    }

    /** 15
     * 格式化调试变量
     * @param @name 要调试的变量
     */
    function easy_dump($name){
        echo "<pre>";
        print_r($name);
        echo "</pre>";
    }

    /** 16
     * 递归遍历列出文件（兼容win）
     * @param string $dir 要列出的文件夹，可使用相对路径或绝对路径
     * @return array
     */
    function ls_deep(string $dir){
        $files = array();
        if(@$handle = opendir($dir)) { //注意这里要加一个@，不然会有warning错误提示：）
            while(($file = readdir($handle)) !== false) {
                if($file != ".." && $file != ".") { //排除根目录
                    if(is_dir($dir.DIRECTORY_SEPARATOR.$file)) { //如果是子文件夹，就进行递归
                        $arr = ["is_dir"=>1,"name"=>$file,"son"=>ls_deep($dir.DIRECTORY_SEPARATOR.$file)];
                        $files[] = $arr;
                    } else { //文件
                        $arr = ["is_dir"=>0,"name"=>$file];
                        $files[] = $arr;
                    }
                }
            }
            closedir($handle);
            return $files;
        }else{
            return array();
        }
    }


    /** 17
     * 递归复制文件夹（兼容win)
     * @param string $src 原文件夹
     * @param string $dst 新文件夹
     */
    function recurse_copy(string $src,string $dst){
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . DIRECTORY_SEPARATOR . $file) ) {
                    recurse_copy($src.DIRECTORY_SEPARATOR.$file,$dst.DIRECTORY_SEPARATOR.$file);
                }
                else {
                    copy($src.DIRECTORY_SEPARATOR.$file,$dst.DIRECTORY_SEPARATOR.$file);
                }
            }
        }
        closedir($dir);
    }


    /** 18
     * 递归删除文件夹及其文件（兼容win)
     * @param string $dir 删除的目录
     * @return bool
     */
    function del_dir(string $dir) {
        //先删除目录下的文件：
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $full_path=$dir.DIRECTORY_SEPARATOR.$file;
                if(!is_dir($full_path)) {
                    unlink($full_path);
                } else {
                    del_dir($full_path);
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

    /** 19
     * 消除一个str的部分str，从后往前开始
     * @param string $src_str
     * @param string $end_str
     * @return false|string $newstr 新字符串
     */
    function str_cut_end(string $src_str,string $end_str){

        $end_length = strlen($end_str);

        return substr($src_str,0,-$end_length);
    }

    /** 20
     * 递归合并2个数组，程序中主要用于合并config与conf_base
     * @param array $old 旧数组
     * @param array $append 待添加数组
     * @return array 合并后的数据
     */
    function arr2_merge(array $old,array $append){

        $new_arr = $old; // 默认是旧数据中的内容

        // 遍历新数组并添加未存在的数据
        foreach ($append as $key=>$value){

            // 还是数组，递归
            if(is_array($append[$key])){
                // 校验旧数组是否存在对应子项
                if(isset($old[$key])){
                    $new_arr[$key] = arr2_merge($old[$key],$append[$key]);
                }else{
                    $new_arr[$key] = arr2_merge(array(),$append[$key]);
                }
            }else{
                // 键不存在，则添加
                if(!array_key_exists($key,$old)){
                    $new_arr[$key] = $value;
                }else{
                    $new_arr[$key] = $old[$key];
                }
            }
        }

        return $new_arr;
    }

    /** 21
     * 获取配置文件（默认获取用户配置文件）
     * @param string $config_path
     * @return mixed
     */
    function get_config(string $config_path=""){
        // 默认使用$config_path全局变量
        if(empty($config_path)){
            global $config_path;
        }
        // 校验文件是否存在
        $file_path = get_base_root().$config_path;
        if(!file_exists($file_path)){
            return array();
        }else{
            return require($file_path);
        }
    }

    /** 22
     * 获取目录的物理路径
     * @param int $level 传入0则当前目录，传入1则上级目录，2上上级，以此类推
     * @param string $dir 文件或目录，如果不存在，则默认是当前执行脚本的所在目录
     * @return string 物理路径
     */
    function get_dir_root(int $level=0,string $dir=""){
        if(empty($dir)){
            $dir = $_SERVER['SCRIPT_FILENAME'];
        }
        if($level==0){
            $ph_dir = dirname($dir);
        }else{
            $ph_dir =  dirname($dir,$level+1);
        }
        return $ph_dir;
    }

    /** 23
     * 获取程序所在的根目录
     */
    function get_base_root(){
        return get_dir_root(1,__FILE__);
    }

    /** 24
     * 获取网站所在的根目录
     */
    function get_site_root(){
        return $_SERVER['DOCUMENT_ROOT'];
    }


    /** 25
     * 保存config配置（数组）
     * @param string|null $config_path
     * @param array|null $config
     * @return false|int
     */
    function save_config(string $config_path=null,array $config=null){

        if(is_null($config_path)){
            global $config_path;
        }
        if(is_null($config)){
            global $config;
        }
        $text='<?php return '.var_export($config,true).';';
        return file_put_contents(get_base_root().$config_path,$text);
    }

    /** 26
     * 安装检测
     * @param string $config_path 主配置文件目录（自动拼接程序目录）
     * @param array $install_paths 未安装前，允许访问的目录，第一个页面为安装页面
     * @return bool 返回true已安装，若未安装，先判断当前页面是否允许，允许返回false，不允许则自动重定向
     */
    function check_install(string $config_path,array $install_paths){
        if(!file_exists(get_base_root().$config_path)){
            $redirect = true;
            foreach ($install_paths as $k=>$v){
                if(get_page_url()==get_base_url().$v){
                    $redirect = false;
                }
            }
            if($redirect){
                redirect($install_paths[0]);
            }
            return false;
        }
        return true;
    }

    /** 27
     * js输出提示
     * @param string $message
     */
    function js_alert(string $message){
        echo "<script>alert('$message')</script>";
    }

    /** 28
     * 检测是否存在某个session，默认检测user
     * @param string $user
     * @return bool 存在返回true
     */
    function check_session(string $user=""){
        if(empty($user)){
            global $user;
        }
        if(isset($_SESSION[$user])){
            return true;
        }else{
            return false;
        }
    }

    /** 29
     * 获取服务器IP
     */
    function get_server_ip(){
        $server_hostname=$_SERVER['SERVER_NAME'];
        return gethostbyname($server_hostname);
    }

    /** 30
     * 获取客户端IP
     */
    function get_remote_ip()
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

    /** 31
     * 构建并输出错误消息（应存在错误项errno，通常为-1）
     * @param array|string|null $msg
     * @param bool $die 是否停止解析，默认true
     */
    function build_err($msg=null,bool $die=true){
        // 数组处理
        if(is_array($msg)){
            if(!isset($msg['errno'])){
                $msg['errno'] = -1;
            }
            if(!isset($msg['errmsg'])){
                $msg['errmsg'] = "fail";
            }
            echo json_encode($msg,JSON_UNESCAPED_UNICODE);
        }
        // 字符串处理
        elseif(is_string($msg)){
            echo json_encode(array("errno"=>-1,"errmsg"=>$msg),JSON_UNESCAPED_UNICODE);
        }
        // 默认值
        elseif(empty($msg)){
            echo json_encode(array("errno"=>-1,"errmsg"=>"fail"),JSON_UNESCAPED_UNICODE);
        }
        if($die){
            die;
        }
    }

    /** 32
     * 获取一个session域的数据
     * @param string $param
     * @return mixed
     */
    function force_session_param(string $param){
        if(isset($_SESSION[$param])){
            return $_SESSION[$param];
        }else{
            build_err("缺少session参数：".$param);
        }
    }

    /** 32
     * 打印可换行的消息
     * @param $msg
     */
    function easy_echo($msg){
        echo "<p>";
        echo $msg;
        echo "</p>";
    }

    /** 33
     * 去掉字符串前缀
     * @param string $str
     * @param string $pre
     * @return false|string
     */
    function str_cut_start(string $str,string $pre){
        return substr($str,strlen($pre));
    }

    /** 34
     * 创建一个请求正确响应消息
     * @param array|string|null $msg
     */
    function build_success($msg=null){
        $msg_arr = array();
        if(empty($msg)){
            $msg_arr = ["errno"=>0,"errmsg"=>"success"];
        }
        elseif(is_string($msg)){
            $msg_arr = ["errno"=>0,"errmsg"=>$msg];
        }
        elseif(is_array($msg)){
            if(!isset($msg['errno'])){
                $msg['errno'] = 0;
            }
            if(!isset($msg['errmsg'])){
                $msg['errmsg'] = "success";
            }
            $msg_arr = $msg;
        }
        echo json_encode($msg_arr,JSON_UNESCAPED_UNICODE);
    }

    /** 35
     * 获取一个文件的真实地址，这里不使用realpath，这里以程序根目录开始计算的绝对路径
     * @param string $path
     */
    function get_file_root(string $path){
        echo get_base_root().$path;
    }

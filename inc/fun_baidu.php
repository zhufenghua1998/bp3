<?php
/**
        百度网盘业务函数（包括相关），均以 m_ 开头
 */

    /** 1
     * 检测百度账户类型
     * @param string $vip_type 账户vip的数字标识
     * @return string $vip_str 账户vip的字符串标识
     */
    function m_str_vip($vip_type="-1"){

        $vip_str = "";
        if(isset($vip_type)){
            if($vip_type=="2"){
                $vip_str = '超级会员';
            }
            elseif($vip_type=="1"){
                $vip_str = '普通会员';
            }
            elseif($vip_type=="0"){
                $vip_str = '普通用户';
            }
        }else{
            $vip_str = "用户不存在";
        }
        return $vip_str;
    }

    /** 2
     * 业务模型，获取basic
     * @param string $access_token
     * @return mixed basic数组
     */
    function m_basic(string $access_token=""){
        if(empty($access_token)){
            global $access_token;
        }
        $url = "https://pan.baidu.com/rest/2.0/xpan/nas?access_token=$access_token&method=uinfo";

        $result = easy_file_get_content($url);

        return m_decode($result);
    }


    /** 3
     * 使用code换取identify
     * @param $code
     * @param $appKey
     * @param $secret
     * @param $redirect
     * @param $state
     * @param $grant_url
     * @param $refresh_url
     * @return mixed
     */
    function m_callback($code,$appKey,$secret,$redirect,$state,$grant_url,$refresh_url){

        $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=authorization_code&code=$code&client_id=$appKey&client_secret=$secret&redirect_uri=$redirect&state=$state";
        $result = easy_file_get_content($url);
        $identify = m_decode($result);
        global $time;
        $identify['conn_time'] = $time; // 添加时间
        $identify['grant_url'] = $grant_url; //授权地址
        $identify['refresh_url'] = $refresh_url; //刷新地址

        return $identify;
    }

    /** 4
     * 查询文件信息
     * @param string $access_token 授权令牌
     * @param string $fsid 文件id
     * @return mixed
     */
    function m_file_info(string $access_token,string $fsid){
        $url = "http://pan.baidu.com/rest/2.0/xpan/multimedia?access_token=$access_token&method=filemetas&fsids=[$fsid]&dlink=1&thumb=1&dlink=1&extra=1";
        $result =  easy_file_get_content($url);

        return m_decode($result);
    }

    /** 5
     * 查询文件重定向后的下载地址
     * @param string $dlink 直接请求地址
     * @return mixed|string 重定向后的下载地址
     */
    function m_redirect_dlink(string $dlink){
        //设置默认选项
        stream_context_get_default(easy_build_opt());
        //取得headers
        $get_headers = get_headers($dlink, 1);
        //取得最后一个location
        $locations = $get_headers['Location'];
        if(is_array($locations)){
            return $locations[0];
        }else{
            return $locations;
        }
    }

    /** 6
     * 刷新identify
     * @param string $refresh_token
     * @param string $app_key
     * @param string $secret
     * @param string $grant_url
     * @param string $refresh_url
     * @return mixed
     */
    function m_refresh(string $refresh_token,string $app_key,string $secret,string $grant_url,string $refresh_url){
        $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=refresh_token&refresh_token=$refresh_token&client_id=$app_key&client_secret=$secret";
        $result =  easy_file_get_content($url);
        $identify = m_decode($result);
        global $time;
        $identify['conn_time'] = $time; // 添加时间
        $identify['grant_url'] = $grant_url; //授权地址
        $identify['refresh_url'] = $refresh_url; //刷新地址

        return json_encode($identify);
    }

    /** 7
     * 获取token，并且尝试自动刷新
     * @param array|null $config 配置信息
     * @param bool $force 强制刷新
     * @return mixed token
     */
    function m_token_refresh(array $config=null,bool $force=false){

        global $time;
        global $grant;
        global $grant2;
        global $grant_refresh;
        global $grant2_refresh;
        if(empty($config)){
            global $config;
        }
        if(isset($config['identify']) && isset($config['identify']['access_token'])){
            $pass_time = $time - $config['identify']['conn_time'];
            $express_time = $config['identify']['expires_in']-$pass_time;
            if($express_time<1728000 || $force){ //有效期小于20天，自动刷新token，或指定刷新，则自动刷新token

                $refresh_url = $config['identify']['refresh_url'];
                $refresh_token = $config['identify']['refresh_token'];
                // 使用免app
                if($refresh_url==$grant_refresh){
                    $appKey = $config['connect']['app_id'];
                    $secret = $config['connect']['secret_key'];
                    $param = m_refresh($refresh_token,$appKey,$secret,$grant,$refresh_url);
                }
                // 使用内置app
                elseif($refresh_url==$grant2_refresh){
                    $appKey = $config['inner']['app_id'];
                    $secret = $config['inner']['secret_key'];
                    $param = m_refresh($refresh_token,$appKey,$secret,$grant2,$refresh_url);
                }
                // 自定义url（程序外，则请求url）
                else{
                    $url = $refresh_url."?refresh_token=$refresh_token";
                    $param = easy_file_get_content($url);
                }
                $identify = m_decode($param);
                $config['identify'] = $identify; // 更新身份信息
                save_config();  // 保存
            }
            return $config['identify']['access_token'];
        }else{
            return "";
        }
    }

    /** 8
     * 搜索文件
     * @param string $pre_dir 如果未设置，默认使用全局变量
     * @param int $page 页数
     * @param string $key 搜索关键字
     * @param string $access_token
     * @return mixed
     */
    function m_file_search(string $pre_dir,int $page,string $key,string $access_token){
        if(!isset($pre_dir)){
            global $pre_dir;
        }
        $url = "http://pan.baidu.com/rest/2.0/xpan/file?dir=$pre_dir&access_token=$access_token&web=1&recursion=1&page=$page&num=20&method=search&key=$key";
        $result = easy_file_get_content($url);
        return m_decode($result);
    }

    /** 9 列出文件
     * @param string $dir 需要urlencode编码
     * @param string $access_token
     * @return mixed
     */
    function m_file_list(string $dir,string $access_token){
        $enc_dir = urlencode($dir);
        $url = "https://pan.baidu.com/rest/2.0/xpan/file?method=list&dir=$enc_dir&order=name&start=0&limit=10000&web=web&folder=0&access_token=$access_token&desc=0";

        $result = easy_file_get_content($url);
        return m_decode($result);
    }

    /** 10
     * 辅助函数，检测并解析响应数据，所有业务请求均应使用此函数
     * @param string $str
     * @param bool $to_arr
     * @return false|string
     */
    function m_decode(string $str,bool $to_arr=true){
        $arr = json_decode($str,true);
        if($arr['errno']=="0"){
            if($to_arr){
                return $arr;
            }else{
                return json_encode($str);
            }
        }else{
            $msg = array(
                "2"=>"参数错误",
                "-6"=>"身份验证失败",
                "31034"=>"命中接口频控",
                "42000"=>"访问过于频繁",
                "42001"=>"rand校验失败",
                "42999"=>"功能下线",
                "9100"=>"一级封禁",
                "9200"=>"二级封禁",
                "9300"=>"三级封禁",
                "9400"=>"四级封禁",
                "9500"=>"五级封禁"
            );
            foreach ($msg as $k=>$v){
                if($arr['errno']==$k){
                    $arr['zh-CN'] = $v;
                }
            }
            build_err($arr); // 输出增强后的响应信息
        }
    }






<?php
    session_start();
    $state = $_SESSION['state'];
    if($state!=$_GET['state']){
        echo "非法state";
        die;
    }
    $config_file = "../config.php";
    require_once($config_file);
    $code = $_GET['code'];
    $app_id = $config['connect']['app_id'];
    $secrect_key = $config['connect']['secret_key'];
    $redirect_uri = $config['connect']['redirect_uri'];
    
    $url = "https://openapi.baidu.com/oauth/2.0/token?grant_type=authorization_code&code=$code&client_id=$app_id&client_secret=$secrect_key&redirect_uri=$redirect_uri&state=$state";
    $result = file_get_contents($url, false);
    $json = json_decode($result,true);
    $json['conn_time'] = time();
    $config['identify'] = $json; // 会清除掉refresh_url，以自动识别app而不是免app
    file_put_contents($config_file,$text);
    // 获取basic
    require('./basic.php');
    //返回index.php
    $back_url = './index.php';
?>
<h2>百度连接成功，即将自动返回...</h2>
<script>
   setTimeout(function () { 
        window.location.href = "<?php echo $back_url;?>";
   }, 1500); 
 
</script>
    
    
    
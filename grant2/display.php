<?php
    session_start();
    $config = require("../config.php");
    
    
    $result = $_SESSION['result'];
    // 本页面仅用于展示获取到的信息，包含token，refresh_token等
    $json = json_decode($result);

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo '授权结果'.' | '.$config['site']['title'];?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/clipboard.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <link href="../fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
        <style>
            td{
                padding: 5px;
                border: 1px solid #ddd;
                word-break: break-all;
            }
            pre>code{
                padding: 5px;
                white-space: normal;
                word-break: break-all;
            }
        </style>
    </head>
    <body>
        <h2 class="text-center">本次授权结果如下：</h2>
        <div class="container">
            <table class="table table-bordered table-responsive">
                <tr>
                    <th>名称</th>
                    <th>描述</th>
                    <th>值</th>
                </tr>
                <tr>
                    <td>expires_in</td>
                    <td>有效期</td>
                    <td><?php echo $json->expires_in;?></td>
                </tr>
                <tr>
                    <td>refresh_token</td>
                    <td>刷新token</td>
                    <td><?php echo $json->refresh_token;?></td>
                </tr>
                <tr>
                    <td>access_token</td>
                    <td>访问令牌</td>
                    <td><?php echo $json->access_token;?></td>
                </tr>
                <tr>
                    <td>session_secret</td>
                    <td>session_secret</td>
                    <td><?php echo $json->session_secret;?></td>
                </tr>
                <tr>
                    <td>session_key</td>
                    <td>session_key</td>
                    <td><?php echo $json->session_key;?></td>
                </tr>
                <tr>
                    <td>scope</td>
                    <td>scope</td>
                    <td><?php echo $json->scope;?></td>
                </tr>
                <tr>
                    <td>授权地址(非原生)</td>
                    <td>grant_url</td>
                    <td><?php echo $json->grant_url;?></td>
                </tr>
                <tr>
                    <td>刷新地址(非原生)</td>
                    <td>refresh_url</td>
                    <td><?php echo $json->refresh_url;?></td>
                </tr>
            </table>
            <h2>授权信息 <button id="copy" class="btn btn-lg btn-primary">复制</button></h2>
            <div>
                <pre><code id="code"><?php echo $result;?></code></pre>
            </div>
            <h2><a href="./">返回授权页面</a></h2>
        </div>
        <footer class="copyright">
                <div class="navbar navbar-default navbar-inverse">
                <p class="text-center" style="color:#9d9d9d;margin-top:15px;">Copyright © <?php echo $config['site']['title'];?> <?php echo date('Y')?></p>
                </div>
        </footer>
        <style>
            .copyright,.navbar-inverse{
                margin-bottom: 0px;
            }
        </style>
        <script>
            // 返回指定的text
            var clipboard = new ClipboardJS('#copy', {
                text: function() {
                    return $("#code").text();
                }
            });
                // 复制成功事件
                clipboard.on('success', function(e) {
                    alert("复制成功")
                });
                // 复制失败事件
                clipboard.on('error', function(e) {
                    alert("复制失败")
                });
            $(function () {
              if($(window).height()==$(document).height()){
                $(".copyright").addClass("navbar-fixed-bottom");
              }
              else{
                $(".copyright").removeClass(" navbar-fixed-bottom");
              }    
            });
        </script>
    </body>
</html>
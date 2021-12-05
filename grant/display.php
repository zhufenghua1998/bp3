<?php
    session_start();
    
    $result = $_SESSION['result'];
    // 本页面仅用于展示获取到的信息，包含token，refresh_token等
    $json = json_decode($result);
?>
<!doctype html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>授权结果 | bp3授权系统</title>
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
        <h2>本次授权结果如下：</h2>
        <table>
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
        </table>
        <h2>原始信息 <button id="copy">复制</button></h2>
        <div>
            <pre><code id="code"><?php echo $result;?></code></pre>
        </div>
        <h2><a href="./">返回首页</a></h2>
        <script>
            window.onload = function(){
                let copyBtn = document.getElementById("copy");
                copyBtn.onclick = function(){
                    selectText('code');
                    document.execCommand("copy");
                    setTimeout("alert('复制成功')",200);
                }
            }
            function selectText(dom_id) {
				var selection = window.getSelection();        
				selection.removeAllRanges();
				var range = document.createRange();
				range.selectNodeContents(document.getElementById(dom_id));
				selection.addRange(range);
            }
        </script>
    </body>
</html>
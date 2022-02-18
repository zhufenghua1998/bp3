<?php
    // 注销
    session_start();
    // session_destroy();
    $_SESSION['user'] = null;
    $url = '../';
    header("Location: $url");
?>
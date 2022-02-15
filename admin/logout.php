<?php
    // 注销
    session_start();
    $_SESSION['user'] = null;
    $url = '../';
    header("Location: $url");
?>
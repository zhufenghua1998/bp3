<?php
    // 注销
    session_start();
    session_destroy();
    $url = '../';
    header("Location: $url");
?>
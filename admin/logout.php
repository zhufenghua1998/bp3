<?php
    session_start();
    session_destroy();
    $url = '../';
    header("Location: $url");
?>
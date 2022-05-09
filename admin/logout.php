<?php
    // 注销
    require_once("../functions.php");
    // session_destroy();
    $_SESSION[$user] = null;
    $_SESSION['config'] = null;
    redirect($base_url);

<?php

    /**
     * 获取当前页面的Url绝对地址
     */ 
    function getPageUrl(){
        $page_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";
        return $page_url;
    }
    
    /**
     * 获取当前页面的目录的url地址
     * 获取方式：getDirUrl(basename(__FILE__))
     */ 
     function getDirUrl($fileName){
         $pageUrl = getPageUrl();
         $dirUrl = substr($pageUrl,0,-strlen($fileName));
         return $dirUrl;
     }

?>
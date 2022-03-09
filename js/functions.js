    /**
     * 消息提醒函数
     * type限定为：default/info/success/warning/error中的任一种
     */ 
    function message(text,type){
        let text_class = "";
        switch(type){
            
        case "default":
            text_class = "fa fa-comments";
            break;
        case "info":
            text_class = "fa fa-info-circle text-info";
            break;
        case "success":
            text_class = "fa fa-check-square-o text-success";
            break;
        case "warning":
            text_class = "fa fa-warning text-warning";
            break;
        case "error":
            text_class = "fa fa-close text-danger";
            break;
        default:
            throw "消息type错误，请传递default/info/success/warning/error中的任一种";
            break;
        }
        let msgs = $(".message");
        let len = msgs.length; 
        let end = 0;
        let baseHeight = 0;
        if(len>0){
            baseHeight =msgs.first().innerHeight()+20;
            let start = msgs.first().attr('no');
            end = +start+len;
        }
        let height = 100+end*baseHeight+"px";
        $(`<div no='${end}' id='msg-${end}' class='message ${text_class}' style='top: ${height};position: fixed;left: 50%;border: 1px solid #ddd;
        background-color:#bbb;transform: translate(-50%, -50%);font-size: 1.2em;padding: 1rem;z-index: 999;border-radius: 0.5rem;'>${text}</div>`).appendTo("body");
        let rmScript = `$("#msg-${end}").remove();`;
        setTimeout(rmScript,1500);
    }
    
    /**
     * 延迟后刷新页面，单位毫秒，默认1500
     */ 
    function lazy_reload(time){
        let def_time = 1500;
        if(!time){
            time = def_time;
        }
        setTimeout("location.reload()", time );
    }
    
    /**
     * 延迟后跳转到指定页面，单位毫秒，默认1500
     */ 
    function easy_load(href,time){
        let def_time = 1500;
        if(!time){
            time = def_time;
        }
        setTimeout("location.href='"+href+"'", time );
    }
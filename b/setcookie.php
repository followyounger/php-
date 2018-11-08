<?php
header("Content-type: text/html; charset=utf-8");
$sid = isset($_GET['sid']) ? $_GET['sid'] : '';

// var_dump($sid); die();

if(!empty($sid)) {
    set_cookie('SID',$sid,0,'/','',0,1);
}

/**
 * 免刷新写入cookie
 * name     必需。规定 cookie 的名称。
 * value     必需。规定 cookie 的值。
 * expire     必需。规定 cookie 的有效期。
 * path     可选。规定 cookie 的服务器路径。
 * domain     可选。规定 cookie 的域名。
 * secure     可选。规定是否通过安全的 HTTPS 连接来传输 cookie。
 * httponly 可选。规定是否禁止js读取cookie。
 */
function set_cookie($name,$value='',$expire=0,$path='/',$domain='',$secure=0,$httponly=0) {
    $_COOKIE[$name] = $value;
    if(is_array($value)){
        foreach($value as $k=>$v){
            if(is_array($v)){
                foreach($v as $a=>$b){
                    setcookie($name.'['.$k.']['.$a.']',$b,$expire,$path,$domain,$secure,$httponly);
                }
            }else{
                setcookie($name.'['.$k.']',$v,$expire,$path,$domain,$secure,$httponly);
            }
        }
    }else{
        setcookie($name,$value,$expire,$path,$domain,$secure,$httponly);
    }
}
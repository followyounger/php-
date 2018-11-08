<?php
    header("Content-type: text/html; charset=utf-8");

    if(!empty($_POST)) {
        $response = curl_post('www.u.com/index.php',$_POST);
        if($response['code'] > 0) {
            die('error：'.$response['msg']);
        }
        set_cookie('SID',$response['data']['sid'],0,'/','',0,1);
        echo '登录成功';
        $url = 'http://www.b.com/setcookie.php?sid='.$response['data']['sid'];
        die('<script type="text/javascript" src="'.$url.'" reload="1"></script>');
    }

    function curl_post( $url , $arrPost = array() , $func = "http_build_query" ){
        $ch = curl_init();
        $opt[CURLOPT_URL] = $url;
        $opt[CURLOPT_RETURNTRANSFER] = 1;
        $opt[CURLOPT_TIMEOUT] = 10;
        // var_dump($arrPost); die();
        if(!empty($arrPost)){
            if($func == 'json_encode')
                $opt[CURLOPT_HTTPHEADER] = array("Content-Type: application/json;charset=UTF-8");
            $opt[CURLOPT_POST] = 1;
            $opt[CURLOPT_POSTFIELDS] = call_user_func($func , $arrPost );
        }
        curl_setopt_array($ch, $opt);
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response, true);
        return $res; 
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
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>A域名的登录框</title> 
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <form action="http://www.A.com/index.php" method="post">
            <input type="text" name="uname" placeholder="帐号"/>
            <input type="password" name="upasswd" placeholder="密码"/>
            <input type="submit" value="提交" />
        </form>
    </body>
</html>
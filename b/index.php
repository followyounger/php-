<?php
header("Content-type: text/html; charset=utf-8");
$sid = isset($_COOKIE['SID']) ? $_COOKIE['SID'] : '';

if(empty($sid)) echo "请先登录";

$response = curl_post('http://www.u.com/index.php',array('sid'=>$sid));
if($response['code'] > 0) {
    die('error：'.$response['msg']);
}

die('您的帐号密码是：'.$response['data']['uinfo']);

function curl_post( $url , $arrPost = array() , $func = "http_build_query" ){
    $ch = curl_init();

    $opt[CURLOPT_URL] = $url;
    $opt[CURLOPT_RETURNTRANSFER] = 1;
    $opt[CURLOPT_TIMEOUT] = 10;
    if( !empty( $arrPost ) ){
        if( $func == 'json_encode' )
            $opt[CURLOPT_HTTPHEADER] = array("Content-Type: application/json;charset=UTF-8");
        $opt[CURLOPT_POST] = 1;
        $opt[CURLOPT_POSTFIELDS] = call_user_func( $func , $arrPost );
    }

    curl_setopt_array ( $ch, $opt );
    $response = curl_exec( $ch );
    curl_close( $ch );

    return json_decode($response, true);
}
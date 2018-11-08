<?php
header("Content-type: text/html; charset=utf-8");

$sid = isset($_POST['sid']) ? $_POST['sid'] : '';
if(!empty($sid)) {
    $uname_upasswd = file_get_contents($sid);
    if(empty($uname_upasswd)) {
        die(json_encode(array(
            'code'=>1,
            'msg'=>'fail',
            'data'=>array()
        )));
    }
    die(json_encode(array(
        'code'=>0,
        'msg'=>'success',
        'data'=>array('uinfo'=>$uname_upasswd)
    )));
}
$uname = isset($_POST['uname']) ? $_POST['uname'] : '';
$upasswd = isset($_POST['upasswd']) ? $_POST['upasswd'] : '';

if($uname == '' || $upasswd == '') {
    die(json_encode(array(
        'code'=>1,
        'msg'=>'fail',
        'data'=>array()
    )));
}

define('SID_SALT', '密码盐');
$passwd = passwd($uname.$upasswd,SID_SALT);
file_put_contents($passwd, $uname.'，'.$upasswd);
die(json_encode(array(
    'code'=>0,
    'msg'=>'success',
    'data'=>array('sid'=>$passwd)
)));


function passwd($string,$salt) {
    return md5(substr(md5($string).md5($salt),16,48));
}
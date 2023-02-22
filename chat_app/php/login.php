<?php
session_start();

include_once('config.php');
include_once('../classes/UserLogic.php');

$email = filter_input(INPUT_POST, 'email');
if(!$email){
    $res['err_masg'] = "Emailアドレスを入力して下さい";
    exit();
}
$password = filter_input(INPUT_POST, 'password');
if(!$email){
    $res['err_masg'] = "パスワードを入力してください";
    exit();
}

$user = UserLogic::login($email, $password);
if(!$email){
    $res['err_masg'] = "Emailまたはパスワードに誤りがあります";
    exit();
}


// セッションにIDを保持
$_SESSION['unique_id'] = $user['unique_id'];

$res['user'] = $user;

echo json_encode($res);
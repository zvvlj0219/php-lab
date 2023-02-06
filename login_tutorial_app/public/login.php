<?php
// セッション
session_start(); //セッションにセッションIDが入る

require_once ('../classes/UserLogic.php');

//エラーメッセージ
$err = [];

//バリデーション
$email = filter_input(INPUT_POST, 'email');
if(!$email){
    $err['email'] = 'メールアドレスを記入してください';
}

$password = filter_input(INPUT_POST, 'password');
if(!$password){
    $err['password'] = 'パスワードを記入してください';
}

if(count($err) > 0) {
    // バリデーションの内容をスーパーグローバル変数に渡しどこからでも参照できるようにする
    $_SESSION = $err;
    header("Location: login_form.php");
    return;
}

// ログイン後の処理
$result = UserLogic::login($email, $password);

if(!$result) {
    header("Location: login_form.php");

    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン完了画面</title>
</head>
<body>
    <h2>ログイン完了</h2>
    <p>ログインしました</p>
    <a href="mypage.php">マイページへ</a>
</body>
</html>
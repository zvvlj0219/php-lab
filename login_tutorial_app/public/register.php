<?php
require_once ('../classes/UserLogic.php');

session_start();

//エラーメッセージ
$err = [];

// signup_form.phpからトークンを受け取る
$token = filter_input(INPUT_POST, 'csrf_token');

if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']){
    exit("ACCESS DENIED");
}

// 二重送信対策
unset($_SESSION['csrf_token']);

//バリデーション
$username = filter_input(INPUT_POST, 'username');
$email = filter_input(INPUT_POST, 'email');
if(!$username){
    $err[] = 'ユーザー名を記入してください';
}
if(!$email){
    $err[] = 'メールアドレスを記入してください';
}

// 正規表現
/**
 * PHPでpreg_match関数を使用すると、指定した文字列の中に、
 * 正規表現にマッチする(合っている)文字が存在するか確認することができます。
 * よく使うパターンとしては、入力されたフォーマットが正しいかチェックするときなどに
 * 使用します。郵便番号の入力形式が正しいか、電話番号の入力形式が正しいかなどです。
 */
$password = filter_input(INPUT_POST, 'password');
if(!preg_match("/\A[a-z\d]{8,100}+\z/i", $password)){
    $err[] = 'パスワードは英数字8文字以上100文字以下にしてください';
}

$password_conf = filter_input(INPUT_POST, 'password_conf');
if($password !== $password_conf){
    $err[] = '確認用パスワードと異なっています';
}

if(count($err) === 0) {
    //ユーザーを登録する処理
    $userData = [
        "username" => $username,
        "email" => $email,
        "password" => password_hash($password, PASSWORD_DEFAULT) 
    ];

    $hasCreated = UserLogic::createUser($userData);

    if(!$hasCreated){
        $err[] = "登録に失敗しました";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー登録完了画面</title>
</head>
<body>
    <?php if(count($err) > 0) : ?>
        <?php foreach($err as $e) : ?>
            <p><?php echo $e ?></p>
        <?php endforeach ?>
    <?php else : ?>
        <p>ユーザー登録画完了しました</p>
    <?php endif ?>
    <a href="./signup_form.php">戻る</a>
</body>
</html>
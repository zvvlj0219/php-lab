<?php
// http://localhost/practice-php/php-lab/apps/認証/cookie_session.php

// クッキーを使って10秒のページリクエスト回数を保持する
// クッキーの有効期限が切れたら、新しいクッキーを発行する

$SESSION_NAME = 'my_session';
$PV = 'pv';
$pv_count = 0;

session_name($SESSION_NAME);
// $_COOKIE['my_session'] 初期値はランダムなID
// 下のsession_regenerate_id()で新しいIDに自動で変わる
/**
 * $_COOkIE = array(
 *      "my_session" => ランダムなID, 
 *      etc..
 * )
 */

session_start();

session_regenerate_id(true);

$hasSession = isset($_COOKIE[session_name()]);
$hasPV = isset($_COOKIE[$PV]);

if($hasSession && $hasPV){
    $pv_count = $_COOKIE[$PV] + 1;
} else {
    $pv_count = 1;
}
setcookie($PV, $pv_count, time() + 10);

var_dump($_COOKIE);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>10秒PV計測</title>
</head>
<body>
    <p>
        10秒のPVを計測します<br />
        10秒以内にページをリロードすればカウントを維持できる
    </p>
    <p>
        <?php
            print('セッション名は'.session_name().'です<br />');
            print('セッションIDは'.session_id().'です<br />');
        ?>
    </p>
    <?php
        if(!$hasSession){
            print('初回の訪問です。セッションを開始します。');
        } else{
            print($pv_count.'回目の訪問です。<br>');
        }
    ?>
</body>
</html>
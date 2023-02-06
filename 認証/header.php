<?php
// localhost/practice-php/php-lab/認証/header.php

/**
 * header関数の役割は、
 * レスポンスヘッダを設定することです。 
 * ヘッダ情報には、クライアントからサーバーへ送られる
 * リクエストヘッダと、サーバーからクライアントに送られる
 * レスポンスヘッダが 存在しており、このレスポンスヘッダを
 * PHPスクリプトから操作することが出来るものがheader関数となります。
 */

if (!isset($_SERVER['PHP_AUTH_USER'])){
    header('WWW-Authenticate: Basic realm="Private Page"');
    header('HTTP/1.0 401 Unauthorized');

    //多分認証が通ると
    //PHP_AUTH_USER,PHP_AUTH_PWが作られる
    var_dump($_SERVER);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    this is header php
</body>
</html>
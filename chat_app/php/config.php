<?php
include_once(dirname(__FILE__).'/../env.php');

function db_connect(){
    $host = DB_HOST;
    $db_name = DB_NAME;
    $user = DB_USER;
    $password = DB_PASSWORD;

    $dsn = "mysql:host={$host};charset=utf8mb4;dbname={$db_name}";

    try{
        // pdo (php data object)のインスタンス作成
        $dbh = new PDO($dsn, $user, $password);

        // PDO::ERRMODE_EXCEPTION エラー処理方法の設定 属性を設定する
        // PDO::FETCH_ASSOC 配列をkey=>valueで必ず返す
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        // dbh (database handler)
        return $dbh;
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        die('データベース接続に失敗しました');
    }
}
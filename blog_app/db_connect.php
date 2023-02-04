<?php
/**
 * mysqlへの接続
 */

// データベース名
define('DB_DATABASE', 'todo');
// mysqlのユーザー名
define('DB_USERNAME', 'root');
// パスワード
define('DB_PASSWORD', '3.)W[+jJWL2PT4C');
// DSN (data souece name)
define('DSN', 'mysql:host=localhost;charset=utf8;dbname='.DB_DATABASE);

function db_connect() {
    try{
        // pdo (php data object)のインスタンス作成
        $dbh = new PDO(DSN, DB_USERNAME, DB_PASSWORD);

        // エラー処理方法の設定 属性を設定する
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // dbh (database handler)
        return $dbh;
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        die('データベース接続に失敗しました');
    }
}

?>

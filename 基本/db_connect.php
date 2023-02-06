<?php
// http://localhost/practice-php/php-lab/DB/db_connect.php
/**
 * 公式サイトによると、mysql_connectは PHP5.5.0で非推奨になり、
 * PHP 7.0.0で削除されています。よほど古いサイトの改修などに
 * 関わる時以外は使う事はまず無いでしょう。
 * 他にもほとんどのmysql関数が非推奨または削除となっています。
 * 
 * mysql_connectが削除されたのでその代替方法として用意されているのが
 * mysqli関数です。
 * mysqli関数はオブジェクト指向と手続き型の２パターンでの実装が可能です。
 * これはmysql_connectからの移行を配慮して後方互換の為に残しておいた
 * ものらしいので、基本的にはオブジェクト指向の方で実装すれば良いかと
 * 思います。
 */

$db_username = 'root';
$db_password = '3.)W[+jJWL2PT4C';
$db_name = 'blog';
$table_name = 'blogs';

// $mysqli = new mysqli('localhost', $db_username, $db_password, $db_name);
// if (mysqli_connect_error()){
//     die("データベースの接続に失敗しました");
// }

/**
 * PDO => PHP Data Objects
 * PHPからデータベースへ接続するためのクラスのことです。
 *  dbh => data base handler
 * dsn => data source name
 */

// Data Source Name
$dsn = "mysql:dbname={$db_name};host=localhost";
try{
    $dbh = new PDO($dsn, $db_username, $db_password);

    print('<br>');

    if ($dbh == null){
        print('接続に失敗しました。<br>');
    }else{
        print('接続に成功しました。<br>');
    }
    
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $dbh->query("SELECT * FROM {$table_name}");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    var_dump($result);

    $dbh = null;
}catch(PDOException $e){
    print('Connection failed:'.$e->getMessage());
    die();
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
    this is db connect php
</body>
</html>
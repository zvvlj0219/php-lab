<?php 
    require('./db_connect.php');

    // URLのパラメータに渡されているidを取得する
    $id = filter_input(INPUT_GET, 'id');

    try{
        // データベースに接続する dbh database handler
        $dbh = db_connect();

        $sql = "delete from posts where id = :id";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // main.phpにリダイレクト
        header("Location: ./main.php");

        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
?>

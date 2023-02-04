<?php
    // 新規todo登録
    // db_connectを使うためにインポートする
    require('db_connect.php');

    // リクエストの内容を受け取る
    $title = filter_input(INPUT_POST, 'title');
    $content = filter_input(INPUT_POST, 'content');
    // submitはイベントが実行されたら,
    // inputのvalue属性の値がセットされる 初期値はNULL
    $submit = filter_input(INPUT_POST, 'submit');

    //submitイベントが発火されたときに以下の処理をするようにする
    if (!empty($submit)) {
        // データベースに接続する dbh database handler
        $dbh = db_connect();

        try{
            // 新規のデータを登録するsql
            $sql = "insert into posts (title, content) values (:title, :content)";

            // prepareで待機
            $stmt = $dbh->prepare($sql);

            // bindParam() sql文のパラメータに値を設定する
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);

            $stmt->execute();

            // 登録完了したらmain.phpへ戻る
            header("Location: ./main.php");
        } catch(PDOException $e) {
            echo 'エラー：' . $e->getMessage();
            die();
        }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録</title>
    <link rel="stylesheet" href="./styles/style.css?<?php echo time(); ?>">
</head>

<body>
    <div class="title-area">
        <h1>新規登録</h1>
        <a href="main.php" style="color: white;">メイン画面に戻る</a>
    </div>
    <form action="" method="POST">
        <input type="text" class="input-area" name="title" placeholder="Title" required> <br>
        <input type="text" class="input-area" name="content" placeholder="Content" required> <br>
        <input type="submit" class="input-area submit" name="submit" value="登録">
    </form>
</body>

</html>
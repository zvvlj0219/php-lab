<?php
    require('./db_connect.php');

    // edit.phpで編集した内容を受け取る
    $id = filter_input(INPUT_POST, 'id');
    $title = filter_input(INPUT_POST, 'title');
    $content = filter_input(INPUT_POST, 'content');
    $submit = filter_input(INPUT_POST, 'submit');

    $dbh = db_connect();

    if(!empty($submit)){
        try{
            $sql = 'update posts set title = :title, content = :content where id = :id';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch(PDOException $e){
            echo $e->getMessage();
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
    <title>編集完了画面</title>
    <link rel="stylesheet" href="./styles/style.css?<?php echo time(); ?>">
</head>
<body>
    <div class="title-area">
        <h1>編集完了画面</h1>
    </div>
    <div class="text-area">
        <p>ID:<?php echo $id?>を編集しました。</p>
        <p><a href="main.php">メイン画面に戻ります。</a></p>
    </div>
</body>
</html>
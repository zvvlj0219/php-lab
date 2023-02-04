<?php
    // db_connectを使うためにインポートする
    require('./db_connect.php');

    $dbh = db_connect();
    try {
        // ポストを全件取得、時間の小さい順に
        // $sql = "SELECT * FROM posts";
        $sql = "SELECT * FROM posts ORDER BY time";
        
        // stmtにはPDOStatement | falseが帰ってくる
        $stmt = $dbh->query($sql);

    } catch(PDOException $e) {
        echo $e->getMessage();
        die(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    
    <title>メインページ</title>
</head>
<body>
    <h1>メインページ</h1>
    <a href="create.php" ><button type="button" class="btn btn-primary">新規登録</button></a>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">記事ID</th>
                <th scope="col">タイトル</th>
                <th scope="col">本文</th>
                <th scope="col">作成日</th>
                <th scope="col">編集</th>
                <th scope="col">削除</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($stmt as $row) : ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["title"]; ?></td>
                    <td><?php echo $row["content"]; ?></td>
                    <td><?php echo $row["time"]; ?></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id'];?>">編集</a>
                    </td>
                    <td>
                        <a href="delete.php?id=<?php echo $row['id'];?>">削除</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
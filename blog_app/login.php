<?php
    // http://localhost/practice-php/php-lab/apps/blog_app/login.php
    // 参考記事 https://fukuroblog.com/todo-delete/

    // db_connectを使うためにインポートする
    require('./db_connect.php');

    /**
     * php リロードしたら同じデータが登録されてしまう-対策方法
     * https://minamiblog-0601.com/php_header/
     * 
     * 概要
     * それは、フォームを送信するとPHPでは「$_POST」という変数に格納されます。
     * この変数は、送信後も保持されているのでリロードをするともう一度送信されてしまいます。
     * 対策
     * header関数でページ遷移させます
     */

    // リクエストの内容を受け取る
    // $_POST['name']のような書き方は,php8.0以上はfilter_inputとかを使わないとエラーになる
    $name = filter_input(INPUT_POST, 'name');
    $password = filter_input(INPUT_POST, 'password');
    // submitはイベントが実行されたら,
    // inputのvalue属性の値がセットされる 初期値はNULL
    $submit = filter_input(INPUT_POST, 'submit');

    //submitイベントが発火されたときに以下の処理をするようにする
    if (!empty($submit)) {
        // データベースに接続する dbh database handler
        $dbh = db_connect();

        try{
            // sql文 :name :passwordには後から値が入る（引数みたいなもの）
            $sql = "select * from users where name = :name and password = :password";

            // sql文に:nameみたいなパラメータがあるときは、
            // prepareメソッドで待機させておく
            // パラメータがない時はqueryメソッドで実行する
            $stmt = $dbh->prepare($sql);

            // bindParam() sql文のパラメータに値を設定する
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':password', $password);

            // prepareで待機させておいたsqlを実行する
            // bindParamで値を設定するか、
            // excute()の引数に配列として渡す この場合
            // excute(array(':name' => $name, ':password' => $password));
            $stmt->execute();
        } catch(PDOException $e) {
            echo 'エラー：' . $e->getMessage();
            die();
        }

        // stmtは多次元配列になっている
        // stmt = array([0] => array(...), [1] => array(...),... )

        // fetch()の引数modeはPDOがその行(レコード)をどの様に返すかを決定する
        // PDO::FETCH_ASSOCは多分array()ぽいものを返す
        // excuteして取得したデータが何件かのレコードがあったとしても
        // fetchは初めの抽出した１件を返す
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            // 処理が成功すればページ遷移させる
            header("Location: ./main.php");

            // exitはメッセージを出力し、現在のスクリプトを終了する
            exit;
        } else {
            echo '
            <font color="red">
                パスワードか名前に間違いがあります。
            </font>
        ';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログインページ</title>
    <link rel="stylesheet" href="./styles/style.css?<?php echo time(); ?>">
</head>

<body>
    <div class="title-area">
        <h1>ログインページ</h1>
    </div>

    <!-- actionにはデータを送信したいurlを指定する -->
    <!-- この場合同じファイルになるので何も指定しない -->
    <form action="" method="POST">
        <input type="text" class="input-area" name="name" placeholder="Your Name" required> <br>
        <input type="text" class="input-area" name="password" placeholder="Your Password" required> <br>
        <input type="submit" class="input-area submit" name="submit" value="ログイン">
    </form>

</body>
</html>
<?php
    // http://localhost/practice-php/php-lab/apps/login_tutorial_app/public/login.php
session_start();

$err = $_SESSION;

// セッションを消す
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
</head>
<body>
    <h2>ログインフォーム</h2>

    <?php if(isset($err['msg'])) : ?>
        <p><?php echo $err['msg'] ?></p>
    <?php endif; ?>

    <form action="login.php" method="post">

        <!--  パスワード自動補完対策-->
            <div style="width:0;height:0;overflow:hidden;">
                <input type="text" name="_users">
                <input type="password" name="_pwd">
            </div>
        <!--  パスワード自動補完対策-->

        <p>
            <label for="email">メールアドレス:</label>
            <input type="email" name ="email" >
            <?php if(isset($err['email'])) : ?>
                <p><?php echo $err['email'] ?></p>
            <?php endif; ?>
        </p>

        <p>
            <label for="password">パスワード:</label>
            <input type="password" name ="password">
            <?php if(isset($err['password'])) : ?>
                <p><?php echo $err['password'] ?></p>
            <?php endif; ?>
        </p>

        <p> 
            <input type="submit" value="ログイン">
        </p>

    </form>
    <a href="signup_form.php">新規登録はこちらから</a>
</body>
</html>
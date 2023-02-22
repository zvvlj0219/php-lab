<?php
// http://localhost/practice-php/php-lab/apps/chat_app

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once('./head.php') ?>
<body>
<div class="wrapper">
    <section class="form login">
        <header>Realtime Chat App</header>
        <form action="#" method="POST" autocomplete="off">
            <div class="error-text"></div>
            
            <!--  パスワード自動補完対策-->
                <div style="width:0;height:0;overflow:hidden;">
                    <input type="text" name="_users">
                    <input type="password" name="_pwd">
                </div>
            <!--  パスワード自動補完対策-->

            <div class="field input">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="field input">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
                <i class="fas fa-eye"></i>
            </div>
            <div class="field button">
                <input type="submit" name="submit" value="Continue to Chat">
            </div>
        </form>
        <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
    </section>
</div>

<script src="js/pass-show-hide.js"></script>
<script src="js/login.js"></script>

</body>
</html>
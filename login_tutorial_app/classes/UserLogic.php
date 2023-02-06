<?php
require_once ('../db_connect.php');

class UserLogic {
    /**
     * ユーザーを登録する
     *
     * @param array $userData
     * @return bool $result
     */
    public static function createUser($userData)
    {
        $result = false;

        $sql = "insert into users (name, email, password) values (:name, :email, :password)";

        try{
            $dbh = db_connect();

            $stmt = $dbh->prepare($sql);

            $stmt->bindParam(':name', $userData['username']);
            $stmt->bindParam(':email', $userData['email']);
            $stmt->bindParam(':password', $userData['password']);

            $result = $stmt->execute();

            return $result;
        } catch(PDOException $e){
            echo 'エラー：' . $e->getMessage();
            die();
        }
    }

    /**
     * ログイン処理
     *
     * @param string $email
     * @param string $password
     * @return bool $result
     */
    public static function login($email, $password)
    {

        // 結果
        $result = false;

        // ユーザーをemailから検索して所得
        $user = self::getUserByEmail($email);

        if(!$user) {
            $_SESSION['msg'] = "emailが一致しません";

            return $result;
        }

        // パスワードの照会(パスワードをでコードして、ログインフォームで入力されたものと同じかの確認)
        $verified = password_verify($password, $user['password']);

        if($verified){
            // ログイン成功
            session_regenerate_id(true);
            
            // この時点では $_SESSION === array() 空
            // $_SESSIONにユーザーの情報を保持する
            $_SESSION['login_user'] = $user;

            $result = true;

            return $result;
        } else {
            $_SESSION['msg'] = "パスワードが一致しません";
            return $result;
        }
    }

    /**
     * emailからユーザー取得
     * @param string $email
     * @return array | bool $user | false
     */
    public static function getUserByEmail($email)
    {
        $sql = "select * from users where email = :email";

        try{
            $dbh = db_connect();

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch(PDOException $e){
            return false;
        }
    }

    /**
     * ログインチェック
     * @param void
     * @return bool $result
     */
    public static function checkLogin()
    {
       $result = false;

       // セッションにログインユーザーがはいてなかったらfalse
       if(
            isset($_SESSION['login_user'])
            && $_SESSION['login_user']['id'] > 0
        ){
            $result = true;
        }

        return $result;
    }

    /**
     * ログアウト
     * @param void
     * @return bool $result
     */
    public static function logout()
    {
        // php公式でドキュメントより
        $_SESSION = array();
        session_destroy();
    }
}

?>
<?php
// import db_connect
require_once(dirname(__FILE__).'/../php/config.php');

class UserLogic {
    /**
     * Emailでユーザーを検索
     *
     * @param string $email
     * @return $user | false
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
     * unique_idでユーザーを検索する
     *
     * @param string $unique_id
     * @return $user | false
     */
    public static function getUserFromId($unique_id)
    {
        $sql = "select * from users where unique_id = :unique_id";

        try{
            $dbh = db_connect();

            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':unique_id', $unique_id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch(PDOException $e){
            return false;
        }
    }

    /**
     * ユーザー全件検索
     *
     * @param  void
     * @return PDOStatement | false $stmt | false
     */
    public static function fetchAllUsers()
    {
        $sql = "select * from users";

        try{
            $dbh = db_connect();
            $stmt = $dbh->query($sql);
            return $stmt;
        } catch(PDOException $e){
            return false;
        }
    }


    /**
     * 画像の拡張子をチェック
     *
     * @param  string $img_name
     * @return bool
     */
    public static function checkExt($img_name)
    {
        //アップロードされたファイルの拡張子を取得
        $img_explode = explode('.', $img_name);
        $img_ext = end($img_explode);

        // 拡張子が許可されたものかチェックする
        $extention = ['png', 'jpeg', 'jpg'];
        $result = in_array($img_ext, $extention, true);

        return $result;
    }

    /**
     * 画像をアップロード
     *
     * @param string $img_name
     * @param string $tmp_name
     * @return bool
     */
    public static function uploadImage($new_img_name, $tmp_name)
    {
        if(!file_exists('../images/')){
            mkdir('../images/');
        }

        // imagesフォルダに画像をアップロード
        return move_uploaded_file($tmp_name, "../images/".$new_img_name);
    }

    /**
     * ユーザー登録
     *
     * @param string $fname
     * @param string $lname
     * @param string $email
     * @param string $password
     * @param string $img
     * @return bool
     */
    public static function insertUser(
        $fname, $lname, $email, $password, $img
    )
    {
        // ランダムなID
        $unique_id = rand(time(),1000000);

        // ステータス
        $status = "Active now";

        $insert_query = "
            insert into users 
                (unique_id, fname, lname, email, password, img, status)
            values
                (:unique_id, :fname, :lname, :email, :password, :img, :status)
            ";

        try{
            $dbh = db_connect();

            $stmt = $dbh->prepare($insert_query);
            $stmt->bindParam(':unique_id', $unique_id);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':img', $img);
            $stmt->bindParam(':status', $status);
            $result = $stmt->execute();

            return $result;
        } catch(PDOException $e) {
            return false;
        }
    }

    /**
     * ログイン
     *
     * @param string $email
     * @param string $password
     * @return void
     */
    public static function login($email, $password)
    {
        $user = self::getUserByEmail($email);

        // パスワードの確認はまたこんど

        return $user;
    }


}
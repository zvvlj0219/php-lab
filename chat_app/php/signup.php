<?php
session_start();

require_once('config.php');
require_once('../classes/UserLogic.php');

/**
 * $_POSTはissetでtrueになればそれ以下では普通に使える
 * 
 * php://input は、 
 * enctype="multipart/form-data" に対しては 使用できません。
 * 
 * formのtype="file"以外はenctype="multipart/form-data"でも
 * filter_inputで取得できる
 * 
 * undefinedを避けるにはemptyとかissetを使うしない
 * fileは$_FILES[formのname属性の値]
 * 
 * headerはなくてもなんか大丈夫だった
*/

$fname = filter_input(INPUT_POST, 'fname');
$lname = filter_input(INPUT_POST, 'lname');
$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');

// 全般バリデーション
if(
    empty($fname)
    || empty($lname)
    || empty($email)
    || empty($password)
    || empty($_FILES)
){
    $res['err_msg'] = '入力に誤りがあります';
    echo (json_encode($res));
    exit();
}

// emailバリデーション
if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $res['err_msg'] = '有効なEmailアドレスではありません';

    echo (json_encode($res));
    exit();
}

// dbにユーザーが存在していたら、処理終了
$existedUser = UserLogic::getUserByEmail($email);
if($existedUser){
    $res['err_msg'] = '登録済みのメールアドレスです';

    echo (json_encode($res));
    exit();
}

//画像をアップロード
/**
 * ユーザーがアップロードしたファイルをデータベースに,
 * アップロードするのではなく、ファイルの URL を,
 * 保存するだけであることを忘れないでください。
 * 実際のファイルは特定のフォルダーに保存されます。
 * 
 * $_FILES['inputで指定したname']['name']：ファイル名
 * $_FILES['inputで指定したname']['type']：ファイルのMIMEタイプ
 * $_FILES['inputで指定したname']['tmp_name']：一時保存ファイル名
 * $_FILES['inputで指定したname']['error']：アップロード時のエラーコード
 * $_FILES['inputで指定したname']['size']：ファイルサイズ（バイト単位）
 */

 //画像がアップロードされていなかったら処理終了
if(empty($_FILES['image']['name'])){
    $res['err_msg'] = '画像を選択してください';
    echo (json_encode($res));
    exit();
}

// 画像の情報を変数で保持
$img_name = $_FILES['image']['name'];
$img_type = $_FILES['image']['type'];
$tmp_name = $_FILES['image']['tmp_name'];

// 拡張子が許可されたものかチェックする
$validExt = UserLogic::checkExt($img_name);
if(!$validExt){
    // 許可されたものでないときは処理終了
    $res['err_msg'] = '画像は、「png, jpeg, jpg」のいずれかしか登録できません';
    echo (json_encode($res));
    exit();
}

// 画像名を変更
$new_img_name = time().$img_name;
// 画像をフォルダに保存
$uploaded = UserLogic::uploadImage($new_img_name, $tmp_name);
if(!$uploaded){
    $res['err_msg'] = '画像のアップロードに失敗しました';
    echo (json_encode($res));
    exit();
}

// ユーザー登録
$insert_result = UserLogic::insertUser($fname, $lname, $email, $password, $new_img_name);
if(!$insert_result){
    $res['err_msg'] = 'ユーザー登録に失敗しました';
    echo (json_encode($res));
    exit();
}

// ユーザー検索
$registerdUser = UserLogic::getUserByEmail($email);
if($registerdUser){
    $res['registerdUser'] = $registerdUser;

    // セッションにIDを保持
    $_SESSION['unique_id'] = $registerdUser['unique_id'];

    echo (json_encode($res));
    exit();
} else {
    $res['err_msg'] = '処理に失敗しました';
    echo (json_encode($res));
    exit();
}


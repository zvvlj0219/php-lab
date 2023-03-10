<?php
// localhost/practice-php/php-lab/認証/session.php
/**
 * ■導入
 * まず最初にセッションについて簡単にご説明します。
 * セッションとは開始から終了までの期間です
 * セッションはクッキーと似ていますが、
 * クッキーの場合は管理したい値をクライアント側に保存するのに対し、
 * セッションではサーバ側で管理することです。
 * 
 * 
 * 
 * ■セッション開始
 *       bool session_start()
 * クッキーにセッションIDを入れる
 * セッションを作成します。もしくは、リクエスト上で
 * GET,POSTまたはクッキーにより渡されたセッションIDセッションに基づき,
 * 現在のセッションを復帰します
 * 
 * 
 * ■セッションID 
 *       $_COOKIE["PHPSESSID"])
 * そしてクライアント側にはどのセッションを使っているかを識別するための,
 * セッションIDだけをクライアント側に保存します。
 * このセッションIDをクライアント側に保存するためにクッキーを使うのが一般的です
 * (つまりセッションを使う場合は同時にクッキーも使います)。
 * セッションがまだ開始されていない状態でこの関数が呼ばれた場合は、
 * 新しいセッションを開始しセッションIDを割り当てます。
 * セッションIDはクライアント側にクッキー名「PHPSESSID」で保存されます。
 * (PHPSESSIDはデフォルト値であり、php.iniで変更可)
 * iDの中身はランダムな値が使われるようになっています。
 * 
 * 
 * ■セッション変数 
 *      $_SESSION[セッション変数名] = 値
 * クッキーだけを使って値をクライアント側に保存する場合は盗み見られる場合などもあります。
 * セッションでは値はサーバ側にセッション変数として保存されますので,
 * 大事なデータを扱う場合などはセッションの方を出来る限り使います。
 * クライアント毎に色々な値が書き込まれますが、セッションID(ランダム値)を,
 * 識別子としてどのクライアントが保存した値かは識別できるようになっています。
 * 
 * 
 * ■セッション変数の削除とセッションIDの削除
 *       unset (セッション変数)
 *       void unset ( mixed var [, mixed var [, mixed ...]] )
 * 保存されたセッション変数を削除することも出来ます。「unset」関数を使います。
 * 例）unset($_SESSION("visited"));
 *   また全てのセッション変数を削除するためには
 * 下記のように空の配列を「$_SESSION」変数に格納します。
 * $_SESSION = array();
 * 例えばログアウトの処理などをしてセッションそのものを破棄したい場合です。
 * この場合はクライアント側に保存されているセッションIDを削除した後で、
 * セッションを破棄します。
 * クライアント側にはクッキーで保存されていますのでクッキーを削除します。
 * 
 * 
 * ■セッション名 
 *      string session_name ( [string name] )
 * セッションを開始した際にクライアントのクッキー名として利用されるのが,
 * デフォルトでは「PHPSESSID」となっています。この値をセッション名と言いますが、
 * デフォルト値はphp.iniで設定されています。
 * もしデフォルト値を変更したいのであれば、php.iniを変更して下さい。
 *    このようにセッション名は必ず固定されているものではないため、
 * プログラム中では固定値の「PHPSESSID」を使って記述してしまうと,
 * 問題となる場合があります。その為、セッション名を参照したい場合には,
 * 現在使われているセッション名を取得できる「session_name」関数を使います。
 *    「session_name」関数を引数無しで使うと、現在のセッション名を取得できます。
 * また引数に別のセッション名を指定した場合には、セッション名を変更が可能です。
 * 
 * 
 * ■セッションIDの取得と変更
 *      string session_id ( [string id] )
 * セッションIDは自動的にランダムな値が設定されますが、
 * セッションIDを自分で設定することも出来ます。「session_id」関数を使います。
 * 引数なしで現在のセッションIDを取得し、
 * 引数に新しいセッションIDを指定することでセッションIDを変更できる
 * 
 * ■セッションIDの自動変更 
 *      bool session_regenerate_id ( [bool delete_old_session] )
 * セッションは便利ですがセッションIDが漏洩すると、
 * 別の人にセッションを乗っ取られる可能性もあります。
 * そこでセッションIDを絶えず変更することでセキュリティを向上させることが出来ます。
 * 「session_regenerate_id」関数は、現在使っているセッションを終了させることなく,
 * セッションIDだけを新しい値に置き換えてくれます。
 * PHP5.1以降になって古いセッションを削除することが引数で指定することで
 * 出来るようになりました。古いセッション情報を残しておくことは資源の無駄であると,
 * 同時にセキュリティ的にもよくないため、引数の「delete_old_session」はTRUEに
 * 指定することが望ましいと思います。
 * 例）
 * $old_id = session_id();
 * session_regenerate_id(); // ここで自動でセッションIDが変更される
 * $new_id = session_id();
 * 
 */
  session_start();
?>

<html>
<head><title>PHP TEST</title></head>
<body>

<?php

    if (!isset($_COOKIE["PHPSESSID"])){
        print('初回の訪問です。セッションを開始します。');
    }else{
        print('セッションは開始しています。<br>');
        print('セッションIDは '.$_COOKIE["PHPSESSID"].' です。');
    }

    if (!isset($_SESSION["visited"])){
        print('初回の訪問です。セッションを開始します。');

        $_SESSION["visited"] = 1;
        $_SESSION["date"] = date('c');
    }else{
        $visited = $_SESSION["visited"];
        $visited++;

        print('訪問回数は'.$visited.'です。<br>');

        $_SESSION["visited"] = $visited;

        if (isset($_SESSION["date"])){
            print('前回の訪問日時は'.$_SESSION["date"].'です。<br>');
        }

        $_SESSION["date"] = date('c');
    }


?>

</body>
</html>
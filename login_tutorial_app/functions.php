<?php

/**
 * XSS クロスサイトスクリプティング
 * webページにアクセスすることで、不正なスクリプトが実行される脆弱性
 */
/**
 * XSS対策:エスケープ処理
 * 
 * @param string $str 対象の文字列
 * @return string 処理された文字列
 */
function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}


/**
 * CSRF(シーサーフ)
 * クロスサイトリクエストフォージェリ（偽造）
 * web利用者が意図しない、偽造されたリクエストが実行されてまう脆弱性
 */
/**
 * csrf対策
 *
 * @param void
 * @return string $csrf_token
 */
function setToken(){
    // トークンを生成
    $csrf_token = bin2hex(random_bytes(32));
    // セッションでトークンを保持
    $_SESSION['csrf_token'] = $csrf_token;

    return $csrf_token;
}
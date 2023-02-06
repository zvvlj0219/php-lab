<?php

/**
 * 
 * 変数の初期化
 * 変数の初期値にはNULLが代入される
 * そのため初期値を設定しなくても使える
 * 
 * phpは動的型付け言語なので型が違う値を再代入することもできる
 * 
 * ★★jsと違うのはifとかforで宣言された変数はグローバルスコープで
 * 定義したことになる

 */

// 宣言
$name;
$_pref_name;

// 代入
$old = 20;
$name = '加藤';

//エイリアス 
$num1 = 320;
$num2 =& $num1; // 代入ではない

$num1 = 45;
echo($num1); // expected output 45
echo($num2); // expected output 45

/**
 * 定数
 * define(識別子, 値);
 * 大文字と小文字は区別して扱われますが
 * 慣習的に定数名は全て大文字を使います。
 * 変数名とは異なり先頭に「$」は必要ありません。
 */

define("TAX", 0.10);

$price1 = 100 * (1 + TAX);
$price2 = 84 * (1 + TAX);
$price3 = 180 * (1 + TAX);

/**
 * jsとは違う
 * ifとかforで宣言された変数はグローバルスコープで
 * 定義したことになる
 */

if(true){
    $count = 10;
}
echo $count; // expected output 10
// if内の変数が参照できる！！
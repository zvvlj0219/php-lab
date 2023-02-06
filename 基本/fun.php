<?php

// localhost/practice-php/php-lab/基本/fun.php

/**
 * 関数
 * jsと異なるのは関数内からグローバルレベルの参照をするには
 * &もしくはuseを使わなければならない 「参照渡し」
 * 普通に仮引数に変数を渡すことを「値渡し」という
 * 
 */
// 関数
function sum($num1, $num2){
    return $num1 + $num2;
}

// 型をつけて定義もできるけど
// typescriptみたいに型推論はされない
function add(int $a, int $b): int{
    return $a + $b;
}

add(2,3);
sum(3,4);
// add('', 8);
// エディター上では引数に文字列を渡しても怒られない

// 返り値を変数に代入
$result = add(100,200);
echo $result; // expected output 300

/**
 * 参照
 * グローバルスコープの変数であっても、
 * 関数内で使う際は
 * 参照渡しで引数にセットしないと使えない
 */

// &を付けて参照渡し(=グローバルスコープの参照)
function printData_1 (&$result) {
    echo $result; // 300
}
printData_1($result);

function editResult (&$result) {
    $result *= 2; 
    // $ここではグローバルスコープの
    // $resultを参照するので
    // 値を書き換えたら
    // 参照元の$resultも上書きされる
}
editResult($result);
echo $result; // 600 

$printData_2 = function(&$result, $name){
    echo "{$name}の結果は{$result}です";
};
$printData_2($result,'john'); // johnの結果は600です


/**
 * 関数式として定義するときは
 * 呼びだし時は、$変数() と書く
 */
$greeting = function($name){
    echo 'hello';
    echo "My name is {$name}";
}; // 変数なのでセミコロンが必要

// greeting('mike'); Undefined function 'greeting'
$greeting('ken'); //変数化してるので呼び出し時$がいる

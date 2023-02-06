<?php
// localhost/practice-php/php-lab/基本/array.php

/**
 * 配列
 * 
 * jsとは違いphpの世界にはオブジェクトがない
 * 
 * 配列のキーには数値も文字列も指定できる！ごちゃまぜにできる
 * js でいうMapオブジェクトに相当
 * 
 * 出力にはechoは使えない（引数がstring型であるため）
 * * 出力される値がstring型であれば使える
 * 
 * var_dump(変数または配列): void
 * print_r( $変数または配列 [, bool $return = false ] ) 
 *          第二引数にtrueを指定すると、結果を返します。
 * var_export($変数または配列 [, bool $return = false ]) がある
 *          第二引数にtrueを指定すると、結果を返します。
 */
$array = [
    'iphone',
    'xperia',
    'gallaxy'
];
print_r($array);

// インデックスを指定して値を追加する
$array_1;
$array_1[0] = 'apple';
$array_1[1] = 'banana';
print_r($array_1);

// キーは数値か文字列ならなんでもいい
$result;
$result['eigo'] = 72;
$result['suugaku'] = 82;
$result[2] = '英語';
$result[-3] = 'マイナスサン';
print_r($result);
// expected output
/**
 * Array ( 
 * [eigo] => 72
 * [suugaku] => 82
 * [2] => 英語
 * [-3] => マイナスサン 
 * )
*/

/**
 * キー自動付与
 * 整数値のキーを自動でつける
 * 
 * 付与される整数値は
 * 配列内に存在する整数値のキーで一番大きいものに１を足した整数値
 * キーが負の数の整数値しか存在してなかたっら、0になる
 */
$var[] = 100; // key => 0
$var[] = 'Tokyo'; // key => 1
$var['var'] = 'var'; // key => 'var'
$var[13] = 13; // key => 13
$var[] = 'キーは14番目'; // key => 14(自動付与)

/**
 * 配列の初期化
 * $変数 = array('key1' => '値’, 'key2' => '値２’,,,,)
 * $変数= array(値1, 値2, ...); この場合キー自動付与
 *  
 * jsでいうところの
 * const m = new Map(
 *  [
 *    ['phone1', 'iphone'],
 *    ['phone2', 'xperia']
 *  ]
 * )
*/
$initializedArray = array(
    'Tokyo' => '東京',
    'Osaka' => '大阪',
    'Fukuoka' => '福岡',
);
print_r($initializedArray);
/**
 * expected output
 * Array (
 * [Tokyo] => 東京
 * [Osaka] => 大阪
 * [Fukuoka] => 福岡
 * )
 */

/**
 * 多次元配列
 * 要素の値にはどのような値でも格納することができます。
 * その為、数値や文字列などに加えて他の配列を格納することも可能です。
 */

$maker = array('富士通', 'NEC', 'Sony', 'Sharp');
$type = array('Note', 'Desktop');
$pc = array($maker, $type); 
print_r($pc);
/**
 * Array(
*   [0] => Array( // $maker
*    )
*   [1] => Array( // $type
*    )
 * )
 */
print($pc[0][1]); // expected output NEC

$fruits= ['apple', 'melon', 'banana'];

//第2引数でtrueを指定すると出力(表示)するのではなく
//結果を戻り値として文字列で返すという動きに変わるのです。
print_r($fruits, true); // なにも表示されない
$res = print_r($fruits, true);
echo $res;

// var_export関数で出力される結果は
// 公式ドキュメントでは「変数表現を返します」とあります。
// この「変数表現」とは「プログラムで記述する際と
// 同じような表記で返すという意味合い」になります。
$res = var_export($fruits, true);
echo $res;
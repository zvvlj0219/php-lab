<?php

/**
 * if分 switch文 while文
 * jsと一緒
 */
$old = 30;

if ($old >= 20){
  print '年齢は20才以上です';
}

$pref = '神奈川';

switch ($pref){
    case '東京':
        print '関東です';
        break;
    case '千葉':
        print '関東です';
        break;
    default :
        print('日本です');
        break;
}

/**
 * 比較演算子
 * jsと同じ
 * == 値が等しい
 * === 値も型も等しい
 * 
 * xor or || は全部同じ
 */
$a = 'a';
$b = 'b';

echo($a === $b); // expected output false
echo($a xor $b);
echo($a or $b);


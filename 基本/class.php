<?php
// localhost/practice-php/php-lab/基本/class.php

/**
 * クラス
 * typescriptの書き方とほぼ一緒
 * 
 * 違う点
 * ●定数をクラスないで定義するときは
 *   defineではなくconstを使う!!!
 * ●メソッド名の部分を"__construct"とすると、
 *   それがコンストラクタとなります。
 * 
 * オブジェクト:クラスをインスタンス化したもの
 * 
 * jsではオブジェクトは 
 * const a = {} とか 
 * クラスをnewしたインスタンスとか
 * 関数は第1級オブジェクトとか
 * クラスはオブジェクトだとか
 * なんでもオブジェクトという
 * 
 * phpではオブジェクトと言うと
 * 基本はインスタンスオブジェクトのことを指す
 * jsでいうところのオブジェクト{}は存在せず、連想配列と呼ぶ
 * 
 * a -> b -> c のように参照する
*/

/**
 * アクセス修飾子
 * public どこからでもアクセス可能
 * protected クラス内と継承したクラス内からアクセス可能
 * private クラス内のみアクセス可能
 */

class Television{
  public $channelNo;

  function dispChannel(){
    print('現在のチャンネルは'.$this->channelNo);
  }

  function setChannel($channel){
    $this->channelNo = $channel;
    $this->dispChannel();
  }
}

$tv = new Television();
$tv->setChannel(5);

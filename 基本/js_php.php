<?php
    /**
     * string file_get_contents('php://input')
     * 
     * javascriptからpostされたデータは、
     * 連想配列（key => value）ではないので
     * $_POSTやfilter_inputでは取り出せない(※昔はできた)。そのため
     * file_get_contents('php://input')を使う
     * 返り値は「json文字列」になっているので
     * json_decode()を使い、phpで扱える連想配列に変換する
     */

    // 例）
    // jsから以下のpostリクエストがあった時
    // const res = await fetch("**.php",{
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json'
    //       },
    //     body: JSON.stringify({
    //         name: 'john',
    //         age: 23
    //     })
    // })
    $json_string = file_get_contents('php://input');

    // 第２引数のtrueはassociate array（連想配列）に変換する
    // trueを入れないとphpプログラムで扱いずらい
    $post_array = json_decode($json_string, true);

    // 任意でkey=>valueを追加できる
    $post_array['php'] = 'ok php';

    // javascriptに値を返すときはjson形式に変換する
    $result_json = json_encode($post_array);

    header('Content-Type: application/json; charset=utf-8');

    // printとかechoを使い、最終的にjavascriptにデータを返す
    print($result_json);


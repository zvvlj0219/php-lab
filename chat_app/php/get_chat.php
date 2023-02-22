<?php

session_start();
include_once('config.php');
include_once(dirname(__FILE__).'/../classes/ChatLogic.php');

if(!isset($_SESSION['unique_id'])){
    header("Location: ../login.php");
}

// postのbodyを取得
$json_string = file_get_contents('php://input');
// 第２引数のtrueはassociate array（連想配列）に変換する
$post_array = json_decode($json_string, true);

$incoming_id = $post_array['incoming_id'];
$outgoing_id = $post_array['outgoing_id'];

$stmt = ChatLogic::getChat($incoming_id, $outgoing_id);
 
foreach($stmt as $row){
    $chat_array[] = $row;
}

if(empty($chat_array)) $chat_array = [];

$res['messages'] = $chat_array;

echo json_encode($res);
exit();

?>
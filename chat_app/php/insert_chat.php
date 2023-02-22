<?php
session_start();
include_once('config.php');

// postのbodyを取得
$json_string = file_get_contents('php://input');
// 第２引数のtrueはassociate array（連想配列）に変換する
$post_array = json_decode($json_string, true);


// セッションがないときはログイン処理に移行
if(!isset($_SESSION['unique_id'])){
    header("Location: ../login.php");
}

$incoming_id = $post_array['incoming_id'];
$outgoing_id = $_SESSION['unique_id'];
$message = $post_array['message'];

$sql = "
    insert into messages 
        (incoming_msg_id, outgoing_msg_id, msg)
    values 
        (:incoming_msg_id, :outgoing_msg_id, :msg)
    ";
    
try{
    $dbh = db_connect();
    $stmt = $dbh->prepare($sql);

    $stmt->bindParam(':incoming_msg_id', $incoming_id);
    $stmt->bindParam(':outgoing_msg_id', $outgoing_id);
    $stmt->bindParam(':msg', $message);
    $stmt->execute();
} catch(PDOException $e){
    http_response_code(500);
    return;
}

exit();

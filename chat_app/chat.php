<?php
// http://localhost/practice-php/php-lab/apps/chat_app

session_start();

require_once("classes/UserLogic.php");
require_once("classes/ChatLogic.php");
require_once('php/config.php');

if(!isset($_SESSION['unique_id'])){
    header("Location: login.php");
}

// URLのパラメータに渡されているidを取得する
$incoming_id = filter_input(INPUT_GET, 'user_id');
$outgoing_id = $_SESSION['unique_id'];

// チャット相手のユーザー情報を所得
$friend = UserLogic::getUserFromId($incoming_id);

// ここでチャットを取得
$stmt = ChatLogic::getChat($incoming_id, $outgoing_id);
foreach($stmt as $row){
    $chat_array[] = $row;
}

if(empty($chat_array)) $chat_array = array();

$param_json = json_encode($chat_array);
$friend_json = json_encode($friend);

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once('./head.php') ?>
<body>
    <div class="wrapper">
        <section class="chat-area">
            <header>
                <a href="users.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
                <img src="./images/<?php echo $friend['img'] ?>" alt="">
                <div class="details">
                    <span><?php echo($friend['lname'].' '.$friend['fname']) ?></span>
                </div>
            </header>

            <div class="chat-box">
                
            </div>

            <form action="#" class="typing-area">
                <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
                <button><i class="fab fa-telegram-plane"></i></button>
            </form>

        </section>
    </div>

<script>
    // このscriptタグないで宣言した変数/定数は下のchat.jsでも参照できる
    const incoming_id = "<?php echo $incoming_id; ?>";
    const outgoing_id = "<?php echo $outgoing_id; ?>";
    // phpからjsにjsonを渡すときは、
    // phpでjson_encodeしたものを
    // jsでJSON.parse()でパースして取得する
    // そのときなぜかシングルクォートじゃないとエラーになる
    const messages_onLoad = JSON.parse('<?php echo $param_json; ?>')
    const friendData = JSON.parse('<?php echo $friend_json; ?>')
    console.log(messages_onLoad)
</script>
<script src="js/chat.js"></script>

</body>
</html>
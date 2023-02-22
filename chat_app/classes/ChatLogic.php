<?php
// import db_connect
require_once(dirname(__FILE__).'/../php/config.php');

class ChatLogic {

    /**
     * Undocumented function
     *
     * @param string $incoming_id
     * @param string $outgoing_id
     * @return $stmt | false
     */
    public static function getChat($incoming_id, $outgoing_id)
    {

        $sql = "select * from messages 
                where (outgoing_msg_id = {$incoming_id} and incoming_msg_id = {$outgoing_id})
                or    (outgoing_msg_id = {$outgoing_id} and incoming_msg_id = {$incoming_id})";

        try{
            $dbh = db_connect();

            $stmt = $dbh->query($sql);
            
            return $stmt;    
        } catch(PDOException $e){
            return false;
        }
    }
}

?>
<?php
class Telegram {

    protected string $token;
    protected string $admin;

    function __construct() {
        $this->token = TG_TOKEN;
        $this->admin = TG_ADMIN;
    }

    function sendMessage($text, $reply_markup = "", $code = false):string {
        if ($code == true) {$text = "<code>$text</code>";}
        return $this->postRequest("sendMessage", $this->token, ["chat_id" => $this->admin, "text" => $text, "reply_markup" => $reply_markup, "parse_mode" => "HTML"]);
    }

    function deleteMessage($chat_id, $message_id):string {
        return $this->postRequest("deleteMessage", $this->token, ["chat_id" => $chat_id, "message_id" => $message_id]);
    }

    private function postRequest($method, $token, $data):string {
        if(strlen(TG_TOKEN) == 0 || strlen(TG_ADMIN) == 0 ) {return "";}
        $ch = curl_init();
        $ch_post = [
            CURLOPT_URL => "https://api.telegram.org/bot$token/$method",
            CURLOPT_POST => TRUE,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_POSTFIELDS => $data
        ];
        curl_setopt_array($ch, $ch_post);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}
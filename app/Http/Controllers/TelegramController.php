<?php

namespace App\Http\Controllers;

class TelegramController extends Controller
{
    private $token;

    public function __construct()
    {
        $this->token = env('TELEGRAM_TOKEN');
    }
    public function index()
    {

        $chat_id = "-651094039";
        $mensagem = urlencode("Mensagem de exemplo!");

        $url = "https://api.telegram.org/bot$this->token/sendMessage?chat_id=$chat_id&text=$mensagem";

        $response = file_get_contents($url);
        $result = json_decode($response, true);

        return response()->json($result);
    }

    public function chats()
    {
        $url = "https://api.telegram.org/bot$this->token/getUpdates";

        $response = file_get_contents($url);
        $result = json_decode($response, true);

        $chats = [];
        foreach ($result["result"] as $update) {
            if (isset($update["message"])) {
                $message = $update["message"];
                $chat_id = $message["chat"]["id"];
                $chat_type = $message["chat"]["type"];
                $chats[] = [$chat_type, $chat_id];
            }
        }

        $chats = array_map("unserialize", array_unique(array_map("serialize", $chats)));

        return response()->json(array_values($chats));
    }
}

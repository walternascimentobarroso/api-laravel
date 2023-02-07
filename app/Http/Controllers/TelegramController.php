<?php

namespace App\Http\Controllers;

class TelegramController extends Controller
{
    private $token;
    private $chatId;
    private $url = "https://api.telegram.org/bot";

    public function __construct()
    {
        $this->token = env('TELEGRAM_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    public function me()
    {
        $url = "$this->url$this->token/getMe";
        $response = file_get_contents($url);
        $result = json_decode($response, true);

        return response()->json($result);
    }

    public function sendMessage()
    {
        $mensagem = urlencode("Mensagem de exemplo!");
        $url = "$this->url$this->token/sendMessage?chat_id=$this->chatId&text=$mensagem";
        $response = file_get_contents($url);
        $result = json_decode($response, true);

        return response()->json($result);
    }

    public function groups()
    {
        $url = "$this->url$this->token/getUpdates";
        $response = file_get_contents($url);
        $response = json_decode($response, true);
        $groups = [];

        foreach ($response['result'] as $update) {
            if (isset($update['message']['chat']['type']) && $update['message']['chat']['type'] === 'group') {
                $groupId = $update['message']['chat']['id'];
                $groupName = $update['message']['chat']['title'];
                $groups[$groupId] = $groupName;
            }
        }

        return response()->json(['ok' => true, 'groups' => $groups]);
    }
}

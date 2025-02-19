<?php

namespace App\Services\Notification\Providers;

use App\Models\User;
use App\Services\Notification\Providers\Contracts\Provider;
use GuzzleHttp\Client;

class TelegramProvider implements Provider
{

    private $user;
    private $text;

    public function __construct(User $user, String $text)
    {
        $this->user = $user;
        $this->text = $text;
    }
    public function send()
    {
        if(is_null($this->user->chat_id)){
            throw new \App\Services\Notification\Exceptions\UserIsNotSubscribeToBot();
        }

        $client = new Client();

        $response = $client->post(config('services.telegram.bot.send_message_uri'),$this->prepareData($this->user, $this->text));
        return $response->getBody();
    }

    private function prepareData() {
        $data = [
            'chat_id' => $this->user->chat_id,
            'text' => $this->text,
        ];
        return [
            'json' => $data,
        ];
    }

}

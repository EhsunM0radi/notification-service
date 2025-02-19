<?php

namespace App\Services\Notification\Providers;

use App\Models\User;
use App\Services\Notification\Exceptions\PushProblem;
use App\Services\Notification\Providers\Contracts\Provider;

class PushProvider implements Provider
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
        $randomNum = rand(1,9);
        if($randomNum == 3){
            throw new PushProblem();
        }
        return true;
    }

}

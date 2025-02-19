<?php

namespace App\Services\Notification;

use App\Services\Notification\Providers\Contracts\Provider;

/**
 * @method sendEmail(App\Models\User $user, Illuminate\Mail\Mailable $mailable)
 * @method sendTelegram(App\Models\User $user, String $text)
 */

class Notification
{
    public function __call($name, $arguments)
    {
        $providerPath = __NAMESPACE__ . '\Providers\\' . substr($name,4) . 'Provider';
        if(!class_exists($providerPath)){
            throw new \Exception('Class does not exist');
        }
        $providerInstance = new $providerPath(...$arguments);
        if(!is_subclass_of($providerInstance, Provider::class)){
            throw new \Exception("Class Must Implements App\Services\Notification\Providers\Contracts\Provider");
        }
        return $providerInstance->send();
    }

}

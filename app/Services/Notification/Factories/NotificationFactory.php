<?php
namespace App\Services\Notification\Factories;

use App\Services\Notification\Providers\Contracts\Provider;
use App\Services\Notification\Providers\EmailProvider;
use App\Services\Notification\Providers\PushProvider;
use App\Services\Notification\Providers\TelegramProvider;

class NotificationFactory {
    public static function create(string $type, array $data): Provider {
        switch (strtolower($type)) {
            case 'email':
                return new EmailProvider(...$data);
            case 'telegram':
                return new TelegramProvider(...$data);
            case 'push':
                return new PushProvider(...$data);
            default:
                throw new \Exception("Notification type '{$type}' is not supported.");
        }
    }
}

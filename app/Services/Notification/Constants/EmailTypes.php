<?php

namespace App\Services\Notification\Constants;

use App\Mail\Invoice;
use App\Mail\WarningMessage;
use App\Mail\WelcomeMessage;

class EmailTypes
{
    const WARNING_MESSAGE = 1;
    const WELCOME_MESSAGE = 2;
    const INVOICE = 3;

    public static function toString()
    {
        return [
            self::WARNING_MESSAGE => 'پیام اخطار',
            self::WELCOME_MESSAGE => 'پیام خوش آمد گویی',
            self::INVOICE => 'فاکتور',
        ];
    }

    public static function toMail($type)
    {
        try{
            return [
                self::WARNING_MESSAGE => WarningMessage::class,
                self::WELCOME_MESSAGE => WelcomeMessage::class,
                self::INVOICE => Invoice::class,
            ][$type];
        } catch (\Throwable $th) {
            throw new \InvalidArgumentException('Mailable class does not exists.' );
        }
    }
}

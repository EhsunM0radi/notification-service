<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Notification\Constants\EmailTypes;
use App\Services\Notification\Exceptions\UserIsNotSubscribeToBot;
use App\Services\Notification\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function email()
    {
        $users = User::all();
        $email_types = EmailTypes::toString();
        return view('notifications.send-email',compact('users','email_types'));
    }

    public function telegram()
    {
        $users = User::all();

        return view('notifications.send-telegram',compact('users'));
    }

    public function push()
    {
        $users = User::all();

        return view('notifications.send-push',compact('users'));
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'user' => 'integer | exists:users,id',
            'email_type' => 'integer'
        ]);

        try {
            $notification = resolve(Notification::class);
            $mailable = EmailTypes::toMail($request->email_type);
            $notification->sendEmail(User::find($request->user),new $mailable);
            return redirect()->back()->with('success',__('notification.email_sent_successfully'));
        } catch(\Throwable $th) {
            return redirect()->back()->with('failed',__('notification.email_has_failed'));
        }
    }

    public function sendTelegram(Request $request, Notification $notification)
    {
        $request->validate([
            'user' => 'integer | exists:users,id',
            'message'=> 'string | max:256',
        ]);

        try {
            $notification->sendTelegram(User::find($request->user), $request->message);
            return $this->redirectBack('success', __('notification.message_sent_successfully'));
        } catch(UserIsNotSubscribeToBot $e) {
            return $this->redirectBack('failed', __('notification.user_is_not_subscribed_to_the_bot'));
        } catch(\Exception $e) {
            return $this->redirectBack('failed', __('notification.telegram_service_has_a_problem'));
        }
    }

    public function sendPush(Request $request, Notification $notification)
    {
        $request->validate([
            'user' => 'integer | exists:users,id',
            'message'=> 'string | max:256',
        ]);

        try {
            $notification->sendPush(User::find($request->user), $request->message);
            return $this->redirectBack('success', __('notification.message_sent_successfully'));
        } catch(\Exception $e) {
            return $this->redirectBack('failed', __('notification.push_service_has_a_problem'));
        }
    }

    private function redirectBack(String $type, String $text) {
        return redirect()->back()->with($type, $text);
    }

}

<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Mail\Invoice;
use App\Mail\WarningMessage;
use App\Mail\WelcomeMessage;
use App\Models\User;
use App\Services\Notification\Notification;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // $notification = new Notification;
    // $notification->sendEmail(User::find(1),new WelcomeMessage);
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function() {
    Route::get('/notifications/send-email',[NotificationController::class,'email'])->name('notification.form.email');
    Route::get('/notifications/send-telegram',[NotificationController::class,'telegram'])->name('notification.form.telegram');
    Route::get('/notifications/send-push',[NotificationController::class,'push'])->name('notification.form.push');
    Route::post('/notifications/send-email',[NotificationController::class,'sendEmail'])->name('notification.send.email');
    Route::post('/notifications/send-telegram',[NotificationController::class,'sendTelegram'])->name('notification.send.telegram');
    Route::post('/notifications/send-push',[NotificationController::class,'sendPush'])->name('notification.send.push');
});

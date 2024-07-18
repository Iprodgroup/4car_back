<?php

namespace App\Http\Services;

use App\Models\Feedback;
use Illuminate\Support\Facades\Http;

class FeedbackService
{
    public function sendDataToTelegram(Feedback $feedback): void
    {
        $token = env('TELEGRAM_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
        $message = "Новое сообщение обратной связи:\n\nИмя: {$feedback->name}\nНомер: {$feedback->number}";

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);

    }
}

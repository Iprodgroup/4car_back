<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackRequest;
use App\Http\Services\FeedbackService;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FeedbackController extends Controller
{
    public function store(FeedbackRequest $request)
    {
        $feedback = Feedback::create($request->all());
        $this->sendToTelegram($feedback);
        return $this->success('Ваш запрос успешно сохранен.Свяжемся с вами');
    }


    public function sendToTelegram(Feedback $feedback)
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

<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\FeedbackRequest;

class FeedbackController extends Controller
{
    public function store(FeedbackRequest $request)
    {
        $feedback = Feedback::create($request->all());
        $this->sendToTelegram($feedback);
        return $this->success('Ваш запрос успешно сохранен.Свяжемся с вами');
    }


    public function sendToTelegramWithoutEmail(Feedback $feedback)
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

    public function sendToTelegramWithEmail($name, $email, $text)
    {
        $token = env('TELEGRAM_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
        $message = "Новое сообщение обратной связи:\n\nИмя: {$name}\nEmail: {$email}\nВаше сообщение: {$text} ";

        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
        ]);
    }
    public function send(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $text = $request->input('text');
        return $this->sendToTelegramWithEmail($name, $email, $text);
    }
}

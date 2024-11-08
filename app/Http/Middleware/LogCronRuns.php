<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\TelegramNotificationService;

class LogCronRuns
{
    protected $telegramService;

    public function __construct(TelegramNotificationService $telegramService)
    {
        $this->telegramService = $telegramService;
    }

    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);

        Log::info('Cron job started', [
            'ip' => $request->ip(),
            'url' => $request->fullUrl(),
            'method' => $request->method()
        ]);

        $response = $next($request);

        $duration = microtime(true) - $startTime;

        $message = "🤖 Cron Job Executed:\n";
        $message .= "🕒 Timestamp: " . now() . "\n";
        $message .= "⏱️ Duration: " . round($duration, 2) . " seconds\n";
        $message .= "🌐 IP: " . $request->ip();

        $this->telegramService->sendMessage($message);

        return $response;
    }
}

<?php

namespace App\Modules\Tasks\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\Tasks\Events\TaskCompletedEvent;
use Illuminate\Events\Attributes\AsListener;

// #[AsListener(TaskCompletedEvent::class)]
class SendTaskCompletedWebhookListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskCompletedEvent $event): void
    {
        $task = $event->task;

        $payload = [
            'user_id' => $task->user_id,
            'task_id' => $task->id,
            'message' => "Task '{$task->title}' completed",
            'timestamp' => now()->toISOString(),
        ];

        $url = config('services.webhook.url');
        $secret = config('services.webhook.secret');

        $signature = hash_hmac('sha256', json_encode($payload), $secret);

        try {
            $response = Http::withHeaders([
                'X-Signature' => "sha256={$signature}",
                'Content-Type' => 'application/json',
            ])->post($url, $payload);

            Log::info('Task completed webhook sent', [
                'task_id' => $task->id,
                'response_status' => $response->status(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Failed to send task completed webhook', [
                'task_id' => $task->id,
                'error' => $e->getMessage(),
            ]);
        }
    }
}

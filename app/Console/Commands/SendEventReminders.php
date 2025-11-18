<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Models\EventNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for upcoming events to participants';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get events starting in the next 24 hours
        $upcomingEvents = Event::with('participants')
            ->where('start_time', '>', now())
            ->where('start_time', '<=', now()->addDay())
            ->get();

        $notificationsSent = 0;

        foreach ($upcomingEvents as $event) {
            // Get participants who are going or interested
            $participants = $event->participants()
                ->wherePivotIn('status', ['going', 'interested'])
                ->get();

            foreach ($participants as $participant) {
                // Check if reminder already sent
                $existingNotification = EventNotification::where('event_id', $event->id)
                    ->where('user_id', $participant->uid)
                    ->where('type', 'event_reminder')
                    ->where('created_at', '>=', now()->subDay())
                    ->first();

                if (!$existingNotification) {
                    $timeUntilEvent = now()->diffInHours($event->start_time);
                    
                    if ($timeUntilEvent < 24) {
                        $message = 'Sự kiện "' . $event->title . '" sẽ bắt đầu vào ' . $event->start_time->format('H:i, d/m/Y');
                        
                        EventNotification::create([
                            'event_id' => $event->id,
                            'user_id' => $participant->uid,
                            'type' => 'event_reminder',
                            'message' => $message,
                        ]);

                        $notificationsSent++;
                    }
                }
            }
        }

        $this->info("Sent {$notificationsSent} event reminders.");
        return 0;
    }
}

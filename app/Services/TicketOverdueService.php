<?php

namespace App\Services;

use App\Models\Tickets;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendOverdueTicketWhatsapp;

class TicketOverdueService
{
    public function markOverdue(): int
    {
        $now   = Carbon::now();
        $count = 0;

        Tickets::where('status', 'Progress')           
            ->whereNotNull('estimation_to')            
            ->where('estimation_to', '<', $now)        
            ->chunk(100, function ($tickets) use ($now, &$count) {

                foreach ($tickets as $ticket) {
                    $oldStatus = $ticket->status;

                    // Update status menjadi Overdue
                    $ticket->update([
                        'status' => 'Overdue',
                    ]);

                    // Kirim notifikasi WhatsApp via Queue
                    SendOverdueTicketWhatsapp::dispatch($ticket->id)
                        ->onQueue('whatsappoverdue');

                    // Log per ticket untuk audit trail
                    Log::info('TICKET_MARKED_OVERDUE', [
                        'ticket_id'     => $ticket->id,
                        'priority'      => $ticket->priority,
                        'old_status'    => $oldStatus,
                        'estimation_to' => $ticket->estimation_to->toDateTimeString(),
                        'now'           => $now->toDateTimeString(),
                    ]);

                    $count++;
                }
            });

        return $count;
    }
}
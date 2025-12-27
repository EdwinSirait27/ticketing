<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Tickets;
use Illuminate\Support\Facades\Log;
use App\Models\Ticketattachments;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Services\NextcloudService;
use PHPUnit\Framework\Attributes\Ticket;
use Yajra\DataTables\Facades\DataTables;


class TicketController extends Controller
{
    public function openTicket()
    {
        return view('pages.openticket');
    }
    public function allTickets()
    {
        
$todaysticket = Tickets::whereDate('created_at', Carbon::today())->count(); 
$onprogressticket = Tickets::where('status', 'Progress')
    ->count();
        return view('pages.alltickets',compact('todaysticket','onprogressticket'));
    }
//        public function getAlltickets(Request $request)
// {
//     $query = Tickets::select([
//             'id',
//             'user_id',
//             'queue_number',
//             'title',
//             'category',
//             'status',
//     ])->with('user.employee');
  

//     return DataTables::eloquent($query)
//         ->addColumn('employee_name', function ($tickets) {
//             return optional($tickets->user->employee)->employee_name ?? 'Empty';
//         })
       
//         ->addColumn('action', function ($user) {
//             $idHashed = substr(hash('sha256', $user->id . env('APP_KEY')), 0, 8);
//             return '
//                 <a href="' . route('editusers', $idHashed) . '" 
//                    data-bs-toggle="tooltip" 
//                    title="Edit User: ' . e($user->username) . '">
//                     <i class="fas fa-user-edit text-secondary"></i>
//                 </a>';
//         })
//         ->rawColumns(['action'])
//         ->make(true);
// }
public function getAlltickets(Request $request)
{
    $query = Tickets::with('user.employee')
        ->select([
            'id',
            'user_id',
            'queue_number',
            'title',
            'category',
            'status',
        ]);

    return DataTables::eloquent($query)
        ->addColumn('employee_name', function ($ticket) {
            return optional($ticket->user?->employee)->employee_name ?? '-';
        })
        ->orderColumn('employee_name', function ($query, $order) {
            // disable ordering (WAJIB)
        })
                ->addColumn('action', function ($user) {
            $idHashed = substr(hash('sha256', $user->id . env('APP_KEY')), 0, 8);
            return '
                <a href="' . route('editusers', $idHashed) . '" 
                   data-bs-toggle="tooltip" 
                   title="Edit User: ' . e($user->username) . '">
                    <i class="fas fa-user-edit text-secondary"></i>
                </a>';
        })
                ->rawColumns(['action'])

        ->make(true);
}

// public function store(Request $request)
// {
//     Log::info('Ticket store request masuk', [
//         'user_id' => auth()->id(),
//         'ip'      => $request->ip(),
//     ]);

//     $validated = $request->validate([
//         'request_uuid'  => 'required|uuid|unique:ticket_tables,request_uuid',
//         'title'         => 'required|string|min:5|max:150',
//         'category'      => 'required|string',
//         'description'   => 'required|string|min:5|max:500',
//         'attachments'   => 'nullable|array|min:1|max:3',
//         'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
//     ]);

//     try {
//         DB::transaction(function () use ($request, $validated, &$ticket) {

//             $queueNumber = Tickets::whereDate('created_at', Carbon::today())
//                 ->lockForUpdate()
//                 ->count() + 1;

//             $ticket = Tickets::create([
//                 'id'           => (string) Str::uuid(),
//                 'request_uuid' => $validated['request_uuid'],
//                 'user_id'      => auth()->id(),
//                 'queue_number' => $queueNumber,
//                 'title'        => $validated['title'],
//                 'category'     => $validated['category'],
//                 'description'  => $validated['description'],
//                 'status'       => 'Open',
//             ]);

//             // ==============================
//             // 📎 NEXTCLOUD ATTACHMENTS
//             // ==============================
//             Log::info('HAS FILE CHECK', [
//     'hasFile' => $request->hasFile('attachments'),
//     'files'   => $request->file('attachments'),
// ]);

//             if ($request->hasFile('attachments')) {

//                 $categoryFolder = Str::slug($ticket->category);
//                 $userFolder     = Str::slug(auth()->user()->username);
//                 $ticketFolder   = $ticket->id;

//                 $basePath = "ticket/{$categoryFolder}/{$userFolder}/{$ticketFolder}";

//                 // pastikan folder ada
//                 NextcloudService::makeDir('ticket');
//                 NextcloudService::makeDir("ticket/{$categoryFolder}");
//                 NextcloudService::makeDir("ticket/{$categoryFolder}/{$userFolder}");
//                 NextcloudService::makeDir($basePath);

//                 foreach ($request->file('attachments') as $file) {
//                     $filename = time() . '_' . $file->getClientOriginalName();

//                     NextcloudService::upload(
//                         $basePath,
//                         $filename,
//                         file_get_contents($file->getRealPath()),
//                         $file->getMimeType()
//                     );

//                     Ticketattachments::create([
//                         'id'        => (string) Str::uuid(),
//                         'ticket_id' => $ticket->id,
//                         'file_name' => $filename,
//                         'file_path' => "{$basePath}/{$filename}",
//                     ]);
//                 }

//                 // 🔗 SHARE FOLDER (INI YANG PENTING)
//                 $shareUrl = NextcloudService::shareFolder($basePath);
//                 Log::info('NEXTCLOUD SHARE CREATED', [
//     'url' => $shareUrl,
// ]);


//                 $ticket->update([
//                     'attachment_folder' => $basePath,
//                     'attachment_url'    => $shareUrl,
//                 ]);
//             }
//         });
//         $ticket->refresh();

//         // ==============================
//         // 📲 WHATSAPP NOTIFICATION
//         // ==============================
//         $attachmentText = '';
//         if (!empty($ticket->attachment_url)) {
//             $attachmentText =
//                 "\n Attachments:\n" .
//                 $ticket->attachment_url;
//         }

//         try {
//             Http::timeout(15)->post('http://127.0.0.1:3000/send-message', [
//                 'group_id' => '120363405189832865@g.us',
//                 'text' =>
//                     "*New Ticket*\n" .
//                     "Queue: {$ticket->queue_number}\n" .
//                     "Date: " . $ticket->created_at
//                         ->timezone('Asia/Makassar')
//                         ->format('d-m-Y H:i') . "\n" .
//                     "Title: {$ticket->title}\n" .
//                     "Category: {$ticket->category}\n" .
//                     "Description: {$ticket->description}\n" .
//                     "User: " . (
//                         auth()->user()->employee->employee_name
//                         ?? auth()->user()->employee->store->name
//                     ) .
//                     $attachmentText,
//             ]);
//             Log::info('WA MESSAGE FINAL', [
//     'attachment_url' => $ticket->attachment_url
// ]);

//         } catch (\Throwable $e) {
//             Log::warning('Gagal kirim WA notification', [
//                 'error' => $e->getMessage(),
//             ]);
//         }

//         return redirect()
//             ->route('openticket')
//             ->with('success', 'Ticket successfully submitted');

//     } catch (\Throwable $e) {
//         Log::error('failed to submitted ticket', [
//             'message' => $e->getMessage(),
//             'user_id' => auth()->id(),
//         ]);

//         return redirect()
//             ->route('openticket')
//             ->with('error', 'Ticket failed to submitted');
//     }
// }


public function store(Request $request)
{
    Log::info('TICKET REQUEST START', [
        'user_id'        => auth()->id(),
        'ip'             => $request->ip(),
        'content_length' => $request->server('CONTENT_LENGTH'),
    ]);

    // 🛑 Guard khusus Swoole
    if (
        $request->isMethod('post') &&
        is_null($request->server('CONTENT_LENGTH'))
    ) {
        Log::error('EMPTY REQUEST BODY - SWOOLE GUARD');
        return back()->withErrors([
            'attachments' => 'Upload gagal, silakan ulangi',
        ]);
    }

    $validated = $request->validate([
        'request_uuid'  => 'required|uuid|unique:ticket_tables,request_uuid',
        'title'         => 'required|string|min:5|max:150',
        'category'      => 'required|string',
        'description'   => 'required|string|min:5|max:500',
        'attachments'   => 'nullable|array|min:1|max:3',
        'attachments.*' => 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
    ]);

    $ticket = null;

    try {
        // ==============================
        // 🎫 DB TRANSACTION (ONLY DB)
        // ==============================
        DB::beginTransaction();
        Log::info('DB TRANSACTION START');

        $queueNumber = Tickets::whereDate('created_at', Carbon::today())
            ->lockForUpdate()
            ->count() + 1;

        $ticket = Tickets::create([
            'id'           => (string) Str::uuid(),
            'request_uuid' => $validated['request_uuid'],
            'user_id'      => auth()->id(),
            'queue_number' => $queueNumber,
            'title'        => $validated['title'],
            'category'     => $validated['category'],
            'description'  => $validated['description'],
            'status'       => 'Open',
        ]);

        Log::info('TICKET CREATED', [
            'ticket_id' => $ticket->id,
            'queue'     => $queueNumber,
        ]);

        DB::commit();
        Log::info('DB TRANSACTION COMMIT', [
            'ticket_id' => $ticket->id,
        ]);

    } catch (\Throwable $e) {
        DB::rollBack();

        Log::error('TICKET STORE FAILED', [
            'error'   => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('openticket')
            ->with('error', 'Ticket failed to submitted');
    }

    // ==============================
    // 📎 ATTACHMENTS (OUTSIDE DB)
    // ==============================
    $this->handleAttachments($request, $ticket);

    // ==============================
    // 📲 WHATSAPP
    // ==============================
    $this->sendWhatsappNotification($ticket);

    return redirect()
        ->route('openticket')
        ->with('success', 'Ticket successfully submitted');
}

private function handleAttachments(Request $request, Tickets $ticket): void
{
    if (! $request->hasFile('attachments')) {
        Log::info('NO ATTACHMENTS UPLOADED');
        return;
    }

    $files = $request->file('attachments');

    Log::info('ATTACHMENT START', [
        'count'      => count($files),
        'total_size' => collect($files)->sum(fn ($f) => $f->getSize()),
    ]);

    $categoryFolder = Str::slug($ticket->category);
    $userFolder     = Str::slug(auth()->user()->username);
    $basePath       = "ticket/{$categoryFolder}/{$userFolder}/{$ticket->id}";

    foreach ([
        'ticket',
        "ticket/{$categoryFolder}",
        "ticket/{$categoryFolder}/{$userFolder}",
        $basePath,
    ] as $dir) {
        NextcloudService::makeDir($dir);
    }

    foreach ($files as $index => $file) {

        Log::info('UPLOADING FILE', [
            'index' => $index,
            'name'  => $file->getClientOriginalName(),
            'size'  => $file->getSize(),
            'mime'  => $file->getMimeType(),
        ]);

        $filename = time() . '_' . $file->getClientOriginalName();

        // ✅ SWOOLE SAFE FLOW
        $tmpPath = $file->store('tmp-uploads');
        $stream  = Storage::readStream($tmpPath);

        NextcloudService::upload(
            $basePath,
            $filename,
            $stream,
            $file->getMimeType()
        );

        if (is_resource($stream)) {
            fclose($stream);
        }

        Storage::delete($tmpPath);

        Ticketattachments::create([
            'id'        => (string) Str::uuid(),
            'ticket_id' => $ticket->id,
            'file_name' => $filename,
            'file_path' => "{$basePath}/{$filename}",
        ]);
    }

    $shareUrl = NextcloudService::shareFolder($basePath);

    Log::info('NEXTCLOUD SHARE CREATED', [
        'url' => $shareUrl,
    ]);

    $ticket->update([
        'attachment_folder' => $basePath,
        'attachment_url'    => $shareUrl,
    ]);
}

private function sendWhatsappNotification(Tickets $ticket): void
{
    try {
        $attachmentText = $ticket->attachment_url
            ? "\nAttachments:\n{$ticket->attachment_url}"
            : '';

        $response = Http::timeout(15)->post('http://127.0.0.1:3000/send-message', [
            'group_id' => '120363405189832865@g.us',
            'text' =>
                "*New Ticket*\n" .
                "Queue: {$ticket->queue_number}\n" .
                "Date: " . $ticket->created_at
                    ->timezone('Asia/Makassar')
                    ->format('d-m-Y H:i') . "\n" .
                "Title: {$ticket->title}\n" .
                "Category: {$ticket->category}\n" .
                "Description: {$ticket->description}\n" .
                "User: " . (
                    auth()->user()->employee->employee_name
                    ?? auth()->user()->employee->store->name
                ) .
                $attachmentText,
        ]);

        Log::info('WA SENT', [
            'status' => $response->status(),
            'body'   => $response->body(),
        ]);

    } catch (\Throwable $e) {
        Log::warning('WA FAILED', [
            'error' => $e->getMessage(),
        ]);
    }
}

}

// public function store(Request $request)
// {
//     Log::info('Ticket store request masuk', [
//         'user_id' => auth()->id(),
//         'ip'      => $request->ip(),
//     ]);

//     $validated = $request->validate([
//         'request_uuid' => 'required|uuid|unique:ticket_tables,request_uuid',
//         'title'        => 'required|string|min:5|max:150',
//         'category'     => 'required|string',
//         'description'  => 'required|string|min:5|max:500',
//         'attachments'  => 'nullable|array|min:1|max:3',
//         'attachments.*'=> 'file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
//     ]);

//     try {
//         DB::transaction(function () use ($request, $validated, &$ticket) {

//             // 🔢 Hitung antrian HARI INI (AMAN)
//             $queueNumber = Tickets::whereDate('created_at', Carbon::today())
//                 ->lockForUpdate()
//                 ->count() + 1;

//             $ticket = Tickets::create([
//                 'id'           => (string) Str::uuid(),
//                 'request_uuid' => $validated['request_uuid'],
//                 'user_id'      => auth()->id(),
//                 'queue_number' => $queueNumber,
//                 'title'        => $validated['title'],
//                 'category'     => $validated['category'],
//                 'description'  => $validated['description'],
//                 'status'       => 'Open',
//             ]);

//             // if ($request->hasFile('attachments')) {
//             //     foreach ($request->file('attachments') as $file) {
//             //         $path = $file->store("tickets/{$ticket->id}", 'public');

//             //         Ticketattachments::create([
//             //             'id'        => (string) Str::uuid(),
//             //             'ticket_id'=> $ticket->id,
//             //             'file_name'=> $file->getClientOriginalName(),
//             //             'file_path'=> $path,
//             //         ]);
//             //     }
//             // }
//             if ($request->hasFile('attachments')) {

//     $categoryFolder = Str::slug($ticket->category);
//     $basePath = "ticket/{$categoryFolder}/{$ticket->id}";

//     // 📁 Pastikan folder ada
//     NextcloudService::makeDir("ticket");
//     NextcloudService::makeDir("ticket/{$categoryFolder}");
//     NextcloudService::makeDir($basePath);

//     foreach ($request->file('attachments') as $file) {

//         $filename = time() . '_' . $file->getClientOriginalName();

//         NextcloudService::upload(
//             $basePath,
//             $filename,
//             file_get_contents($file->getRealPath()),
//             $file->getMimeType()
//         );

//         Ticketattachments::create([
//             'id'        => (string) Str::uuid(),
//             'ticket_id' => $ticket->id,
//             'file_name' => $filename,
//             'file_path' => "{$basePath}/{$filename}",
//         ]);
//     }
// }

//         });
//         // 🔔 Kirim WA (DI LUAR TRANSACTION)
//         try {
//             Http::timeout(5)->post('http://127.0.0.1:3000/send-message', [
//                 'group_id' => '120363405189832865@g.us',
//                 'text' =>
//                     "*New Ticket*\n" .
//                     "Queue: {$ticket->queue_number}\n" .
//                     "Date: " . $ticket->created_at
//                         ->timezone('Asia/Jakarta')
//                         ->format('d-m-Y H:i') . "\n" .
//                     "Title: {$ticket->title}\n" .
//                     "Category: {$ticket->category}\n" .
//                     "Description: {$ticket->description}\n" .
//                     "User: " . (
//                         auth()->user()->employee->employee_name
//                         ?? auth()->user()->employee->store->name
//                         ) . 
//                         "Attachment: $attachmentText"
                    
            
//             ]);
//         } catch (\Throwable $e) {
//             Log::warning('Gagal kirim WA notification', [
//                 'error' => $e->getMessage(),
//             ]);
//         }

//         return redirect()
//             ->route('openticket')
//             ->with('success', 'Ticket successfully submitted');

//     } catch (\Throwable $e) {
//         Log::error('failed to submitted ticket', [
//             'message' => $e->getMessage(),
//             'user_id' => auth()->id(),
//         ]);

//         return redirect()
//             ->route('openticket')
//             ->with('error', 'Ticket failed to submitted');
//     }
// }
{{-- @extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="p-4 space-y-4">

    <div class="grid grid-cols-3 gap-3">
        <div class="bg-red-100 text-red-600 p-3 rounded-lg text-center">
            <p class="text-sm">Open</p>
            <p class="text-xl font-bold">3</p>
        </div>

        <div class="bg-yellow-100 text-yellow-600 p-3 rounded-lg text-center">
            <p class="text-sm">Progress</p>
            <p class="text-xl font-bold">2</p>
        </div>

        <div class="bg-green-100 text-green-600 p-3 rounded-lg text-center">
            <p class="text-sm">Closed</p>
            <p class="text-xl font-bold">8</p>
        </div>
    </div>

    <a href="#"
       class="block bg-blue-600 text-white text-center py-3 rounded-lg font-semibold">
        + Buat Ticket
    </a>

</div>
@endsection --}}
@extends('layouts.app')

@section('title', 'Dashboard')

@section('header', 'Dashboard')

@section('content')
<div class="p-4 space-y-4">

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Example: expects $stats = ['open'=>x, 'in_progress'=>y, 'closed'=>z, 'overdue'=>w] --}}
        <div class="bg-white/5 backdrop-blur-sm p-4 rounded-lg shadow-sm flex flex-col">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-300">Open</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['open'] ?? 0 }}</p>
                </div>
                <div class="text-sm text-slate-400">▸ {{ $stats['open_change'] ?? '+0' }}</div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Tiket yang belum ditangani</p>
        </div>

        <div class="bg-white/5 backdrop-blur-sm p-4 rounded-lg shadow-sm flex flex-col">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-300">In Progress</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['in_progress'] ?? 0 }}</p>
                </div>
                <div class="text-sm text-slate-400">▸ {{ $stats['in_progress_change'] ?? '+0' }}</div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Sedang dikerjakan oleh tim</p>
        </div>

        <div class="bg-white/5 backdrop-blur-sm p-4 rounded-lg shadow-sm flex flex-col">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-300">Closed</p>
                    <p class="text-2xl font-bold text-white">{{ $stats['closed'] ?? 0 }}</p>
                </div>
                <div class="text-sm text-slate-400">▸ {{ $stats['closed_change'] ?? '+0' }}</div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Tiket terselesaikan</p>
        </div>

        <div class="bg-white/5 backdrop-blur-sm p-4 rounded-lg shadow-sm flex flex-col">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-300">Overdue</p>
                    <p class="text-2xl font-bold text-rose-400">{{ $stats['overdue'] ?? 0 }}</p>
                </div>
                <div class="text-sm text-slate-400">▸ {{ $stats['overdue_change'] ?? '+0' }}</div>
            </div>
            <p class="mt-3 text-xs text-slate-400">Tiket melewati SLA</p>
        </div>
    </div>

    {{-- QUICK ACTIONS + FILTERS --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            <a href="#" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow">
            {{-- <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold shadow"> --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg>
                Buat Ticket
            </a>

            <a href="#" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-lg font-medium shadow-sm">
            {{-- <a href="{{ route('tickets.import') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-lg font-medium shadow-sm"> --}}
                Import CSV
            </a>

        </div>

        <div class="flex items-center gap-2">
            {{-- Quick filter chips (expects $quickFilters array) --}}
            @foreach($quickFilters ?? ['All','Open','In Progress','Overdue','My Tickets'] as $filter)
                <a href="#" class="px-3 py-1 rounded-full text-sm bg-white/5 hover:bg-white/10 text-slate-200">{{ $filter }}</a>
                {{-- <a href="{{ route('tickets.index', ['filter' => Str::lower($filter)]) }}" class="px-3 py-1 rounded-full text-sm bg-white/5 hover:bg-white/10 text-slate-200">{{ $filter }}</a> --}}
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- LEFT: Recent Tickets --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white/3 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-3">Recent Tickets</h3>

                {{-- Table responsive --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="text-slate-300/80 text-left">
                            <tr>
                                <th class="px-3 py-2">#</th>
                                <th class="px-3 py-2">Title</th>
                                <th class="px-3 py-2">Priority</th>
                                <th class="px-3 py-2">Status</th>
                                <th class="px-3 py-2">Assigned</th>
                                <th class="px-3 py-2">Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentTickets ?? [] as $ticket)
                                <tr class="border-t border-white/5 hover:bg-white/2">
                                    <td class="px-3 py-2">#{{ $ticket->id }}</td>
                                    <td class="px-3 py-2"><a href="{{ route('tickets.show', $ticket->id) }}" class="font-medium hover:underline">{{ Str::limit($ticket->title, 50) }}</a></td>
                                    <td class="px-3 py-2">{{ ucfirst($ticket->priority) }}</td>
                                    <td class="px-3 py-2">{{ ucfirst($ticket->status) }}</td>
                                    <td class="px-3 py-2">{{ $ticket->assigned_to?->name ?? '-' }}</td>
                                    <td class="px-3 py-2">{{ $ticket->updated_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-3 py-4 text-slate-400">Tidak ada tiket terbaru.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 text-right">
                    <a href="#" class="text-sm text-slate-300 hover:underline">Lihat semua tiket &rarr;</a>
                    {{-- <a href="{{ route('tickets.index') }}" class="text-sm text-slate-300 hover:underline">Lihat semua tiket &rarr;</a> --}}
                </div>
            </div>

            {{-- Activity / Timeline --}}
            <div class="bg-white/3 p-4 rounded-lg shadow-sm">
                <h3 class="text-lg font-semibold text-white mb-3">Activity</h3>
                <ul class="space-y-3 text-sm text-slate-300">
                    @foreach($activities ?? [] as $act)
                        <li class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full mt-2 bg-slate-400"></div>
                            <div>
                                <div class="text-slate-100">{{ $act['title'] }}</div>
                                <div class="text-xs text-slate-400">{{ $act['time'] }}</div>
                            </div>
                        </li>
                    @endforeach
                    @if(empty($activities))
                        <li class="text-slate-400">Tidak ada aktivitas.</li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- RIGHT: Announcements + Small Stats --}}
        <div class="space-y-4">
            <div class="bg-white/3 p-4 rounded-lg shadow-sm">
                <h4 class="font-semibold text-white">Announcements</h4>
                <div class="mt-3 text-sm text-slate-300 space-y-2">
                    @forelse($announcements ?? [] as $ann)
                        <div class="p-2 rounded-md bg-white/2">
                            <div class="font-medium">{{ $ann->title }}</div>
                            <div class="text-xs text-slate-400">{{ $ann->created_at->format('d M Y H:i') }}</div>
                        </div>
                    @empty
                        <div class="text-slate-400">Tidak ada pengumuman.</div>
                    @endforelse
                </div>
            </div>

            <div class="bg-white/3 p-4 rounded-lg shadow-sm">
                <h4 class="font-semibold text-white">SLA Compliance</h4>
                <div class="mt-3">
                    {{-- simple progress bar --}}
                    <div class="w-full bg-white/5 rounded-full h-3 overflow-hidden">
                        <div class="h-3 rounded-full" style="width: {{ $slaCompliance ?? 0 }}%; background: linear-gradient(90deg,#06b6d4,#3b82f6);"></div>
                    </div>
                    <div class="mt-2 text-sm text-slate-300">{{ $slaCompliance ?? 0 }}% memenuhi SLA</div>
                </div>
            </div>

            <div class="bg-white/3 p-4 rounded-lg shadow-sm">
                <h4 class="font-semibold text-white">Quick Stats</h4>
                <div class="mt-3 grid grid-cols-2 gap-2 text-sm text-slate-300">
                    <div>
                        <div class="text-xs">Assigned to Me</div>
                        <div class="font-medium text-white">{{ $stats['assigned_to_me'] ?? 0 }}</div>
                    </div>
                    <div>
                        <div class="text-xs">New Today</div>
                        <div class="font-medium text-white">{{ $stats['today'] ?? 0 }}</div>
                    </div>
                    <div>
                        <div class="text-xs">High Priority</div>
                        <div class="font-medium text-white">{{ $stats['high'] ?? 0 }}</div>
                    </div>
                    <div>
                        <div class="text-xs">Waiting Customer</div>
                        <div class="font-medium text-white">{{ $stats['waiting_customer'] ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

 {{-- Floating action button for mobile --}}
{{-- <a href="#" class="fixed right-4 bottom-6 sm:bottom-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg flex items-center justify-center md:hidden"> --}}
{{-- <a href="{{ route('tickets.create') }}" class="fixed right-4 bottom-6 sm:bottom-10 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg flex items-center justify-center md:hidden"> --}}
    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/></svg> --}}
{{-- </a> --}}

@endsection

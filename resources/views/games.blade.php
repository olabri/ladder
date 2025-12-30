<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Ladderen • Follese Brettspillklubb</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-b from-slate-100 via-white to-slate-50 text-slate-900">
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col gap-10 px-4 py-20">
            <header class="mx-auto flex w-full max-w-5xl flex-col gap-4 rounded-3xl border border-slate-200 bg-white p-8 text-left shadow-lg backdrop-blur-sm md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.7em] text-slate-400">Follese Brettspillklubb</p>
                    <h1 class="text-3xl font-semibold text-slate-900 md:text-4xl">Ladderen</h1>
                    <p class="text-sm text-slate-500">
                        Rangeringen bygger på hver gameplay, med poeng etter kompleksiteten. Nå ser du hvem som leder og hvilke spill som nylig ble spilt.
                    </p>
                </div>
                <div class="flex gap-3 text-xs uppercase tracking-[0.4em]">
                    <a href="{{ route('home') }}" class="rounded-full border border-white/25 px-4 py-2 text-slate-100 transition hover:border-white/40 hover:text-white">
                        Til forsiden
                    </a>
                    <a href="#games-played" class="rounded-full border border-slate-500/40 px-4 py-2 text-slate-200 transition hover:border-slate-300 hover:text-white">
                        Se spill
                    </a>
                </div>
            </header>

            <section class="space-y-4">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-[0.5em] text-slate-500">Ladder</p>
                            <h2 class="text-2xl font-semibold text-slate-900">De høyest rangerte</h2>
                        </div>
                        <span class="text-xs font-semibold uppercase tracking-[0.3em] text-amber-500">Poeng</span>
                    </div>
                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full table-fixed text-sm">
                            <thead>
                                <tr class="bg-slate-50">
                                    <th class="px-4 py-3 text-left text-xs uppercase tracking-[0.3em] text-slate-500">Rank</th>
                                    <th class="px-4 py-3 text-left text-xs uppercase tracking-[0.3em] text-slate-500">Navn</th>
                                    <th class="px-4 py-3 text-left text-xs uppercase tracking-[0.3em] text-slate-500">E-post</th>
                                    <th class="px-4 py-3 text-right text-xs uppercase tracking-[0.3em] text-amber-500">Poeng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rankings as $index => $entry)
                                    <tr class="{{ $index % 2 === 0 ? 'bg-white' : 'bg-slate-50' }}">
                                        <td class="px-4 py-3 font-semibold text-slate-500">#{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-semibold text-slate-900">{{ $entry['user']->name }}</td>
                                        <td class="px-4 py-3 text-slate-600">{{ $entry['user']->email }}</td>
                                        <td class="px-4 py-3 text-right font-semibold text-amber-500">{{ number_format($entry['points']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-slate-500">Ingen poeng registrert enda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="games-played" class="space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs uppercase tracking-[0.5em] text-slate-400">Gameplays</p>
                        <h2 class="text-2xl font-semibold text-white">Nylig spilte kvelder</h2>
                    </div>
                    <span class="text-xs uppercase tracking-[0.3em] text-slate-400">Dato • Spill • Lokasjon</span>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-lg shadow-slate-200">
                    <div class="divide-y divide-slate-100">
                        @foreach ($gameplays as $play)
                            @php
                                $playerNames = collect($play->results ?? [])
                                    ->pluck('user_id')
                                    ->map(fn ($userId) => $users->get($userId)?->name ?? 'Ukjent')
                                    ->filter()
                                    ->values();
                            @endphp
                            <article class="flex flex-col gap-3 py-4 last:pb-0">
                                <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.3em] text-slate-500">{{ $play->date_played->format('Y-m-d') }}</p>
                                        <p class="text-lg font-semibold text-slate-900">{{ $play->game?->name ?? 'Ukjent spill' }}</p>
                                    </div>
                                    <div class="text-xs uppercase tracking-[0.3em] text-slate-500">{{ $play->location }}</div>
                                </div>
                                <div class="text-sm text-slate-600">
                                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Deltakere (1-5)</p>
                                    <p>{{ $playerNames->implode(' • ') ?: 'Ingen spillere registrert' }}</p>
                                </div>
                            </article>
                        @endforeach
                        @unless ($gameplays->count())
                            <p class="py-4 text-sm text-slate-500">Ingen gameplay-data ennå.</p>
                        @endunless
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>

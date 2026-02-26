<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Stigen • Follese Brettspillklubb</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-b from-slate-900 to-slate-800 text-slate-100">
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col gap-10 px-4 py-20">
            <header id="panel-hero" class="mx-auto flex w-full max-w-5xl flex-col gap-4 rounded-3xl border border-slate-800 bg-slate-900/80 p-8 text-left shadow-lg shadow-black/30 backdrop-blur-sm md:flex-row md:items-center md:justify-between">
                <div class="space-y-2">
                    <p class="text-xs uppercase tracking-[0.7em] text-slate-400">Follese Brettspillklubb</p>
                    <h1 class="text-3xl font-semibold text-white md:text-4xl">Stigen</h1>
                    <p class="text-sm text-slate-300">
                        Rangeringen bygger på hver Spilløkt, med poeng etter kompleksitet. Nå ser du hvem som leder og hvilke spill som nylig ble spilt.
                    </p>
                </div>
                <div class="flex gap-3 text-xs uppercase tracking-[0.4em]">
                    <a href="{{ route('home') }}" class="rounded-full border border-emerald-400/40 px-4 py-2 text-emerald-200 transition hover:border-emerald-300 hover:text-emerald-100">
                        Til forsiden
                    </a>
                    <a href="#games-played" class="rounded-full border border-slate-500/40 px-4 py-2 text-slate-200 transition hover:border-slate-300 hover:text-white">
                        Se spill
                    </a>
                </div>
            </header>

            <section class="space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                        <h2 class="text-2xl font-semibold text-white">De høyest rangerte</h2>
                </div>
                <div id="panel-ladder" class="rounded-3xl border border-slate-800 bg-slate-900/80 p-6 shadow-lg shadow-black/30">
                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full table-fixed text-sm">
                            <thead>
                                <tr class="bg-slate-800/60">
                                    <th class="px-4 py-3 text-left text-xs uppercase tracking-[0.3em] text-slate-300">Rank</th>
                                    <th class="px-4 py-3 text-left text-xs uppercase tracking-[0.3em] text-slate-300">Navn</th>
                                    <th class="px-4 py-3 text-right text-xs uppercase tracking-[0.3em] text-amber-300">Poeng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rankings as $index => $entry)
                                    <tr class="{{ $index % 2 === 0 ? 'bg-slate-900/40' : 'bg-slate-800/40' }}">
                                        <td class="px-4 py-3 font-semibold text-slate-300">#{{ $index + 1 }}</td>
                                        <td class="px-4 py-3 font-semibold text-white">{{ $entry['user']->name }}</td>
                                        <td class="px-4 py-3 text-right font-semibold text-amber-300">{{ number_format($entry['points']) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-slate-400">Ingen poeng registrert enda.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="games-played" class="space-y-4">
                <div class="flex flex-wrap items-center justify-between gap-3">
                        <h2 class="text-2xl font-semibold text-white">Spillkvelder</h2>
                </div>
                <div id="panel-gameplays" class="rounded-3xl border border-slate-800 bg-slate-900/80 p-6 shadow-lg shadow-black/30">
                    <div class="divide-y divide-slate-800">
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
                                        <p class="text-white">{{ $play->date_played->format('d/m-Y') }} - 
                                        <span class="text-lg font-semibold">{{ $play->game?->name ?? 'Ukjent spill' }}</span></p>
                                    </div>
                                    <div class="text-xs uppercase tracking-[0.3em] text-slate-400">{{ $play->location }}</div>
                                </div>
                                <div class="text-sm text-slate-300">
                                    <p class="text-xs uppercase tracking-[0.3em] text-slate-400">Resultat</p>
                                    <p>{{ $playerNames->implode(' • ') ?: 'Ingen spillere registrert' }}</p>
                                </div>
                            </article>
                        @endforeach
                        @unless ($gameplays->count())
                            <p class="py-4 text-sm text-slate-400">Ingen Spilløkter-data ennå.</p>
                        @endunless
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>

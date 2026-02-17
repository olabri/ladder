<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Velkommen til Follese Brettspillklubb</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 text-white">
        <div class="flex min-h-screen items-center justify-center px-6 py-12">
            <div class="w-full max-w-3xl space-y-10 rounded-3xl border border-white/20 bg-slate-900/70 p-10 shadow-[0_30px_80px_rgba(2,6,23,0.7)] backdrop-blur">
                <div>
                    <p class="text-xs uppercase tracking-[0.5em] text-slate-300">Velkommen</p>
                    <h1 class="mt-4 text-4xl font-semibold leading-tight text-white/90 md:text-5xl">
                        Velkommen til Follese Brettspillklubb!
                    </h1>
                    <p class="mt-4 text-lg leading-relaxed text-slate-200/80">
                        Sjekk ut brettspill-stigen vår, finn dine spillvenner og bli inspirert til neste slag. Vi samler erfarne og nye spillere til hyggelige kvelder i et nordisk klima av raushet og strategi.
                    </p>
                </div>
                <div class="flex flex-col gap-6 rounded-2xl border border-slate-800/70 bg-slate-950/30 p-6 text-sm text-slate-200 shadow-inner shadow-black/30">
                    <p class="text-xs uppercase tracking-[0.4em] text-slate-500">Hva venter</p>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <span class="flex h-2 w-2 rounded-full bg-emerald-400"></span>
                            <span>Følg brettspill-Stigen og finn neste kamp.</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-2 w-2 rounded-full bg-sky-400"></span>
                            <span>Oppdag klubben, spillere og nye strategier.</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="flex h-2 w-2 rounded-full bg-amber-400"></span>
                            <span>Bli med på hyggelige kvelder og del erfaring.</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between gap-4">
                    <a
                        href="{{ url('/games') }}"
                        class="inline-flex items-center justify-center rounded-full bg-white px-10 py-3 text-base font-semibold text-slate-950 shadow-lg shadow-emerald-500/30 transition hover:bg-slate-100"
                    >
                        Stigen
                    </a>
                    <div class="text-right text-xs uppercase tracking-[0.4em] text-slate-500">Follese Btettspillklubb</div>
                </div>
            </div>
        </div>
    </body>
</html>

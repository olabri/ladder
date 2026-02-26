<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center gap-3">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Administrer klubbens brukere, spill og registrerte gameplays fra ett sted.
                </p>
            </div>
            <a
                href="{{ route('home') }}"
                class="inline-flex items-center justify-center rounded-full border border-slate-300 px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-700 transition hover:border-slate-500 hover:text-slate-900 focus:outline-none focus-visible:ring focus-visible:ring-slate-400/40 dark:border-slate-700 dark:text-slate-200 dark:hover:border-slate-400 dark:hover:text-white"
            >
                Til forsiden
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="rounded-xl border border-emerald-400/60 bg-emerald-500/10 p-4 text-sm text-emerald-900 dark:text-emerald-100">
                    {{ session('status') }}
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-3">
                <div id="panel-overview" class="rounded-2xl border border-gray-200/70 bg-white/90 p-6 shadow-sm shadow-slate-800/10 dark:border-slate-700/60 dark:bg-slate-900/60">
                    <p class="text-sm uppercase tracking-[0.4em] text-gray-500 dark:text-gray-400">Oversikt</p>
                    <div class="mt-4">
                        <p class="text-4xl font-semibold text-slate-900 dark:text-white">{{ $totalUsers }}</p>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400">Aktive medlemmer</p>
                    </div>
                    <div class="mt-4 flex items-center justify-between text-sm text-slate-600 dark:text-slate-300">
                        <span>Adminer</span>
                        <span>{{ $adminCount }}</span>
                    </div>
                </div>

                <div id="panel-game-admins" class="rounded-2xl border border-gray-200/70 bg-white/90 p-6 shadow-sm shadow-slate-800/10 dark:border-slate-700/60 dark:bg-slate-900/60">
                    <p class="text-sm uppercase tracking-[0.4em] text-gray-500 dark:text-gray-400">Game admins</p>
                    <div class="mt-4">
                        <p class="text-4xl font-semibold text-slate-900 dark:text-white">{{ $gameAdminCount }}</p>
                        <p class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400">Spillansvarlige</p>
                    </div>
                </div>

                <div id="panel-games" class="lg:col-span-2 rounded-2xl border border-gray-200/70 bg-white/90 p-6 shadow-sm shadow-slate-800/10 dark:border-slate-700/60 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Spill</h3>
                        <span class="text-xs uppercase tracking-[0.4em] text-gray-400">Gi oversikt</span>
                    </div>
                    <div class="mt-4 space-y-4">
                        <div class="rounded-2xl border border-slate-200/60 bg-white/80 p-5 dark:border-slate-800 dark:bg-slate-900/60">
                            <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400">Nytt spill</p>
                                    <p class="text-xs text-slate-400">Navn + kompleksitet</p>
                                </div>
                                <button
                                    id="show-game-form"
                                    type="button"
                                    class="inline-flex items-center justify-center rounded-full bg-sky-500 px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-sky-400 focus:outline-none focus-visible:ring focus-visible:ring-sky-500/40"
                                >
                                    Registrer nytt spill
                                </button>
                            </div>
                            <div
                                id="game-form-panel"
                                class="{{ $errors->hasAny(['game_name', 'game_complexity']) ? '' : 'hidden' }} mt-6 rounded-2xl border border-dashed border-slate-200/60 bg-white/60 p-6 shadow-inner shadow-black/5 dark:border-slate-700/60 dark:bg-slate-900/40"
                                data-default-name="{{ old('game_name', '') }}"
                                data-default-complexity="{{ old('game_complexity', '') }}"
                                data-show-on-errors="{{ $errors->hasAny(['game_name', 'game_complexity']) ? 'true' : 'false' }}"
                            >
                                <form id="game-form" method="POST" action="{{ route('dashboard.games.store') }}" class="space-y-6">
                                    @csrf
                                    <input type="hidden" name="_method" id="game-form-method" value="POST">
                                    <div class="grid gap-4 md:grid-cols-2">
                                        <div>
                                            <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400" for="game-form-name">Navn</label>
                                            <input
                                                id="game-form-name"
                                                type="text"
                                                name="game_name"
                                                value="{{ old('game_name') }}"
                                                class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                                required
                                            />
                                            @error('game_name')
                                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400" for="game-form-complexity">Kompleksitet</label>
                                            <select
                                                id="game-form-complexity"
                                                name="game_complexity"
                                                class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                                required
                                            >
                                                @foreach ($complexityLevels as $levelValue => $levelLabel)
                                                    <option value="{{ $levelValue }}" {{ old('game_complexity') == $levelValue ? 'selected' : '' }}>
                                                        {{ ucfirst($levelLabel) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('game_complexity')
                                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <button
                                            type="submit"
                                            class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-slate-800 focus:outline-none focus-visible:ring focus-visible:ring-slate-500/40"
                                        >
                                            Lagre spill
                                        </button>
                                        <button
                                            type="button"
                                            id="game-form-cancel"
                                            class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500 transition hover:text-slate-700 dark:hover:text-slate-200"
                                        >
                                            Avbryt
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="rounded-2xl border border-slate-200/60 bg-white/80 p-5 dark:border-slate-800 dark:bg-slate-900/60">
                            <div class="overflow-hidden rounded-xl border border-slate-200/60 dark:border-slate-800">
                                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-sm">
                                    <thead class="bg-slate-50 dark:bg-slate-900">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Navn</th>
                                            <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Kompleksitet</th>
                                            <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Lagt til</th>
                                            <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Handling</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                        @forelse ($games as $game)
                                            <tr class="bg-white dark:bg-slate-900">
                                                <td class="px-4 py-3 text-slate-800 dark:text-slate-100">{{ $game->name }}</td>
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $game->complexity }}</td>
                                                <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $game->created_at->format('Y-m-d') }}</td>
                                                <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                                    <div class="flex items-center gap-3">
                                                        <a
                                                            href="#game-form-panel"
                                                            data-action="edit-game"
                                                            data-id="{{ $game->id }}"
                                                            data-name="{{ $game->name }}"
                                                            data-complexity="{{ $game->complexity }}"
                                                            class="text-xs text-slate-500 underline-offset-2 hover:underline dark:text-slate-400"
                                                        >
                                                            Endre
                                                        </a>
                                                        <form method="POST" action="{{ route('dashboard.games.destroy', $game) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button
                                                                type="submit"
                                                                class="text-xs font-semibold uppercase tracking-[0.3em] text-rose-600 hover:text-rose-400 dark:text-rose-400 dark:hover:text-rose-200"
                                                            >
                                                                Slett
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                                    Ingen spill registrert enda.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="panel-gameplay" class="rounded-2xl border border-slate-200/70 bg-white/90 p-6 shadow-sm shadow-slate-800/10 dark:border-slate-700/60 dark:bg-slate-900">
                    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Gameplay</h3>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Registrer og rediger kampdatoer med rangering.</p>
                        </div>
                        <button
                            id="show-gameplay-form"
                            type="button"
                            class="inline-flex items-center justify-center rounded-full bg-indigo-500 px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-indigo-400 focus:outline-none focus-visible:ring focus-visible:ring-indigo-500/40"
                        >
                            Registrer gameplay
                        </button>
                    </div>

                    <div
                        id="gameplay-form-panel"
                        class="{{ $errors->hasAny(['gameplay_game_id', 'gameplay_players.*', 'gameplay_date_played']) ? '' : 'hidden' }} mt-6 rounded-2xl border border-dashed border-slate-200/60 bg-white/60 p-6 shadow-inner shadow-black/5 dark:border-slate-700/60 dark:bg-slate-900/40"
                        data-default-game="{{ old('gameplay_game_id', $games->first()?->id ?? '') }}"
                        data-default-players="@json(old('gameplay_players', []))"
                        data-default-date="{{ old('gameplay_date_played', now()->toDateString()) }}"
                        data-default-location="{{ old('gameplay_location', 'FOLK') }}"
                        data-show-on-errors="{{ $errors->hasAny(['gameplay_game_id', 'gameplay_players.*', 'gameplay_date_played']) ? 'true' : 'false' }}"
                    >
                        <form id="gameplay-form" method="POST" action="{{ route('dashboard.gameplays.store') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="_method" id="gameplay-form-method" value="POST">
                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400" for="gameplay-form-game">Spill</label>
                                    <select
                                        id="gameplay-form-game"
                                        name="gameplay_game_id"
                                        class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                    >
                                        @foreach ($games as $game)
                                            <option value="{{ $game->id }}" {{ old('gameplay_game_id') == $game->id ? 'selected' : '' }}>{{ $game->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('gameplay_game_id')
                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400" for="gameplay-form-date">Dato</label>
                                    <input
                                        id="gameplay-form-date"
                                        type="date"
                                        name="gameplay_date_played"
                                        value="{{ old('gameplay_date_played', now()->toDateString()) }}"
                                        class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                        required
                                    />
                                    @error('gameplay_date_played')
                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid gap-4 md:grid-cols-2">
                                <div>
                                    <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400" for="gameplay-form-location">Lokasjon</label>
                                    <input
                                        id="gameplay-form-location"
                                        type="text"
                                        name="gameplay_location"
                                        value="{{ old('gameplay_location', 'FOLK') }}"
                                        class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                    />
                                    @error('gameplay_location')
                                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400">
                                    Rangering (1-5)
                                </div>
                            </div>

                            <div class="grid gap-4 sm:grid-cols-5">
                                @for ($rank = 1; $rank <= 5; $rank++)
                                    @php $slotIndex = $rank - 1; @endphp
                                    <div>
                                        <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400" for="gameplay-form-player-{{ $rank }}">Plass {{ $rank }}</label>
                                        <select
                                            id="gameplay-form-player-{{ $rank }}"
                                            name="gameplay_players[]"
                                            data-gameplay-slot="{{ $rank }}"
                                            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                        >
                                            <option value="">Velg spiller</option>
                                            @foreach ($players as $player)
                                                <option value="{{ $player->id }}" {{ old("gameplay_players.{$slotIndex}") == $player->id ? 'selected' : '' }}>
                                                    {{ $player->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endfor
                            </div>

                            <div class="flex items-center justify-between">
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-slate-800 focus:outline-none focus-visible:ring focus-visible:ring-slate-500/40"
                                >
                                    Lagre gameplay
                                </button>
                                <button
                                    type="button"
                                    id="gameplay-form-cancel"
                                    class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500 transition hover:text-slate-700 dark:hover:text-slate-200"
                                >
                                    Avbryt
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mt-6 overflow-hidden rounded-xl border border-slate-200/60 dark:border-slate-800">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-900">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Dato</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Spill</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Spiller</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Lokasjon</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Handling</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse ($gameplays as $play)
                                    <tr class="bg-white dark:bg-slate-900">
                                        <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $play->date_played->format('Y-m-d') }}</td>
                                        <td class="px-4 py-3 text-slate-800 dark:text-slate-100">{{ $play->game?->name ?? 'Ukjent' }}</td>
                                        <td class="px-4 py-3 text-slate-700 dark:text-slate-300">{{ $play->primaryPlayer()?->name ?? 'Ukjent' }}</td>
                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $play->location }}</td>
                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-300">
                                            <div class="flex items-center gap-3">
                                                <a
                                                    href="#gameplay-form-panel"
                                                    data-action="edit-gameplay"
                                                    data-id="{{ $play->id }}"
                                                    data-game-id="{{ $play->game_id }}"
                                                    data-players='@json(array_column($play->results ?? [], 'user_id'))'
                                                    data-date="{{ $play->date_played->toDateString() }}"
                                                    data-location="{{ $play->location }}"
                                                    class="text-xs text-slate-500 underline-offset-2 hover:underline dark:text-slate-400"
                                                >
                                                    Endre
                                                </a>
                                                <form method="POST" action="{{ route('dashboard.gameplays.destroy', $play) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="text-xs font-semibold uppercase tracking-[0.3em] text-rose-600 hover:text-rose-400 dark:text-rose-400 dark:hover:text-rose-200"
                                                    >
                                                        Slett
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                            Ingen gameplays registrert ennå.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="panel-users" class="lg:col-span-2 rounded-2xl border border-slate-200/70 bg-white/95 p-6 shadow-sm shadow-slate-800/10 dark:border-slate-700/60 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Alle brukere</h3>
                    </div>
                    <div class="mt-4 overflow-hidden rounded-xl border border-slate-200/60 dark:border-slate-800">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-800 text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-900">
                                <tr>
                                    <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Navn</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">E-post</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Rolle</th>
                                    <th class="px-4 py-3 text-left font-medium text-slate-500 dark:text-slate-300">Lagt til</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse ($users as $member)
                                    <tr class="bg-white dark:bg-slate-900">
                                        <td class="px-4 py-3 text-slate-800 dark:text-slate-100">
                                            <div class="flex items-baseline justify-between gap-3">
                                                <span>{{ $member->name }}</span>
                                                <a
                                                    href="#user-form-panel"
                                                    data-action="edit-user"
                                                    data-id="{{ $member->id }}"
                                                    data-name="{{ $member->name }}"
                                                    data-email="{{ $member->email }}"
                                                    data-admin="{{ $member->is_admin ? '1' : '0' }}"
                                                    data-game-admin="{{ $member->is_game_admin ? '1' : '0' }}"
                                                    class="text-xs text-slate-500 underline-offset-2 hover:underline dark:text-slate-400"
                                                >
                                                    Endre
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $member->email }}</td>
                                        <td class="px-4 py-3 font-semibold text-slate-900 dark:text-slate-100">
                                            @if ($member->is_admin)
                                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-600 dark:bg-emerald-600/20 dark:text-emerald-100">Admin</span>
                                            @elseif ($member->is_game_admin)
                                                <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-sky-600 dark:bg-sky-600/20 dark:text-sky-100">Game admin</span>
                                            @else
                                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-slate-600 dark:bg-slate-700/40 dark:text-slate-200">Medlem</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-slate-500 dark:text-slate-400">
                                            {{ $member->created_at->format('Y-m-d') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-500 dark:text-slate-400">
                                            Ingen registrerte brukere funnet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Administrer brukere</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Registrer nye medlemmer eller endre roller og e-post.</p>
                            </div>
                            <button
                                id="show-user-form"
                                type="button"
                                class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-emerald-400 focus:outline-none focus-visible:ring focus-visible:ring-emerald-500/40"
                            >
                                Registrer ny bruker
                            </button>
                        </div>

                        <div
                            id="user-form-panel"
                            class="{{ $errors->hasAny(['name', 'email', 'password']) ? '' : 'hidden' }} rounded-2xl border border-dashed border-slate-200/60 bg-white/60 p-6 shadow-inner shadow-black/5 dark:border-slate-700/60 dark:bg-slate-900/40"
                            data-default-name="{{ old('name', '') }}"
                            data-default-email="{{ old('email', '') }}"
                            data-default-is-admin="{{ old('is_admin') ? '1' : '0' }}"
                            data-default-is-game-admin="{{ old('is_game_admin') ? '1' : '0' }}"
                            data-show-on-errors="{{ $errors->hasAny(['name', 'email', 'password']) ? 'true' : 'false' }}"
                        >
                            <form id="user-form" method="POST" action="{{ route('dashboard.users.store') }}" class="space-y-6">
                                @csrf
                                <input type="hidden" name="_method" id="user-form-method" value="POST">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400" for="user-form-name">Navn</label>
                                        <input
                                            id="user-form-name"
                                            type="text"
                                            name="name"
                                            value="{{ old('name') }}"
                                            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                            required
                                        />
                                        @error('name')
                                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400" for="user-form-email">E-post</label>
                                        <input
                                            id="user-form-email"
                                            type="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                            required
                                        />
                                        @error('email')
                                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400" for="user-form-password">Passord</label>
                                        <input
                                            id="user-form-password"
                                            type="password"
                                            name="password"
                                            class="mt-2 w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
                                            required
                                        />
                                        @error('password')
                                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-4">
                                        <label class="flex items-center justify-between rounded-xl border border-slate-200/70 bg-white px-3 py-2 text-xs uppercase tracking-[0.4em] text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                            <span>Gi admin</span>
                                            <input id="user-form-is-admin" type="checkbox" name="is_admin" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-400" {{ old('is_admin') ? 'checked' : '' }} />
                                        </label>
                                        <label class="flex items-center justify-between rounded-xl border border-slate-200/70 bg-white px-3 py-2 text-xs uppercase tracking-[0.4em] text-slate-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                                            <span>Game admin</span>
                                            <input id="user-form-is-game-admin" type="checkbox" name="is_game_admin" value="1" class="h-4 w-4 rounded border-slate-300 text-sky-500 focus:ring-sky-400" {{ old('is_game_admin') ? 'checked' : '' }} />
                                        </label>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400">
                                    <div id="user-form-password-hint" class="text-xs text-slate-500 dark:text-slate-400">Minimum 8 tegn.</div>
                                    <div class="flex gap-3">
                                        <button
                                            type="submit"
                                            class="inline-flex items-center justify-center rounded-full bg-slate-900 px-5 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-slate-800 focus:outline-none focus-visible:ring focus-visible:ring-slate-500/40"
                                        >
                                            Lagre
                                        </button>
                                        <button
                                            type="button"
                                            id="user-form-cancel"
                                            class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-500 transition hover:text-slate-700 dark:hover:text-slate-200"
                                        >
                                            Avbryt
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let dashboardInitController;

        const initDashboardForms = () => {
            if (dashboardInitController) {
                dashboardInitController.abort();
            }
            dashboardInitController = new AbortController();
            const { signal } = dashboardInitController;

            const panel = document.getElementById('user-form-panel');
            if (panel) {
                const form = document.getElementById('user-form');
                const showBtn = document.getElementById('show-user-form');
                const cancelBtn = document.getElementById('user-form-cancel');
                const methodInput = document.getElementById('user-form-method');
                const nameInput = document.getElementById('user-form-name');
                const emailInput = document.getElementById('user-form-email');
                const passwordInput = document.getElementById('user-form-password');
                const passwordHint = document.getElementById('user-form-password-hint');
                const isAdminInput = document.getElementById('user-form-is-admin');
                const isGameAdminInput = document.getElementById('user-form-is-game-admin');
                const baseStoreAction = '{{ route('dashboard.users.store') }}';
                const baseUpdateAction = '{{ url("dashboard/users") }}';
                const defaultName = panel.dataset.defaultName || '';
                const defaultEmail = panel.dataset.defaultEmail || '';
                const defaultIsAdmin = panel.dataset.defaultIsAdmin === '1';
                const defaultIsGameAdmin = panel.dataset.defaultIsGameAdmin === '1';

                const openForm = (mode, user = null) => {
                    panel.classList.remove('hidden');
                    if (mode === 'edit' && user) {
                        form.action = `${baseUpdateAction}/${user.id}`;
                        methodInput.value = 'PATCH';
                        nameInput.value = user.name;
                        emailInput.value = user.email;
                        isAdminInput.checked = user.isAdmin;
                        isGameAdminInput.checked = user.isGameAdmin;
                        passwordInput.removeAttribute('required');
                        passwordInput.value = '';
                        passwordHint.textContent = 'La stå tomt for å beholde eksisterende passord.';
                    } else {
                        form.action = baseStoreAction;
                        methodInput.value = 'POST';
                        nameInput.value = defaultName;
                        emailInput.value = defaultEmail;
                        isAdminInput.checked = defaultIsAdmin;
                        isGameAdminInput.checked = defaultIsGameAdmin;
                        passwordInput.setAttribute('required', 'required');
                        passwordHint.textContent = 'Minimum 8 tegn.';
                    }
                };

                showBtn?.addEventListener('click', function () {
                    openForm('create');
                    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, { signal });

                document.querySelectorAll('[data-action="edit-user"]').forEach((link) => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        openForm('edit', {
                            id: this.dataset.id,
                            name: this.dataset.name,
                            email: this.dataset.email,
                            isAdmin: this.dataset.admin === '1',
                            isGameAdmin: this.dataset.gameAdmin === '1',
                        });
                        panel.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, { signal });
                });

                cancelBtn?.addEventListener('click', function () {
                    openForm('create');
                    panel.classList.add('hidden');
                }, { signal });

                if (panel.dataset.showOnErrors === 'true') {
                    openForm('create');
                }
            }

            const gamePanel = document.getElementById('game-form-panel');
            if (gamePanel) {
                const showGameBtn = document.getElementById('show-game-form');
                const cancelGameBtn = document.getElementById('game-form-cancel');
                const gameForm = document.getElementById('game-form');
                const methodInput = document.getElementById('game-form-method');
                const nameInput = document.getElementById('game-form-name');
                const complexityInput = document.getElementById('game-form-complexity');
                const baseStore = '{{ route('dashboard.games.store') }}';
                const baseAction = '{{ url("dashboard/games") }}';
                const defaultName = gamePanel.dataset.defaultName || '';
                const defaultComplexity = gamePanel.dataset.defaultComplexity || '';

                const openGameForm = (mode, game = null) => {
                    gamePanel.classList.remove('hidden');
                    if (mode === 'edit' && game) {
                        gameForm.action = `${baseAction}/${game.id}`;
                        methodInput.value = 'PATCH';
                        nameInput.value = game.name;
                        complexityInput.value = game.complexity;
                    } else {
                        gameForm.action = baseStore;
                        methodInput.value = 'POST';
                        nameInput.value = defaultName;
                        complexityInput.value = defaultComplexity;
                    }
                };

                showGameBtn?.addEventListener('click', function () {
                    openGameForm('create');
                    gamePanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, { signal });

                document.querySelectorAll('[data-action="edit-game"]').forEach((link) => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        openGameForm('edit', {
                            id: this.dataset.id,
                            name: this.dataset.name,
                            complexity: this.dataset.complexity,
                        });
                        gamePanel.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, { signal });
                });

                cancelGameBtn?.addEventListener('click', function () {
                    openGameForm('create');
                    gamePanel.classList.add('hidden');
                }, { signal });

                if (gamePanel.dataset.showOnErrors === 'true') {
                    openGameForm('create');
                }
            }

            const gameplayPanel = document.getElementById('gameplay-form-panel');
            if (gameplayPanel) {
                const showGameplayBtn = document.getElementById('show-gameplay-form');
                const cancelGameplayBtn = document.getElementById('gameplay-form-cancel');
                const gameplayForm = document.getElementById('gameplay-form');
                const methodInput = document.getElementById('gameplay-form-method');
                const gameSelect = document.getElementById('gameplay-form-game');
                const dateInput = document.getElementById('gameplay-form-date');
                const locationInput = document.getElementById('gameplay-form-location');
                const playerSlots = gameplayPanel.querySelectorAll('[data-gameplay-slot]');
                const baseStore = '{{ route('dashboard.gameplays.store') }}';
                const baseAction = '{{ url("dashboard/gameplays") }}';

                const defaults = {
                    game: gameplayPanel.dataset.defaultGame,
                    players: JSON.parse(gameplayPanel.dataset.defaultPlayers || '[]'),
                    date: gameplayPanel.dataset.defaultDate,
                    location: gameplayPanel.dataset.defaultLocation,
                };

                const openGameplayForm = (mode, gameplay = null) => {
                    gameplayPanel.classList.remove('hidden');
                    if (mode === 'edit' && gameplay) {
                        gameplayForm.action = `${baseAction}/${gameplay.id}`;
                        methodInput.value = 'PATCH';
                        gameSelect.value = gameplay.gameId;
                        dateInput.value = gameplay.date;
                        locationInput.value = gameplay.location;
                        playerSlots.forEach((slot, index) => {
                            slot.value = gameplay.players[index] ?? '';
                        });
                    } else {
                        gameplayForm.action = baseStore;
                        methodInput.value = 'POST';
                        gameSelect.value = defaults.game;
                        dateInput.value = defaults.date;
                        locationInput.value = defaults.location;
                        playerSlots.forEach((slot, index) => {
                            slot.value = defaults.players[index] ?? '';
                        });
                    }
                };

                showGameplayBtn?.addEventListener('click', function () {
                    openGameplayForm('create');
                    gameplayPanel.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }, { signal });

                document.querySelectorAll('[data-action="edit-gameplay"]').forEach((link) => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        openGameplayForm('edit', {
                            id: this.dataset.id,
                            gameId: this.dataset.gameId,
                            players: JSON.parse(this.dataset.players || '[]'),
                            date: this.dataset.date,
                            location: this.dataset.location,
                        });
                        gameplayPanel.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }, { signal });
                });

                cancelGameplayBtn?.addEventListener('click', function () {
                    openGameplayForm('create');
                    gameplayPanel.classList.add('hidden');
                }, { signal });

                if (gameplayPanel.dataset.showOnErrors === 'true') {
                    openGameplayForm('create');
                }
            }
        };

        document.addEventListener('DOMContentLoaded', initDashboardForms);
        document.addEventListener('livewire:navigated', initDashboardForms);
    </script>
</x-app-layout>

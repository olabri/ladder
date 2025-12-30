<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Administrer klubbens brukere og gi tilgang til admin-verktøy.
            </p>
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
                <div class="rounded-2xl border border-gray-200/70 bg-white/80 p-6 shadow-sm shadow-slate-800/10 dark:border-slate-700/60 dark:bg-slate-900">
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

                <div class="lg:col-span-2 rounded-2xl border border-gray-200/70 bg-white/80 p-6 shadow-sm shadow-slate-800/10 dark:border-slate-700/60 dark:bg-slate-900">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Alle brukere</h3>
                        <span class="text-xs uppercase tracking-[0.4em] text-gray-400">Sortert nyest først</span>
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
                                        <td class="px-4 py-3 text-slate-800 dark:text-slate-100">{{ $member->name }}</td>
                                        <td class="px-4 py-3 text-slate-600 dark:text-slate-300">{{ $member->email }}</td>
                                        <td class="px-4 py-3 font-semibold text-slate-900 dark:text-slate-100">
                                            {{ $member->is_admin ? 'Admin' : 'Medlem' }}
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
                </div>
            </div>

            <div class="rounded-2xl border border-dashed border-slate-200/60 bg-white/90 p-6 shadow-sm shadow-slate-800/10 dark:border-slate-700/60 dark:bg-slate-900">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Registrer ny bruker</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Legg til nye medlemmer med passord og eventuelt admin-tilgang.</p>
                <form class="mt-6 grid gap-4 md:grid-cols-2" method="POST" action="{{ route('dashboard.users.store') }}">
                    @csrf

                    <div class="md:col-span-1">
                        <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400">Navn</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-transparent px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:text-slate-100"
                            required
                        />
                        @error('name')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400">E-post</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-transparent px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:text-slate-100"
                            required
                        />
                        @error('email')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400">Passord</label>
                        <input
                            type="password"
                            name="password"
                            class="mt-2 w-full rounded-xl border border-slate-200 bg-transparent px-3 py-2 text-sm text-slate-900 outline-none focus:border-slate-500 focus:ring focus:ring-slate-500/30 dark:border-slate-700 dark:text-slate-100"
                            required
                        />
                        @error('password')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1 relative flex items-center justify-between rounded-xl border border-slate-200/70 bg-slate-50 px-3 py-2 dark:border-slate-700 dark:bg-slate-800">
                        <label class="text-xs uppercase tracking-[0.4em] text-slate-500 dark:text-slate-400">Gi admin</label>
                        <input
                            type="checkbox"
                            name="is_admin"
                            value="1"
                            class="h-4 w-4 rounded border-slate-300 text-emerald-500 focus:ring-emerald-400"
                            {{ old('is_admin') ? 'checked' : '' }}
                        />
                    </div>

                    <div class="md:col-span-2 flex justify-end">
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-8 py-3 text-sm font-semibold uppercase tracking-[0.4em] text-white transition hover:bg-emerald-400 focus:outline-none focus-visible:ring focus-visible:ring-emerald-500/40"
                        >
                            Lagre bruker
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

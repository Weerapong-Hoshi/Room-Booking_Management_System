<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            @if (Auth::user()->profile_image)
                <img src="{{ asset('storage/' . Auth::user()->profile_image) }}"
                    alt="{{ Auth::user()->name }}"
                    class="w-16 h-16 rounded-full object-cover border-4 border-indigo-500">
            @else
                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-bold text-2xl border-4 border-indigo-500">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h2 class="font-bold text-3xl text-gray-900 dark:text-white leading-tight">
                    👤 {{ Auth::user()->name }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                @if (Auth::user()->role === 'admin')
                    <span class="text-xs font-bold text-purple-600 dark:text-purple-400">🔑 ผู้ดูแลระบบ</span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white dark:bg-gray-800 shadow-lg sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div>
            </div>
        </div>
    </div>
</x-app-layout>

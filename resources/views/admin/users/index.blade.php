<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-3xl text-gray-900 dark:text-white leading-tight">
                    👥 จัดการผู้ใช้ระบบ
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ทั้งหมด {{ $users->count() }} ผู้ใช้</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-blue-700 shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                เพิ่มผู้ใช้ใหม่
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-200 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-gray-100 to-gray-50 dark:from-gray-700 dark:to-gray-600">
                            <tr class="text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                                <th class="px-6 py-4">🖼️ รูปโปรไฟล์</th>
                                <th class="px-6 py-4">👤 ชื่อผู้ใช้</th>
                                <th class="px-6 py-4">📧 อีเมล</th>
                                <th class="px-6 py-4">🔖 ยศ</th>
                                <th class="px-6 py-4">📅 สมัครสมาชิก</th>
                                <th class="px-6 py-4 text-center">⚙️ จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($users as $user)
                                <tr class="hover:bg-blue-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <td class="px-6 py-4">
                                        @if ($user->profile_image)
                                            <img src="{{ asset('storage/' . $user->profile_image) }}"
                                                alt="{{ $user->name }}"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-indigo-200 dark:border-indigo-700">
                                        @else
                                            <div
                                                class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-bold text-lg border-2 border-indigo-200 dark:border-indigo-700">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-600 dark:text-gray-400">ID: {{ $user->id }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $user->email }}</td>
                                    <td class="px-6 py-4">
                                        @if ($user->role === 'admin')
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 border border-purple-300 dark:border-purple-700">
                                                🔑 ผู้ดูแลระบบ
                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 border border-green-300 dark:border-green-700">
                                                👤 ผู้ใช้ทั่วไป
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $user->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg font-semibold text-sm hover:bg-blue-200 dark:hover:bg-blue-900/50 transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                แก้ไข
                                            </a>

                                            @if ($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('ยืนยันการลบผู้ใช้: {{ $user->name }}?');"
                                                    style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg font-semibold text-sm hover:bg-red-200 dark:hover:bg-red-900/50 transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        ลบ
                                                    </button>
                                                </form>
                                            @else
                                                <span
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-400 rounded-lg font-semibold text-sm cursor-not-allowed"
                                                    title="ไม่สามารถลบบัญชีของตัวเองได้">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                        ลบ
                                                    </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 6a3 3 0 11-6 0 3 3 0 016 0zM6 20a9 9 0 0118 0v-2a9 9 0 00-18 0v2z">
                                                </path>
                                            </svg>
                                            <p class="text-gray-600 dark:text-gray-400 font-semibold">ไม่มีผู้ใช้</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

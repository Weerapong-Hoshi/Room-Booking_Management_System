<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
            📋 อนุมัติการจองห้อง
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">ตรวจสอบและอนุมัติคำขอจองห้องจากผู้ใช้งาน</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ส่วนที่ 1: ตารางอนุมัติการจอง -->
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-2xl border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">รายการคำขอจองห้อง (รออนุมัติ)</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $pendingBookings->count() }} รายการรออนุมัติ</p>
                    </div>
                    <span
                        class="bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 text-2xl font-bold px-4 py-2 rounded-xl border-2 border-red-300 dark:border-red-700">
                        {{ $pendingBookings->count() }}
                    </span>
                </div>
                
                @if($pendingBookings->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs font-bold">
                                <tr>
                                    <th class="px-6 py-4">👤 ผู้จอง</th>
                                    <th class="px-6 py-4">🏛️ ห้อง</th>
                                    <th class="px-6 py-4">📅 วันที่</th>
                                    <th class="px-6 py-4">⏰ เวลา</th>
                                    <th class="px-6 py-4 text-center">⚙️ จัดการ</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($pendingBookings as $booking)
                                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-700/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="dark:text-white font-semibold">{{ $booking->user->name }}</div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">{{ $booking->user->email }}</div>
                                        </td>
                                        <td class="px-6 py-4 dark:text-white font-bold text-indigo-600 dark:text-indigo-400">{{ $booking->room->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                            {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                            {{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }} - 
                                            {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center gap-2">
                                                <form action="{{ route('admin.approve', $booking->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                                        ✓ อนุมัติ
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.reject', $booking->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit"
                                                        class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                                        ✕ ปฏิเสธ
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                <p class="text-gray-600 dark:text-gray-400 text-lg font-semibold">ไม่มีรายการรออนุมัติ</p>
                                                <p class="text-gray-500 dark:text-gray-500 text-sm mt-1">ยินดีด้วย! ทุกการจองได้รับการอนุมัติแล้ว</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-20 h-20 text-green-300 dark:text-green-700 mb-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-gray-700 dark:text-gray-300 text-xl font-bold">ไม่มีรายการรออนุมัติ</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">ยินดีด้วย! ทุกการจองได้รับการอนุมัติแล้ว</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Info Box -->
            <div class="mt-8 p-6 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-2xl">
                <div class="flex gap-4">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-7-4a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h4 class="font-bold text-blue-900 dark:text-blue-200">💡 เคล็ดลับ</h4>
                        <p class="text-sm text-blue-800 dark:text-blue-300 mt-1">ตรวจสอบรายละเอียดการจองอย่างระมัดระวัง ก่อนการอนุมัติ เพื่อให้มั่นใจว่าไม่มีความขัดแย้งกับการจองอื่น</p>
                    </div>
                </div>
            </div>

            <!-- Quick Navigation -->
            <div class="mt-8">
                <a href="{{ route('admin.rooms.index') }}" class="inline-block bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                    🏛️ จัดการห้องเรียน
                </a>
        </div>
    </div>
</x-app-layout>

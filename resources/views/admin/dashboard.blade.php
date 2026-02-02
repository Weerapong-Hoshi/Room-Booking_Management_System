<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            แผงควบคุมผู้ดูแลระบบ (Admin Control Panel)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- ส่วนที่ 1: ตารางอนุมัติการจอง -->
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">รายการคำขอจองห้อง (รออนุมัติ)</h3>
                    <span
                        class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $pendingBookings->count() }}
                        รายการ</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-300 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4">ผู้จอง</th>
                                <th class="px-6 py-4">ห้อง</th>
                                <th class="px-6 py-4">วันที่/เวลา</th>
                                <th class="px-6 py-4 text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($pendingBookings as $booking)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                                    <td class="px-6 py-4 dark:text-white">{{ $booking->user->name }}</td>
                                    <td class="px-6 py-4 dark:text-white font-medium">{{ $booking->room->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i') }} -
                                        {{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}
                                    </td>
                                    <td class="px-6 py-4 flex justify-center gap-2">
                                        <form action="{{ route('admin.approve', $booking->id) }}" method="POST">
                                            @csrf
                                            <button
                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-1.5 rounded-lg text-sm font-bold transition">อนุมัติ</button>
                                        </form>
                                        <form action="{{ route('admin.reject', $booking->id) }}" method="POST">
                                            @csrf
                                            <button
                                                class="bg-red-100 text-red-600 hover:bg-red-200 px-4 py-1.5 rounded-lg text-sm font-bold transition">ปฏิเสธ</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        ไม่มีรายการรออนุมัติในขณะนี้</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ส่วนที่ 2: จัดการห้องเรียน (Edit/Delete) -->
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">จัดการข้อมูลห้องเรียน</h3>
                    <button
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg shadow-indigo-200 transition">+
                        เพิ่มห้องใหม่</button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($rooms as $room)
                        <div
                            class="p-4 border dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 flex justify-between items-center group">
                            <div>
                                <h4 class="font-bold dark:text-white group-hover:text-indigo-600 transition">
                                    {{ $room->name }}</h4>
                                <p class="text-xs text-gray-500">ความจุ: {{ $room->capacity }} ที่นั่ง</p>
                            </div>
                            <div class="flex gap-1">
                                <button class="p-2 text-blue-500 hover:bg-blue-50 rounded-lg transition" title="แก้ไข">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="ลบ">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

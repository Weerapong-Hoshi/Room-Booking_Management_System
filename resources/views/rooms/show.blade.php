<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            รายละเอียดห้อง: {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden border dark:border-gray-700">

                <!-- ส่วนบน: รูปและรายละเอียด -->
                <div class="grid grid-cols-1 md:grid-cols-2">

                    <!-- ซ้าย: รูปห้อง -->
                    <div class="h-64 md:h-96 bg-gray-200 dark:bg-gray-700 overflow-hidden">
                        @if ($room->image_url)
                            <img src="{{ $room->image_url }}" alt="รูปห้อง {{ $room->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center w-full h-full text-gray-500">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="absolute mt-24 text-sm font-medium">ไม่มีรูปภาพห้อง</span>
                            </div>
                        @endif
                    </div>

                    <!-- ขวา: รายละเอียดห้อง -->
                    <div class="p-8 space-y-6 flex flex-col justify-between">
                        <div>
                            <h3 class="text-3xl font-black text-gray-900 dark:text-white mb-2">{{ $room->name }}</h3>

                            <div class="space-y-3 pb-6 border-b dark:border-gray-700">
                                <p class="text-gray-600 dark:text-gray-400">
                                    <span class="font-bold text-gray-800 dark:text-white">คำอธิบาย:</span>
                                    {{ $room->description }}
                                </p>
                                <p class="text-gray-600 dark:text-gray-400 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    <span class="font-bold text-gray-800 dark:text-white mr-1">ความจุ:</span>
                                    {{ $room->capacity }} ที่นั่ง
                                </p>
                            </div>
                        </div>

                        <!-- ปุ่มจองห้อง (Logic ใหม่: ห้ามแสดงถ้าห้องติดจอง) -->
                        <div class="pt-4 mt-auto">
                            @if ($isFullyBooked)
                                <!-- ถ้าห้องไม่ว่าง (ติด Approved หรือ Pending) -->
                                <p class="text-lg font-bold text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                        </path>
                                    </svg>
                                    ห้องถูกจองแล้วในขณะนี้
                                </p>
                                <p class="text-sm text-gray-500 mt-2">โปรดตรวจสอบตารางด้านล่างเพื่อดูช่วงเวลาที่ว่าง</p>

                                <!-- ลบลิงก์จองออกไปเลยเพื่อให้ปุ่มไม่ปรากฏ -->
                            @else
                                <!-- ถ้าห้องว่างจริงๆ -->
                                <a href="{{ route('bookings.create', $room->id) }}"
                                    class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-lg hover:bg-indigo-700 transition transform active:scale-95">
                                    จองห้องนี้ทันที
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- ส่วนล่าง: ตารางรายการจอง (วัน/เวลา) -->
                <div class="p-8 border-t dark:border-gray-700">
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-4 border-b pb-2">
                        ตารางการจองที่มีผลอยู่</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left dark:text-gray-300">
                            <thead
                                class="bg-gray-50 dark:bg-gray-700 text-gray-500 text-xs uppercase font-bold tracking-widest">
                                <tr>
                                    <th class="px-6 py-3">ผู้จอง</th>
                                    <th class="px-6 py-3">เวลาเริ่ม</th>
                                    <th class="px-6 py-3">เวลาสิ้นสุด</th>
                                    <th class="px-6 py-3">สถานะ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($activeBookings as $booking)
                                    <tr
                                        class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                                        <td class="px-6 py-4 font-bold">{{ $booking->user->name }}</td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i น.') }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y H:i น.') }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded text-xs font-bold {{ $booking->status === 'approved' ? 'bg-green-500' : 'bg-yellow-500' }} text-white">
                                                {{ $booking->status === 'approved' ? 'อนุมัติแล้ว' : 'รออนุมัติ' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                                            ไม่มีรายการจองที่มีผลอยู่ในขณะนี้</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

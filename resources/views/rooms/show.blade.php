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

                <!-- ส่วนล่าง: ตารางรายการจอง (วัน/เวลา) Modern -->
                <div class="p-8 border-t dark:border-gray-700">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-2xl font-black text-gray-800 dark:text-white">ตารางการจองที่มีผลอยู่</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $activeBookings->count() }} รายการจองในระบบ</p>
                        </div>
                    </div>

                    @forelse($activeBookings as $booking)
                        <div class="mb-4 p-5 bg-gradient-to-r {{ $booking->status === 'approved' ? 'from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-l-4 border-green-500' : 'from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 border-l-4 border-yellow-500' }} rounded-xl shadow-sm hover:shadow-md transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $booking->status === 'approved' ? 'from-green-400 to-green-600' : 'from-yellow-400 to-yellow-600' }} flex items-center justify-center text-white font-bold text-sm mr-3">
                                            {{ substr($booking->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white">{{ $booking->user->name }}</p>
                                            <p class="text-xs text-gray-600 dark:text-gray-400">ID: {{ $booking->user->id }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                        <div>
                                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">เวลาเริ่ม</p>
                                            <p class="text-sm font-black text-gray-900 dark:text-white flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ \Carbon\Carbon::parse($booking->start_time)->format('d/m/Y H:i น.') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">เวลาสิ้นสุด</p>
                                            <p class="text-sm font-black text-gray-900 dark:text-white flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ \Carbon\Carbon::parse($booking->end_time)->format('d/m/Y H:i น.') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-1">ระยะเวลา</p>
                                            <p class="text-sm font-black text-gray-900 dark:text-white flex items-center">
                                                <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ \Carbon\Carbon::parse($booking->start_time)->diffInMinutes(\Carbon\Carbon::parse($booking->end_time)) }} นาที
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <span class="px-4 py-2 rounded-full text-xs font-bold {{ $booking->status === 'approved' ? 'bg-green-500 text-white' : 'bg-yellow-500 text-white' }} whitespace-nowrap ml-4">
                                    {{ $booking->status === 'approved' ? '✓ อนุมัติแล้ว' : '⏱ รออนุมัติ' }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400 text-lg font-medium">ไม่มีรายการจองที่มีผลอยู่ในขณะนี้</p>
                            <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">ห้องนี้ว่างและพร้อมสำหรับการจอง</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

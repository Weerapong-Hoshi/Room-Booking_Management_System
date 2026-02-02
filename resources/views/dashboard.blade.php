<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ระบบจองห้องเรียนและห้องประชุม
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- ส่วนที่ 1: การแจ้งเตือน (Alerts) -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm rounded-r"
                    role="alert">
                    <p class="font-bold">สำเร็จ!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm rounded-r"
                    role="alert">
                    <p class="font-bold">เกิดข้อผิดพลาด!</p>
                    <p>{{ $errors->first() }}</p>
                </div>
            @endif

            <!-- ส่วนที่ 2: หัวข้อและปุ่มเมนูหลัก -->
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                    รายการห้องทั้งหมด
                </h3>
                <a href="{{ route('bookings.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="User8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    ดูปฏิทินการจองทั้งหมด
                </a>
            </div>

            <!-- ส่วนที่ 3: รายการห้อง (Room Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($rooms as $room)
                    <div
                        class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-shadow duration-300">
                        <div class="p-6">
                            <!-- แสดงสถานะ ว่าง/ไม่ว่าง -->
                            <div class="flex justify-between items-start mb-4">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $room->name }}</h4>

                                @if ($room->is_busy)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 shadow-sm">
                                        <span class="w-2 h-2 mr-1.5 bg-red-500 rounded-full animate-pulse"></span>
                                        ไม่ว่าง (มีการใช้งาน)
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 shadow-sm">
                                        <span class="w-2 h-2 mr-1.5 bg-green-500 rounded-full"></span>
                                        ว่าง
                                    </span>
                                @endif
                            </div>

                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-2">
                                {{ $room->description ?? 'ไม่มีคำอธิบายเพิ่มเติมสำหรับห้องนี้' }}
                            </p>

                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                รองรับได้: {{ $room->capacity }} ที่นั่ง
                            </div>

                            <!-- ปุ่มดำเนินการ -->
                            <div class="flex gap-2">
                                <a href="{{ route('bookings.create', $room->id) }}"
                                    class="flex-1 text-center px-4 py-2 bg-blue-500 border border-transparent rounded-lg font-bold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    จองห้องนี้
                                </a>

                                @if (Auth::user()->role === 'admin')
                                    <button
                                        class="px-3 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-lg hover:bg-gray-200 transition-colors"
                                        title="แก้ไขห้อง (เฉพาะแอดมิน)">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white dark:bg-gray-800 rounded-xl shadow">
                        <p class="text-gray-500 dark:text-gray-400">ยังไม่มีข้อมูลห้องในระบบ</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <!-- Load Flatpickr CSS/JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ยืนยันรายละเอียดการจอง
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl rounded-3xl flex flex-col md:flex-row border border-gray-100 dark:border-gray-700">

                <!-- ส่วนซ้าย: ข้อมูลห้อง (Context Area) -->
                <div class="md:w-1/3 bg-indigo-600 p-8 text-white flex flex-col justify-center">
                    <div class="mb-6">
                        <span class="text-indigo-200 text-xs font-bold uppercase tracking-widest">คุณกำลังจอง</span>
                        <h3 class="text-3xl font-black mt-1">{{ $room->name }}</h3>
                    </div>
                    <ul class="space-y-4 text-sm text-indigo-100">
                        <li class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            รองรับ {{ $room->capacity }} ที่นั่ง
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $room->description ?? 'ไม่มีรายละเอียดเพิ่มเติม' }}
                        </li>
                    </ul>
                </div>

                <!-- ส่วนขวา: ฟอร์มเลือกเวลา (Form Area) -->
                <div class="md:w-2/3 p-10 bg-white dark:bg-gray-800">
                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">

                        <div class="grid grid-cols-1 gap-6">
                            <!-- เวลาเริ่ม -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">ระบุเวลาที่เริ่มเข้าใช้ห้อง</label>
                                <div class="relative">
                                    <input type="text" id="start_time" name="start_time"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition shadow-sm dark:text-white"
                                        placeholder="เลือกวันและเวลาเริ่ม..." required>
                                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            </div>

                            <!-- เวลาสิ้นสุด -->
                            <div>
                                <label
                                    class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">ระบุเวลาที่สิ้นสุดการใช้งาน</label>
                                <div class="relative">
                                    <input type="text" id="end_time" name="end_time"
                                        class="w-full pl-10 pr-4 py-3 bg-gray-50 dark:bg-gray-900 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 transition shadow-sm dark:text-white"
                                        placeholder="เลือกวันและเวลาสิ้นสุด..." required>
                                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="p-3 bg-red-50 text-red-600 text-xs font-bold rounded-xl border border-red-100">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <div class="pt-4 flex flex-col gap-3">
                            <button type="submit"
                                class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-2xl shadow-xl shadow-indigo-200 dark:shadow-none transition-all transform hover:-translate-y-1">
                                ยืนยันคำขอจองห้อง
                            </button>
                            <a href="{{ route('dashboard') }}"
                                class="w-full py-3 text-center text-gray-500 font-bold hover:text-gray-700 transition">ยกเลิก</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ตั้งค่า Flatpickr
        const config = {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minDate: "today",
            locale: "th"
        };
        flatpickr("#start_time", config);
        flatpickr("#end_time", config);
    </script>
</x-app-layout>

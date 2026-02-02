<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                ระบบจองห้องเรียนและห้องประชุม
            </h2>
            <a href="{{ route('bookings.index') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold text-xs uppercase tracking-widest hover:bg-indigo-700 transition shadow-md">
                ดูปฏิทินการจองทั้งหมด
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- 1. แถบข้อมูลผู้ใช้งาน (User Info Bar) -->
            <div
                class="bg-white dark:bg-gray-800 p-5 rounded-2xl mb-8 flex items-center border border-gray-100 dark:border-gray-700 shadow-sm">
                <div
                    class="bg-indigo-100 dark:bg-indigo-900/40 p-3 rounded-xl text-indigo-600 dark:text-indigo-400 mr-5">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-indigo-500 uppercase tracking-widest mb-1">ข้อมูลผู้เข้าใช้งาน
                    </h3>
                    <p class="text-xl font-extrabold text-gray-900 dark:text-white flex items-center">
                        {{ auth()->user()->name }}
                        <span class="mx-3 text-gray-300 dark:text-gray-600 font-light">|</span>
                        <span class="text-gray-500 dark:text-gray-400">ID: {{ auth()->user()->id }}</span>
                    </p>
                </div>
            </div>

            <div class="mb-8 border-b dark:border-gray-700 pb-4">
                <h3 class="text-2xl font-black text-gray-800 dark:text-white italic">รายการห้องเรียนทั้งหมด</h3>
            </div>

            <!-- 2. รายการห้อง (Room Grid) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($rooms as $room)
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden">
                        <div class="p-6 flex-1">

                            <!-- ชื่อห้องและ Badge สถานะ -->
                            <div class="flex justify-between items-start mb-5">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white leading-tight">
                                    {{ $room->name }}</h4>

                                @if ($room->display_status === 'my_room')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        ●
                                        {{ $room->booking_status === 'approved' ? 'ห้องของคุณ (อนุมัติแล้ว)' : 'ห้องของคุณ (รออนุมัติ)' }}
                                    </span>
                                @elseif($room->display_status === 'occupied')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                        ● ถูกจองแล้ว
                                    </span>
                                @elseif($room->display_status === 'pending_others')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                        ● มีคนจองแล้ว (รออนุมัติ)
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        ● ว่าง
                                    </span>
                                @endif
                            </div>

                            <!-- รายละเอียดห้องพื้นฐาน -->
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 italic min-h-[40px]">
                                {{ $room->description ?? 'พร้อมสำหรับการใช้งาน' }}</p>

                            <!-- ข้อมูลการจอง (ถ้ามี) -->
                            @if ($room->display_status !== 'available')
                                <div
                                    class="mb-5 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
                                    <p
                                        class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase mb-2 tracking-widest">
                                        รายละเอียดผู้จองปัจจุบัน:</p>
                                    <div class="flex items-center mb-2">
                                        <div
                                            class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400 mr-2 text-xs font-bold uppercase">
                                            {{ substr($room->booked_by_name, 0, 1) }}
                                        </div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200">
                                            {{ $room->booked_by_name }} <span
                                                class="font-normal text-gray-400 ml-1">(ID:
                                                {{ $room->booked_by_id }})</span>
                                        </p>
                                    </div>
                                    <p
                                        class="text-xs text-indigo-600 dark:text-indigo-400 font-bold flex items-center mt-3">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($room->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($room->end_time)->format('H:i') }} น.
                                        <span
                                            class="ml-2 font-normal text-gray-400">({{ \Carbon\Carbon::parse($room->start_time)->format('d/m/Y') }})</span>
                                    </p>
                                </div>
                            @endif

                            <!-- ข้อมูลความจุ -->
                            <div class="flex items-center text-xs text-gray-400 mb-6">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                <span>รองรับได้: <strong>{{ $room->capacity }} ที่นั่ง</strong></span>
                            </div>
                        </div>

                        <!-- 3. ส่วนของปุ่มดำเนินการ (ล่างสุดของ Card) -->
                        <div class="px-6 pb-6 mt-auto">
                            @if ($room->display_status === 'available')
                                <a href="{{ route('bookings.create', $room->id) }}"
                                    class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 border border-transparent rounded-xl font-bold text-sm text-white uppercase tracking-widest hover:bg-blue-700 transition shadow-lg shadow-blue-200 dark:shadow-none">
                                    จองห้องนี้
                                </a>
                            @elseif($room->display_status === 'my_room')
                                <form action="{{ route('bookings.cancel', $room->booking_id) }}" method="POST"
                                    onsubmit="return confirm('ยืนยันการยกเลิกการจองนี้?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full py-3 bg-red-50 text-red-600 border border-red-100 rounded-xl font-bold text-sm hover:bg-red-100 transition">
                                        ยกเลิกการจองของคุณ
                                    </button>
                                </form>
                            @else
                                <div
                                    class="w-full py-3 bg-gray-50 dark:bg-gray-900/80 text-gray-400 rounded-xl font-bold text-sm text-center border border-gray-100 dark:border-gray-700 cursor-not-allowed">
                                    ไม่สามารถจองได้ในขณะนี้
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>

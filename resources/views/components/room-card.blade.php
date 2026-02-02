@props(['room'])

<div
    class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm hover:shadow-2xl transition-all duration-300 flex flex-col overflow-hidden group">
    <div class="p-6 flex-1">

        <!-- 1. ชื่อห้อง, ปุ่มรายละเอียด และ Badge สถานะ -->
        <div class="flex justify-between items-start mb-3">
            <h4 class="text-xl font-black text-gray-900 dark:text-white leading-tight flex items-center">
                {{ $room->name }}
                <!-- ปุ่ม/ลิงก์ รายละเอียดห้อง -->
                <a href="{{ route('rooms.show', $room->id) }}"
                    class="inline-flex items-center text-sm font-bold text-indigo-500 dark:text-indigo-400 hover:text-indigo-600 ml-3 transition-colors"
                    title="ดูรายละเอียดห้องเพิ่มเติม">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xs font-medium">รายละเอียด</span>
                </a>
            </h4>

            <!-- Badge สถานะ -->
            @if ($room->display_status === 'my_room')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border border-blue-200 dark:border-blue-800">
                    <span class="w-1.5 h-1.5 mr-1.5 bg-blue-500 rounded-full"></span>
                    {{ $room->booking_status === 'approved' ? 'ห้องของคุณ' : 'รออนุมัติ' }}
                </span>
            @elseif($room->display_status === 'occupied')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-200 dark:border-red-800">
                    <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full animate-pulse"></span>
                    ถูกจองแล้ว
                </span>
            @elseif($room->display_status === 'pending_others')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400 border border-gray-200 dark:border-gray-600">
                    <span class="w-1.5 h-1.5 mr-1.5 bg-gray-400 rounded-full animate-bounce"></span>
                    มีคนจองแล้ว
                </span>
            @elseif($room->display_status === 'maintenance')
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">
                    <span class="w-1.5 h-1.5 mr-1.5 bg-yellow-500 rounded-full"></span>
                    ปิดซ่อมบำรุง
                </span>
            @else
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                    <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                    ว่าง
                </span>
            @endif
        </div>

        <!-- 2. รายละเอียดการจอง/คำอธิบาย (โชว์เมื่อไม่ว่าง) -->
        @if ($room->display_status !== 'available')
            <div
                class="mb-5 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl border border-gray-100 dark:border-gray-700 transition-all">
                <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase mb-3 tracking-widest italic">
                    ข้อมูลการใช้งานปัจจุบัน:</p>

                <div class="flex items-center mb-3">
                    <div
                        class="w-9 h-9 rounded-full bg-white dark:bg-gray-800 flex items-center justify-center text-indigo-600 shadow-sm mr-3 text-xs font-black border border-gray-100 dark:border-gray-700">
                        {{ substr($room->booked_by_name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-800 dark:text-gray-200 leading-none mb-1">
                            {{ $room->booked_by_name }}
                        </p>
                        <p class="text-[10px] text-gray-400 font-medium">ID: {{ $room->booked_by_id }}</p>
                    </div>
                </div>

                <div
                    class="flex items-center text-xs text-indigo-600 dark:text-indigo-400 font-bold bg-white dark:bg-gray-800 px-3 py-2 rounded-lg inline-flex">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ \Carbon\Carbon::parse($room->start_time)->format('H:i') }} -
                    {{ \Carbon\Carbon::parse($room->end_time)->format('H:i') }} น.
                    <span
                        class="ml-2 font-normal text-gray-400">({{ \Carbon\Carbon::parse($room->start_time)->format('d/m/Y') }})</span>
                </div>
            </div>
        @else
            <!-- ถ้าห้องว่าง แสดงรายละเอียดห้อง -->
            <div class="mb-5 min-h-[90px]">
                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed italic">
                    {{ $room->description ?? 'ห้องว่าง พร้อมสำหรับการเข้าใช้งาน สามารถกดจองได้ทันที' }}
                </p>
            </div>
        @endif

        <!-- ข้อมูลความจุ -->
        <div class="flex items-center text-[11px] text-gray-400 mb-6 px-1">
            <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            รองรับได้: <strong class="ml-1 text-gray-700 dark:text-gray-300">{{ $room->capacity }} ที่นั่ง</strong>
        </div>
    </div>

    <!-- 3. ส่วนของปุ่มดำเนินการ -->
    <div class="px-6 pb-6 mt-auto">
        @if ($room->display_status === 'available')
            <a href="{{ route('bookings.create', $room->id) }}"
                class="w-full inline-flex justify-center items-center px-4 py-3.5 bg-indigo-600 text-white rounded-2xl font-black text-xs uppercase transition shadow-lg shadow-indigo-100 hover:bg-indigo-700 transform active:scale-95">
                จองห้องนี้
            </a>
        @elseif($room->display_status === 'my_room')
            <button type="button"
                @click="openModal = true; cancelUrl = '{{ route('bookings.cancel', $room->booking_id) }}'; roomName = '{{ $room->name }}'"
                class="w-full py-3.5 bg-red-50 text-red-600 border border-red-100 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-red-100 transition shadow-sm">
                ยกเลิกการจองของคุณ
            </button>
        @elseif($room->display_status === 'maintenance')
            <div
                class="w-full py-3.5 bg-yellow-50 text-yellow-800 rounded-2xl font-black text-xs uppercase tracking-widest text-center border border-yellow-100 cursor-not-allowed">
                ปิดซ่อมบำรุง
            </div>
        @else
            <div
                class="w-full py-3.5 bg-gray-50 dark:bg-gray-900/80 text-gray-400 rounded-2xl font-black text-xs uppercase tracking-widest text-center border border-gray-100 dark:border-gray-700 cursor-not-allowed">
                ไม่สามารถจองได้ในขณะนี้
            </div>
        @endif
    </div>
</div>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            ระบบจองห้องเรียน (Calendar View)
        </h2>
    </x-slot>

    <!-- Load FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <!-- ฝั่งซ้าย: ฟอร์มจองห้อง -->
                <div class="md:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-4 dark:text-white">จองห้องใหม่</h3>
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm dark:text-gray-300">เลือกห้อง</label>
                            <select name="room_id"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" required>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }} ({{ $room->capacity }}
                                        ที่นั่ง)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm dark:text-gray-300">เริ่ม</label>
                            <input type="datetime-local" name="start_time"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm dark:text-gray-300">สิ้นสุด</label>
                            <input type="datetime-local" name="end_time"
                                class="w-full rounded-md border-gray-300 dark:bg-gray-700 dark:text-white" required>
                        </div>
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">ยืนยันการจอง</button>
                    </form>

                    @if ($errors->any())
                        <p class="mt-4 text-red-500 text-sm">{{ $errors->first() }}</p>
                    @endif
                </div>

                <!-- ฝั่งขวา: ปฏิทิน -->
                <div class="md:col-span-3 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <div id="calendar" class="dark:text-white"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek', // แสดงเป็นรายสัปดาห์ (เหมือน Google Calendar)
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'th',
                events: "{{ route('bookings.events') }}", // ดึงข้อมูลจาก Controller
                slotMinTime: '08:00:00', // เริ่ม 8 โมง
                slotMaxTime: '20:00:00', // สิ้นสุด 2 ทุ่ม
                eventClick: function(info) {
                    alert('การจอง: ' + info.event.title + '\nเริ่ม: ' + info.event.start
                        .toLocaleString());
                }
            });
            calendar.render();
        });
    </script>

    <style>
        .fc-event {
            cursor: pointer;
        }

        .dark .fc-theme-standard td,
        .dark .fc-theme-standard th {
            border-color: #374151;
        }
    </style>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    📅 ระบบจองห้องเรียน
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">เลือกห้องและเวลาที่คุณต้องการจอง</p>
            </div>
        </div>
    </x-slot>

    <!-- Load FullCalendar CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Main Container -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- ฝั่งซ้าย: ฟอร์มจองห้อง -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 p-8 rounded-2xl shadow-lg border border-blue-100 dark:border-gray-600 sticky top-24">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-3 bg-indigo-600 rounded-xl">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">จองห้องใหม่</h3>
                        </div>

                        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-5">
                            @csrf

                            <!-- เลือกห้อง -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                    🏛️ เลือกห้อง
                                </label>
                                <select name="room_id"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:outline-none transition-colors bg-white"
                                    required>
                                    <option value="">-- เลือกห้องเรียน --</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">{{ $room->name }} (🪑 {{ $room->capacity }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- วันที่ -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
                                    📅 เลือกวันที่
                                </label>
                                <input type="date" id="booking_date" name="booking_date"
                                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:outline-none transition-colors"
                                    required>
                            </div>

                            <!-- เวลาเริ่ม -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">
                                    🕐 เวลาเริ่ม
                                </label>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <input type="number" id="start_hour" min="8" max="19" value="8" 
                                            class="w-20 px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:outline-none text-center font-semibold">
                                        <span class="text-gray-600 dark:text-gray-300 font-bold">:</span>
                                        <input type="number" id="start_minute" min="0" max="59" value="0" step="15"
                                            class="w-20 px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:outline-none text-center font-semibold">
                                        <span class="text-gray-600 dark:text-gray-300">น.</span>
                                    </div>
                                    <!-- Quick select buttons -->
                                    <div class="grid grid-cols-3 gap-2">
                                        <button type="button" onclick="setStartTime(8, 0)" class="time-btn text-xs py-1 px-2 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-indigo-500 dark:hover:bg-indigo-600 hover:text-white transition">08:00</button>
                                        <button type="button" onclick="setStartTime(9, 0)" class="time-btn text-xs py-1 px-2 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-indigo-500 dark:hover:bg-indigo-600 hover:text-white transition">09:00</button>
                                        <button type="button" onclick="setStartTime(10, 0)" class="time-btn text-xs py-1 px-2 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-indigo-500 dark:hover:bg-indigo-600 hover:text-white transition">10:00</button>
                                        <button type="button" onclick="setStartTime(13, 0)" class="time-btn text-xs py-1 px-2 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-indigo-500 dark:hover:bg-indigo-600 hover:text-white transition">13:00</button>
                                        <button type="button" onclick="setStartTime(14, 0)" class="time-btn text-xs py-1 px-2 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-indigo-500 dark:hover:bg-indigo-600 hover:text-white transition">14:00</button>
                                        <button type="button" onclick="setStartTime(15, 0)" class="time-btn text-xs py-1 px-2 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-indigo-500 dark:hover:bg-indigo-600 hover:text-white transition">15:00</button>
                                    </div>
                                </div>
                            </div>

                            <!-- เวลาสิ้นสุด -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">
                                    🕑 เวลาสิ้นสุด
                                </label>
                                <div class="space-y-3">
                                    <div class="flex items-center gap-2">
                                        <input type="number" id="end_hour" min="8" max="20" value="9" 
                                            class="w-20 px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:outline-none text-center font-semibold">
                                        <span class="text-gray-600 dark:text-gray-300 font-bold">:</span>
                                        <input type="number" id="end_minute" min="0" max="59" value="0" step="15"
                                            class="w-20 px-3 py-2 rounded-lg border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:outline-none text-center font-semibold">
                                        <span class="text-gray-600 dark:text-gray-300">น.</span>
                                    </div>
                                    <!-- Duration options -->
                                    <div class="grid grid-cols-4 gap-1">
                                        <button type="button" onclick="setDuration(1)" class="time-btn text-xs py-1 px-1 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-blue-500 dark:hover:bg-blue-600 hover:text-white transition">1 ชม</button>
                                        <button type="button" onclick="setDuration(2)" class="time-btn text-xs py-1 px-1 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-blue-500 dark:hover:bg-blue-600 hover:text-white transition">2 ชม</button>
                                        <button type="button" onclick="setDuration(3)" class="time-btn text-xs py-1 px-1 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-blue-500 dark:hover:bg-blue-600 hover:text-white transition">3 ชม</button>
                                        <button type="button" onclick="setDuration(4)" class="time-btn text-xs py-1 px-1 rounded-lg bg-gray-200 dark:bg-gray-600 hover:bg-blue-500 dark:hover:bg-blue-600 hover:text-white transition">4 ชม</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden inputs for form submission -->
                            <input type="hidden" id="start_time" name="start_time" required>
                            <input type="hidden" id="end_time" name="end_time" required>

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full mt-6 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-semibold py-3 rounded-xl hover:from-indigo-700 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                ยืนยันการจอง
                            </button>
                        </form>

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="mt-4 p-4 bg-red-100 dark:bg-red-900 border-l-4 border-red-500 rounded-lg">
                                <p class="text-red-700 dark:text-red-200 text-sm font-semibold">
                                    ⚠️ {{ $errors->first() }}
                                </p>
                            </div>
                        @endif

                        <!-- Info Box -->
                        <div class="mt-6 p-4 bg-blue-100 dark:bg-blue-900/30 border border-blue-300 dark:border-blue-700 rounded-xl">
                            <p class="text-xs text-blue-700 dark:text-blue-300">
                                💡 <strong>เคล็ดลับ:</strong> คลิกบนปฏิทินเพื่อดูรายละเอียดการจองที่มีอยู่
                            </p>
                        </div>
                    </div>
                </div>

                <!-- ฝั่งขวา: ปฏิทิน -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700">
                        <div id="calendar" class="fc-modern dark:text-white"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script>
        // Time picker functions
        function setStartTime(hour, minute) {
            document.getElementById('start_hour').value = hour;
            document.getElementById('start_minute').value = String(minute).padStart(2, '0');
            autoSetEndTime();
        }

        function setDuration(hours) {
            const startHour = parseInt(document.getElementById('start_hour').value);
            const startMin = parseInt(document.getElementById('start_minute').value);
            let endHour = startHour + hours;
            
            if (endHour > 20) endHour = 20;
            document.getElementById('end_hour').value = endHour;
            document.getElementById('end_minute').value = startMin;
        }

        function autoSetEndTime() {
            const startHour = parseInt(document.getElementById('start_hour').value);
            let endHour = startHour + 1;
            if (endHour > 20) endHour = 20;
            document.getElementById('end_hour').value = endHour;
        }

        // Format time inputs (ensure 2 digits)
        function formatTimeInput(elem) {
            let val = parseInt(elem.value) || 0;
            if (elem.id.includes('minute')) {
                val = Math.max(0, Math.min(59, val));
                val = Math.round(val / 15) * 15; // Round to nearest 15 minutes
            } else {
                const min = parseInt(elem.getAttribute('min'));
                const max = parseInt(elem.getAttribute('max'));
                val = Math.max(min, Math.min(max, val));
            }
            elem.value = String(val).padStart(2, '0');
        }

        // Update hidden inputs for form submission
        function updateFormInputs() {
            const date = document.getElementById('booking_date').value;
            const startHour = String(parseInt(document.getElementById('start_hour').value)).padStart(2, '0');
            const startMin = String(parseInt(document.getElementById('start_minute').value)).padStart(2, '0');
            const endHour = String(parseInt(document.getElementById('end_hour').value)).padStart(2, '0');
            const endMin = String(parseInt(document.getElementById('end_minute').value)).padStart(2, '0');

            if (date) {
                document.getElementById('start_time').value = `${date}T${startHour}:${startMin}`;
                document.getElementById('end_time').value = `${date}T${endHour}:${endMin}`;
            }
        }

        // Set today as default date
        window.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const dateStr = today.toISOString().split('T')[0];
            document.getElementById('booking_date').value = dateStr;

            // Add event listeners
            document.getElementById('start_hour').addEventListener('change', formatTimeInput);
            document.getElementById('start_minute').addEventListener('change', function() {
                formatTimeInput(this);
                autoSetEndTime();
            });
            document.getElementById('end_hour').addEventListener('change', formatTimeInput);
            document.getElementById('end_minute').addEventListener('change', formatTimeInput);
            document.getElementById('booking_date').addEventListener('change', updateFormInputs);

            document.getElementById('start_hour').addEventListener('blur', function() {
                formatTimeInput(this);
                autoSetEndTime();
                updateFormInputs();
            });
            document.getElementById('start_minute').addEventListener('blur', function() {
                formatTimeInput(this);
                autoSetEndTime();
                updateFormInputs();
            });
            document.getElementById('end_hour').addEventListener('blur', function() {
                formatTimeInput(this);
                updateFormInputs();
            });
            document.getElementById('end_minute').addEventListener('blur', function() {
                formatTimeInput(this);
                updateFormInputs();
            });

            // Initial form update
            updateFormInputs();
        });

        // Override form submit to ensure values are updated
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    updateFormInputs();
                });
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'th',
                events: "{{ route('bookings.events') }}",
                slotMinTime: '08:00:00',
                slotMaxTime: '20:00:00',
                slotDuration: '01:00:00',
                slotLabelInterval: '01:00',
                businessHours: {
                    daysOfWeek: [1, 2, 3, 4, 5],
                    startTime: '08:00',
                    endTime: '17:00',
                },
                
                // Enhanced Event Styling
                eventDidMount: function(info) {
                    info.el.style.borderRadius = '8px';
                    info.el.style.padding = '8px';
                    info.el.style.fontSize = '13px';
                    info.el.style.fontWeight = '600';
                    info.el.style.border = 'none';
                    info.el.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                    info.el.style.transition = 'all 0.3s ease';
                    
                    // Add hover effect
                    info.el.addEventListener('mouseenter', function() {
                        this.style.boxShadow = '0 4px 16px rgba(0,0,0,0.2)';
                        this.style.transform = 'translateY(-2px)';
                    });
                    
                    info.el.addEventListener('mouseleave', function() {
                        this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
                        this.style.transform = 'translateY(0)';
                    });
                },
                
                // Event Click Handler - Show detailed modal
                eventClick: function(info) {
                    showEventModal(info.event);
                },
                
                // Date Click Handler - Pre-fill form
                dateClick: function(info) {
                    document.getElementById('booking_date').value = info.dateStr;
                    setStartTime(8, 0);
                    setDuration(1);
                    updateFormInputs();
                    
                    // Scroll to form
                    document.querySelector('form').scrollIntoView({ behavior: 'smooth', block: 'start' });
                },
                
                // View Changed
                datesSet: function(info) {
                    console.log('Calendar view changed');
                }
            });
            
            calendar.render();
        });

        // Helper function to format date for input
        function formatDateForInput(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        // Modal for Event Details
        function showEventModal(event) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4 animate-fadeIn';
            
            const startDate = new Date(event.start).toLocaleString('th-TH', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const endDate = new Date(event.end).toLocaleString('th-TH', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            const duration = Math.round((new Date(event.end) - new Date(event.start)) / 60000);
            
            modal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full overflow-hidden animate-slideUp">
                    <div class="bg-gradient-to-r from-indigo-600 to-blue-600 p-6 text-white">
                        <h2 class="text-2xl font-bold">📌 ${event.title}</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">🕐</span>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">เวลาเริ่ม</p>
                                <p class="font-semibold text-gray-900 dark:text-white">${startDate}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">⏱️</span>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">ระยะเวลา</p>
                                <p class="font-semibold text-gray-900 dark:text-white">${duration} นาที</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="text-2xl">🕑</span>
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">เวลาสิ้นสุด</p>
                                <p class="font-semibold text-gray-900 dark:text-white">${endDate}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-700 p-4 flex gap-3">
                        <button onclick="this.closest('.fixed').remove()" class="flex-1 px-4 py-2 rounded-lg border-2 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-semibold hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors">
                            ปิด
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(modal);
            
            // Close on outside click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.remove();
                }
            });
        }
    </script>

    <style>
        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease;
        }

        .animate-slideUp {
            animation: slideUp 0.3s ease;
        }

        /* Time Input Styling */
        input[type="number"] {
            appearance: textfield;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            appearance: none;
            margin: 0;
        }

        input[type="number"]:focus {
            background-color: #f0f9ff;
        }

        .dark input[type="number"]:focus {
            background-color: #1e3a8a;
        }

        /* Time Button Styling */
        .time-btn {
            font-weight: 600;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .time-btn:active {
            transform: scale(0.95);
        }

        /* FullCalendar Custom Styling */
        .fc {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .fc .fc-button-primary {
            background-color: #4f46e5;
            border-color: #4f46e5;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .fc .fc-button-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        .fc .fc-button-primary.fc-button-active {
            background-color: #4338ca;
            border-color: #4338ca;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        .fc .fc-button-primary:focus {
            box-shadow: none;
        }

        .fc .fc-col-header-cell {
            background-color: #f8fafc;
            color: #1e293b;
            font-weight: 700;
            padding: 12px 0;
            border: none;
        }

        .dark .fc .fc-col-header-cell {
            background-color: #1f2937;
            color: #f1f5f9;
        }

        .fc .fc-daygrid-day {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .fc .fc-daygrid-day:hover {
            background-color: #f0f9ff;
            box-shadow: inset 0 0 0 2px #e0e7ff;
        }

        .dark .fc .fc-daygrid-day {
            background-color: #1f2937;
            border-color: #374151;
        }

        .dark .fc .fc-daygrid-day:hover {
            background-color: #111827;
            box-shadow: inset 0 0 0 2px #3b82f6;
        }

        .fc .fc-daygrid-day.fc-day-other {
            background-color: #f9fafb;
            opacity: 0.7;
        }

        .dark .fc .fc-daygrid-day.fc-day-other {
            background-color: #111827;
            opacity: 0.7;
        }

        .fc .fc-daygrid-day-frame {
            min-height: 100px;
        }

        .fc .fc-event {
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .fc-event-title {
            font-weight: 700;
            padding: 4px 0;
        }

        .fc-event-time {
            font-weight: 600;
            font-size: 12px;
        }

        .fc .fc-daygrid-day-number {
            padding: 8px;
            font-weight: 600;
        }

        .fc .fc-timegrid-slot {
            height: 3em;
        }

        .fc .fc-col-time-cell {
            vertical-align: middle;
        }

        .fc .fc-timegrid-now-indicator-arrow {
            border-color: #ef4444;
            width: 8px;
        }

        .fc .fc-timegrid-now-indicator-line {
            border-color: #ef4444;
            height: 2px;
        }

        .fc .fc-theme-standard td,
        .fc .fc-theme-standard th {
            border-color: #e2e8f0;
        }

        .dark .fc .fc-theme-standard td,
        .dark .fc .fc-theme-standard th {
            border-color: #374151;
        }

        /* Business hours styling */
        .fc .fc-timegrid-slot.fc-col-disabled {
            background-color: rgba(15, 23, 42, 0.02);
        }

        .dark .fc .fc-timegrid-slot.fc-col-disabled {
            background-color: rgba(0, 0, 0, 0.2);
        }

        /* Toolbar styling */
        .fc .fc-toolbar {
            padding: 16px;
            gap: 16px;
        }

        .fc .fc-toolbar-title {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }

        .dark .fc .fc-toolbar-title {
            color: #f1f5f9;
        }

        .fc .fc-button-group {
            gap: 8px;
        }

        .fc .fc-button {
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .fc .fc-toolbar {
                flex-direction: column;
                padding: 12px;
            }

            .fc .fc-toolbar-title {
                font-size: 18px;
            }

            .fc .fc-button-group {
                flex-wrap: wrap;
            }

            .fc .fc-daygrid-day-frame {
                min-height: 80px;
            }
        }
    </style>
</x-app-layout>

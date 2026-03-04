<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
            📊 สถิติการใช้งานห้อง
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">วิเคราะห์การใช้งานห้องเรียนและห้องประชุม</p>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">ห้องทั้งหมด</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $roomUsageData->count() }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">การจองทั้งหมด</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $roomUsageData->sum('booking_count') }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">ห้องที่ใช้งานมากที่สุด</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $roomUsageData->first()->room->name ?? 'N/A' }}</p>
                        </div>
                        <div
                            class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Bar Chart: Room Usage -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📊 ห้องที่ถูกใช้งานมากที่สุด</h3>
                    <div class="h-80">
                        <canvas id="roomUsageChart"></canvas>
                    </div>
                </div>

                <!-- Line Chart: Booking Trend -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📈 แนวโน้มการจอง (30 วันล่าสุด)
                    </h3>
                    <div class="h-80">
                        <canvas id="bookingTrendChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Download PDF Report -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📄 รายงานการจอง</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">ดาวน์โหลดรายงานการจองในรูปแบบ PDF</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('admin.pdf.report') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        ดาวน์โหลด PDF Report
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        กลับสู่ Dashboard
                    </a>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // ===== DEBUG LOG =====
            const roomLabels = @json($roomLabels);
            const roomCounts = @json($roomCounts);
            const dateLabels = @json($bookingByDate->pluck('date'));
            const dateCounts = @json($bookingByDate->pluck('count'));

            console.log('=== ANALYTICS DEBUG ===');
            console.log('roomLabels:', roomLabels);
            console.log('roomCounts:', roomCounts);
            console.log('dateLabels:', dateLabels);
            console.log('dateCounts:', dateCounts);
            console.log('======================');

            // ===== Bar Chart: Room Usage =====
            const roomUsageCtx = document.getElementById('roomUsageChart').getContext('2d');
            const roomUsageChart = new Chart(roomUsageCtx, {
                type: 'bar',
                data: {
                    labels: roomLabels,
                    datasets: [{
                        label: 'จำนวนการจอง',
                        data: roomCounts,
                        backgroundColor: 'rgba(59, 130, 246, 0.8)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // ===== Line Chart: Booking Trend =====
            const bookingTrendCtx = document.getElementById('bookingTrendChart').getContext('2d');
            const bookingTrendChart = new Chart(bookingTrendCtx, {
                type: 'line',
                data: {
                    labels: dateLabels,
                    datasets: [{
                        label: 'การจองต่อวัน',
                        data: dateCounts,
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>

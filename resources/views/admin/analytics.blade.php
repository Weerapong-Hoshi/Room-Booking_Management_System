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
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
                                {{ $roomUsageData->count() }}</p>
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
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
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
                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-1">
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

            <!-- Charts Row 1 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">📊 ห้องที่ถูกใช้งานมากที่สุด</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">เรียงตามจำนวนการจองที่อนุมัติแล้ว</p>
                    <div id="roomUsageChart"></div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">📈 แนวโน้มการจอง (30 วันล่าสุด)
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">สามารถ Zoom เพื่อดูรายละเอียดได้</p>
                    <div id="bookingTrendChart"></div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">🍩 สัดส่วนการใช้งานห้อง</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">เปรียบเทียบสัดส่วนการจองแต่ละห้อง</p>
                    <div id="donutChart"></div>
                </div>

                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg border border-gray-100 dark:border-gray-700 flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">📄 รายงานการจอง</h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">ดาวน์โหลดรายงานสรุปการจองห้องในรูปแบบ PDF</p>
                        <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-2 mb-6">
                            <li>✅ รายการจองทั้งหมดที่อนุมัติแล้ว</li>
                            <li>✅ เรียงตามวันที่จองล่าสุด</li>
                            <li>✅ รองรับภาษาไทย</li>
                        </ul>
                    </div>
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
    </div>

    @push('scripts')
        <script>
            // ✅ รอให้ Vite (type="module") โหลด window.ApexCharts ก่อน
            document.addEventListener('DOMContentLoaded', function() {

                const roomLabels = @json($roomLabels);
                const roomCounts = @json($roomCounts);
                const dateLabels = @json($bookingByDate->pluck('date'));
                const dateCounts = @json($bookingByDate->pluck('count'));

                const isDark = document.documentElement.classList.contains('dark');
                const textColor = isDark ? '#94a3b8' : '#64748b';
                const gridColor = isDark ? '#334155' : '#e2e8f0';

                // ===== Bar Chart =====
                new ApexCharts(document.getElementById('roomUsageChart'), {
                    chart: {
                        type: 'bar',
                        height: 320,
                        foreColor: textColor,
                        background: 'transparent',
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    series: [{
                        name: 'จำนวนการจอง',
                        data: roomCounts
                    }],
                    xaxis: {
                        categories: roomLabels,
                        labels: {
                            style: {
                                colors: textColor,
                                fontSize: '12px'
                            }
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: textColor
                            }
                        }
                    },
                    colors: ['#3b82f6'],
                    plotOptions: {
                        bar: {
                            borderRadius: 8,
                            columnWidth: '50%',
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            colors: [textColor],
                            fontSize: '12px'
                        },
                        offsetY: -20
                    },
                    grid: {
                        borderColor: gridColor,
                        strokeDashArray: 4
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'light',
                            type: 'vertical',
                            shadeIntensity: 0.4,
                            gradientToColors: ['#60a5fa'],
                            stops: [0, 100]
                        }
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        y: {
                            formatter: val => val + ' ครั้ง'
                        }
                    }
                }).render();

                // ===== Area Chart =====
                new ApexCharts(document.getElementById('bookingTrendChart'), {
                    chart: {
                        type: 'area',
                        height: 320,
                        foreColor: textColor,
                        background: 'transparent',
                        toolbar: {
                            show: true,
                            tools: {
                                zoom: true,
                                zoomin: true,
                                zoomout: true,
                                reset: true,
                                pan: true,
                                download: false
                            }
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    series: [{
                        name: 'การจองต่อวัน',
                        data: dateCounts
                    }],
                    xaxis: {
                        categories: dateLabels,
                        labels: {
                            style: {
                                colors: textColor,
                                fontSize: '11px'
                            },
                            rotate: -30
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    yaxis: {
                        min: 0,
                        labels: {
                            style: {
                                colors: textColor
                            }
                        }
                    },
                    colors: ['#10b981'],
                    stroke: {
                        curve: 'smooth',
                        width: 3
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [0, 100]
                        }
                    },
                    markers: {
                        size: 5,
                        colors: ['#10b981'],
                        strokeColors: isDark ? '#1f2937' : '#ffffff',
                        strokeWidth: 2,
                        hover: {
                            size: 7
                        }
                    },
                    grid: {
                        borderColor: gridColor,
                        strokeDashArray: 4
                    },
                    dataLabels: {
                        enabled: false
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        y: {
                            formatter: val => val + ' ครั้ง'
                        }
                    }
                }).render();

                // ===== Donut Chart =====
                new ApexCharts(document.getElementById('donutChart'), {
                    chart: {
                        type: 'donut',
                        height: 320,
                        foreColor: textColor,
                        background: 'transparent',
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    series: roomCounts,
                    labels: roomLabels,
                    colors: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'],
                    legend: {
                        position: 'bottom',
                        labels: {
                            colors: textColor
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'ทั้งหมด',
                                        color: textColor,
                                        formatter: w => w.globals.seriesTotals.reduce((a, b) => a + b, 0) +
                                            ' ครั้ง'
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        formatter: val => Math.round(val) + '%'
                    },
                    tooltip: {
                        theme: isDark ? 'dark' : 'light',
                        y: {
                            formatter: val => val + ' ครั้ง'
                        }
                    }
                }).render();

            });
        </script>
    @endpush
</x-app-layout>

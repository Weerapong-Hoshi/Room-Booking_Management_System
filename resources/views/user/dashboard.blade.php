<x-app-layout>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

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

            <!-- 2. ส่วนของรายการห้องและ Modal -->
            <div x-data="{ openModal: false, cancelUrl: '', roomName: '' }">

                <!-- Grid รายการห้อง (ใช้ Component ที่สร้างไว้แล้ว) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($rooms as $room)
                        <x-room-card :room="$room" />
                    @endforeach
                </div>

                <!-- --- หน้าต่างยืนยัน (Confirmation Modal Panel) --- -->
                <div x-show="openModal" class="fixed inset-0 z-[60] overflow-y-auto" x-cloak>
                    <div
                        class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                        <div @click="openModal = false" x-show="openModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm" aria-hidden="true">
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                            aria-hidden="true">&#8203;</span>

                        <div x-show="openModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            class="inline-block w-full max-w-sm p-8 overflow-hidden text-left align-bottom transition-all transform bg-white dark:bg-gray-800 rounded-[2.5rem] shadow-2xl sm:my-8 sm:align-middle">
                            <div class="text-center">
                                <div
                                    class="flex items-center justify-center w-20 h-20 mx-auto bg-red-50 dark:bg-red-900/20 rounded-3xl mb-6">
                                    <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-black text-gray-900 dark:text-white mb-2">ยกเลิกการจอง?</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 px-2">คุณต้องการยกเลิกการจองห้อง
                                    <span class="font-bold text-gray-900 dark:text-white" x-text="roomName"></span>
                                    ใช่หรือไม่?
                                </p>
                            </div>
                            <div class="mt-8 flex flex-col gap-3">
                                <form :action="cancelUrl" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                        class="w-full py-4 bg-red-600 text-white font-black rounded-2xl shadow-lg transition transform active:scale-95">ยืนยันการยกเลิก</button>
                                </form>
                                <button @click="openModal = false"
                                    class="w-full py-3 text-sm font-bold text-gray-400 hover:text-gray-600 transition">กลับไปก่อน</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

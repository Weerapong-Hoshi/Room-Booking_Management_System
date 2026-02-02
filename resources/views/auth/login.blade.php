<x-guest-layout>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 px-4">

        <!-- ส่วนหัว/Logo -->
        <div class="mb-8 text-center">
            <div class="bg-indigo-600 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto shadow-lg mb-4">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011-1v5m-4 0h4">
                    </path>
                </svg>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                Room Booking System
            </h1>
            <p class="text-gray-500 dark:text-gray-400 mt-2 text-lg">ระบบจองห้องเรียนและห้องประชุมออนไลน์</p>
        </div>

        <!-- กล่อง Login -->
        <div
            class="w-full sm:max-w-md px-8 py-10 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-3xl border border-gray-100 dark:border-gray-700">

            <!-- แสดงข้อความสถานะ (ถ้ามี) -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        อีเมลนักศึกษา / บุคลากร
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all"
                        placeholder="ชื่อผู้ใช้@example.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        รหัสผ่าน
                    </label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm transition-all"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-8">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">จดจำฉันไว้ในระบบ</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                            class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 font-medium">
                            ลืมรหัสผ่าน?
                        </a>
                    @endif
                </div>

                <!-- ปุ่ม Login -->
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg transform transition hover:-translate-y-1 active:scale-95 duration-200">
                    เข้าสู่ระบบ
                </button>

                <!-- ลิงก์สมัครสมาชิก -->
                <div class="mt-8 text-center border-t border-gray-100 dark:border-gray-700 pt-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        ยังไม่มีบัญชีใช้งาน?
                        <a href="{{ route('register') }}"
                            class="font-bold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 ml-1">
                            สมัครสมาชิกใหม่ที่นี่
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <p class="mt-8 text-sm text-gray-400 dark:text-gray-500">
            © 2026 University Room Booking Project
        </p>
    </div>
    </div>
</x-guest-layout>

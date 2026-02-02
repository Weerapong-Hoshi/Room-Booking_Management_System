<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-white leading-tight">
            ✏️ แก้ไขข้อมูลผู้ใช้
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8 border border-gray-200 dark:border-gray-700">

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Profile Image -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-3">
                            🖼️ รูปโปรไฟล์
                        </label>
                        <div class="flex items-center gap-4">
                            <div id="preview"
                                class="w-24 h-24 rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-bold text-3xl border-4 border-indigo-200 dark:border-indigo-700 overflow-hidden">
                                @if ($user->profile_image)
                                    <img src="{{ asset('storage/' . $user->profile_image) }}"
                                        class="w-full h-full object-cover">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                            <input type="file" id="profile_image" name="profile_image" accept="image/*"
                                class="block w-full text-sm text-gray-600 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-100 dark:file:bg-indigo-900/30
                                file:text-indigo-700 dark:file:text-indigo-300
                                hover:file:bg-indigo-200 dark:hover:file:bg-indigo-900/50
                                cursor-pointer">
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                            👤 ชื่อผู้ใช้
                        </label>
                        <input type="text" name="name"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:outline-none transition-colors"
                            placeholder="กรอกชื่อผู้ใช้" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                            📧 อีเมล
                        </label>
                        <input type="email" name="email"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:outline-none transition-colors"
                            placeholder="กรอกอีเมล" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                            🔖 ยศ
                        </label>
                        <select name="role"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-indigo-500 focus:outline-none transition-colors"
                            required>
                            <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>👤 ผู้ใช้ทั่วไป
                            </option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>🔑 ผู้ดูแลระบบ
                            </option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Info Box -->
                    <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl">
                        <p class="text-sm text-blue-900 dark:text-blue-200">
                            💡 <strong>หมายเหตุ:</strong> รหัสผ่านปัจจุบันจะไม่เปลี่ยนแปลง หากต้องการเปลี่ยนให้ผู้ใช้แก้ไขจากหน้า Profile ของตนเอง
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-4">
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-indigo-600 to-blue-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-blue-700 shadow-lg transition-all duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            บันทึกการเปลี่ยนแปลง
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                            class="flex-1 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white font-bold rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            ยกเลิก
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        document.getElementById('profile_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML =
                        `<img src="${event.target.result}" class="w-full h-full object-cover">`;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>

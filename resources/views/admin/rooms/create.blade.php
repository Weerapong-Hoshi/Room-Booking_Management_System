<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            เพิ่มห้องเรียน/ห้องประชุมใหม่
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border dark:border-gray-700">

                <!-- ฟอร์มส่งข้อมูลไปยัง AdminController::storeRoom -->
                <form method="POST" action="{{ route('admin.rooms.store') }}" class="space-y-6" enctype="multipart/form-data">
                    @csrf

                    <!-- ชื่อห้อง -->
                    <div>
                        <label for="name"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">ชื่อห้อง (เช่น IT 101,
                            ห้องประชุมใหญ่)</label>
                        <input id="name" name="name" type="text" required
                            class="w-full px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                            value="{{ old('name') }}" placeholder="เช่น Meeting Room A">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ความจุ -->
                    <div>
                        <label for="capacity"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">ความจุ
                            (จำนวนคน)</label>
                        <input id="capacity" name="capacity" type="number" required min="1"
                            class="w-full px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('capacity') border-red-500 @enderror"
                            value="{{ old('capacity') }}" placeholder="เช่น 30">
                        @error('capacity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- สถานะ -->
                    <div>
                        <label for="status"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">สถานะเริ่มต้น</label>
                        <select id="status" name="status" required
                            class="w-full px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>พร้อมใช้งาน
                            </option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                ปิดซ่อมบำรุง</option>
                        </select>
                    </div>

                    <!-- รูปภาพห้อง (อัปโหลดไฟล์) -->
                    <div>
                        <label for="image" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">รูปภาพห้อง (อัปโหลด)</label>
                        <input id="image" name="image" type="file" accept="image/*"
                            class="w-full px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('image') border-red-500 @enderror">
                        <p class="text-xs text-gray-400 mt-1">แนะนำขนาดไม่เกิน 2MB</p>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- คำอธิบาย -->
                    <div>
                        <label for="description"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">คำอธิบายห้อง</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror"
                            placeholder="รายละเอียดของห้อง เช่น มีโปรเจคเตอร์, ไม่มีแอร์">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-3 pt-4">
                        <a href="{{ route('admin.rooms.index') }}"
                            class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            ยกเลิก
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            บันทึกห้องใหม่
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            แก้ไขข้อมูลห้อง: {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8 border dark:border-gray-700">

                <!-- ฟอร์มส่งข้อมูลไปยัง AdminController::updateRoom -->
                <form method="POST" action="{{ route('admin.rooms.update', $room->id) }}" class="space-y-6">
                    @csrf
                    @method('PATCH') <!-- ต้องระบุ method เป็น PATCH สำหรับการอัปเดต -->

                    <!-- ชื่อห้อง -->
                    <div>
                        <label for="name"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">ชื่อห้อง (เช่น IT 101,
                            ห้องประชุมใหญ่)</label>
                        <input id="name" name="name" type="text" required
                            class="w-full px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                            value="{{ old('name', $room->name) }}" placeholder="เช่น Meeting Room A">
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
                            value="{{ old('capacity', $room->capacity) }}" placeholder="เช่น 30">
                        @error('capacity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- สถานะ -->
                    <div>
                        <label for="status"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">สถานะห้อง</label>
                        <select id="status" name="status" required
                            class="w-full px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="available"
                                {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>พร้อมใช้งาน</option>
                            <option value="maintenance"
                                {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>ปิดซ่อมบำรุง
                            </option>
                        </select>
                    </div>

                    <!-- URL รูปภาพ (Optional) -->
                    <div>
                        <label for="image_url" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">URL
                            รูปภาพห้อง (Optional)</label>
                        <input id="image_url" name="image_url" type="url"
                            class="w-full px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('image_url') border-red-500 @enderror"
                            value="{{ old('image_url', $room->image_url) }}"
                            placeholder="http://example.com/room_pic.jpg">
                        @error('image_url')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- คำอธิบาย -->
                    <div>
                        <label for="description"
                            class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">คำอธิบายห้อง</label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full px-4 py-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror"
                            placeholder="รายละเอียดของห้อง เช่น มีโปรเจคเตอร์, ไม่มีแอร์">{{ old('description', $room->description) }}</textarea>
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
                            บันทึกการแก้ไข
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

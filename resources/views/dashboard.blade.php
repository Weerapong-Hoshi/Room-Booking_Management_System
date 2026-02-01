<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">รายการห้องว่าง</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($rooms as $room)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <!-- ชื่อห้อง -->
                        <h3 class="text-xl font-bold mb-2">{{ $room->name }}</h3>

                        <!-- รายละเอียด -->
                        <p class="text-gray-600 dark:text-gray-300 mb-4">
                            {{ $room->description }}
                        </p>

                        <div class="flex justify-between items-center border-t pt-4 dark:border-gray-700">
                            <!-- ความจุ -->
                            <span class="text-sm text-gray-500">
                                รองรับ: {{ $room->capacity }} คน
                            </span>

                            <!-- ปุ่มจอง -->
                            <a href="#"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                จองห้องนี้
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</div>

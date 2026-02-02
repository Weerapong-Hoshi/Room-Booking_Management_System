<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            แผงควบคุมผู้ดูแลระบบ (Admin Panel)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- ส่วนที่ 1: จัดการคำขอจอง (Approve/Reject) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white border-b pb-2">รายการรออนุมัติ</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left dark:text-gray-300">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="p-3">ผู้จอง</th>
                                <th class="p-3">ห้อง</th>
                                <th class="p-3">ช่วงเวลา</th>
                                <th class="p-3">สถานะ</th>
                                <th class="p-3 text-right">ดำเนินการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings->where('status', 'pending') as $booking)
                                <tr class="border-b dark:border-gray-700">
                                    <td class="p-3">{{ $booking->user->name }}</td>
                                    <td class="p-3">{{ $booking->room->name }}</td>
                                    <td class="p-3 text-sm">{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                                    <td class="p-3"><span
                                            class="bg-yellow-500 text-white px-2 py-1 rounded text-xs">Pending</span>
                                    </td>
                                    <td class="p-3 text-right flex justify-end gap-2">
                                        <form action="{{ route('admin.approve', $booking->id) }}" method="POST">
                                            @csrf
                                            <button
                                                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">อนุมัติ</button>
                                        </form>
                                        <form action="{{ route('admin.reject', $booking->id) }}" method="POST">
                                            @csrf
                                            <button
                                                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">ปฏิเสธ</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ส่วนที่ 2: จัดการห้อง (CRUD) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between mb-4 border-b pb-2">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">จัดการข้อมูลห้อง</h3>
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">+ เพิ่มห้องใหม่</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach ($rooms as $room)
                        <div
                            class="border dark:border-gray-700 p-4 rounded-lg flex justify-between items-center bg-gray-50 dark:bg-gray-900">
                            <div>
                                <p class="font-bold dark:text-white">{{ $room->name }}</p>
                                <p class="text-xs text-gray-500">ความจุ: {{ $room->capacity }}</p>
                            </div>
                            <div class="flex gap-2">
                                <button class="text-blue-500 hover:underline text-sm">แก้ไข</button>
                                <button class="text-red-500 hover:underline text-sm">ลบ</button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

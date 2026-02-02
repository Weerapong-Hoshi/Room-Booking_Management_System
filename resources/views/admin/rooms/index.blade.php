<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            จัดการข้อมูลห้องเรียน (Room Management)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl overflow-hidden p-6 border dark:border-gray-700">

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded-r">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">รายการห้องทั้งหมด</h3>
                    <a href="{{ route('admin.rooms.create') }}"
                        class="px-4 py-2 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition">
                        + เพิ่มห้องใหม่
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left dark:text-gray-300">
                        <thead
                            class="bg-gray-50 dark:bg-gray-700 text-gray-500 text-xs uppercase font-bold tracking-widest">
                            <tr>
                                <th class="px-6 py-3">ชื่อห้อง</th>
                                <th class="px-6 py-3">ความจุ</th>
                                <th class="px-6 py-3">สถานะ</th>
                                <th class="px-6 py-3 text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rooms as $room)
                                <tr
                                    class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors">
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $room->name }}
                                    </td>
                                    <td class="px-6 py-4">{{ $room->capacity }} ที่นั่ง</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 rounded text-xs font-bold {{ $room->status === 'available' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                                            {{ $room->status === 'available' ? 'พร้อมใช้งาน' : 'ซ่อมบำรุง' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex justify-center gap-2">
                                        <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                            class="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">แก้ไข</a>
                                        <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST"
                                            onsubmit="return confirm('ยืนยันการลบห้อง {{ $room->name }}? การจองทั้งหมดจะถูกลบไปด้วย')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600">ลบ</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">
                                        ไม่มีข้อมูลห้องในระบบ</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

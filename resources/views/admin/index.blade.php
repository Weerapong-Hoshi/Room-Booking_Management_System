<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">จัดการการจองห้อง</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left dark:text-white">
                    <thead>
                        <tr class="border-b">
                            <th class="p-3">ห้อง</th>
                            <th class="p-3">ผู้จอง</th>
                            <th class="p-3">เวลา</th>
                            <th class="p-3">สถานะ</th>
                            <th class="p-3">ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr class="border-b">
                                <td class="p-3">{{ $booking->room->name }}</td>
                                <td class="p-3">{{ $booking->user->name }}</td>
                                <td class="p-3 text-sm">
                                    {{ $booking->start_time }} ถึง <br> {{ $booking->end_time }}
                                </td>
                                <td class="p-3">
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $booking->status === 'approved' ? 'bg-green-500' : ($booking->status === 'pending' ? 'bg-yellow-500' : 'bg-red-500') }} text-white">
                                        {{ $booking->status }}
                                    </span>
                                </td>
                                <td class="p-3 flex gap-2">
                                    @if ($booking->status === 'pending')
                                        <form action="{{ route('admin.approve', $booking->id) }}" method="POST">
                                            @csrf
                                            <button
                                                class="bg-blue-500 text-white px-3 py-1 rounded text-xs">อนุมัติ</button>
                                        </form>
                                        <form action="{{ route('admin.reject', $booking->id) }}" method="POST">
                                            @csrf
                                            <button
                                                class="bg-red-500 text-white px-3 py-1 rounded text-xs">ปฏิเสธ</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

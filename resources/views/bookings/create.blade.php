<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            จองห้อง: {{ $room->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow">

                @if ($errors->any())
                    <div class="mb-4 text-red-600 font-bold">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <div class="mb-4">
                        <label class="block mb-2">เวลาเริ่ม</label>
                        <input type="datetime-local" name="start_time" class="w-full border-gray-300 rounded" required>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-2">เวลาสิ้นสุด</label>
                        <input type="datetime-local" name="end_time" class="w-full border-gray-300 rounded" required>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                        ยืนยันการจอง
                    </button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>

<section>
    <header>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ __('🖼️ ข้อมูลโปรไฟล์') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("อัปเดตข้อมูลโปรไฟล์และอีเมลของคุณ") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Profile Image -->
        <div class="p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-xl border-2 border-blue-100 dark:border-gray-600">
            <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-4">
                🖼️ รูปโปรไฟล์
            </label>
            <div class="flex items-center gap-6">
                <div id="preview" class="w-32 h-32 rounded-full bg-gradient-to-br from-indigo-400 to-blue-500 flex items-center justify-center text-white font-bold text-4xl border-4 border-indigo-200 dark:border-indigo-700 overflow-hidden flex-shrink-0">
                    @if ($user->profile_image)
                        <img src="{{ asset('storage/' . $user->profile_image) }}"
                            alt="{{ $user->name }}"
                            class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="flex-1">
                    <input type="file" id="profile_image" name="profile_image" accept="image/*"
                        class="block w-full text-sm text-gray-600 dark:text-gray-400
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-100 dark:file:bg-indigo-900/30
                        file:text-indigo-700 dark:file:text-indigo-300
                        hover:file:bg-indigo-200 dark:hover:file:bg-indigo-900/50
                        cursor-pointer">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">JPG, PNG หรือ GIF (ขนาดไม่เกิน 2MB)</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_image')" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('👤 ชื่อ')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-2" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('📧 อีเมล')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-2" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4">
            <x-primary-button>{{ __('💾 บันทึก') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-400 font-semibold"
                >{{ __('✓ บันทึกสำเร็จ') }}</p>
            @endif
        </div>
    </form>

    <script>
        document.getElementById('profile_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.innerHTML = `<img src="${event.target.result}" class="w-full h-full object-cover">`;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

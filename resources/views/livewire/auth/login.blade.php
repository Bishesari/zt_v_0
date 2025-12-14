<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('ورود به حساب')" :description="__('نام کاربری و پسورد خود را جهت ورود وارد کنید.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf
            <flux:input
                name="user_name"
                :label="__('نام کاربری')"
                :value="old('user_name')"
                type="user_name"
                required
                :placeholder="__('نام کاربری')"
                autofocus
                class:input="text-center tracking-widest font-bold"
                dir="ltr"
            />
            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('کلمه عبور')"
                    type="password"
                    required
                    :placeholder="__('کلمه عبور')"
                    class:input="text-center tracking-widest font-bold"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('بازیابی پسورد') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('بخاطر سپاری')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('ورود') }}
                </flux:button>
            </div>
        </form>

    </div>
</x-layouts.auth>

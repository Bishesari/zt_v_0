<?php

use App\Models\Contact;
use App\Models\Driver;
use App\Models\Profile;
use App\Models\User;
use App\Rules\NCode;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Component;

new class extends Component {
    public string $f_name_fa = '';
    public string $l_name_fa = '';
    public string $n_code = '';
    public string $mobile_nu = '';

    protected function rules(): array
    {
        return [
            'f_name_fa' => ['required', 'min:2', 'max:30'],
            'l_name_fa' => ['required', 'min:2', 'max:30'],
            'n_code' => ['required', 'digits:10', new NCode, 'unique:profiles'],
            'mobile_nu' => ['required', 'starts_with:09', 'digits:11', 'unique:contacts'],
        ];
    }


    public function save(): void
    {
        $this->validate();
        DB::transaction(function () {
            // 1. User
            $user = User::create([
                'user_name' => $this->mobile_nu,
                'password' => ($this->n_code),
                'is_active' => true,
            ]);
            $user->assignRole('driver');

            // 2. Profile
            Profile::create([
                'user_id' => $user->id,
                'f_name_fa' => $this->f_name_fa,
                'l_name_fa' => $this->l_name_fa,
                'n_code' => $this->n_code,
            ]);

            // 3. Driver
            Driver::create([
                'user_id' => $user->id,
                'is_active' => true,
            ]);

            // 4. Contact اصلی
            Contact::create([
                'user_id' => $user->id,
                'mobile_nu' => $this->mobile_nu,
                'is_primary' => true,
            ]);
        });
        $this->modal('new-driver')->close();

    }

    public function reset_all(): void
    {
        $this->reset(['f_name_fa', 'l_name_fa', 'n_code', 'mobile_nu']);
    }

}; ?>

<div>
    <flux:modal.trigger name="new-driver">
        <flux:button class="cursor-pointer">{{__('راننده جدید')}}</flux:button>
    </flux:modal.trigger>

    <flux:modal name="new-driver" class="md:w-96" focusable flyout @close="reset_all" :dismissible="false">
        <div>
            <flux:heading size="lg" class="text-center">{{__('ثبت راننده جدید')}}</flux:heading>
            <flux:text class="mt-2 mb-3 text-center">{{'اطلاعات مربوط به راننده جدید را وارد کنید.'}}</flux:text>

            <form wire:submit.prevent="save" class="space-y-6">
                <flux:input wire:model="f_name_fa" label="نام:" placeholder="نام"
                            class:input="text-center font-semibold" autofocus required/>
                <flux:input wire:model="l_name_fa" label="نام خانوادگی:" placeholder="نام خانوادگی"
                            class:input="text-center font-semibold" required/>
                <flux:input wire:model="n_code" label="کدملی:" placeholder="کدملی"
                            class:input="text-center tracking-widest font-bold" maxlength="10" dir="ltr" required/>
                <flux:input wire:model="mobile_nu" label="شماره موبایل:" placeholder="شماره موبایل"
                            class:input="text-center tracking-widest font-bold" maxlength="11" dir="ltr" required/>


                <div class="flex">
                    <flux:spacer/>
                    <flux:button type="submit" variant="primary">{{__('ذخیره')}}</flux:button>
                </div>
            </form>

        </div>
    </flux:modal>
</div>

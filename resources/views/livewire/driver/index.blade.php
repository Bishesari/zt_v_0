<?php

use App\Models\Driver;
use Livewire\Volt\Component;

new class extends Component {

    public string $search = '';      // برای جستجو
    public bool $showActive = true; // فیلتر فعال/غیرفعال

    public $drivers;

    public function mount()
    {
        $this->drivers = Driver::query()
            ->with(['user.profile', 'user.contacts']) // eager load برای کاهش query
            ->when($this->showActive, fn($q) => $q->where('is_active', true))
            ->whereHas('user.profile', function ($q) {
                if ($this->search) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%")
                        ->orWhere('n_code', 'like', "%{$this->search}%");
                }
            })
            ->orderBy('id', 'desc')
            ->get();
    }


}; ?>

<div>
    <livewire:driver.create/>
        <flux:header>
            رانندگان
            <input type="text" wire:model="search" placeholder="جستجوی نام یا کد ملی..." class="ml-2 p-1 border rounded">
            <flux:button x-on:click="$wire.showActive = !$wire.showActive">
                {{ $showActive ? 'نمایش غیر فعال‌ها' : 'نمایش فعال‌ها' }}
            </flux:button>
        </flux:header>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>نام</th>
                    <th>نام خانوادگی</th>
                    <th>کد ملی</th>
                    <th>شماره موبایل</th>
                    <th>فعال؟</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                    <tr>
                        <td>{{ $driver->id }}</td>
                        <td>{{ $driver->user->profile->f_name_fa }}</td>
                        <td>{{ $driver->user->profile->l_name_fa }}</td>
                        <td>{{ $driver->user->profile->n_code }}</td>
                        <td>
                            {{ $driver->user->contacts->where('is_primary', true)->first()?->mobile_nu ?? '-' }}
                        </td>
                        <td>{{ $driver->is_active ? 'فعال' : 'غیرفعال' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

</div>

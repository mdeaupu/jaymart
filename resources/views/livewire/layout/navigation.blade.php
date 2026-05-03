<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->dispatch('prepare-for-logout');
        $this->redirect('/', navigate: true);
    }

    public function getNavigationMenu(): array
    {
        $user = auth()->user();

        $menus = [
            'owner' => [
                ['label' => 'Dashboard', 'route' => 'owner.dashboard', 'active' => 'owner.dashboard'],
                ['label' => 'Report', 'route' => 'owner.report.main', 'active' => 'owner.report.*'],
                ['label' => 'User Management', 'route' => 'owner.users', 'active' => 'owner.users'],
                ['label' => 'Branches Management', 'route' => 'owner.branches', 'active' => 'owner.branches'],
                ['label' => 'Stock Monitoring', 'route' => 'owner.monitoring', 'active' => 'owner.monitoring'],
                ['label' => 'Stock Adjustment', 'route' => 'owner.adjustments', 'active' => 'owner.adjustments'],
                ['label' => 'Stock Approval', 'route' => 'owner.approval', 'active' => 'owner.approval'],
                ['label' => 'Stock Audit Log', 'route' => 'owner.audit', 'active' => 'owner.audit'],
            ],
            'manager' => [
                ['label' => 'Dashboard', 'route' => 'manager.dashboard', 'active' => 'manager.dashboard'],
                ['label' => 'Staff Management', 'route' => 'manager.staff', 'active' => 'manager.staff'],
                ['label' => 'Stock Adjustment', 'route' => 'manager.stockadjustmentcreate', 'active' => 'manager.stockadjustmentcreate'],
                ['label' => 'Adjustment History', 'route' => 'manager.stockadjustmenthistory', 'active' => 'manager.stockadjustmenthistory'],
                ['label' => 'Stock Purchase', 'route' => 'manager.stockpurchase', 'active' => 'manager.stockpurchase'],
                ['label' => 'Purchase History', 'route' => 'manager.stockpurchasehistory', 'active' => 'manager.stockpurchasehistory'],
                ['label' => 'Export Center', 'route' => 'manager.export', 'active' => 'manager.export'],
                ['label' => 'Financial Summary', 'route' => 'manager.finance', 'active' => 'manager.finance'],
            ],
            'supervisor' => [
                ['label' => 'Real-Time Monitoring', 'route' => 'supervisor.monitoring', 'active' => 'supervisor.monitoring'],
                ['label' => 'Void Approval', 'route' => 'supervisor.void', 'active' => 'supervisor.void'],
                ['label' => 'Adjustment Approval', 'route' => 'supervisor.stock', 'active' => 'supervisor.stock'],
                ['label' => 'Audit Trail', 'route' => 'supervisor.audit', 'active' => 'supervisor.audit'],
            ],
            'cashier' => [
                ['label' => 'Dashboard', 'route' => 'cashier.dashboard', 'active' => 'cashier.dashboard'],
                ['label' => 'Transaksi', 'route' => 'cashier.pos', 'active' => 'cashier.pos'],
                ['label' => 'Laporan', 'route' => 'cashier.report', 'active' => 'cashier.report'],
            ],
            'warehouse' => [
                ['label' => 'Dashboard', 'route' => 'warehouse.dashboard', 'active' => 'warehouse.dashboard'],
                ['label' => 'Incoming', 'route' => 'warehouse.incoming', 'active' => 'warehouse.incoming'],
                ['label' => 'Damaged', 'route' => 'warehouse.damaged', 'active' => 'warehouse.damaged'],
                ['label' => 'Opname', 'route' => 'warehouse.opname', 'active' => 'warehouse.opname'],
            ],
        ];

        foreach ($menus as $role => $items) {
            if ($user->hasRole($role))
                return $items;
        }

        return [];
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->dashboardUrl() }}" wire:navigate>
                        <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" class="w-16 h-auto">
                    </a>
                </div>
                <!-- Navigation Links (Desktop) -->
                <div class="hidden space-x-4 lg:space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @foreach($this->getNavigationMenu() as $item)
                        <x-nav-link :href="route($item['route'])" :active="request()->routeIs($item['active'])"
                            wire:navigate>
                            {{ __($item['label']) }}
                        </x-nav-link>
                    @endforeach
                </div>
            </div>
            <!-- Settings & Dark Mode (Desktop) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-2">
                <!-- Dark Mode Toggle -->
                <button
                    @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')"
                    class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                    <svg class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block " fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z">
                        </path>
                    </svg>
                </button>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition">
                            <div x-data="{ name: '{{ auth()->user()->name }}' }" x-text="name"
                                x-on:profile-updated.window="name = $event.detail.name"></div>
                            <svg class="ms-1 fill-current h-4 w-4" viewBox="0 0 20 20">
                                <path
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>{{ __('Profile') }}</x-dropdown-link>
                        <button wire:click="logout"
                            class="w-full text-start"><x-dropdown-link>{{ __('Log Out') }}</x-dropdown-link></button>
                    </x-slot>
                </x-dropdown>
            </div>
            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Responsive Navigation Menu -->
    <div x-show="open" x-transition
        class="sm:hidden bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
        <div class="pt-2 pb-3 space-y-1">
            @foreach($this->getNavigationMenu() as $item)
                <x-responsive-nav-link :href="route($item['route'])" :active="request()->routeIs($item['active'])"
                    wire:navigate>
                    {{ __($item['label']) }}
                </x-responsive-nav-link>
            @endforeach
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4 flex justify-between items-center">
                <div>
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                </div>
                <button
                    @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')"
                    class="p-2 rounded-md text-gray-500 dark:text-gray-400">
                    <svg class="w-6 h-6 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg class="w-6 h-6 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 3v1m0 16v1m9-9h-1M4 9h-1m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')"
                    wire:navigate>{{ __('Profile') }}</x-responsive-nav-link>
                <button wire:click="logout"
                    class="w-full text-start"><x-responsive-nav-link>{{ __('Log Out') }}</x-responsive-nav-link></button>
            </div>
        </div>
    </div>
</nav>
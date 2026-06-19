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
        if (!$user)
            return [];

        $menus = [
            'owner' => [
                ['label' => 'Dashboard', 'route' => 'owner.dashboard', 'active' => 'owner.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['label' => 'Report', 'route' => 'owner.report.main', 'active' => 'owner.report.*', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                ['label' => 'User Management', 'route' => 'owner.users', 'active' => 'owner.users', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['label' => 'Branches Management', 'route' => 'owner.branches', 'active' => 'owner.branches', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4'],
                ['label' => 'Stock Monitoring', 'route' => 'owner.monitoring', 'active' => 'owner.monitoring', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
                ['label' => 'Stock Adjustment', 'route' => 'owner.adjustments', 'active' => 'owner.adjustments', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                ['label' => 'Stock Approval', 'route' => 'owner.approval', 'active' => 'owner.approval', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['label' => 'Stock Audit Log', 'route' => 'owner.audit', 'active' => 'owner.audit', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
            ],
            'manager' => [
                ['label' => 'Dashboard', 'route' => 'manager.dashboard', 'active' => 'manager.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['label' => 'Staff Management', 'route' => 'manager.staff', 'active' => 'manager.staff', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['label' => 'Stock Adjustment', 'route' => 'manager.stockadjustmentcreate', 'active' => 'manager.stockadjustmentcreate', 'icon' => 'M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Adjustment History', 'route' => 'manager.stockadjustmenthistory', 'active' => 'manager.stockadjustmenthistory', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Adjustment Review', 'route' => 'manager.stockadjustmentreview', 'active' => 'manager.stockadjustmentreview', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                ['label' => 'Stock Purchase', 'route' => 'manager.stockpurchase', 'active' => 'manager.stockpurchase', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z'],
                ['label' => 'Purchase History', 'route' => 'manager.stockpurchasehistory', 'active' => 'manager.stockpurchasehistory', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01'],
                ['label' => 'Otorisasi Void Kasir', 'route' => 'manager.verify-void', 'active' => 'manager.verify-void', 'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['label' => 'Export Center', 'route' => 'manager.export', 'active' => 'manager.export', 'icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'],
                ['label' => 'Financial Summary', 'route' => 'manager.finance', 'active' => 'manager.finance', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
            ],
            'supervisor' => [
                ['label' => 'Dashboard', 'route' => 'supervisor.dashboard', 'active' => 'supervisor.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['label' => 'Real-Time Monitoring', 'route' => 'supervisor.monitoring', 'active' => 'supervisor.monitoring', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
                ['label' => 'Verifikasi Void Kasir', 'route' => 'supervisor.verify-void', 'active' => 'supervisor.verify-void', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                ['label' => 'Verify Opname', 'route' => 'supervisor.verify-opname', 'active' => 'supervisor.verify-opname', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['label' => 'Opname History', 'route' => 'supervisor.opname-history', 'active' => 'supervisor.opname-history', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                ['label' => 'Audit Trail', 'route' => 'supervisor.audit', 'active' => 'supervisor.audit', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ],
            'cashier' => [
                ['label' => 'Dashboard', 'route' => 'cashier.dashboard', 'active' => 'cashier.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['label' => 'Transaksi (POS)', 'route' => 'cashier.pos', 'active' => 'cashier.pos', 'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z'],
                ['label' => 'Laporan', 'route' => 'cashier.report', 'active' => 'cashier.report', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
            ],
            'warehouse' => [
                ['label' => 'Dashboard', 'route' => 'warehouse.dashboard', 'active' => 'warehouse.dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['label' => 'Incoming Stock', 'route' => 'warehouse.incoming', 'active' => 'warehouse.incoming', 'icon' => 'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1'],
                ['label' => 'Damaged Goods', 'route' => 'warehouse.damaged', 'active' => 'warehouse.damaged', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'],
                ['label' => 'Opname', 'route' => 'warehouse.opname', 'active' => 'warehouse.opname', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
            ],
        ];

        // Default fallback pencarian role dinamis pada user model[cite: 18]
        foreach ($menus as $role => $items) {
            if ($user->hasRole($role)) {
                return $items;
            }
        }

        return [];
    }
};
?>

<div h-full x-data="{ mobileOpen: false }">

    {{-- BAR ATAS MOBILE (Hanya terlihat di bawah breakpoint lg) --}}
    <div
        class="lg:hidden flex items-center justify-between bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 h-14 px-4 fixed top-0 w-full z-40">
        <a href="{{ auth()->user()->dashboardUrl() }}" wire:navigate class="flex items-center">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" class="w-10 h-auto">
        </a>

        <div class="flex items-center gap-2">
            {{-- Dark Mode (Mobile) --}}
            <button
                @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')"
                class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <svg class="w-5 h-5 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg class="w-5 h-5 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z">
                    </path>
                </svg>
            </button>

            {{-- Hamburger Toggle Button menggunakan Event Alpine --}}
            <button @click="mobileOpen = ! mobileOpen"
                class="p-2 rounded-md text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': mobileOpen, 'inline-flex': ! mobileOpen }" class="inline-flex"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'inline-flex': mobileOpen, 'hidden': ! mobileOpen }" class="hidden"
                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- SIDEBAR VERTIKAL UTAMA (Binding class diatur oleh Alpine) --}}
    <aside :class="mobileOpen ? 'translate-x-0 pt-14 lg:pt-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed inset-y-0 left-0 z-30 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform flex flex-col justify-between transition-transform duration-300 ease-in-out lg:translate-x-0">

        <div class="flex-1 px-4 py-6 overflow-y-auto">
            <!-- Logo Header -->
            <div class="hidden lg:flex items-center gap-3 pb-6 mb-6 border-b border-gray-100 dark:border-gray-700">
                <a href="{{ auth()->user()->dashboardUrl() }}" wire:navigate class="block">
                    <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" class="w-14 h-auto">
                </a>
                <div>
                    <h2 class="font-bold text-sm tracking-tight text-gray-800 dark:text-gray-200">Jaymart POS</h2>
                    <span class="text-[11px] text-gray-400 dark:text-gray-500 font-medium">Management Center</span>
                </div>
            </div>

            <!-- Links Menu Utama -->
            <nav class="space-y-1">
                @foreach($this->getNavigationMenu() as $item)
                            @php $active = request()->routeIs($item['active']); @endphp
                            <a href="{{ route($item['route']) }}" wire:navigate
                                class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium tracking-wide transition-colors group
                                   {{ $active
                    ? 'bg-purple-600 text-white shadow-sm shadow-purple-600/20'
                    : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-100' }}">

                                <svg class="w-5 h-5 flex-shrink-0 transition-colors {{ $active ? 'text-white' : 'text-gray-400 dark:text-gray-500 group-hover:text-gray-500 dark:group-hover:text-gray-300' }}"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="{{ $item['icon'] }}"></path>
                                </svg>

                                <span>{{ __($item['label']) }}</span>
                            </a>
                @endforeach
            </nav>
        </div>

        <!-- PANEL PROFILE & AKUN (BAWAH SIDEBAR) -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/50">
            <div class="flex items-center justify-between mb-4 px-2">
                <div class="flex items-center gap-2 truncate">
                    <div
                        class="w-8 h-8 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center font-bold text-xs text-purple-700 dark:text-purple-300 uppercase flex-shrink-0">
                        {{ substr(auth()->user()->name, 0, 2) }}
                    </div>
                    <div class="truncate">
                        <p class="text-xs font-semibold text-gray-800 dark:text-gray-200 truncate"
                            x-data="{ name: '{{ auth()->user()->name }}' }" x-text="name"
                            x-on:profile-updated.window="name = $event.detail.name"></p>
                        <span
                            class="text-[10px] text-gray-400 dark:text-gray-500 block truncate">{{ auth()->user()->email }}</span>
                    </div>
                </div>

                {{-- Dark Mode Toggle (Desktop) --}}
                <button
                    @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light')"
                    class="hidden lg:block p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 rounded-md transition-colors">
                    <svg class="w-4 h-4 block dark:hidden" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg class="w-4 h-4 hidden dark:block" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="space-y-1">
                <a href="{{ route('profile') }}" wire:navigate
                    class="flex items-center justify-center gap-2 w-full px-3 py-1.5 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg text-xs font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                    {{ __('Profile') }}
                </a>
                <button wire:click="logout"
                    class="flex items-center justify-center gap-2 w-full px-3 py-1.5 bg-transparent text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/30 rounded-lg text-xs font-semibold transition-colors">
                    {{ __('Log Out') }}
                </button>
            </div>
        </div>
    </aside>

    {{-- OVERLAY LATAR BLUR MOBILE (Menggunakan kontrol x-show Alpine) --}}
    <div x-show="mobileOpen" @click="mobileOpen = false" x-transition.opacity
        class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-20 lg:hidden"></div>
</div>
<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('index') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            {{-- Core Dashboard --}}
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>

            {{-- Core Farmers Section --}}
            <li class="sidebar-menu-group-title">Farmers</li>
            <li>
                <a href="{{ route('farmers.index') }}">
                    <iconify-icon icon="flowbite:users-group-outline" class="menu-icon"></iconify-icon>
                    <span>All Farmers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('farmers.create') }}">
                    <iconify-icon icon="heroicons:document" class="menu-icon"></iconify-icon>
                    <span>Create Farmer</span>
                </a>
            </li>

            {{-- Dynamic Module Menu Items --}}
            @if(isset($sidebarItems) && is_array($sidebarItems))
                @foreach($sidebarItems as $groupTitle => $items)
                    @if(is_array($items) && !empty($items))
                        <li class="sidebar-menu-group-title">{{ $groupTitle }}</li>
                        @foreach($items as $item)
                            @if(isset($item['title']) && isset($item['route']) && isset($item['icon']))
                                <li>
                                    <a href="{{ route($item['route']) }}">
                                        <iconify-icon icon="{{ $item['icon'] }}" class="menu-icon"></iconify-icon>
                                        <span>{{ $item['title'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            @endif

            {{-- System Section --}}
            <li class="sidebar-menu-group-title">System</li>
            <li>
                <a href="{{ route('modules.index') }}">
                    <iconify-icon icon="carbon:application-web" class="menu-icon"></iconify-icon>
                    <span>Module Management</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

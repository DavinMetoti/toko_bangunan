<nav class="navbar navbar-vertical navbar-expand-lg">
    <div class="collapse navbar-collapse" id="navbarVerticalCollapse">
        <!-- scrollbar removed-->
        <div class="navbar-vertical-content">
            <ul class="navbar-nav flex-column" id="navbarVerticalNav">
                @foreach (config('menu.sidebar') as $group)
                    <li class="nav-item">
                        <!-- Label Group -->
                        <p class="navbar-vertical-label">{{ $group['title'] }}</p>
                        <hr class="navbar-vertical-line" />

                        @foreach ($group['children'] as $menu)
                            <div class="nav-item-wrapper">
                                <a class="nav-link label-1 {{ request()->routeIs($menu['route']) ? 'active' : '' }}"
                                href="{{ route($menu['route']) }}"
                                role="button">
                                    <div class="d-flex align-items-center">
                                        <span class="nav-link-icon">
                                            @if($menu['icon'])
                                                <i class="{{ $menu['icon'] }}"></i>
                                            @else
                                                <i data-feather="{{ $menu['father'] }}"></i>
                                            @endif
                                        </span>
                                        <span class="nav-link-text-wrapper">
                                            <span class="nav-link-text">{{ $menu['title'] }}</span>
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="navbar-vertical-footer"><button class="btn navbar-vertical-toggle border-0 fw-semibold w-100 white-space-nowrap d-flex align-items-center"><span class="uil uil-left-arrow-to-left fs-8"></span><span class="uil uil-arrow-from-right fs-8"></span><span class="navbar-vertical-footer-text ms-2">Collapsed View</span></button></div>
</nav>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('index') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span style="color: var(--bs-primary)">
                    <img src="{{ asset('assets/img/logo/logo-white.png') }}" class="site-logo" width="50px" alt="logo" id="site-logo">
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-semibold ms-2">{{ __settings('SITE_TITLE') }}</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
                    fill-opacity="0.9" />
                <path
                    d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
                    fill-opacity="0.4" />
            </svg>
        </a>
    </div>
    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item {{ Request::routeIs('index') ? 'active' : '' }}">
            <a href="{{ route('index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-home-smile-line"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>
        <li class="menu-header mt-5">
            <span class="menu-header-text">Functions</span>
        </li>
        <li class="menu-item {{ Request::routeIs('payment.*') || Request::routeIs('paymentOnline.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle waves-effect">
                <i class="menu-icon tf-icons ri-exchange-dollar-fill"></i>
                <div>Payments</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Request::routeIs('payment.*') ? 'active' : '' }}">
                    <a href="{{ route('payment.index') }}" class="menu-link">
                        <div>All Payments</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::routeIs('paymentOnline.*') ? 'active' : '' }}">
                    <a href="{{ route('paymentOnline.index') }}" class="menu-link">
                        <div>Online Payment</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Request::routeIs('customers.*') ? 'active' : '' }}">
            <a href="{{ route('customers.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-group-line"></i>
                <div>Customers</div>
            </a>
        </li>
        <li class="menu-item {{ Request::routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-user-4-line"></i>
                <div>Users</div>
            </a>
        </li>
        <li class="menu-item {{ Request::routeIs('platform.*') ? 'active' : '' }}">
            <a href="{{ route('platform.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-gamepad-line"></i>
                <div>Platform</div>
            </a>
        </li>
        <li class="menu-header mt-5">
            <span class="menu-header-text">Settings</span>
        </li>
        <li class="menu-item {{ Request::routeIs('setting.*') ? 'active' : '' }}">
            <a href="{{ route('setting.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ri-settings-4-line"></i>
                <div>Settings</div>
            </a>
        </li>
        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link bg-danger">
                <i class="menu-icon tf-icons ri-logout-box-r-line"></i>
                <div>Logout</div>
            </a>
        </li>
    </ul>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logo = document.getElementById('site-logo');
        const darkLogo = "{{ asset('assets/img/logo/'. __settings('DARK_LOGO')) }}";
        const lightLogo = "{{ asset('assets/img/logo/'. __settings('LIGHT_LOGO')) }}";

        function updateLogo() {
            if (Helpers.isDarkStyle()) {
                logo.src = lightLogo;
            } else {
                logo.src = darkLogo;
            }
        }

        // Initial logo setup
        updateLogo();

        // Listen for theme change events
        document.querySelectorAll('[data-theme]').forEach(item => {
            item.addEventListener('click', function() {
                setTimeout(updateLogo, 100); // Delay to ensure theme change is applied
            });
        });
    });
</script>

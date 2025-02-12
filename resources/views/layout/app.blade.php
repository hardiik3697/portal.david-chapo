<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ url('assets') }}/" data-template="vertical-menu-template"
    data-style="light">

    <head>
        @include('layout.meta')

        <title>@yield('title') - {{ __settings('SITE_TITLE') }}</title>

        @include('layout.styles')

        @include('layout.helper-js')
    </head>

    <body>
        <div class="layout-wrapper layout-content-navbar">
            <div class="layout-container">
                @include('layout.sidebar')
          
                <div class="layout-page">
                    @include('layout.navbar')
          
                    <div class="content-wrapper">
                        @yield('content')
          
                        @include('layout.footer')
          
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>

            <div class="layout-overlay layout-menu-toggle"></div>

            <div class="drag-target"></div>
        </div>

        @include('layout.scripts')

        @if(isset($pageJs) && is_array($pageJs))
            @foreach ($pageJs as $jsFile)
                @vite($jsFile)
            @endforeach
        @endif
    </body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">

    <title>{{ config('app.name', 'IdealHome') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/core-img/favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17875198654"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag('js', new Date());
        gtag('config', 'AW-17875198654');
    </script>
</head>

<body class="bg-surface text-body font-sans antialiased">
    @php
        $agency = App\Models\Agency::query()->first();
    @endphp

    <div class="min-h-screen flex flex-col">
        <!-- Header Area -->
        <header class="relative z-50">
            <!-- Top Header Area -->
            <div class="bg-heading text-white/90 py-2.5 hidden md:block border-b border-white/5">
                <div
                    class="container mx-auto px-4 flex justify-between items-center text-[11px] tracking-[0.2em] uppercase font-bold">
                    <div class="flex items-center group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:{{ $agency?->email }}"
                            class="hover:text-primary transition-colors">{{ $agency?->email }}</a>
                    </div>
                    <div class="flex items-center group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:{{ $agency?->phone }}"
                            class="hover:text-primary transition-colors">{{ $agency?->phone }}</a>
                    </div>
                </div>
            </div>

            <!-- Main Navigation Area -->
            <nav id="stickyHeader"
                class="bg-primary/95 backdrop-blur-md border-b border-white/10 transition-all duration-300 ease-in-out">
                <div class="container mx-auto px-4">
                    <div class="flex items-center justify-between h-20 md:h-28">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class="inline-block py-2">
                            <img src="{{ asset('img/core-img/logo.png') }}" alt="{{ config('app.name') }} Logo"
                                class="h-14 md:h-20 w-auto invert transition-transform hover:scale-110 duration-300">
                        </a>

                        <!-- Centered Menu -->
                        <div class="hidden lg:flex items-center space-x-12">
                            @php
                                $navLinks = [
                                    ['route' => 'home', 'label' => 'Pagina principala'],
                                    ['route' => 'sales-listings', 'label' => 'Vanzari'],
                                    ['route' => 'rent-listings', 'label' => 'Inchirieri'],
                                    ['route' => 'team', 'label' => 'Echipa noastra'],
                                    ['route' => 'contact', 'label' => 'Contact'],
                                ];
                            @endphp
                            @foreach($navLinks as $link)
                                <a href="{{ route($link['route']) }}"
                                    class="text-white font-bold text-sm uppercase tracking-widest hover:text-white transition-all duration-300 relative group py-2 {{ request()->routeIs($link['route']) ? 'text-white' : 'text-white/80' }}">
                                    {{ label($link['label']) }}
                                    <span
                                        class="absolute -bottom-1 left-0 w-0 h-0.5 bg-white transition-all duration-300 group-hover:w-full {{ request()->routeIs($link['route']) ? 'w-full' : '' }}"></span>
                                </a>
                            @endforeach
                        </div>

                        <!-- Mobile Burger (Far Right) -->
                        <div class="lg:hidden">
                            <button id="mobile-menu-btn"
                                class="p-2 text-white focus:outline-none rounded-lg hover:bg-white/10 transition-colors">
                                <span class="sr-only">Open menu</span>
                                <svg id="menu-icon-open" class="w-8 h-8" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                                <svg id="menu-icon-close" class="hidden w-8 h-8" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu"
                    class="hidden lg:hidden bg-heading border-t border-white/10 transform transition-all duration-300 ease-in-out shadow-2xl">
                    <div class="px-6 py-10 space-y-4">
                        @foreach($navLinks as $link)
                            <a href="{{ route($link['route']) }}"
                                class="block px-6 py-4 text-base font-bold uppercase tracking-[0.2em] text-white/70 hover:text-white hover:bg-primary/20 rounded-xl transition-all {{ request()->routeIs($link['route']) ? 'text-white bg-primary/40' : '' }}">
                                {{ label($link['label']) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </nav>
        </header>



        <!-- Main Content -->
        <main class="flex-grow">
            @yield('content')
        </main>

        <!-- Footer Area -->
        <footer class="bg-heading text-white pt-16 pb-8">
            <div class="container mx-auto px-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                    <!-- About Section -->
                    <div class="space-y-6">
                        <img src="{{ asset('img/core-img/logo.png') }}" alt="{{ config('app.name') }}" class="h-12 w-auto brightness-0 invert">
                        <p class="text-white/60 text-sm leading-relaxed max-w-xs">
                            {{ label('Footer scurta descriere a agentiei.') }}
                        </p>
                    </div>

                    <!-- Office Hours & Contact -->
                    <div class="space-y-6">
                        <h4 class="text-primary font-bold uppercase tracking-widest text-xs border-b border-primary/20 pb-2 inline-block">
                            {{ label('Program & Contact') }}
                        </h4>
                        <ul class="space-y-3 text-sm text-white/70">
                            <li class="flex justify-between border-b border-white/5 pb-2">
                                <span>{{ label('Luni - Vineri') }}</span>
                                <span class="text-white font-medium">{{ $agency?->weekly_hours }}</span>
                            </li>
                            <li class="flex justify-between border-b border-white/5 pb-2">
                                <span>{{ label('Sambata') }}</span>
                                <span class="text-white font-medium">{{ $agency?->saturday_hours }}</span>
                            </li>
                            <li class="flex justify-between border-b border-white/5 pb-2">
                                <span>{{ label('Duminica') }}</span>
                                <span class="text-white font-medium">{{ $agency?->sunday_hours }}</span>
                            </li>
                        </ul>
                        <div class="pt-2 gap-3 flex flex-col">
                           <a href="tel:{{ $agency?->phone }}" class="text-sm hover:text-primary transition-colors flex items-center">
                                <span class="w-2 h-2 rounded-full bg-primary mr-3 shadow-[0_0_8px_rgba(148,112,84,0.8)]"></span>
                                {{ $agency?->phone }}
                           </a>
                           <a href="mailto:{{ $agency?->email }}" class="text-sm hover:text-primary transition-colors flex items-center">
                                <span class="w-2 h-2 rounded-full bg-primary mr-3 shadow-[0_0_8px_rgba(148,112,84,0.8)]"></span>
                                {{ $agency?->email }}
                           </a>
                        </div>
                    </div>

                    <!-- Useful Links -->
                    <div class="space-y-6">
                        <h4 class="text-primary font-bold uppercase tracking-widest text-xs border-b border-primary/20 pb-2 inline-block">
                            {{ label('Link-uri Utile') }}
                        </h4>
                        <ul class="space-y-3">
                            @foreach([
                                ['route' => 'home', 'label' => 'Acasa'],
                                ['route' => 'sales-listings', 'label' => 'Vanzari'],
                                ['route' => 'rent-listings', 'label' => 'Inchirieri'],
                                ['route' => 'team', 'label' => 'Echipa'],
                                ['route' => 'contact', 'label' => 'Contact'],
                            ] as $link)
                                <li>
                                    <a href="{{ route($link['route']) }}" class="text-sm text-white/60 hover:text-primary hover:pl-2 transition-all duration-300 flex items-center">
                                        <svg class="w-3 h-3 mr-2 opacity-0 -ml-5 group-hover:opacity-100 group-hover:ml-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        {{ label($link['label']) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Featured Properties Grid -->
                    <div class="space-y-6">
                        <h4 class="text-primary font-bold uppercase tracking-widest text-xs border-b border-primary/20 pb-2 inline-block">
                            {{ label('Proprietati Premium') }}
                        </h4>
                        @php
                            $properties = \App\Models\Estate::query()->orderBy('sale_price', 'desc')->limit(6)->get();
                        @endphp
                        <div class="grid grid-cols-3 gap-2">
                            @foreach($properties as $property)
                                <a href="{{ route('estate.show', $property->slug) }}" class="block aspect-square overflow-hidden group rounded-sm border border-white/10 hover:border-primary/50 transition-colors">
                                    <img src="{{ $property->featured_image }}" alt="Property" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-500 scale-105 group-hover:scale-125">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Copyright Bar -->
                <div class="pt-8 border-t border-white/5 text-center">
                    <p class="text-white/40 text-[11px] uppercase tracking-[0.2em]">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. 
                        Designed & Developed by 
                        <a href="mailto:razvanc1006@gmail.com" class="text-white/60 hover:text-primary transition-colors font-bold underline decoration-primary/30 decoration-2 underline-offset-4">Razvan C.</a>
                    </p>
                </div>
            </div>
        </footer>

    </div>

    @stack('scripts')
    @livewireScripts

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIconOpen = document.getElementById('menu-icon-open');
        const menuIconClose = document.getElementById('menu-icon-close');

        mobileMenuBtn.addEventListener('click', () => {
            const isHidden = mobileMenu.classList.contains('hidden');

            if (isHidden) {
                mobileMenu.classList.remove('hidden');
                menuIconOpen.classList.add('hidden');
                menuIconClose.classList.remove('hidden');
            } else {
                mobileMenu.classList.add('hidden');
                menuIconOpen.classList.remove('hidden');
                menuIconClose.classList.add('hidden');
            }
        });

        // Sticky Header Effects
        window.addEventListener('scroll', () => {
            const header = document.getElementById('stickyHeader');
            if (window.scrollY > 50) {
                header.classList.add('shadow-lg', 'py-1');
                header.classList.remove('py-0');
            } else {
                header.classList.remove('shadow-lg', 'py-1');
            }
        });
    </script>
</body>


</html>
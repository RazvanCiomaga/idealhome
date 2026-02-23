@extends('layouts.tw-app')

@section('content')
    @php
        $offerTypes = \App\Models\OfferType::query()->orderBy('name')->get();
        $estateTypes = \App\Models\EstateType::query()->orderBy('name')->get();
        $zones = \App\Models\Zone::query()->orderBy('name')->get();
        $roomEntrances = \App\Models\RoomEntrance::query()->orderBy('name')->get();

        // Fetch featured properties
        $featuredProperties = \App\Models\Estate::query()
            ->orderByRaw('home_page_display DESC, sale_price DESC')
            ->limit(6)
            ->get();
    @endphp

    <div class="relative min-h-[85vh] flex items-center">
        <!-- Hero Background with Overlay -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('img/bg-img/hero1.jpg') }}" alt="Luxurious Home" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-heading/80 via-heading/50 to-transparent"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 py-20">
            <div class="max-w-4xl">
                <!-- Hero Content -->
                <div class="mb-12">
                    <span
                        class="inline-block px-4 py-1.5 bg-primary text-white text-[10px] uppercase tracking-[0.3em] font-bold rounded-sm mb-6 shadow-lg shadow-primary/20">
                        {{ label('Agentie Imobiliara de Incredere') }}
                    </span>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                        {{ label('Gaseste Caminul') }} <br>
                        <span class="text-primary">{{ label('Ideal Pentru Tine') }}</span>
                    </h1>
                    <p class="text-white/70 text-lg md:text-xl max-w-2xl leading-relaxed">
                        {{ label('Descopera o colectie selecta de proprietati premium in cele mai bune zone ale orasului.') }}
                    </p>
                </div>

                <!-- Modern Search Filter Tool -->
                <div class="bg-white/10 backdrop-blur-xl p-2 rounded-xl border border-white/20 shadow-2xl">
                    <form action="#" class="bg-white rounded-lg p-6 lg:p-8 shadow-inner">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Transaction Type -->
                            <div class="space-y-2">
                                <label
                                    class="text-[10px] uppercase tracking-widest font-bold text-body">{{ label('Tranzactie') }}</label>
                                <select
                                    class="w-full bg-surface border-none text-heading text-sm font-medium rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 cursor-pointer">
                                    <option value="none">{{ label('Toate tipurile') }}</option>
                                    @foreach($offerTypes as $type)
                                        <option value="{{ $type->imobmanager_id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Estate Type -->
                            <div class="space-y-2">
                                <label
                                    class="text-[10px] uppercase tracking-widest font-bold text-body">{{ label('Proprietate') }}</label>
                                <select
                                    class="w-full bg-surface border-none text-heading text-sm font-medium rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 cursor-pointer">
                                    <option value="none">{{ label('Apartament, Casa...') }}</option>
                                    @foreach($estateTypes as $type)
                                        <option value="{{ $type->imobmanager_id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Zone -->
                            <div class="space-y-2">
                                <label
                                    class="text-[10px] uppercase tracking-widest font-bold text-body">{{ label('Zona / Cartier') }}</label>
                                <select
                                    class="w-full bg-surface border-none text-heading text-sm font-medium rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/20 cursor-pointer">
                                    <option value="none">{{ label('Alege locatia') }}</option>
                                    @foreach($zones as $zone)
                                        <option value="{{ $zone->name }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price / Submit -->
                            <div class="flex items-end">
                                <button type="button"
                                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/30 transition-all active:scale-95 flex items-center justify-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                    {{ label('Cauta Acum') }}
                                </button>
                            </div>
                        </div>

                        <!-- Secondary Filters (Collapsible trigger could go here) -->
                        <div class="mt-6 pt-6 border-t border-divider flex flex-wrap gap-4 items-center">
                            <div class="flex items-center gap-2 group cursor-pointer">
                                <div
                                    class="w-8 h-8 rounded-full bg-surface flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 text-body group-hover:text-primary transition-colors" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                </div>
                                <span
                                    class="text-xs font-bold text-body uppercase tracking-widest group-hover:text-primary transition-colors">{{ label('Filtre Avansate') }}</span>
                            </div>

                            <div class="h-4 w-px bg-divider"></div>

                            <div class="flex gap-4">
                                <span class="text-xs text-body font-medium flex items-center">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span>
                                    {{ \App\Models\Estate::count() }} {{ label('Proprietati Active') }}
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div
            class="absolute bottom-10 left-1/2 -translate-x-1/2 hidden md:flex flex-col items-center gap-2 text-white/40 animate-bounce">
            <span class="text-[10px] uppercase tracking-widest font-bold">{{ label('Spre Continut') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </div>

    <!-- Combined About & Featured Section -->
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row gap-16">

                <!-- Left Side: About Agency (2/3 width) -->
                <div class="w-full lg:w-2/3 space-y-12">
                    <div class="space-y-6">
                        <h4 class="text-primary font-bold uppercase tracking-[0.3em] text-[10px]">
                            {{ label('Cine suntem noi') }}
                        </h4>
                        <h2 class="text-4xl md:text-5xl font-bold text-heading leading-tight italic">
                            {{ label('Cauta proprietatea perfecta') }}
                        </h2>
                        <p class="text-body text-lg leading-relaxed italic max-w-2xl">
                            {{ label('Descriere cautare proprietate') }}
                        </p>
                    </div>

                    <div class="relative rounded-2xl overflow-hidden shadow-2xl group">
                        <img src="{{ asset('img/bg-img/about.jpg') }}" alt="Our Agency"
                            class="w-full h-[400px] object-cover group-hover:scale-105 transition-transform duration-1000">
                        <div class="absolute inset-0 bg-gradient-to-t from-heading/60 to-transparent"></div>
                        <div class="absolute bottom-8 left-8 right-8">
                            <p class="text-white text-lg font-medium leading-relaxed italic">
                                {{ label('Descriere agentie IdealHome pagina principala') }}
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-12 pt-4">
                        <div class="flex items-center gap-4">
                            <div class="text-primary text-4xl font-bold">10+</div>
                            <div class="text-heading text-[10px] uppercase tracking-widest font-bold leading-tight">
                                {{ label('Ani de') }}<br>{{ label('Experienta') }}
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-primary text-4xl font-bold">500+</div>
                            <div class="text-heading text-[10px] uppercase tracking-widest font-bold leading-tight">
                                {{ label('Proprietati') }}<br>{{ label('Vandute') }}
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-primary text-4xl font-bold">100%</div>
                            <div class="text-heading text-[10px] uppercase tracking-widest font-bold leading-tight">
                                {{ label('Clienti') }}<br>{{ label('Satisfacuti') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side: Featured Properties Carousel (1/3 width) -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-surface rounded-3xl p-8 h-full flex flex-col shadow-sm border border-divider/50">
                        <div class="flex justify-between items-center mb-8">
                            <h4 class="text-heading font-bold uppercase tracking-widest text-xs italic">
                                {{ label('Imobile de interes') }}
                            </h4>
                            <!-- Carousel Nav -->
                            <div class="flex gap-2">
                                <button onclick="scrollCarousel(-1)"
                                    class="p-2 rounded-full bg-white border border-divider hover:bg-primary hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button onclick="scrollCarousel(1)"
                                    class="p-2 rounded-full bg-white border border-divider hover:bg-primary hover:text-white transition-all shadow-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- CSS Snap Carousel -->
                        <div id="property-carousel"
                            class="flex-grow flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide pb-4 outline-none">
                            @foreach($featuredProperties as $estate)
                                <div class="min-w-full snap-center group">
                                    <div
                                        class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500 border border-divider/30 flex flex-col h-full italic">
                                        <div class="relative aspect-[4/3] overflow-hidden">
                                            <img src="{{ $estate->featured_image }}" alt="{{ $estate->title }}"
                                                class="w-full h-full object-cover">
                                            <div
                                                class="absolute bottom-3 right-3 bg-primary text-white py-1.5 px-4 rounded-lg font-bold text-sm shadow-lg">
                                                €{{ number_format($estate->sale_price ?: $estate->rent_price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="p-6 space-y-3">
                                            <div
                                                class="text-primary text-[10px] font-bold uppercase tracking-widest flex items-center gap-2">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                {{ $estate->zone }}
                                            </div>
                                            <h3 class="text-lg font-bold text-heading line-clamp-1 h-7">
                                                {{ $estate->title }}
                                            </h3>
                                            <div class="pt-4 border-t border-divider grid grid-cols-2 gap-4">
                                                <div class="flex items-center gap-2">
                                                    <img src="{{ asset('img/icons/garage.png') }}" class="w-4 h-4 opacity-40">
                                                    <span class="text-xs font-bold text-heading">{{ $estate->rooms }}
                                                        Cam.</span>
                                                </div>
                                                <div class="flex items-center gap-2">
                                                    <img src="{{ asset('img/icons/space.png') }}"
                                                        class="w-4 h-4 opacity-40 text-xs">
                                                    <span class="text-xs font-bold text-heading">{{ $estate->area }} m²</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('estate.show', $estate->slug) }}"
                                                class="block w-full text-center py-3 mt-4 text-[10px] font-bold uppercase tracking-[0.2em] border border-divider hover:border-primary hover:text-primary transition-all rounded-lg">
                                                {{ label('Vezi Detalii') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <p class="mt-8 text-body text-xs italic leading-relaxed text-center">
                            {{ label('Proprietati prezentare scurta descriere.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function scrollCarousel(direction) {
            const carousel = document.getElementById('property-carousel');
            const scrollAmount = carousel.offsetWidth + 24; // Width + gap
            carousel.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection
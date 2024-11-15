<div>
    <!-- ##### Breadcumb Area Start ##### -->
    <section class="breadcumb-area bg-img" style="background-image: url(img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title">{{ label('Pagina principala') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Advance Search Area Start ##### -->
    <div class="south-search-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="advanced-search-form">
                        <!-- Search Title -->
                        <div class="search-title">
                            <p>{{ label('Cautati o proprietate') }}</p>
                        </div>
                        <!-- Search Form -->
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                <div class="form-group">
                                    <select id="select-transaction-types" class="form-control" wire:model="transactionType">
                                        <option value="none" @if($transactionType === 'none') selected @endif>{{ label('Selecteaza tipul tranzactiei') }}</option>
                                        @foreach($filters['transactionTypes'] as $key => $value)
                                            <option value="{{ $key }}" @if($key === $transactionType) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                <div class="form-group">
                                    <select id="select-room-entrance" class="form-control" wire:model="roomEntrance" >
                                        <option value="none">{{ label('Selecteaza compartimentarea') }}</option>
                                        @foreach($filters['roomEntrances'] as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                <div class="form-group">
                                    <select id="zones" class="form-control" wire:model="zone">
                                        <option value="{{ $defaultSelect }}">{{ label('Selecteaza zona') }}</option>
                                        @foreach($filters['zones'] as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                <div class="form-group">
                                    <select id="floors" class="form-control" wire:model="floor">
                                        <option value="{{ $defaultSelect }}">{{ label('Selecteaza etaj') }}</option>
                                        @foreach($filters['floors'] as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                <div class="form-group">
                                    <select id="year" class="form-control" wire:model="year">
                                        <option value="{{ $defaultSelect }}">{{ label('Selecteaza anul constructiei') }}</option>
                                        @foreach($filters['construction_year'] as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 d-flex justify-content-between align-items-end">
                                <!-- More Filter -->
                                <div class="more-filter">
                                    <a href="#" id="moreFilter"></a>
                                </div>
                                <!-- Submit -->
                                <div class="form-group mb-0">
                                    <button type="button" class="btn south-btn" wire:click="applyFilters">{{ label('Cauta') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="about-content-wrapper section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="section-heading text-left wow fadeInUp" data-wow-delay="250ms">
                        <h2>{{ label('Cauta proprietatea perfecta') }}</h2>
                        <p>{{ label('Descriere cautare proprietate') }}</p>
                    </div>
                    <div class="about-content">
                        <img class="wow fadeInUp" data-wow-delay="350ms" src="img/bg-img/about.jpg" alt="">
                        <p class="wow fadeInUp" data-wow-delay="450ms">{{ label('Descriere agentie IdealHome pagina principala') }}</p>
                    </div>
                </div>

                <div class="col-12 col-lg-4">
                    <div class="section-heading text-left wow fadeInUp" data-wow-delay="250ms">
                        <h2>{{ label('Imobile de interes') }}</h2>
                        <p>{{ label('Proprietati prezentare scurta descriere.') }}</p>
                    </div>

                    <div class="featured-properties-slides owl-carousel wow fadeInUp" data-wow-delay="350ms">


                        @foreach($this->featuredProperties as $estate)
                            <div class="single-featured-property">
                                <div class="property-thumb">
                                    <img src="{{ $estate->featured_image }}" alt="{{ $estate->title . 'featured image' }}" style="height: 250px; width: 100%">

                                    <div class="tag">
                                        <span>{{ label('Tag vanzare') }}</span>
                                    </div>
                                    <div class="list-price">
                                        <p>€{{ number_format($estate->sale_price, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                                <!-- Property Content -->
                                <div class="property-content">
                                    <a href="{{ route('estate.show', ['slug' => $estate->slug]) }}">
                                        <h5>{{ $estate->title . ' - ' . $estate->construction_year . ' - ' . $estate->room_entrances }}</h5>
                                    </a>
                                    <p class="location"><img src="img/icons/location.png" alt="">{{ $estate->zone }}</p>
                                    <p>{{ substr($estate->description, 0, 100) . '...' }}</p>
                                    <div class="property-meta-data d-flex align-items-end justify-content-between">
                                        <div class="new-tag">
                                            <img src="img/icons/new.png" alt="">
                                        </div>
                                        <div class="bathroom">
                                            <img src="img/icons/bathtub.png" alt="">
                                            <span>{{ $estate->bathrooms }}</span>
                                        </div>
                                        <div class="garage">
                                            <img src="img/icons/garage.png" alt="">
                                            <span>{{ $estate->rooms }}</span>
                                        </div>
                                        <div class="space">
                                            <img src="img/icons/space.png" alt="">
                                            <span>{{ $estate->area }} &#13217;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="call-to-action-area bg-fixed bg-overlay-black" style="background-image: url(img/bg-img/cta.jpg)">
        <div class="container h-100">
            <div class="row align-items-center h-100">
                <div class="col-12">
                    <div class="cta-content text-center">
                        <h2 class="wow fadeInUp" data-wow-delay="300ms">{{ label('Cauti loc de inchiriat?') }}</h2>
                        <h6 class="wow fadeInUp" data-wow-delay="400ms">{{ label('Loc de inchiriat scurta descriere.') }}</h6>
                        <a href="{{ route('rent-listings') }}" class="btn south-btn mt-50 wow fadeInUp" data-wow-delay="500ms">{{ label('Vezi anunturi de inchiriere') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectRoomEntranceInput = $('#select-room-entrance').select2();
            const zonesInput = $('#zones').select2();
            const yearInput = $('#year').select2();
            const floorsInput = $('#floors').select2();
            const transactionTypeInput = $('#select-transaction-types').select2();

            // Local variables to store selected values
            let selectedRoomEntrance = 'none';
            let selectedZones = 'none';
            let selectedYear = 'none';
            let selectedFloor = 'none';
            let selectedTransactionType = 'sale';


            // Update local variables on selection change (no Livewire re-render here)
            selectRoomEntranceInput.on('change', function () {
                selectedRoomEntrance = $(this).val(); // Store selected room entrance locally
            });

            zonesInput.on('change', function () {
                selectedZones = $(this).val(); // Store selected zones locally
            });

            yearInput.on('change', function () {
                selectedYear = $(this).val(); // Store selected year locally
            });

            floorsInput.on('change', function () {
                selectedFloor = $(this).val(); // Store selected floor locally
            });

            transactionTypeInput.on('change', function () {
                selectedTransactionType = $(this).val(); // Store selected transaction type locally
            });

            document.querySelector('.btn.south-btn').addEventListener('click', function () {
                // Set Livewire properties right before calling applyFilters()

                @this.set('roomEntrance', selectedRoomEntrance);

                @this.set('zone', selectedZones);

                @this.set('year', selectedYear);

                @this.set('floor', selectedFloor);

                @this.set('transactionType', selectedTransactionType);

                @this.call('applyFilters');
            });
        });
    </script>
@endpush

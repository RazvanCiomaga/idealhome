<div>
    <section class="breadcumb-area bg-img" style="background-image: url(img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title">{{ label('Pagina proprietate') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                                    <select id="select-transaction-types" class="form-control" wire:model="offerType">
                                        <option value="none" @if($offerType === 'none') selected @endif>{{ label('Selecteaza tipul tranzactiei') }}</option>
                                        @foreach($filters['offerTypes'] as $key => $value)
                                            <option value="{{ $key }}" @if($key === $offerType) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                <div class="form-group">
                                    <select id="select-estate-type" class="form-control" wire:model="estateType">
                                        <!-- 'none' option is always available for resetting the filter -->
                                        <option value="none" @if($estateType === 'none') selected @endif>{{ label('Selecteaza tipul proprietatii') }}</option>
                                        @foreach($filters['estateTypes'] as $key => $value)
                                            <option value="{{ $key }}" @if($key === $roomEntrance) selected @endif>{{ $value }}</option>
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
                                </div>
                                <!-- Submit -->
                                <div class="form-group mb-0">
                                    <button type="button" id="apply-filters" class="btn south-btn" wire:click="applyFilters">{{ label('Cauta') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="listings-content-wrapper section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Single Listings Slides -->
                    <div class="single-listings-sliders owl-carousel">
                        @foreach($this->estate?->images ?? [] as $image)
                            <img src="{{ $image }}" alt="{{ $this->estate?->title }}" class="img-fluid" style="height: 70vh; object-fit: contain;">
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="listings-content">
                        <!-- Price -->
                        <div class="list-price d-flex">
                            @if ($this->estate?->facebook_url)<a href="{{ $this->estate->facebook_url }}" target="_blank"><img src="img/icons/facebook.png" alt=""/></a>@endif
                            <p>€{{ $this->estate?->sale_price > 0 ? number_format($this->estate->sale_price, 2, ',', '.') : number_format($this->estate->rent_price, 2, ',', '.')  }}</p>
                        </div>
                        <h5> {{ $this->estate?->title }}</h5>
                        <p class="location"><img src="img/icons/location.png" alt="">{{ $this->estate?->zone }}</p>
                        <p>{!! $this->estate?->description ?? '' !!}</p>
                        <!-- Meta -->
                        <div class="property-meta-data d-flex align-items-end">
                            <div class="new-tag">
                                <img src="img/icons/new.png" alt="">
                            </div>
                            <div class="bathroom">
                                <img src="img/icons/bathtub.png" alt="">
                                <span>{{ $this->estate?->bathrooms }}</span>
                            </div>
                            <div class="garage">
                                <img src="img/icons/garage.png" alt="">
                                <span>{{ $this->estate?->rooms }}</span>
                            </div>
                            <div class="space">
                                <img src="img/icons/space.png" alt="">
                                <span>{{ $this->estate?->area }} &#13217;</span>
                            </div>
                        </div>
                        <!-- Core Features -->
                        <ul class="listings-core-features row">
                            @foreach($this->estate?->getFormattedProperties() as $property)
                                <li class="col-12 col-md-6"><i class="fa fa-check" aria-hidden="true"></i> {{ $property }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="contact-realtor-wrapper">
                        <div class="realtor-info">
                            <img src="{{ $this->agent?->picture }}" alt="">
                            <div class="realtor---info">
                                <h2>{{ $this->agent?->name }}</h2>
                                <p>{{ ucfirst($this->agent?->position ?? '') }}</p>
                                <h6><img src="img/icons/phone-call.png" alt=""> {{ $this->agent?->phone }}</h6>
                                <h6><img src="img/icons/envelope.png" alt=""> {{ $this->agent?->email }}</h6>
                            </div>
                            <div class="realtor--contact-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="realtor-name" placeholder="{{ label('Nume') }}" wire:model="clientName">
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" id="realtor-number" placeholder="{{ label('Nr. telefon') }}" wire:model="clientPhone">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" id="realtor-email" placeholder="{{ label('Email') }}" wire:model="clientEmail">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" class="form-control" id="realtor-message" cols="30" rows="10" placeholder="{{ label('Mesaj...') }}" wire:model="clientMessage"></textarea>
                                </div>
                                <button type="button" class="btn south-btn" wire:click="sendMessage">{{ label('Contacteaza agentul') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Listing Maps -->
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <div class="listings-maps mt-100">--}}
{{--                        <div id="googleMap"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
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
            const estateTypesInput = $('#select-estate-type').select2();

            // Local variables to store selected values
            let selectedRoomEntrance = 'none';
            let selectedZones = 'none';
            let selectedYear = 'none';
            let selectedFloor = 'none';
            let selectedTransactionType = 1;
            let selectedEstateType = 'none';

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

            estateTypesInput.on('change', function () {
                selectedEstateType = $(this).val(); // Store selected floor locally
            });

            document.querySelector('#apply-filters').addEventListener('click', function () {
                // Set Livewire properties right before calling applyFilters()

            @this.set('roomEntrance', selectedRoomEntrance);

            @this.set('zone', selectedZones);

            @this.set('year', selectedYear);

            @this.set('floor', selectedFloor);

            @this.set('offerType', selectedTransactionType);

            @this.set('estateType', selectedEstateType);

            @this.call('applyFilters');
            });
        });
    </script>
@endpush

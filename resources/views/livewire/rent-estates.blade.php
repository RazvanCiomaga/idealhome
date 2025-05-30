<div>
    <section class="breadcumb-area bg-img" style="background-image: url(img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title">{{ $this->title }}</h3>
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
                                <div class="col-12 col-md-8 col-lg-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="input" wire:model.live="searchTerm" placeholder="{{ label('Cauta...') }}" style="background-color: #fff; border: 1px solid #aaa; border-radius: 4px; height: 1.75rem;">
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                    <div class="form-group">
                                        <select id="select-estate-type" class="form-control" wire:model="estateType">
                                            <!-- 'none' option is always available for resetting the filter -->
                                            <option value="none" @if($this->estateType === 'none') selected @endif>{{ label('Selecteaza tipul proprietatii') }}</option>
                                            @foreach($this->filters['estateTypes'] as $key => $value)
                                                <option value="{{ $key }}" @if($key == $this->estateType) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                    <div class="form-group">
                                        <select id="select-room-entrance" class="form-control" wire:model="roomEntrance">
                                            <!-- 'none' option is always available for resetting the filter -->
                                            <option value="none" @if($this->roomEntrance === 'none') selected @endif>{{ label('Selecteaza compartimentarea') }}</option>
                                            @foreach($this->filters['roomEntrances'] as $key => $value)
                                                <option value="{{ $key }}" @if($key === $this->roomEntrance) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                    <div class="form-group">
                                        <select id="zones" class="form-control" wire:model="zone">
                                            <!-- 'none' option for zone, similar to roomEntrance -->
                                            <option value="{{ $this->defaultSelect }}" @if($this->zone === $this->defaultSelect) selected @endif>{{ label('Selecteaza zona') }}</option>
                                            @foreach($this->filters['zones'] as $key => $value)
                                                <option value="{{ $key }}" @if($key === $this->zone) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                    <div class="form-group">
                                        <select id="floors" class="form-control" wire:model="floor">
                                            <!-- 'none' option for floor -->
                                            <option value="{{ $this->defaultSelect }}" @if($this->floor === $this->defaultSelect) selected @endif>{{ label('Selecteaza etaj') }}</option>
                                            @foreach($this->filters['floors'] as $key => $value)
                                                <option value="{{ $key }}" @if($key == $this->floor) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                    <div class="form-group">
                                        <select id="year" class="form-control" wire:model="year">
                                            <!-- 'none' should not be selected as default here, so 'year' is empty -->
                                            <option value="{{ $this->defaultSelect }}" @if($this->year === '') selected @endif>{{ label('Selecteaza anul constructiei') }}</option>
                                            @foreach($this->filters['construction_year'] as $key => $value)
                                                <option value="{{ $key }}" @if($key === $this->year) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-4 col-lg-3" wire:ignore>
                                    <div class="form-group">
                                        <select id="rooms" class="form-control" wire:model="rooms">
                                            <option value="{{ $this->defaultSelect }}" @if($this->floor === $this->defaultSelect) selected @endif>{{ label('Selecteaza numar camere') }}</option>
                                            @foreach($this->filters['rooms'] as $key => $value)
                                                <option value="{{ $key }}" @if($key == $this->rooms) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-12 d-flex justify-content-between align-items-end">
                                    <!-- More Filter -->
                                    <div class="more-filter">
                                        <button type="button" class="btn" id="moreFilter" wire:click="clearFilters">{{ label('Sterge filtre') }}</button>
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
    <!-- ##### Advance Search Area End ##### -->

    <!-- ##### Listing Content Wrapper Area Start ##### -->
    <section class="listings-content-wrapper section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="listings-top-meta d-flex justify-content-between mb-100">
                        <div class="order-by-area d-flex align-items-center">
                            <span class="mr-15">{{ label('Ordoneaza rezultate') }}</span>
                            <select wire:model.live="sortOption">
                                <option value="{{ $this->defaultSelect }}" @if($this->sortOption === $this->defaultSelect) selected @endif>
                                @foreach($this->sortOptions as $key => $value)
                                    <option value="{{ $key }}" @if($key === $this->sortOption) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if ($this->getEstates()->total() > 0)
                    @foreach($this->getEstates() as $estate)
                        <!-- Single Featured Property -->
                        <div class="col-12 col-md-6 col-xl-4">
                            <div class="single-featured-property mb-50">
                                <!-- Property Thumbnail -->
                                <div class="property-thumb">
                                    <img src="{{ $estate->featured_image }}" alt="{{ $estate->title . 'featured image' }}" style="height: 250px; width: 100%">

                                    <div class="tag">
                                        <a href="{{ route('estate.show', ['slug' => $estate->slug]) }}">
                                            <span>{{ label('Tag inchiriere') }} </span>
                                        </a>
                                    </div>
                                    <div class="list-price">
                                        <a href="{{ route('estate.show', ['slug' => $estate->slug]) }}">
                                            <p>€{{ number_format($estate->rent_price, 2, ',', '.') }}</p>
                                        </a>
                                    </div>
                                </div>
                                <!-- Property Content -->
                                <div class="property-content">
                                    <a href="{{ route('estate.show', ['slug' => $estate->slug]) }}">
                                        <h5>{{ $estate->title . ' - ' . $estate->construction_year . ' - ' . $estate->room_entrances }}</h5>
                                    </a>
                                    <p class="location"><img src="img/icons/location.png" alt="">{{ $estate->zone }}</p>
                                    <p>{{ substr(strip_tags($estate->description), 0, 100) . '...' }}</p>
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
                        </div>
                    @endforeach
                @else
                    <div class="d-flex justify-content-center align-items-center vh-100 col-12 col-md-6 col-xl-4">
                        {{ label('Nu sunt rezultate') }}
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-12">
                    {{ $this->getEstates()->links() }}
                </div>
            </div>
        </div>
    </section>
        <!-- ##### Listing Content Wrapper Area End ##### -->
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectRoomEntranceInput = $('#select-room-entrance').select2();
            const zonesInput = $('#zones').select2();
            const yearInput = $('#year').select2();
            const floorsInput = $('#floors').select2();
            const estateTypesInput = $('#select-estate-type').select2();
            const roomsInput = $('#rooms').select2();

            // Local variables to store selected values
            let selectedRoomEntrance = 'none';
            let selectedZones = 'none';
            let selectedYear = 'none';
            let selectedFloor = 'none';
            let selectedEstateType = 'none';
            let selectedRooms = 'none';

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

            estateTypesInput.on('change', function () {
                selectedEstateType = $(this).val(); // Store selected floor locally
            });

            roomsInput.on('change', function () {
                selectedRooms = $(this).val(); // Store selected floor locally
            });

            document.querySelector('#apply-filters').addEventListener('click', function () {
                // Set Livewire properties right before calling applyFilters()

            @this.set('roomEntrance', selectedRoomEntrance);

            @this.set('zone', selectedZones);

            @this.set('year', selectedYear);

            @this.set('floor', selectedFloor);

            @this.set('estateType', selectedEstateType);

            @this.set('rooms', selectedRooms);

            @this.call('applyFilters');
            });
        });
    </script>
@endpush

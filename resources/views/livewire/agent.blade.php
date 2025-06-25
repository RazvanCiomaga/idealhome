<div>
    <section class="breadcumb-area bg-img" style="background-image: url('{{ asset('img/bg-img/hero1.jpg') }}');">
    </section>

    <section class="listings-content-wrapper section-padding-50">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <img class="card-img-top" src="{{ $agent?->picture ?? 'img/bg-img/team1.jpg' }}" alt="">
                        <div class="card-body text-center">
                            <img src="{{ asset('img/icons/prize.png') }}" alt="">
                            <p class="card-text">{{ strlen($agent?->position ?? '') ? ucfirst($agent?->position) : label('Agent') }}</p>
                            <h6><img src="{{ asset('img/icons/phone-call.png') }}" alt=""> {{ $agent?->phone }}</h6>
                            <h6><img src="{{ asset('img/icons/envelope.png') }}" alt=""> {{ $agent?->email }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 pt-1">
                    <h2> {{ $agent?->name }} </h2>
                    <div>
                        {!! $agent?->description ?? '' !!}
                    </div>

                    <div class="row mt-2 pt-1">
                        <div class="col-12 pt-2">
                            <h5> {{ label('Anunturile agentului') }} </h5>
                        </div>
                        @if ($this->getEstates()->total() > 0)
                            @foreach($this->getEstates() as $estate)
                                <!-- Single Featured Property -->
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="single-featured-property mb-50">
                                        <!-- Property Thumbnail -->
                                        <div class="property-thumb">
                                            <img src="{{ $estate->featured_image }}" alt="{{ $estate->title . 'featured image' }}" style="height: 200px; width: 100%">

                                            <div class="tag">
                                                <a href="{{ route('estate.show', ['slug' => $estate->slug]) }}">
                                                    <span>{{ label('Tag vanzare') }} </span>
                                                </a>
                                            </div>
                                            <div class="list-price">
                                                <a href="{{ route('estate.show', ['slug' => $estate->slug]) }}">
                                                    <p>€{{ number_format($estate->sale_price, 2, ',', '.') }}</p>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Property Content -->
                                        <div class="property-content">
                                            <a href="{{ route('estate.show', ['slug' => $estate->slug]) }}">
                                                <h5>{{ $estate->title . ' - ' . $estate->construction_year . ' - ' . $estate->room_entrances }}</h5>
                                            </a>
                                            <p class="location"><img src="{{ asset('img/icons/location.png') }}" alt=""> {{ $estate->zone }}</p>
                                            <p>{{ substr(strip_tags($estate->description), 0, 50) . '...' }}</p>
                                            <div class="property-meta-data d-flex align-items-end justify-content-between">
                                                <div class="new-tag">
                                                    <img src="{{ asset('img/icons/new.png') }}" alt="">
                                                </div>
                                                <div class="bathroom">
                                                    <img src="{{ asset('img/icons/bathtub.png') }}" alt="">
                                                    <span>{{ $estate->bathrooms }}</span>
                                                </div>
                                                <div class="garage">
                                                    <img src="{{ asset('img/icons/garage.png') }}" alt="">
                                                    <span>{{ $estate->rooms }}</span>
                                                </div>
                                                <div class="space">
                                                    <img src="{{ asset('img/icons/space.png') }}" alt="">
                                                    <span>{{ $estate->area }} &#13217;</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="d-flex justify-content-center align-items-center vh-100 col-12 col-md-6 col-xl-4">
                                {{ label('Agentul nu are proprietati publicate in acest moment.') }}
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-12">
                            {{ $this->getEstates()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

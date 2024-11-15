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

    <section class="listings-content-wrapper section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Single Listings Slides -->
                    <div class="single-listings-sliders owl-carousel">
                        @foreach($this->estate->images as $image)
                            <img src="{{ $image }}" alt="{{ $this->estate->title }}" class="img-fluid" style="height: 70vh; object-fit: contain;">
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="listings-content">
                        <!-- Price -->
                        <div class="list-price">
                            <p>€{{ $this->estate->sale_price > 0 ? number_format($this->estate->sale_price, 2, ',', '.') : number_format($this->estate->rent_price, 2, ',', '.')  }}</p>
                        </div>
                        <h5>{{ $this->estate->title }}</h5>
                        <p class="location"><img src="img/icons/location.png" alt="">{{ $this->estate->zone }}</p>
                        <p>{{ $this->estate->description ?? '' }}</p>
                        <!-- Meta -->
                        <div class="property-meta-data d-flex align-items-end">
                            <div class="new-tag">
                                <img src="img/icons/new.png" alt="">
                            </div>
                            <div class="bathroom">
                                <img src="img/icons/bathtub.png" alt="">
                                <span>{{ $this->estate->bathrooms }}</span>
                            </div>
                            <div class="garage">
                                <img src="img/icons/garage.png" alt="">
                                <span>{{ $this->estate->rooms }}</span>
                            </div>
                            <div class="space">
                                <img src="img/icons/space.png" alt="">
                                <span>{{ $estate->area }} &#13217;</span>
                            </div>
                        </div>
                        <!-- Core Features -->
                        <ul class="listings-core-features d-flex align-items-center">
                            @foreach($this->estate->getFormattedProperties() as $property)
                                <li><i class="fa fa-check" aria-hidden="true"></i> {{ $property }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="contact-realtor-wrapper">
                        <div class="realtor-info">
                            <img src="{{ $this->agent->picture }}" alt="">
                            <div class="realtor---info">
                                <h2>{{ $this->agent->name }}</h2>
                                <p>{{ ucfirst($this->agent->position) }}</p>
                                <h6><img src="img/icons/phone-call.png" alt=""> {{ $this->agent->phone }}</h6>
                                <h6><img src="img/icons/envelope.png" alt=""> {{ $this->agent->email }}</h6>
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

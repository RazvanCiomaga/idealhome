 <div>
        <!-- ##### Breadcumb Area Start ##### -->
        <section class="breadcumb-area bg-img" style="background-image: url(img/bg-img/hero1.jpg);">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-12">
                        <div class="breadcumb-content">
                            <h3 class="breadcumb-title">{{ label('Pagina contact') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- ##### Breadcumb Area End ##### -->

        <section class="south-contact-area section-padding-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="contact-heading">
                            <h6>{{ label('Informatii contact') }}</h6>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="content-sidebar">
                            <!-- Office Hours -->
                            <div class="weekly-office-hours">
                                <ul>
                                    <li class="d-flex align-items-center justify-content-between">
                                        <span>{{ label('Luni - Vineri') }}</span> <span>{{ $this->agency?->weekly_hours }}</span></li>
                                    <li class="d-flex align-items-center justify-content-between"><span>{{ label('Sambata') }}</span>
                                        <span>{{ $this->agency?->saturday_hours }}</span></li>
                                    <li class="d-flex align-items-center justify-content-between"><span>{{ label('Duminica') }}</span> <span>{{ $this->agency?->sunday_hours }}</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- Address -->
                            <div class="address mt-30">
                                <h6><img src="img/icons/phone-call.png" alt=""> {{ $this->agency?->phone }}</h6>
                                <h6><img src="img/icons/envelope.png" alt=""> {{ $this->agency?->email }}</h6>
                                <h6><img src="img/icons/location.png" alt=""> {{ $this->agency?->address }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form Area -->
                    <div class="col-12 col-lg-8">
                        <div class="contact-form">
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
                            <button type="button" class="btn south-btn" wire:click="sendMessage">{{ label('Contacteaza-ne') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

            <!-- Google Maps -->
        <div class="map-area mb-100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div id="googleMap" class="googleMap">
                            <div style="overflow:hidden;max-width:100%;height:30rem;"><div id="display-google-map" style="height:100%; width:100%;max-width:100%;"><iframe style="height:100%;width:100%;border:0;" frameborder="0" src="https://www.google.com/maps/embed/v1/place?q=ideal+home+iasi&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8"></iframe></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
 </div>

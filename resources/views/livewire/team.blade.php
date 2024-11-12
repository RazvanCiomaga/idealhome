<div>
    <section class="breadcumb-area bg-img" style="background-image: url(img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title">Team</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="meet-the-team-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading">
                        <h2>Meet The Team</h2>
                        <p>Suspendisse dictum enim sit amet libero</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @foreach($this->agents as $agent)
                    <div class="col-12 col-sm-6 col-lg-4">
                        <div class="single-team-member mb-100 wow fadeInUp" data-wow-delay="250ms">
                            <!-- Team Member Thumb -->
                            <div class="team-member-thumb">
                                <img src="{{ $agent->picture }}" alt="{{ $agent->name . ' ' . 'profile' }}">
                            </div>
                            <!-- Team Member Info -->
                            <div class="team-member-info">
                                <div class="section-heading">
                                    <img src="img/icons/prize.png" alt="">
                                    <h2>{{ $agent->name }}</h2>
                                    <p>{{ strlen($agent->position ?? '') ? ucfirst($agent->position) : 'Agent' }}</p>
                                </div>
                                <div class="address">
                                    <h6><img src="img/icons/phone-call.png" alt=""> {{ $agent->phone }}</h6>
                                    <h6><img src="img/icons/envelope.png" alt=""> {{ $agent->email }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

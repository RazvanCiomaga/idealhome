<div>
    <section class="breadcumb-area bg-img" style="background-image: url(img/bg-img/hero1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="breadcumb-content">
                        <h3 class="breadcumb-title">{{ label('Titlu pagina echipa') }}</h3>
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
                        <h2>{{ label('Intalneste echipa') }}</h2>
                        <p>{{ label('Intalneste echipa scurta descriere.') }}</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                @foreach($this->agents ?? [] as $agent)
                    <div class="col-12 col-sm-6 col-lg-4 mb-3">
                        <div class="card">
{{--                            <img class="card-img-top" src="{{ $agent->picture }}" alt="{{ $agent->name . ' ' . ($agent->position ?? '') }}" style="height: 40vh;">--}}
                            <img class="card-img-top" src="img/bg-img/team1.jpg" alt="" style="height: 40vh;">
                            <div class="card-body text-center">
                                <img src="img/icons/prize.png" alt="">
                                <h5 class="card-title">{{ $agent->name }}</h5>
                                <p class="card-text">{{ strlen($agent->position ?? '') ? ucfirst($agent->position) : label('Agent') }}</p>
                                <h6><img src="img/icons/phone-call.png" alt=""> {{ $agent->phone }}</h6>
                                <h6><img src="img/icons/envelope.png" alt=""> {{ $agent->email }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</div>

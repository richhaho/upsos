<!-- Start new-shop-here section -->
    <section class="new-shop-here sec-m">
        <div class="container">
            <div class="row">
                <div class="col-12 wow animate fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms">
                    <div class="sec-title layout-2 special">
                        <div class="title-left">
                            <h2>{{ $ps->partner_title }}</h2>
                            <p>{{ strip_tags($ps->partner_text) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="slick-wrapper wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="0.2s">
                    <div id="shop-arrival" class="d-flex justify-content-center">
                        @foreach ($partners as $partner)
                        <div class="slide-item">
                            <div class="new-shop">
                                <img src="{{ asset('assets/images/'.$partner->photo) }}" alt="">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- End new-shop-here section -->
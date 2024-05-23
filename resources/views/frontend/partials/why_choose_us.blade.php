    <!-- Start why-choose-two section -->
    <section class="why-choose-two sec-m-top">
        <div class="container-fluid p-0">
            <div class="why-choose-two-wrapper">
                <div class="why-choose-two-left">
                    <img src="{{ asset('assets/images/'.$ps->choose_us_photo) }}" alt="">
                </div>
                <div class="why-choose-two-right">
                    <div class="why-choose-two-cnt">
                        <h2 class=" wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">{{ $ps->choose_us_title }}</h2>
                        <p class=" wow animate fadeInUp" data-wow-delay="300ms" data-wow-duration="1500ms">
                            @php
                                echo $ps->choose_us_text;
                            @endphp
                        </p>
                        <div class="choose-reasons">
                            @foreach ($features as $feature)
                            <div class="single-reason wow animate fadeInLeft" data-wow-delay="{{ $loop->iteration.'00' +100 }}ms" data-wow-duration="1500ms">
                                <div class="icon text-white-50">
                                    <i class="{{ $feature->icon }}"></i>
                                </div>
                                <div class="choose-cnt">
                                    <h4>{{ $feature->title }}</h4>
                                    <p>
                                        @php
                                            echo $feature->details;
                                        @endphp
                                    </p>
                                </div>
                            </div>
                            @endforeach
                            
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End why-choose-two section -->

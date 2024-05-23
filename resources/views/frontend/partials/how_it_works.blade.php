 <!-- Start how-it-works-two section -->
 <section class="how-it-works-two sec-m-top">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="work-process-left">
                    <h2 class=" wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">{{ $ps->start_title }}</h2>
                    <span class=" wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                        @php
                            echo $ps->start_text;
                        @endphp
                    </span>

                    @foreach ($account_process as $data)
                    <div class="process-step wow animate fadeInUp" data-wow-delay="{{ $loop->iteration *200 }}ms" data-wow-duration="1500ms">
                        <div class="icon">
                            <i><span>0{{ $loop->iteration }}</span><img src="{{ asset('assets/images/'.$data->icon) }}" alt=""></i>
                        </div>
                        <div class="step-cnt">
                            <h4>{{ $data->title }}</h4>
                            <p>{{ strip_tags($data->details) }}
                               
                            </p>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
            <div class="col-lg-6 wow animate fadeInDown" data-wow-delay="200ms" data-wow-duration="1500ms">
                <div class="work-process-right">
                    <img src="{{ asset('assets/images/'.$ps->start_photo) }}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End how-it-works-two section -->

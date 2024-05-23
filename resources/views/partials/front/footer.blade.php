 <!-- Start footer section -->
 <footer class="footer-1 sec-m-top">
    <img src="{{ asset('assets/front/footer-left-shape.png') }}" alt="" class="line-shape">
    <div class="container">
        <div class="footer-top">
            <div class="row gy-5">
                <div class="col-md-6 col-lg-5">
                    <div class="footer-widget with-logo">
                        <div class="footer-logo">
                            <a href="{{ route('front.index') }}"><img src="{{asset('assets/images/'.$gs->footer_logo)}}" alt=""></a>
                        </div>
                        <p>{{ $gs->footer }}</p>
                        <div class="request-btn">
                            <a href="{{ route('front.allservices') }}">@lang('Request a Service')</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="footer-widget">
                        <h4>@lang('Explore On')</h4>

                        <ul class="footer-menu">
                            @foreach(json_decode($gs->menu,true) as $key => $menue)
   <li><a href="{{ url($menue['href']) }}" target="{{ $menue['target'] == 'blank' ? '_blank' : '_self' }}">@lang($menue['title'])</a></li>
                            @endforeach
                        </ul>

                    </div>
                </div>
                <div class="col-md-6 col-lg-2">
                    <div class="footer-widget">
                        <h4>@lang('Categories')</h4>
                        <ul class="footer-menu">
                             @foreach ($categories->take(7) as $data)
                            <li><a href="{{ route('front.servicecategory',$data->slug) }}">{{ $data->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="footer-widget">
                        <h4>@lang('Misc Information')</h4>
                        <div class="information">
						<ul class="footer-menu">
                             
							<li><div class="info"><div class="icon"><i class="fas fa-user-shield"></i></div><div class="desc"><a href="/privacy">@lang('Privacy & Policy')</a></div></div></li>
							<li><div class="info"><div class="icon"><i class="fas fa-h-square"></i></div><div class="desc"><a href="/supports">@lang('Help & Support')</a></div></div></li>
					<li><div class="info"><div class="icon"><i class="far fa-question-circle"></i></div><div class="desc"><a href="/frequently-asked-questions">@lang('FAQ')</a></div></div></li>
							

  <li><div class="info"><div class="icon"><i class="fas fa-list"></i></div><div class="desc"><a href="/about">@lang('About Us')</a></div></div></li>



<li><div class="info"><div class="icon"><i class="far fa-envelope"></i></div><div class="desc"><a href="/contact">@lang('Contact Us')</a></div></div></li>

 </ul>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="copy-right">
                        <span>
                            @php
                            echo $gs->copyright;
                        @endphp
                        </span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer-social-media">
                        <ul>
                            <li><a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="https://www.pinterest.com"><i class="fab fa-pinterest-p"></i></a></li>
                            <li><a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End footer section -->
    
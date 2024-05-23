<div class="header-logo">

    <a href="{{ route('front.index') }}"><img src="{{asset('assets/images/'.$gs->logo)}}" alt=""></a>

</div>

<div class="main-menu">

    <nav class="main-nav">

        <div class="mobile-menu-logo">

            <a href="{{ route('front.index') }}"><img src="{{asset('assets/images/'.$gs->logo)}}" alt=""></a>

            <div class="remove">

                <i class="bi bi-plus-lg"></i>

            </div>

        </div>

        <ul>

            @foreach(json_decode($gs->menu,true) as $key => $menue)

            <li><a href="{{ url($menue['href']) }}"
                    target="{{ $menue['target'] == 'blank' ? '_blank' : '_self' }}">@lang($menue['title']) </a></li>

            @endforeach



            <!-- @if ($pages->count()>0)

            <li class="has-child">

                <a href="#">@lang('Pages')</a>

                <i class="bi bi-chevron-down"></i>

                <ul class="sub-menu">

                    @foreach ($pages as $page)

                    <li><a href="{{ route('front.page',$page->slug) }}">{{ $page->title }}</a></li>

                    @endforeach

                </ul>

            </li>

            @endif
 -->

<li class="me-3 chatify-indicator" style="position:relative;">

                    <a href="{{ route('chatify') }}"><i class="fas fa-envelope" title="View Unread Messages"></i>
                        <span class="unread_messages_indicator">&nbsp;</span>
                    </a>
                </li>




        </ul>



        <div class="my-account">

            @auth
            @if (auth()->user()->is_seller == 1)
            <a href="{{ route('user.dashboard') }}">@lang('Dashboard') </a>
            @else
            <a href="{{ route('buyer.dashboard') }}">@lang('Dashboard') </a>
            @endif
            @endauth

            @guest

            <a href="{{ route('user.login') }}">@lang('Login Now')</a>

            @endguest

        </div>



    </nav>

</div>

<div class="header-right">



    <div class="phone">



        <div class="change-language mx-2">

            <select name="language" class="language selectors nice language-bar form-control">

                @foreach(DB::table('languages')->get() as $language)

                <option value="{{route('front.language',$language->id)}}" {{ Session::has('language') ? (
                    Session::get('language')==$language->id ? 'selected' : '' ) :
                    (DB::table('languages')->where('is_default','=',1)->first()->id == $language->id ? 'selected' : '')
                    }} >

                    {{$language->language}}

                </option>

                @endforeach

            </select>

        </div>



        <div class="change-language">

            <select name="currency" class="currency selectors nice language-bar form-control">

                @foreach(DB::table('currencies')->get() as $currency)

                <option value="{{route('front.currency',$currency->id)}}" {{ Session::has('currency') ? (
                    Session::get('currency')==$currency->id ? 'selected' : '' ) :
                    (DB::table('currencies')->where('is_default','=',1)->first()->id == $currency->id ? 'selected' : '')
                    }}>

                    {{$currency->name}}

                </option>

                @endforeach

            </select>

        </div>

        <div class="mx-2 d-flex align-items-center justify-content-center">
            <div class="form-check form-switch">
                <input class="form-check-input online-switcher" name="is_service_online" type="checkbox" id="check" >
            </div>
        </div>



    </div>



    <div class="account-btn">

        @auth

        @auth
        @if (auth()->user()->is_seller == 1)
        <a href="{{ route('user.dashboard') }}">@lang('Dashboard') </a>
        @else
        <a href="{{ route('buyer.dashboard') }}">@lang('Dashboard') </a>
        @endif
        @endauth

        @endauth

        @guest

        <a href="{{ route('user.login') }}">@lang('Login Now')</a>

        @endguest

    </div>

    <div class="mobile-menu">

        <a href="javascript:void(0)" class="cross-btn">

            <span class="cross-top"></span>

            <span class="cross-middle"></span>

            <span class="cross-bottom"></span>

        </a>

    </div>

</div>
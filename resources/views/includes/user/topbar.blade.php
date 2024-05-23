<div class="dashboard-header bg--gradient">

    <div class="navbar-top">

        <div class="container-fluid">

            <ul class="d-flex align-items-center justify-content-between py-1 py-md-0">

                <li>

                    <div class="nav-toggle me-3">

                        <span></span>

                        <span></span>

                        <span></span>

                    </div>

                </li>

                <li class="me-3">

                    <div class="change-language">

                        <select name="language" class="language selectors nice language-bar">

                            @foreach(DB::table('languages')->get() as $language)

                                <option value="{{route('front.language', $language->id)}}" {{ Session::has('language') ? (Session::get('language') == $language->id ? 'selected' : '') : (DB::table('languages')->where('is_default', '=', 1)->first()->id == $language->id ? 'selected' : '') }} >

                                    {{$language->language}}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </li>

                <li class="me-3" style="position:relative;">

                    <a href="{{ route('chatify') }}"><i class="fas fa-envelope" title="View Unread Messages"></i>
                        <span class="unread_messages_indicator">&nbsp;</span>
                    </a>
                </li>

                <li class="ms-auto me-2">

                    <div class="change-language">

                        <select name="currency" class="currency selectors nice language-bar">

                            @foreach(DB::table('currencies')->get() as $currency)

                                <option value="{{route('front.currency', $currency->id)}}" {{ Session::has('currency') ? (Session::get('currency') == $currency->id ? 'selected' : '') : (DB::table('currencies')->where('is_default', '=', 1)->first()->id == $currency->id ? 'selected' : '') }}>

                                    {{$currency->name}}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </li>

                <li class="me-2">

                    <div class="mode--toggle">

                        <i class="fas fa-moon"></i>

                    </div>

                </li>

                <li class="position-relative">

                    <a href="javascript:void(0)" class="dashboard-header-profile">
                        @if(auth()->user()->is_provider == 1)
                        <img src="{{ auth()->user()->is_provider ? asset(auth()->user()->photo) : asset('assets/images/avatars/avatar.png')}}" alt="No Image">
                        @else
                        <img src="{{ auth()->user()->photo ? asset('assets/images/avatars/' . auth()->user()->photo) : asset('assets/images/avatars/avatar.png') }}" alt="clients">
                        @endif

                        <div class="name d-none d-sm-block">

                           {{ auth()->user()->name }}

                        </div>

                    </a>

                    <div class="user-toggle-menu">

                        <ul>

                            <li>

                                <a href="{{ auth::user()->is_seller == 1 ? route('user.change.password.form') : route('buyer.change.password.form') }}">

                                    <i class="fas fa-unlock"></i>

                                    @lang('Change Password')

                                </a>

                            </li>

                            <li>

                                <a href="{{ auth::user()->is_seller == 1 ? route('user.show2faForm') : route('buyer.show2faForm') }}">

                                    <i class="fas fa-user-check"></i>

                                    @lang('2FA Security')

                                </a>

                            </li>

                            <li>

                                <a href="{{ auth::user()->is_seller == 1 ? route('user.logout') : route('buyer.logout') }}">

                                    <i class="fas fa-sign-out-alt"></i>

                                    @lang('Logout')

                                </a>

                            </li>

                        </ul>

                    </div>

                </li>

            </ul>

        </div>

    </div>

</div>
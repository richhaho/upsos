<aside class="dashboard-sidebar">
    <div class="bg--gradient">&nbsp;</div>
    <div class="dashboard-sidebar-inner">
        <div class="user-sidebar-header">
            <a href="{{ route('front.index') }}">
                <img src="{{asset('assets/images/'.$gs->logo)}}" alt="logo">
            </a>
            <div class="sidebar-close">
                <span class="close">&nbsp;</span>
            </div>
        </div>
        <div class="user-sidebar-body">
            <ul class="user-sidbar-link">

                    <span class="subtitle">@lang('General Information')</span>
                </li>
                <li>
                    <a href="{{ route('buyer.dashboard') }}" class="{{ request()->routeIs('buyer.dashboard') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-archive"></i></span>
                        @lang('Dashboard')
                    </a>
                </li>

                <li>
                    <a href="{{ route('buyer.transaction') }}" class="{{ request()->routeIs('buyer.transaction') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-briefcase"></i></span>
                        @lang('Transactions')
                    </a>
                </li>


                <li>
                    <span class="subtitle">@lang('Jobs')</span>
                </li>

                <li>
                    <a href="{{ route('buyer.jobs') }}" class="{{ request()->routeIs('buyer.jobs') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-tree"></i></span>
                        @lang('Jobs')
                    </a>
                </li>

                <li>
                    <a href="{{ route('buyer.jobrequest') }}" class="{{ request()->routeIs('buyer.jobrequest') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-tree"></i></span>
                        @lang('Job Request')
                    </a>
                </li>

                <li>
                    <a href="{{ route('buyer.job.allorder') }}" class="{{ request()->routeIs('buyer.jobrequest') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-tree"></i></span>
                        @lang('Job Orders')
                    </a>
                </li>

                <li>
                    <span class="subtitle">@lang('Services')</span>
                </li>

                <li>
                    <a href="{{ route('buyer.service.allorder') }}" class="{{ request()->routeIs('buyer.service.allorder') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-tree"></i></span>
                        @lang('All Service Order')
                    </a>
                </li>

                

                <li>
                    <span class="subtitle">@lang('Deposits')</span>
                </li>
                <li>
                    <a href="{{ route('buyer.deposit.create') }}" class="{{ request()->routeIs('buyer.deposit.create') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-business-time"></i></span>
                        @lang('Create Deposit')
                    </a>
                </li>
                <li>
                    <a href="{{ route('buyer.deposit.index') }}" class="{{ request()->routeIs('buyer.deposit.index') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-history"></i></span>
                        @lang('Deposit History')
                    </a>
                </li>
                
                <li>
                    <span class="subtitle">@lang('Payouts')</span>
                </li>
                <li>
                    <a href="{{ route('buyer.withdraw.index') }}" class="{{ request()->routeIs('user.withdraw.index') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-donate"></i></span>
                        @lang('Payout')
                    </a>
                </li>
                <li>
                    <a href="{{ route('buyer.withdraw.history') }}" class="{{ request()->routeIs('user.withdraw.history') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-history"></i></span>
                        @lang('Payout History')
                    </a>
                </li>
                
                <li>
                    <span class="subtitle">@lang('Account Information')</span>
                </li>
                <li>
                    <a href="{{ route('buyer.message.index') }}" class="{{ request()->routeIs('buyer.message.index') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-question-circle"></i></span>
                        @lang('Support Ticket')
                    </a>
                </li>
                <li>
                    <a href="{{ route('buyer.profile.index') }}" class="{{ request()->routeIs('buyer.profile.index') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-user-circle"></i></span>
                        @lang('Edit Profile')
                    </a>
                </li>
                <li>
                    <a href="{{ route('buyer.show2faForm') }}" class="{{ request()->routeIs('buyer.show2faForm') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-lock-open"></i></span>
                        @lang('2FA Security')
                    </a>
                </li>

                <li>
                    <a href="{{ route('buyer.change.password.form') }}" class="{{ request()->routeIs('buyer.change.password.form') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-question-circle"></i></span>
                        @lang('Change Password')
                    </a>
                </li>

                <li>
                    <a href="{{ route('buyer.logout') }}">
                        <span class="icon"><i class="fas fa-exchange-alt"></i></span>
                        @lang('Logout')
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
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

                <li>
                    <span class="subtitle">@lang('General Information')</span>
                </li>
                <li>
                    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-archive"></i></span>
                        @lang('Dashboard')
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.transaction') }}" class="{{ request()->routeIs('user.transaction') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-briefcase"></i></span>
                        @lang('Transactions')
                    </a>
                </li>

                <li>
                    <span class="subtitle">@lang('Job Orders')</span>
                </li>


                <li>
                    <a href="{{ route('user.all.job.request') }}" class="{{ request()->routeIs('user.all.job.request') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-briefcase"></i></span>
                        @lang('Applied Jobs')
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.job.order') }}" class="{{ request()->routeIs('user.job.orders') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-briefcase"></i></span>
                        @lang('Job Orders')
                    </a>
                </li>

                <li>
                    <span class="subtitle">@lang('Service Order')</span>
                </li>
                <li>
                    <a href="{{ route('user.service.order','all') }}" class="{{ request()->routeIs('user.service.order','all') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-tree"></i></span>
                        @lang('All Orders')
                    </a>

                    <a href="{{ route('user.service.order','pending') }}" class="{{ request()->routeIs('user.service.order','pending') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-tree"></i></span>
                        @lang('Pending Orders')
                    </a>

                    <a href="{{ route('user.service.order','active') }}" class="{{ request()->routeIs('user.service.order','active') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-tree"></i></span>
                        @lang('Active Orders')
                    </a>

                    <a href="{{ route('user.service.order','completed') }}" class="{{ request()->routeIs('user.service.order','completed') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-tree"></i></span>
                        @lang('Completed Orders')
                    </a>
                </li>

                <li>
                    <span class="subtitle">@lang('Invest')</span>
                </li>
                <li>
                    <a href="{{ route('user.invest.plans') }}" class="{{ request()->routeIs('user.invest.plans') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-tree"></i></span>
                        @lang('Plans')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.service') }}" class="{{ request()->routeIs('user.invest.plans') ? 'active' : ''}}">
                        <span class="icon"><i class="fa fa-cogs"></i></span> 
                        @lang('Services')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.add.schedule') }}" class="{{ request()->routeIs('user.invest.plans') ? 'active' : ''}}">
                        <span class="icon"><i class="fa fa-clock"></i></span>
                        @lang('Schedule')
                    </a>
                </li>

                <li>
                    <span class="subtitle">@lang('Deposits')</span>
                </li>
                <li>
                    <a href="{{ route('user.deposit.create') }}" class="{{ request()->routeIs('user.deposit.create') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-business-time"></i></span>
                        @lang('Create Deposit')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.deposit.index') }}" class="{{ request()->routeIs('user.deposit.index') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-history"></i></span>
                        @lang('Deposit History')
                    </a>
                </li>
                
                <li>
                    <span class="subtitle">@lang('Payouts')</span>
                </li>
                <li>
                    <a href="{{ route('user.withdraw.index') }}" class="{{ request()->routeIs('user.withdraw.index') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-donate"></i></span>
                        @lang('Payout')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.withdraw.history') }}" class="{{ request()->routeIs('user.withdraw.history') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-history"></i></span>
                        @lang('Payout History')
                    </a>
                </li>

                
                
                <li>
                    <span class="subtitle">@lang('Account Information')</span>
                </li>
                <li>
                    <a href="{{ route('user.message.index') }}" class="{{ request()->routeIs('user.message.index') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-question-circle"></i></span>
                        @lang('Support Ticket')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.profile.index') }}" class="{{ request()->routeIs('user.profile.index') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-user-circle"></i></span>
                        @lang('Edit Profile')
                    </a>
                </li>
                <li>
                    <a href="{{ route('user.show2faForm') }}" class="{{ request()->routeIs('user.show2faForm') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-lock-open"></i></span>
                        @lang('2FA Security')
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.change.password.form') }}" class="{{ request()->routeIs('user.change.password.form') ? 'active' : ''}}">
                        <span class="icon"><i class="fas fa-question-circle"></i></span>
                        @lang('Change Password')
                    </a>
                </li>

                <li>
                    <a href="{{ route('user.logout') }}">
                        <span class="icon"><i class="fas fa-exchange-alt"></i></span>
                        @lang('Logout')
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
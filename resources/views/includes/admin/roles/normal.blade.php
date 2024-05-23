@if(Auth::guard('admin')->user()->role_id != 0)

  @if(Auth::guard('admin')->user()->sectionCheck('Menu Builder'))
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.gs.menubuilder') }}">
      <i class="fas fa-compass"></i>
      <span>{{ __('Menu Builder') }}</span></a>
  </li>
  @endif



  @if(Auth::guard('admin')->user()->sectionCheck('Manage Plan'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manage_plan" aria-expanded="true"
      aria-controls="collapseTable">
      <i class="fab fa-telegram-plane"></i>
      <span>{{  __('Manage Plan') }}</span>
    </a>
    <div id="manage_plan" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.plans.index') }}">{{ __('All Plans') }}</a>
      </div>
    </div>
  </li>
  @endif


  @if(Auth::guard('admin')->user()->sectionCheck('Seller Subscription'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manage_plan" aria-expanded="true" aria-controls="collapseTable">
        <i class="fas fa-user"></i>
        <span>{{  __('Seller Subscription') }}</span>
    </a>
    <div id="manage_plan" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.pending-plans.index') }}">{{ __('Pending Plans') }}</a>
            <a class="collapse-item" href="{{ route('admin.approved-plans.index') }}">{{ __('Approved Plans') }}</a>
        </div>
    </div>
</li>
  @endif


  @if(Auth::guard('admin')->user()->sectionCheck('Manage Category'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manage_categories" aria-expanded="true" aria-controls="collapseTable">
        <i class="fab fa-telegram-plane"></i>
        <span>{{  __('Manage Categories') }}</span>
    </a>
    <div id="manage_categories" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.categories.index') }}">{{ __('All Categories') }}</a>
            <a class="collapse-item" href="{{ route('admin.subcategories.index') }}">{{ __('All SubCategories') }}</a>
        </div>
    </div>
</li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Service Area'))

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#service-area" aria-expanded="true" aria-controls="collapseTable">
        <i class="fab fa-telegram-plane"></i>
        <span>{{  __('Services Area') }}</span>
    </a>
    <div id="service-area" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="{{ route('admin.country.index') }}">{{ __('Countries') }}</a>
            <a class="collapse-item" href="{{ route('admin.cities.index') }}">{{ __('Cities') }}</a>
            <a class="collapse-item" href="{{ route('admin.areas.index') }}">{{ __('Areas') }}</a>
        </div>
    </div>
</li>

@endif




@if(Auth::guard('admin')->user()->sectionCheck('Services'))

<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manage-services" aria-expanded="true" aria-controls="collapseTable">
      <i class="fab fa-telegram-plane"></i>
      <span>{{  __('Services') }}</span>
	   <?php $pendingServicesCount = \App\Models\Service::where('status',0)->count(); ?>
            @if($pendingServicesCount > 0)
                <span class="badge badge-danger">{{ $pendingServicesCount }}</span>
            @endif
  </a>
  <div id="manage-services" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="{{ route('admin.services.index') }}">{{ __('All Services') }}</a>
          <a class="collapse-item" href="{{ route('admin.services.pending') }}">{{ __('Pending Services') }}</a>
          <a class="collapse-item" href="{{ route('admin.services.completed') }}">{{ __('Completed Services') }}</a>
          <a class="collapse-item" href="{{ route('admin.services.declined') }}">{{ __('Declined Services') }}</a>
      </div>
  </div>
</li>

@endif

@if(Auth::guard('admin')->user()->sectionCheck('All Job'))
<li class="nav-item">
  <a class="nav-link" href="{{ route('admin.jobs.index') }}">
      <i class="fas fa-chart-line"></i>
      <span>{{ __('All jobs') }}</span>
	   <?php $pendingJobsCount = \App\Models\Job::where('status',0)->count(); ?>
            @if($pendingJobsCount > 0)
                <span class="badge badge-danger">{{ $pendingJobsCount }}</span>
            @endif
  </a>
</li>

<li class="nav-item">
        <a class="nav-link" href="{{ route('admin.jobs.index') }}">
            <i class="fas fa-chart-line"></i>
            <span>{{ __('All jobs') }}</span>
            <?php $pendingJobsCount = \App\Models\Job::where('status',0)->count(); ?>
            @if($pendingJobsCount > 0)
                <span class="badge badge-danger">{{ $pendingJobsCount }}</span>
            @endif
        </a>
    </li>


@endif


@if(Auth::guard('admin')->user()->sectionCheck('All Orders'))

<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#all-order" aria-expanded="true" aria-controls="collapseTable">
      <i class="fab fa-telegram-plane"></i>
      <span>{{  __('All Orders') }}</span>
	  <?php $pendingServiceOrdersCount = \App\Models\ServiceOrder::where('status',0)->count(); ?>
            @if($pendingServiceOrdersCount > 0)
                <span class="badge badge-danger">{{ $pendingServiceOrdersCount }}</span>
            @endif
  </a>
  <div id="all-order" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="{{ route('admin.orders.index') }}">{{ __('All Orders') }}</a>
          <a class="collapse-item" href="{{ route('admin.orders.cancelled') }}">{{ __('Cancelled Order') }}</a>
          
      </div>
  </div>
</li>

@endif


@if(Auth::guard('admin')->user()->sectionCheck('Manage KYC Form'))
<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#customer" aria-expanded="true" aria-controls="collapseTable">
            <i class="fas fa-user"></i>
            <span>{{  __('Manage Customers') }}</span>
                <?php $pendingUsersCount = \App\Models\User::where('kyc_status',0)->count(); ?>
            @if($pendingUsersCount > 0)
                <span class="badge badge-danger">{{ $pendingUsersCount }}</span>
            @endif
        </a>
        <div id="customer" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.user.index') }}">{{ __('User List') }}</a>
                <a class="collapse-item" href="{{ route('admin.kyc.info','user')}}">{{ __('User KYC Info') }}
				 <?php $pendingKycCount = \App\Models\User::all()->whereNotNull('kyc_info')->where('kyc_status',3)->count(); ?>
            @if($pendingKycCount > 0)
                <span class="badge badge-danger">{{ $pendingKycCount }}</span>
            @endif
				</a>


                <a class="collapse-item" href="{{route('admin.manage.module')}}">{{ __('User KYC Modules') }}</a>

            </div>
        </div>
    </li>

@endif



  @if(Auth::guard('admin')->user()->sectionCheck('Transactions'))
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.transactions.index') }}">
      <i class="fas fa-chart-line"></i>
      <span>{{ __('Transactions') }}</span>
    </a>
  </li>
  @endif
  

@if(Auth::guard('admin')->user()->sectionCheck('Commissions'))

<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#commisson" aria-expanded="true" aria-controls="collapseTable">
      <i class="fab fa-cc-mastercard"></i>
      <span>{{  __('Commissons') }}</span>
  </a>
  <div id="commisson" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
          <a class="collapse-item" href="{{ route('admin.commission.index') }}">{{ __('Admin Commissions') }}</a>
          <a class="collapse-item" href="{{ route('admin.commission.setting') }}">{{ __('Commission Setting') }}</a>
      </div>
  </div>
</li>

@endif




  @if(Auth::guard('admin')->user()->sectionCheck('Withdraws'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#withdraw" aria-expanded="true"
      aria-controls="collapseTable">
      <i class="fab fa-cc-mastercard"></i>
      <span>{{  __('Withdraws') }}</span>
	  <?php $pendingWithdrawsCount = \App\Models\Withdraw::where('status',1)->count(); ?>
            @if($pendingWithdrawsCount > 0)
                <span class="badge badge-danger">{{ $pendingWithdrawsCount }}</span>
            @endif
    </a>
    <div id="withdraw" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.withdraw.index') }}">{{ __('Withdraw Request') }}</a>
        <a class="collapse-item" href="{{ route('admin-withdraw-method-index') }}">{{ __('Withdraw Method') }}</a>

      </div>
    </div>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Deposits'))
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.deposits.index') }}">
      <i class="fas fa-piggy-bank"></i>
      <span>{{ __('Deposits') }}</span>
	   <?php $pendingDepositsCount = \App\Models\Deposit::where('status', 1)->count(); ?>
            @if($pendingDepositsCount > 0)
                <span class="badge badge-danger">{{ $pendingDepositsCount }}</span>
            @endif
    </a>
  </li>
  @endif



  @if(Auth::guard('admin')->user()->sectionCheck('Manage Blog'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#blog" aria-expanded="true"
      aria-controls="collapseTable">
      <i class="fas fa-fw fa-newspaper"></i>
      <span>{{  __('Manage Blog') }}</span>
    </a>
    <div id="blog" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.cblog.index') }}">{{ __('Categories') }}</a>
        <a class="collapse-item" href="{{ route('admin.blog.index') }}">{{ __('Posts') }}</a>
      </div>
    </div>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('General Setting'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable1" aria-expanded="true"
      aria-controls="collapseTable">
      <i class="fas fa-fw fa-cogs"></i>
      <span>{{  __('General Settings') }}</span>
    </a>
    <div id="collapseTable1" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.gs.logo') }}">{{ __('Logo') }}</a>
        <a class="collapse-item" href="{{ route('admin.gs.fav') }}">{{ __('Favicon') }}</a>
        <a class="collapse-item" href="{{ route('admin.gs.load') }}">{{ __('Loader') }}</a>
        <a class="collapse-item" href="{{ route('admin.gs.breadcumb') }}">{{ __('Breadcumb Banner') }}</a>
        <a class="collapse-item" href="{{ route('admin.gs.contents') }}">{{ __('Website Contents') }}</a>
        <a class="collapse-item" href="{{ route('admin.country.index') }}">{{ __('Manage Countries') }}</a>
        <a class="collapse-item" href="{{ route('admin.gs.footer') }}">{{ __('Footer') }}</a>
        <a class="collapse-item" href="{{ route('admin.gs.error.banner') }}">{{ __('Error Banner') }}</a>
        <a class="collapse-item" href="{{ route('admin.gs.maintenance') }}">{{ __('Website Maintenance') }}</a>
      </div>
    </div>
  </li>
  @endif


  {{-- @if(Auth::guard('admin')->user()->sectionCheck('Tax'))
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.taxes.index') }}">
        <i class="fas fa-swimmer"></i>
        <span>{{ __('Tax') }}</span>
    </a>
</li>
  @endif --}}

  @if(Auth::guard('admin')->user()->sectionCheck('Homepage Manage'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#homepage" aria-expanded="true"
    aria-controls="collapseTable">
    <i class="fas fa-igloo"></i>
    <span>{{ __('Home Page Manage') }}</span>
  </a>
    <div id="homepage" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.ps.hero') }}">{{ __('Hero Section') }}</a>
        <a class="collapse-item" href="{{ route('admin.ps.about') }}">{{ __('About Us Section') }}</a>
        <a class="collapse-item" href="{{ route('admin.counter.index') }}">{{ __('About Us Counter') }}</a>
        <a class="collapse-item" href="{{ route('admin.partners.index') }}">{{ __('Partners') }}</a>
        <a class="collapse-item" href="{{ route('admin.account.process.index') }}">{{ __('How To Start') }}</a>

        <a class="collapse-item" href="{{ route('admin.feature.index') }}">{{ __('Feature Section') }}</a>
        <a class="collapse-item" href="{{ route('admin.review.index') }}">{{ __('Testimonial Section') }}</a>

        <a class="collapse-item" href="{{ route('admin.ps.heading') }}">{{ __('Section Heading') }}</a>
        <a class="collapse-item" href="{{ route('admin.ps.customization') }}">{{ __('Homepage Customization') }}</a>
      </div>
    </div>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Email Setting'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#email_settings" aria-expanded="true"
      aria-controls="collapseTable">
      <i class="fa fa-envelope"></i>
      <span>{{  __('Email Settings') }}</span>
    </a>
    <div id="email_settings" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.mail.index') }}">{{ __('Email Template') }}</a>
        <a class="collapse-item" href="{{ route('admin.mail.config') }}">{{ __('Email Configurations') }}</a>
        <a class="collapse-item" href="{{ route('admin.group.show') }}">{{ __('Group Email') }}</a>
      </div>
    </div>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Message'))
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.user.message') }}">
      <i class="fas fa-vote-yea"></i>
      <span>{{ __('Messages') }}</span></a>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Payment Setting'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#payment_gateways" aria-expanded="true"
      aria-controls="collapseTable">
      <i class="fas fa-fw fa-newspaper"></i>
      <span>{{  __('Payment Settings') }}</span>
    </a>
    <div id="payment_gateways" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.currency.index') }}">{{ __('Currencies') }}</a>
        <a class="collapse-item" href="{{ route('admin.payment.index') }}">{{  __('Payment Gateways')  }}</a>
      </div>
    </div>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Manage Roles'))
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.role.index') }}">
      <i class="fa fa-crop"></i>
      <span>{{ __('Manage Roles') }}</span></a>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Manage Staff'))
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.staff.index') }}">
      <i class="fas fa-fw fa-users"></i>
      <span>{{ __('Manage Staff') }}</span></a>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Manage KYC Form'))
  <li class="nav-item">
    <a class="nav-link" href="{{route('admin.manage.kyc.user','user')}}">
      <i class="fas fa-child"></i>
      <span>{{ __('Manage KYC Form') }}</span></a>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Language Manage'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#langs" aria-expanded="true"
      aria-controls="collapseTable">
      <i class="fas fa-language"></i>
      <span>{{  __('Language Manage') }}</span>
    </a>
    <div id="langs" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{route('admin.lang.index')}}">{{ __('Website Language') }}</a>
        <a class="collapse-item" href="{{route('admin.tlang.index')}}">{{ __('Admin Panel Language') }}</a>
      </div>
    </div>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Fonts'))
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.font.index') }}">
      <i class="fas fa-font"></i>
      <span>{{ __('Fonts') }}</span></a>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Menupage Setting'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#menu" aria-expanded="true"
      aria-controls="collapseTable">
      <i class="fas fa-fw fa-edit"></i>
      <span>{{  __('Menu Page Settings') }}</span>
    </a>
    <div id="menu" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('admin.ps.contact') }}">{{ __('Contact Us Page') }}</a>
        <a class="collapse-item" href="{{ route('admin.page.index') }}">{{ __('Other Pages') }}</a>
      </div>
    </div>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Seo Tools'))
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#seoTools" aria-expanded="true"
      aria-controls="collapseTable">
      <i class="fas fa-wrench"></i>
      <span>{{  __('SEO Tools') }}</span>
    </a>
    <div id="seoTools" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{route('admin.seotool.analytics')}}">{{ __('Google Analytics') }}</a>
        <a class="collapse-item" href="{{route('admin.social.links.index')}}">{{ __('Social Links') }}</a>
        <a class="collapse-item" href="{{ route('admin.social.facebook') }}">{{ __('Facebook Login') }}</a>
        <a class="collapse-item" href="{{ route('admin.social.google') }}">{{ __('Google Login') }}</a>
      </div>
    </div>
  </li>
  @endif

  @if(Auth::guard('admin')->user()->sectionCheck('Sitemaps'))
  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.sitemap.index') }}">
      <i class="fa fa-sitemap"></i>
      <span>{{ __('Sitemaps') }}</span></a>
  </li>
  @endif

  <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.cache.clear') }}">
      <i class="fas fa-sync"></i>
      <span>{{ __('Clear Cache') }}</span></a>
  </li>


@endif



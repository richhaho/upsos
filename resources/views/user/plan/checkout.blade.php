@if ($plan->price == 0)

@include('user.plan.freeplan')

@else

@include('user.plan.payment')
    
@endif
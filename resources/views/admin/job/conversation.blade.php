
@extends('layouts.admin')

@section('content')


    <div class="card">
        <div class="d-sm-flex align-items-center py-3 justify-content-between">

        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="javascript:;">{{ __('Job Conversation') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.jobs.index') }}">{{ __('All Message') }}</a></li>
        </ol>
        </div>
    </div>


    <!-- Row -->
    <div class="row mt-3">
      <!-- Datatables -->
      <div class="col-lg-12">

        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body text--dark">
                                <h5 class="card-title my-4 text--dark">@lang('All Conversation')</h5>
                            
                                @foreach ($messages as $message)
                                <div class="single-reply-area user mb-3">
                                   
                                    <div class="row">
                                        
                                       <div class="col-lg-12 mb-3">
                                          <div class="reply-area">
                                             <div class="left">
                                                <p><strong>{{ $message->user_type=='seller' ? "Seller: " : "Buyer:" }}</strong>  {{ $message->message }}</p>
                                             </div>
                                             <div class="right">

                                                @if ($message->user_type == 'seller')
                                                @php
                                                     $user = DB::table('users')->where('id',$message->seller_id)->first();
                                                @endphp
                                                @else
                                                @php
                                                     $user = DB::table('users')->where('id',$message->buyer_id)->first();
                                                @endphp
                                                @endif

                                                <img class="img-circle" src="{{ $user->photo ? asset('assets/images/'.$user->photo) : asset('assets/front/images/clients/client1.jpg') }}" alt="">
                                               
                                                <p class="ticket-date my-2">{{ $user->name }}</p>
                                             </div>
                                          </div>
                                       </div>
                                       
                                    </div>
                                    
                                 </div>
                                 @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>



      </div>
    </div>


@endsection


@section('scripts')


@endsection

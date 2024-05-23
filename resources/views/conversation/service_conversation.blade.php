@extends('layouts.user')

@push('css')
    
@endpush

@section('contents')
<div class="breadcrumb-area">
    <h3 class="title">@lang('Service Conversation')</h3>
    <ul class="breadcrumb">
        <li>
          <a href="{{ route('user.dashboard') }}">@lang('Dashboard')</a>
        </li>
  
        <li>
            @lang('Service Conversation')
        </li>
    </ul>
</div>

<div class="dashboard--content-item ">
    <div class="row g-3">
      <div class="col-12">
        <div class="card default--card">
            <div class="card-body">

                        <div class="message-card p-5">
                            <div class="card p-2">
                                <div class="card-body text--dark">
                                    <h5 class="card-title my-4 text--dark">@lang('All Conversation')</h5>
                                
                                    @foreach ($messages as $message)
                                    <div class="single-reply-area user mb-3">
                                       
                                        <div class="row">
                                            
                                           <div class="col-lg-12 mb-3">
                                              <div class="reply-area">
                                                 <div class="left">
                                                    <p><strong>{{ $message->user_type=='seller' ? "Seller: " : "Buyer:" }}</strong>  {{ $message->message }}</p>
                                                    <br>
                                                    <p>@lang('Attachment'): <a href="{{ asset('assets/file/'.$message->attachment) }}" download>{{ $message->attachment }}</a> </p>
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
               
                <form class="mt-5 p-5" id="request-form" action="{{ Auth::user()->is_seller ==1 ? route('user.service.conversation.store',$serviceorder->id) : route('buyer.service.conversation.store',$serviceorder->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="seller_id" value="{{ $serviceorder->seller_id }}">
                    <input type="hidden" name="buyer_id" value="{{ $serviceorder->buyer_id }}">
                    <input type="hidden" name="service_id" value="{{ $serviceorder->service_id }}">
                    <input type="hidden" name="user_type" value="{{ Auth::user()->is_seller==1 ? 'seller' : 'buyer'}}">
                    <input type="hidden" name="work_type" value="service">
    
                    <div class="row gy-3 gy-md-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">{{__('Message')}}</label>
                                <textarea name="message" class="form-control nic-edit @error('message') is-invalid @enderror" cols="30" rows="5" placeholder="{{__('Enter Message')}}"></textarea>
                                @error('message')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
    
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror">
                                @error('attachment')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
    
    
                        <div class="col-sm-12">
                            <label class="form-label d-none d-sm-block">&nbsp;</label>
                            <button type="submit" class="cmn--btn bg--primary submit-btn w-100 border-0">{{__('Submit')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
  </div>
@endsection


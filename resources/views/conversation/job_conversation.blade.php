@extends('layouts.user') @push('css') @endpush @section('contents')
<div class="breadcrumb-area">
    <h3 class="title">@lang('Job Conversation')</h3>
    <ul class="breadcrumb">
        <li>
            <a href="{{ route('buyer.dashboard') }}">@lang('Dashboard')</a>
        </li>

        <li>
            @lang('Job Conversation')
        </li>
    </ul>
</div>

<div class="dashboard--content-item">
    <div class="row g-3">
        <div class="col-12">
            <div class="card default--card">
                <div class="card-body">
                    <div class="d-flex justify-content-between p-5">
                        <div class="details my-4">
                            <h6 class="mb-4">@lang('Job Offer Details')</h6>
                            <div class="data ms-3">
                                <div class="div my-2">
                                    <label for=""> <strong>@lang('Job Request ID:')</strong> #{{ $jobrequest->id }} </label>
                                </div>
                                <div class="div my-2">
                                    <label for=""> <strong>@lang('Job Title:')</strong> {{ $jobrequest->job_title }} </label>
                                </div>
                                <div class="div my-2">
                                    <label for=""> <strong>@lang('Offer Price:')</strong> {{ showAmount($jobrequest->seller_offer) }} </label>
                                </div>
                            </div>
                        </div>

                        @if (Auth::user()->id == $jobrequest->buyer_id)
                        <div class="hire-btn">
                            @if(DB::table('job_orders')->where('job_request_id', $jobrequest->id)->exists())
                            <button type="button" class="btn btn-danger">
                                @lang('Already Hired')
                            </button>
                            @else
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                @lang('Hire Now')
                            </button>
                            @endif
                        </div>
                        @endif
                    </div>
                    <div class="message-card p-5">
                        <div class="card p-2">
                            <div class="card-body text--dark">
                                @if($messages->count() > 0)
                                <h5 class="card-title my-4 text--dark">@lang('All Conversation')</h5>

                                @foreach ($messages as $message)
                                <div class="single-reply-area user mb-3">
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <div class="reply-area">
                                                <div class="left">
                                                    <p><strong>{{ $message->user_type=='seller' ? "Seller: " : "Buyer:" }}</strong> {{ $message->message }}</p>
                                                    <br>
                                                    <p>@lang('Attachment'): <a href="{{ asset('assets/file/'.$message->attachment) }}" download>{{ $message->attachment }}</a> </p>
                                                </div>
                                                <div class="right">
                                                    @if ($message->user_type == 'seller') @php $user = DB::table('users')->where('id',$message->seller_id)->first(); @endphp @else @php $user =
                                                    DB::table('users')->where('id',$message->buyer_id)->first(); @endphp @endif

                                                    <img class="img-circle" src="{{ $user->photo ? asset('assets/images/'.$user->photo) : asset('assets/front/images/clients/client1.jpg') }}" alt="" />

                                                    <p class="ticket-date my-2">{{ $user->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else

                                <h4 class="card-title my-4 text--dark text-center">@lang('No Message Found!')</h4>
                                @endif

                            </div>
                        </div>
                    </div>

                    @includeIf('includes.flash')
                    <form class="mt-5 p-5" id="request-form" action="{{ Auth::user()->is_seller ==1 ? route('user.job.conversation.store',$jobrequest->id) : route('buyer.job.conversation.store',$jobrequest->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="seller_id" value="{{ $jobrequest->seller_id }}" />
                        <input type="hidden" name="buyer_id" value="{{ $jobrequest->buyer_id }}" />
                        <input type="hidden" name="job_id" value="{{ $jobrequest->job_id }}" />
                        <input type="hidden" name="user_type" value="{{ Auth::user()->is_seller==1 ? 'seller' : 'buyer'}}" />
                        <input type="hidden" name="work_type" value="job" />

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
                                    <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror" />
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

{{-- Job request Accept Modal --}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Payment')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buyer.wallet.submit') }}" method="POST">
                    @csrf
                    <label for=""> @lang('Pay From Wallet') ({{ showAmount(Auth::user()->balance) }})</label>
                    <div class="d-flex align-items-center mt-4">
                        <input type="hidden" name="job_id" value="{{ $jobrequest->job_id }}" />

                        <div class="input-group flex-grow-1 ms-2 w-50">
                            <span class="input-group-text">{{ $defaultCurrency->sign }}</span>
                            <input value="{{ rootAmount($jobrequest->seller_offer) }}" type="text" disabled class="form-control" aria-label="Amount (to the nearest dollar)" />
                            <input type="hidden" value="{{ rootAmount($jobrequest->seller_offer) }}" name="price" />
                            <input type="hidden" value="{{ $jobrequest->id}}" name="id" />

                            <button type="submit" id="final-btn" class="mybtn1 cmn--btn input-group-text">{{ __('Submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

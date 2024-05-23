@extends('layouts.user')

@push('css')
    
@endpush

@section('contents')
<div class="breadcrumb-area">
  <h3 class="title">@lang('Job Order Details')</h3>
  <ul class="breadcrumb">
      <li>
          <a href="{{ route('buyer.job.allorder') }}">@lang('Job Order')</a>
      </li>
      <li>
          @lang('Job Order Details')
      </li>
  </ul>
</div>

<div class="dashboard--content-item">
  <div class="table-responsive-sm">
      <table class="table mb-0">
          <tbody>
          <tr class="border-top">
              <th class="45%" width="45%">{{__('Job Title')}}</th>
              <td width="10%">:</td>
              <td class="45%" width="45%">{{ $data->job->job_title }}</td>
          </tr>

          <tr>
              <th class="45%" width="45%">{{__('Seller Name')}}</th>
              <td width="10%">:</td>
              <td class="45%" width="45%"> {{ $data->seller->name }}</td>
          </tr>

          <tr>
              <th class="45%" width="45%">{{__('Amount')}}</th>
              <td width="10%">:</td>
              <td class="45%" width="45%">{{ showAmount($data->price) }}</td>
          </tr>

          <tr>
              <th class="45%" width="45%">{{__('Admin Fees')}}</th>
              <td width="10%">:</td>
              <td class="45%" width="45%">{{ $data->admin_commission_price== null ? '0' : showAmount($data->admin_commission_price) }}</td>
          </tr>

          <tr>
            <th class="45%" width="45%">{{__('Buyer will get')}}</th>
            <td width="10%">:</td>
            <td class="45%" width="45%">{{ $data->admin_commission_price== null ? showAmount($data->price) : showAmount($data->price-$data->admin_commission_price) }}</td>
        </tr>

          <tr>
            <th class="45%" width="45%">{{__('Payment Status')}}</th>
            <td width="10%">:</td>
            <td class="45%" width="45%">{{ $data->payment_status }}</td>
          </tr>

          <tr>
              <th class="45%" width="45%">{{__('Status')}}</th>
              <td width="10%">:</td>
              <td class="45%" width="45%">
                @if ($data->order_status == 'completed')
                  <span class="badge bg-success">{{__('Completed')}}</span>
                @elseif($data->order_status == 'pending')
                  <span class="badge bg-warning">{{__('Pending')}}</span>
                @else 
                  <span class="badge bg-danger">{{__('Rejected')}}</span>
                @endif
              </td>
          </tr>


          </tbody>
      </table>
  </div>
</div>


@endsection

@push('js')

@endpush

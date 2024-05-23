<div class="content-area no-padding">
    <div class="add-product-content1">
       <div class="row">
          <div class="col-lg-12">
             <div class="product-description">
                <div class="body-area">
                   <div class="table-responsive show-table">
                      <table class="table">
                         <tbody>
                            <tr>
                               <th width="50%">{{ __('Seller ID#') }}</th>
                               <td>{{ $user->id }}</td>
                            </tr>
                            <tr>
                               <th>{{ __('Name') }}</th>
                               <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                               <th>{{ __('Email') }}</th>
                               <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                               <th>{{ __('Phone') }}</th>
                               <td>{{ $user->phone }}</td>
                            </tr>
                            <tr>
                               <th>{{ __('Plan Title') }}</th>
                               <td>{{ $data->plan->title }}</td>
                            </tr>
                            <tr>
                               <th>{{ __('Plan Type') }}</th>
                               <td>{{ $data->plan_type }}</td>
                            </tr>
                            <tr>
                               <th>{{ __('Connet') }}</th>
                               <td>{{ $data->connect }}</td>
                            </tr>
                            <tr>
                               <th>{{ __('Payment Mathod') }}</th>
                               <td>{{ $data->method }}</td>
                            </tr>
                            <tr>
                               <th>{{ __('Price') }}</th>
                               <td>{{showAdminPrice($data->amount)}}</td>
                            </tr>

                            <tr>
                               <th>{{ __('Transaction ID') }}</th>
                               <td>{{ $data->txnid }}</td>
                            </tr>
                         </tbody>
                      </table>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
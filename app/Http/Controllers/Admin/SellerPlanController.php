<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Datatables;

class SellerPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function pending()
    {
        return view('admin.sellerplan.pending');
    }
    public function approved()
    {
        return view('admin.sellerplan.approved');
    }

    public function datatables($status){
        
            $datas = UserSubscription::where('status','=',$status)->orderBy('id','desc')->get();

        return Datatables::of($datas)
                            ->addColumn('checkbox',function(UserSubscription $data){
                                return $checkbox = $data->id ? '<input type="checkbox" class="form-check-input m-0 p-0 columnCheck" value="'.$data->id.'">':'';
                            })
                            ->editColumn('user', function(UserSubscription $data) {
                                
                                return  $data->user->name;
                            })
                            ->editColumn('plan', function(UserSubscription $data) {
                                return $data->plan->title;
                            })
                            
                            ->editColumn('price', function(UserSubscription $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                if($data->amount != NULL){
                                    $amount = showAdminPrice($data->amount);
                                }else{
                                    $amount = '';
                                }
                                return  $amount;
                            })
                            ->editColumn('method', function(UserSubscription $data) {
                                return $data->method;
                            })
                            ->editColumn('txnid', function(UserSubscription $data) {
                                return $data->txnid;
                            })
                            ->editColumn('time', function(UserSubscription $data) {
                                return \Carbon\Carbon::parse($data->created_at)->diffForHumans();
                            })
                            ->editColumn('status',function(UserSubscription $data){

                                if($data->payment_status == 'completed'){
                                    return '<span class="badge badge-success">Complete</span>';
                                }else{
                                    return '<span class="badge badge-warning">Pending</span>';
                                }

                              
                            })
                            ->addColumn('action', function(UserSubscription $data) {
                                $status      = $data->status == 1 ? __('Approved') : __('Pending');
                                $status_sign = $data->status == 1 ? 'success'   : 'warning';

                               if($data->status != 1){

                                
                                return '<div class="btn-group mb-1">
                                <button type="button" class="btn btn-'.$status_sign.' btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                '.$status.'
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.seller.plan.status',['id1' => $data->id, 'id2' => 0]).'">'.__("Pending").'</a>
                                <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.seller.plan.status',['id1' => $data->id, 'id2' => 1]).'">'.__("Completed").'</a>
                                </div>
                            </div>

                            <a href="javascript:;"  id="detail" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-sm btn-rounded mb-1" data-href="'.route('admin.sellerplans.details',$data->id).'">'.__("Details").'</a>
                            ';
                               }
                               else{
                                return '<a href="javascript:;"  id="detail" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-primary btn-sm btn-rounded mb-1" data-href="'.route('admin.sellerplans.details',$data->id).'">'.__("Details").'</a>
                                ';
                               }
                            
                                
                            })

                            
                            ->rawColumns(['checkbox','status','action'])
                            ->toJson();;

    }

    public function status($id1,$id2)
    {
        if($id2==0){
            $msg = __('You can not Update once you Approved!');
            return response()->json($msg);
        }
        else{
        $data = UserSubscription::findOrFail($id1);
        $data->status = $id2;
        $user = User::findOrFail($data->user_id);
        $plan = Plan::findOrFail($data->planid);
        $user->planid = $data->planid;
        $user->connect = $user->connect + $plan->connect;
        $user->service_limit = $user->service_limit + $plan->service;
        $user->job_limit = $user->job_limit + $plan->job;
        $user->plan_type = $data->plan_type;

$user->status = $data->status;

        if($data->plan_type == 'monthly'){
            $user->plan_expiredate = Carbon::now()->addMonth();
        }
        if($data->plan_type == 'yearly'){
            $user->plan_expiredate = Carbon::now()->addYear();
        }
        if($data->plan_type == 'lifetime'){
            $user->plan_expiredate = Carbon::now()->addYear(100);
        }
        $user->save();
        $data->update();
        $msg = __('Data Updated Successfully.');
        return response()->json($msg);

        }
    }

    public function sellerbulkdelete(Request $request){
        $ids = $request->bulk_id;
        $bulk_ids = explode(",",$ids);
        foreach($bulk_ids as $key=>$id){
           
            if($id){
                try {
                    $data = UserSubscription::findOrFail($id);
                    $data->delete();

                    $msg = 'Data Deleted Successfully.';
                } catch (\Throwable $th) {
                    $msg = 'Something went wrong.';
                }
            }
        }
        return response()->json($msg);
      
    }

    public function details($id)
    {
        $data = UserSubscription::findOrFail($id);
        $user=User::findOrFail($data->user_id);
        return view('admin.sellerplan.details',compact('data','user'));
    }


}

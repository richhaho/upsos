<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceOrder;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.order.index');
    }

    public function cancelled(){
        return view('admin.order.cancelled');
    }

    public function datatables($status){



        if($status == 0){
            $datas = ServiceOrder::where('status', 0)->get();
        }
        elseif($status == 1){
            $datas = ServiceOrder::where('status', 1)->get();
        }
        elseif($status == 2){
            $datas = ServiceOrder::where('status', 2)->get();
        }
        elseif($status == 3){
            $datas = ServiceOrder::where('status', 3)->get();
        }
        else{
            $datas = ServiceOrder::orderBy('id','desc')->get();
        }
        

        return Datatables::of($datas)


            ->editColumn('buyer_name', function ($data) {
                return $data->buyer->name;
            })
            ->editColumn('service_name', function ($data) {
                return Str::limit($data->service->title, 20) ;
            })
            ->editColumn('service_date', function ($data) {
                return $data->date;
            })
            ->editColumn('schedule', function ($data) {
                return $data->schedule;
            })


            ->editColumn('price', function ($data) {
                return showAdminPrice($data->total);
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('d M Y');
            })

            ->addColumn('payment_status', function ($data){
                if($data->payment_status == 'cancel'){
                    $status = '<span class="badge badge-danger">'.__('Cancel').'</span>';
                }

                elseif ($data->payment_status == 'completed'){
                    $status = '<span class="badge badge-success">'.__('Completed').'</span>';
                }
                else{
                    $status = '<div class="btn-group mb-1">
                    <button type="button" class="btn btn-warning btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.__('Pending').'
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start">
                        <a href="'.route('admin.orders.payment.status',['id'=> $data->id, 'slug'=>'completed']).'" class="dropdown-item">'.__('Accept').'</a>
                        <a href="'.route('admin.orders.payment.status',['id'=>$data->id, 'slug'=>'cancel']).'" class="dropdown-item">'.__('Cancel').'</a>
                    </div>
                </div>';

                }

                return $status;


            })

            ->addColumn('status', function($data) {
                if($data->status == 0){
                    $status  = __('Pending');
                    $status_sign = 'warning';
                }
                
                elseif($data->status == 1){
                    $status  = __('Active');
                    $status_sign = 'primary';
                }
                elseif($data->status == 3){
                    $status  = __('Cancel');
                    $status_sign = 'danger';
                }

                if($data->status == 2){
                    $div  = '<span class="badge badge-success">'.__('Completed').'</span>';
                }
                else{

                    $div = '<div class="btn-group mb-1">
                    <button type="button" class="btn btn-'.$status_sign.' btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.$status .'
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start">
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.orders.status',['id1' => $data->id, 'id2' => 0]).'">'.__("Pending").'</a>
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.orders.status',['id1' => $data->id, 'id2' => 1]).'">'.__("Active").'</a>
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.orders.status',['id1' => $data->id, 'id2' => 2]).'">'.__("Completed").'</a>
                        
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.orders.status',['id1' => $data->id, 'id2' => 3]).'">'.__("Cancelled").'</a>
                    </div>
                </div>';

                }

                return $div;
            })
            ->editColumn('order_type', function($data){
                if($data->is_online == 1){
                    $type = '<span class="badge badge-success">'.__('Online').'</span>';
                }
                else{
                    $type = '<span class="badge badge-primary">'.__('Offline').'</span>';
                }

                return $type;
            })

            ->addColumn('action', function( $data) {
                return '
                <a href="'.route('admin.orders.show', $data->id).'" class="btn btn-primary btn-sm btn-rounded"><i class="fa fa-eye"></i></a>';
          })

            ->rawColumns(['buyer_name','action','status','price','created_at','payment_status','order_type'])
            ->make(true);
    }


    public function paymentstatus($id, $slug){

        $data = ServiceOrder::findOrFail($id);
        $data->payment_status = $slug;
        $data->save();

        return redirect()->back()->with('success', __('Status changed successfully'));
    }

    public function status($id1, $id2){

        $data = ServiceOrder::findOrFail($id1);
        $data->status = $id2;
        $data->save();

        Toastr::success(__('Status changed successfully'));
        return redirect()->back();
    }

    public function show($id){
        $data = ServiceOrder::findOrFail($id);
        return view('admin.order.show', compact('data'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuyerSellerMessage;
use App\Models\Job;
use App\Models\Jobrequest;
use Illuminate\Http\Request;
use Datatables;

class JobController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(){

            $datas = Job::orderBy('id','desc')->get();


        return Datatables::of($datas)
            
            ->editColumn('email', function ($data) {
                return $data->buyer->email;
            })
            ->editColumn('budget', function ($data) {
                return rootAmount($data->budget).' '. globalCurrency()->sign ;
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->format('d M Y');
            })

            ->addColumn('status', function($data) {
                if($data->status == 0){
                    $status  = __('Pending');
                    $status_sign = 'warning';
                }
                elseif($data->status == 1){
                    $status  = __('Completed');
                    $status_sign = 'success';
                }
                elseif($data->status == 2){
                    $status  = __('Declined');
                    $status_sign = 'danger';
                }

                return '<div class="btn-group mb-1">
                    <button type="button" class="btn btn-'.$status_sign.' btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.$status .'
                    </button>
                    <div class="dropdown-menu" x-placement="bottom-start">
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.jobs.status',['id1' => $data->id, 'id2' => 0]).'">'.__("Pending").'</a>
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.jobs.status',['id1' => $data->id, 'id2' => 1]).'">'.__("Completed").'</a>
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.jobs.status',['id1' => $data->id, 'id2' => 2]).'">'.__("Declined").'</a>
                    </div>
                </div>';
            })
          
            ->addColumn('action', function(Job $data) {
                return '<div class="btn-group mb-1">
                  <button type="button" class="btn btn-primary btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.'Actions' .'
                  </button>
                  <div class="dropdown-menu" x-placement="bottom-start">
                    <a href="' . route('front.jobdetails',$data->job_slug) . '"  class="dropdown-item">'.__("view").'</a>
                    <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="dropdown-item" data-href="'.  route('admin.jobs.delete',$data->id).'">'.__("Delete").'</a>
                    <a href="' . route('admin.jobs.allrequests',$data->id) . '"  class="dropdown-item">'.__("All Request").'</a>
                  </div>
                </div>';
          })

            ->rawColumns(['email','action','status','budget','created_at'])
            ->make(true);
    }

    public function index()
    {
        return view('admin.job.index');
    }
    public function status($id1, $id2)
    {
        $service = Job::findOrFail($id1);

     

        if($service->status == 1){
            $msg = 'Completed data can not be changed.';
            return response()->json($msg);
        }
        $service->status = $id2;
        $service->save();
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
    }

    public function allrequests($id){
        $jobrequests= Jobrequest::where('job_id',$id)->paginate(10);
        return view('admin.job.allrequests',compact('jobrequests'));
    }

    public function conversation($id){
        $messages=BuyerSellerMessage::where('job_id',$id)->get();
        return view('admin.job.conversation',compact('messages'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Datatables;

class ServiceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables($status){

        if($status == 'pending'){
            $datas = Service::where('status', 0)->get();
        }
        elseif($status == 'completed'){
            $datas = Service::where('status', 1)->get();
        }
        elseif($status == 'declined'){
            $datas = Service::where('status', 2)->get();
        }
        else{
            $datas = Service::orderBy('id','desc')->get();
        }

        return Datatables::of($datas)

            
            
            ->editColumn('email', function ($data) {
                return $data->seller->email;
            })
            ->editColumn('price', function ($data) {
                return showAdminPrice($data->price);
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
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.services.status',['id1' => $data->id, 'id2' => 0]).'">'.__("Pending").'</a>
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.services.status',['id1' => $data->id, 'id2' => 1]).'">'.__("Completed").'</a>
                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.services.status',['id1' => $data->id, 'id2' => 2]).'">'.__("Declined").'</a>
                    </div>
                </div>';
            })

            ->addColumn('action', function(Service $data) {
                return '<div class="btn-group mb-1">
                  <button type="button" class="btn btn-primary btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    '.'Actions' .'
                  </button>
                  <div class="dropdown-menu" x-placement="bottom-start">
                    <a href="' . route('admin.services.details',$data->id) . '"  class="dropdown-item">'.__("views").'</a>
                    <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="dropdown-item" data-href="'.  route('admin.services.delete',$data->id).'">'.__("Delete").'</a>
                    <a   class="dropdown-item" href="'.  route('admin.services.highlight',$data->id).'">'.__("Highlight").'</a>

                  </div>
                </div>';
          })

            ->rawColumns(['user_email','action','status','price','created_at'])
            ->make(true);
    }

    public function index()
    {
        return view('admin.service.index');
    }

    public function pending()
    {
        return view('admin.service.pending');
    }

    public function completed()
    {
        return view('admin.service.completed');
    }
    public function declined()
    {
        return view('admin.service.declined');
    }

    public function details($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.service.details',compact('service'));
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);

        if($service->benefits ? $service->benefits->count() : 0 > 0){
            foreach($service->benefits as $benefit){
                if($benefit->image != null){
                    @unlink('assets/images/'.$benefit->image);
                }
                $benefit->delete();
            }

        }

        if($service->reviews ?  $service->reviews->count() : 0 > 0){
            foreach($service->reviews as $review){
                $review->delete();
            }
        }

        if($service->serviceorders ? $service->serviceorders->count(): 0 > 0){
            foreach($service->serviceorders as $serviceorder){
                $serviceorder->delete();
            }
        }

        if($service->includes ? $service->includes->count():0 > 0){
            foreach($service->includes as $include){
                $include->delete();
            }
        }

        if($service->additional ? $service->additional->count() : 0 > 0){
            foreach($service->additional as $additional){
                $additional->delete();
            }
        }
        if($service->image != null){
            @unlink('assets/images/'.$service->image);
        }
        
        $service->delete();
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
    }


    public function status(Request $request, $id1, $id2)
    {
        $service = Service::findOrFail($id1);
        if($service->status == 1){
            $msg = 'This service is already completed.';
            return response()->json($msg);
        }
        $service->status = $id2;
        $service->save();
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
    }

    public function highlight($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.service.highlight',compact('service'));
    }

    public function highlightUpdate(Request $request, $id)
    {
        foreach($request->all() as $key => $value){
            if($value == 'on'){
                $request->merge([$key => 1]);
            }
            else{
                $request->merge([$key => 0]);
            }
        }
        $service = Service::findOrFail($id);
        $input = $request->all();
        $service->update($input);
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
    }


    
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use Illuminate\Http\Request;
use Datatables;

class CommissionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        return view('admin.commission.index');
    }

    public function datatables(Request $request)
    {
         $datas = Commission::orderBy('id','desc');

         return Datatables::of($datas)
                        ->addColumn('checkbox',function(Commission $data){
                            return $checkbox = $data->id ? '<input type="checkbox" class="form-check-input m-0 p-0 columnCheck " value="'.$data->id.'">':'';
                        })
                        ->editColumn('customer_type', function(Commission $data) {
                            return $data->commision_from ;
                        })

                        ->editColumn('charge', function(Commission $data) {
                            return showAdminPrice($data->commision_charge) ;
                        })
                        ->editColumn('type', function(Commission $data) {
                            return $data->commission_method;
                        })

                            
                        ->addColumn('action', function(Commission $data) {
                              return '<a href=" ' . route('admin.commission.view',$data->id) . ' " class="btn btn-success"><i class="fas fa-eye text-light edit" ></i></a>';
                        })
                        ->rawColumns(['checkbox','photo','status','action'])
                        ->toJson();
    }

    public function setting()
    {
        return view('admin.commission.setting');
    }

    public function view($id)
    {
        $data = Commission::find($id);
        return view('admin.commission.view',compact('data'));
    }



    
}

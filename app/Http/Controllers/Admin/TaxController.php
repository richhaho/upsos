<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Tax;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Validator;

class TaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {
         $datas = Tax::orderBy('id','desc');

         return Datatables::of($datas)
                        ->editColumn('country_id', function(Tax $data) {
                            
                             return  $data->country != NULL ? $data->country->name : 'Country Deleted';
                        })
                        ->addColumn('status', function(Tax $data) {
                            $status      = $data->status == 1 ? __('Activated') : __('Deactivated');
                            $status_sign = $data->status == 1 ? 'success'   : 'danger';

                            return '<div class="btn-group mb-1">
                                    <button type="button" class="btn btn-'.$status_sign.' btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    '.$status .'
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start">
                                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.taxes.status',['id1' => $data->id, 'id2' => 1]).'">'.__("Activate").'</a>
                                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.taxes.status',['id1' => $data->id, 'id2' => 0]).'">'.__("Deactivate").'</a>
                                    </div>
                                </div>';
                        })
                        ->addColumn('action', function(Tax $data) {
                              return '<div class="btn-group mb-1">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  '.'Actions' .'
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                  <a href="' . route('admin.taxes.edit',$data->id) . '"  class="dropdown-item">'.__("Edit").'</a>
                                  <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="dropdown-item" data-href="'.  route('admin.taxes.delete',$data->id).'">'.__("Delete").'</a>
                                </div>
                              </div>';
                        })
                        ->rawColumns(['status','action'])
                        ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index()
    {
        return view('admin.taxes.index');
    }

    public function create()
    {
        $data['countries'] = Country::whereStatus(1)->get();
        return view('admin.taxes.create',$data);
    }

    public function store(Request $request)
    {
        $rules = [
            'tax'      => 'required',
            'country_id'=> 'required|unique:taxes'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }


        $data = new Tax();

        $input = $request->all();
        $data->fill($input)->save();

        $msg = __('New Data Added Successfully.').' '.'<a href="'.route('admin.taxes.index').'"> '.__('View Lists.').'</a>';
        return response()->json($msg);
    }


    public function edit($id)
    {
        $data['data'] = Tax::findOrFail($id);
        $data['countries'] = Country::whereStatus(1)->get();

        return view('admin.taxes.edit',$data);
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'tax'      => 'required',
            'country_id'=> 'required|unique:taxes,country_id,'.$id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Tax::findOrFail($id);
        $input = $request->all();
        $data->update($input);

        $msg = __('Data Updated Successfully.').' '.'<a href="'.route('admin.taxes.index').'"> '.__('View Lists.').'</a>';
        return response()->json($msg);
    }


    public function status($id1,$id2)
    {
        $data = Tax::findOrFail($id1);
        $data->status = $id2;
        $data->update();

        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
    }

    public function destroy($id)
    {
        $data = Tax::findOrFail($id)->delete();

        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
    }
}

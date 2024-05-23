<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Datatables;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {
         $datas = City::orderBy('id','desc');

         return Datatables::of($datas)
                        
                        ->editColumn('country_id', function(City $data) {
                            return $country = $data->country != NULL ? $data->country->name : 'Country Deleted';
                        })
                        ->addColumn('status', function(City $data) {
                            $status  = $data->status == 1 ? __('Activated') : __('Deactivated');
                            $status_sign = $data->status == 1 ? 'success'   : 'danger';

                            return '<div class="btn-group mb-1">
                                <button type="button" class="btn btn-'.$status_sign.' btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                '.$status .'
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                    <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.cities.status',['id1' => $data->id, 'id2' => 1]).'">'.__("Activate").'</a>
                                    <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.cities.status',['id1' => $data->id, 'id2' => 0]).'">'.__("Deactivate").'</a>
                                </div>
                            </div>';
                        })

                        ->addColumn('tax', function(City $data) {
                            return $data->tax . '%';
                        })

                        ->addColumn('action', function(City $data) {
                              return '<div class="btn-group mb-1">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  '.'Actions' .'
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                  <a href="' . route('admin.cities.edit',$data->id) . '"  class="dropdown-item">'.__("Edit").'</a>
                                  <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="dropdown-item" data-href="'.  route('admin.cities.delete',$data->id).'">'.__("Delete").'</a>
                                </div>
                              </div>';
                        })
                        ->rawColumns(['status','action','tax'])
                        ->toJson();
    }

    public function index()
    {
        return view('admin.cities.index');
    }

    public function create()
    {
        $data['countries'] = Country::whereStatus(1)->get();
        return view('admin.cities.create',$data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title'=> 'required',
            'country_id'=> 'required'
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $input = $request->all();
        City::create($input);
        $msg = __('Data Created Successfully.').' '.'<a href="'.route('admin.cities.index').'"> '.__('View Lists.').'</a>';
        return response()->json($msg);
    }


    public function edit($id)
    {
        $data['countries'] = Country::whereStatus(1)->get();
        $data['data'] = City::findOrFail($id);

        return view('admin.cities.edit',$data);
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'title'=> 'required',
            'country_id'=> 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = City::findOrFail($id);
        $input = $request->all();
        $data->update($input);

        $msg = __('Data Updated Successfully.').' '.'<a href="'.route('admin.cities.index').'"> '.__('View Lists.').'</a>';
        return response()->json($msg);
    }


    public function status($id1,$id2)
    {
        $data = City::findOrFail($id1);
        $data->status = $id2;
        $data->update();

        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
    }

    public function destroy($id)
    {
        try {
            $this->delete($id);
            $msg = 'Data Deleted Successfully.';
        } catch (\Throwable $th) {
            $msg = $th->getMessage();
        }
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
    }

    public function delete($id){
        $data = City::findOrFail($id);
        @unlink('assets/images/'.$data->photo);
        $data->delete();

        return true;
    }


}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {
         $datas = Area::orderBy('id','desc');

         return Datatables::of($datas)
                        
                        ->editColumn('country_id', function(Area $data) {
                            return $country = $data->country != NULL ? $data->country->name : 'Country Deleted';
                        })
                        ->editColumn('city_id', function(Area $data) {
                            return $city = $data->city != NULL ? $data->city->title : 'City Deleted';
                        })
                        ->addColumn('status', function(Area $data) {
                            $status      = $data->status == 1 ? __('Activated') : __('Deactivated');
                            $status_sign = $data->status == 1 ? 'success'   : 'danger';

                            return '<div class="btn-group mb-1">
                                <button type="button" class="btn btn-'.$status_sign.' btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                '.$status .'
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                    <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.areas.status',['id1' => $data->id, 'id2' => 1]).'">'.__("Activate").'</a>
                                    <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.areas.status',['id1' => $data->id, 'id2' => 0]).'">'.__("Deactivate").'</a>
                                </div>
                            </div>';
                        })

                        ->addColumn('action', function(Area $data) {
                              return '<div class="btn-group mb-1">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  '.'Actions' .'
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                  <a href="' . route('admin.areas.edit',$data->id) . '"  class="dropdown-item">'.__("Edit").'</a>
                                  <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="dropdown-item" data-href="'.  route('admin.areas.delete',$data->id).'">'.__("Delete").'</a>
                                </div>
                              </div>';
                        })
                        ->rawColumns(['status','action'])
                        ->toJson();
    }

    public function index()
    {
        return view('admin.areas.index');
    }

    public function create()
    {
        $data['countries'] = Country::whereStatus(1)->get();
        $data['cities'] = City::whereStatus(1)->get();

        return view('admin.areas.create',$data);
    }

    public function store(Request $request)
    {
        $rules = [
            'title'=> 'required',
            'country_id'=> 'required',
            'city_id'=> 'required'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = new Area();

        $input = $request->all();
        $data->fill($input)->save();

        $msg = __('New Data Added Successfully.').' '.'<a href="'.route('admin.areas.index').'"> '.__('View Lists.').'</a>';
        return response()->json($msg);
    }


    public function edit($id)
    {
        $data['countries'] = Country::whereStatus(1)->get();
        $data['cities'] = City::whereStatus(1)->get();
        $data['data'] = Area::findOrFail($id);

        return view('admin.areas.edit',$data);
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'title'=> 'required',
            'country_id'=> 'required',
            'city_id'=> 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Area::findOrFail($id);
        $input = $request->all();
        $data->update($input);

        $msg = __('Data Updated Successfully.').' '.'<a href="'.route('admin.areas.index').'"> '.__('View Lists.').'</a>';
        return response()->json($msg);
    }


    public function status($id1,$id2)
    {
        $data = Area::findOrFail($id1);
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
        $data = Area::findOrFail($id);
        $data->delete();

        return true;
    }
}

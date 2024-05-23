<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Category;
use Datatables;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {
         $datas = Category::orderBy('id','desc');

         return Datatables::of($datas)
                       
                        ->editColumn('photo', function(Category $data) {
                            $photo = $data->photo ? url('assets/images/'.$data->photo):url('assets/images/noimage.png');
                            return '<img src="' . $photo . '" alt="Image">';
                        })
                        ->addColumn('status', function(Category $data) {
                            $status      = $data->status == 1 ? __('Activated') : __('Deactivated');
                            $status_sign = $data->status == 1 ? 'success'   : 'danger';

                            return '<div class="btn-group mb-1">
                            <button type="button" class="btn btn-'.$status_sign.' btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            '.$status .'
                            </button>
                            <div class="dropdown-menu" x-placement="bottom-start">
                            <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.categories.status',['id1' => $data->id, 'id2' => 1]).'">'.__("Activate").'</a>
                            <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="'. route('admin.categories.status',['id1' => $data->id, 'id2' => 0]).'">'.__("Deactivate").'</a>
                            </div>
                        </div>';

                        })

                        ->addColumn('action', function(Category $data) {
                              return '<div class="btn-group mb-1">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  '.'Actions' .'
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                  <a href="' . route('admin.categories.edit',$data->id) . '"  class="dropdown-item">'.__("Edit").'</a>
                                  <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="dropdown-item" data-href="'.  route('admin.categories.delete',$data->id).'">'.__("Delete").'</a>
                                </div>
                              </div>';
                        })
                        ->rawColumns(['photo','status','action'])
                        ->toJson();
    }

    public function index()
    {
        return view('admin.categories.index');
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
       
       
        $rules = [
            'photo'      => 'required|mimes:jpeg,jpg,png,svg',
            'title'=> 'required',
            'slug'=>'required|unique:categories|max:255'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }


        $data = new Category();

        $input = $request->all();
        $input['slug'] = Str::slug($request->slug, '-');
        if ($file = $request->file('photo'))
        {
            $name = fileName($file);
            upload($name,$file,$data->photo);
            $input['photo'] = $name;
        }
        $data->fill($input)->save();

        $msg = __('New Data Added Successfully.').' '.'<a href="'.route('admin.categories.index').'"> '.__('View Lists.').'</a>';
        return response()->json($msg);
    }

    public function edit($id)
    {
        $data = Category::findOrFail($id);
        return view('admin.categories.edit',compact('data'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'photo'      => 'mimes:jpeg,jpg,png,svg',
            'title'=>'required',
            'slug' => 'required|unique:categories,slug,'.$id,
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Category::findOrFail($id);
        $input = $request->all();

        $input['slug'] = Str::slug($request->slug, '-');
        if ($file = $request->file('photo'))
        {
            $name = fileName($file);
            upload($name,$file,$data->photo);
            $input['photo'] = $name;
        }
        $data->update($input);

        $msg = __('Data Updated Successfully.').' '.'<a href="'.route('admin.categories.index').'"> '.__('View Lists.').'</a>';
        return response()->json($msg);
    }


    public function status($id1,$id2)
    {
        $data = Category::findOrFail($id1);
        $data->status = $id2;
        $data->update();

        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
    }





    public function delete($id){
        $data = Category::findOrFail($id);

        foreach($data->subcategories as $key=>$value){
            $value->delete();
        }

        if($data->services->count()>0){
            $msg = 'You cant delete this category. It has some services.';
            return response()->json($msg);
        }

        @unlink('assets/images/'.$data->photo);
        $data->delete();
        $msg = 'Data Deleted Successfully.';
        return response()->json($msg);
    }


}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Datatables;
use Illuminate\Support\Facades\Validator;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function datatables(Request $request)
    {
        $datas = Subcategory::orderBy('id', 'desc');

        return Datatables::of($datas)

            ->editColumn('photo', function (Subcategory $data) {
                $image = $data->image ? url('assets/images/' . $data->image) : url('assets/images/noimage.png');
                return '<img src="' . $image . '" alt="Image">';
            })
            ->editColumn('category', function (Subcategory $data) {
                return $data->category ? $data->category->title : '';
            })
            ->addColumn('status', function (Subcategory $data) {
                $status = $data->status == 1 ? __('Activated') : __('Deactivated');
                $status_sign = $data->status == 1 ? 'success' : 'danger';

                return '<div class="btn-group mb-1">
                                    <button type="button" class="btn btn-' . $status_sign . ' btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    ' . $status . '
                                    </button>
                                    <div class="dropdown-menu" x-placement="bottom-start">
                                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="' . route('admin.subcategories.status', ['id1' => $data->id, 'id2' => 1]) . '">' . __("Activate") . '</a>
                                        <a href="javascript:;" data-toggle="modal" data-target="#statusModal" class="dropdown-item" data-href="' . route('admin.subcategories.status', ['id1' => $data->id, 'id2' => 0]) . '">' . __("Deactivate") . '</a>
                                    </div>
                                </div>';
            })
            ->addColumn('action', function (Subcategory $data) {
                return '<div class="btn-group mb-1">
                                <button type="button" class="btn btn-primary btn-sm btn-rounded dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  ' . 'Actions' . '
                                </button>
                                <div class="dropdown-menu" x-placement="bottom-start">
                                  <a href="' . route('admin.subcategories.edit', $data->id) . '"  class="dropdown-item">' . __("Edit") . '</a>
                                  <a href="javascript:;" data-toggle="modal" data-target="#deleteModal" class="dropdown-item" data-href="' . route('admin.subcategories.delete', $data->id) . '">' . __("Delete") . '</a>
                                </div>
                              </div>';
            })
            ->rawColumns(['photo', 'category', 'status', 'action'])
            ->toJson(); //--- Returning Json Data To Client Side
    }
    public function index()
    {
        return view('admin.subcategories.index');
    }

    public function create()
    {
        $data['categories'] = Category::where('status', 1)->get();
        return view('admin.subcategories.create', $data);
    }

    public function store(Request $request)
    {

        $rules = [
            'image' => 'required|mimes:jpeg,jpg,png,svg',
            'title' => 'required',
            'slug' => 'required|unique:subcategories|max:255',
            'category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $limit = 5; // THIS NEED TO BE ADDED TO THE GLOBAL SETTINGS IF AVAILABLE
                    $categoryId = explode(',', $value);

                    if ($categoryId[1] === 'child') {
                        $count = 3; // curent data + next data + the parent table
                        $category = Subcategory::find($categoryId[0]);
                        $continue = true;

                        while ($continue) {
                            $count++;
                            $category = $category->parent;
                            if (!$category?->parent) {
                                $continue = false;
                            }
                            if ($count > $limit) {
                                $continue = false;
                            }
                        }

                        if ($count > $limit) {
                            $fail("The sub category depth has reached the maximum limit of {$limit} levels.");
                        }
                    }
                },
            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }


        $data = new Subcategory();

        $input = $request->all();
        $input['slug'] = Str::slug($request->slug, '-');
        $categoryId = explode(',', $request->category_id);
        if ($categoryId[1] === 'parent') {
            $input['category_id'] = $categoryId[0];
        } else {
            $input['category_id'] = Subcategory::find($categoryId[0])->category_id;
            $input['parent_id'] = $categoryId[0];
        }

        if ($file = $request->file('image')) {
            $name = fileName($file);
            upload($name, $file, $data->image);
            $input['image'] = $name;
        }
        $data->fill($input)->save();

        $msg = __('New Data Added Successfully.') . ' ' . '<a href="' . route('admin.subcategories.index') . '"> ' . __('View Lists.') . '</a>';
        return response()->json($msg);
    }


    public function edit($id)
    {
        $data['data'] = Subcategory::findOrFail($id);
        $data['categories'] = Category::get();

        return view('admin.subcategories.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'image' => 'mimes:jpeg,jpg,png,svg',
            'title' => 'required',
            'slug' => 'required|unique:subcategories,slug,' . $id,
            'category_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    $limit = 5; // THIS NEED TO BE ADDED TO THE GLOBAL SETTINGS IF AVAILABLE
                    $categoryId = explode(',', $value);

                    if ($categoryId[1] === 'child') {
                        $count = 2; // curent data + the parent table
                        $category = Subcategory::find($categoryId[0]);
                        $continue = true;

                        while ($continue) {
                            $count++;
                            $category = $category->parent;
                            if (!$category?->parent) {
                                $continue = false;
                            }
                            if ($count > $limit) {
                                $continue = false;
                            }
                        }

                        if ($count > $limit) {
                            $fail("The sub category depth has reached the maximum limit of {$limit} levels.");
                        }
                    }
                },
            ]
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Subcategory::findOrFail($id);
        $input = $request->all();

        $input['slug'] = Str::slug($request->slug, '-');
        $categoryId = explode(',', $request->category_id);
        if ($categoryId[1] === 'parent') {
            $input['category_id'] = $categoryId[0];
        } else {
            $input['category_id'] = Subcategory::find($categoryId[0])->category_id;
            $input['parent_id'] = $categoryId[0];
        }

        $input['slug'] = Str::slug($request->slug, '-');
        if ($file = $request->file('image')) {
            $name = fileName($file);
            upload($name, $file, $data->image);
            $input['image'] = $name;
        }
        $data->update($input);

        $msg = __('Data Updated Successfully.') . ' ' . '<a href="' . route('admin.subcategories.index') . '"> ' . __('View Lists.') . '</a>';
        return response()->json($msg);
    }


    public function status($id1, $id2)
    {
        $data = Subcategory::findOrFail($id1);
        $data->status = $id2;
        $data->update();

        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
    }

    public function bulkdelete(Request $request)
    {
        $ids = $request->bulk_id;
        $bulk_ids = explode(",", $ids);
        foreach ($bulk_ids as $key => $id) {
            if ($id) {
                try {
                    $this->delete($id);
                    $msg = 'Data Deleted Successfully.';
                } catch (\Throwable $th) {
                    $msg = $th->getMessage();
                }
            }
        }
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

    public function delete($id)
    {
        $data = Subcategory::findOrFail($id);
        @unlink('assets/images/' . $data->photo);
        $data->delete();

        return true;
    }
}

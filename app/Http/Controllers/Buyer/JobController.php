<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Job;
use App\Models\Jobrequest;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Mews\Purifier\Facades\Purifier;
use Intervention\Image\Facades\Image;

class JobController extends Controller
{
    public function jobs()
    {
        $jobs= Job::where('buyer_id',auth()->id())->get();
        return view('buyer.jobs.index',compact('jobs'));
    }

    public function jobcreate()
    {
        $categories_main = Category::where('status',1)->get();
        $subcategories = Subcategory::tree();
        $countries = Country::where('status',1)->get();
        $cities = City::where('status',1)->get();
        $areas = Area::where('status',1)->get();

        $groupedSubcategories = [];
        $subcat_parents_ids = [];

        foreach ($subcategories as $subcategory) {
            $parentId = $subcategory->parent_id ?? 0; // If parent_id is null, use 0 as the default value
            $groupedSubcategories[$parentId][] = $subcategory;

            // Track unique parent ids with child subcategories
            if ($subcategory->parent_id != null && !in_array($parentId, $subcat_parents_ids)) {
                $subcat_parents_ids[] = $parentId;
            }
        }

        return view('buyer.jobs.create',compact('categories_main', 'subcategories','groupedSubcategories','subcat_parents_ids', 'countries', 'cities', 'areas'));
    }

    public function jobstore(Request $request)
    {

        if($request->is_job_online == 0){
            $request->validate([
                'job_country_id' => 'required',
                'job_city_id' => 'required',
                'job_area_id' => 'required',
            ]);
        }

        $request->validate([
            'job_title' => 'required',
            'job_slug' => 'required|unique:jobs',
            'category_id' => 'required',
            'description' => 'required',
            'budget' => 'required',
            'deadline' => 'required',
            'image' => 'required|mimes:jpeg,jpg,png',

        ]);

        $input = $request->all();
        $job = new Job();

        $input['buyer_id'] = auth()->id();
        $input['status'] = 0;
        $input['description']= Purifier::clean($request->description);

        if($request->is_job_online == 1){
            $input['job_country_id'] = 0;
            $input['job_city_id'] = 0;
            $input['job_area_id'] = 0;
        }
        else{
            $input['job_country_id'] = $request->job_country_id;
            $input['job_city_id'] = $request->job_city_id;
            $input['job_area_id'] = $request->job_area_id;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img = time() . '.' . $image->getClientOriginalExtension();

            $resizeImage = Image::make($image);
            $resizeImage->resize(600, 400, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->move('assets/images', $img);
            $resizeImage->save('assets/images/shopping_carts/' . $img);

            $input['image'] = $img;
        }

        if ($request->hasFile('image_gallery')) {
            $imageGallery = $request->file('image_gallery');
            $galleryData = [];

            foreach ($imageGallery as $key => $image) {
                $img = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                $image->move('assets/images', $img);

                $galleryData[$key] = $img;
            }

            $input['image_gallery'] = json_encode($galleryData);
        }

        if($request->deadline < date('Y-m-d')){
            return back()->with('error','Deadline must be greater than today');
        }
        else{
            $input['deadline'] = $request->deadline;

        }

        $input['budget'] = round(baseCurrencyAmount($request->budget),2);
        $job->fill($input)->save();
        $job->subcategories()->attach($request->input('subcategory_ids'));
        return redirect()->back()->with('success','Job Added Successfully');
    }


    public function jobedit($id)
    {
        $job = Job::where('id',$id)->first();
        $categories_main = Category::where('status',1)->get();
        $subcategories = Subcategory::tree();
        $countries = Country::where('status',1)->get();
        $cities = City::where('status',1)->get();
        $areas = Area::where('status',1)->get();

        $groupedSubcategories = [];
        $subcat_parents_ids = [];

        foreach ($subcategories as $subcategory) {
            $parentId = $subcategory->parent_id ?? 0; // If parent_id is null, use 0 as the default value
            $groupedSubcategories[$parentId][] = $subcategory;

            // Track unique parent ids with child subcategories
            if ($subcategory->parent_id != null && !in_array($parentId, $subcat_parents_ids)) {
                $subcat_parents_ids[] = $parentId;
            }
        }

        return view('buyer.jobs.edit',compact('job','categories_main','groupedSubcategories','subcat_parents_ids', 'subcategories', 'countries', 'cities', 'areas'));
    }

    public function jobupdate(Request $request, $id)
    {
        if($request->is_job_online == 0){
            $request->validate([
                'job_country_id' => 'required',
                'job_city_id' => 'required',
                'job_area_id' => 'required',
            ]);
        }

        $request->validate([
            'job_title' => 'required',
            'job_slug' => 'required|unique:jobs,job_slug,'.$id,
            'category_id' => 'required',
            'description' => 'required',
            'budget' => 'required',
            'deadline' => 'required',
            'image' => 'mimes:jpeg,jpg,png',

        ]);

        $input = $request->all();
        $job = Job::findOrFail($id);

        $input['buyer_id'] = auth()->id();
        $input['status'] = 0;
        $input['description']= Purifier::clean($request->description);

        if($request->is_job_online == 1){
            $input['job_country_id'] = 0;
            $input['job_city_id'] = 0;
            $input['job_area_id'] = 0;
        }
        else{
            $input['job_country_id'] = $request->job_country_id;
            $input['job_city_id'] = $request->job_city_id;
            $input['job_area_id'] = $request->job_area_id;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img = time() . '.' . $image->getClientOriginalExtension();

            $resizeImage = Image::make($image);
            $resizeImage->resize(600, 400, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->move('assets/images', $img);
            if(file_exists('assets/images/'.$job->image)){
                unlink('assets/images/'.$job->image);
            }
            $resizeImage->save('assets/images/shopping_carts/' . $img);

            $input['image'] = $img;
        }

        $galleryData = json_decode($job->image_gallery, true) ?? [];

        if ($request->hasFile('image_gallery')) {
            foreach ($galleryData as $existingImage) {
                $existingImagePath = 'assets/images/' . $existingImage;
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }
            $galleryData = [];
            $imageGallery = $request->file('image_gallery');

            foreach ($imageGallery as $image) {
                $img = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move('assets/images', $img);

                $galleryData[] = $img;
            }
        }

        if ($request->has('deleted_images')) {
            $deletedImages = explode(',', $request->deleted_images);
            foreach ($deletedImages as $imageName) {
                if ($imageName === '') {
                    continue;
                } else {
                    $path = 'assets/images/' . $imageName;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                if (($key = array_search($imageName, $galleryData)) !== false) {
                    unset($galleryData[$key]);
                }
            }
        }

        $galleryData = array_values($galleryData);
        $input['image_gallery'] = json_encode($galleryData);

        $old= date('Y-m-d',strtotime($job->deadline)) ;

        if($request->deadline != $old){
            if($request->deadline < date('Y-m-d')){
                return back()->with('error','Deadline must be greater than today');
            }
            else{
                $input['deadline'] = $request->deadline;

            }
        }

        $input['budget'] = round(baseCurrencyAmount($request->budget),2);

        $job->fill($input)->save();
        $job->subcategories()->sync($request->input('subcategory_ids'));
        return redirect()->back()->with('success','Job Updated Successfully');

    }

    public function jobdelete($id)
    {
        $job = Job::findOrFail($id);
        @unlink('assets/images/'.$job->image);
        $job->orders()->delete();
        Jobrequest::where('job_id',$id)->delete();
        $job->subcategories()->detach();
        $job->delete();
        return redirect()->back()->with('success','Job Deleted Successfully');
    }
}

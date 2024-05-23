<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Jobrequest;
use App\Models\Service;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Mews\Purifier\Facades\Purifier;
use mysql_xdevapi\Exception;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('seller_id',auth()->user()->id)->get();
        return view('user.service.index', compact('services'));
    }

    public function addService(){
        $categories_main = Category::where('status', 1)->get();
        $subcategories = Subcategory::tree();
        $countries = Country::where('status', 1)->get();
        $cities = City::where('status', 1)->get();
        $areas = Area::where('status', 1)->get();



        return view('user.service.add', compact('categories_main', 'subcategories', 'countries', 'cities', 'areas'));
    }


    public function storeService(Request $request){
        try {

            $user = Auth::user();
            $count = DB::table('services')->where('seller_id','=',$user->id)->count();

            if($user->plan_type != 'life_time'){
                if(Carbon::now() > $user->plan_expiredate){
                    return redirect()->back()->with('error','Your subscription has been expired');
                }}

            if($count >= $user->service_limit){
                return redirect()->back()->with('error','You have reached your service limit');
            }

            if($request->is_service_online == 1){
                $request->validate([
                    'delivery_days' => 'required',
                    'revision' => 'required',
                    'price' => 'required',
                ]);
            }
            if($request->is_service_online == 0){
                $request->validate([
                    'service_country_id' => 'required',
                    'service_city_id' => 'required',

                ]);

                $area= new Area();
                $area->country_id= $request->service_country_id;
                $area->city_id= $request->service_city_id;
                $area->title= $request->service_area_id;
            }

            $request->validate([
                'title' => 'required|unique:services,title',
                'category_id' => 'required',
                'description' => 'required',
                'slug' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png',
            ]);

            $input = $request->all();
            $service = new Service();

            if(isset($request->newarea)){
                $area= new Area();
                $area->country_id= $request->service_country_id;
                $area->city_id= $request->service_city_id;
                $area->title= $request->newarea;

                $area->save();
            }

            if($request->hasFile('image')){
                $image = $request->file('image');
                $img = time() . '.' . $image->getClientOriginalExtension();

                $resizeImage = Image::make($image);
                $resizeImage->resize(600, 400, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $image->move('assets/images', $img);
                $resizeImage->save('assets/images/shopping_carts/' . $img);
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

            $input['seller_id'] = auth()->id();
            $input['status'] = 0;
            $input['description']= Purifier::clean($request->description);

            if($request->is_service_online == 1){
                $input['delivery_days'] = $request->delivery_days;
                $input['revision'] = $request->revision;
                $input['price'] = baseCurrencyAmount($request->price);
            }
            else{
                $input['delivery_days'] = 0;
                $input['revision'] = 0;
                $input['price'] = 0;

                if (isset($area)) {
                    $input['service_area_id'] = $area->id;
                }
            }

            $service->fill($input)->save();
// Attach subcategories to the service
            $service->subcategories()->attach($request->input('subcategory_ids'));

            return redirect()->back()->with('success','Service Added Successfully');
        }catch (\Exception $e){
            return redirect()->back()->with('Error creating service: ' . $e->getMessage());
        }



    }

    public function editService($id)
    {
        $service = Service::where('id',$id)->first();
        $categories_main = Category::where('status',1)->get();
        $subcategories = Subcategory::tree();
        $countries = Country::where('status',1)->get();
        $cities = City::where('status',1)->get();
        $areas = Area::where('status',1)->get();

        return view('user.service.edit', compact('service','categories_main','subcategories', 'countries','cities','areas'));
    }

    public function updateService(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        if($request->is_service_online == 1){
            $request->validate([
                'delivery_days' => 'required',
                'revision' => 'required',
                'price' => 'required',
            ]);
        }

        if($request->is_service_online == 0){
            $request->validate([
                'service_country_id' => 'required',
                'service_city_id' => 'required',

            ]);
        }

        if(isset($request->newarea)){
            $area= new Area();
            $area->country_id= $request->service_country_id;
            $area->city_id= $request->service_city_id;
            $area->title= $request->newarea;
            $area->save();
        }

        $request->validate([
            'title' => 'required|unique:services,title,'.$id,
            'category_id' => 'required',
            'description' => 'required',
            'slug' => 'required',
            'image' => 'mimes:jpeg,jpg,png',
        ]);

        $input = $request->all();
        $service = Service::whereId($id)->first();

        $input['seller_id'] = auth()->id();
        $input['status'] = $service->status;
        $input['description']= Purifier::clean($request->description);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $img = time() . '.' . $image->getClientOriginalExtension();

            $resizeImage = Image::make($image);
            $resizeImage->resize(600, 400, function ($constraint) {
                $constraint->aspectRatio();
            });

            $image->move('assets/images', $img);
            if(file_exists('assets/images/'.$service->image)){
                unlink('assets/images/'.$service->image);
            }
            $resizeImage->save('assets/images/shopping_carts/' . $img);

            $input['image'] = $img;
        }

        $galleryData = json_decode($service->image_gallery, true) ?? [];

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

        if($request->is_service_online == 1){
            $input['delivery_days'] = $request->delivery_days;
            $input['revision'] = $request->revision;
            $input['price'] = baseCurrencyAmount($request->price);
        }
        else{
            $input['delivery_days'] = 0;
            $input['revision'] = 0;
            $input['price'] = 0;
            if (isset($area)) {
                $input['service_area_id'] = $area->id;
            }
        }

        $service->fill($input)->save();
        $service->subcategories()->sync($request->input('subcategory_ids'));
        return redirect()->back()->with('success','Service Updated Successfully');
    }

    public function deleteService($slug): \Illuminate\Http\RedirectResponse
    {
        $service = Service::where('slug',$slug)->first();
        if(file_exists('assets/images/'.$service->image)){
            unlink('assets/images/'.$service->image);
        }
        $service->subcategories()->detach();
        $service->delete();
        return redirect()->back()->with('success','Service Deleted Successfully');
    }
}

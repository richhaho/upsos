<?php

namespace App\Http\Controllers\Admin;
use App\Models\Pagesetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Str;
use Validator;
use Purifier;

class PageSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function update(Request $request)
    {
            $data = Pagesetting::findOrFail(1);
            $input = $request->all();


            if ($file = $request->file('brand_photo'))
            {
                $name = Str::random(8).time().'.'.$file->getClientOriginalExtension();
                $file->move('assets/images',$name);
                @unlink('assets/images/'.$data->brand_photo);
                $input['brand_photo'] = $name;
            }

            if ($file = $request->file('choose_us_photo'))
            {
                $name = Str::random(8).time().'.'.$file->getClientOriginalExtension();
                $file->move('assets/images',$name);
                @unlink('assets/images/'.$data->choose_us_photo);
                $input['choose_us_photo'] = $name;
            }

            if( $file = $request->file('testimonial_banner'))
            {
                $name = Str::random(8).time().'.'.$file->getClientOriginalExtension();
                $file->move('assets/images',$name);
                @unlink('assets/images/'.$data->testimonial_banner);
                $input['testimonial_banner'] = $name;
            }

            if ($file = $request->file('about_photo1'))
            {
                $name = Str::random(8).time().'.'.$file->getClientOriginalExtension();
                $file->move('assets/images',$name);
                @unlink('assets/images/'.$data->about_photo1);
                $input['about_photo1'] = $name;
            }

            if ($file = $request->file('about_photo2'))
            {
                $name = Str::random(8).time().'.'.$file->getClientOriginalExtension();
                $file->move('assets/images',$name);
                @unlink('assets/images/'.$data->about_photo2);
                $input['about_photo2'] = $name;
            }
            if ($file = $request->file('about_photo3'))
            {
                $name = Str::random(8).time().'.'.$file->getClientOriginalExtension();
                $file->move('assets/images',$name);
                @unlink('assets/images/'.$data->about_photo3);
                $input['about_photo3'] = $name;
            }

            if ($file = $request->file('start_photo'))
            {
                $name = Str::random(8).time().'.'.$file->getClientOriginalExtension();
                $file->move('assets/images',$name);
                @unlink('assets/images/'.$data->start_photo);
                $input['start_photo'] = $name;
            }


            if ($file = $request->file('hero_photo'))
            {
                $name = Str::random(8).time().'.'.$file->getClientOriginalExtension();
                $file->move('assets/images',$name);
                @unlink('assets/images/'.$data->hero_photo);
                $input['hero_photo'] = $name;
            }

            if ($file = $request->file('login_banner'))
            {
                $name = Str::random(8).time().'.'.$file->getClientOriginalExtension();
                $file->move('assets/images',$name);
                @unlink('assets/images/'.$data->login_banner);
                $input['login_banner'] = $name;
            }



            if($request->about_details){
                $input['about_details'] = Purifier::clean($request->about_details);
            }

          
            if($request->plan_subtitle){
                $input['plan_subtitle'] = Purifier::clean($request->plan_subtitle);
            }
            if($request->start_text){
                $input['start_text'] = Purifier::clean($request->start_text);
            }
           
            if($request->testimonial_text){
                $input['testimonial_text'] = Purifier::clean($request->testimonial_text);
            }
            if($request->blog_text){
                $input['blog_text'] = Purifier::clean($request->blog_text);
            }
            if($request->feature_text){
                $input['feature_text'] = Purifier::clean($request->feature_text);
            }
            if($request->login_subtitle){
                $input['login_subtitle'] = Purifier::clean($request->login_subtitle);
            }
            if($request->brand_text){
                $input['brand_text'] = Purifier::clean($request->brand_text);
            }

            if($request->category_subtitle){
                $input['category_subtitle'] = Purifier::clean($request->category_subtitle);
            }
            if($request->best_service_text){
                $input['best_service_text'] = Purifier::clean($request->best_service_text);
            }
            if($request->popular_service_text){
                $input['popular_service_text'] = Purifier::clean($request->popular_service_text);
            }
            if($request->choose_us_text){
                $input['choose_us_text'] = Purifier::clean($request->choose_us_text);
            }
            if($request->featured_text){
                $input['featured_text'] = Purifier::clean($request->featured_text);
            }
            
            if($request->partner_text){
                $input['partner_text'] = Purifier::clean($request->partner_text);
            }
            $data->update($input);
            $msg = 'Data Updated Successfully.';
            return response()->json($msg);
    }

    public function homeupdate(Request $request)
    {
        $data = Pagesetting::findOrFail(1);
        $input = $request->all();

        $data->update($input);
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
    }


    public function customization(){
        $data = Pagesetting::find(1);
        return view('admin.pagesetting.customization',compact('data'));
    }

    public function customizationUpdate(Request $request){
        $data = Pagesetting::find(1);
        
        if($request->home_module){
            $input['home_module'] = json_encode($request->home_module,true);
        }else{
            $input['home_module'] = NULL;
        }
        $data->update($input);
        
        if($request->ajax()){
            $msg = 'Data Updated Successfully.';
            return response()->json($msg);
        }else{
            return back()->withSuccess('Data Updated Successfully.');
        }
    }

    public function hero(){
        $data = Pagesetting::find(1);
        return view('admin.pagesetting.hero_section',compact('data'));
    }

    public function about(){
        $data = Pagesetting::find(1);
        return view('admin.pagesetting.about_section',compact('data'));
    }




    public function calltoaction(){
        $data = Pagesetting::find(1);
        return view('admin.pagesetting.call_section',compact('data'));
    }

    public function contact()
    {
        $data = Pagesetting::find(1);
        return view('admin.pagesetting.contact',compact('data'));
    }

    public function sectionHeading(){
        $data = Pagesetting::find(1);
        return view('admin.pagesetting.sectionheading',compact('data'));
    }

   

    public function customize()
    {
        $data = Pagesetting::find(1);
        return view('admin.pagesetting.customize',compact('data'));
    }


    public function blogsection()
    {
        $ps = HomepageSetting::findOrFail(1);
        return view('admin.pagesetting.blog_section',compact('ps'));
    }


    public function faqupdate($status)
    {
        $page = Pagesetting::findOrFail(1);
        $page->f_status = $status;
        $page->update();
        Session::flash('success', 'FAQ Status Upated Successfully.');
        return redirect()->back();
    }

    public function contactup($status)
    {
        $page = Pagesetting::findOrFail(1);
        $page->c_status = $status;
        $page->update();
        Session::flash('success', 'Contact Status Upated Successfully.');
        return redirect()->back();
    }

    public function contactupdate(Request $request)
    {
        $page = Pagesetting::findOrFail(1);
        $input = $request->all();
        $page->update($input);
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
    }


}

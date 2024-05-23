<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function GuzzleHttp\json_decode;

class Pagesetting extends Model
{
    protected $fillable = [
        'contact_success',
        'contact_email',
        'contact_title',
        'contact_text',
        'street',
        'phone',
        'fax',
        'email',
        'site',
        'phone_code',
        'side_title',
        'side_text',
        'review_blog',
        'pricing_plan',
        'video_subtitle',
        'video_title',
        'video_text',
        'video_link',
        'video_image',
        'video_background',
        'start_title',
        'start_text',
        'start_photo',
        'best_service_title',
        'best_service_text',
        'popular_service_title',
        'popular_service_text',
        'choose_us_title',
        'choose_us_text',
        'choose_us_photo',
        'featured_title',
        'featured_text',
        'partner_title',
        'partner_text',
        'testimonial_title',
        'testimonial_text',
        'testimonial_banner',


        'brand_title',
        'brand_text',
        'brand_photo',
        'category_title',
        'category_subtitle',
        'portfolio_subtitle',
        'portfolio_title',
        'portfolio_text',
        'p_subtitle',
        'p_title',
        'p_text',
        
        'blog_subtitle',
        'blog_title',
        'blog_text',
        'faq_title',
        'faq_subtitle',
        'banner_title',
        'banner_text',
        'banner_link1',
        'banner_link2',
        'about_photo1',
        'about_photo2',
        'about_photo3',
        'about_title',
        'about_details',
        'about_link',
        'about_video_link',
        'footer_top_photo',
        'footer_top_title',
        'footer_top_text',
        'hero_title',
        'hero_subtitle',
        'hero_photo',

        'profit_title',
        'profit_text',
        'call_title',
        'call_subtitle',
        'call_link',
        'call_bg',
        'latitude',
        'longitude',
        'home_module',
    ];

    public $timestamps = false;

    public function upload($name,$file,$oldname)
    {
        $file->move('assets/images',$name);
        if($oldname != null)
        {
            if (file_exists(public_path().'/assets/images/'.$oldname)) {
                unlink(public_path().'/assets/images/'.$oldname);
            }
        }  
    }

    public function homeModuleCheck($value)
    {
        $sections = json_decode($this->home_module,true);
        if (in_array($value, $sections)){
            return true;
        }else{
            return false;
        }
    }

}

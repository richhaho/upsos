<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'image',
        'status',
        'parent_id'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

//    public function services()
//    {
//        return $this->hasMany('App\Models\Service', 'subcategory_id');
//    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_subcategory', 'subcategory_id', 'service_id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_subcategory', 'subcategory_id', 'job_id');
    }

    public function children()
    {
        return $this->hasMany(Subcategory::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Subcategory::class, 'parent_id');
    }

    public static function tree(){
        $allCategories = Subcategory::where('status', 1)->get();
        $rootCategories = $allCategories->whereNull('parent_id');
        self::formatTree($rootCategories, $allCategories);
        return $rootCategories;
    }

    private static function formatTree($categories, $allcategories){
        foreach ($categories as $category){
            $category->children = $allcategories->where('parent_id', $category->id)->values();

            if ($category->children->isNotEmpty()){
                self::formatTree($category->children, $allcategories);
            }
        }

    }

}

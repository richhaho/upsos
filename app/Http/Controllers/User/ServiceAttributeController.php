<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Service;
use App\Models\Serviceadditional;
use App\Models\Servicebenefit;
use App\Models\ServiceFaq;
use App\Models\Serviceincludes;
use Illuminate\Http\Request;

class ServiceAttributeController extends Controller
{
    public function attribute($slug)
    {
        $service = Service::where('slug', $slug)->first();
        return view('user.attribute.create', compact('service'));
    }

    public function storeAttribute(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $service_total_price = 0;
        $include = array_filter($request->include_service_title);
        $additional = array_filter($request->additional_service_title);
        $benefits = array_filter($request->benefits);
        $faqs = array_filter($request->faq_title);
    
        if ($request->is_service_online == 1) {
            if ($include) {
                foreach ($request->include_service_title as $key => $value) {
                    $data['service_id'] = $id;
                    $data['seller_id'] = auth()->id();
                    $data['include_service_title'] = $request->include_service_title[$key];
                    $data['include_service_price'] = 0;
                    $data['include_service_quantity'] = 0;
    
                    // Check if an image is provided before handling it
                    if ($request->hasFile('image') && $request->file('image')[$key]->isValid()) {
                        $image = $request->file('image')[$key];
                        $img = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                        $image->move('assets/images', $img);
                        $data['image'] = $img;
                    }
    
                    Serviceincludes::create($data);
                }
            }
        } else {
            if ($include) {
                foreach ($include as $key => $value) {
                    $data['service_id'] = $id;
                    $data['seller_id'] = auth()->id();
                    $data['include_service_title'] = $request->include_service_title[$key];
                    $data['include_service_price'] = baseCurrencyAmount($request->include_service_price[$key]);
                    $data['include_service_quantity'] = $request->include_service_quantity[$key];
    
                    // Check if an image is provided before handling it
                    if ($request->hasFile('image') && $request->file('image')[$key]->isValid()) {
                        $image = $request->file('image')[$key];
                        $img = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                        $image->move('assets/images', $img);
                        $data['image'] = $img;
                    }
    
                    $service_total_price += baseCurrencyAmount($request->include_service_price[$key]) * $request->include_service_quantity[$key];
                    Serviceincludes::create($data);
                }
                Service::where('id', $id)->update(['price' => $service_total_price]);
            }
        }

        if ($additional) {
            foreach ($additional as $key => $value) {
                $data['service_id'] = $id;
                $data['seller_id'] = auth()->id();
                $data['additional_service_title'] = $request->additional_service_title[$key];
                $data['additional_service_price'] = baseCurrencyAmount($request->additional_service_price[$key]);
                $data['additional_service_quantity'] = $request->additional_service_quantity[$key];
        
                // Check if an image is provided before handling it for additional service
                if ($request->hasFile('product_image') && $request->file('product_image')[$key]->isValid()) {
                    $image = $request->file('product_image')[$key];
                    $img = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                    $image->move('assets/images', $img);
                    $data['product_image'] = $img;
                }
        
                Serviceadditional::create($data);
            }
        }
        

        if ($benefits) {
            foreach ($benefits as $key => $value) {
                $data['service_id'] = $id;
                $data['seller_id'] = auth()->id();
                $data['benefits'] = $request->benefits[$key];
                Servicebenefit::create($data);
            }
        }

        if ($faqs) {
            foreach ($faqs as $key => $value) {
                $data['service_id'] = $id;
                $data['seller_id'] = auth()->id();
                $data['faq_title'] = $request->faq_title[$key];
                $data['faq_detail'] = $request->faq_detail[$key];
                ServiceFaq::create($data);
            }
        }

        return redirect()->back()->with('success', 'Service Attribute Added Successfully');

    }
    public function editAttribute($slug)
    {
        $service = Service::where('slug', $slug)->first();

        $serviceincludes = Serviceincludes::where('service_id', $service->id)->get();

        $serviceadditional = Serviceadditional::where('service_id', $service->id)->get();

        $servicebenefits = Servicebenefit::where('service_id', $service->id)->get();
        $servicefaqs = ServiceFaq::where('service_id', $service->id)->get();
        return view('user.attribute.edit', compact('service', 'serviceincludes', 'servicebenefits', 'serviceadditional', 'servicefaqs'));
    }

    public function updateAttribute(Request $request, $id)
    {
        $service_total_price = 0;
        $extraIds = [];

        $service = Service::findOrFail($id);

        if ($request->is_service_online == 1) {

            if (isset($request->include_service_title)) {
                foreach ($request->include_service_title as $key => $value) {
                    $data['service_id'] = $id;
                    $data['seller_id'] = auth()->id();
                    $data['include_service_title'] = $request->include_service_title[$key];
                    $data['include_service_price'] = 0;
                    $data['include_service_quantity'] = 0;
                    $data['image'] = '';

                    if (isset($request->image[$key])) {
                        $image = $request->image[$key];
                        $img = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                        $image->move('assets/images', $img);
                        $data['image'] = $img;
                    } else {
                        // If image is not provided, retain existing image 
                        if (isset($request->attribute_id[$key])) {
                            $existingImage = Serviceincludes::find($request->attribute_id[$key])->image;
                            $data['image'] = $existingImage;
                        } 
                    }

    
                    if (isset($request->attribute_id[$key])) {
                        Serviceincludes::where('id', $request->attribute_id[$key])->update($data);
                    } else {
                        $extraIds[] = Serviceincludes::create($data)->id;
                    }
                                           
                }
            }
        } else {
            if (isset($request->include_service_title)) {
                foreach ($request->include_service_title as $key => $value) {
                    $data['service_id'] = $id;
                    $data['seller_id'] = auth()->id();
                    $data['include_service_title'] = $request->include_service_title[$key];
                    $data['include_service_price'] = baseCurrencyAmount($request->include_service_price[$key]);
                    $data['include_service_quantity'] = $request->include_service_quantity[$key];

                    if (isset($request->image[$key])) {
                        $image = $request->image[$key];
                        $img = time() . '_' . $key . '.' . $image->getClientOriginalExtension();
                        $image->move('assets/images', $img);
                        $data['image'] = $img;
                    } else {
                        if (isset($request->attribute_id[$key])) {
                            $existingImage = Serviceincludes::find($request->attribute_id[$key])->image;                   
                        }
                    }  

                    $service_total_price += baseCurrencyAmount($request->include_service_price[$key]) * $request->include_service_quantity[$key];
                    // Update attribute when id is existing
                    if (isset($request->attribute_id[$key])) {
                        Serviceincludes::where('id', $request->attribute_id[$key])->update($data);
                    } else {
                        // Add new attribute
                        $extraIds[] = Serviceincludes::create($data)->id;
                    }
                }
                Service::where('id', $id)->update(['price' => $service_total_price]);
            }
        }

        $mergeIds = array_merge(isset($request->attribute_id) ? $request->attribute_id : [], $extraIds);
        // Delete attributes when not existing in the request
        Serviceincludes::where('service_id', $id)->whereNotIn('id', $mergeIds)->delete();

        $extraIds = [];
        if (isset($request->additional_service_title)) {
            foreach ($request->additional_service_title as $key => $value) {
                $data = [
                    'service_id' => $id,
                    'seller_id' => auth()->id(),
                    'additional_service_title' => $request->additional_service_title[$key],
                    'additional_service_price' => baseCurrencyAmount($request->additional_service_price[$key]),
                    'additional_service_quantity' => $request->additional_service_quantity[$key],
                ];
                if (isset($request->product_image[$key])) {
                    $product_image = $request->product_image[$key];
                    $img = time() . '_' . $key . '.' . $product_image->getClientOriginalExtension();
                    $product_image->move('assets/images', $img);
                    $data['product_image'] = $img;
                } else {
                    if (isset($request->additional_id[$key])) {
                        $existingImage = Serviceadditional::find($request->additional_id[$key])->product_image;               
                    }
                }

                if (isset($request->additional_id[$key])) {
                    Serviceadditional::where('id', $request->additional_id[$key])->update($data);
                } else {
                    $extraIds[] = Serviceadditional::create($data)->id;
                }

                
            }
        }

        $mergeIds = array_merge(isset($request->additional_id) ? $request->additional_id : [], $extraIds);
        // Delete additional when not existing in the request
        Serviceadditional::where('service_id', $id)->whereNotIn('id', $mergeIds)->delete();

        $extraIds = [];
        if (isset($request->benefits)) {
            foreach ($request->benefits as $key => $value) {
                $benefits['service_id'] = $id;
                $benefits['seller_id'] = auth()->id();
                $benefits['benefits'] = $request->benefits[$key];
                if (isset($request->benefit_id[$key])) {
                    Servicebenefit::where('id', $request->benefit_id[$key])->update($benefits);
                } elseif ($benefits['benefits']) {
                    $extraIds[] = Servicebenefit::create($benefits)->id;
                }
            }
        }

        $mergeIds = array_merge(isset($request->benefit_id) ? $request->benefit_id : [], $extraIds);
        // Delete benefit when not existing in the request
        Servicebenefit::where('service_id', $id)->whereNotIn('id', $mergeIds)->delete();

        $extraIds = [];
        if ($request->faq_title) {
            foreach ($request->faq_title as $key => $value) {
                $faq['service_id'] = $id;
                $faq['seller_id'] = auth()->id();
                $faq['faq_title'] = $request->faq_title[$key];
                $faq['faq_detail'] = $request->faq_detail[$key];

                if (isset($request->faq_id[$key])) {
                    ServiceFaq::where('id', $request->faq_id[$key])->update($faq);
                } elseif ($faq['faq_title']) {
                    $extraIds[] = ServiceFaq::create($faq)->id;
                }
            }
        }

        $mergeIds = array_merge(isset($request->faq_id) ? $request->faq_id : [], $extraIds);
        // Delete benefit when not existing in the request
        ServiceFaq::where('service_id', $id)->whereNotIn('id', $mergeIds)->delete();

        return redirect()->back()->with('success', 'Service Attribute Updated Successfully');
    }

}

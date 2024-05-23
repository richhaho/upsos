<?php

namespace App\Http\Controllers;

use App\Models\BuyerSellerMessage;
use App\Models\ServiceOrder;
use Illuminate\Http\Request;

class ServiceConversationController extends Controller
{
    public function index($id)
    {
        $serviceorder=ServiceOrder::findOrFail($id);
        $messages=BuyerSellerMessage::where('service_id',$serviceorder->service_id)->where('seller_id',$serviceorder->seller_id)->where('buyer_id',$serviceorder->buyer_id)->get();
        
        return view('conversation.service_conversation',compact('serviceorder','messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'message'=>'required',
        ]);
        $message=new BuyerSellerMessage();
        
        $input=$request->all();
        if($request->hasFile('attachment')){
            $file=$request->file('attachment');
            $filename=time().'.'.$file->getClientOriginalExtension();
            $file->move('assets/file/',$filename);
            $input['attachment']=$filename;
        }
        $message->fill($input)->save();
        return redirect()->back()->with('success','Message sent successfully');
    }

    
}

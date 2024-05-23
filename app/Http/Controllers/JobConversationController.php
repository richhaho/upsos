<?php

namespace App\Http\Controllers;

use App\Models\BuyerSellerMessage;
use App\Models\Jobrequest;
use Illuminate\Http\Request;

class JobConversationController extends Controller
{
    public function index($id)
    {
        
        $jobrequest=Jobrequest::where('job_id',$id)->first();
        $messages=BuyerSellerMessage::where('job_id',$id)->where('buyer_id',$jobrequest->buyer_id)->where('seller_id',$jobrequest->seller_id)->get();

        return view('conversation.job_conversation',compact('jobrequest','messages'));
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

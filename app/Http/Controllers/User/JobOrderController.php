<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\JobOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOrderController extends Controller
{
    public function index()
    {
        $orders= JobOrder::where('seller_id',auth()->id())->paginate(10);
        return view('user.joborder.index', compact('orders'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'order_complete_request' => 'required',
        ]);
        $joborder = JobOrder::findOrFail($id);
        $joborder->update([
            'order_complete_request' => $request->order_complete_request,
        ]);
        return redirect()->back()->with('success', 'Order Complete Request Sent Successfully');

    }

    public function details($id)
    {
        $order = JobOrder::findOrFail($id);
        return view('user.joborder.details', compact('order'));
    }
}

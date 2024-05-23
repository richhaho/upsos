<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller

{
   

public function resume($username)
    {
        $user = User::whereUsername($username)->firstOrFail();

        return view('frontend.resume', compact('user'));
    }




//public function resume(User $id)
 //   {
  //      return view('frontend.resume', [
   //         'user' => $id,
   // ]);
   // }





}
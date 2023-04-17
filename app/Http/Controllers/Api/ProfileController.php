<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
    * Update the image of the token bearer from resource.
    */
   public function image(UserRequest $request)
   {
       $user = User::findOrFail($request->user()->id);

       if ( !is_null($user->image) ){
           Storage::disk('public')->delete($user->image);
       }

       $user->image = $request->file('image')->storePublicly('images', 'public');

       $user->save();

       return $user;
   }

   /**
     * Display the specified information of the token bearer.
     */
    public function show(Request $request)
    {
        return $request->user();
    }

}

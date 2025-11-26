<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;


class ProfileController extends Controller
{
        public function edit()

       {
        $user = Auth::user();
        $profile = $user->profile; 
        return view('profile', compact('user','profile'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();
        $user->name = $request->username;
        $user->save();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        if ($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('avatars','public');

            $manager =  new ImageManager(new Driver());
            $manager->read(storage_path("app/public/{$path}"))
                ->resize(150,150)
                ->save();

            $profile->avatar = $path;
        }
        
        $profile->user_id = $user->id;
        $profile->postal_code = $request->postal_code;
        $profile->username = $request->username;
        $profile->address = $request->address;
        $profile->building = $request->building;

        $profile->save();

        return redirect()->route('index');
    }
}

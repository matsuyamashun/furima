<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
        public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile; 
        return view('profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->user()->update($request->all());
        return redirect()->route('index');
    }
}

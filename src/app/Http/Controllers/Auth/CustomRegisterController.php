<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class CustomRegisterController extends Controller
{
    public function store(Request $request, CreateNewUser $creator)
    {
        
        $user = $creator->create($request->all());

        
        Auth::login($user);

        
        return redirect()->route('profile.edit');
    }
}

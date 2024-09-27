<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|numeric'
        ]);

        $user = Auth::user();
        $user->phone_number = $request->input('phone_number');
        $user->save();

        return redirect()->back()->with('success', 'फोन नम्बर सफलतापूर्वक अपडेट गरियो।');
    }
}

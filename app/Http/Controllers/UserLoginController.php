<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class UserLoginController extends Controller
{
    use AuthenticatesUsers;

    public function userLogin(Request $request)
    {
        $status = "Wrong Email/ Password";
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $account = User::where('email', '=', $request->email)->first();
            $myState = $account->getUserDataLogin();

            return response()->json(['status' => 'success', 'userData' => $myState], 200);
        }
        
        return response()->json(['status' => $status]);
    }

    public function logout()
    {
        Auth::logout();

        session()->invalidate();

        return response()->json(['status' => 'success']);
    }
}

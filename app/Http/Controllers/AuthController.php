<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{
    public function login(Request $r)
    {
        $user  = User::whereEmail($r->email)->first();

        if (!is_null($user) && Hash::check($r->password, $user->password)) {

            $user->api_token = Str::random(100);
            $user->save();

            return response()->json([
                'code' => 200,
                'token' => $user->api_token
            ]);

        } else {
            return response()->json([
                'code' => 406,
                'msg' => 'Datos incorrecto'
            ]);
        }
    }
    public function logout()
    {
        $user = User::find(Auth::user()->id);
        $user->api_token = null;
        $user->save();
    }
}

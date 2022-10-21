<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $request["password"] = Hash::make($request->password);
        $user = User::create($request->all());
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function login(Request $r)
    {
        $user  = User::whereEmail($r->email)->first();

        if (!is_null($user) && Hash::check($r->password, $user->password)) {

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'msg' => 'Datos incorrectos'
            ], 406);
        }
    }
    public function logout(Request $request)
    {
        try {
            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();
            return response()->json(200);
        } catch (\Throwable $th) {
            return response()->json($th, 406);
        }
    }
}

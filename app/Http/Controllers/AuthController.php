<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreSuscription;
use App\Models\Suscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{


    public function login(Request $r)
    {
        $user = User::whereEmail($r->email)->first();

        if (!is_null($user) && Hash::check($r->password, $user->password)) {
            $store = Store::whereStoreId($user->store_id)->get(['store_id','store_state'])->first();
            $suscription_id = StoreSuscription::where('store_id', $store->store_id)->first()->suscription_id;
            $months_duration = Suscription::where('suscription_id', $suscription_id)->first()->months_duration;
            $months_duration = date('Y-m-d', strtotime("+ $months_duration month"));
            if ($store->store_state == 1 && date('Y-m-d') <= $months_duration) {
                $token = $user->createToken('auth_token')->plainTextToken;
                $user->auth_token = $token;
                $user->save();
                return response()->json([
                    'token' => $token,
                    'user' => $user,
                ], 200);
            } else {
                return response()->json([
                    'msg' => 'El comercio actual no tiene una suscripción activa',
                ], 401);
            }
        } else {
            return response()->json([
                'msg' => 'Datos incorrectos'
            ], 406);
        }
    }
    public function logout(Request $request)
    {
        try {
            $user = getUser();
            $user->auth_token = '';
            $user->save();
            return response()->json(200);
            $accessToken = $request->bearerToken();
            $token = PersonalAccessToken::findToken($accessToken);
            $token->delete();

            return response()->json(200);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function accessDenny()
    {
        return response()->json([
            'error' => 'unauthenticated.'
        ], 406);
    }
}

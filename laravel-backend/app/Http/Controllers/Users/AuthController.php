<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\RegistrationRequest;
use App\Http\Requests\Users\TokenRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request)
    {
        $input = $request->validated();

        $input['password'] = Hash::make($input['password']);
        $user = User::query()->create($input);

        $token = $user->createToken($this->getDeviceName($request))->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function token(TokenRequest $request)
    {
        $input = $request->validated();
        $input['password'] = Hash::make($input['password']);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'The provided credentials are incorrect.'], 401);
        }

        return response()->json(['token' => $user->createToken($this->getDeviceName($request))->plainTextToken]);
    }

    private function getDeviceName(Request $request)
    {
        if($request->has('device_name')) {
            return $request->device_name;
        }
        //        $agent = app(Agent::class)->browser(); ....
        return $request->userAgent();
    }
}

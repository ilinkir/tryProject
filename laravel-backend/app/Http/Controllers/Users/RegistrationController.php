<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Jobs\RegistrationUsers;
use App\Mail\Auth\VerifyMail;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
//        https://klisl.com/laravel-email-confirmation.html
        RegistrationUsers::dispatch($request->validated());

        return 'check your email ' . $request->email;
    }

    public function verify($token)
    {
        $user = User::query()->where('verify_token', $token)->first();

        if (empty($user)) {
            return 'Shit';
        }

        $user->update([
            'verify_token' => null,
            'email_verified_at' => Carbon::now()
        ]);

        return 'Your e-mail is verified. You can now login.';
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\ResetEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate(([
            'name'     => 'required|string',
            'email'    => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]));

        $user = User::create([
            'name'     => $fields['name'],
            'email'    => $fields['email'],
            'password' => bcrypt($fields['password']),

        ]);
        $token = $user->createToken($fields['password'])->plainTextToken;

        $response = [
            'user'  => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $fields['email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'One of the details is wrong',
            ], 401);
        }
        $token = $user->createToken($fields['password'])->plainTextToken;

        $response = [
            'user'  => $user,
            'token' => $token,
        ];
        return response($response, 201);
    }

    public function sendResetPasswordEmail(Request $request)
    {
        $email = $request->getContent();
        $user = User::where('email', $email)->first();

        if ($user) {
            $randomPassword = Hash::make(Str::random(1));
            $token = $user->createToken($randomPassword)->plainTextToken;
            $emailBuilder = [
                'title' => 'Hello ' . $user->name . '!',
                'body'  => 'Please click on the link below to reset your password',
                'link'  => ''.env('APP_URL_CLIENT').'/reset-password-form/'.$token,
            ];

            Mail::to($email)->send(new ResetEmail($emailBuilder));
            return response([
                'message' => 'We sent an E-mail with a reset link to ' . $email,
            ], 200);

        }
        return response([
            'message' => 'The inserted e-mail does not match ' .
                'any user in our records'], 400);
    }

    public function resetPasswordForm(Request $request) {

    }

}

<?php

namespace App\Http\Controllers;

use App\Mail\ResetEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

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
        $token = $user->createToken('sdhkfjg44hbf*&^GF')->plainTextToken;

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
        if (!$user) {
            return response([
                'message' => 'This email does not exist on our records',
            ], 401);
        }
        if (!Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Password is wrong',
            ], 401);
        }
        $token = $user->createToken('sdhkfjg44hbf*&^GF')->plainTextToken;

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

    public function checkToken(Request $request)
    {
        $token = $request->getContent();

        if ($token) {
            $tokenExist = PersonalAccessToken::findToken($token);
            if ($tokenExist) {
                return response(['message' => 'Ok', 'responseCode' => 1], 200);
            } else {
                return response(['message' => 'The given token was wrong', 'responseCode' => 2], 400);
            }
        } else {
            return  response(['message' => 'The given token does not exist', 'responseCode' => 3], 400);
        }
    }
    public function resetPasswordForm(Request $request) {

    }

}

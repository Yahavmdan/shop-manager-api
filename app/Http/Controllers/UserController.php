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
            'is_admin' => 'nullable',
        ]));

        $user = User::create([
            'name'     => $fields['name'],
            'email'    => $fields['email'],
            'password' => bcrypt($fields['password']),
            'is_admin' => $fields['is_admin']?: 0,
        ]);

        $token = $user->createToken($user->id)->plainTextToken;

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

            $token = $user->createToken($user->id)->plainTextToken;

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
            $token = $user->createToken($user->id)->plainTextToken;
            $user->withAccessToken($token);
            $emailBuilder = [
                'title' => 'Hello ' . $user->name . '!',
                'body'  => 'Please click on the link below to reset your password',
                'link'  => ''.env('APP_URL_CLIENT').'/reset-password-form?token='.$token,
            ];

            Mail::to($email)->send(new ResetEmail($emailBuilder));
            return response([
                'message' => 'We sent an E-mail with a reset link to ' . $email,
            ], 200);

        }
        return response(['message' => 'The inserted e-mail does not match any user in our records'], 400);
    }

    public function checkToken(Request $request)
    {
        $token = $request->getContent();

        if ($token) {
            $tokenExist = PersonalAccessToken::findToken($token);
            $user = User::where('id' , $tokenExist->name)->first();
            if ($tokenExist && $user->is_admin == 1) {
                return response(['message' => 'Ok', 'responseCode'  => 1], 200);
            }
            if ($tokenExist && $user->is_admin == 0) {
                return response(['message' => 'Ok', 'responseCode'  => 2], 200);
            }
        }
        return response(['message' => 'Bad request', 'responseCode' => 3], 400);
    }

    public function resetPassword(Request $request) {
        $newPassword = $request->newPassword;
        $token = $request->token;
        $tokenExist = PersonalAccessToken::findToken($token);
        $user = User::where('id', $tokenExist->name)->first();
        $user->password = Hash::make($newPassword);
        $user->save();
    }

    public function destroy($id) {

        $admin = User::where('id', $id)->first();
        if ($admin->is_admin === '1') {
            return response('Cannot delete admin user',400);
        }

        return User::destroy($id);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
        $user->update($request->all());

        return $user;
    }

    public function show($id)
    {
        return User::find($id);
    }

    public function index()
    {
        $response = User::all();
        return response($response,200);
    }
    public function search($searchValue)
    {
        return User::
        where('name', 'like', '%' . $searchValue . '%')
            ->orWhere('email', 'like', '%' . $searchValue . '%')
            ->orWhere('id', 'like', '%' . $searchValue . '%')
            ->get();

    }

}

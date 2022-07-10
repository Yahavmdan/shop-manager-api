<?php

namespace App\Http\Controllers;

use App\Models\ProfilePicture;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $profilePicture = new ProfilePicture;
        if ($request->hasFile('image')) {
            $completeFileName = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($completeFileName, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $completePic = str_replace(' ','_',$fileName).'-'.rand() . '_'.time(). '.'.
            $extension;
            $request->file('image')->storeAs('public/profilePics', $completePic);
            $profilePicture->image = $completePic;
        }
        if($profilePicture->save()) {
            $response = ['pic' => 'hg', 'message' => 'Upload success' ];
            return response($response);
        } else {
            return response([
                'message' => 'Upload failed',
            ], 400);
        }
    }
}

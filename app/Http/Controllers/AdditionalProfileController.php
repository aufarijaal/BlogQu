<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdditionalProfileController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->only("user-id", "username", "bio", "about", "gender", "dob"), [
            "user-id" => "required|numeric|exists:users,id",
            "username" => "required|max:100|unique:profiles,username,{$request['user-id']}",
            "bio" => "max:255",
            "about" => "max:255",
            "gender" => "required|in:M,F",
            "dob" => "required|date"
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \App\Models\Profile::where("user_id", (int) $request["user-id"])->update([
            "username" => $request["username"],
            "bio" => $request["bio"],
            "about" => $request["about"],
            "gender" => $request["gender"],
            "dob" => $request["dob"],
        ]);

        return back()->with("message", "Profile updated.");
    }
}

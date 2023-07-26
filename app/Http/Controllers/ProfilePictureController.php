<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfilePictureController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pp' => 'required|image|mimes:png,jpg,jpeg|max:3000', // Max size in kilobytes (3MB)
            'user-id' => 'required|numeric|exists:users,id'
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $ppPath = \App\Models\Profile::select("pp")->where("user_id", (int) $request["user-id"])->get()->pluck("pp")->first();
        if (!is_null($ppPath) && Storage::exists("public/" . $ppPath)) {
            Storage::delete("public/" . $ppPath);
        }

        $file = $request->file("pp");
        $path = $file->storePubliclyAs(sprintf("profile-pictures/%d", (int) $request["user-id"]), $file->hashName(), "public");

        \App\Models\Profile::where("user_id", (int) $request["user-id"])->update([
            "pp" => $path
        ]);

        return back();
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->only("user-id"), [
            'user-id' => 'required|numeric|exists:users,id'
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return redirect()->back();
        }

        $ppPath = \App\Models\Profile::select("pp")->where("user_id", (int) $request["user-id"])->get()->pluck("pp")->first();
        if (!is_null($ppPath) && Storage::exists("public/" . $ppPath)) {
            Storage::delete("public/" . $ppPath);
        }

        \App\Models\Profile::where("user_id", (int) $request["user-id"])->update([
            "pp" => null
        ]);

        return back();
    }
}

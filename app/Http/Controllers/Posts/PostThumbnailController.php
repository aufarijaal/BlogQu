<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostThumbnailController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'thumbnail' => 'required|image|mimes:png,jpg,jpeg|max:3000', // Max size in kilobytes (3MB)
            'post-id' => 'required|numeric|exists:posts,id'
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $thumbnailPath = \App\Models\Post::select("thumbnail")->where("id", (int) $request["post-id"])->get()->pluck("thumbnail")->first();
        if (!is_null($thumbnailPath) && Storage::exists("public/" . $thumbnailPath)) {
            Storage::delete("public/" . $thumbnailPath);
        }

        $file = $request->file("thumbnail");
        $path = $file->storePubliclyAs(sprintf("thumbnails/%d", $request["post-id"]), $file->hashName(), "public");

        \App\Models\Post::where("id", (int) $request["post-id"])->update([
            "thumbnail" => $path
        ]);

        return back();
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->only("post-id"), [
            'post-id' => 'required|numeric|exists:posts,id'
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $thumbnailPath = \App\Models\Post::select("thumbnail")->where("id", (int) $request["post-id"])->get()->pluck("thumbnail")->first();
        if (!is_null($thumbnailPath) && Storage::exists("public/" . $thumbnailPath)) {
            Storage::delete("public/" . $thumbnailPath);
        }

        \App\Models\Post::where("id", (int) $request["post-id"])->update([
            "thumbnail" => null
        ]);

        return back();
    }
}

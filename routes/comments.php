<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Comment;

Route::prefix("comments")->group(function () {
    Route::middleware("auth")->post("/", function(Request $request) {
        Comment::create([
            "post_id" => $request["post-id"],
            "user_id" => auth()->user()->id,
            "parent_id" => $request["parent-id"],
            "content" => $request["content"]
        ]);

        return back();
    })->name("comments.create");
    
    Route::middleware("auth")->put("/", function(Request $request) {
        Comment::where("id", (int) $request['comment-id'])->update([
            "content" => $request["content"]
        ]);
    
        return back();
    })->name("comments.update");

    Route::middleware("auth")->delete("/", function(Request $request) {
        Comment::where("id", (int) $request['comment-id'])->delete();
        Comment::where("parent_id", (int) $request['comment-id'])->delete();

        return back();
    })->name("comments.destroy");
});

Route::prefix("comment-likes")->group(function () {
    Route::middleware("auth")->post("/", function(Request $request) {
        
    })->name("comment-likes.create");

    Route::middleware("auth")->delete("/", function(Request $request) {

    })->name("comment-likes.destroy");
});
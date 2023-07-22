<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MyPostsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $posts = DB::table("posts")->select(
            "posts.id as post_id",
            "posts.user_id as author_id",
            "posts.title as post_title",
            "posts.status as post_status",
            "posts.updated_at as post_updated_at"
        )->where("posts.user_id", $user->id);

        switch ($request->query('sort')) {
            case 'status':
                $posts->orderBy('posts.status');
                break;
            case 'newest':
                $posts->orderByDesc('posts.created_at');
                break;
            case 'oldest':
                $posts->orderBy('posts.created_at');
                break;
            case 'recent-update':
                $posts->orderByDesc('posts.updated_at');
                break;
            default:
                $posts->orderBy('posts.title');
                break;
        }

        return view("posts.my-posts", [
            "posts" => $posts->get()
        ]);
    }
}

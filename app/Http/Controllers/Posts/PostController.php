<?php

namespace App\Http\Controllers\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = \App\Models\Post::create([
            "user_id" => auth()->user()->id
        ]);

        return redirect()->route("posts.edit", ["postId" => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Models\Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($postId)
    {
        $post = DB::table('posts')->select(
            "posts.id as post_id",
            "posts.category_id",
            "categories.name as category_name",
            "categories.slug as category_slug",
            "posts.title as post_title",
            "posts.thumbnail as post_thumbnail",
            "posts.status as post_status",
            "posts.parent_id as post_parent_id",
            "posts.updated_at",
        )->leftJoin("categories", "categories.id", "=", "posts.category_id")
            ->where("posts.id", $postId)->get()->first();

        $postBody = \App\Models\Post::select("body")->where("id", $post->post_id)->get()->first()->body;
        $allTags = \App\Models\Tag::all();
        $allCategories = \App\Models\Category::all("name", "slug");
        $tagsFilter = \App\Models\PostTag::where("post_id", $post->post_id)->get()->pluck("tag_id")->toArray();
        $existingTags = $allTags->whereIn("id", $tagsFilter);

        return view("posts.edit", [
            "post" => $post,
            "allTags" => $allTags,
            "allCategories" => $allCategories,
            "existing" => $existingTags->toJson(),
            "postBody" => $postBody
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->only([
            "id", "title", "category", "tags", "body", "status"
        ]), [
            "id" => "required|exists:posts,id",
            "title" => "required_unless:status,draft|max:255",
            "category" => "required_unless:status,draft",
            "tags" => [
                function ($attribute, $value, $fail) use ($request) {
                    if (count(json_decode($value)->new) + count(json_decode($value)->tags) == 0 && $request["status"] != "draft") {
                        $fail('The ' . $attribute . ' field is required unless status is in draft.');
                    }
                }
            ],
            "body" => "required_unless:status,draft",
            "status" => "required"
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $tagsRequest = json_decode($request["tags"]);

        DB::beginTransaction();
            $post = \App\Models\Post::find((int) $request["id"]);
            $tagIdsToSync = [];

            // Prepare the tag ids for synchronization, first populate the ids from the already existing tags.
            foreach ($tagsRequest->tags as $item) {
                array_push($tagIdsToSync, $item->id);
            }

            // And then, insert the new tags if user specifiy them.
            if(count($tagsRequest->new) != 0) {
                foreach ($tagsRequest->new as $tagName) {
                    $t = \App\Models\Tag::create([
                        "name" => $tagName
                    ]);

                    \App\Models\Tag::where("id", $t->id)->update([
                        "slug" => Str::slug($t->id . "-" . $t->name)
                    ]);

                    // Push the tag id to the ids array for synchronization
                    array_push($tagIdsToSync, $t->id);
                }
            }

            // Second, sync the tags using the combination of newly created tags from the user and the updated old tags from the post
            $post->tags()->sync($tagIdsToSync);
            $post->update([
                "category_id" => explode("-", $request["category"])[0],
                "title" => $request["title"],
                "slug" => Str::slug($request["title"] . "-" . fake()->uuid()),
                "body" => $request["body"],
                "excerpt" => Str::limit(strip_tags($request["body"]), 100, ""),
                "status" => $request["status"]
            ]);
        DB::commit();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->only(["post-id"]), [
            "post-id" => "required|exists:posts,id",
        ]);

        if ($validator->fails()) {
            // Handle validation errors
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \App\Models\Post::where("id", (int) $request["post-id"])->delete();

        return back();
    }
}

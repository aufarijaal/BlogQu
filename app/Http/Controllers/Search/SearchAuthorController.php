<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchAuthorController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $authors = DB::table("users")
            ->select(
                "users.id as author_id",
                "users.name as author_name",
                "profiles.username as author_username",
                "profiles.bio as author_bio",
                "profiles.pp as author_pp"
            )
            ->join("profiles", "profiles.user_id", "=", "users.id")
            ->where("users.name", "LIKE", sprintf("%%%s%%", $request->query("q")))
            ->orWhere("profiles.username", "LIKE", sprintf("%%%s%%", $request->query("q")))
            ->get();

        return view("search.index", [
            "authors" => $authors,
            "tab" => "authors",
            "query" => $request->query("q")
        ]);
    }
}

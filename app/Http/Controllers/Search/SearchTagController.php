<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchTagController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $tags = \App\Models\Tag::where("name", "LIKE", sprintf("%%%s%%", $request->query("q")))->orderBy("name")->get();

        return view("search.index", [
            "tags" => $tags,
            "tab" => "tags",
            "query" => $request->query("q")
        ]);
    }
}

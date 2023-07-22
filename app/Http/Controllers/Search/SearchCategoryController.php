<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SearchCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $categories = \App\Models\Category::where("name", "LIKE", sprintf("%%%s%%", $request->query("q")))->orderBy("name")->get();

        return view("search.index", [
            "categories" => $categories,
            "tab" => "categories",
            "query" => $request->query("q")
        ]);
    }
}

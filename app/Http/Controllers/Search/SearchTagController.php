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
        $currentPage = $request->query("page") ?? 1;
        $dataPerPage = 25;
        $nextPage = (int) $currentPage + 1;
        $prevPage = (int) $currentPage - 1;
        $hasNextPage = null;
        $hasPrevPage = null;
        $totalPages = null;
        $totalData = null;

        $tags = \App\Models\Tag::where("name", "LIKE", sprintf("%%%s%%", $request->query("q")))->orderBy("name")->limit($dataPerPage)->offset($dataPerPage * ($currentPage - 1))->get();
        $totalData = \App\Models\Tag::where("name", "LIKE", sprintf("%%%s%%", $request->query("q")))->orderBy("name")->count();

        $totalPages = (int) ceil($totalData / $dataPerPage);
        $hasPrevPage = $currentPage > 1;
        $hasNextPage = $currentPage < $totalPages;
        return view("search.index", [
            "tags" => $tags,
            "tab" => "tags",
            "query" => $request->query("q"),
            "nextPage" => $nextPage,
            "prevPage" => $prevPage,
            "hasPrevPage" => $hasPrevPage,
            "hasNextPage" => $hasNextPage,
            "currentPage" => $currentPage,
            "dataPerPage" => $dataPerPage,
            "totalData" => $totalData,
            "totalPages" => $totalPages
        ]);
    }
}

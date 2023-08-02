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
        $currentPage = $request->query("page") ?? 1;
        $dataPerPage = 5;
        $nextPage = (int) $currentPage + 1;
        $prevPage = (int) $currentPage - 1;
        $hasNextPage = null;
        $hasPrevPage = null;
        $totalPages = null;
        $totalData = null;

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
            ->limit($dataPerPage)
            ->offset($dataPerPage * ($currentPage - 1))
            ->get();

        $totalData = DB::table("users")
            ->select(DB::raw("COUNT(*) as total_count"))
            ->join("profiles", "profiles.user_id", "=", "users.id")
            ->where("users.name", "LIKE", sprintf("%%%s%%", $request->query("q")))
            ->orWhere("profiles.username", "LIKE", sprintf("%%%s%%", $request->query("q")))
            ->get()->first()->total_count;

        $totalPages = (int) ceil($totalData / $dataPerPage);
        $hasPrevPage = $currentPage > 1;
        $hasNextPage = $currentPage < $totalPages;
        return view("search.index", [
            "authors" => $authors,
            "tab" => "authors",
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

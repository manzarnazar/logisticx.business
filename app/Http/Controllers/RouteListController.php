<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\RouteList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteListController extends Controller
{
    public function searchRoute(Request $request)
    {
        if (!request()->ajax() || $request->input('search') == null) {
            return;
        }

        $routes = RouteList::where('status', Status::ACTIVE)
            ->where('title', 'LIKE', '%' . $request->input('search') . '%')
            ->latest('updated_at')
            ->orderBy('name')
            ->select(['title', 'name'])
            ->get();

        return view('backend.setting.route_list.route_datalist', compact('routes'));
    }

    public function search(Request $request)
    {
        $search = $request->input('q');
        if ($search == null) {
            return redirect()->back();
        }

        $route = RouteList::where('status', Status::ACTIVE)->where('title', $search)->orWhere('name', $search)->orWhere('uri', $search)->first();

        if (is_null($route)) {
            return redirect()->back()->with('danger', ___('alert.no_result_found'), 'error');
        }

        return redirect()->route($route->name);

        // $baseQuery = RouteList::where('status', Status::ACTIVE);

        // $columns = ['title', 'name', 'uri'];

        // foreach ($columns as $column) {

        //     $query = clone $baseQuery;

        //     // $query->where($column, 'LIKE', '%' . $search . '%');
        //     $query->where($column, $search);

        //     if ($query->exists()) {
        //         break; // Stop loop if matches are found
        //     }
        // }

        // if ($query->count()  === 1) {
        //     $route = $query->first();
        //     return redirect()->route($route->name);
        // }

        // return redirect()->back()->with('danger', ___('alert.no_result_found'), 'error');
    }
}

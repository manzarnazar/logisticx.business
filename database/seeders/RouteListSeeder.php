<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\RouteList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class RouteListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RouteList::truncate();

        $prefixes = ['admin', 'merchant', 'parcel'];

        $routes = Route::getRoutes()->getRoutesByMethod()['GET'];

        foreach ($routes as $route) {

            $title = str_replace(['.', '-'], ' ', $route->getName());
            $title = ucwords(preg_replace('/([a-z])([A-Z])/', '$1 $2', $title));

            $routeName  = $route->getName();
            $uri        = $route->uri();

            $negativePattern = '/\{[a-zA-Z]+\}/'; // Regular expression pattern to match "{any}"

            if ((Str::startsWith($uri, $prefixes) || Str::startsWith($routeName, 'dashboard')) && !preg_match($negativePattern, $uri) && !is_null($routeName)) {
                $routeList          = new RouteList();
                $routeList->title   = $title;
                $routeList->name    = $routeName;
                $routeList->uri     = $uri;
                $routeList->status  = Status::ACTIVE;
                $routeList->save();
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(settings('paginate_value'));

        return view('backend.notification.index', compact('notifications'));
    }
}

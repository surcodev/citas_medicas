<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CalendarController extends Controller
{
    public function index()
    {
        Gate::authorize('read_calendar');
        return view('admin.calendar.index');
    }
}

<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display user's dashboard
     */
    public function index()
    {
        return view('user.Dashboard.index');
    }
}

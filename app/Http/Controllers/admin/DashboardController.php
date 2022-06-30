<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        // $admin = DB::table('users')
        //     ->join('admins', 'users.id', '=', 'admins.user_id')
        //     ->where('status', '1')
        //     ->orderBy('nama', 'asc')
        //     ->get();
            
        return view('admin.dashboard.dashboard');
        // return view('admin.dashboard.admin.manajemen_admin', compact(''));
    }
}

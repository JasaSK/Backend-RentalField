<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Field;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::all();
        $fieldCount = Field::count();
        $maintenanceCount = Schedule::count();

        return view('admin.dashboard', compact('user', 'fieldCount', 'maintenanceCount'));
    }
}

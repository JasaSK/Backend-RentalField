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
        $bookingCount = Booking::where('created_at', '>=', now()->subDay())->count();
        $fieldStatus = Field::where('status', 'available')->count();

        $lastMonth = now()->subMonth();


        $lastMonthIncome = Booking::where('status', 'approved')
            ->whereMonth('date', $lastMonth->month)
            ->whereYear('date', $lastMonth->year)
            ->sum('total_price');

        $incomeThisMonth = Booking::where('status', 'approved')
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->sum('total_price');

        if ($lastMonthIncome > 0) {
            $percentageChange = (($incomeThisMonth - $lastMonthIncome) / $lastMonthIncome) * 100;
        } else {
            $percentageChange = 100;
        }

        $percentageChange = number_format($percentageChange, 2);

        $weeklyOrders = Booking::selectRaw('WEEK(date, 1) as week, COUNT(*) as total')
            ->whereMonth('date', now()->month)
            ->groupBy('week')
            ->pluck('total');

        $weeklyIncome = Booking::selectRaw('WEEK(date, 1) as week, SUM(total_price) as total')
            ->whereMonth('date', now()->month)
            ->groupBy('week')
            ->pluck('total');

        // dd($percentageChange);
        return view('admin.dashboard', compact(
            'user',
            'fieldCount',
            'maintenanceCount',
            'bookingCount',
            'fieldStatus',
            'incomeThisMonth',
            'percentageChange',
            'weeklyOrders',
            'weeklyIncome'
        ));
    }
}

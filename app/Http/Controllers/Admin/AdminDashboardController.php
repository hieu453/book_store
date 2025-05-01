<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $revenues = DB::table('orders')
                        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_price) as revenue")
                        ->whereBetween(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), [$from, $to])
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get();

        return Inertia::render('Admin/Index', [
            'from' => $from,
            'to' => $to,
            'revenues' => $revenues,
        ]);
    }
}

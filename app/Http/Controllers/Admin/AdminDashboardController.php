<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $revenues = DB::table('orders')
                        ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total_price) as revenue")
                        ->whereBetween(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), [$from, $to])
                        ->where('status', '=', 'completed')
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get();

        $usersCount = User::count();
        $productsCount = Product::count();
        $categoriesCount = Category::count();
        $ordersCount = Order::count();

        $totalRevenues = Order::where('status', 'completed')->sum('total_price');

        return Inertia::render('Admin/Index', [
            'from' => $from,
            'to' => $to,
            'revenues' => $revenues,
            'usersCount' => $usersCount,
            'productsCount' => $productsCount,
            'categoriesCount' => $categoriesCount,
            'ordersCount' => $ordersCount,
            'totalRevenues' => $totalRevenues,
        ]);
    }
}

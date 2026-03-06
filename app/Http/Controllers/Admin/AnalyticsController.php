<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index()
    {
        // $totalRevenue = Order::whereMonth('created_at', now()->month)
        //                     ->where('status','completed')
        //                     ->sum('total');
        $totalRevenue = 200;

        // $totalOrders = Order::whereMonth('created_at', now()->month)->count();
        $totalOrders = 12;

        // $totalCustomers = User::count();
        $totalCustomers = 10;

        $lowStockCount = Product::where('stock','<',5)->count();

        $months = ['Jan','Feb','Mar','Apr','May','Jun'];
        $monthlyRevenue = [12000,15000,18000,14000,22000,25000];

        return view('admin.analytics.index', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'lowStockCount',
            'months',
            'monthlyRevenue'
        ));
    }
}

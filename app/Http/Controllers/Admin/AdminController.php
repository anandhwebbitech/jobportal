<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'password' => $request->password,
        ];

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $request->username;
        } else {
            $credentials['username'] = $request->username;
        }

        if (Auth::attempt($credentials)) {

            if (Auth::user()->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->route('admin.admindashboard')->with('success', 'Login Successfully!');
            }

            Auth::logout();
            return back()->withInput($request->only('username'))->with('error', 'You are not an admin');
        }

        return back()->withInput($request->only('username'))->with('error', 'Invalid credentials');
    }

    public function dashboard()
    {
        // $totalRevenue = Order::where('status','completed')->sum('total');
        $totalRevenue = 200;
        // $orderCount = Order::count();
        $orderCount = 176;
        $customerCount = User::count();
        $lowStockCount = 1000;
        $productCount = 1000;
        $categoryCount = 1000;
        $colorCount = 1000;
        $sizeCount = 1000;

        $recentOrders = [];

       
        $months = ['Jan','Feb','Mar','Apr','May','Jun'];
        $monthlySales = [1000,2000,3000,2500,4000,5000];

        return view('admin.index', compact(
            'totalRevenue',
            'orderCount',
            'customerCount',
            'lowStockCount',
            'productCount',
            'categoryCount',
            'colorCount',
            'sizeCount',
            'recentOrders',
            'months',
            'monthlySales'
        ));
    }

    public function logout(Request $request)
    {
        // Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Logout Successfully!');
    }
}

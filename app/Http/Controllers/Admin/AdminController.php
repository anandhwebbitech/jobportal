<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\TestStatus\Notice;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
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
    public function AdminNotification(){
        return view('admin.notification');
    }
    public function AdminNotificationData(Request $request){
       $adminNotification = Notification::where('send_to', Auth::user()->id)
        ->latest();

        return DataTables::of($adminNotification)

        ->addIndexColumn()

        ->addColumn('type', function ($row) {
            return $row->type_label; // ✅ TEXT instead of number
        })

        ->addColumn('message', function ($row) {
            return $row->message ?? '-';
        })

        ->addColumn('send_from', function ($row) {
            return $row->sender->name ?? 'System'; 
            // assuming relation: sender()
        })

        ->addColumn('date', function ($row) {
            return Carbon::parse($row->created_at)->format('d M Y, h:i A');
        })

        ->addColumn('action', function ($row) {
            return '
                <button class="btn btn-sm btn-primary viewBtn" data-id="'.$row->id.'">View</button>
                ';
                // <button class="btn btn-sm btn-danger deleteBtn" data-id="'.$row->id.'">Delete</button>
        })

        ->rawColumns(['action'])

        ->make(true);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $users = User::where('role', 'user')->latest();

            return DataTables::of($users)
                ->addIndexColumn()

                ->filter(function ($query) {
                    if (request()->has('search') && $search = request('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('created_at', 'like', "%{$search}%");
                        });
                    }
                })

                ->editColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })

                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex gap-2">
                            <a href="'. route('admin.users.edit', $row->id) .'" 
                            class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>

                            <button data-id="'.$row->id.'"
                                data-route="'.route('admin.users.destroy', $row->id).'" 
                                class="btn btn-sm btn-danger delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })

                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('admin.customers.index');
    }
}

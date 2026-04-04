<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Models\Notification;
use App\Events\UserNotification;
class JobSeekerController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::with('details')->where('role','user')->orderBy('id','desc');

            return DataTables::of($data)

                ->addIndexColumn()

                ->addColumn('mobile', function ($row) {
                    return $row->details->mobile ?? '-';
                })

                ->addColumn('location', function ($row) {
                    return ($row->details->city ?? '') . ', ' . ($row->details->state ?? '');
                })

                ->addColumn('qualification', function ($row) {
                    return $row->details->qualification ?? '-';
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_active == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } elseif ($row->is_active == 0) {
                        return '<span class="badge bg-secondary">Inactive</span>';
                    } elseif ($row->is_active == 2) {
                        return '<span class="badge bg-info">Resubmitted</span>';
                    } elseif ($row->is_active == 3) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    }

                    return '<span class="badge bg-warning">Unknown</span>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-info viewUser" data-id="'.$row->id.'">
                            <i class="fa fa-eye"></i> 
                        </button>
                       
                    ';
                    //  <button class="btn btn-sm btn-danger delete" data-id="'.$row->id.'">
                    //         <i class="fa fa-trash"></i> 
                    //     </button>
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin.jobseeker.index');
    }
    public function show($id)
    {
        $user = User::with('details')->findOrFail($id);
        $user->created_at_formatted = $user->created_at
            ? $user->created_at->format('d M Y h:i A')
            : '-';
        if ($user->detail && $user->detail->skills) {
            $user->detail->skills = json_decode($user->detail->skills, true);
        }
        return response()->json($user);
    }

    public function Approve(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'is_active'     => false,
                'reject_reason' => 'User not found'
            ]);
        }
        $user->is_active = $request->is_active;

        if ($request->is_active == 3) {
            $user->reject_message = $request->reject_message;
        }
        if ($user->save()) {
            
            try {
                $this->RegisterMail($user->is_active, $user->id);

            } catch (\Exception $e) {
                \Log::error('Mail Error: ' . $e->getMessage());
            }

            return response()->json([
                'status' => true,
                'message' => 'User status updated successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to update user status'
        ]);
    }

    public function RegisterMail($type, $userId)
    {
        $user = User::with('details')->find($userId);

        if (!$user) {
            return;
        }

        // ✅ Status Text
        $statusText = match ($user->is_active) {
            1 => 'Approved',
            3 => 'Rejected',
            default => 'Pending',
        };

        $data = [
            'name'   => $user->name,
            'status' => $statusText,
            'email'  => $user->email,
            'mobile' => $user->details->mobile ?? '',
        ];

        Mail::send('emails.registermail', $data, function ($message) use ($data, $statusText) {
            $message->to($data['email'])
                ->subject('Linner Job Portal Registration is ' . $statusText);
        });
    }

}

<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function index()
    {
        return view('frontend.jobseeker.notifications');
    }
    public function list(Request $request)
    {
        $query = Notification::where('send_to', auth()->id());

        // Filters
        if ($request->filter == 'unread') {
            $query->where('is_read', 0);
        }

        if ($request->filter == 'interview') {
            $query->where('type', Notification::TYPE_JOB_APPLICATION_INTERVIEW);
        }

        if ($request->filter == 'application') {
            $query->where('type', 'application');
        }

        $notifications = $query->latest()->paginate(10);

        return response()->json($notifications);
    }

    public function markRead($id)
    {
        $notification = Notification::find($id);
        if(!$notification) {
            return response()->json(['status' => false, 'msg' => 'Not found']);
        }

        $notification->is_read = 1;
        $notification->save();

        return response()->json(['status' => true]);
    }
  

    public function readAll()
    {
        return back();
    }

   public function clearAll()
    {
        $notifications = Notification::where('send_to', Auth::id());
        if (!$notifications->exists()) {
            return response()->json(['status' => false, 'msg' => 'No notifications found']);
        }
        // dd(8);
        $notifications->delete();
        return response()->json(['status' => true, 'msg' => 'All notifications cleared']);
    }

    public function Notificationlist(Request $request)
    {
        $notifications = $this->notificationService->getUserNotifications();
        $notifs = $notifications->map(function ($n) {
            return [
                'id'    => $n->id,
                'title' => $n->title ?? 'Notification',
                'msg'   => $n->message ?? '',
                // 'type'  => $n->data['type'] ?? 'info',
                'type' => isset($n->type)  ? Notification::typeName($n->type) : 'Unknown',
                'type_id' => $n->type,
                'read'  => $n->is_read,
                'date'  => $n->created_at->diffForHumans(),
                'group' => $n->created_at->isToday() ? 'today' : 'older',

                // UI mapping
                'ico'  => 'fas fa-bell',
                'icls' => 'info',
                'tcls' => 'chip-info',
                'tlbl' => isset($n->type)  ? ucfirst(Notification::typeName($n->type)) : 'Unknown',

                'actions' => [
                    [
                        'lbl' => 'View',
                        'ico' => 'fas fa-eye',
                        'cls' => 'primary'
                    ]
                ]
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $notifs
        ]);
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);

        if(!$notification) {
            return response()->json(['status' => false, 'msg' => 'Notification not found']);
        }

        $notification->delete();

        return response()->json(['status' => true]);
    }
    public function markAllRead()
    {
        // Mark all unread notifications as read
        Notification::where('is_read', 0)->where('send_to',Auth::id())->update(['is_read' => 1]);

        return response()->json(['status' => true]);
    }
}
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
        $query = Notification::where('send_to', auth()->id())
            ->latest();

        // ✅ Unread Filter
        if ($request->filter == 'unread') {

            $query->where('is_read', 0);
        }

        // ✅ Interview Filter
        if ($request->filter == 'interview') {

            $query->whereIn('type', [
                Notification::TYPE_JOB_APPLICATION_INTERVIEW
            ]);
        }

        // ✅ Application Filter
        if ($request->filter == 'application') {

            $query->whereIn('type', [

                Notification::TYPE_JOB_APPLICATION,
                Notification::TYPE_JOB_APPLICATION_SHORTLIST,
                Notification::TYPE_JOB_APPLICATION_REJECT,
                Notification::TYPE_JOB_APPLICATION_INTERVIEW

            ]);
        }

        // ✅ Alert Filter
        if ($request->filter == 'alert') {

            $query->whereIn('type', [

                Notification::TYPE_JOB_POST,
                Notification::TYPE_JOB_UPDATE

            ]);
        }

        // ✅ Admin Filter
        if ($request->filter == 'admin') {

            $query->whereIn('type', [

                Notification::TYPE_EMPLOYER_APPROVED,
                Notification::TYPE_EMPLOYER_PENDING,
                Notification::TYPE_EMPLOYER_REJECT

            ]);
        }

        $notifications = $query->get();

        $notifs = $notifications->map(function ($n) {

            // -----------------------------------
            // DEFAULT VALUES
            // -----------------------------------

            $frontendType = 'system';

            $ico  = 'fas fa-bell';

            $icls = 'ni-sys';

            $tcls = 'nc-sys';

            $tlbl = 'System';

            // -----------------------------------
            // APPLICATION TYPES
            // -----------------------------------

            if (in_array($n->type, [

                Notification::TYPE_JOB_APPLICATION,
                Notification::TYPE_JOB_APPLICATION_SHORTLIST,
                Notification::TYPE_JOB_APPLICATION_REJECT,
                Notification::TYPE_JOB_APPLICATION_INTERVIEW

            ])) {

                $frontendType = 'application';

                $ico  = 'fas fa-file-user';

                $icls = 'ni-app';

                $tcls = 'nc-app';

                $tlbl = 'Application';
            }

            // -----------------------------------
            // ALERT TYPES
            // -----------------------------------

            elseif (in_array($n->type, [

                Notification::TYPE_JOB_POST,
                Notification::TYPE_JOB_UPDATE

            ])) {

                $frontendType = 'alert';

                $ico  = 'fas fa-triangle-exclamation';

                $icls = 'ni-alert';

                $tcls = 'nc-alert';

                $tlbl = 'Alert';
            }

            // -----------------------------------
            // ADMIN TYPES
            // -----------------------------------

            elseif (in_array($n->type, [

                Notification::TYPE_EMPLOYER_APPROVED,
                Notification::TYPE_EMPLOYER_PENDING,
                Notification::TYPE_EMPLOYER_REJECT

            ])) {

                $frontendType = 'admin';

                $ico  = 'fas fa-shield-check';

                $icls = 'ni-admin';

                $tcls = 'nc-admin';

                $tlbl = 'Admin';
            }

            // -----------------------------------
            // SHORTLIST
            // -----------------------------------

            if ($n->type == Notification::TYPE_JOB_APPLICATION_SHORTLIST) {

                $frontendType = 'shortlist';

                $ico  = 'fas fa-star';

                $icls = 'ni-sl';

                $tcls = 'nc-sl';

                $tlbl = 'Shortlisted';
            }

            return [

                'id' => $n->id,

                'title' => $n->title ?? 'Notification',

                'msg' => $n->message ?? '',

                // frontend use
                'type' => $frontendType,

                // original type
                'type_id' => $n->type,

                'read' => $n->is_read,

                'read_at' => $n->is_read ? now() : null,

                'created_at' => $n->created_at,

                'date' => $n->created_at->diffForHumans(),

                'group' => $n->created_at->isToday()
                    ? 'today'
                    : 'older',

                // UI
                'ico' => $ico,

                'icls' => $icls,

                'tcls' => $tcls,

                'tlbl' => $tlbl,

                // Actions
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
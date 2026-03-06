<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index($type){
        return view('admin.settings.index')->with('activeTab', $type);
    }

    public function update(Request $request)
    {
        $type = $request->type;

        if (!$type) {
            return back()->with('error', 'Invalid settings type.');
        }

        $keys = [];

        /*
        |--------------------------------------------------------------------------
        | GENERAL SETTINGS
        |--------------------------------------------------------------------------
        */
        if ($type === 'general') {

            $request->validate([
                'site_name'  => 'required|string|max:255',
                'site_email' => 'required|email|max:255',
                'site_logo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $keys = [
                'site_name',
                'site_email',
                'site_address',
            ];

            if ($request->hasFile('site_logo')) {

                $logo = $request->file('site_logo');

                if (setting('site_logo') && file_exists(public_path(setting('site_logo')))) {
                    unlink(public_path(setting('site_logo')));
                }

                $filename = time() . '_' . $logo->getClientOriginalName();

                $logo->move(public_path('uploads/settings'), $filename);

                $logoPath = 'uploads/settings/' . $filename;

                Setting::updateOrCreate(
                    ['key' => 'site_logo'],
                    ['value' => $logoPath]
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EMAIL SETTINGS
        |--------------------------------------------------------------------------
        */
        elseif ($type === 'email') {

            $request->validate([
                'mail_host'     => 'required|string|max:255',
                'mail_port'     => 'required',
                'mail_username' => 'required|string|max:255',
                'mail_password' => 'nullable|string|max:255',
            ]);

            $keys = [
                'mail_host',
                'mail_port',
                'mail_username',
                'mail_password',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | PAYMENT SETTINGS
        |--------------------------------------------------------------------------
        */
        elseif ($type === 'payment') {

            $request->validate([
                'payment_client_id' => 'nullable|string|max:255',
                'payment_secret_key'=> 'nullable|string|max:255',
            ]);

            // Checkbox handling
            Setting::updateOrCreate(
                ['key' => 'online_payment_status'],
                ['value' => $request->has('online_payment_status') ? 1 : 0]
            );

            $keys = [
                'payment_client_id',
                'payment_secret_key',
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | PROFILE UPDATE
        |--------------------------------------------------------------------------
        */
        elseif ($type === 'profile') {

            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
                'avatar'=> 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $user = auth()->user();
            $user->name  = $request->name;
            $user->email = $request->email;

            if ($request->has('remove_avatar')) {

                if ($user->avatar && file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }

                $user->avatar = null;
            }
            if ($request->hasFile('avatar')) {

                $avatar = $request->file('avatar');

                if ($user->avatar && file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }

                $filename = time() . '_' . $avatar->getClientOriginalName();

                $avatar->move(public_path('uploads/profile'), $filename);

                $user->avatar = 'uploads/profile/' . $filename;
            }

            $user->save();

            return redirect()->back()
                ->with('success', 'Profile updated successfully.')
                ->with('activeTab', 'profile');
        }

        /*
        |--------------------------------------------------------------------------
        | PASSWORD UPDATE
        |--------------------------------------------------------------------------
        */
        elseif ($type === 'password') {

            $request->validate([
                'current_password'      => 'required',
                'new_password'          => 'required|min:6|confirmed',
            ]);

            $user = auth()->user();

            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'Current password is incorrect'
                ])->with('activeTab', 'profile');
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->back()
                ->with('success', 'Password updated successfully.')
                ->with('activeTab', 'profile');
        }

        else {
            return back()->with('error', 'Invalid settings type.');
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE SETTINGS (General, Email, Payment)
        |--------------------------------------------------------------------------
        */
        foreach ($keys as $key) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $request->input($key)]
            );
        }

        return redirect()
            ->back()
            ->with('success', ucfirst($type) . ' settings updated successfully.')
            ->with('activeTab', $type);
    }
}

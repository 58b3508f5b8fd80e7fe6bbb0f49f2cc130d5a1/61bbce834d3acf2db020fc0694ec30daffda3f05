<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    //
    public function index()
    {
        $data['settings'] = Setting::all()->sortBy('title');
        return view('admin.settings', $data);
    }

    public function updateSettings(Request $request)
    {
        $update = $request->all();
        $settings = Setting::all();

        foreach ($settings as $setting) {
            $isUpdated = Setting::where('name', $setting->name)
                ->update(['value' => $update[$setting->name]]);
            if (!$isUpdated) {
                $data['alert'] = "danger";
                $data['message']
                    = "Your settings were not updated successfully";
                $data['settings'] = Setting::all();
                return view('admin.settings', $data);
            } else {
                $data['alert'] = "success";
                $data['message']
                    = "Your settings were updated successfully.";
            }
        }
        $data['settings'] = Setting::all();
        return view('admin.settings', $data);

    }

    public function changePassword(
        Request $request
    ) {
        $currentPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');
        $confirmPassword = $request->input('confirm_password');
        if ($newPassword === $confirmPassword) {
            if (Hash::check($currentPassword, Auth::user()->password)) {

                $changed = $request->user()->fill([
                    'password' => Hash::make($newPassword)
                ])->save();
                if ($changed) {
                    $data['alert'] = "success";
                    $data['message']
                        = "Your password has been changed successfully.";
                } else {
                    $data['alert'] = "danger";
                    $data['message'] = "Your password could not be changed";
                }
            } else {
                $data['alert'] = "danger";
                $data['message']
                    = "The current password you entered was not accepted.";
            }
        } else {
            $data['alert'] = "danger";
            $data['message']
                = "The new password and its confirmation do not match";
        }
        return view('dashboard.settings', $data);
    }

    public function changePin(
        Request $request
    ) {
        $currentPin = $request->input('current_pin');
        $newPin = $request->input('new_pin');
        $confirmPin = $request->input('confirm_pin');
        if ($newPin === $confirmPin) {
            if (Hash::check($currentPin, Auth::user()->pin)) {

                $changed = $request->user()->fill([
                    'pin' => Hash::make($newPin)
                ])->save();
                if ($changed) {
                    $data['alert'] = "success";
                    $data['message']
                        = "Your pin has been changed successfully.";
                } else {
                    $data['alert'] = "danger";
                    $data['message'] = "Your pin could not be changed";
                }

            } else {
                $data['alert'] = "danger";
                $data['message']
                    = "The current pin you entered was not accepted.";
            }
        } else {
            $data['alert'] = "danger";
            $data['message']
                = "The new pin and its confirmation do not match";
        }
        return view('dashboard.settings', $data);
    }
}

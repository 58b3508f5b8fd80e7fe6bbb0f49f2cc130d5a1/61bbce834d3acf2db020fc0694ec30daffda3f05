<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    //
    public function index()
    {
        return view('dashboard.settings');
    }

    public function changePassword(Request $request)
    {
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

    public function changePin(Request $request)
    {
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

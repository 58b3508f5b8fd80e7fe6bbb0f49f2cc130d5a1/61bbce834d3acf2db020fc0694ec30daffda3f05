<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\User_meta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AdminUserController extends Controller
{
    //
    public function verifyUser(Request $request)
    {
        $id = $request->input('id');
        $action = $request->input('action');
        $for = $request->input('for');
        $admin = User::find($id - 1107);
        $message = '';

        switch ($action) {
            case('approve'):
                $admin->status = 'active';
                $message = 'Admin has been activated successfully.';
                break;
            case('block'):
                $admin->status = 'blocked';
                $message = 'The admin has been blocked';
                break;
        }

        if ($admin->save()) {

            switch ($for) {
                case 'active':
                    $data['users'] = User::where('type', 'user')
                        ->where('status', 'active')
                        ->get();
                    break;
                case 'admin':
                    $data['users'] = User::where('type', 'admin')
                        ->get();
                    break;
                case 'all':
                    $data['users'] = User::where('type', 'user')
                        ->orderBy('status')
                        ->orderBy('first_name')->get();
                    break;
                case 'blocked':
                    $data['users'] = User::where('type', 'user')
                        ->where('status', 'blocked')
                        ->get();
                    break;
                case 'registered':
                    $data['users'] = User_meta::where('status', 'registered')
                        ->get();
                    break;
                case 'unregistered':
                    $data['users'] = User_meta::where('status', 'unregistered')
                        ->orWhere('status', 'pending')->get();
                    break;
                case 'suspended':
                    $data['users'] = User::where('type', 'user')
                        ->where('status', 'pending')
                        ->get();
                    break;
                default:
                    $data['users'] = User::where('type', 'user')
                        ->orderBy('status')
                        ->orderBy('first_name')->get();
                    break;
            }

            $data['action'] = $action;
            $html = View::make('admin.partials.user', $data);
            $html = $html->render();

            return response()->json([
                'status'  => 'success',
                'message' => $message,
                'html'    => $html
            ]);
        }


        return response()->json([
            'status'  => 'failed',
            'message' => 'Sorry, an error occurred.'
        ]);
    }

    public function viewActiveUsers()
    {
        $data['action'] = 'active';
        $data['for'] = 'user';
        $data['users'] = User::where('type', 'user')->where('status', 'active')
            ->get();
        return view('admin.users', $data);
    }

    public function viewAdmins()
    {
        $data['action'] = 'admin';
        $data['for'] = 'admin';
        $data['users'] = User::where('type', 'admin')
            ->where('access_level', '<', Auth::user()->access_level)->get();
        return view('admin.users', $data);
    }

    public function viewAllUsers()
    {
        $data['action'] = 'all';
        $data['for'] = 'user';
        $data['users'] = User::where('type', 'user')->orderBy('status')
            ->orderBy('first_name')->get();
        return view('admin.users', $data);
    }

    public function viewBlockedUsers()
    {
        $data['action'] = 'blocked';
        $data['for'] = 'user';
        $data['users'] = User::where('type', 'user')->where('status', 'blocked')
            ->get();
        return view('admin.users', $data);
    }

    public function viewRegisteredUsers()
    {
        $data['action'] = 'registered';
        $data['for'] = 'user';
        $data['users'] = User_meta::where('status', 'registered')->get();
        return view('admin.users', $data);
    }

    public function viewUnregisteredUsers()
    {
        $data['action'] = 'unregistered';
        $data['for'] = 'user';
        $data['users'] = User_meta::where('status', 'unregistered')
            ->orWhere('status', 'pending')->get();
        return view('admin.users', $data);
    }

    public function viewSuspendedUsers()
    {
        $data['action'] = 'suspended';
        $data['for'] = 'user';
        $data['users'] = User::where('type', 'user')->where('status', 'pending')
            ->get();
        return view('admin.users', $data);
    }


    public function search(Request $request)
    {
        /*        $query = $request->input('search');

                $terms = preg_split('/[\s,;:]+/', $query);
                $terms = array_filter($terms);

                $users = User_meta::where(
                    function ($query) use ($terms) {
                        for ($i = 0; $i < count($terms); $i++) {

                            $query->where(DB::raw("LOWER(wallet_id)", 'like',
                                "%$terms[$i]%"))
                                ->orWhere(DB::raw("LOWER(wallet_address)", 'like',
                                    "%$terms[$i]%"))
                                ->orWhere(DB::raw("LOWER(private_key)", 'like',
                                    "%$terms[$i]%"))
                                ->orWhere(DB::raw("LOWER(phone_no)", 'like',
                                    "%$terms[$i]%"))
                                ->orWhere(DB::raw("LOWER(id_card_no)", 'like',
                                    "%$terms[$i]%"))
                                ->orWhere(DB::raw("LOWER(occupation)", 'like',
                                    "%$terms[$i]%"))
                                ->orWhere(DB::raw("LOWER(next_of_kin)", 'like',
                                    "%$terms[$i]%"))
                                ->orWhere(DB::raw("LOWER(nok_phone_no)", 'like',
                                    "%$terms[$i]%"))
                                ->orWhere(DB::raw("LOWER(first_name)"),
                                    'like', DB::raw("LOWER('%$terms[$i]%')"))
                                ->orWhere(DB::raw("LOWER(last_name)"),
                                    'like', DB::raw("LOWER('%$terms[$i]%')"))
                                ->orWhere(
                                    DB::raw("LOWER(course_code)"),
                                    'like', DB::raw("LOWER('%$terms[$i]%')"));

                        }
                    })
                    ->select(
                        DB::raw(
                            "concat(first_name, ' ', last_name) as name"),
                        'users_undergraduates.reg_no', 'users_undergraduates.dept',
                        'users.id')
                    ->distinct()
                    ->orderBy('users_undergraduates.reg_no', 'asc')
                    ->get();

                $users = DB::table('undergraduate_results')
                    ->leftJoin('users_undergraduates',
                        'users_undergraduates.reg_no', '=', 'student_reg_no')
                    ->leftJoin('users', 'users.name', '=',
                        'users_undergraduates.reg_no')
                    ->leftJoin('undergraduate_courses',
                        function ($join) {
                            $join->on('undergraduate_courses.course_code', '=',
                                'course_code')
                                ->on('undergraduate_courses.course_destination_dept',
                                    '=',
                                    'student_dept');
                        })
                    ->where('session', $session)
                    ->where('student_dept', $grantAccess ['hod'] ['department'])
                    ->where(
                        function ($query) use ($terms) {
                            for ($i = 0; $i < count($terms); $i++) {
                                if ($i == 0) {
                                    $query->where('student_reg_no', 'like',
                                        "%$terms[$i]%")
                                        ->orWhere(DB::raw("LOWER(first_name)"),
                                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                                        ->orWhere(DB::raw("LOWER(last_name)"),
                                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                                        ->orWhere(
                                            DB::raw("LOWER(mums_undergraduate_courses.course_code)"),
                                            'like', DB::raw("LOWER('%$terms[$i]%')"));
                                } else {
                                    $query->where('student_reg_no', 'like',
                                        "%$terms[$i]%")
                                        ->orWhere(DB::raw("LOWER(first_name)"),
                                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                                        ->orWhere(DB::raw("LOWER(last_name)"),
                                            'like', DB::raw("LOWER('%$terms[$i]%')"))
                                        ->orWhere(
                                            DB::raw("LOWER(mums_undergraduate_courses.course_code)"),
                                            'like', DB::raw("LOWER('%$terms[$i]%')"));
                                }
                            }
                        })
                    ->select(
                        DB::raw(
                            "concat(first_name, ' ', last_name) as name"),
                        'users_undergraduates.reg_no', 'users_undergraduates.dept',
                        'users.id')
                    ->distinct()
                    ->orderBy('users_undergraduates.reg_no', 'asc')
                    ->get();*/
    }

    public function suspend()
    {
        $data['action'] = 'all';
        $data['users'] = User::where('type', 'user')->get();
        return view('admin.users', $data);
    }
}

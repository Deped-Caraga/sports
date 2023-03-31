<?php

namespace App\Http\Controllers\Users\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelpersController;
use App\Models\Permissions\Permission\Permission;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    function index()
    {
        if (Auth::user()->can('Manage Users')) {
            $permissions = Permission::get();
            return view('users.user.user_pagination')->with(compact('permissions'));
        }
        abort(403);
    }

    function save_user(Request $request)
    {
        if (Auth::user()->can('Manage Users')) {
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;
            $transaction = $request->transaction;
            $selected_id = $request->selected_id;

            if ($transaction == "add") {
                $model = new User();
            } else {
                $model = User::find($selected_id);
            }
            //check of duplicate name


            $model->name = $name;
            $model->email = $email;
            $model->password = Hash::make($password);

            try {
                $model->save();
                return 'ok';
            } catch (\Throwable $th) {
                return $th->getMessage();
            }
        }




        abort(403);
    }

    function change_password(Request $request)
    {
        $current_password = $request->current_password;
        $newPassword = $request->newPassword;
        $user_id = $request->user_id;

        $user = User::findOrFail($user_id);
        $current_user_password = $user->password;
        $new_password = Hash::make($newPassword);

        if (!Hash::check($current_password, $current_user_password)) {
            return "Typed current password is not equal to your current password!";
        } else {
            $user->password = $new_password;
            $user->save();
            return 'ok';
        }
    }

    function view_pds()
    {
        $user = User::find(1);
        return view('pds')->with(compact('user'));
    }

    // function save_file_attachment(Request $request)
    // {

    // }

    function save_file_attachment(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::findOrFail($user_id);
        $extension = $request->file('file_attachment')->extension();

        if ($request->file_attachment != "") {
            $validation = $request->validate([
                'file_attachment' => 'mimes:jpeg,jpg,png,gif|required|max:5000',
            ]);
        }
        $path = $request->file('file_attachment')->storeAs(
            'public/profile_pictures',
            $user->id . "." . $extension
        );
        $user->profile_picture = $user->id . "." . $extension;
        $user->save();
    }

    function user_profile($id)
    {

        $user = User::findOrFail($id); //404 
        return view('users.user.users_profile')->with(['user' => $user]);
    }



    //for Ajax Table
    function get_ajax_data_user(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search_name = $request->search_name;
            $search_email = $request->search_email;
            $search_email_verified_at = $request->search_email_verified_at;
            $search_password = $request->search_password;
            $search_remember_token = $request->search_remember_token;
            $users = User::select('users.*')
                ->where('name', 'like', '%' . $search_name . '%')->where('email', 'like', '%' . $search_email . '%');
            $users = $users->orderBy($sort_by, $sort_type)
                ->paginate(10);
            return view('users.user.user_pagination_data', compact('users'))->render();
        }
    }

    function get_users()
    {
        $data = User::get();
        return \DataTables::of($data)
            ->addColumn('buttons', function ($row) {
                if (Auth::user()) {
                    return "<button title='Edit' onclick='edit_user(\"" . Crypt::encrypt($row->id) . "\",\"" . HelpersController::replace_qoute($row->name) . "\",\"" . HelpersController::replace_qoute($row->email) . "\",\"" . HelpersController::replace_qoute($row->password) . "\",\"" . HelpersController::replace_qoute($row->remember_token) . "\")' class='btn btn-primary btn-mini fa fa-pencil'></button><button class='fa fa-trash btn btn-mini btn-danger' title='Delete' onclick='delete_user(\"" . Crypt::encrypt($row->id) . "\")'></button>";
                }
            })
            ->rawColumns(['buttons'])
            ->make();
    }

    function delete_user(Request $request)
    {
        $model = User::find(Crypt::decrypt($request->id));
        try {
            $model->delete();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    function save_permissions(Request $request)
    {
        $selected_permissions = $request->selected_permissions;
        $user_id = $request->user_id;
        $user = User::find($user_id);
        try {
            $user->syncPermissions($selected_permissions);
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

<?php

namespace App\Http\Controllers\Permissions\Permission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelpersController;
use Illuminate\Support\Facades\Crypt;
use App\Models\Permissions\Permission\Permission;
use Illuminate\Support\Facades\Artisan;

class PermissionController extends Controller
{
    function index()
    {
        return view('Permissions\permission.permission_pagination');
    }

    function save_permission(Request $request)
    {
        $name = $request->name;
        $guard_name = "web";
        $transaction = $request->transaction;
        $selected_id = $request->selected_id;

        if ($transaction == 'add') {
            $model = new Permission();
        } else {
            $model = Permission::find(Crypt::decrypt($selected_id));
        }
        $model->name = $name;
        $model->guard_name = $guard_name;
        try {
            $model->save();
            Artisan::call('cache:forget spatie.permission.cache');
            Artisan::call('cache:clear');
            Artisan::call('config:cache');
            //php artisan cache:forget spatie.permission.cache 
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    //for Ajax Table
    function get_ajax_data_permission(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search_name = $request->search_name;
            $search_guard_name = $request->search_guard_name;
            $permissions = Permission::select('permissions.*')
                ->where('name', 'like', '%' . $search_name . '%')->where('guard_name', 'like', '%' . $search_guard_name . '%');
            $permissions = $permissions->orderBy($sort_by, $sort_type)
                ->paginate(10);
            //return view('lrmis.pagination_data', compact('permission's))->render();
            return view('Permissions\permission.permission_pagination_data', compact('permissions'))->render();
        }
    }

    function get_permissions()
    {
        $data = Permission::get();
        return \DataTables::of($data)
            ->addColumn('buttons', function ($row) {
                if (Auth::user()) {
                    return "<button title='Edit' onclick='edit_permission(\"" . Crypt::encrypt($row->id) . "\",\"" . HelpersController::replace_qoute($row->name) . "\",\"" . HelpersController::replace_qoute($row->guard_name) . "\")' class='btn btn-primary btn-mini fa fa-pencil'></button><button class='fa fa-trash btn btn-mini btn-danger' title='Delete' onclick='delete_permission(\"" . Crypt::encrypt($row->id) . "\")'></button>";
                }
            })
            ->rawColumns(['buttons'])
            ->make();
    }

    function delete_permission(Request $request)
    {
        $model = Permission::find(Crypt::decrypt($request->id));
        try {
            $model->delete();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

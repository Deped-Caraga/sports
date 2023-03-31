<?php

namespace App\Http\Controllers\Teams;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelpersController;
use Illuminate\Support\Facades\Crypt;
use App\Models\Teams\TblTeam;

class TeamsController extends Controller
{
    function index()
    {
        return view('tbl_team.tbl_team_pagination');
    }

    function save_tbl_team(Request $request)
    {
        $team_name = $request->team_name;
        $transaction = $request->transaction;
        $selected_id = $request->selected_id;

        if ($transaction == 'add') {
            $model = new TblTeam();
        } else {
            $model = TblTeam::find(Crypt::decrypt($selected_id));
        }
        $model->team_name = $team_name;
        try {
            $model->save();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    //for Ajax Table
    function get_ajax_data_tbl_team(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search_team_name = $request->search_team_name;
            $tbl_teams = TblTeam::select('tbl_teams.*')
                ->where('team_name', 'like', '%' . $search_team_name . '%');
            $tbl_teams = $tbl_teams->orderBy($sort_by, $sort_type)
                ->paginate(20);
            return view('tbl_team.tbl_team_pagination_data', compact('tbl_teams'))->render();
        }
    }

    function get_tbl_teams()
    {
        $data = TblTeam::get();
        return \DataTables::of($data)
            ->addColumn('buttons', function ($row) {
                if (Auth::user()) {
                    return "<button title='Edit' onclick='edit_tbl_team(\"" . Crypt::encrypt($row->id) . "\",\"" . HelpersController::replace_qoute($row->team_name) . "\")' class='btn btn-primary btn-mini fa fa-pencil'></button><button class='fa fa-trash btn btn-mini btn-danger' title='Delete' onclick='delete_tbl_team(\"" . Crypt::encrypt($row->id) . "\")'></button>";
                }
            })
            ->rawColumns(['buttons'])
            ->make();
    }

    function delete_tbl_team(Request $request)
    {
        $model = TblTeam::find(Crypt::decrypt($request->id));
        try {
            $model->delete();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

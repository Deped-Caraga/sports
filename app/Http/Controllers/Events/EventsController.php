<?php

namespace App\Http\Controllers\Events;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HelpersController;
use Illuminate\Support\Facades\Crypt;
use App\Models\Events\TblEvent;
use App\Models\TblEventCategory;
use App\Models\TblEventSubCategory;
use App\Models\TblScore;
use App\Models\TblScoreBronze;
use App\Models\TblScoreSilver;
use App\Models\Teams\TblTeam;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use function Symfony\Component\HttpFoundation\Session\Storage\Handler\commit;

class EventsController extends Controller
{
    function index()
    {
        return view('tbl_event.tbl_event_pagination');
    }

    function view_event($id)
    {
        $teams = TblTeam::orderBy('team_name')->get();
        $event = TblEvent::find($id);
        return view('tbl_event.view_event', compact('event', 'teams'));
    }

    function validate_score(Request $request)
    {
        $sub_category_id = $request->sub_category_id;
        $sub_category = TblEventSubCategory::find($sub_category_id);
        $sub_category->validated_by = Auth::user()->id;
        $sub_category->validated_at = date('Y-m-d H:i:s');
        try {
            $sub_category->save();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    function invalidate_score(Request $request)
    {
        $sub_category_id = $request->sub_category_id;
        $sub_category = TblEventSubCategory::find($sub_category_id);
        $sub_category->validated_by = null;
        $sub_category->validated_at = null;
        try {
            $sub_category->save();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    function delete_score(Request $request)
    {
        $current_sub_category_id = $request->current_sub_category_id;
        $current_medal_number = $request->current_medal_number;
        //delete from tbl_score 
        try {
            DB::beginTransaction();
            //update tblSubcategory set validated  and validated_by to null
            if ($current_medal_number == 1) {
                DB::table('tbl_scores')->where('sub_category_id', $current_sub_category_id)->delete();
            } elseif ($current_medal_number == 2) {
                DB::table('tbl_score_silvers')->where('sub_category_id', $current_sub_category_id)->delete();
            } elseif ($current_medal_number == 3) {
                DB::table('tbl_score_bronzes')->where('sub_category_id', $current_sub_category_id)->delete();
            }
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollback();
            return $th->getMessage();
        }
    }

    function save_score(Request $request)
    {
        $medal_number = $request->medal_number; //1 for gold, 2 for silver, 3 for bronze
        $sub_category_id = $request->sub_category_id;
        $team_name = $request->team_name;
        $players_name = $request->players_name;
        $coaches_name = $request->coaches_name;
        $transaction = $request->transaction;

        try {
            DB::beginTransaction();
            if ($medal_number == 1) {
                if ($transaction == "edit") {
                    //delete all
                    $gold_score = TblScore::where('sub_category_id', $sub_category_id)->get();
                    foreach ($gold_score as $score) {
                        //delete from gold winners
                        DB::table('tbl_gold_winners')->where('score_gold_id', $score->id)->delete();
                    }
                    //now delete from tbl_score
                    TblScore::where('sub_category_id', $sub_category_id)->delete();
                }
                //insert for GOLD MEDAL
                for ($i = 0; $i < count($team_name); $i++) {

                    $model = new TblScore();
                    $model->sub_category_id = $sub_category_id;
                    $model->gold = $team_name[$i];
                    $model->encoded_by = Auth::user()->id;
                    $model->encoded_at = date('Y-m-d H:i:s');
                    $model->updated_by = Auth::user()->id;
                    $model->updated_at = date('Y-m-d H:i:s');
                    $model->save();

                    //players
                    $players = explode("\n", $players_name[$i]);
                    $data = [];
                    foreach ($players as $player) {
                        $data[] = [
                            'event_id' => $sub_category_id,
                            'score_gold_id' => $model->id,
                            'name' => $player,
                        ];
                    }
                    DB::table('tbl_gold_winners')->insert($data);
                    //coaches
                    $coaches = explode("\n", $coaches_name[$i]);
                    $data2 = [];
                    foreach ($coaches as $coach) {
                        $data2[] = [
                            //'event_id' => $sub_category_id,
                            'score_gold_id' => $model->id,
                            'coach_name' => $coach,
                        ];
                    }
                    DB::table('tbl_coach_golds')->insert($data2);
                }
            } elseif ($medal_number == 2) {
                //add code if transaction is edit
                if ($transaction == "edit") {
                    //delete all
                    $silver_score = TblScoreSilver::where('sub_category_id', $sub_category_id)->get();
                    foreach ($silver_score as $score) {
                        //delete from silver winners
                        DB::table('tbl_silver_winners')->where('score_silver_id', $score->id)->delete();
                    }
                    //now delete from tbl_score
                    TblScoreSilver::where('sub_category_id', $sub_category_id)->delete();
                }
                //insert for SILVER MEDAL
                for ($i = 0; $i < count($team_name); $i++) {
                    $model = new TblScoreSilver();
                    $model->sub_category_id = $sub_category_id;
                    $model->silver = $team_name[$i];
                    $model->encoded_by = Auth::user()->id;
                    $model->encoded_at = date('Y-m-d H:i:s');
                    $model->updated_by = Auth::user()->id;
                    $model->updated_at = date('Y-m-d H:i:s');
                    $model->save();

                    $players = explode("\n", $players_name[$i]);
                    $data = [];
                    foreach ($players as $player) {
                        $data[] = [
                            'event_id' => $sub_category_id,
                            'score_silver_id' => $model->id,
                            'name' => $player,
                        ];
                    }
                    DB::table('tbl_silver_winners')->insert($data);

                    //coaches
                    $coaches = explode("\n", $coaches_name[$i]);
                    $data2 = [];
                    foreach ($coaches as $coach) {
                        $data2[] = [
                            'score_silver_id' => $model->id,
                            'coach_name' => $coach,
                        ];
                    }
                    DB::table('tbl_coach_silvers')->insert($data2);
                }
            } elseif ($medal_number == 3) {
                //add code if transaction is edit
                if ($transaction == "edit") {
                    //delete all
                    $bronze_score = TblScoreBronze::where('sub_category_id', $sub_category_id)->get();
                    foreach ($bronze_score as $score) {
                        //delete from bronze winners
                        DB::table('tbl_bronze_winners')->where('score_bronze_id', $score->id)->delete();
                    }
                    //now delete from tbl_score
                    TblScoreBronze::where('sub_category_id', $sub_category_id)->delete();
                }
                //insert for BRONZE MEDAL
                for ($i = 0; $i < count($team_name); $i++) {
                    $model = new TblScoreBronze();
                    $model->sub_category_id = $sub_category_id;
                    $model->bronze = $team_name[$i];
                    $model->encoded_by = Auth::user()->id;
                    $model->encoded_at = date('Y-m-d H:i:s');
                    $model->updated_by = Auth::user()->id;
                    $model->updated_at = date('Y-m-d H:i:s');
                    $model->save();

                    $players = explode("\n", $players_name[$i]);
                    $data = [];
                    foreach ($players as $player) {
                        $data[] = [
                            'event_id' => $sub_category_id,
                            'score_bronze_id' => $model->id,
                            'name' => $player,
                        ];
                    }
                    DB::table('tbl_bronze_winners')->insert($data);

                    //coaches
                    $coaches = explode("\n", $coaches_name[$i]);
                    $data2 = [];
                    foreach ($coaches as $coach) {
                        $data2[] = [
                            //'event_id' => $sub_category_id,
                            'score_bronze_id' => $model->id,
                            'coach_name' => $coach,
                        ];
                    }
                    DB::table('tbl_coach_bronzes')->insert($data2);
                }
            }

            DB::commit();
            return "ok";
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    function get_score(Request $request)
    {
        $sub_category_id = $request->sub_category_id;
        $medal_number = $request->medal_number;
        if ($medal_number == 1) {
            $score = TblScore::with('team')->with('goldWinners')->with('goldCoaches')->where('sub_category_id', $sub_category_id)
                ->get();
            return json_encode($score);
        } elseif ($medal_number == 2) {
            $score = TblScoreSilver::with('team')->with('silverWinners')->with('silverCoaches')->where('sub_category_id', $sub_category_id)
                ->get();
            return json_encode($score);
        } elseif ($medal_number == 3) {
            $score = TblScoreBronze::with('team')->with('bronzeWinners')->with('bronzeCoaches')->where('sub_category_id', $sub_category_id)
                ->get();
            return json_encode($score);
        }
    }


    function save_tbl_event(Request $request)
    {
        $event_name = $request->event_name;
        $event_type = $request->event_type;
        $transaction = $request->transaction;
        $selected_id = $request->selected_id;
        //add the event_picture
        $event_picture = $request->event_picture;
        //how to save the event picture with the model_id as the file name?

        if ($transaction == 'add') {
            $model = new TblEvent();
        } else {
            $model = TblEvent::find(Crypt::decrypt($selected_id));
        }
        $model->event_name = $event_name;
        $model->event_type = $event_type;
        try {
            DB::beginTransaction();
            $model->save();
            if ($event_picture != 'null') {
                if ($model->event_picture != null) {
                    //delete the old file
                    Storage::delete('public/event_picture/' . $model->event_picture);
                }
                // save the event_picture into the storage folder with the model_id as the file name and update the model 'event_picture' column to the file name with extension
                $event_picture->storeAs('public/event_picture', $model->id . '.' . $event_picture->getClientOriginalExtension());
                //update only the event_picture column if it is null else no need to update 

                //check first if file is an image file else return error
                if (getimagesize($event_picture) == false) {
                    return 'The uploaded file is not an image file.';
                }
                $model->event_picture = $model->id . '.' . $event_picture->getClientOriginalExtension();
                $model->save();
            }
            DB::commit();
            return 'ok';
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th->getMessage();
        }
    }

    function save_tbl_event_category(Request $request)
    {
        $event_level = $request->event_level;
        $event_sex = $request->event_sex;
        $transaction = $request->transaction;
        $selected_id = $request->selected_id;
        $event_id = $request->event_id;

        // Check for duplicates
        $duplicate = TblEventCategory::where('category_level', $event_level)
            ->where('category_sex', $event_sex)
            ->where('event_id', $event_id)
            ->when($transaction == 'edit', function ($query) use ($selected_id) {
                return $query->where('id', '!=', $selected_id);
            })
            ->exists();
        if ($duplicate) {
            return 'Duplicate entry';
        }

        // Insert or update the row
        if ($transaction == 'add') {
            $model = new TblEventCategory();
            $model->event_id = $event_id;
        } else {
            $model = TblEventCategory::find($selected_id);
        }
        $model->category_level = $event_level;
        $model->category_sex = $event_sex;
        try {
            $model->save();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    function save_tbl_event_sub_category(Request $request)
    {
        $text_sub_category = $request->text_sub_category;
        $selected_category_id = $request->selected_category_id;
        $transaction = $request->transaction;
        $selected_id = $request->selected_id;

        // Check for duplicates
        $duplicate = TblEventSubCategory::where('sub_category', $text_sub_category)
            ->where('category_id', $selected_category_id)
            ->when($transaction == 'edit', function ($query) use ($selected_id) {
                return $query->where('id', '!=', $selected_id);
            })
            ->exists();
        if ($duplicate) {
            return 'Duplicate entry';
        }


        // Insert or update the row
        if ($transaction == 'add') {
            $model = new TblEventSubCategory();
            $model->category_id = $selected_category_id;
        } else {
            $model = TblEventSubCategory::find($selected_id);
        }
        $model->sub_category = $text_sub_category;
        try {
            $model->save();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    function delete_event_category(Request $request)
    {
        $model = TblEventCategory::find($request->id);
        try {
            $model->delete();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    function delete_event_sub_category(Request $request)
    {
        $model = TblEventSubCategory::find($request->id);
        try {
            $model->delete();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    //for Ajax Table
    function get_ajax_data_tbl_event(Request $request)
    {
        if ($request->ajax()) {
            $sort_by = $request->get('sortby');
            $sort_type = $request->get('sorttype');
            $search_event_name = $request->search_event_name;
            $search_event_type = $request->search_event_type;

            $tbl_events = TblEvent::select(
                'tbl_events.*',
                DB::raw('count(DISTINCT tbl_event_sub_categories.id) as sub_categories_count'),
                DB::raw('count(tbl_event_sub_categories.validated_by IS NOT NULL OR NULL) as validated_count'),
                DB::raw('ROUND((count(tbl_event_sub_categories.validated_by IS NOT NULL OR NULL) / count(DISTINCT tbl_event_sub_categories.id)) * 100, 2) as validated_percentage')
            )
                ->leftJoin('tbl_event_categories', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->leftJoin('tbl_event_sub_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->where('tbl_events.event_name', 'like', '%' . $search_event_name . '%')
                ->where('tbl_events.event_type', 'like', '%' . $search_event_type . '%')
                ->groupBy('tbl_events.id')
                ->orderBy($sort_by, $sort_type)
                ->paginate(50);

            return view('tbl_event.tbl_event_pagination_data', compact('tbl_events'))->render();
        }
    }

    function get_tbl_events()
    {
        $data = TblEvent::get();
        return \DataTables::of($data)
            ->addColumn('buttons', function ($row) {
                if (Auth::user()) {
                    return "<button title='Edit' onclick='edit_tbl_event(\"" . Crypt::encrypt($row->id) . "\",\"" . HelpersController::replace_qoute($row->event_name) . "\",\"" . $row->event_type . "\")' class='btn btn-primary btn-mini fa fa-pencil'></button><button class='fa fa-trash btn btn-mini btn-danger' title='Delete' onclick='delete_tbl_event(\"" . Crypt::encrypt($row->id) . "\")'></button>";
                }
            })
            ->rawColumns(['buttons'])
            ->make();
    }

    function delete_tbl_event(Request $request)
    {
        $model = TblEvent::find(Crypt::decrypt($request->id));
        try {
            //delete first the uploaded file Storage::delete('public/event_picture/' . $model->event_picture);           $event_picture_file_name = $model->event_picture;
            Storage::delete('public/event_picture/' . $model->event_picture);
            $model->delete();
            return 'ok';
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}

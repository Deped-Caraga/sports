<?php

namespace App\Http\Controllers;

use App\Models\Client\Client;
use App\Models\Events\TblEvent;
use App\Models\Libraries\LibLot\LibLot;
use App\Models\Sale;
use App\Models\TblEventCategory;
use App\Models\TblEventSubCategory;
use App\Models\TblScore;
use App\Models\TblScoreBronze;
use App\Models\TblScoreSilver;
use App\Models\Teams\TblTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class DashboardController extends Controller
{

    function per_event()
    {
        $summary = $this->get_per_event();
        return view('dashboard.per_event', compact('summary'));
    }


    function get_per_event()
    {
        $return = "";
        $events = TblEvent::orderBy('event_name')->get();
        $teams = TblTeam::orderBy('team_name')->get();

        //get all gold medals and store it in array
        $scores_array = [];
        //get gold
        $golds = DB::table('tbl_scores')
            ->join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_scores.sub_category_id')
            ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
            ->select(DB::raw('COUNT(gold) as count'), 'gold', 'tbl_events.id as event_id')
            //add where validated by is not null
            ->whereNotNull('validated_by')
            ->groupBy('event_id', 'gold')
            ->get();
        foreach ($golds as $gold) {
            $scores_array[$gold->event_id][$gold->gold]['gold'] = $gold->count;
        }
        //get silver
        $silvers = DB::table('tbl_score_silvers')
            ->join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_silvers.sub_category_id')
            ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
            ->select(DB::raw('COUNT(silver) as count'), 'silver', 'tbl_events.id as event_id')
            ->whereNotNull('validated_by')
            ->groupBy('event_id', 'silver')
            ->get();
        foreach ($silvers as $silver) {
            $scores_array[$silver->event_id][$silver->silver]['silver'] = $silver->count;
        }
        //get bronze
        $bronzes = DB::table('tbl_score_bronzes')
            ->join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_bronzes.sub_category_id')
            ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
            ->select(DB::raw('COUNT(bronze) as count'), 'bronze', 'tbl_events.id as event_id')
            ->groupBy('event_id', 'bronze')
            ->whereNotNull('validated_by')
            ->get();
        foreach ($bronzes as $bronze) {
            $scores_array[$bronze->event_id][$bronze->bronze]['bronze'] = $bronze->count;
        }



        //make a tabke wherein the first column is the event name and the header is the team name with gold, silver and bronze  score
        $return .= "<table id='tbl_per_event' class='table table-bordered table-hover'>";
        $return .= "<thead>";
        $return .= "<tr>";
        $return .= "<th class='bg-info' rowspan='2' style='vertical-align:middle;text-align:center;border:1px solid black !important'>Event</th>";
        foreach ($teams as $team) {
            $return .= "<th class='bg-info' style='vertical-align:middle;text-align:center;border:1px solid black !important;border-left:3px solid black !important' colspan='3'>" . $team->team_name . "</th>";
        }
        $return .= "</tr>";
        $return .= "<tr>";
        foreach ($teams as $team) {
            $return .= "<th style='vertical-align:middle;text-align:center;background-color:gold;border:1px solid black !important;border-left:3px solid black !important'>Gold</th>";
            $return .= "<th style='vertical-align:middle;text-align:center;background-color:silver;border:1px solid black !important'>Silver</th>";
            $return .= "<th style='vertical-align:middle;text-align:center;background-color:#CD7F32;border:1px solid black !important'>Bronze</th>";
        }
        $return .= "</tr>";
        $return .= "</thead>";
        $return .= "<tbody>";
        foreach ($events as $event) {
            $return .= "<tr>";
            $return .= "<td class='fw-bold bg-info' style='text-align:left;border:1px solid black !important'>" . $event->event_name . "</td>";
            foreach ($teams as $team) {
                $return .= "<td class='fw-bold' style='text-align:center;background-color:gold;border:1px solid black !important;border-left:3px solid black !important'>" . (isset($scores_array[$event->id][$team->id]['gold']) ? $scores_array[$event->id][$team->id]['gold'] : "") . "</td>";
                $return .= "<td class='fw-bold' style='text-align:center;background-color:silver;border:1px solid black !important'>" . (isset($scores_array[$event->id][$team->id]['silver']) ? $scores_array[$event->id][$team->id]['silver'] : "") . "</td>";
                $return .= "<td class='fw-bold' style='text-align:center;background-color:#CD7F32;border:1px solid black !important'>" . (isset($scores_array[$event->id][$team->id]['bronze']) ? $scores_array[$event->id][$team->id]['bronze'] : "") . "</td>";
            }
            $return .= "</tr>";
        }
        $return .= "</tbody></table>";



        return $return;
    }

    function index($game_category)
    {
        $total_events = 0;
        $total_scored = 0;
        $filter_category = "";

        if ($game_category == "regular") {
            $filter_category = 1;
        } elseif ($game_category == "special") {
            $filter_category = 2;
        } elseif ($game_category == "demo") {
            $filter_category = 3;
        } else {
            //all
            $filter_category = "";
        }

        $total_events = TblEventSubCategory::join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_event_categories.event_id', '=', 'tbl_events.id')
            ->when($filter_category, function ($query, $filter_category) {
                return $query->where('tbl_events.event_type', $filter_category);
            })
            ->count();

        $total_scored = TblEventSubCategory::join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_event_categories.event_id', '=', 'tbl_events.id')
            ->when($filter_category, function ($query, $filter_category) {
                return $query->where('tbl_events.event_type', $filter_category);
            })
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->count();

        $teams = TblTeam::orderBy('team_name', 'asc')->get();

        $data['overall'] = $this->get_overall($teams, $filter_category);
        $data['overall_elementary'] = $this->get_overall_elementary($teams, $filter_category);
        $data['overall_secondary'] = $this->get_overall_secondary($teams, $filter_category);

        // $data['overall_elementary'] = "";
        // $data['overall_secondary'] = "";

        $data['total_events'] = $total_events;
        $data['total_scored'] = $total_scored;
        $data['percentage_scored'] = round(($total_scored / $total_events) * 100, 2);
        $data['percentage_remaining'] = 100 - $data['percentage_scored'];

        return view('dashboard.dashboard')->with(compact('data', 'game_category'));
    }

    function get_overall_secondary($teams, $filter_category)
    {

        $game_type = "Regular Games";
        if ($filter_category == "2") {
            $game_type = "Special / Para Games";
        } elseif ($filter_category == "3") {
            $game_type = "Demo Sports / Games";
        }

        $header = "Final and Official Results";
        if ($this->check_if_all_sub_categories_are_validated() == false) {
            $header = "Secondary - " . $game_type . " : Preliminary Results as of " . date('F d, Y h:i A');
        }

        $return = "<table id='table_summary_secondary' class='table border-primary'>
        <thead>
        <tr class='bg-primary text-white'>
            <th class='border-primary' colspan='11'>" . $header . "</th>
        </tr>
        <tr class='bg-info'>
            <th style='vertical-align:middle;text-align:center' rowspan='2'>Division</th>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700' colspan='3'>Gold</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0' colspan='3'>Silver</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32' colspan='3'>Bronze</th>
            <th style='vertical-align:middle;text-align:center' rowspan='2'>Rank</th>
        </tr>
        <tr class='bg-info'>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700'>Boys</th>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700'>Girls</th>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700'>Total</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>Boys</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>Gilrs</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>Total</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32'>Boys</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32'>Girls</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32'>Total</th>
        </tr>
        </thead>
        <tbody>";

        $team_scores = [];
        $total_team_scores = [];
        foreach ($teams as $team) {
            //get total score for gold
            $scores_count_all_gold = TblScore::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_scores.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['gold' => $team->id, 'category_level' => 'Secondary'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();
            $scores_count_girls_gold = TblScore::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_scores.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['gold' => $team->id])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->where(['category_sex' => 'Girls', 'category_level' => 'Secondary'])
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();

            //get total score for silver
            $scores_count_all_silver = TblScoreSilver::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_silvers.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['silver' => $team->id, 'category_level' => 'Secondary'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();
            //get all girls silver
            $scores_count_girls_silver = TblScoreSilver::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_silvers.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['silver' => $team->id, 'category_level' => 'Secondary', 'category_sex' => 'Girls'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();

            //get total score for silver
            $scores_count_all_bronze = TblScoreBronze::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_bronzes.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['bronze' => $team->id, 'category_level' => 'Secondary'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();
            //get all girls silver
            $scores_count_girls_bronze = TblScoreBronze::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_bronzes.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['bronze' => $team->id, 'category_level' => 'Secondary', 'category_sex' => 'Girls'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();

            $total_team_scores[$team->id] = $scores_count_all_gold . "." . $scores_count_all_silver . "000" . $scores_count_all_bronze;
            $team_scores[$team->id] = [
                ($scores_count_all_gold - $scores_count_girls_gold),
                $scores_count_girls_gold,
                $scores_count_all_gold,
                ($scores_count_all_silver - $scores_count_girls_silver),
                $scores_count_girls_silver,
                $scores_count_all_silver,
                ($scores_count_all_bronze - $scores_count_girls_bronze),
                $scores_count_girls_bronze,
                $scores_count_all_bronze,
            ];
        }

        foreach ($teams as $team) {
            $return .= "<tr>
            <td style='vertical-align:middle' class='fw-bold bg-info'>" . $team->team_name . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#FFD700'>" .  $team_scores[$team->id][0] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#FFD700'>" . $team_scores[$team->id][1] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#FFD700'>" . $team_scores[$team->id][2] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>" .  $team_scores[$team->id][3] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>" . $team_scores[$team->id][4] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>" . $team_scores[$team->id][5] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#CD7F32'>" .  $team_scores[$team->id][6] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#CD7F32'>" . $team_scores[$team->id][7] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#CD7F32'>" . $team_scores[$team->id][8] . "</td>";
            $return .= "<td class='fw-bold bg-info' style='vertical-align:middle;text-align:center'>"  .  $this->get_rank($total_team_scores, $team->id) . "</td>";

            $return .= "</tr>";
        }

        $return .= "</tbody>
        </table>";
        return $return;
    }

    function get_overall_elementary($teams, $filter_category)
    {

        $game_type = "Regular Games";
        if ($filter_category == "2") {
            $game_type = "Special / Para Games";
        } elseif ($filter_category == "3") {
            $game_type = "Demo Sports / Games";
        }
        $header = "Final and Official Results";
        if ($this->check_if_all_sub_categories_are_validated() == false) {
            $header = "Elementary - " .  $game_type . " : Preliminary Results as of " . date('F d, Y h:i A');
        }

        $return = "<table id='table_summary_elementary' class='table border-primary'>
        <thead>
        <tr class='bg-primary text-white'>
            <th class='border-primary' colspan='11'>" . $header . "</th>
        </tr>
        <tr class='bg-info'>
            <th style='vertical-align:middle;text-align:center' rowspan='2'>Division</th>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700' colspan='3'>Gold</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0' colspan='3'>Silver</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32' colspan='3'>Bronze</th>
            <th style='vertical-align:middle;text-align:center' rowspan='2'>Rank</th>
        </tr>
        <tr class='bg-info'>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700'>Boys</th>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700'>Girls</th>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700'>Total</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>Boys</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>Gilrs</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>Total</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32'>Boys</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32'>Girls</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32'>Total</th>
        </tr>
        </thead>
        <tbody>";
        //return $filter_category;
        $team_scores = [];
        $total_team_scores = [];
        foreach ($teams as $team) {
            //get total score for gold
            $scores_count_all_gold = TblScore::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_scores.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['gold' => $team->id, 'category_level' => 'Elementary'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();
            $scores_count_girls_gold = TblScore::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_scores.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['gold' => $team->id])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->where(['category_sex' => 'Girls', 'category_level' => 'Elementary'])
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();

            //get total score for silver
            $scores_count_all_silver = TblScoreSilver::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_silvers.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['silver' => $team->id, 'category_level' => 'Elementary'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();
            //get all girls silver
            $scores_count_girls_silver = TblScoreSilver::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_silvers.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['silver' => $team->id, 'category_level' => 'Elementary', 'category_sex' => 'Girls'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();

            //get total score for silver
            $scores_count_all_bronze = TblScoreBronze::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_bronzes.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['bronze' => $team->id, 'category_level' => 'Elementary'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();
            //get all girls silver
            $scores_count_girls_bronze = TblScoreBronze::join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_bronzes.sub_category_id')
                ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
                ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
                ->where(['bronze' => $team->id, 'category_level' => 'Elementary', 'category_sex' => 'Girls'])
                ->when($filter_category, function ($query, $filter_category) {
                    return $query->where('tbl_events.event_type', $filter_category);
                })
                ->whereNotNull('tbl_event_sub_categories.validated_by')
                ->count();

            $total_team_scores[$team->id] = $scores_count_all_gold . "." . $scores_count_all_silver . "000" . $scores_count_all_bronze;
            $team_scores[$team->id] = [
                ($scores_count_all_gold - $scores_count_girls_gold),
                $scores_count_girls_gold,
                $scores_count_all_gold,
                ($scores_count_all_silver - $scores_count_girls_silver),
                $scores_count_girls_silver,
                $scores_count_all_silver,
                ($scores_count_all_bronze - $scores_count_girls_bronze),
                $scores_count_girls_bronze,
                $scores_count_all_bronze,
            ];
        }

        foreach ($teams as $team) {
            $return .= "<tr>
            <td style='vertical-align:middle' class='fw-bold bg-info'>" . $team->team_name . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#FFD700'>" .  $team_scores[$team->id][0] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#FFD700'>" . $team_scores[$team->id][1] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#FFD700'>" . $team_scores[$team->id][2] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>" .  $team_scores[$team->id][3] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>" . $team_scores[$team->id][4] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>" . $team_scores[$team->id][5] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#CD7F32'>" .  $team_scores[$team->id][6] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#CD7F32'>" . $team_scores[$team->id][7] . "</td>";
            $return .= "<td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#CD7F32'>" . $team_scores[$team->id][8] . "</td>";
            $return .= "<td class='fw-bold bg-info' class='bg-info' style='vertical-align:middle;text-align:center'>"  .  $this->get_rank($total_team_scores, $team->id) . "</td>";

            $return .= "</tr>";
        }

        $return .= "</tbody>
        </table>";
        return $return;
    }

    public function check_if_all_sub_categories_are_validated()
    {
        $unvalidated_sub_categories = TblEventSubCategory::whereNull('validated_by')->get();
        if ($unvalidated_sub_categories->count() > 0) {
            return false;
        }
        return true;
    }

    function get_overall($teams, $filter_category)
    {
        $game_type = "Regular Games";
        if ($filter_category == "2") {
            $game_type = "Special / Para Games";
        } elseif ($filter_category == "3") {
            $game_type = "Demo Sports / Games";
        }

        $header = "Final and Official Results";
        if ($this->check_if_all_sub_categories_are_validated() == false) {
            $header = $game_type . " : Preliminary Results as of " . date('F d, Y h:i A');
        }

        $return = "<table id='table_summary' class='table border-primary'>
        <thead>
        <tr class='bg-primary text-white'>
            <th class='border-primary' colspan='13'>" . $header . "</th>
        </tr>
        <tr class='bg-info'>
            <th style='vertical-align:middle;text-align:center' rowspan='2'>Division</th>
            <th style='vertical-align:middle;text-align:center;background-color:#ffffff6b' colspan='4'>Elementary</th>
            <th style='vertical-align:middle;text-align:center' colspan='4'>Secondary</th>
            <th style='vertical-align:middle;text-align:center ;background-color:#ffffff6b' colspan='4'>Overall</th>
        </tr>
        <tr class='bg-info'>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700'>Gold</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>Silver</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32'>Bronze</th>
            <th style='vertical-align:middle;text-align:center;background-color:#ffffff6b'>Rank</th>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700'>Gold</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>Silver</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32'>Bronze</th>
            <th class='bg-info' style='vertical-align:middle;text-align:center'>Rank</th>
            <th style='vertical-align:middle;text-align:center;background-color:#FFD700'>Gold</th>
            <th style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>Silver</th>
            <th style='vertical-align:middle;text-align:center;background-color:#CD7F32'>Bronze</th>
            <th style='vertical-align:middle;text-align:center;background-color:#ffffff6b'>Rank</th>

        </tr>
        </thead>
        <tbody>";

        //overall
        $scores = []; // index 0 for gold, 1 for silver, 2 for bronze
        //$gold_scores=[];
        //return $filter_category;
        $gold_scores = TblScore::select(DB::raw('count(gold) as gold_count, gold'))
            ->join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_scores.sub_category_id')
            ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
            ->when($filter_category, function ($query, $filter_category) {
                return $query->where('tbl_events.event_type', $filter_category);
            })
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->groupBy('gold')
            ->get();
        //return $gold_scores->count();
        // for Silver
        $silver_scores = TblScoreSilver::select(DB::raw('count(silver) as silver_count, silver'))
            ->join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_silvers.sub_category_id')
            ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->when($filter_category, function ($query, $filter_category) {
                return $query->where('tbl_events.event_type', $filter_category);
            })
            ->groupBy('silver')
            ->get();
        //for Bronze
        $bronze_scores = TblScoreBronze::select(DB::raw('count(bronze) as bronze_count, bronze'))
            ->join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_bronzes.sub_category_id')
            ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->when($filter_category, function ($query, $filter_category) {
                return $query->where('tbl_events.event_type', $filter_category);
            })
            ->groupBy('bronze')
            ->get();

        foreach ($gold_scores as $gold) {
            $scores[0][$gold->gold] = $gold->gold_count; // gold will be the Team ID and gold_count for the count
        }
        //for silver
        foreach ($silver_scores as $silver) {
            $scores[1][$silver->silver] = $silver->silver_count;
        }
        //for bronze
        foreach ($bronze_scores as $bronze) {
            $scores[2][$bronze->bronze] = $bronze->bronze_count;
        }

        $team_scores = []; //array to hold the total scores for each team
        foreach ($teams as $team) {
            $gold_count = isset($scores[0][$team->id]) ? $scores[0][$team->id] : 0;
            $silver_count = isset($scores[1][$team->id]) ? $scores[1][$team->id] : 0;
            $bronze_count = isset($scores[2][$team->id]) ? $scores[2][$team->id] : 0;
            $team_scores[$team->id] = $gold_count . "." . $silver_count . "" . $bronze_count;
        }

        //SECONDARY
        $scores_secondary = []; // index 0 for gold, 1 for silver, 2 for bronze
        $gold_scores_secondary = TblScore::select(DB::raw('count(gold) as gold_count, gold'))
            ->join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_scores.sub_category_id')
            ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
            ->when($filter_category, function ($query, $filter_category) {
                return $query->where('tbl_events.event_type', $filter_category);
            })
            ->where(['tbl_event_categories.category_level' => 'Secondary'])
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->groupBy('gold')
            ->get();
        // $gold_scores_secondary->count();
        // for Silver
        $silver_scores_secondary = TblScoreSilver::select(DB::raw('count(silver) as silver_count, silver'))
            ->join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_silvers.sub_category_id')
            ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
            ->when($filter_category, function ($query, $filter_category) {
                return $query->where('tbl_events.event_type', $filter_category);
            })
            ->where(['tbl_event_categories.category_level' => 'Secondary'])
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->groupBy('silver')
            ->get();
        //for Bronze
        $bronze_scores_secondary = TblScoreBronze::select(DB::raw('count(bronze) as bronze_count, bronze'))
            ->join('tbl_event_sub_categories', 'tbl_event_sub_categories.id', '=', 'tbl_score_bronzes.sub_category_id')
            ->join('tbl_event_categories', 'tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id')
            ->join('tbl_events', 'tbl_events.id', '=', 'tbl_event_categories.event_id')
            ->when($filter_category, function ($query, $filter_category) {
                return $query->where('tbl_events.event_type', $filter_category);
            })
            ->where(['tbl_event_categories.category_level' => 'Secondary'])
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->groupBy('bronze')
            ->get();

        foreach ($gold_scores_secondary as $gold) {
            $scores_secondary[0][$gold->gold] = $gold->gold_count; // gold will be the Team ID and gold_count for the count
        }
        //for silver
        foreach ($silver_scores_secondary as $silver) {
            $scores_secondary[1][$silver->silver] = $silver->silver_count;
        }
        //for bronze
        foreach ($bronze_scores_secondary as $bronze) {
            $scores_secondary[2][$bronze->bronze] = $bronze->bronze_count;
        }

        $team_scores_secondary = []; //array to hold the total scores for each team
        $team_scores_elementary = []; //array to hold the total scores for each team
        foreach ($teams as $team) {
            $gold_count_secondary = isset($scores_secondary[0][$team->id]) ? $scores_secondary[0][$team->id] : 0;
            $silver_count_secondary = isset($scores_secondary[1][$team->id]) ? $scores_secondary[1][$team->id] : 0;
            $bronze_count_secondary = isset($scores_secondary[2][$team->id]) ? $scores_secondary[2][$team->id] : 0;
            $team_scores_secondary[$team->id] = $gold_count_secondary . "." . $silver_count_secondary . "" . $bronze_count_secondary;

            $gold_count = isset($scores[0][$team->id]) ? $scores[0][$team->id] : 0;
            $silver_count = isset($scores[1][$team->id]) ? $scores[1][$team->id] : 0;
            $bronze_count = isset($scores[2][$team->id]) ? $scores[2][$team->id] : 0;
            $team_scores_elementary[$team->id] = $gold_count -  $gold_count_secondary . "." . $silver_count - $silver_count_secondary . "" . $bronze_count - $bronze_count_secondary;
        }

        foreach ($teams as $team) {
            $return .= "<tr>
            <td style='vertical-align:middle' class='fw-bold bg-info'> " . $team->team_name . "</td>";

            //overall
            $gold_overall = (isset($scores[0][$team->id]) ? $scores[0][$team->id] : 0);
            $silver_overall = (isset($scores[1][$team->id]) ? $scores[1][$team->id] : 0);
            $bronze_overall = (isset($scores[2][$team->id]) ? $scores[2][$team->id] : 0);
            //secondary
            $gold_overall_secondary = (isset($scores_secondary[0][$team->id]) ? $scores_secondary[0][$team->id] : 0);
            $silver_overall_secondary = (isset($scores_secondary[1][$team->id]) ? $scores_secondary[1][$team->id] : 0);
            $bronze_overall_secondary = (isset($scores_secondary[2][$team->id]) ? $scores_secondary[2][$team->id] : 0);
            //elementary
            $gold_overall_elementary = $gold_overall - $gold_overall_secondary;
            $silver_overall_elementary = $silver_overall - $silver_overall_secondary;
            $bronze_overall_elementary = $bronze_overall - $bronze_overall_secondary;
            //Elementary
            $return .= " 
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#FFD700'>" . $gold_overall_elementary . "</td>
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#C0C0C0'>" . $silver_overall_elementary . "</td>
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#CD7F32'>" . $bronze_overall_elementary . "</td>
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#73e1f7'>" . $this->get_rank($team_scores_elementary, $team->id) . "</td>";
            //Secondary
            $return .= "
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#FFD700'>" . $gold_overall_secondary . "</td>
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#C0C0C0''>" . $silver_overall_secondary . "</td>
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#CD7F32'>" . $bronze_overall_secondary . "</td>
            <td class='fw-bold bg-info' style='vertical-align:middle;text-align:center'>" . $this->get_rank($team_scores_secondary, $team->id) . "</td>";
            //overall
            $return .= "
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#FFD700'>" . $gold_overall . "</td>
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#C0C0C0''>" . $silver_overall . "</td>
            <td class='fw-bold' style='vertical-align:middle;text-align:center;background-color:#CD7F32'>" . $bronze_overall . "</td>
            <td class='fw-bold' style='vertical-align:middle;text-align:center;;background-color:#73e1f7'>" . $this->get_rank($team_scores, $team->id) . "</td>";
            $return .= "</tr>";
        }
        $return .= "</tbody>
        </table>";
        return $return;
    }

    function get_rank($array, $team)
    {
        arsort($array); //sort the array in descending order of values
        $rank = 0; //initialize rank to 0
        $prev_value = null; //initialize previous value to null
        $prev_rank = null; //initialize previous rank to null
        foreach ($array as $key => $value) {
            if ($value !== $prev_value) { //if value is different from previous value, update rank
                $prev_value = $value;
                $prev_rank = ++$rank;
            }
            if ($key == $team) { //if team is found, return rank
                if ($prev_rank == 1) {
                    //add medal icon using BI Icon
                    return "<i class='bi bi-award-fill text-primary'> </i> 1";
                } // else if 2
                else if ($prev_rank == 2) {
                    return "<i class='bi bi-award-fill text-primary'> </i> 2";
                } // else if 3
                else if ($prev_rank == 3) {
                    return "<i class='bi bi-award-fill text-primary'> </i> 3";
                }
                return $prev_rank;
            }
        }
    }



    function print_event($event_id)
    {

        $event = TblEvent::find($event_id);
        $return = "
        <head>
            <meta charset='UTF-8'>
            <title>List of Winners</title>
            <style>
            @page {
                size: A4 portrait;
                margin-top: 2mm;
                margin-bottom: 2mm;
                margin-left: 6mm;
                margin-right: 6mm;
            }
            </style>
        </head>
        <center>
            <div style='width:8.27in;height:11.69in'>
            
            " . $this->generate_print_header();
        $return .= "<h4>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h4>";
        $return .= "<h2>GAME RESULTS</h2>";
        $return .= "<table style='width:100%;border-collapse:collapse;'>";
        //get the sub categories
        $categories = $event->eventCategories;
        foreach ($categories as $category) {
            $sub_categories = $category->eventSubCategories;
            foreach ($sub_categories as $sub_category) {
                //add a div that always page break in printing if there is not enough space
                //check if the tbl_event_sub_category validated_by field is not null

                $return .= "<div style='page-break-inside:avoid'>";
                $return .= $this->generate_winners_by_sub_category($sub_category);
                $return .= "</div>";
            }
        }


        $return .= "</table>" . $this->generate_signatory() . "
        <body>";


        $return .= "</center>";
        return $return;
    }

    function generate_signatory()
    {
        return "
        <br><br>
        <table style='width:100%;border-collapse:collapse; border:none'>
            <tr style='border:none !important'>
                <td style='width:50%;border:none'>Prepared by:<br><br>
                    <b style='text-decoration:underline'>" . env('SETTING_PREPARED_BY') . "</b>
                    " . env('SETTING_PREPARED_BY_POSITION') . "
                    " . env('SETTING_PREPARED_BY_ROLE') . "
                </td>
                <td style='width:50%;border:none'>Reviewed by:<br><br>
                    <b style='text-decoration:underline'>" . env('SETTING_REVIEWED_BY') . "</b>
                    " . env('SETTING_REVIEWED_BY_POSITION') . "
                    " . env('SETTING_REVIEWED_BY_ROLE') . "
                </td>
            </tr>
            <tr style='border:none !important'>
                <td style='width:50%;border:none !important'><br><br><br>Noted by:<br><br>
                    <b style='text-decoration:underline'>" . env('SETTING_NOTED_BY') . "</b>
                    " . env('SETTING_NOTED_BY_POSITION') . "
                    " . env('SETTING_NOTED_BY_ROLE') . "
                </td>
                <td style='border:none'></td>
            </tr>
        </table>";
    }


    function print_category($category_id)
    {
        $category = TblEventCategory::find($category_id);
        $return = "
        <head>
            <meta charset='UTF-8'>
            <title>List of Winners</title>
            <style>
            @page {
                size: A4 portrait;
                margin-top: 2mm;
                margin-bottom: 2mm;
                margin-left: 6mm;
                margin-right: 6mm;
            }
            </style>
        </head>
        <center>
            <div style='width:8.27in;height:11.69in'>
            
            " . $this->generate_print_header();
        $return .= "<h4>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h4>";
        $return .= "<h2>GAME RESULTS</h2>";
        $return .= "<table style='width:100%;border-collapse:collapse;'>";
        //get the sub categories
        $sub_categories = $category->eventSubCategories;
        foreach ($sub_categories as $sub_category) {
            //add a div that always page break in printing if there is not enough space
            //check if the tbl_event_sub_category validated_by field is not null

            $return .= "<div style='page-break-inside:avoid'>";
            $return .= $this->generate_winners_by_sub_category($sub_category);
            $return .= "</div>";
        }
        $return .= "</table>
        <br><br>
        " . $this->generate_signatory() . "
        <body>";


        $return .= "</center>";
        return $return;
    }

    function print_sub_category($sub_id)
    {
        $sub_category = TblEventSubCategory::find($sub_id);

        $return = "
        <head>
            <meta charset='UTF-8'>
            <title>List of Winners</title>
            <style>
            @page {
                size: A4 portrait;
                margin-top: 2mm;
                margin-bottom: 2mm;
                margin-left: 6mm;
                margin-right: 6mm;
            }
            </style>
        </head>
        <center>
            <div style='width:8.27in;height:11.69in'>
            
            " . $this->generate_print_header();
        $return .= "<h4>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h4>";
        $return .= "<h2>GAME RESULTS</h2>";
        $return .= "<table style='width:100%;border-collapse:collapse;'>";
        $return .= $this->generate_winners_by_sub_category($sub_category);
        $return .= "</table>
        <br><br>
        " . $this->generate_signatory() . "
        <body>";


        $return .= "</center>";
        return $return;
    }

    function generate_winners_by_sub_category($sub_category)
    {
        $return = "
        <tr>
            <td colspan='3' style='padding:6px;font-size:16px'><b>" . strtoupper($sub_category->category->event->event_name) . " - "  . strtoupper($sub_category->category->category_level . " " . $sub_category->category->category_sex . " - " . $sub_category->sub_category) . "</b></td>
        </tr>
        <tr style='background-color:#0dcaf0;margin:3px;border:1px solid black'>
            <th style='padding:6px;border:1px solid black'>MEDAL</th>
            <th style='padding:6px;border:1px solid black'>DIVISION</th>
            <th style='padding:6px;border:1px solid black'>ATHLETE</th>
            <th style='padding:6px;border:1px solid black'>COACH</th>
        </tr>";

        if ($sub_category->validated_by == null) {
            //just return a row with medal icons and stating No results in Division, Athlete, and Coach column
            $return .= "
                <tr>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:left'>
                    <img src='" . asset('images/gold.png') . "' style='width:50px;height:70px;vertical-align:middle'>
                    <b>GOLD</b>
                    </td>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>Waiting Result</td>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>Waiting Result</td>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>Waiting Result</td>
                </tr>
                <tr>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:left'>
                    <img src='" . asset('images/silver.png') . "' style='width:50px;height:70px;vertical-align:middle'>
                    <b>Silver</b>
                    </td>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>Waiting Result</td>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>Waiting Result</td>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>Waiting Result</td>
                </tr>
                <tr>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:left'>
                    <img src='" . asset('images/bronze.png') . "' style='width:50px;height:70px;vertical-align:middle'>
                    <b>Bronze</b>
                    </td>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>Waiting Result</td>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>Waiting Result</td>
                    <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>Waiting Result</td>
                </tr>
            ";
        } else {
            //gold
            $gold_winners = $sub_category->golds;
            if ($gold_winners->count() == 0) {
                $return .= "
            <tr>
            <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:left'>
            <img src='" . asset('images/gold.png') . "' style='width:50px;height:70px;vertical-align:middle'>
            <b>GOLD</b>
            </td>
            <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>No Qualified Winner</td>
            <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>No Qualified Winner</td>
            <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>No Qualified Winner</td>
            </tr>";
            }
            foreach ($gold_winners as $gold_winner) {
                $return .= "
            <tr style='margin:3px;border:1px solid black'>
                <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:left'>
                    <img src='" . asset('images/gold.png') . "' style='width:50px;height:70px;vertical-align:middle'>
                <b>GOLD</b>
                </td>
                <td style='padding:6px;vertical-align:middle;min-height:500px;border:1px solid black'><b>" . $gold_winner->team->team_name . "</b></td>";
                $athletes = $gold_winner->goldWinners;
                $athlete_list = "";
                foreach ($athletes as $athlete) {
                    //add in the athlete list if not the first add new line
                    if ($athlete_list != "") {
                        $athlete_list .= "<br>";
                    }
                    $athlete_list .= strtoupper($athlete->name);
                }
                $return .= "<td style='padding:6px;vertical-align:middle;border:1px solid black'><b>" . $athlete_list . "</b></td>";

                //now get the coaches
                $coaches = $gold_winner->goldCoaches;
                $coach_list = "";
                foreach ($coaches as $coach) {
                    //add in the coach list if not the first add new line
                    if ($coach_list != "") {
                        $coach_list .= "<br>";
                    }
                    $coach_list .= strtoupper($coach->coach_name);
                }
                $return .= "<td style='padding:6px;vertical-align:middle;border:1px solid black'><b>" . $coach_list . "</b></td>";

                $return .= "</tr>";
            }

            //silver
            $silver_winners = $sub_category->silvers;
            if ($silver_winners->count() == 0) {
                $return .= "
            <tr>
            <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:left'>
                 <img src='" . asset('images/silver.png') . "' style='width:50px;height:70px;vertical-align:middle'>
             <b>SILVER</b>
             </td>
             <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>No Qualified Winner</td>
             <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>No Qualified Winner</td>
             <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>No Qualified Winner</td>
             </tr>";
            }
            foreach ($silver_winners as $silver_winner) {
                $return .= "
             <tr style='margin:3px;border:1px solid black'>
                 <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:left'>
                 <img src='" . asset('images/silver.png') . "' style='width:50px;height:70px;vertical-align:middle'>
                 <b>SILVER</b>
                 </td>
                 <td style='padding:6px;vertical-align:middle;min-height:500px;border:1px solid black'><b>" . $silver_winner->team->team_name . "</b></td>";
                $athletes = $silver_winner->silverWinners;
                $athlete_list = "";
                foreach ($athletes as $athlete) {
                    //add in the athlete list if not the first add new line
                    if ($athlete_list != "") {
                        $athlete_list .= "<br>";
                    }
                    $athlete_list .= strtoupper($athlete->name);
                }
                $return .= "<td style='padding:6px;vertical-align:middle;border:1px solid black'><b>" . $athlete_list . "</b></td>";

                //now get the coaches
                $coaches = $silver_winner->silverCoaches;
                $coach_list = "";
                foreach ($coaches as $coach) {
                    //add in the coach list if not the first add new line
                    if ($coach_list != "") {
                        $coach_list .= "<br>";
                    }
                    $coach_list .= strtoupper($coach->coach_name);
                }
                $return .= "<td style='padding:6px;vertical-align:middle;border:1px solid black'><b>" . $coach_list . "</b></td>";

                $return .= "</tr>";
            }

            //bronze
            $bronze_winners = $sub_category->bronzes;
            //if no bronze winners
            if ($bronze_winners->count() == 0) {
                $return .= "
            <tr>
            <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:left'>
            <img src='" . asset('images/bronze.png') . "' style='width:50px;height:70px;vertical-align:middle'>
             <b>BRONZE</b>
             </td>
             <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>No Qualified Winner</td>
             <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>No Qualified Winner</td>
             <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:center'>No Qualified Winner</td>
             </tr>";
            }
            foreach ($bronze_winners as $bronze_winner) {
                $return .= "
             <tr style='margin:3px;border:1px solid black'>
                 <td style='padding:6px;vertical-align:middle;border:1px solid black;text-align:left'>
                 <img src='" . asset('images/bronze.png') . "' style='width:50px;height:70px;vertical-align:middle'>
                 <b>BRONZE</b>
                 </td>
                 <td style='padding:6px;vertical-align:middle;min-height:500px;border:1px solid black'><b>" . $bronze_winner->team->team_name . "</b></td>";
                $athletes = $bronze_winner->bronzeWinners;
                $athlete_list = "";
                foreach ($athletes as $athlete) {
                    //add in the athlete list if not the first add new line
                    if ($athlete_list != "") {
                        $athlete_list .= "<br>";
                    }
                    $athlete_list .= strtoupper($athlete->name);
                }
                $return .= "<td style='padding:6px;vertical-align:middle;border:1px solid black'><b>" . $athlete_list . "</b></td>";

                //now get the coaches
                $coaches = $bronze_winner->bronzeCoaches;
                $coach_list = "";
                foreach ($coaches as $coach) {
                    //add in the coach list if not the first add new line
                    if ($coach_list != "") {
                        $coach_list .= "<br>";
                    }
                    $coach_list .= strtoupper($coach->coach_name);
                }
                $return .= "<td style='padding:6px;vertical-align:middle;border:1px solid black'><b>" . $coach_list . "</b></td>";

                $return .= "</tr>";
            }
        }
        return $return;
    }

    function generate_print_header($orientation = 'portrait')
    {
        $return = "";
        //add an image and position at the center of the page
        // if orientation is portrait then use header.png else use header_landscape.png
        if ($orientation == 'portrait') {
            $return .= "
            <img style='width:90%' src='" . url('/images/header.png') . "' />
            ";
        } else {
            $return .= "
            <img style='width:90%' src='" . url('/images/header_landscape.png') . "' />
            ";
        }
        return $return;
    }


    function print_certificate($sub_id)
    {
        $sub_category = TblEventSubCategory::find($sub_id);
        $event_picture = asset('storage/event_picture/' . $sub_category->category->event->event_picture);
        //add only the $sub_category->sub_category if it is not the same with $sub_category->category->event->event_name
        $event_name = strtoupper($sub_category->category->event->event_name) == strtoupper($sub_category->sub_category) ?
            $sub_category->category->event->event_name . " - " . $sub_category->category->category_level . " - " . $sub_category->category->category_sex : $sub_category->category->event->event_name . " - " . $sub_category->category->category_level . " - " . $sub_category->category->category_sex . " - " . $sub_category->sub_category;
        //$event_name = $sub_category->category->event->event_name . " - " . $sub_category->category->category_level . " - " . $sub_category->category->category_sex . " - " . $sub_category->sub_category;

        $return = "
        <head>
            <meta charset='UTF-8'>
            <title>Athletes and Coaches Certificates</title>
            <style>
                @page {
                    size: A4 landsacpe;
                    margin-top: 0.1mm;
                    margin-bottom: 0.01mm;
                    margin-left: 20mm;
                    margin-right: 20mm;
                }
                .qr-code-wrapper {
                    float: right;
                }
            </style>
        </head><body>
        <center>
            ";



        //get the gold winners athletes
        $gold_winners = $sub_category->golds;
        foreach ($gold_winners as $gold_winner) {
            $athletes = $gold_winner->goldWinners;
            foreach ($athletes as $athlete) {
                //get certifcate number by getting current year - A - athletete - subcategory_id 
                $cert_number = date('Y') . "-A-" . $sub_id . "-"  . $athlete->id;
                $return .= $this->get_certificate_per_player('GOLD', $athlete->name, 'ATHLETE', $event_name, $event_picture, $cert_number);
            }
        }
        // get the gold coaches
        foreach ($gold_winners as $gold_winner) {
            $coaches = $gold_winner->goldCoaches;
            foreach ($coaches as $coach) {
                //get certificate number by getting current year - C - coach - subcategory_id
                $cert_number = date('Y') . "-C-" . $sub_id . "-" .  $coach->id;
                $return .= $this->get_certificate_per_player('GOLD', $coach->coach_name, 'COACH', $event_name, $event_picture, $cert_number);
            }
        }

        //get the silver winners athletes
        $silver_winners = $sub_category->silvers;
        foreach ($silver_winners as $silver_winner) {
            $athletes = $silver_winner->silverWinners;
            foreach ($athletes as $athlete) {
                //get certifcate number by getting current year - A - athletete - subcategory_id 
                $cert_number = date('Y') . "-A-" . $sub_id . "-"  . $athlete->id;
                $return .= $this->get_certificate_per_player('SILVER', $athlete->name, 'ATHLETE', $event_name, $event_picture, $cert_number);
            }
        }
        // get the silver coaches
        foreach ($silver_winners as $silver_winner) {
            $coaches = $silver_winner->silverCoaches;
            foreach ($coaches as $coach) {
                //get certificate number by getting current year - C - coach - subcategory_id
                $cert_number = date('Y') . "-C-" . $sub_id . "-" .  $coach->id;
                $return .= $this->get_certificate_per_player('SILVER', $coach->coach_name, 'COACH', $event_name, $event_picture, $cert_number);
            }
        }
        //get the bronze winners athletes
        $bronze_winners = $sub_category->bronzes;
        foreach ($bronze_winners as $bronze_winner) {
            $athletes = $bronze_winner->bronzeWinners;
            foreach ($athletes as $athlete) {
                //get certifcate number by getting current year - A - athletete - subcategory_id 
                $cert_number = date('Y') . "-A-" . $sub_id . "-"  . $athlete->id;
                $return .= $this->get_certificate_per_player('BRONZE', $athlete->name, 'ATHLETE', $event_name, $event_picture, $cert_number);
            }
        }
        // get the bronze coaches
        foreach ($bronze_winners as $bronze_winner) {
            $coaches = $bronze_winner->bronzeCoaches;
            foreach ($coaches as $coach) {
                //get certificate number by getting current year - C - coach - subcategory_id
                $cert_number = date('Y') . "-C-" . $sub_id . "-" .  $coach->id;
                $return .= $this->get_certificate_per_player('BRONZE', $coach->coach_name, 'COACH', $event_name, $event_picture, $cert_number);
            }
        }

        $return .= "</center></body>";
        return $return;
    }


    function get_certificate_per_player($medal, $name, $role, $event_name, $event_image, $cert_number)
    {
        $medal_image = "gold.png";
        if ($medal == "SILVER") {
            $medal_image = "silver.png";
        } else if ($medal == "BRONZE") {
            $medal_image = "bronze.png";
        }
        $return = "
        
        <div style='width:11.69in;height:8.27in'>";
        $return .= $this->generate_print_header('landscape');
        $return .= "<h3>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h3>";
        $return .= "<p style='font-size:20px; position: relative'>
                <img style='height:200px; position: absolute; top: -15px; left: 20%; transform: translateX(-50%);' src='" . url('images/' . $medal_image) . "'>
                <b style='font-size:35px; margin-top: 40px; display: block; text-align: center; position: relative; z-index: 1'>" . $medal . " MEDAL CERTIFICATE</b>
                <img style='height:200px; position: absolute; top: -15px; left: 83%; transform: translateX(-50%);' src='" . $event_image . "'>
                <br>is awarded to<br><br><br>
                <b style='font-size:40px;text-decoration:underline;text-underline-offset: 5px;'>" . strtoupper($name) . "</b><br><br><br>
                for having been declared as the <b>" . $medal . " MEDALIST " . $role . "</b> during the " . ucwords(env('SETTING_EVENT_NAME2')) . " 
                in the <br><b>" . strtoupper($event_name) . "</b><br> 
                " . env('SETTING_EVENT_HELD_ON') . "<br><br>
                Awarded this " . env('SETTING_EVENT_AWARDING_DAY') . "
                <br><br>
                <img  style='width:2in;margin-bottom:-30px' src='" . url('images/signatory.png') . "'><br>
                <b style='text-decoration:underline;text-underline-offset: 3px;'>" . env('SETTING_CERTIFICATE_SIGNATORY') . "</b>
                <br>" . env('SETTING_CERTIFICATE_SIGNATORY_POSITION') . "
            </p>";

        $return .= "<div class='qr-code-wrapper'>" . QrCode::size(100)->generate($cert_number);

        $return .= "<br>" . $cert_number . "</div>";
        $return .= "</div>";
        //add a div with page break after
        return $return;
    }


    function print_final()
    {
        //make html heading tags add css for table make it 1 px border black and collapse
        //force body size to A4
        $return = "<html><head><title>Finals</title>";
        $return .= "<style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            padding:5px
        }
        .bg-info{
            background-color: #73e1f7;
        }
        .bg-primary{
            background-color: #0d6efd;
            color:white;
        }


        body{
            width: 8.27in;
            height: 11.69in;
            margin: 0 auto;
        }

        </style>";
        $return .= "</head><body><center>";
        $teams = TblTeam::orderBy('team_name')->get();

        //REGULAR GAMES
        //overall
        $return .= $this->generate_print_header();
        $return .= "<br><br><h3>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h3>";
        $return .= "<br>";
        $return .= $this->get_overall($teams, '1');
        $return .= $this->generate_signatory();
        $return .= "<div style='page-break-after:always'></div>";
        //Elementary
        $return .= $this->generate_print_header();
        $return .= "<br><br><h3>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h3>";
        $return .= "<br>";
        $return .= $this->get_overall_elementary($teams, '1');
        $return .= $this->generate_signatory();
        $return .= "<div style='page-break-after:always'></div>";
        //SECONDARY
        $return .= $this->generate_print_header();
        $return .= "<br><br><h3>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h3>";
        $return .= "<br>";
        $return .= $this->get_overall_secondary($teams, '1');
        $return .= $this->generate_signatory();
        $return .= "<div style='page-break-after:always'></div>";

        //SPECIAL GAMES
        //overall
        $return .= $this->generate_print_header();
        $return .= "<br><br><h3>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h3>";
        $return .= "<br>";
        $return .= $this->get_overall($teams, '2');
        $return .= $this->generate_signatory();
        $return .= "<div style='page-break-after:always'></div>";
        //Elementary
        // $return .= $this->generate_print_header();
        // $return .= "<br><br><h3>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h3>";
        // $return .= "<br>";
        // $return .= $this->get_overall_elementary($teams, '2');
        // $return .= $this->generate_signatory();
        // $return .= "<div style='page-break-after:always'></div>";
        // //SECONDARY
        // $return .= $this->generate_print_header();
        // $return .= "<br><br><h3>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h3>";
        // $return .= "<br>";
        // $return .= $this->get_overall_secondary($teams, '2');
        // $return .= $this->generate_signatory();
        // $return .= "<div style='page-break-after:always'></div>";

        //DEMO GAMES
        //overall
        $return .= $this->generate_print_header();
        $return .= "<br><br><h3>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h3>";
        $return .= "<br>";
        $return .= $this->get_overall($teams, '3');
        $return .= $this->generate_signatory();
        $return .= "<div style='page-break-after:always'></div>";

        $return .= "</center></body>";
        return $return;
    }


    function print_team($team_id)
    {
        return "TEST";
    }

    function get_winners($team_id)
    {
        $return = "";
        $team = TblTeam::find($team_id);

        //get list of winners for the gold also get the coaches
        $gold_winners = TblScore::select('tbl_scores.*')
            ->join('tbl_event_sub_categories', function ($join) {
                $join->on('tbl_event_sub_categories.id', '=', 'tbl_scores.sub_category_id');
            })
            ->join('tbl_event_categories', function ($join) {
                $join->on('tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id');
            })
            ->join('tbl_events', function ($join) {
                $join->on('tbl_events.id', '=', 'tbl_event_categories.event_id');
            })
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->where('gold', $team_id)
            ->orderBy('tbl_events.event_name')
            ->orderBy('tbl_event_categories.category_level')
            ->orderBy('tbl_event_categories.category_sex')
            ->get();
        $return .= "<table style='width:100%;border-collapse:collapse'><tr style='background-color:gold'><th colspan='6'>" . $team->team_name . " - GOLD MEDALIST</th></tr>
        <tr style='background-color:'><th>Event</th><th>Category</th><th>Sub Category</th><th>Athlete</th><th>Coach</th><th>Medal Count</th>
        </tr>";

        foreach ($gold_winners as $gold_winner) {
            $return .= "<tr>";

            $return .= "<td style='vertical-align:middle'>" . strtoupper($gold_winner->subCategory->category->event->event_name) . "</td>";

            $return .= "<td style='vertical-align:middle'>" . strtoupper($gold_winner->subCategory->category->category_level . " - " . $gold_winner->subCategory->category->category_sex) . "</td>
                    <td style='vertical-align:middle'>" . strtoupper($gold_winner->subCategory->sub_category) . "</td>";
            //gold winners
            $return .= "<td style='vertical-align:middle'>";
            //$return .= $gold_winners_athletes = dd($gold_winner);

            //loop winners and add new line if more than 1 but not on the last one.
            $gold_winners_athletes = $gold_winner->goldWinners;
            $i = 0;
            foreach ($gold_winners_athletes as $gold_winners_athlete) {
                $i++;
                $return .= $gold_winners_athlete->name;
                if (count($gold_winners_athletes) > 1 && $i < count($gold_winners_athletes)) {
                    $return .= "<br>";
                }
            }

            $return .= "</td>";
            //gold coaches
            $return .= "<td style='vertical-align:middle'>";
            $gold_coaches = $gold_winner->goldCoaches;
            //loop coaches and add new line if more than 1 but not on the last one.
            $i = 0;
            foreach ($gold_coaches as $gold_coach) {
                $i++;
                $return .= $gold_coach->coach_name;
                if (count($gold_coaches) > 1 && $i < count($gold_coaches)) {
                    $return .= "<br>";
                }
            }
            $return .= "</td>";
            $return .= "<td>1 Gold</td>";
            $return .= "</tr>";
        }
        $return .= "<tr><th colspan='5'>Total Gold Medals</th><th>" . ($gold_winners->count() > 1 ? $gold_winners->count() . " Golds" : $gold_winners->count() . " Gold") .  "</th></tr>";
        $return .= "</table>";


        //get list of winners for the silver also get the coaches
        $silver_winners = TblScoreSilver::select('tbl_score_silvers.*')
            ->join('tbl_event_sub_categories', function ($join) {
                $join->on('tbl_event_sub_categories.id', '=', 'tbl_score_silvers.sub_category_id');
            })
            ->join('tbl_event_categories', function ($join) {
                $join->on('tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id');
            })
            ->join('tbl_events', function ($join) {
                $join->on('tbl_events.id', '=', 'tbl_event_categories.event_id');
            })
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->where('silver', $team_id)
            ->orderBy('tbl_events.event_name')
            ->orderBy('tbl_event_categories.category_level')
            ->orderBy('tbl_event_categories.category_sex')
            ->get();
        $return .= "<table style='width:100%;border-collapse:collapse'><tr style='background-color:silver'><th colspan='6'>" . $team->team_name . " - GOLD MEDALIST</th></tr>
        <tr style='background-color:'><th>Event</th><th>Category</th><th>Sub Category</th><th>Athlete</th><th>Coach</th><th>Medal Count</th>
        </tr>";

        foreach ($silver_winners as $silver_winner) {
            $return .= "<tr>";

            $return .= "<td style='vertical-align:middle'>" . strtoupper($silver_winner->subCategory->category->event->event_name) . "</td>";

            $return .= "<td style='vertical-align:middle'>" . strtoupper($silver_winner->subCategory->category->category_level . " - " . $silver_winner->subCategory->category->category_sex) . "</td>
                    <td style='vertical-align:middle'>" . strtoupper($silver_winner->subCategory->sub_category) . "</td>";
            //silver winners
            $return .= "<td style='vertical-align:middle'>";
            //$return .= $silver_winners_athletes = dd($silver_winner);

            //loop winners and add new line if more than 1 but not on the last one.
            $silver_winners_athletes = $silver_winner->silverWinners;
            $i = 0;
            foreach ($silver_winners_athletes as $silver_winners_athlete) {
                $i++;
                $return .= $silver_winners_athlete->name;
                if (count($silver_winners_athletes) > 1 && $i < count($silver_winners_athletes)) {
                    $return .= "<br>";
                }
            }

            $return .= "</td>";
            //silver coaches
            $return .= "<td style='vertical-align:middle'>";
            $silver_coaches = $silver_winner->silverCoaches;
            //loop coaches and add new line if more than 1 but not on the last one.
            $i = 0;
            foreach ($silver_coaches as $silver_coach) {
                $i++;
                $return .= $silver_coach->coach_name;
                if (count($silver_coaches) > 1 && $i < count($silver_coaches)) {
                    $return .= "<br>";
                }
            }
            $return .= "</td>";
            $return .= "<td>1 Silver</td>";
            $return .= "</tr>";
        }
        $return .= "<tr><th colspan='5'>Total Silver Medals</th><th>" . ($silver_winners->count() > 1 ? $silver_winners->count() . " silvers" : $silver_winners->count() . " Gold") .  "</th></tr>";
        $return .= "</table>";


        //get list of winners for the bronze also get the coaches
        $bronze_winners = TblScoreBronze::select('tbl_score_bronzes.*')
            ->join('tbl_event_sub_categories', function ($join) {
                $join->on('tbl_event_sub_categories.id', '=', 'tbl_score_bronzes.sub_category_id');
            })
            ->join('tbl_event_categories', function ($join) {
                $join->on('tbl_event_categories.id', '=', 'tbl_event_sub_categories.category_id');
            })
            ->join('tbl_events', function ($join) {
                $join->on('tbl_events.id', '=', 'tbl_event_categories.event_id');
            })
            ->whereNotNull('tbl_event_sub_categories.validated_by')
            ->where('bronze', $team_id)
            ->orderBy('tbl_events.event_name')
            ->orderBy('tbl_event_categories.category_level')
            ->orderBy('tbl_event_categories.category_sex')
            ->get();
        $return .= "<table style='width:100%;border-collapse:collapse'><tr style='background-color:#CD7F32'><th colspan='6'>" . $team->team_name . " - GOLD MEDALIST</th></tr>
    <tr style='background-color:'><th>Event</th><th>Category</th><th>Sub Category</th><th>Athlete</th><th>Coach</th><th>Medal Count</th>
    </tr>";

        foreach ($bronze_winners as $bronze_winner) {
            $return .= "<tr>";

            $return .= "<td style='vertical-align:middle'>" . strtoupper($bronze_winner->subCategory->category->event->event_name) . "</td>";

            $return .= "<td style='vertical-align:middle'>" . strtoupper($bronze_winner->subCategory->category->category_level . " - " . $bronze_winner->subCategory->category->category_sex) . "</td>
                <td style='vertical-align:middle'>" . strtoupper($bronze_winner->subCategory->sub_category) . "</td>";
            //bronze winners
            $return .= "<td style='vertical-align:middle'>";
            //$return .= $bronze_winners_athletes = dd($bronze_winner);

            //loop winners and add new line if more than 1 but not on the last one.
            $bronze_winners_athletes = $bronze_winner->bronzeWinners;
            $i = 0;
            foreach ($bronze_winners_athletes as $bronze_winners_athlete) {
                $i++;
                $return .= $bronze_winners_athlete->name;
                if (count($bronze_winners_athletes) > 1 && $i < count($bronze_winners_athletes)) {
                    $return .= "<br>";
                }
            }

            $return .= "</td>";
            //bronze coaches
            $return .= "<td style='vertical-align:middle'>";
            $bronze_coaches = $bronze_winner->bronzeCoaches;
            //loop coaches and add new line if more than 1 but not on the last one.
            $i = 0;
            foreach ($bronze_coaches as $bronze_coach) {
                $i++;
                $return .= $bronze_coach->coach_name;
                if (count($bronze_coaches) > 1 && $i < count($bronze_coaches)) {
                    $return .= "<br>";
                }
            }
            $return .= "</td>";
            $return .= "<td>1 Bronze</td>";
            $return .= "</tr>";
        }
        $return .= "<tr><th colspan='5'>Total Bronze Medals</th><th>" . ($bronze_winners->count() > 1 ? $bronze_winners->count() . " Bronzes" : $bronze_winners->count() . " Bronze") .  "</th></tr>";
        $return .= "</table>";



        return $return;
    }

    function winners_per_team($team_id)
    {
        $team = TblTeam::find($team_id);
        $winners = $this->get_winners($team_id);
        return view('winners', compact('team', 'winners'));
    }

    function print_winners($team_id)
    {
        $team = TblTeam::find($team_id);
        $winners = $this->get_winners($team_id);

        $return = "";
        //make html in a4 size paper
        //center the body
        $return .= "<html><head><title>" . $team->team_name . " Winners</title>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
            }
            th, td {
                padding: 5px;
                text-align: left;
            }

        </style>
        </head>
        <body style='width:8.27in;height:11.69in;margin: 0 auto;'>";
        $return .= $this->generate_print_header();
        $return .= "<center>
                <h4>" . env('SETTING_EVENT_NAME') . "<br>" . env('SETTING_EVENT_DATE') . "</h4>";
        $return .= "<h2>" . $team->team_name  . " - MEDALISTS</h2></center>";

        $return .= $winners;
        $return .= $this->generate_signatory();
        $return .= "</body></html>";
        return $return;
    }
}

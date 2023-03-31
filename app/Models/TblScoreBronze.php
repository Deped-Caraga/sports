<?php

namespace App\Models;

use App\Models\Teams\TblTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblScoreBronze extends Model
{
    use HasFactory;
    public $timestamps = false;

    function team()
    {
        return $this->belongsTo(TblTeam::class, 'bronze', 'id');
    }

    function bronzeWinners()
    {
        return $this->hasMany(TblBronzeWinner::class, 'score_bronze_id', 'id');
    }

    function bronzeCoaches()
    {
        return $this->hasMany(TblCoachBronze::class, 'score_bronze_id', 'id');
    }

    function encodedBy()
    {
        return $this->belongsTo(User::class, 'encoded_by', 'id');
    }

    function subCategory()
    {
        return $this->belongsTo(TblEventSubCategory::class, 'sub_category_id', 'id');
    }
}

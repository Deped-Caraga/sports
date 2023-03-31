<?php

namespace App\Models;

use App\Models\Teams\TblTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblScore extends Model
{
    use HasFactory;
    public $timestamps = false;

    function team()
    {
        return $this->belongsTo(TblTeam::class, 'gold', 'id');
    }

    function goldWinners()
    {
        return $this->hasMany(TblGoldWinner::class, 'score_gold_id', 'id');
    }
    function goldCoaches()
    {
        return $this->hasMany(TblCoachGold::class, 'score_gold_id', 'id');
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

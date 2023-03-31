<?php

namespace App\Models;

use App\Models\Teams\TblTeam;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblScoreSilver extends Model
{
    use HasFactory;
    public $timestamps = false;

    function team()
    {
        return $this->belongsTo(TblTeam::class, 'silver', 'id');
    }

    function silverWinners()
    {
        return $this->hasMany(TblSilverWinner::class, 'score_silver_id', 'id');
    }
    function silverCoaches()
    {
        return $this->hasMany(TblCoachSilver::class, 'score_silver_id', 'id');
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

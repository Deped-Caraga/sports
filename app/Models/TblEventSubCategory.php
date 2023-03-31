<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblEventSubCategory extends Model
{
    use HasFactory;
    public $timestamps = false;

    function golds()
    {
        return $this->hasMany(TblScore::class, 'sub_category_id', 'id');
    }

    function silvers()
    {
        return $this->hasMany(TblScoreSilver::class, 'sub_category_id', 'id');
    }

    function bronzes()
    {
        return $this->hasMany(TblScoreBronze::class, 'sub_category_id', 'id');
    }

    function validatedBy()
    {
        return $this->belongsTo(User::class, 'validated_by', 'id');
    }

    function category()
    {
        return $this->belongsTo(TblEventCategory::class, 'category_id', 'id');
    }
}

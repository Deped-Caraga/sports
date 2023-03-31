<?php

namespace App\Models;

use App\Models\Events\TblEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblEventCategory extends Model
{
    use HasFactory;
    public $timestamps = false;

    function eventSubCategories()
    {
        return $this->hasMany(TblEventSubCategory::class, 'category_id', 'id')->orderBy('sub_category');
    }

    function event()
    {
        return $this->belongsTo(TblEvent::class, 'event_id', 'id');
    }
}

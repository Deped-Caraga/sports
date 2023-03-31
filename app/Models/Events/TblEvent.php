<?php

namespace App\Models\Events;

use App\Models\TblEventCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblEvent extends Model
{
    use HasFactory;

    public $timestamps = false;

    function eventCategories()
    {
        return $this->hasMany(TblEventCategory::class, 'event_id')->orderBy('category_level')->orderBy('category_sex');
    }
}

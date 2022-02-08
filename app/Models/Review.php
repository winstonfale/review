<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $guarded = ['id'];


    public $appends = ['created_time'];


    public function getCreatedTimeAttribute() {
        return Carbon::parse($this->created_at)->diffForHumans();
    }
}

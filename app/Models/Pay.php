<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pay extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getDateAttribute($date)
    {
        return date("d-m-Y", strtotime($date));
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = date("Y-m-d", strtotime($date));
    }
}

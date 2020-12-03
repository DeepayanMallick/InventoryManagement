<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getCreatedAtAttribute($created_at)
    {
        return date("d-m-Y h:i A", strtotime($created_at));
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }
}

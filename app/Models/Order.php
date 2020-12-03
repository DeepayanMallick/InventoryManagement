<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getCreatedAtAttribute($created_at)
    {
        return date("d-m-Y h:i A", strtotime($created_at));
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function order_products()
    {
        return $this->hasMany('App\Models\OrderProduct');
    }
}
